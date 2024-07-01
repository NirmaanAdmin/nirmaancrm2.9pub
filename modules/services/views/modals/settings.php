<div class="modal fade" id="productSettingsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo _l('settings'); ?></h4>
            </div>
            <?php echo form_open('services/products/settings', array('id' => 'productSettings-form')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="subscription_product_public" class="control-label clearfix">
                                <?= _l('allow_non_clients_subscribe') ?>
                            </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="yes_subscription_product_public" name="subscription_product_public" value="1" <?= ($public == '1') ? 'checked' : '' ?>>
                                <label for="yes_subscription_product_public"><?= _l('yes') ?></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="no_subscription_product_public" name="subscription_product_public" value="0" <?= ($public == '0') ? 'checked' : '' ?>>
                                <label for="no_subscription_product_public"><?= _l('no') ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enable_subscription_products_view" class="control-label clearfix">
                                <?= _l('enable_subscription_products_view') ?>
                            </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="yes_enable_subscription_products_view" name="enable_subscription_products_view" value="1" <?= (get_option('enable_subscription_products_view') == '1') ? 'checked' : '' ?>>
                                <label for="yes_enable_subscription_products_view"><?= _l('yes') ?></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="no_enable_subscription_products_view" name="enable_subscription_products_view" value="0" <?= (get_option('enable_subscription_products_view') == '0') ? 'checked' : '' ?>>
                                <label for="no_enable_subscription_products_view"><?= _l('no') ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enable_invoice_products_view" class="control-label clearfix">
                                <?= _l('enable_invoice_products_view') ?>
                            </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="yes_enable_invoice_products_view" name="enable_invoice_products_view" value="1" <?= (get_option('enable_invoice_products_view') == '1') ? 'checked' : '' ?>>
                                <label for="yes_enable_invoice_products_view"><?= _l('yes') ?></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="no_enable_invoice_products_view" name="enable_invoice_products_view" value="0" <?= (get_option('enable_invoice_products_view') == '0') ? 'checked' : '' ?>>
                                <label for="no_enable_invoice_products_view"><?= _l('no') ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enable_products_more_info_button" class="control-label clearfix">
                                <?= _l('enable_products_more_info_button') ?>
                            </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="yes_enable_products_more_info_button" name="enable_products_more_info_button" value="1" <?= (get_option('enable_products_more_info_button') == '1') ? 'checked' : '' ?>>
                                <label for="yes_enable_products_more_info_button"><?= _l('yes') ?></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="no_enable_products_more_info_button" name="enable_products_more_info_button" value="0" <?= (get_option('enable_products_more_info_button') == '0') ? 'checked' : '' ?>>
                                <label for="no_enable_products_more_info_button"><?= _l('no') ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="show_product_quantity_field" class="control-label clearfix">
                                <?= _l('show_product_quantity_field') ?>
                            </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="yes_show_product_quantity_field" name="show_product_quantity_field" value="1" <?= (get_option('show_product_quantity_field') == '1') ? 'checked' : '' ?>>
                                <label for="yes_show_product_quantity_field"><?= _l('yes') ?></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="no_show_product_quantity_field" name="show_product_quantity_field" value="0" <?= (get_option('show_product_quantity_field') == '0') ? 'checked' : '' ?>>
                                <label for="no_show_product_quantity_field"><?= _l('no') ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hide_invoice_subcription_group_from_client_side" class="control-label clearfix">
                                <?= _l('hide_invoice_subcription_group_from_client_side') ?>
                            </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="yes_hide_invoice_subcription_group_from_client_side" name="hide_invoice_subcription_group_from_client_side" value="1" <?= (get_option('hide_invoice_subcription_group_from_client_side') == '1') ? 'checked' : '' ?>>
                                <label for="yes_hide_invoice_subcription_group_from_client_side"><?= _l('yes') ?></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="no_hide_invoice_subcription_group_from_client_side" name="hide_invoice_subcription_group_from_client_side" value="0" <?= (get_option('hide_invoice_subcription_group_from_client_side') == '0') ? 'checked' : '' ?>>
                                <label for="no_hide_invoice_subcription_group_from_client_side"><?= _l('no') ?></label>
                            </div>
                        </div>
                        <?php
                        $selected = array();
                        if ($db_days) {
                            $selected = array_merge($selected, $db_days);
                        }
                        $numbers = range(0, 60);
                        $days = [];
                        foreach ($numbers as $key => $number) {
                            $days[] = [
                                'value' => $key,
                                'name' => ($number > 1 ? $number . ' ' . _l('days') : ($number < 1 ? '' : $number . ' ' . _l('days'))),
                            ];
                        }
                        echo render_select('days[]', $days, array('value', 'name'), 'days_to_notify', $selected, array('multiple' => true, 'data-actions-box' => true), array(), '', '', false);
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close_btn" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    init_selectpicker();
</script>