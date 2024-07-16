<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
 <a href="#" onclick="new_day_off(); return false;" class="btn btn-info" data-toggle="sidebar-right" data-target=".leave_modal-add-edit-modal"><?php echo _l('new_leave'); ?></a>
 <br/><br/>

<table class="table dt-table">
   <thead>
    <tr>
      <th><?php echo _l('date_off'); ?></th>
      <th><?php echo _l('reason_holidays'); ?></th>
      <th><?php echo _l('creator'); ?></th>
      <th><?php echo _l('options'); ?></th>
    </tr>
   </thead>
   <tbody>
    <?php foreach($holiday as $d) {?>
        <tr>
          <td><?php echo _d($d['date']); ?></td>
          <td><?php echo html_entity_decode($d['reason']); ?></td>
          <td><a href="<?php echo admin_url('hrm/member/'.$d["addedfrom"]); ?>">
                <?php echo staff_profile_image($d['addedfrom'],[
            'staff-profile-image-small mright5',
            ], 'small', [
            'data-toggle' => 'tooltip',
            'data-title'  => get_staff_full_name($d['addedfrom']),
            ]).' '. get_staff_full_name($d['addedfrom']); ?>
             </a></td>
          <td>
           <a href="#" onclick="edit_day_off(this,<?php echo html_entity_decode($d['id']); ?>); return false" data-reason="<?php echo html_entity_decode($d['reason']); ?>" data-date="<?php echo html_entity_decode($d['date']); ?>" class="btn btn-default btn-icon" data-toggle="sidebar-right" data-target=".leave_modal_update-edit-modal"><i class="fa fa-pencil-square-o"></i></a>

            <a href="<?php echo admin_url('resource_workload/delete_dayoff/'.$d['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
          </td>
        </tr>
      <?php } ?>
   </tbody>
  </table>
<div class="modal fade" id="add_update_dayoff" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('resource_workload/add_update_dayoff')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_leave'); ?></span>
                    <span class="add-title"><?php echo _l('new_leave'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('reason','reason_holidays') ?> 
                        <?php echo render_date_input('date','date_off'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->