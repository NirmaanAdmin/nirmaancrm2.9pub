<script>
var data_check = {};
var data_color = {};
var workload,
tasks,
data_workload,
columns,
nestedheaders,
data_tooltip,
data_overload,
data_timesheets,
data_capacity_billable,
data_capacity_unbillable,
capacityBillable,
capacityUnbillable,
gantt;

(function($) {
"use strict";
  // Init datepickers
  init_datepicker();
  <?php if($type == 'workload'){ ?>
  columns = <?php echo html_entity_decode(json_encode($columns)); ?>;
  data_workload = <?php echo html_entity_decode(json_encode($data_workload['data'])); ?>;
  nestedheaders = <?php echo html_entity_decode(json_encode($nestedheaders)); ?>;
  data_tooltip = <?php echo html_entity_decode(json_encode($data_workload['data_tooltip'])); ?>;
  data_overload = <?php echo html_entity_decode(json_encode($data_workload['data_overload'])); ?>;
  data_timesheets = <?php echo html_entity_decode(json_encode($data_workload['data_timesheets'])); ?>;
  var workloadElement = document.querySelector('#workload');
  var workloadSettings = {
    data: <?php echo html_entity_decode(json_encode($data_workload['data'])); ?>,
    columns: <?php echo html_entity_decode(json_encode($columns)); ?>,
    stretchH: 'all',
    autoWrapRow: true,
    rowHeaders: true,
    nestedHeaders: <?php echo html_entity_decode(json_encode($nestedheaders)); ?>,
      columnSorting: {
      indicator: true
    },
    licenseKey: 'non-commercial-and-evaluation',
    autoColumnSize: true,
    width: '100%',
    height: 400,
    dropdownMenu: true,
    mergeCells: true,
    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    multiColumnSorting: {
      indicator: true
    },
     hiddenColumns: {
      columns: [1],
      indicators: true
    },
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    comments: true,
    cell: <?php echo html_entity_decode(json_encode($data_workload['data_tooltip'])); ?>,
    cells: function(row, col, prop) {
      var cellProperties = {};
      cellProperties.renderer = myRenderer;
      return cellProperties;
    }
  };

  workload = new Handsontable(workloadElement, workloadSettings);
  <?php } ?>
  <?php if($type == 'chart'){ ?>
  Highcharts.chart('container_task', {
    chart: {
      type: 'pie',
      options3d: {
        enabled: true,
        alpha: 45
      }
    },
    title: {
      text: '<?php echo _l('statistics_by_estimate_hours'); ?>'
    },
    plotOptions: {
      pie: {
        innerSize: 100,
        depth: 45
      }
    },
    credits: {
        enabled: false
    },
    series: [{
        innerSize: '20%',
        name: '<?php echo _l('total_hours'); ?>',
        data: <?php echo html_entity_decode($estimate_stats); ?>
      }]
  });


  Highcharts.chart('container_time', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },

    title: {
        text: '<?php echo _l('statistics_by_spent_hours'); ?>'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        innerSize: '20%',
        name: '<?php echo _l('total_hours'); ?>',
        data: <?php echo html_entity_decode($spent_stats); ?>
      }]
  });

  Highcharts.chart('container_priority', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<?php echo _l('statistics_by_departments'); ?>'
    },
    xAxis: {
        categories: <?php echo html_entity_decode($column_department); ?>
    },
    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: '<?php echo _l('total_hours'); ?>'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.x + '</b><br/>' +
                this.series.name + ': ' + this.y + '<br/>' +
                'Total: ' + this.point.stackTotal;
        }
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        column: {
            stacking: 'normal'
        }
    },
    series: <?php echo html_entity_decode($department_stats); ?>
  });
  <?php } ?>
  <?php if($type == 'timeline'){ ?>
  tasks = <?php echo html_entity_decode(json_encode($data_timeline)); ?>;

  
  gantt = new Gantt("#timeline", tasks, {
      custom_popup_html: function(task) {
        // the task object will contain the updated
        // dates and progress value

        var total_time = 0;
        if(task.total_time != undefined){
          total_time = '<p class="details_title"> <?php echo _l('total_hours'); ?>: '+task.total_time.toFixed(2)+'</p>';
        }else{
          total_time = ''
        }
        var estimate_hour = 0;
        if(task.estimate_hour != undefined){
          estimate_hour = '<p class="details_title"> <?php echo _l('estimated_hour'); ?>: '+task.estimate_hour.toFixed(2)+'</p>';
        }else{
          estimate_hour = ''
        }
        return `
        <div class="details-container">
          <h5 class="details_title">  ${task.name}</h5>
          <hr>
          ${total_time}
          ${estimate_hour}
          <p class="details_title"> <?php echo _l('from_date'); ?>: ${task.start}</p>
          <p class="details_title"> <?php echo _l('to_date'); ?>: ${task.end}</p>
        </div>
        `;
      },
      on_date_change: function(task, start, end) {
        if($.isNumeric(task.id)){
          var start_date = start.getFullYear()+'-'+(start.getMonth() + 1)+'-'+start.getDate();
          var end_date = end.getFullYear()+'-'+(end.getMonth() + 1)+'-'+end.getDate();
          task_date_change(task.id, start_date, end_date);
        }
      },
      on_click: function (task) {
        if($.isNumeric(task.id)){
          init_task_modal(task.id);
        }
      },
  });

  $('body').on('change', '.task-single-inline-field', function() {
    var data = {};
    data.department = $('select[name="department"]').val();
    data.role = $('select[name="role"]').val();
    data.project = $('select[name="project"]').val();
    data.staff = $('select[name="staff"]').val();
    data.from_date = $('input[name="from_date"]').val();
    data.to_date = $('input[name="to_date"]').val();
    $.post(admin_url + 'resource_workload/get_data_timeline', data).done(function(response) {
      response = JSON.parse(response);
      tasks = response.data_timeline;
      gantt.refresh(tasks);
    });
  });

  $('body').on('click', '#task-form button[type="submit"]', function() {
    var data = {};
    data.department = $('select[name="department"]').val();
    data.role = $('select[name="role"]').val();
    data.project = $('select[name="project"]').val();
    data.staff = $('select[name="staff"]').val();
    data.from_date = $('input[name="from_date"]').val();
    data.to_date = $('input[name="to_date"]').val();
    setTimeout(
      function()
      {
        $.post(admin_url + 'resource_workload/get_data_timeline', data).done(function(response) {
          response = JSON.parse(response);
          tasks = response.data_timeline;
          gantt.refresh(tasks);
        });
      }, 100);
  });

  <?php } ?>
  <?php if($type == 'kanban'){ ?>
    workload_kanban();
  <?php } ?>
  <?php if($type == 'capacity'){ ?>
    data_capacity_billable = <?php echo html_entity_decode(json_encode($data_capacity['billable'])); ?>;
    var capacityBillableElement = document.querySelector('#capacity_billable');
    var capacityBillableSettings = {
      data: data_capacity_billable,
      columns: [
      {
        data: 'project',
        type: 'text'
      },
      {
        data: 'total',
        type: 'text'
      },
    ],
    licenseKey: 'non-commercial-and-evaluation',
      stretchH: 'all',
      autoWrapRow: true,
      rowHeights: 25,
       defaultRowHeight: 100,
      rowHeaders: true,
      colHeaders: [
        '<?php echo _l('project'); ?>',
        '<?php echo _l('total'); ?>',
      ],
        columnSorting: {
        indicator: true
      },
      autoColumnSize: {
        samplingRatio: 23
      },
      dropdownMenu: true,
      mergeCells: true,
      contextMenu: true,
      manualRowMove: true,
      manualColumnMove: true,
      multiColumnSorting: {
        indicator: true
      },
      filters: true,
      manualRowResize: true,
      manualColumnResize: true
    };

    capacityBillable = new Handsontable(capacityBillableElement, capacityBillableSettings);

    data_capacity_unbillable = <?php echo html_entity_decode(json_encode($data_capacity['unbillable'])); ?>;
    var capacityUnbillableElement = document.querySelector('#capacity_unbillable');
    var capacityUnbillableSettings = {
      data: data_capacity_unbillable,
      columns: [
      {
        data: 'project',
        type: 'text'
      },
      {
        data: 'total',
        type: 'text'
      },
    ],
    licenseKey: 'non-commercial-and-evaluation',
      stretchH: 'all',
      autoWrapRow: true,
      rowHeights: 25,
       defaultRowHeight: 100,
      rowHeaders: true,
      colHeaders: [
        '<?php echo _l('project'); ?>',
        '<?php echo _l('total'); ?>',
      ],
        columnSorting: {
        indicator: true
      },
      autoColumnSize: {
        samplingRatio: 23
      },
      dropdownMenu: true,
      mergeCells: true,
      contextMenu: true,
      manualRowMove: true,
      manualColumnMove: true,
      multiColumnSorting: {
        indicator: true
      },
      filters: true,
      manualRowResize: true,
      manualColumnResize: true
    };

    capacityUnbillable = new Handsontable(capacityUnbillableElement, capacityUnbillableSettings);
  <?php } ?>
})(jQuery);

function get_data_workload(project_id,id) {
  "use strict";
  var data = {};
  data.department = $('select[name="department"]').val();
  data.role = $('select[name="role"]').val();
  data.project = $('select[name="project"]').val();
  data.staff = $('select[name="staff"]').val();
  data.from_date = $('input[name="from_date"]').val();
  data.to_date = $('input[name="to_date"]').val();
  <?php if($type == 'workload'){ ?>
    $.post(admin_url + 'resource_workload/get_data_workload', data).done(function(response) {
      response = JSON.parse(response);
      data_workload = response.data_workload;
      data_overload = response.data_overload;
      data_timesheets = response.data_timesheets;
      columns = response.columns;
      nestedheaders = response.nestedheaders;
      data_tooltip = response.data_tooltip;
      $('.total_capacity').html(response.data_total.capacity.toFixed(2));
      $('.total_estimated_time').html(response.data_total.estimate.toFixed(2));
      $('.total_spent_time').html(response.data_total.spent_time.toFixed(2));
      $('.total_available_cap').html((response.data_total.capacity - response.data_total.estimate).toFixed(2));

      workload.updateSettings({
        data: data_workload,
        columns: columns,
        nestedHeaders: nestedheaders,
        cell: data_tooltip,
        })

    });
  <?php } ?>
  <?php if($type == 'chart'){ ?>
      init_chart();
  <?php } ?>
  <?php if($type == 'timeline'){ ?>
    $.post(admin_url + 'resource_workload/get_data_timeline', data).done(function(response) {
      response = JSON.parse(response);
      tasks = response.data_timeline;
      gantt.refresh(tasks);
    });
  <?php } ?>
  <?php if($type == 'kanban'){ ?>
    workload_kanban();
  <?php } ?>
  <?php if($type == 'capacity'){ ?>
    $.post(admin_url + 'resource_workload/get_data_capacity', data).done(function(response) {
      response = JSON.parse(response);
      capacityBillable.updateSettings({
        data: response.billable,
        });

      capacityUnbillable.updateSettings({
        data: response.unbillable,
        });

      $('.total_capacity').html("<?php echo _l('total_capacity').': ' ?>" + response.total.total_capacity);
      $('.total_billable').html(response.total.billable);
      $('.total_unbillable').html(response.total.unbillable);
    });
  <?php } ?>
};

function myRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
  Handsontable.renderers.TextRenderer.apply(this, arguments);
  var basework = <?php echo html_entity_decode(get_option('standard_workload')); ?>;
  if (data_overload[row][prop] == 1) {
    td.style.color = 'red';
  }else{
    td.style.color = 'black';
  }
  if (data_timesheets[row][prop] == 1) {
    instance.setCellMeta(row, col, 'className', 'gray-bg')
  }
}

function yellowRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
  Handsontable.renderers.TextRenderer.apply(this, arguments);
  td.style.backgroundColor = 'yellow';
}

function task_date_change(task_id, start_date, end_date){
  "use strict";
  var data = {};
  data.task_id = task_id;
  data.start_date = start_date;
  data.end_date = end_date;

  $.post(admin_url + 'resource_workload/task_date_change', data).done(function(response) {
    
  });
}

function workload_kanban_update(ui, object) {
  "use strict";
  if (object === ui.item.parent()[0]) {
      var data = {};
      data.staff_id = $(ui.item.parent()[0]).parents('.workload-column').data('col-staff-id');
      data.task_id = $(ui.item).data('task-id');

      check_kanban_empty_col('[data-task-id]');

      setTimeout(function() {
          $.post(admin_url + 'resource_workload/update_task_assigned', data)
      }, 50);
  }
}

function workload_kanban() {
  "use strict";
  init_workload_kanban('resource_workload/workload_kanban', workload_kanban_update, '.staff-workload-kanban', 445, 360, after_workload_kanban);
}

function after_workload_kanban() {
  "use strict";
  for (var i = -10; i < $('.task-phase').not('.color-not-auto-adjusted').length / 2; i++) {
      var r = 120;
      var g = 169;
      var b = 56;
      $('.task-phase:eq(' + (i + 10) + ')').not('.color-not-auto-adjusted').css('background', color(r - (i * 13), g - (i * 13), b - (i * 13))).css('border', '1px solid ' + color(r - (i * 12), g - (i * 12), b - (i * 12)));
  };
}

// General function to init kan ban based on settings
function init_workload_kanban(url, callbackUpdate, connect_with, column_px, container_px, callback_after_load) {
  "use strict";
    if ($('#kan-ban').length === 0) { return; }
    var parameters = [];
    var _kanban_param_val;

    $.each($('#kanban-params input'), function() {
        if ($(this).attr('type') == 'checkbox') {
            _kanban_param_val = $(this).prop('checked') === true ? $(this).val() : '';
        } else {
            _kanban_param_val = $(this).val();
        }
        if (_kanban_param_val !== '') {
            parameters[$(this).attr('name')] = _kanban_param_val;
        }
    });


    $.each($('#kanban-params select'), function() {
        _kanban_param_val = $(this).val();

        if (_kanban_param_val !== '') {
            parameters[$(this).attr('name')] = _kanban_param_val;
        }
    });

    var search = $('input[name="search"]').val();
    if (typeof(search) != 'undefined' && search !== '') { parameters['search'] = search; }

    var sort_type = $('input[name="sort_type"]');
    var sort = $('input[name="sort"]').val();
    if (sort_type.length != 0 && sort_type.val() !== '') {
        parameters['sort_by'] = sort_type.val();
        parameters['sort'] = sort;
    }

    parameters['kanban'] = true;
    url = admin_url + url;
    url = buildUrl(url, parameters);
    delay(function() {
        $("body").append('<div class="dt-loader"></div>');
        $('#kan-ban').load(url, function() {

            fix_kanban_height(column_px, container_px);
            var scrollingSensitivity = 20,
                scrollingSpeed = 60;

            if (typeof(callback_after_load) != 'undefined') { callback_after_load(); }

            $(".status").sortable({
                connectWith: connect_with,
                helper: 'clone',
                appendTo: '#kan-ban',
                placeholder: "ui-state-highlight-card",
                revert: 'invalid',
                scrollingSensitivity: 50,
                scrollingSpeed: 70,
                sort: function(event, uiHash) {
                    var scrollContainer = uiHash.placeholder[0].parentNode;
                    // Get the scrolling parent container
                    scrollContainer = $(scrollContainer).parents('.kan-ban-content-wrapper')[0];
                    var overflowOffset = $(scrollContainer).offset();
                    if ((overflowOffset.top + scrollContainer.offsetHeight) - event.pageY < scrollingSensitivity) {
                        scrollContainer.scrollTop = scrollContainer.scrollTop + scrollingSpeed;
                    } else if (event.pageY - overflowOffset.top < scrollingSensitivity) {
                        scrollContainer.scrollTop = scrollContainer.scrollTop - scrollingSpeed;
                    }
                    if ((overflowOffset.left + scrollContainer.offsetWidth) - event.pageX < scrollingSensitivity) {
                        scrollContainer.scrollLeft = scrollContainer.scrollLeft + scrollingSpeed;
                    } else if (event.pageX - overflowOffset.left < scrollingSensitivity) {
                        scrollContainer.scrollLeft = scrollContainer.scrollLeft - scrollingSpeed;

                    }
                },
                change: function() {
                    var list = $(this).closest('ul');
                    var KanbanLoadMore = $(list).find('.kanban-load-more');
                    $(list).append($(KanbanLoadMore).detach());
                },
                start: function(event, ui) {
                    $('body').css('overflow', 'hidden');

                    $(ui.helper).addClass('tilt');
                    $(ui.helper).find('.panel-body').css('background', '#fbfbfb');
                    // Start monitoring tilt direction
                    tilt_direction($(ui.helper));
                },
                stop: function(event, ui) {
                    $('body').removeAttr('style');
                    $(ui.helper).removeClass("tilt");
                    // Unbind temporary handlers and excess data
                    $("html").off('mousemove', $(ui.helper).data("move_handler"));
                    $(ui.helper).removeData("move_handler");
                },
                update: function(event, ui) {
                    callbackUpdate(ui, this);
                }
            });

            $('.status').sortable({
                cancel: '.not-sortable'
            });

        });

    }, 200);
}

function init_chart(data) {
  "use strict";
  var data_filter = {};
  data_filter.department = $('select[name="department"]').val();
  data_filter.role = $('select[name="role"]').val();
  data_filter.project = $('select[name="project"]').val();
  data_filter.staff = $('select[name="staff"]').val();
  data_filter.from_date = $('input[name="from_date"]').val();
  data_filter.to_date = $('input[name="to_date"]').val();
  $.post(admin_url + 'resource_workload/workload_chart', data_filter).done(function(res) {
     res = JSON.parse(res);
      Highcharts.chart('container_task', {
    chart: {
      type: 'pie',
      options3d: {
        enabled: true,
        alpha: 45
      }
    },
    title: {
      text: '<?php echo _l('statistics_by_estimate_hours'); ?>'
    },
    plotOptions: {
      pie: {
        innerSize: 100,
        depth: 45
      }
    },
    credits: {
        enabled: false
    },
    series: [{
        innerSize: '20%',
        name: '<?php echo _l('total_hours'); ?>',
        data: res.estimate_stats
      }]
  });

  Highcharts.chart('container_time', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },

    title: {
        text: '<?php echo _l('statistics_by_spent_hours'); ?>'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        innerSize: '20%',
        name: '<?php echo _l('total_hours'); ?>',
        data: res.spent_stats
      }]
  });

  Highcharts.chart('container_priority', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<?php echo _l('statistics_by_departments'); ?>'
    },
    xAxis: {
        categories: res.column_department
    },
    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: '<?php echo _l('total_hours'); ?>'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.x + '</b><br/>' +
                this.series.name + ': ' + this.y + '<br/>' +
                'Total: ' + this.point.stackTotal;
        }
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        column: {
            stacking: 'normal'
        }
    },
    series: res.department_stats
  });
  })
}

// Workload Kanban load more
function workload_kanban_load_more(staff_id, e, url, column_px, container_px) {
  "use strict";
    var LoadMoreParameters = [];
    var search = $('input[name="search"]').val();
    var _kanban_param_val;
    var page = $(e).attr('data-page');
    var total_pages = $('[data-col-staff-id="' + staff_id + '"]').data('total-pages');
    if (page <= total_pages) {

        var sort_type = $('input[name="sort_type"]');
        var sort = $('input[name="sort"]').val();
        if (sort_type.length != 0 && sort_type.val() !== '') {
            LoadMoreParameters['sort_by'] = sort_type.val();
            LoadMoreParameters['sort'] = sort;
        }

        if (typeof(search) != 'undefined' && search !== '') {
            LoadMoreParameters['search'] = search;
        }

        $.each($('#kanban-params input'), function() {
            if ($(this).attr('type') == 'checkbox') {
                _kanban_param_val = $(this).prop('checked') === true ? $(this).val() : '';
            } else {
                _kanban_param_val = $(this).val();
            }
            if (_kanban_param_val !== '') {
                LoadMoreParameters[$(this).attr('name')] = _kanban_param_val;
            }
        });

        LoadMoreParameters['staff'] = staff_id;
        LoadMoreParameters['page'] = page;
        LoadMoreParameters['page']++;
        requestGet(buildUrl(admin_url + url, LoadMoreParameters)).done(function(response) {
            page++;
            $('[data-load-staff="' + staff_id + '"]').before(response);
            $(e).attr('data-page', page);
            fix_kanban_height(column_px, container_px);
        }).fail(function(error) {
            alert_float('danger', error.responseText);
        });
        if (page >= total_pages - 1) {
            $(e).addClass("disabled");
        }
    }
}
</script>