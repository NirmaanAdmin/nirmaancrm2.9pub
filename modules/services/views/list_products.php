<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$group = isset($group) ? $group : '';
$showQuantity = get_option('show_product_quantity_field') == 1 ? true : false;
?>
<h3 id="greeting" class="no-mtop"></h3>
<div class="panel_s mtop25">
    <div class="panel-body">
        <ul class="nav nav-tabs no-margin " role="tablist">
            <li role="presentation" class="<?= (!$group) ? 'active' : null ?>">
                <a data-group="all_products" href="<?php echo site_url('services/'); ?>" role="tab"><i class="fa fa-th" aria-hidden="true"></i> <?php echo _l('all'); ?></a>
            </li>

            <?php if (get_option('enable_subscription_products_view') == 1) { ?>
                <li role="presentation" class="subscription_products <?= ($group && $group == 'subscriptions') ? 'active' : '' ?>">
                    <a data-group="subscription_products" href="<?php echo site_url('services/category/subscriptions'); ?>" role="tab"> <?php echo _l('subscriptions'); ?></a>
                </li>
            <?php } ?>

            <?php if (get_option('enable_invoice_products_view') == 1) { ?>
                <li role="presentation" class="invoice_products <?= (isset($group) && $group == 'invoices') ? 'active' : '' ?>">
                    <a data-group="invoice_products" href="<?php echo site_url('services/category/invoices'); ?>" role="tab"> <?php echo _l('invoice_product'); ?></a>
                </li>
            <?php } ?>

            <?php foreach ($groups as $category) { ?>
                <?php $slug = str_replace(' ', '-', strtolower($category->name)); ?>
                <li role="presentation" class="project_tab_activity <?= (($category->id == $group)) ? 'active' : '' ?>">
                    <a data-group="<?= $slug ?>" href="<?php echo site_url('services/category/' . $category->id . '/' . $slug); ?>" role="tab"><?php echo $category->name; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="panel_s mtop25">
    <div class="panel-body">
        <?php foreach ($products as $product) { ?>
            <div class="col-md-4 col-sm-6 mbot30 ">
                <div class="card panel-body">
                    <div class="card-body">
                        <h3 class="card-title mbot0"><?= html_escape($product->name) ?></h3>
                        <p class="card-text services_module"><?= html_entity_decode($product->description) ?></p>
                        <?php $slug = str_replace(' ', '-', strtolower($product->name)); ?>
                        <?php if (!isset($product->is_recurring)) { ?>
                            <?php if (get_option('enable_products_more_info_button') == 1) { ?>
                                <a href="<?= site_url('services/details/sub/' . $product->id) . '/' . $slug  ?>" class="btn btn-default btn-xs bold mtop10"><?= _l('more_info') ?></a>
                            <?php }
                            $subtext = app_format_money(strcasecmp($product->currency, 'JPY') == 0 ? $product->price : $product->price / 100, strtoupper($product->currency));
                            if ($product->count == 1) {
                                $subtext .= ' / ' . _l($product->period);
                            } else {
                                $subtext .= ' / ' . $product->count . '' . _l($product->period . 's');
                            }
                            ?>
                            <h4 class="card-text bold mtop10 "><?= html_entity_decode($subtext) ?></h4>
                            <div class="row">
                                <?= form_open(site_url('services/subscribe/'), ['class' => 'servicesForm']) ?>
                                <div class="col-md-12 mright20 mleft20">
                                    <?php echo render_custom_fields('products'); ?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <?= form_hidden('product_id', html_escape($product->id)) ?>
                                    <?= form_hidden('clientid', get_client_user_id()) ?>
                                    <?php
                                    if (!$showQuantity) {
                                        echo form_hidden('quantity', '1');
                                    } else {
                                    ?>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="quantity" min="1" id="" value="1" placeholder="<?= _l('quantity') ?>" required>
                                        </div> <?php } ?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <button type="submit" class="form-control btn btn-warning"><?= _l('subscribe') ?></button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        <?php } else {
                            $subtext = app_format_money($product->price, strtoupper($product->currency));
                            if ($product->is_recurring == 1)
                                if ($product->interval == 1) {
                                    $subtext .= ' / ' . _l($product->interval_type);
                                } else {
                                    $subtext .= ' / ' . $product->interval . '' . _l($product->interval_type . 's');
                                }

                        ?>
                            <?php if ((get_option('enable_products_more_info_button') == 1)) { ?>
                                <a href="<?= site_url('services/details/inv/' . $product->id) . '/' . $slug  ?>" class="btn btn-default btn-xs bold mtop10"><?= _l('more_info') ?></a>
                            <?php } ?>
                            <h4 class="card-text bold mtop10 "><?= html_entity_decode($subtext) ?></h4>
                            <div class="row">
                                <?= form_open(site_url('services/invoice'), ['class' => 'servicesForm']) ?>
                                <div class="col-md-12 mright20 mleft20">
                                    <?php echo render_custom_fields('products'); ?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <?= form_hidden('product_id', html_escape($product->id)) ?>
                                    <?= form_hidden('clientid', get_client_user_id()) ?>
                                    <?php
                                    if (!$showQuantity) {
                                        echo form_hidden('quantity', '1');
                                    } else {
                                    ?>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="quantity" min="1" id="" value="1" placeholder="<?= _l('quantity') ?>" required>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <button type="submit" class="form-control btn btn-warning"><?= _l('order') ?></button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    "use strict"
    var greetDate = new Date();
    var hrsGreet = greetDate.getHours();

    var greet;
    if (hrsGreet < 12)
        greet = "<?php echo _l('good_morning'); ?>";
    else if (hrsGreet >= 12 && hrsGreet <= 17)
        greet = "<?php echo _l('good_afternoon'); ?>";
    else if (hrsGreet >= 17 && hrsGreet <= 24)
        greet = "<?php echo _l('good_evening'); ?>";

    if (greet) {
        document.getElementById('greeting').innerHTML =
            '<b>' + greet + ' <?php echo html_escape($contact->firstname); ?>!</b>';
    }

    $('[data-custom-field-required="1"]').each(function(index, field) {
        $(field).attr('required', true);
    });
</script>