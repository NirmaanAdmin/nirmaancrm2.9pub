<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4>
              <i class="fa fa-street-view menu-icon"></i> <?php echo  _l('workplace_mgt'); ?>                
            </h4>
            <div class="horizontal-scrollable-tabs  mb-5">
              <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
              <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
              <div class="horizontal-tabs mb-4">
                <ul class="nav nav-tabs nav-tabs-horizontal">
                  <?php
                  foreach($tab as $gr){
                    ?>
                    <li<?php if($gr == $group){echo " class='active'"; } ?>>
                    <a href="<?php echo admin_url('timesheets/workplace_mgt?group='.$gr); ?>" data-group="<?php echo html_entity_decode($gr); ?>">
                      <?php
                      if($gr == 'workplace_assign'){ ?>
                       <i class="fa fa-location-arrow"></i>&nbsp;
                     <?php }
                     if($gr == 'workplace'){ ?>
                      <i class="fa fa-map"></i>&nbsp;
                    <?php }
                    echo _l($gr); ?></a>
                  </li>
                  <?php
                } 
                ?>
              </ul>
            </div>
            <?php $this->load->view('workplace_mgt/includes/'.$group); ?>
          </div>

        </div>
      </div>
      <div class="clearfix"></div>

    </div>
    <div class="btn-bottom-pusher"></div>
  </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
</body>
</html>
<?php require 'modules/timesheets/assets/js/setting_js.php';?>

