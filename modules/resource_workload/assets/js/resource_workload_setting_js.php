<script>
(function($) {
"use strict";
<?php if($group == "customize_standard_workload"){ ?>
  var hotElement = document.querySelector('#staff_shiftings');
  var hotElementContainer = hotElement.parentNode;
  var hotSettings = { 
    data: <?php echo json_encode($standard_workload); ?>,
    columns: [
      {
        data: 'id',
        type: 'text'
      },
      {
        data: 'staffid',
        renderer: customDropdownRenderer,
        editor: "chosen",
        width: 150,
        chosenOptions: {
            data: <?php echo json_encode($staffs); ?>
        }
      },
      {
        data: 'monday',
        type: 'numeric'
      },
      {
        data: 'tuesday',
        type: 'numeric'
      },
      {
        data: 'wednesday',
        type: 'numeric'
      },
      {
        data: 'thursday',
        type: 'numeric'
      },
      {
        data: 'friday',
        type: 'numeric'
      },
      {
        data: 'saturday',
        type: 'numeric'
      },
      {
        data: 'sunday',
        type: 'numeric'
      }
    ],
    licenseKey: 'non-commercial-and-evaluation',
    stretchH: 'all',
    autoWrapRow: true,
    headerTooltips: true,
    rowHeaders: true,
    width: '100%',
    rowHeights: 25,
    rowHeaders: true,
    colHeaders: [
      '',
      '<?php echo _l('name'); ?>',
      '<?php echo _l('wd_monday'); ?>',
      '<?php echo _l('wd_tuesday'); ?>',
      '<?php echo _l('wd_wednesday'); ?>',
      '<?php echo _l('wd_thursday'); ?>',
      '<?php echo _l('wd_friday'); ?>',
      '<?php echo _l('wd_saturday'); ?>',
      '<?php echo _l('wd_sunday'); ?>'
    ],
     columnSorting: {
      indicator: true
    },
    dropdownMenu: true,
    mergeCells: true,
    contextMenu: true,
    multiColumnSorting: {
      indicator: true
    },  
    hiddenColumns: {
      columns: [0],
      indicators: true
    },
    filters: true,
  };
  var hot = new Handsontable(hotElement, hotSettings);

  $('.staff-shifting-form-submiter').on('click', function() {
    $('input[name="staff_shifting_data"]').val(JSON.stringify(hot.getData()));
  });

<?php } ?>
    console.log($('input[id="wd_monday"]:checked').length);

  count_capacity(); 
  if($('input[id="wd_monday"]:checked').length){
    console.log('b');
  }
  if($('input[id="wd_sunday"]:checked').length){
    console.log('c');
  }

  $('#standard_workload').change(function() {
    count_capacity();
  });
  $('[name="standard_workload"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_monday"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_tuesday"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_thursday"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_wednesday"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_friday"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_saturday"]').change(function() {
    count_capacity();
  });
  $('input[id="wd_sunday"]').change(function() {
    count_capacity();
  });
})(jQuery);

function count_capacity(){
    "use strict";
  var count = 0;

  if($('input[id="wd_monday"]:checked').length){
    count++;
  }
  if($('input[id="wd_tuesday"]:checked').length){
    count++;
  }
  if($('input[id="wd_thursday"]:checked').length){
    count++;
  }
  if($('input[id="wd_wednesday"]:checked').length){
    count++;
  }
  if($('input[id="wd_friday"]:checked').length){
    count++;
  }
  if($('input[id="wd_saturday"]:checked').length){
    count++;
  }
  if($('input[id="wd_sunday"]:checked').length){
    count++;
  }

  $('#capacity').html($('#standard_workload').val()*count);
}

function new_day_off(){
    "use strict";
    $('#additional').html('');
    $('#add_update_dayoff input[name="date"]').val('');
    $('#add_update_dayoff select[name="department[]"]').val('').change();
    $('#add_update_dayoff input[name="reason"]').val('');
    $('#add_update_dayoff').modal('show');
    $('.add-title').removeClass('hide');
    $('.edit-title').addClass('hide');
}
function edit_day_off(invoker,id){
    "use strict";
    $('#additional').append(hidden_input('id',id));
    $('#add_update_dayoff input[name="date"]').val($(invoker).data('date'));
    var departments = $(invoker).data('department')+'';
    var departmentsArray = [];
    if(departments.indexOf(",")){
        departmentsArray = departments.split(',');
    }else{
        departmentsArray = [departments];
    }
    $('#add_update_dayoff select[name="department[]"]').val(departmentsArray).change();
    $('#add_update_dayoff input[name="reason"]').val($(invoker).data('reason'));
    $('#add_update_dayoff').modal('show');
    $('.add-title').addClass('hide');
    $('.edit-title').removeClass('hide');
}

function new_standard_workload(){
    "use strict";
    $('#add_standard_workload input[name="standard_workload"]').val('');
    $('#add_standard_workload select[name="staffs[]"]').val('').change();
    $('#add_standard_workload').modal('show');
}


function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
  var selectedId;
  var optionsList = cellProperties.chosenOptions.data;

  if(typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
      Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
      return td;
  }

  var values = (value + "").split("|");
  value = [];
  for (var index = 0; index < optionsList.length; index++) {

      if (values.indexOf(optionsList[index].id + "") > -1) {
          selectedId = optionsList[index].id;
          value.push(optionsList[index].label);
      }
  }
  value = value.join(", ");

  Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
  return td;
}
</script>