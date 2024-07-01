<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (isset($product_error)) { ?>
   <div class="alert alert-warning">
      <?php echo html_escape($product_error); ?>
   </div>
<?php } ?>
<?php echo form_open('services/products/add/invoice', array('id' => 'stripeProductsForm', 'class' => '_transaction_form')); ?>
<div class="row">
   <div class="col-md-6">
      <?php if (isset($product)) {
         echo form_hidden('id', $product->id);
      } ?>
      <?php $value = (isset($product) ? $product->name : ''); ?>
      <?php echo render_input('name', 'name', $value, 'text', [], [], '', 'ays-ignore'); ?>
      <?php $value = (isset($product) ? $product->description : ''); ?>
      <?php echo render_textarea('description', 'short_description', $value, [], [], '', 'ays-ignore'); ?>
      <?php $value = (isset($product) ? $product->long_description : ''); ?>
      <?php echo render_textarea('long_description', _l('long_description') . ' <i class="fa fa-question-circle" data-toggle="tooltip" data-title="' . _l('long_description_hint') . '"></i>', $value, [], [], '', 'ays-ignore'); ?>
   </div>
   <div class="col-md-6">
      <div class="bg-stripe mbot15">
         <?php
         $selected = (isset($product) ? $product->group : '');
         $s_attrs = array('data-show-subtext' => true);
         echo render_select('group', $groups, array('id', 'name'), 'product_group', $selected,  $s_attrs, [], '', 'ays-ignore');
         ?>
      </div>
      <div class="bg-stripe mbot15">
         <?php
         $selected = '';
         if (isset($product->client_id)) {
            $selected = (!is_null($product->client_id)) ? 'customers' : '';
         } elseif (isset($product->customer_group)) {
            $selected = (!is_null($product->customer_group)) ? 'customer_groups' : '';
         }
         $s_attrs = array('data-show-subtext' => true);
         $relations = [];
         $relations[] = array('id' => 'customers', 'name' => 'customer');
         $relations[] = array('id' => 'customer_groups', 'name' => _l('customer_group'));
         echo render_select('related_to', $relations, array('id', 'name'), 'related_to', $selected,  $s_attrs, [], '', 'ays-ignore');
         ?>

         <div id="customers">
            <div class="form-group select-placeholder">
               <label for="clientid" class="control-label"><?php echo _l('invoice_select_customer'); ?></label>
               <select id="clientid" name="clientid" data-live-search="true" data-width="100%" class="ajax-search<?php if (isset($product) && empty($product->clientid)) {
                                                                                                                     echo ' customer-removed';
                                                                                                                  } ?>" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                  <?php
                  $selected = (isset($product) ? $product->client_id : '');
                  if ($selected != '') {
                     $rel_data = get_relation_data('customer', $selected);
                     $rel_val = get_relation_values($rel_data, 'customer');
                     echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                  } ?>
               </select>
            </div>
         </div>
         <div id="customer_groups">
            <?php
            $selected = (isset($product) ? $product->customer_group : '');
            $s_attrs = array('data-show-subtext' => true);
            echo render_select('customer_group', $customers_groups, array('id', 'name'), 'customer_group', $selected,  $s_attrs, [], '', 'ays-ignore');
            ?>
         </div>
      </div>
      <?php $value = (isset($product) ? $product->price : ''); ?>
      <?php echo render_input('price', 'price', $value, 'number', [], [], '', 'ays-ignore'); ?>
      <?php
      $s_attrs = array('data-show-subtext' => true);
      foreach ($currencies as $currency) {
         if ($currency['isdefault'] == 1) {
            $s_attrs['data-base'] = $currency['id'];
         }
         if (isset($product)) {
            if ($currency['id'] == $product->currency) {
               $selected = $currency['id'];
               break;
            }
         } elseif ($currency['isdefault'] == 1) {
            $selected = $currency['id'];
         }
      }
      ?>
      <?php echo render_select('currency', $currencies, array('id', 'name', 'symbol'), 'currency', $selected,  $s_attrs, [], '', 'ays-ignore'); ?>
      <?php
      $selected = (isset($product) ? $product->tax_1 : '');
      $s_attrs = array('multiple' => true,'data-show-subtext' => true,'data-none-selected-text'=>_l('no_tax'));
      echo render_select('tax[]', $taxes, array('id', 'name','taxrate'), 'tax', $selected,  $s_attrs, [], '', 'ays-ignore');
      ?>
      <div class="bg-stripe mbot15">
         <?php
         $selected = 0;
         $selected =  (isset($product) && ($product->is_recurring == 1)) ? 1 : 0;
         $s_attrs = array('data-none-selected-text' => _l('dropdown_non_selected_tex'));
         $relations = [];
         $relations[] = array('id' => '0', 'name' => _l('no'));
         $relations[] = array('id' => '1', 'name' => _l('yes'));
         echo render_select('is_recurring', $relations, array('id', 'name'), 'is_recurring', $selected,  $s_attrs, [], '', 'ays-ignore');
         ?>
         <div id="recurring">
            <div class="col-md-6">
               <?php $value = (isset($product) && $product->is_recurring == 1 ? $product->interval : 1); ?>
               <?php echo render_input('interval', '', $value, 'number', array('min' => 1)); ?>
            </div>
            <div class="col-md-6">
               <select name="interval_type" id="interval_type" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                  <option value="day" <?php if (isset($product) && $product->is_recurring == 1 && $product->interval_type == 'day') {
                                          echo 'selected';
                                       } ?>><?php echo _l('invoice_recurring_days'); ?></option>
                  <option value="week" <?php if (isset($product) && $product->is_recurring == 1 && $product->interval_type == 'week') {
                                          echo 'selected';
                                       } ?>><?php echo _l('invoice_recurring_weeks'); ?></option>
                  <option value="month" <?php if (isset($product) && $product->is_recurring == 1 && $product->interval_type == 'month') {
                                             echo 'selected';
                                          } ?>><?php echo _l('invoice_recurring_months'); ?></option>
                  <option value="year" <?php if (isset($product) && $product->is_recurring == 1 && $product->interval_type == 'year') {
                                          echo 'selected';
                                       } ?>><?php echo _l('invoice_recurring_years'); ?></option>
               </select>
            </div>
         </div>
      </div>
   </div>
</div>
<?php if ((isset($product) && has_permission('subscriptions', '', 'edit')) || !isset($product)) { ?>
   <div class="btn-bottom-toolbar text-right">
      <button type="submit" class="btn btn-info" data-loading-text="<?php echo _l('wait_text'); ?>" data-form="#stripeProductsForm">
         <?php echo _l('save'); ?>
      </button>
   </div>
<?php } ?>
<?php echo form_close(); ?>