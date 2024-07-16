<?php defined('BASEPATH') or exit('No direct script access allowed');

foreach ($staffs as $staff) {
$staffsTasksWhere = '';

$cpicker = '';

$staff_color = '';


$total_pages = $staff['total_pages'];
$tasks = $staff['tasks'];
$total_tasks = count($tasks);

if($staff['staffid'] == 0 && count($tasks) == 0){
  continue;
}
?>
<ul class="kan-ban-col workload-column" data-col-staff-id="<?php echo html_entity_decode($staff['staffid']); ?>" data-total-pages="<?php echo html_entity_decode($total_pages); ?>">
 <li class="kan-ban-col-wrapper">
  <div class="border-right panel_s">
   <div class="panel-heading panel-heading-bg <?php if ($staff_color != '') {
    echo 'color-not-auto-adjusted color-white ';
    } ?><?php if ($staff['staffid'] != 0) {
      echo 'task-phase';
      } else {
        echo 'info-bg';
      } ?>"<?php echo html_entity_decode($staff_color); ?>>
        <i class="fa fa-reorder pointer"></i>&nbsp;

        <a href="#" class="title-avatar"><?php echo staff_profile_image($staff['staffid'],array('staff-profile-image-xs sub-staff-assigned-milestone pull-left no-margin'),'small',array('data-toggle'=>'tooltip','data-title'=>get_staff_full_name($staff['staffid']))); ?>&nbsp;
        <span class="bold heading"><?php echo html_entity_decode($staff['firstname'].' '.$staff['lastname']); ?></span>
        </a>
    </span>
</div>
<div class="kan-ban-content-wrapper">
  <div class="kan-ban-content">
   <ul class="status staff-workload-kanban milestone-tasks-wrapper sortable relative" data-task-status-id="<?php echo html_entity_decode($staff['staffid']); ?>">
    <?php
    foreach ($tasks as $task) {
     $this->load->view('resource_workload/_workload_kanban_card', array('task'=>$task, 'milestone'=>$staff['staffid']));
   } ?>
   <?php if ($total_tasks > 0) { ?>
     <li class="text-center not-sortable kanban-load-more" data-load-staff="<?php echo html_entity_decode($staff['staffid']); ?>">
       <a href="#" class="btn btn-default btn-block<?php if ($total_pages <= 1) { echo ' disabled'; } ?>" data-page="1" onclick="workload_kanban_load_more(<?php echo html_entity_decode($staff['staffid']); ?>,this,'resource_workload/workload_kanban_load_more',320,360); return false;";>
        <?php echo _l('load_more'); ?>
      </a>
    </li>
  <?php } ?>
  <li class="text-center not-sortable mtop30 kanban-empty<?php if ($total_tasks > 0) { echo ' hide'; } ?>">
   <h4>
    <i class="fa fa-circle-o-notch" aria-hidden="true"></i><br /><br />
    <?php echo _l('no_tasks_found'); ?>
  </h4>
</li>
</ul>
</div>
</div>
</li>
</ul>
<?php } ?>
