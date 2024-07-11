<script>
    var project_id = $('input[name="project_id"]').val();
    var fnServerParams = {
    "project_id": 'input[name="project_id"]',
    "milestones": 'select[name="milestones_'+project_id+'"]',
    "members": 'select[name="members_'+project_id+'"]',
    "task_status": 'select[name="task_status_'+project_id+'"]',
 }
  $(function(){
    var circle = $('.project-progress').circleProgress({fill: {
      gradient: ['#84c529', '#84c529']
    }}).on('circle-animation-progress', function(event, progress, stepValue) {
      $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
    });
        project_roadmap_tasks(project_id);
  });
  $('select[name="milestones_'+project_id+'"],select[name="members_'+project_id+'"],select[name="task_status_'+project_id+'"]').on('change', function() {
       project_roadmap_tasks(project_id);
     });
  function project_roadmap_tasks(project_id) {
     if ($.fn.DataTable.isDataTable('.table-project_roadmap_tasks_' + project_id)) {
       $('.table-project_roadmap_tasks_' + project_id).DataTable().destroy();
     }
     initDataTable('.table-project_roadmap_tasks_' + project_id, admin_url + 'project_roadmap/project_roadmap_tasks/'+project_id, false, false, fnServerParams);
   }
   function project_roadmap_tasks_by_member(project_id,id) {
     if ($.fn.DataTable.isDataTable('.table-project_roadmap_tasks_' + project_id)) {
       $('.table-project_roadmap_tasks_' + project_id).DataTable().destroy();
     }
     $('input[name="member_id_'+project_id+'"]').val(id);
     var Params = {
      "members": 'input[name="member_id_'+project_id+'"]'};
     initDataTable('.table-project_roadmap_tasks_' + project_id, admin_url + 'project_roadmap/project_roadmap_tasks/'+project_id, false, false, Params);
   }
   function project_roadmap_tasks_by_milestone(project_id,id) {
     if ($.fn.DataTable.isDataTable('.table-project_roadmap_tasks_' + project_id)) {
       $('.table-project_roadmap_tasks_' + project_id).DataTable().destroy();
     }
     $('input[name="milestone_id_'+project_id+'"]').val(id);
     var Params = {
      "milestones": 'input[name="milestone_id_'+project_id+'"]'};
     initDataTable('.table-project_roadmap_tasks_' + project_id, admin_url + 'project_roadmap/project_roadmap_tasks/'+project_id, false, false, Params);
   }


    var rows = $('.table-milestones').find('tr');
    $.each(rows, function() {
        var td = $(this).find('td').eq(1);
        var percent = $(td).find('input[name="percent"]').val();
        $(td).find('.goal-progress').circleProgress({
            value: percent,
            size: 45,
            animation: false,
            fill: {
                gradient: ["#28b8da", "#059DC1"]
            }
        })
    })
</script>