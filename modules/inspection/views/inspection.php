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
                        <?php echo form_open($this->uri->uri_string()); ?>

                        <?php
                        $project_selected = (isset($inspection) && $inspection->project_id != 0) ? $inspection->project_id : '';
                        echo render_select('project_id', $projects, array('id','name'), 'project', $project_selected);
                        ?>

                        <?php
                        $inspection_type_id = (isset($inspection) && $inspection->inspection_type_id != 0) ? $inspection->inspection_type_id : '';
                        echo render_select('inspection_type_id', $inspection_types, array('id','name'), 'inspection_type', $inspection_type_id);
                        ?>

                        <?php
                        $name = (isset($inspection) ? $inspection->name : '');
                        echo render_input('name','name', $name , 'text');
                        ?>

                        <div class="row">
                            <div class="col-md-4 form-group">
                              <label for="vendor"><?php echo _l('responsible_vendor'); ?></label>
                              <select name="vendor_id" id="vendor_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('none_selected'); ?>" >
                                  <option value=""></option>
                                  <?php foreach($vendors as $s) { ?>
                                  <option value="<?php echo html_entity_decode($s['userid']); ?>" <?php if(isset($inspection) && $inspection->vendor_id == $s['userid']){ echo 'selected'; } ?>><?php echo html_entity_decode($s['company']); ?></option>
                                    <?php } ?>
                              </select>              
                            </div>

                            <div class="col-md-4 form-group">
                              <label for="done_by"><?php echo _l('done_by'); ?></label>
                              <select name="done_by[]" id="done_by" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('none_selected'); ?>" multiple="true" data-actions-box="true">
                                  <?php foreach($members as $s) { ?>
                                  <?php
                                  $selected = array();
                                  if(!empty($inspection->done_by)) {
                                    $selected = explode(",", $inspection->done_by);
                                  }
                                  ?>
                                  <option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(in_array($s['id'], $selected)){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
                                    <?php } ?>
                              </select>              
                            </div>

                            <div class="col-md-4 form-group">
                              <label for="reviewers"><?php echo _l('reviewers'); ?></label>
                              <select name="reviewers[]" id="reviewers" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('none_selected'); ?>" multiple="true" data-actions-box="true">
                                  <?php foreach($members as $s) { ?>
                                  <?php
                                  $selected = array();
                                  if(!empty($inspection->reviewers)) {
                                    $selected = explode(",", $inspection->reviewers);
                                  }
                                  ?>
                                  <option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(in_array($s['id'], $selected)){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
                                    <?php } ?>
                              </select>              
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="repeat_every" class="control-label"><?php echo _l('inspection_repeat_every'); ?></label>
                                <select name="repeat_every" id="repeat_every" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('none_selected'); ?>">
                                   <option value=""></option>
                                   <option value="1-week" <?php if(isset($inspection) && $inspection->repeat_every == 1 && $inspection->recurring_type == 'week'){echo 'selected';} ?>><?php echo _l('week'); ?></option>
                                   <option value="2-week" <?php if(isset($inspection) && $inspection->repeat_every == 2 && $inspection->recurring_type == 'week'){echo 'selected';} ?>>2 <?php echo _l('weeks'); ?></option>
                                   <option value="1-month" <?php if(isset($inspection) && $inspection->repeat_every == 1 && $inspection->recurring_type == 'month'){echo 'selected';} ?>>1 <?php echo _l('month'); ?></option>
                                   <option value="2-month" <?php if(isset($inspection) && $inspection->repeat_every == 2 && $inspection->recurring_type == 'month'){echo 'selected';} ?>>2 <?php echo _l('months'); ?></option>
                                   <option value="3-month" <?php if(isset($inspection) && $inspection->repeat_every == 3 && $inspection->recurring_type == 'month'){echo 'selected';} ?>>3 <?php echo _l('months'); ?></option>
                                   <option value="6-month" <?php if(isset($inspection) && $inspection->repeat_every == 6 && $inspection->recurring_type == 'month'){echo 'selected';} ?>>6 <?php echo _l('months'); ?></option>
                                   <option value="1-year" <?php if(isset($inspection) && $inspection->repeat_every == 1 && $inspection->recurring_type == 'year'){echo 'selected';} ?>>1 <?php echo _l('year'); ?></option>
                                   <option value="custom" <?php if(isset($inspection) && $inspection->custom_recurring == 1){echo 'selected';} ?>><?php echo _l('recurring_custom'); ?></option>
                                </select>
                            </div>

                            <div class="col-md-8 form-group">
                              <div id="inputTagsWrapper">
                                 <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                                 <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($inspection) ? prep_tags_input(get_tags_in($inspection->id,'inspection')) : ''); ?>" data-role="tagsinput">
                              </div>
                            </div>
                        </div>

                        <div class="recurring_custom <?php if((isset($inspection) && $inspection->custom_recurring != 1) || (!isset($inspection))){echo 'hide';} ?>">
                          <div class="row">
                             <div class="col-md-6">
                                <?php $value = (isset($inspection) && $inspection->custom_recurring == 1 ? $inspection->repeat_every : 1); ?>
                                <?php echo render_input('repeat_every_custom','',$value,'number',array('min'=>1)); ?>
                             </div>
                             <div class="col-md-6">
                                <select name="repeat_type_custom" id="repeat_type_custom" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('none_selected'); ?>">
                                   <option value="day" <?php if(isset($inspection) && $inspection->custom_recurring == 1 && $inspection->recurring_type == 'day'){echo 'selected';} ?>><?php echo _l('inspection_recurring_days'); ?></option>
                                   <option value="week" <?php if(isset($inspection) && $inspection->custom_recurring == 1 && $inspection->recurring_type == 'week'){echo 'selected';} ?>><?php echo _l('inspection_recurring_weeks'); ?></option>
                                   <option value="month" <?php if(isset($inspection) && $inspection->custom_recurring == 1 && $inspection->recurring_type == 'month'){echo 'selected';} ?>><?php echo _l('inspection_recurring_months'); ?></option>
                                   <option value="year" <?php if(isset($inspection) && $inspection->custom_recurring == 1 && $inspection->recurring_type == 'year'){echo 'selected';} ?>><?php echo _l('inspection_recurring_years'); ?></option>
                                </select>
                             </div>
                          </div>
                        </div>

                        <div id="cycles_wrapper" class="<?php if(!isset($inspection) || (isset($inspection) && $inspection->recurring == 0)){echo ' hide';}?>">
                          <?php $value = (isset($inspection) ? $inspection->cycles : 0); ?>
                          <div class="form-group recurring-cycles">
                             <label for="cycles"><?php echo _l('recurring_total_cycles'); ?>
                             <?php if(isset($inspection) && $inspection->total_cycles > 0){
                                echo '<small>' . _l('cycles_passed', $inspection->total_cycles) . '</small>';
                                }
                                ?>
                             </label>
                             <div class="input-group">
                                <input type="number" class="form-control"<?php if($value == 0){echo ' disabled'; } ?> name="cycles" id="cycles" value="<?php echo $value; ?>" <?php if(isset($inspection) && $inspection->total_cycles > 0){echo 'min="'.($inspection->total_cycles).'"';} ?>>
                                <div class="input-group-addon">
                                   <div class="checkbox">
                                      <input type="checkbox"<?php if($value == 0){echo ' checked';} ?> id="unlimited_cycles">
                                      <label for="unlimited_cycles"><?php echo _l('cycles_infinity'); ?></label>
                                   </div>
                                </div>
                             </div>
                          </div>
                        </div>

                        <?php 
                        $extra_notes = (isset($inspection) ? $inspection->extra_notes : '');
                        echo render_textarea('extra_notes','extra_notes', $extra_notes); 
                        ?>

                        <button type="submit" class="btn btn-info pull-right" name="submit"><?php echo _l('save_and_send_for_review'); ?></button>
                        <button type="submit" class="btn btn-info pull-right" name="draft" style="margin-right: 10px"><?php echo _l('save_and_finish_later'); ?></button>

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
            project_id: 'required',
            inspection_type_id: 'required',
            done_by: 'required',
            reviewers: 'required',
        });
    });
    </script>
</body>
</html>
