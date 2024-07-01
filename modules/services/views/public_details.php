<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$group = isset($group) ? $group : '';
$showQuantity = get_option('show_product_quantity_field') == 1 ? true : false;
?>
<div class="col-md-10 col-md-offset-1 col-xs-12">
    <div class="panel_s mtop25">
        <div class="panel-body">
            <h2 class="title"><?= html_escape($product->name) ?></h2>
            <div class="col-md-12">
                <div class="col-md-8 border-right">
                    <div class="services_description mbot15" style="overflow-wrap: break-word;">
                        <?= ($product->long_description) ?>
                    </div>
                    <hr>
                </div>
                <div class="col-md-4">
                    <div style="overflow-wrap: break-word;"><?= ($product->description) ?></div>
                    <?php if (!isset($product->is_recurring)) { //subscription products 
                    ?>
                        <?php
                        $subtext = app_format_money(strcasecmp($product->currency, 'JPY') == 0 ? $product->price : $product->price / 100, strtoupper($product->currency));
                        if ($product->count == 1) {
                            $subtext .= ' / ' . _l($product->period);
                        } else {
                            $subtext .= ' / ' . $product->count . '' . _l($product->period . 's');
                        }
                        ?>
                        <h4 class="ttitle bold mtop20"><?= html_entity_decode($subtext) ?></h4>
                        <div class="row text-center">
                            <?= form_open(site_url('services/subscribe/'), ['class' => 'servicesForm']) ?>
                            <div class="col-md-12 mright15 mleft20">
                                <?php echo render_custom_fields('products'); ?>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <?= form_hidden('product_id', html_escape($product->id)) ?>
                                <?= form_hidden('type', 'subscription') ?>
                                <?php
                                if (!$showQuantity) {
                                    echo  form_hidden('quantity', '1');
                                } else { ?>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="quantity" min="1" id="" value="1" placeholder="<?= _l('quantity') ?>" required>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6 col-xs-6 ">
                                <button type="submit" class="form-control btn btn-warning"><?= _l('subscribe') ?></button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    <?php } else {
                        $subtext = app_format_money($product->price, strtoupper($product->currency));
                        if ($product->is_recurring == 1) {
                            if ($product->interval == 1) {
                                $subtext .= ' / ' . _l($product->interval_type);
                            } else {
                                $subtext .= ' / ' . $product->interval . '' . _l($product->interval_type . 's');
                            }
                        }
                    ?>
                        <h4 class="card-text bold mtop10 "><?= html_entity_decode($subtext) ?></h4>
                        <div class="row">
                            <?= form_open(site_url('services/invoice'), ['class' => 'servicesForm']) ?>
                            <div class="col-md-12 mright15 mleft20">
                                <?php echo render_custom_fields('products'); ?>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <?= form_hidden('product_id', html_escape($product->id)) ?>
                                <?= form_hidden('type', 'invoice') ?>
                                <?php
                                if (!$showQuantity) {
                                    echo  form_hidden('quantity', '1');
                                } else { ?>
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
    </div>
</div>

<?php
echo $this->view('modals/register');
?>

<script>
    $('[data-custom-field-required="1"]').each(function(index, field) {
        $(field).attr('required', true);
    });

    $('div.services_description.mbot15 img').css('width', '100%')
    $('div.services_description.mbot15 img').css('height', 'auto')
</script>