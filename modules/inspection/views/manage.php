<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="<?php echo admin_url('inspection/create_inspection'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_inspection'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <?php render_datatable(array(
                        [
                            'name'     => '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="tasks"><label></label></div>',
                            'th_attrs' => ['class' => 'visible'],
                        ],
                        _l('the_number_sign'),
                        _l('name'),
                        _l('status'),
                        _l('created_date'),
                        _l('done_by'),
                        _l('tags'),
                        ),'inspections'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-inspections', window.location.href, [6], [6]);
        $('.table-inspections').DataTable().on('draw', function() {
            
        })
    });
</script>
</body>
</html>
