      <input type="hidden" name="hour_attendance" value="<?php echo date('H'); ?>">
      <input type="hidden" name="minute_attendance" value="<?php echo date('i'); ?>">
      <input type="hidden" name="second_attendance" value="<?php echo date('s'); ?>">
      <input type="hidden" name="date_attendance" value="<?php echo date('Y-m-d H:i:s'); ?>">
      <div class="modal" id="clock_attendance_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4>
               <?php echo _l('check_in'); ?> / <?php echo _l('check_out'); ?>
             </h4>
           </div>
           <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <?php 
                $CI = &get_instance();
                $CI->load->model('staff_model');
                $staffs = $CI->staff_model->get();
                ?>
                <?php if(is_admin()){ ?>
                  <?php echo render_select('staff_id', $staffs, array('staffid', array('firstname', 'lastname')),'staff', get_staff_user_id(), array('onchange' => 'changestaff_id(this)')); ?>
                <?php } ?>
                <div class="route_point_combobox hide">
                  <br>
                  <label for="route_point" class="control-label">Route point</label>
                  <select id="route_point" name="route_point" class="selectpicker" data-width="100%" data-none-selected-text="Non selected" tabindex="-98">
                  </select>
                  <br>
                  <br>
                  <div class="clearfix"></div>
                </div>

                <div id="clock" class="clock">
                  <div id="hourHand" class="hourHand"></div>
                  <div id="minuteHand" class="minuteHand"></div>
                  <div id="secondHand" class="secondHand"></div>
                  <div id="center" class="center"></div>
                  <ul>
                    <li><span>1</span></li>
                    <li><span>2</span></li>
                    <li><span>3</span></li>
                    <li><span>4</span></li>
                    <li><span>5</span></li>
                    <li><span>6</span></li>
                    <li><span>7</span></li>
                    <li><span>8</span></li>
                    <li><span>9</span></li>
                    <li><span>10</span></li>
                    <li><span>11</span></li>
                    <li><span>12</span></li>
                  </ul>
                </div>
                <?php 
                $CI->load->model('timesheets/timesheets_model');
                $type_check_in_out = '';
                $data_check_in_out = $CI->timesheets_model->get_list_check_in_out(date('Y-m-d'), get_staff_user_id());
                $html_list = '';
                foreach ($data_check_in_out as $key => $value) {
                  $alert_type = 'alert-success';
                  $type_check_in_out = $value['type_check'];
                  $type_check = _l('checked_in_at');
                  if($value['type_check'] == 2){  
                    $type_check = _l('checked_out_at');
                    $alert_type = 'alert-warning';
                  }
                  $html_list .= '<div class="row"><div class="col-md-12"><div class="alert '.$alert_type.'">'.$type_check.': '._dt($value['date']).'</div></div></div>';
                } ?>
                <?php 
                $allows_updating_check_in_time = 0;
                $data_allows_updating = get_timesheets_option('allows_updating_check_in_time');
                if($data_allows_updating){
                  $allows_updating_check_in_time = $data_allows_updating;
                }
                $allows_to_choose_an_older_date = 0;
                $data_order_date = get_timesheets_option('allows_to_choose_an_older_date');
                if($data_order_date){
                  $allows_to_choose_an_older_date = $data_order_date;
                }                
                ?>
                <div class="row curr_date_attendance_wrap">
                  <div class="curr_date text-center" id="curr_date_attendance">
                    <?php echo _d(date('Y-m-d')); ?>
                    <?php
                    if($allows_updating_check_in_time == 1 || is_admin()){ ?>
                      <button class="btn-edit-datetime">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn-close-edit-datetime hide">
                        <i class="fa fa-times"></i>
                      </button>
                      <?php 
                      $attr = [];
                      if($allows_to_choose_an_older_date == 1 || is_admin())
                      {
                        $attr = array('onchange' => 'changedate(this)');
                      }
                      else{
                        $attr = array('onchange' => 'changedate(this)',
                         'data-date-min-date'=>_dt(date('Y-m-d H:i:s')));
                      }
                      echo render_datetime_input('edit_date', 'edit_date', '', $attr); 
                    }
                    ?>
                  </div>
                </div>
                <br>
                <br>
                <div class="col-md-12 bottom_co_btn">
                  <div class="bottom_co_btn_item">
                    <?php
                    if($type_check_in_out == '' || $type_check_in_out == 2 || $allows_updating_check_in_time == 1 || is_admin()){
                     echo form_open(admin_url('timesheets/check_in_ts'),array('id'=>'timesheets-form-check-in', 'onsubmit'=>'get_data()')); ?>
                     <input type="hidden" name="staff_id" value="<?php echo get_staff_user_id(); ?>">
                     <input type="hidden" name="type_check" value="1">
                     <input type="hidden" name="edit_date" value="">
                     <input type="hidden" name="point_id" value="">
                     <input type="hidden" name="location_user" value="">
                     <button class="btn btn-primary check_in"><?php echo _l('check_in'); ?></button>
                     <?php echo form_close(); } ?>
                   </div>
                   <div class="bottom_co_btn_item">              
                     <?php if($type_check_in_out == 1 || $allows_updating_check_in_time == 1 || is_admin()){
                      echo form_open(admin_url('timesheets/check_in_ts'),array('id'=>'timesheets-form-check-out', 'onsubmit'=>'get_data()')); 
                      ?>  
                      <input type="hidden" name="staff_id" value="<?php echo get_staff_user_id(); ?>">
                      <input type="hidden" name="type_check" value="2">
                      <input type="hidden" name="edit_date" value="">
                      <input type="hidden" name="point_id" value="">
                      <input type="hidden" name="location_user" value="">
                      <button class="btn btn-warning check_out"><?php echo _l('check_out'); ?></button>
                      <?php echo form_close(); } ?>       
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <br>
                  <div class="col-mm-12" id="attendance_history">
                    <?php echo html_entity_decode($html_list); ?>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            </div>
          </div>
        </div>
      </div>

