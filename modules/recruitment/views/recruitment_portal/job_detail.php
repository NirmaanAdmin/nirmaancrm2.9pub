<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php hooks()->do_action('app_customers_portal_head'); ?>

        <div class="panel_s">
            <div class="panel-body">
                <!-- job , and company infor -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title bold campaign-title"><?php echo html_entity_decode($rec_campaingn->campaign_name) ?></h2>

                                <h6 class="card-title bold  duration-title <?php if(strtotime(date("Y-m-d")) > strtotime($rec_campaingn->cp_to_date)){echo 'text-danger' ;}else{ echo 'text-muted' ;} ?> "><?php echo _l('duration') ?>: <?php echo html_entity_decode($rec_campaingn->cp_from_date.' - '.$rec_campaingn->cp_to_date); ?></h6>

                                <?php if($rec_campaingn->display_salary == 1){ ?>
                                            
                                    <h5 class="card-title bold text-muted "><?php echo _l('monthly_salary') ?> <span class="bold"><?php echo html_entity_decode(app_format_money($rec_campaingn->cp_salary_from,'').' - '.app_format_money($rec_campaingn->cp_salary_to,'')) ?></span></h5>

                                         
                                <?php } ?>

                                <h5 class="card-title bold text-muted "><?php echo _l('job_position') ?>: <span class="label label-success"><?php echo html_entity_decode($rec_campaingn->position_name) ?></span></h5>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?php if(isset($rec_campaingn->company_id) && ($rec_campaingn->company_id != '0')){ ?>
                        <div class="row no-gutters">
                            <div class="col-md-8">
                                <div class="card text-right">
                                    <div class="card-body">
                                        <h3 class="card-title bold company-title"><?php echo html_entity_decode($rec_campaingn->company_name) ?></h3>
                                        <h5 class="card-title bold text-muted"><?php echo html_entity_decode($rec_campaingn->company_address) ?></h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img class="images_w_table_detail card-img" src="<?php echo html_entity_decode(site_url($rec_campaingn->company_logo)) ?>" alt="<?php echo html_entity_decode($rec_campaingn->alt_logo) ?>">

                            </div>

                        </div>
                        <?php } ?>

                    </div>
                </div>
                <hr>
                <!-- action -->
                <div class="row">

                    <div class="col-md-12 ">
                        <div class="row button-action-row">
                    <?php if(!(strtotime(date("Y-m-d")) > strtotime($rec_campaingn->cp_to_date))){?>
                        <?php if($rec_channel){ ?>
                        <div class="card text-left buton-margin">
                          <div class="card-body">

                                    <a class="btn btn-success" href="<?php echo site_url('recruitment/forms/wtl/'.$rec_campaingn->cp_id.'/'.$rec_channel->form_key); ?>" target="_blank"><i class="fa fa-paper-plane"></i><?php echo _l('apply_now') ?></a>

                          </div>
                        </div>
                        <?php } ?>
                                    
                    <?php } ?>

                        <div class="card text-left buton-margin">
                            <div class="card-body">
                                <a class="btn btn-default" href="mailto:" target="_blank"><i class="fa fa-envelope"></i><?php echo _l('email_to_friend') ?></a>
                            </div>
                        </div>

                        <div class="card text-right buton-margin">
                              <div class="card-body">
                                <a href="<?php echo site_url('recruitment/recruitment_portal') ?>" class="btn btn-default appointment_go_back"><?php echo _l('go_back') ?></a>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">
                <div class="panel_s">
                    <div class="panel-body">
                            
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title  bold company-title"><?php echo _l('job_description') ?></h3>
                                <p class="card-text"><?php echo html_entity_decode($rec_campaingn->cp_job_description) ?></p>

                            </div>
                        </div>

                        <!-- job skill -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title  bold company-title"><?php echo _l('skill_recquired') ?></h3>

                            <?php if(isset($rec_campaingn->rec_job_skill)){ ?>
                                <?php if(count($rec_campaingn->rec_job_skill) >0) {?>
                                    <?php foreach ($rec_campaingn->rec_job_skill as $value) {?>
                                        <button type="button" class="btn btn-primary"><?php echo html_entity_decode($value['skill_name']) ?></button>

                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                            </div>
                        </div>


                    </div>
                </div>

                <!-- job related  start-->
    <?php if(isset($rec_campaingn->job_in_company)){ ?>
        <?php if(count($rec_campaingn->job_in_company) > 0){ ?>

            <h3 class="card-title  bold company-title"><?php echo _l('related_jobs') ?></h3>
        <div class="panel_s">
            <div class="panel-body" id="panel_body_job">

            <?php foreach ($rec_campaingn->job_in_company as $rec_value) { ?>
                <div class="job" id="job_68268">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="job_content_related col-md-12">

                                    <div class="job-company-logo col-md-2">
                                        <img class="images_w_table_detail" src="<?php echo html_entity_decode(site_url($rec_value['company_logo'])) ?>" alt="<?php echo html_entity_decode($rec_value['alt_logo']) ?>">
                                    </div>
                              
                                    <div class="job__description_detail col-md-6">
                                        <div class="job__body">
                                            <div class="details">
                                                <h3 class="title h3-job-related"><a class="bold a-color" data-controller="utm-tracking" href="<?php echo site_url('recruitment/recruitment_portal/job_detail/'.$rec_value['cp_id']) ?>"><?php echo html_entity_decode($rec_value['campaign_name']) ?></a>
                                                </h3>

                                                <div class="salary not-signed-in">
                                                    
                                                    <a class="view-salary text-muted " data-toggle="modal" data-target="#sign-in-modal" rel="nofollow" href="#"><?php echo html_entity_decode(_l($rec_value['company_name'])) ?></a>
                                                </div>

                                                <div class="salary not-signed-in">

                                                    <div class="job-bottom">
                                                        <div class="tag-list ">
                                                            <?php if($rec_value['cp_form_work']){ ?>
                                                                <a class="job__skill ilabel mkt-track <?php echo html_entity_decode($rec_value['cp_form_work']) ?>-color" data-controller="utm-tracking" href="#">
                                                                    <span>
                                                                    <?php echo _l($rec_value['cp_form_work']) ?>
                                                                    </span>
                                                                </a>
                                                            <?php } ?>

                                                            <a class="job__skill ilabel-cp-workplace  mkt-track " data-controller="utm-tracking" href="#">

                                                                <span> - <?php echo html_entity_decode($rec_value['cp_workplace']) ?></span>
                                                            </a>
                                                            
                                                        </div>
                                                        
                                                    </div>

                                                </div>

                                                <div class="salary not-signed-in">
                                                    
                                                    <h5 class="view-salary bold " data-toggle="modal" data-target="#sign-in-modal" rel="nofollow" href="#"><?php echo html_entity_decode(_l($rec_value['position_name'])) ?></h5>
                                                </div>


                                                <div class="job-description">
                                                    
                                                    <p>
                                                    <?php echo html_entity_decode($rec_value['cp_job_description'].' ...') ?>
                                                        
                                                    </p>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>

                                    <div class="city_and_posted_date hidden-xs col-md-3">
                                        <div class="feature-view_detail_related new text ">
                                            <a class="bold a-color text-uppercase" data-controller="utm-tracking" href="<?php echo site_url('recruitment/recruitment_portal/job_detail/'.$rec_value['cp_id']) ?>"><?php echo _l('view_detail') ?></a>
                                        </div>

                                        <?php  if(strtotime(date("Y-m-d")) > strtotime($rec_value['cp_to_date'])){?>
                                            <div class="feature new text "><?php echo _l('overdue') ?></div>
                                        <?php }else{ ?>
                                            <div class=""></div>
                                        <?php } ?>

                                        <div class="distance-time-job-posted">
                                            <span class="distance-time highlight">
                                            <?php echo html_entity_decode($rec_value['cp_from_date'].' - '.$rec_value['cp_to_date']); ?>
                                            </span>
                                        </div>
                                    </div>

                            </div>
                        </div>

                          </div>
                      </div>  
                        
                </div>
            <?php } ?>

                
            </div>
        </div>
    <?php } ?>
<?php } ?>
    <!-- job related  end-->


            </div>
        
            <div class="col-md-4">
                <div class="panel_s">
                    <div class="panel-body">

                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title bold company-title"><?php echo _l('job_detail') ?></h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3"> 
                                <div class="card">
                                    <div class="card-body">

                                                <h5 class="card-title bold text-muted"><?php echo _l('location_') ?></h5>
                                                <h5 class="card-title bold text-muted"><?php echo _l('company') ?></h5>
                                                <h5 class="card-title bold text-muted"><?php echo _l('type_') ?></h5>
                                                <h5 class="card-title bold text-muted"><?php echo _l('positions_') ?></h5>
                                                <h5 class="card-title bold text-muted"><?php echo _l('experience') ?></h5>
                                                <h5 class="card-title bold text-muted"><?php echo _l('degree') ?></h5>
                                                <h5 class="card-title bold text-muted"><?php echo _l('apply_before') ?></h5>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9"> 
                                <div class="card text-right ">
                                    <div class="card-body">

                                                <h5 class="card-title bold   text-warning"><?php echo html_entity_decode(isset($rec_campaingn->cp_workplace) ? $rec_campaingn->cp_workplace : '...') ?></h5>
                                                <h5 class="card-title bold  text-warning"><?php echo html_entity_decode(isset($rec_campaingn->company_name)) ? $rec_campaingn->company_name :'...' ?></h5>
                                                <h5 class="card-title bold  text-warning"><?php echo html_entity_decode(isset($rec_campaingn->cp_form_work)) ?  $rec_campaingn->cp_form_work : '...' ?></h5>
                                                <h5 class="card-title bold  text-warning"><?php echo html_entity_decode(isset($rec_campaingn->cp_position)) ? $rec_campaingn->cp_position : '...' ?></h5>
                                                <h5 class="card-title bold  text-warning"><?php echo html_entity_decode(isset($rec_campaingn->cp_experience)) ? _l($rec_campaingn->cp_experience): '...' ?></h5>
                                                <h5 class="card-title bold  text-warning"><?php echo html_entity_decode(isset($rec_campaingn->cp_literacy)) ? _l($rec_campaingn->cp_literacy) : '...' ?></h5>
                                                <h5 class="card-title bold  text-warning"><?php echo html_entity_decode($rec_campaingn->cp_to_date) ?></h5>


                                    </div>
                                </div>
                            </div>
                        </div>  


                    </div>
                </div>
            </div>

        </div>
 

<?php hooks()->do_action('app_customers_portal_footer'); ?>
