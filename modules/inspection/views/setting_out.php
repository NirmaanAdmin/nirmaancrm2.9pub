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
                        <?php echo form_open_multipart($this->uri->uri_string()); ?>

                        <?php
                        $id = (isset($result) ? $result->id : '');
                        echo form_hidden('id', $id);
                        ?>

                        <?php
                        $location = (isset($result) ? $result->location : '');
                        echo render_input('location','location', $location , 'text');
                        ?>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?php
                                $surveyed_by = (isset($result) ? $result->surveyed_by : '');
                                echo render_input('surveyed_by','surveyed_by', $surveyed_by , 'text');
                                ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <?php
                                $checked_by = (isset($result) ? $result->checked_by : '');
                                echo render_input('checked_by','checked_by', $checked_by , 'text');
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?php
                                $calibration_equipment = (isset($result) ? $result->calibration_equipment : '');
                                echo render_input('calibration_equipment','calibration_equipment', $calibration_equipment , 'text');
                                ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <?php
                                $reference_drawing = (isset($result) ? $result->reference_drawing : '');
                                echo render_input('reference_drawing','reference_drawing', $reference_drawing , 'text');
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="boundary_line">1. <?php echo _l('boundary_line'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="boundary_line" value="checked" id="boundary_line" <?php if(isset($result) && $result->boundary_line == "checked"){ echo 'checked'; } ?>>
                               <label for="checked"><?php echo _l('checked'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="boundary_line" value="found_okay" id="boundary_line" <?php if(isset($result) && $result->boundary_line == "found_okay"){ echo 'checked'; } ?>>
                               <label for="found_okay"><?php echo _l('found_okay'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="boundary_line" value="not_okay" id="boundary_line" <?php if(isset($result) && $result->boundary_line == "not_okay"){ echo 'checked'; } ?>>
                               <label for="not_okay"><?php echo _l('not_okay'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="boundary_line" value="na" id="boundary_line" <?php if(isset($result) && $result->boundary_line == "na"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 form-group">
                                <?php
                                $remark_1 = (isset($result) ? $result->remark_1 : '');
                                echo render_input('remark_1','remark', $remark_1 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment1" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment1 != '') { ?>
                                    <a href="#"><?php echo $result->attachment1; ?></a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label for="back_distances_available">2. <?php echo _l('back_distances_available'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
                               <input type="radio" name="back_distances_available" value="yes" id="back_distances_available" <?php if(isset($result) && $result->back_distances_available == "yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="back_distances_available" value="no" id="back_distances_available" <?php if(isset($result) && $result->back_distances_available == "no"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="back_distances_available" value="na" id="back_distances_available" <?php if(isset($result) && $result->back_distances_available == "na"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 form-group">
                                <?php
                                $remark_2 = (isset($result) ? $result->remark_2 : '');
                                echo render_input('remark_2','remark', $remark_2 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment2" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment2 != '') { ?>
                                    <a href="#"><?php echo $result->attachment2; ?></a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label for="benchmark_available">3. <?php echo _l('benchmark_available'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
                               <input type="radio" name="benchmark_available" value="yes" id="benchmark_available" <?php if(isset($result) && $result->benchmark_available == "yes"){ echo 'checked'; } ?>>
                               <label for="yes"><?php echo _l('yes'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="benchmark_available" value="no" id="benchmark_available" <?php if(isset($result) && $result->benchmark_available == "no"){ echo 'checked'; } ?>>
                               <label for="no"><?php echo _l('no'); ?></label>
                            </div>
                            <div class="col-md-2 form-group">
                               <input type="radio" name="benchmark_available" value="na" id="benchmark_available" <?php if(isset($result) && $result->benchmark_available == "na"){ echo 'checked'; } ?>>
                               <label for="na"><?php echo _l('na'); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 form-group">
                                <?php
                                $remark_3 = (isset($result) ? $result->remark_3 : '');
                                echo render_input('remark_3','level_of_bm', $remark_3 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment3" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment3 != '') { ?>
                                    <a href="#"><?php echo $result->attachment3; ?></a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 form-group">
                                <?php
                                $remark_4 = (isset($result) ? $result->remark_4 : '');
                                echo render_input('remark_4','other_remarks', $remark_4 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment4" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                </div>
                                <?php
                                if(isset($result) && $result->attachment4 != '') { ?>
                                    <a href="#"><?php echo $result->attachment4; ?></a>
                                <?php } ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info pull-right"><?php echo _l('save'); ?></button>
                        <a href="<?php echo admin_url('inspection'); ?>" class="btn btn-default pull-right" style="margin-right: 10px"><?php echo _l('close'); ?></a>
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
