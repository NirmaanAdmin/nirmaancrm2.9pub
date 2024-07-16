<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo html_entity_decode($title); ?></h4>
                        <hr>
                        <div class="clearfix"></div>
                        <div class="_buttons">
                            <?php if (has_permission('table_shiftwork_management', '', 'view') || is_admin()) { ?>
                                <a href="#" onclick="new_shift_type(); return false;" class="btn btn-info pull-left display-block">
                                    <?php echo _l('add'); ?>
                                </a>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <br>
                        </div>

                        <div class="clearfix"></div>
                        <table class="table table-shift_type scroll-responsive">
                          <thead>
                            <th>ID#</th>
                            <th><?php echo _l('shift_type_name'); ?></th>
                            <th><?php echo _l('description'); ?></th>
                            <th><?php echo _l('options'); ?></th>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                       </tfoot>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
</div>
<div class="modal fade" id="shift" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog w-25">
        <?php echo form_open(admin_url('timesheets/manage_shift_type'),array('id'=>'shift_type')); ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_shift_type'); ?></span>
                    <span class="add-title"><?php echo _l('new_shift_type'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div id="additional_shift"></div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo render_input('shift_type_name','shift_type_name'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_color_picker('color', _l('leads_status_color')); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('time_start_work','time_start_work','', 'time'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('time_end_work','time_end_work','', 'time'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('start_lunch_break_time','start_lunch_break_time','', 'time'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('end_lunch_break_time','end_lunch_break_time','', 'time'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','description') ?>
                    </div>
                    <input type="hidden" name="id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>