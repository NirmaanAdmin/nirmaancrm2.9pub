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

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?php
                                $dwg_no = (isset($result) ? $result->dwg_no : '');
                                echo render_input('dwg_no','dwg_no', $dwg_no , 'text');
                                ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <?php
                                $revision_no = (isset($result) ? $result->revision_no : '');
                                echo render_input('revision_no','revision_no', $revision_no , 'text');
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="grade_of_steel">1. <?php echo _l('grade_of_steel'); ?></label>
                            </div>

                            <div class="col-md-3 form-group">
                               <input type="radio" name="question1" value="Fe415" id="question1" <?php if(isset($result) && $result->question1 == "Fe415"){ echo 'checked'; } ?>>
                               <label for="fe415"><?php echo _l('fe415'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
                               <input type="radio" name="question1" value="Fe500" id="question1" <?php if(isset($result) && $result->question1 == "Fe500"){ echo 'checked'; } ?>>
                               <label for="fe500"><?php echo _l('fe500'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
                               <input type="radio" name="question1" value="Other" id="question1" <?php if(isset($result) && $result->question1 == "Other"){ echo 'checked'; } ?>>
                               <label for="Other"><?php echo _l('Other'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment1") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="diameter_of_main_steel">2. <?php echo _l('diameter_of_main_steel'); ?></label>
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment2") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="is_surface_of_steel_free_from_cracks">3. <?php echo _l('is_surface_of_steel_free_from_cracks'); ?></label>
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment3") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="dia_of_stirrups">4. <?php echo _l('dia_of_stirrups'); ?></label>
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment4") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="bar_bending_schedule">5. <?php echo _l('bar_bending_schedule'); ?></label>
                            </div>

                            <div class="col-md-3 form-group">
                               <input type="radio" name="question5" value="Approved" id="question5" <?php if(isset($result) && $result->question5 == "Approved"){ echo 'checked'; } ?>>
                               <label for="approved"><?php echo _l('approved'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
                               <input type="radio" name="question5" value="Prepare but not approved" id="question5" <?php if(isset($result) && $result->question5 == "Prepare but not approved"){ echo 'checked'; } ?>>
                               <label for="prepare_but_not_approved"><?php echo _l('prepare_but_not_approved'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
                               <input type="radio" name="question5" value="Not Prepared" id="question5" <?php if(isset($result) && $result->question5 == "Not Prepared"){ echo 'checked'; } ?>>
                               <label for="not_prepared"><?php echo _l('not_prepared'); ?></label>
                            </div>
                            <div class="col-md-3 form-group">
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment5") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="lap_length">6. <?php echo _l('lap_length'); ?></label>
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment6") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="cover_to_reinforcement">7. <?php echo _l('cover_to_reinforcement'); ?></label>
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment7") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="positioning_of_bars">8. <?php echo _l('positioning_of_bars'); ?></label>
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
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment8") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="rigidity_of_bars">9. <?php echo _l('rigidity_of_bars'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark9 = (isset($result) ? $result->remark9 : '');
                                echo render_input('remark9','remark', $remark9 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment9[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment9") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="binding_wire">10. <?php echo _l('binding_wire'); ?></label>
                            </div>

                            <div class="col-md-7 form-group">
                                <?php
                                $remark10 = (isset($result) ? $result->remark10 : '');
                                echo render_input('remark10','remark', $remark10 , 'text');
                                ?>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="attachment"><?php echo _l('attachment'); ?></label>
                                <div class="input-group">
                                    <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachment10[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>" multiple="true">
                                </div>
                                <?php
                                if(isset($result) && !empty($result->attachments)) {
                                    foreach ($result->attachments as $key => $value) { 
                                        if($value['attachment_name'] == "attachment10") { ?>
                                        <span class="inline-block label" style="color:#764abc;border:1px solid #764abc;margin: 2px;"><?php echo $value['file_name']; ?>
                                            <div class="inline-block mleft5">
                                                <a href="<?php echo admin_url('inspection/delete_inspection_file/'.$label.'/'.$value['id']); ?>" style="font-size:14px;vertical-align:middle;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            </div>
                                        </span>
                                <?php } } } ?>
                            </div>

                        </div>

                        <?php 
                        $extra_notes = (isset($result) ? $result->extra_notes : '');
                        echo render_textarea('extra_notes','extra_notes', $extra_notes); 
                        ?>

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
            dwg_no: 'required',
        });
    });
    </script>
</body>
</html>
