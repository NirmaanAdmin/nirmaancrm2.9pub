<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (isset($product_error)) { ?>
   <div class="alert alert-warning">
      <?php echo html_entity_decode($product_error); ?>
   </div>
<?php } ?>
<?php echo form_open('services/products/add/subscription', array('id' => 'stripeProductsForm', 'class' => '_transaction_form')); ?>
<div class="row">
   <div class="col-md-6">
      <?php if (isset($product)) { 
         echo form_hidden('id', $product->id);
      } ?>
      <?php $value = (isset($product) ? $product->name : ''); ?>
      <?php echo render_input('name', 'subscription_name', $value, 'text', [], [], '', 'ays-ignore'); ?>
      <?php $value = (isset($product) ? $product->description : ''); ?>
      <?php echo render_textarea('description', 'subscriptions_description', $value, [], [], '', 'ays-ignore'); ?>
      <div class="form-group">
         <div class="checkbox checkbox-primary">
            <input type="checkbox" id="description_in_item" class="ays-ignore" name="description_in_item" <?php if (isset($product) && $product->description_in_item == '1') {
                                                                                                               echo ' checked';
                                                                                                            } ?>>
            <label for="description_in_item"><i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('description_in_invoice_item_help'); ?>"></i> <?php echo _l('description_in_invoice_item'); ?></label>
         </div>
      </div>
      <?php $value = (isset($product) ? $product->long_description : ''); ?>
      <?php echo render_textarea('long_description', _l('long_description' ). ' <i class="fa fa-question-circle" data-toggle="tooltip" data-title="' . _l('long_description_hint') . '"></i>', $value, [], [], '', 'ays-ignore'); ?>
      <?php $value = (isset($product) ? $product->terms : ''); ?>
      <?php echo render_textarea('terms', 'terms_and_conditions', $value, ['placeholder' => _l('subscriptions_terms_info')], [], '', 'ays-ignore'); ?>

   </div>
   <div class="col-md-6">
      <div class="bg-stripe mbot15">
         <?php
         $selected = (isset($product) ? $product->group : '');
         $s_attrs = array('data-show-subtext' => true);
         echo render_select('group', $groups, array('id', 'name'), 'group', $selected,  $s_attrs, [], '', 'ays-ignore');
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
               <select id="clientid" name="clientid" data-live-search="true" data-width="100%" class="ajax-search<?php if (isset($invoice) && empty($invoice->clientid)) {
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
      <div class="bg-stripe mbot15">
         <div class="form-group select-placeholder">
            <label for="stripe_plan_id"><?php echo _l('billing_plan'); ?></label>
            <select id="stripe_plan_id" name="stripe_plan_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('stripe_subscription_select_plan'); ?>">
               <option value=""></option>
               <?php if (isset($plans->data)) { ?>
                  <?php foreach ($plans->data as $plan) {
                     $selected = '';
                     if (isset($product) && $product->stripe_plan_id == $plan->id) {
                        $selected = ' selected';
                     }
                     $subtext = app_format_money(strcasecmp($plan->currency, 'JPY') == 0 ? $plan->amount : $plan->amount / 100, strtoupper($plan->currency));
                     if ($plan->interval_count == 1) {
                        $subtext .= ' / ' . $plan->interval;
                     } else {
                        $subtext .= ' (every ' . $plan->interval_count . ' ' . $plan->interval . 's)';
                     }
                  ?>
                     <option value="<?php echo html_escape($plan->id); ?>" data-interval-count="<?php echo html_escape($plan->interval_count); ?>" data-interval="<?php echo html_escape($plan->interval); ?>" data-amount="<?php echo html_escape($plan->amount); ?>" data-subtext="<?php echo html_escape($subtext); ?>" <?php echo html_escape($selected); ?>>
                        <?php
                        if (empty($plan->nickname)) {
                           echo '[Plan Name Not Set in Stripe, ID:' . html_escape($plan->id) . ']';
                        } else {
                           echo html_escape($plan->nickname);
                        }
                        ?>
                     </option>
                  <?php } ?>
               <?php } ?>
            </select>
         </div>
      </div>
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
         } else {

            if (isset($plan) && strtolower($currency['id']) == $plan->currency) {
               $selected = $currency['id'];
               break;
            } elseif ($currency['isdefault'] == 1) {
               $selected = $currency['id'];
            }
         }
      }
      ?>
      <?php echo render_select('currency', $currencies, array('id', 'name', 'symbol'), 'currency', $selected,  $s_attrs, [], '', 'ays-ignore'); ?>
      <div class="form-group select-placeholder">
         <label class="control-label" for="tax"><?php echo _l('tax'); ?> (Stripe)</label>
         <select class="selectpicker" data-width="100%" name="stripe_tax_id" data-none-selected-text="<?php echo _l('no_tax'); ?>">
            <option value=""></option>
            <?php foreach ($stripe_tax_rates->data as $tax) {
               if ($tax->inclusive) {
                  continue;
               }
            ?>
               <option value="<?php echo html_escape($tax->id); ?>" data-subtext="<?php echo html_escape($tax->display_name); ?>" <?php if (isset($product) && $product->stripe_tax_id == $tax->id) {
                                                                                                                                       echo ' selected';
                                                                                                                                    } ?>><?php echo html_escape($tax->percentage); ?>%</option>
            <?php } ?>
         </select>
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