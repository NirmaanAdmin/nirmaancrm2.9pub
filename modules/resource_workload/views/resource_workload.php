<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php init_head();?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
                <div class="border-right">
                  <h4 class="no-margin font-bold"><?php echo _l($title); ?></h4>
                  <hr />
                </div>
                <div class="row">
                  <div id="kanban-params">
                    <div class="col-md-2 <?php if($type == 'capacity'){echo 'hide';} ?>">
                      <?php echo render_select('department', $departments, array('departmentid', 'name'), 'department', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                    </div>
                    <div class="col-md-2 <?php if($type == 'capacity'){echo 'hide';} ?>">
                      <?php echo render_select('role', $roles, array('roleid', 'name'), 'role', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                    </div>
                    <div class="col-md-2">
                      <?php echo render_select('project', $projects, array('id', 'name'), 'project', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                    </div>
                    <div class="col-md-2 <?php if($type == 'capacity'){echo 'hide';} ?>">
                      <?php echo render_select('staff', $staffs, array('staffid', 'firstname', 'lastname'), 'staff', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-5">
                        <?php echo render_date_input('from_date', 'from_date', date(get_current_date_format(true), strtotime('-7 day', strtotime(date('Y-m-d'))))); ?>
                      </div>
                      <div class="col-md-5">
                        <?php echo render_date_input('to_date', 'to_date', date(get_current_date_format(true))); ?>
                      </div>
                      <div class="col-md-2">
                        <a href="#" onclick="get_data_workload(); return false;" class="px-0 btn btn-info display-block mtop25"><i class="fa fa-search"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
            <div class="horizontal-tabs mb-5">
              <ul class="nav nav-tabs nav-tabs-horizontal mb-10">
              <?php
              foreach($tab as $gr){ ?> 
                <li<?php if($type == $gr){echo " class='active'"; } ?>>
                <a href="<?php echo admin_url('resource_workload?type='.$gr); ?>" data-group="<?php echo html_entity_decode($gr); ?>">
                  <?php echo _l($gr); ?>
                  </a>
                </li>
                <?php 
              } ?>
              </ul>
              </div>
              <?php $this->load->view($tabs['view']); ?>
              <br>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail();?>
<?php require 'modules/resource_workload/assets/js/resource_workload_js.php';?>
</body>
</html>
