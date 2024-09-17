<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="billing_and_shipping_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <?php $countries = get_all_countries(); ?>
                    <div class="col-md-12">
                        <div class="form-group no-mbot hide">
                            <div class="checkbox checkbox-primary checkbox-inline">
                                <input type="checkbox" id="include_shipping" name="include_shipping" checked>
                                <label for="include_shipping"><?php echo _l('shipping_address'); ?></label>
                            </div>
                        </div>
                        <div id="shipping_details">
                            <?php $value = (isset($pur_order) ? $pur_order->shipping_street : ''); ?>
                            <?php echo render_textarea('shipping_street','shipping_street',$value); ?>
                            <?php $value = (isset($pur_order) ? $pur_order->shipping_city : ''); ?>
                            <?php echo render_input('shipping_city','shipping_city',$value); ?>
                            <?php $value = (isset($pur_order) ? $pur_order->shipping_state : ''); ?>
                            <?php echo render_input('shipping_state','shipping_state',$value); ?>
                            <?php $value = (isset($pur_order) ? $pur_order->shipping_zip : ''); ?>
                            <?php echo render_input('shipping_zip','shipping_zip',$value); ?>
                            <?php $selected = (isset($pur_order) ? $pur_order->shipping_country : ''); ?>
                            <?php echo render_select('shipping_country',$countries,array('country_id',array('short_name'),'iso2'),'shipping_country',$selected); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-not-full-width">
                <a href="#" class="btn btn-info save-shipping-billing"><?php echo _l('apply'); ?></a>
            </div>
        </div>
    </div>
</div>
