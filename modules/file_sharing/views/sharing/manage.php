<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="panel_s">
        <div class="panel-body">
          <h4 class="no-margin font-bold"><?php echo _l($title); ?></h4>
          <hr />
          <div class="row">
              <?php if(is_admin()){ ?>
                <div class="col-md-3">
                <?php  echo render_select('member_filter', $staffs, array('staffid', 'firstname', 'lastname'), 'staff', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                </div>
              <?php } ?>
              <div class="col-md-3">
              <?php
              $type = [1 => ['id' => 'fs_staff', 'name' => _l('fs_staff')],
                         2 => ['id' => 'fs_client', 'name' => _l('fs_client')],
                         3 => ['id' => 'fs_public', 'name' => _l('fs_public')],
                         ];
               echo render_select('type', $type, array('id', 'name'), 'type', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
              </div>
              <div class="col-md-3">
              <?php
              $status = [1 => ['id' => 'normal', 'name' => _l('normal')],
                         2 => ['id' => 'expiration_date', 'name' => _l('contracts_view_expired')],
                         3 => ['id' => 'download_limits', 'name' => _l('download_limit_reached')],
                         4 => ['id' => 'has_been_deleted', 'name' => _l('file_has_been_deleted')],];
               echo render_select('status', $status, array('id', 'name'), 'status', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
              </div>
              <div class="col-md-3">
              <?php
              $password = [1 => ['id' => 'have_password', 'name' => _l('have_password')],
                         2 => ['id' => 'no_password', 'name' => _l('no_password')],
                         ];
               echo render_select('password', $password, array('id', 'name'), 'staff_add_edit_password', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
              </div>
            <div class="col-md-3">
              <?php echo render_date_input('from_date','from_date'); ?>
            </div>
            <div class="col-md-3">
              <?php echo render_date_input('to_date','to_date'); ?>
            </div>
          </div>
          <table class="table table-sharing scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('hash_share'); ?></th>
                 <th><?php echo _l('name'); ?></th>
                 <th><?php echo _l('fs_share_expiration_date'); ?></th>
                 <th><?php echo _l('download_limits'); ?></th>
                 <th><?php echo _l('downloads'); ?></th>
                 <th><?php echo _l('have_password'); ?></th>
                 <th><?php echo _l('sharer'); ?></th>
                 <th><?php echo _l('type'); ?></th>
                 <th><?php echo _l('proposal_date_created'); ?></th>
                 <th><?php echo _l('last_updated'); ?></th>
                 <th><?php echo _l('status'); ?></th>
                 <th><?php echo _l('options'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="send-mail-modal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title add-title"><?php echo _l('fs_send_email')?></h4>
         </div>
         <?php echo form_open_multipart(admin_url('file_sharing/send_mail_to_public'),array('id'=>'fs-send-mail-form'));?>
         <?php echo form_hidden('id'); ?>
          <div class="modal-body">
            <?php echo render_input('email', 'email') ?>
          </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="close_send_mail(); return false;"><?php echo _l('close'); ?></button>
            <button type="submit" class="btn btn-info btn-submit"><?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>

<div class="modal fade" id="share-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title add-title"><?php echo _l('fs_share')?></h4>
         </div>
         <?php echo form_open_multipart(admin_url('file_sharing/edit_sharing'),array('id'=>'fs-share-form'));?>
         <?php echo form_hidden('id'); ?>
         
         <div class="modal-body">
            <div class="row mtop15 mbot15 fs-gr-radio">
               <div class="col-md-12">
                  <label class="radio-inline">
                     <input type="radio" name="type" value="fs_staff" id="fs_staff">
                     <span class="inline-mbot"><?php echo _l('fs_staff'); ?></span>
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="type" value="fs_client" id="fs_client">
                     <span class="inline-mbot"><?php echo _l('fs_client'); ?></span>
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="type" value="fs_public" id="fs_public">
                     <span class="inline-mbot"><?php echo _l('fs_public'); ?></span>
                  </label>
               </div>
            </div>
            <div id="div_staff">
               <?php 
               $selected_role = array();
               echo render_select('role[]',$roles,array('roleid',array('name')),'role',$selected_role,array('multiple'=>true, 'data-actions-box' => true),array(),'','',false); ?>
               <?php 
               $selected = array();
               echo render_select('staff[]',$staffs,array('staffid',array('firstname','lastname')),'staff',$selected,array('multiple'=>true, 'data-actions-box' => true),array(),'','',false); ?>
            </div>
            <div id="div_client" class="hide">
               <?php 
               $selected_role = array();
               echo render_select('customer_group[]',$client_groups,array('id','name'),'customer_group',$selected_role,array('multiple'=>true, 'data-actions-box' => true),array(),'','',false); ?>
               <?php 
               $selected = array();
               echo render_select('customer[]',$clients,array('userid','company'),'customer',$selected,array('multiple'=>true, 'data-actions-box' => true),array(),'','',false); ?>
            </div>
            <div id="div_public" class="hide">
                    <div class="row">
                  <div class="col-md-12">
                        <label for="public_link" class="control-label"><?php echo _l('fs_link'); ?></label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="public_link" name="public_link" autocomplete="off" value="<?php echo site_url('file_sharing/d3ghf6'); ?>" readonly>
                           <span class="input-group-addon">
                              <a href="javascript:void(0);" onclick="copy_public_link(); return false;"><i class="fa fa-clone"></i></a>
                           </span>
                           <span class="input-group-addon">
                              <a href="javascript:void(0);" onclick="send_mail(); return false;"><i class="fa fa-envelope-o btn_send_mail"></i></a>
                           </span>
                        </div>
                     </div>
               </div>
               
            </div>
            <div class="form-group">
               <div class="checkbox checkbox-primary">
                  <input type="checkbox" name="expiration_date_apply" id="expiration_date_apply" value="1">
                  <label for="expiration_date_apply"><?php echo _l('expiration_date_apply'); ?></label>
               </div>
            </div>
            <div class="mleft15 hide" id="div_expiration_date">
               <?php echo render_date_input('expiration_date', 'fs_share_expiration_date') ?>
               <div class="form-group">
                  <div class="checkbox checkbox-primary">
                     <input type="checkbox" name="expiration_date_delete" id="expiration_date_delete" value="1">
                     <label for="expiration_date_delete"><?php echo _l('delete_file_when_finished'); ?></label>
                  </div>
               </div>
            </div>
              <div class="form-group">
               <div class="checkbox checkbox-primary">
                  <input type="checkbox" name="download_limits_apply" id="download_limits_apply" value="1">
                  <label for="download_limits_apply"><?php echo _l('download_limits_apply'); ?></label>
               </div>
            </div>
            <div class="mleft15 hide" id="div_download_limit">
               <?php echo render_input('download_limits', 'download_limits', '', 'number', array('min' => 1)) ?>
               <div class="form-group">
                  <div class="checkbox checkbox-primary">
                     <input type="checkbox" name="download_limits_delete" id="download_limits_delete" value="1">
                     <label for="download_limits_delete"><?php echo _l('delete_file_when_finished'); ?></label>
                  </div>
               </div>
            </div>
            <div class="row hide" id="div_public_permisstion">
               <div class="col-md-6">
                  <h5 class="title mbot5"><?php echo _l('fs_permisstion') ?></h5>
                   <div class="row">
                       <div class="col-md-6 mtop10 border-right">
                           <span><?php echo _l('download'); ?></span>
                       </div>
                       <div class="col-md-6 mtop10">
                           <div class="onoffswitch">
                               <input type="checkbox" id="public_is_download" data-perm-id="5" class="onoffswitch-checkbox"  value="1" name="public_is_download" checked>
                               <label class="onoffswitch-label" for="public_is_download"></label>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-12">
                <hr>
               <label for="password" class="control-label"><?php echo _l('staff_add_edit_password'); ?></label>
               <div class="input-group">
                  <input type="password" class="form-control password" name="password" autocomplete="off">
                  <span class="input-group-addon">
                  <a href="#password" class="show_password" onclick="showPassword('password'); return false;"><i class="fa fa-eye"></i></a>
                  </span>
                  
               </div>
               </div>
            </div>
            <div class="row hide" id="div_permisstion">
               <div class="col-md-6">
                  <h5 class="title mbot5"><?php echo _l('fs_permisstion') ?></h5>
                   <div class="row">
                       <div class="col-md-6 mtop10 border-right">
                           <span><?php echo _l('view'); ?></span>
                       </div>
                       <div class="col-md-6 mtop10">
                           <div class="onoffswitch">
                               <input type="checkbox" id="is_read" data-perm-id="5" class="onoffswitch-checkbox" value="1" name="is_read" checked>
                               <label class="onoffswitch-label" for="is_read"></label>
                           </div>
                       </div>
                       <div class="col-md-6 mtop10 border-right">
                           <span><?php echo _l('upload_and_override'); ?></span>
                       </div>
                       <div class="col-md-6 mtop10">
                           <div class="onoffswitch">
                               <input type="checkbox" id="is_write" data-perm-id="6" class="onoffswitch-checkbox"  value="1" name="is_write" checked>
                               <label class="onoffswitch-label" for="is_write"></label>
                           </div>
                       </div>
                       <div class="col-md-6 mtop10 border-right">
                           <span><?php echo _l('delete'); ?></span>
                       </div>
                       <div class="col-md-6 mtop10">
                           <div class="onoffswitch">
                               <input type="checkbox" id="is_delete" data-perm-id="5" class="onoffswitch-checkbox"  value="1" name="is_delete" checked>
                               <label class="onoffswitch-label" for="is_delete"></label>
                           </div>
                       </div>
                       <div class="col-md-6 mtop10 border-right hide">
                           <span><?php echo _l('project_setting_upload_files'); ?></span>
                       </div>
                       <div class="col-md-6 mtop10 hide">
                           <div class="onoffswitch">
                               <input type="checkbox" id="is_upload" data-perm-id="6" class="onoffswitch-checkbox"  value="1" name="is_upload" checked>
                               <label class="onoffswitch-label" for="is_upload"></label>
                           </div>
                       </div>
                       <div class="col-md-6 mtop10 border-right hide">
                           <span><?php echo _l('download'); ?></span>
                       </div>
                       <div class="col-md-6 mtop10 hide">
                           <div class="onoffswitch">
                               <input type="checkbox" id="is_download" data-perm-id="5" class="onoffswitch-checkbox"  value="1" name="is_download" checked>
                               <label class="onoffswitch-label" for="is_download"></label>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            <button type="submit" class="btn btn-info btn-submit"><?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>
<?php init_tail(); ?>
</body>
</html>
