<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<div class="row">
 <div class="col-md-12">
  <?php 
  if(has_permission('route_management','','view') || is_admin()){ ?>
    <div class="col-md-3">
     <?php echo render_select('staff_fillter[]', $staff, array('staffid', array('firstname', 'lastname')), 'staff', get_staff_user_id(), array('multiple' => true, 'onchange' => 'get_data_map_fillter()'),[],'','',false); ?>
   </div>
  <?php } else { ?>
    <input type="hidden" id="staff_fillter[]" name="staff_fillter[]" value="<?php echo get_staff_user_id(); ?>">
  <?php } ?>
 <div class="col-md-3">
   <?php echo render_date_input('date_fillter', 'dates', _d(date('Y-m-d')), array('onchange' => 'get_data_map_fillter()')); ?>
 </div>
 <div class="col-md-3">
   <?php echo render_select('route_point_fillter[]', $route_point, array('id', 'name'), 'route_point', '', array('multiple' => true, 'onchange' => 'get_data_map_fillter()'),[],'','',false); ?>
 </div>
 <div class="col-md-3">
 </div>
</div>
<div class="clearfix"></div>
<br>
<div class="clearfix"></div>
<div class="col-md-12">
  <div id="map"></div>
</div>
</div>

<div class="modal fade" id="check_in_out_log" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="add-title"><?php echo _l('check_in_out_log'); ?></span> <span class="date"></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <?php echo render_select('staffid_fillter', [], array('staffid', array('firstname', 'lastname')), 'staff','', array('onchange' => 'get_log_check_in_out(this)')); ?>    
              <input type="hidden" name="date" value="">        
              <input type="hidden" name="route_point_id" value="">        
          </div>
        </div>
        <div class="row content_log">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<?php require 'modules/timesheets/assets/js/map_js.php'; ?>

