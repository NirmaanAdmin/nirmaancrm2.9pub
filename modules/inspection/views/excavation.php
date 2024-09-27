<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php echo $title; ?></h4>
                        <hr class="hr-panel-heading" />
                        <?php echo form_open_multipart($this->uri->uri_string(), ['id' => 'checklist-form']); ?>

                        <?php
                        $id = (isset($result) ? $result->id : '');
                        echo form_hidden('id', $id);
                        ?>

                        <?php
                        $location = (isset($result) ? $result->location : '');
                        echo render_input('location','location', $location , 'text');
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="all_line_out_center_line_checked">1. <?php echo _l('all_line_out_center_line_checked'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question1" value="Yes" id="question1" <?php if(isset($result) && $result->question1 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question1" value="No" id="question1" <?php if(isset($result) && $result->question1 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question1" value="NA" id="question1" <?php if(isset($result) && $result->question1 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark1 = (isset($result) ? $result->remark1 : '');
                                echo render_input('remark1','remark', $remark1 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment1[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment1 != '') { ?>
                                    <a href="#"><?php echo $result->attachment1; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="architectural_drawing_valid_for_construction_received_at_site">2. <?php echo _l('architectural_drawing_valid_for_construction_received_at_site'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question2" value="Yes" id="question2" <?php if(isset($result) && $result->question2 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question2" value="No" id="question2" <?php if(isset($result) && $result->question2 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question2" value="NA" id="question2" <?php if(isset($result) && $result->question2 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark2 = (isset($result) ? $result->remark2 : '');
                                echo render_input('remark2','remark', $remark2 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment2[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment2 != '') { ?>
                                    <a href="#"><?php echo $result->attachment2; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="rcc_drawing_valid_for_construction_received_at_site">3. <?php echo _l('rcc_drawing_valid_for_construction_received_at_site'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question3" value="Yes" id="question3" <?php if(isset($result) && $result->question3 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question3" value="No" id="question3" <?php if(isset($result) && $result->question3 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question3" value="NA" id="question3" <?php if(isset($result) && $result->question3 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark3 = (isset($result) ? $result->remark3 : '');
                                echo render_input('remark3','remark', $remark3 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment3[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment3 != '') { ?>
                                    <a href="#"><?php echo $result->attachment3; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="proper_side_slopes_given">4. <?php echo _l('proper_side_slopes_given'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question4" value="Yes" id="question4" <?php if(isset($result) && $result->question4 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question4" value="No" id="question4" <?php if(isset($result) && $result->question4 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question4" value="NA" id="question4" <?php if(isset($result) && $result->question4 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark4 = (isset($result) ? $result->remark4 : '');
                                echo render_input('remark4','remark', $remark4 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment4[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment4 != '') { ?>
                                    <a href="#"><?php echo $result->attachment4; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="proper_shoring_done">5. <?php echo _l('proper_shoring_done'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question5" value="Yes" id="question5" <?php if(isset($result) && $result->question5 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question5" value="No" id="question5" <?php if(isset($result) && $result->question5 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question5" value="NA" id="question5" <?php if(isset($result) && $result->question5 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark5 = (isset($result) ? $result->remark5 : '');
                                echo render_input('remark5','remark', $remark5 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment5[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment5 != '') { ?>
                                    <a href="#"><?php echo $result->attachment5; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="other_safety_measures_taken">6. <?php echo _l('other_safety_measures_taken'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question6" value="Yes" id="question6" <?php if(isset($result) && $result->question6 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question6" value="No" id="question6" <?php if(isset($result) && $result->question6 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question6" value="NA" id="question6" <?php if(isset($result) && $result->question6 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark6 = (isset($result) ? $result->remark6 : '');
                                echo render_input('remark6','remark', $remark6 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment6[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment6 != '') { ?>
                                    <a href="#"><?php echo $result->attachment6; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="foundary_strata_levelled_properly">7. <?php echo _l('foundary_strata_levelled_properly'); ?></label>
                            </div>

                            <div class="col-md-4 form-group">
                               <input type="radio" name="question7" value="Yes" id="question7" <?php if(isset($result) && $result->question7 == "Yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question7" value="No" id="question7" <?php if(isset($result) && $result->question7 == "No"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-4 form-group">
                               <input type="radio" name="question7" value="NA" id="question7" <?php if(isset($result) && $result->question7 == "NA"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark7 = (isset($result) ? $result->remark7 : '');
                                echo render_input('remark7','remark', $remark7 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment7[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment7 != '') { ?>
                                    <a href="#"><?php echo $result->attachment7; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="any_problems_to_start_the_concrete_work">8. <?php echo _l('any_problems_to_start_the_concrete_work'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark8 = (isset($result) ? $result->remark8 : '');
                                echo render_input('remark8','remark', $remark8 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment8[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment8 != '') { ?>
                                    <a href="#"><?php echo $result->attachment8; ?></a>
                                <?php } ?>
                            </div>

                        </div>

                        <?php if($inspection_status == 0 || $inspection_status == 1) { ?>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <button type="submit" class="btn btn-info pull-right" name="submit" style="margin: 5px;"><?php echo _l('save_and_send_for_review'); ?></button>
                                    <button type="submit" class="btn btn-default pull-right" name="draft" style="margin: 5px;"><?php echo _l('save_and_finish_later'); ?></button>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if($inspection_status == 2) { ?>
                            <div class="dropdown pull-right">
                              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><?php echo _l('close_inspection'); ?>
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo admin_url('inspection/close_inspection/'.$inspection_id.'/3'); ?>"><?php echo _l('pass'); ?></a></li>
                                <li><a href="<?php echo admin_url('inspection/close_inspection/'.$inspection_id.'/4'); ?>"><?php echo _l('fail'); ?></a></li>
                              </ul>
                            </div>
                        <?php } ?>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
       appValidateForm($('form'), {
            location: 'required',
        });
    });
    </script>
</body>
</html>
