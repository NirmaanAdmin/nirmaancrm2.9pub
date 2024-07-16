<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="_buttons">
        <?php if (has_permission('table_workplace_management', '', 'view') || is_admin()) { ?>
            <a href="#" onclick="new_workplace(); return false;" class="btn btn-info pull-left display-block">
                <?php echo _l('add'); ?>
            </a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
       <thead>
        <th><?php echo _l('workplace'); ?></th>
        <th><?php echo _l('workplace_address'); ?></th>
        <th><?php echo _l('latitude'); ?></th>
        <th><?php echo _l('longitude'); ?></th>
        <th><?php echo _l('distance'); ?></th>
        <th><?php echo _l('set_default'); ?></th>
        <?php  
        if (has_permission('table_workplace_management', '', 'view') || is_admin()) { ?>
            <th><?php echo _l('options'); ?></th>
        <?php } ?>
    </thead>
    <tbody>
        <?php foreach($workplace as $w){ ?>
            <tr>
             <td><?php echo html_entity_decode($w['name']); ?></td>
             <td><?php echo html_entity_decode($w['workplace_address']); ?></td>
             <td><?php echo html_entity_decode($w['latitude']); ?></td>
             <td><?php echo html_entity_decode($w['longitude']); ?></td>
             <td><?php echo html_entity_decode($w['distance']); ?></td>
             <td><?php echo ($w['default'] == 1) ? '<span class="btn text-success"><i class="fa fa-check-square"></i></span>' : '' ; ?></td>
             <?php  
             if (has_permission('table_workplace_management', '', 'view') || is_admin()) { ?>
                <td>
                   <a href="#" onclick="edit_workplace(this,<?php echo html_entity_decode($w['id']); ?>); return false" data-name="<?php echo html_entity_decode($w['name']); ?>" data-id="<?php echo html_entity_decode($w['id']); ?>" data-workplace_address="<?php echo html_entity_decode($w['workplace_address']); ?>" data-latitude="<?php echo html_entity_decode($w['latitude']); ?>" data-longitude="<?php echo html_entity_decode($w['longitude']); ?>" data-distance="<?php echo html_entity_decode($w['distance']); ?>" data-default="<?php echo html_entity_decode($w['default']); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                   <a href="<?php echo admin_url('timesheets/delete_workplace/'.$w['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
               </td>
           <?php } ?>
       </tr>
   <?php } ?>
</tbody>
</table>       
<div class="modal" id="workplace" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('timesheets/add_workplace'), array('id' => 'add_workplace' )); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_workplace'); ?></span>
                    <span class="add-title"><?php echo _l('new_workplace'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional_workplace"></div>   
                        <div class="form">     
                            <?php 
                            echo render_input('name','name'); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('workplace_address', 'workplace_address') ?>
                    </div>
                    <div class="col-md-6">

                        <?php echo render_input('latitude', 'latitude', '') ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('longitude', 'longitude', '') ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('distance', 'distance', '', 'number') ?>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <div class="clearfix"></div>
                        <div class="checkbox mtop15">                           
                            <input type="checkbox" class="capability" name="default" value="1">
                            <label><?php echo _l('set_default'); ?></label>
                        </div>
                    </div>

                </div>
                <input type="hidden" name="id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button class="btn btn-default" type="button" onclick="getMyLocation();"><i class="fa fa-location-arrow"></i> <?php echo _l('get_my_location'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

</body>
</html>
