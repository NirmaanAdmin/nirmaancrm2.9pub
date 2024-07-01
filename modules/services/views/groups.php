<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if (has_permission('subscriptions', '', 'create')) { ?>
                                <button id="new_product_groups" class="btn btn-info pull-left display-block">
                                    <?php echo _l('new_product_group'); ?>
                                </button>
                                <button id="editSettings" class="btn btn-info pull-right display-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                                    <?php echo _l('settings'); ?> <i class="fa fa-cog" aria-hidden="true"></i>
                                </button>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <?php
                        $table_data = array(
                            '#',
                            _l('name'),
                            _l('services_order'),
                        );
                        render_datatable($table_data, 'productGroups ');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_wrapper">
    <div class="modal fade" id="groupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo _l('group'); ?></h4>
                </div>
                <?php echo form_open('services/products/groups', array('id' => 'productGroup-form')); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo render_input('name', 'name', '', '', ['id' => 'groupName', 'required' => 1]);
                            echo render_input('order', 'services_order', '', 'number', ['id' => 'order', 'required' => 1]);
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
</div>
<?php init_tail();?>

<script>
    $(function() {
        initDataTable('.table-productGroups', admin_url + "services/products/table/groups", undefined, undefined);

        $('#new_product_groups').click(function() {
            if ($('#groupModal').is(':hidden')) {
                $('#groupModal').modal({
                    show: true
                });
            }
        });
    });
</script>
<?php require(module_dir_path('services', 'assets/services.php')); ?>
</body>

</html>