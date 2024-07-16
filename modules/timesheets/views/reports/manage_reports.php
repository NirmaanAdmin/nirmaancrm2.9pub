<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper" >
 <div class="content">
  <div class="row">
   <div class="col-md-12">
    <div class="panel_s">
     <div class="panel-body">
      <div class="row">
        <!-- Table report -->
        <div class="col-md-4 border-right">
          <h4 class="no-margin font-medium"><i class="fa fa-balance-scale" aria-hidden="true"></i> <?php echo _l('reports'); ?></h4>
          <hr />
          <p><a href="#" class="font-medium" onclick="init_report(this,'annual_leave_report'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('annual_leave_report'); ?></a></p>
          <hr class="hr-10" />
          <p><a href="#" class="font-medium" onclick="init_report(this,'general_public_report'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('general_public_report'); ?></a></p>                    
          <hr class="hr-10" />                          
          <p><a href="#" class="font-medium" onclick="init_report(this,'requisition_report'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('manage_requisition_report'); ?></a></p>
          <hr class="hr-10" />                          
          <p><a href="#" class="font-medium" onclick="init_report(this,'history_check_in_out'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('history_check_in_out'); ?></a></p>
          <hr class="hr-10" />                          
          <p><a href="#" class="font-medium" onclick="init_report(this,'check_in_out_progress_according_to_the_route'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('check_in_out_progress_according_to_the_route'); ?></a></p>
          <hr class="hr-10" />                          
          <p><a href="#" class="font-medium" onclick="init_report(this,'check_in_out_progress'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('check_in_out_progress'); ?></a></p>
        </div>
        <!-- End table report -->
        <!-- Chart report -->
        <div class="col-md-4 border-right">
          <h4 class="no-margin font-medium"><i class="fa fa-area-chart" aria-hidden="true"></i> <?php echo _l('charts_based_report'); ?></h4>
          <hr />
          <p><a href="#" class="font-medium" onclick="init_report(this,'working_hours'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('working_hours'); ?></a></p>
          <hr class="hr-10"/>
          <p><a href="#" class="font-medium" onclick="init_report(this,'report_of_leave'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('report_of_leave'); ?></a></p>
          <hr class="hr-10"/>
          <p><a href="#" class="font-medium" onclick="init_report(this,'leave_by_department'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('leave_by_department'); ?></a></p>
          <hr class="hr-10"/>
          <p><a href="#" class="font-medium" onclick="init_report(this,'ratio_check_in_out_by_workplace'); return false;"><i class="fa fa-caret-down" aria-hidden="true"></i> <?php echo _l('ratio_check_in_out_by_workplace'); ?></a></p>
        </div>
        <!-- End chart report -->


        <div class="col-md-4">
          <div class="bg-light-gray border-radius-4">
            <div class="p8">

              <div id="currency" class="form-group hide">
               <label for="currency"><i class="fa fa-question-circle" data-toggle="tooltip" title="<?php echo _l('report_sales_base_currency_select_explanation'); ?>"></i> <?php echo _l('currency'); ?></label><br />
               <select class="selectpicker" name="currency" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">

               </select>
             </div>


             <div class="form-group" id="report-time">
              <label for="months-report"><?php echo _l('period_datepicker'); ?></label><br />
              <select class="selectpicker" name="months-report" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
               <option value=""><?php echo _l('report_sales_months_all_time'); ?></option>
               <option value="this_month"><?php echo _l('this_month'); ?></option>
               <option value="1"><?php echo _l('last_month'); ?></option>
               <option value="this_year"><?php echo _l('ts_this_year'); ?></option>
               <option value="last_year"><?php echo _l('ts_last_year'); ?></option>
               <option value="3" data-subtext="<?php echo _d(date('Y-m-01', strtotime("-2 MONTH"))); ?> - <?php echo _d(date('Y-m-t')); ?>"><?php echo _l('report_sales_months_three_months'); ?></option>
               <option value="6" data-subtext="<?php echo _d(date('Y-m-01', strtotime("-5 MONTH"))); ?> - <?php echo _d(date('Y-m-t')); ?>"><?php echo _l('report_sales_months_six_months'); ?></option>
               <option value="12" data-subtext="<?php echo _d(date('Y-m-01', strtotime("-11 MONTH"))); ?> - <?php echo _d(date('Y-m-t')); ?>"><?php echo _l('report_sales_months_twelve_months'); ?></option>
               <option value="custom"><?php echo _l('period_datepicker'); ?></option>
             </select>
           </div>

           <div class="form-group hide" id="report-month">
            <label for="months-report"><?php echo _l('month'); ?></label><br />
            <select class="selectpicker" name="months_2_report" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
              <?php 
              for ($i = 1; $i <= 12; $i++) {
                $dateObj   = DateTime::createFromFormat('!m', $i);
                $monthName = $dateObj->format('F');
                $month = $i;
                if(strlen($i) == 1){
                  $month = '0'.$i;
                }
                $selected = '';
                if(date('m') == $month){
                  $selected = 'selected';                  
                }
                ?>
                <option value="<?php echo html_entity_decode($month); ?>" <?php echo html_entity_decode($selected); ?>><?php echo html_entity_decode($monthName); ?></option>
              <?php } ?>
            </select>
          </div>

          <?php $current_year = date('Y');
          $y0 = (int)$current_year;
          $y1 = (int)$current_year - 1;
          $y2 = (int)$current_year - 2;
          $y3 = (int)$current_year - 3;
          ?>

          <div class="form-group hide" id="year_requisition">
            <label for="months-report"><?php echo _l('period_datepicker'); ?></label><br />
            <select  name="year_requisition" id="year_requisition"  class="selectpicker"  data-width="100%" data-none-selected-text="<?php echo _l('filter_by').' '._l('year'); ?>">
              <option value="<?php echo html_entity_decode($y0) ; ?>" <?php echo 'selected' ?>><?php echo _l('year').' '. $y0 ; ?></option>
              <option value="<?php echo html_entity_decode($y1) ; ?>"><?php echo _l('year').' '. $y1 ; ?></option>
              <option value="<?php echo html_entity_decode($y2) ; ?>"><?php echo _l('year').' '. $y2 ; ?></option>
              <option value="<?php echo html_entity_decode($y3) ; ?>"><?php echo _l('year').' '. $y3 ; ?></option>

            </select>
          </div>


          <div id="date-range" class="hide mbot15">
            <div class="row">
             <div class="col-md-6">
              <?php echo render_date_input('report-from','report_sales_from_date'); ?>
            </div>
            <div class="col-md-6">
              <?php echo render_date_input('report-to','report_sales_to_date'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="report" class="hide">
 <hr class="hr-panel-heading" />
 <div class="row">
  <center><h4 class="title_table"></h4></center>                  
</div>

<?php if(has_permission('report_management', '', 'view') || is_admin()){ ?>
  <div class="row sorting_table hide">
    <div class="table-fillter col-md-4">
      <div class="form-group">
       <label for="annual_leave"><?php echo _l('role'); ?></label>
       <select name="role[]" class="selectpicker" data-live-search="true" multiple data-width="100%" data-none-selected-text="<?php echo _l('invoice_status_report_all'); ?>">
        <?php foreach($roles as $role){ ?>
         <option value="<?php echo html_entity_decode($role['roleid']); ?>"><?php echo html_entity_decode($role['name']) ?></option>
       <?php } ?>
     </select>
   </div>
 </div>
 <div class="table-fillter col-md-4">
  <div class="form-group">
   <label for="annual_leave"><?php echo _l('department'); ?></label>
   <select name="department[]" class="selectpicker" data-live-search="true" multiple data-width="100%" data-none-selected-text="<?php echo _l('invoice_status_report_all'); ?>">
    <?php foreach($department as $value){ ?>
     <option value="<?php echo html_entity_decode($value['departmentid']); ?>"><?php echo html_entity_decode($value['name']); ?></option>
   <?php } ?>
 </select>
</div>
</div>
<div class="table-fillter col-md-4">
 <div class="form-group">
   <label for="annual_leave"><?php echo _l('staff'); ?></label>
   <select name="staff[]" class="selectpicker" data-live-search="true" multiple data-width="100%" data-none-selected-text="<?php echo _l('invoice_status_report_all'); ?>">
    <?php foreach($staff as $item){ ?>
     <option value="<?php echo html_entity_decode($item['staffid']); ?>"><?php echo html_entity_decode($item['firstname']).' '.$item['lastname']; ?></option>
   <?php } ?>
 </select>
</div>
</div>
<div class="table-fillter hide col-md-4 rel-type-fillter">
  <div class="form-group">
    <label for="rel_type" class="control-label"><?php echo _l('type'); ?></label>
    <select name="rel_type[]" class="selectpicker" data-width="100%" multiple="true" data-none-selected-text="<?php echo _l('none_type'); ?>"> 
     <option value="1"><?php echo _l('Leave') ?></option>                  
     <option value="2"><?php echo _l('late') ?></option>                  
     <option value="6"><?php echo _l('early') ?></option>                  
     <option value="3"><?php echo _l('Go_out') ?></option>                  
     <option value="4"><?php echo _l('Go_on_bussiness') ?></option>                  
   </select>
 </div>
</div>
</div> 

<!-- workplace - root -->
<div class="row sorting_2_table hide">
  <div class="filter_fr_2 col-md-3 staff_2_fr">
   <div class="form-group">
     <label for="annual_leave"><?php echo _l('staff'); ?></label>
     <select name="staff_2_fillter[]" class="selectpicker" data-live-search="true" multiple data-width="100%" data-none-selected-text="<?php echo _l('invoice_status_report_all'); ?>">
      <?php foreach($staff as $item){ ?>
       <option value="<?php echo html_entity_decode($item['staffid']); ?>"><?php echo html_entity_decode($item['firstname']).' '.$item['lastname']; ?></option>
     <?php } ?>
   </select>
 </div>
</div>
<div class="filter_fr_2 col-md-3 department_2_fr">
  <?php echo render_select('department_2_fillter[]', $department, array('departmentid', 'name'), 'department', '', array('multiple' => true, 'data-live-search' => true), [], '', '', false); ?>
</div>
<div class="filter_fr_2 col-md-3 roles_2_fr">
  <?php echo render_select('roles_2_fillter[]', $roles, array('roleid', 'name'), 'role', '', array('multiple' => true, 'data-live-search' => true), [], '', '', false); ?>
</div>
<div class="filter_fr_2 col-md-3 workplace_2_fr">
  <?php echo render_select('workplace_2_fillter[]', $workplace, array('id', 'name'), 'workplace', '', array('multiple' => true, 'data-live-search' => true), [], '', '', false); ?>
</div>
<div class="filter_fr_2 col-md-3 route_point_2_fr">
  <?php echo render_select('route_point_2_fillter[]', $route_point, array('id', 'name'), 'route_point', '', array('multiple' => true, 'data-live-search' => true), [], '', '', false); ?>
</div>
<div class="filter_fr_2 col-md-3 word_shift_2_fr">
  <?php echo render_select('word_shift_2_fillter[]', $word_shift, array('id', 'shift_type_name'), 'shift', '', array('multiple' => true, 'data-live-search' => true), [], '', '', false); ?>
</div>
<div class="filter_fr_2 col-md-3 type_2_fr">
  <?php echo render_select('type_2_fillter', [['id' => 3, 'name' => _l('all')], ['id' => 1, 'name' => _l('check_in')], ['id' => 2, 'name' => _l('check_out')]], array('id', 'name'), 'type', 3, [], [], '', '', false); ?>
</div>

<div class="filter_fr_2 col-md-3 type_22_fr">
  <?php echo render_select('type_22_fillter', [
    ['id' => 3, 'name' => _l('all')], 
    ['id' => 1, 'name' => _l('check_in')],
    ['id' => 2, 'name' => _l('check_out')],
    ['id' => 4, 'name' => _l('not_check_in')],
    ['id' => 5, 'name' => _l('not_check_out')],
    ['id' => 6, 'name' => _l('check_in_check_out')]

  ], array('id', 'name'), 'type', 3, [], [], '', '', false); ?>
</div>
<div class="filter_fr_2 col-md-3">
</div>
<div class="filter_fr_2 col-md-3">
</div>
<div class="filter_fr_2 col-md-3">
</div>

</div>
<!-- workplace - root -->
<?php } ?>
<?php $this->load->view('reports/annual_leave_report.php'); ?>
<?php $this->load->view('reports/working_hours.php'); ?>              
<?php $this->load->view('reports/manage_requisition_report.php'); ?>
<?php $this->load->view('reports/general_public_report.php'); ?> 
<?php $this->load->view('reports/history_check_in_out.php'); ?> 
<?php $this->load->view('reports/check_in_out_progress_according_to_the_route.php'); ?> 
<?php $this->load->view('reports/check_in_out_progress.php'); ?> 
<?php $this->load->view('reports/report_of_leave.php'); ?> 
<?php $this->load->view('reports/leave_by_department.php'); ?> 
<?php $this->load->view('reports/ratio_check_in_out_by_workplace.php'); ?> 

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>
<?php require 'modules/timesheets/assets/js/report_js.php'; ?>
</body>
</html>

