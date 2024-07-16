<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="panel_s">
       <div class="panel-body">
        <h4><?php echo _l('timekeeping') ?>
        <hr>
      </h4>
      <div class="horizontal-tabs mb-5">
      </div>
      <input type="hidden" name="current_month" value="<?php echo date('Y-m'); ?>">
      <?php 
      if (has_permission('attendance_management', '', 'view') || is_admin()) {
       ?>
       <div class="row filter_by">
        <div class="col-md-2 leads-filter-column">
          <?php echo render_input('month_timesheets','month',date('Y-m'), 'month'); ?>
        </div>
        <div class="col-md-3 leads-filter-column">
          <?php echo render_select('department_timesheets',$departments,array('departmentid', 'name'),'department'); ?>
        </div>
        <div class="col-md-3 leads-filter-column">
          <?php echo render_select('job_position_timesheets',$roles,array('roleid', 'name'),'role'); ?>
        </div>
        <div class="col-md-3 leads-filter-column">
          <?php echo render_select('staff_timesheets[]',$staffs,array('staffid',array('firstname','lastname')),'staff','',array('multiple'=>true,'data-actions-box'=>true),array(),'','',false); ?>
        </div>
        <div class="col-md-1 mtop25">
          <button type="button" class="btn btn-info timesheets_filter"><?php echo _l('filter'); ?></button>
        </div>                         
      </div>
    <?php } ?>
    <?php echo form_open(admin_url('timesheets/manage_timesheets'),array('id'=>'timesheets-form')); ?>
    <hr class="hr-panel-heading no-margin"/>               
    <div class="row mtop15">
      <div class="col-md-8 line-suggestion">
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('p_x_timekeeping'); ?>" class="btn" >AL</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('W_x_timekeeping'); ?>" class="btn" >W</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('A_x_timekeeping'); ?>" class="btn" >U</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('Le_x_timekeeping'); ?>" class="btn" >HO</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('E_x_timekeeping'); ?>" class="btn" >E</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('L_x_timekeeping'); ?>" class="btn" >L</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('CT_x_timekeeping'); ?>" class="btn" >B</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('OM_x_timekeeping'); ?>" class="btn" >SI</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('TS_x_timekeeping'); ?>" class="btn" >M</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('H_x_timekeeping'); ?>" class="btn" >ME</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('NS_x_timekeeping'); ?>" class="btn" >NS</button>
       <!--  <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php //echo _l('EB_x_timekeeping'); ?>" class="btn" >EB</button>
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php //echo _l('UB_x_timekeeping'); ?>" class="btn" >UB</button> -->
        <button type="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l('P_timekeeping'); ?>" class="btn" >P</button>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-4">
        <a href="javascript:void(0)" class="btn btn-default pull-right mtop5 mleft10 export_excel">
          <i class="fa fa-file-excel"></i> <?php echo _l('export_to_excel'); ?>
        </a>
        <?php if($data_timekeeping_form == 'timekeeping_manually'){ ?>
          <button type="button" onclick="open_check_in_out();" class="btn btn-info pull-right display-block mtop5 check_in_out_timesheet" data-toggle="tooltip" title="" data-original-title="<?php echo _l('check_in').' / '._l('check_out'); ?>"><?php echo _l('check_in'); ?> / <?php echo _l('check_out'); ?></button>
        <?php }elseif($data_timekeeping_form == 'csv_clsx'){ ?>
          <button type="button" class="btn btn-info pull-right display-block mtop5 check_in_out_timesheet" data-toggle="modal" data-target="#import_timesheets_modal" data-original-title="<?php echo _l('import_timesheets'); ?>"><?php echo _l('import_timesheets'); ?></button>
        <?php } ?>
      </div>
      <div class="clearfix"></div>
      <br>
      <div class="col-md-12">
        <div class="form">    
          <div class="hot handsontable htColumnHeaders" id="example">
          </div>
          <?php echo form_hidden('time_sheet'); ?>
          <?php echo form_hidden('month', date('m-Y')); ?>
          <?php echo form_hidden('latch'); ?>
          <?php echo form_hidden('unlatch'); ?>
        </div>
        <hr class="hr-panel-heading" />
        <?php 
        if($check_latch_timesheet){ 
          $latched = '';
          $latch = 'hide';
        }else{
          $latched = 'hide';
          $latch = '';              
        } ?>


        <?php if(is_admin() || has_permission('timesheets_timekeeping','','edit')) {?>

          <button class="btn btn-danger pull-right unlatch_time_sheet mleft5 <?php echo html_entity_decode($latched); ?>" id="btn_unlatch" onclick="return confirm('<?php echo _l('timekeeping_unlatch'); ?>')"><?php echo _l('reopen_attendance'); ?></button>

          <button class="btn btn-info pull-right latch_time_sheet mleft5 <?php echo html_entity_decode($latch); ?>" id="btn_latch" onclick="return confirm('<?php echo _l('timekeeping_latch'); ?>')"><?php echo _l('close_attendance'); ?></button>

          <?php
          $data_timekeeping_form = get_timesheets_option('timekeeping_form');
          if($data_timekeeping_form != 'timekeeping_task'){ ?>
            <a class="btn btn-info pull-right edit_timesheets mleft5 <?php echo html_entity_decode($latch); ?>"><?php echo _l('edit'); ?></a>
          <?php } ?>
          <button class="btn btn-info pull-right save_time_sheet mleft5 hide"><?php echo _l('submit'); ?></button>

          <a class="btn btn-default pull-right exit_edit_timesheets mleft5 hide"><?php echo _l('close'); ?></a>


        <?php } ?>
      </div>
    </div>
    <?php echo form_hidden('is_edit', 0); ?>
    <?php echo form_close(); ?>

    <div class="modal" id="timesheets_detail_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content width-100">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 id='title_detail'>
              <?php echo _l('detail'); ?>
            </h4>
          </div>
          <div class="modal-body">
            <ul class="list-group" id="ul_timesheets_detail_modal">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->      
  </div>
</div>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>

<div class="modal fade" id="import_timesheets_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php echo form_open_multipart(admin_url('timesheets/import_timesheets'),array('id'=>'import-timesheets-form')); ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo _l('import_timesheets'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo render_input('file_timesheets', 'file', '', 'file', ['accept'=>".xlsx, .xls, .csv"]); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <a href="<?php echo site_url('modules/timesheets/uploads/timesheets/import_timesheets.xlsx'); ?>" class="btn btn-primary"><?php echo _l('download_sample'); ?></a>
        <button class="btn btn-primary"><?php echo _l('submit'); ?></button>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>
<?php init_tail(); ?>
</body>
</html>
<?php require 'modules/timesheets/assets/js/timesheets.php'; ?>