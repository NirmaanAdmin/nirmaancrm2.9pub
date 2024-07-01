<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Show options for customers area theme enabled / disabled
 */
$enabled = get_option('ultimate_purple_theme_customers'); ?>
<div class="form-group">
    <label for="ultimate_purple_theme_customers" class="control-label clearfix">
        <h5><?= _l('Enable purple Theme for your customers?'); ?></h5>
    </label>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_ultimate_purple_theme_customers_enabled" name="settings[ultimate_purple_theme_customers]" value="1" <?= ($enabled == '1') ?' checked' : '' ?>>
        <label for="y_opt_1_ultimate_purple_theme_customers_enabled">
            <?= _l('settings_yes'); ?>
        </label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_admin-dark_theme_enabled" name="settings[ultimate_purple_theme_customers]" value="0" <?= ($enabled == '0') ?' checked' : '' ?>>
        <label for="y_opt_2_admin-dark_theme_enabled">
            <?= _l('settings_no'); ?>
        </label>
    </div>
</div>
<hr>
<!-- <hr> -->
<!-- Select Color -->
<div class="form-group">
    <label for="ultimate_purple_theme_customers_colors" class="control-label clearfix">
        <h5>Choose the colors of your theme:</h5><br>
    </label>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3 d_flex">
                <label class="t_s_color" for="favcolor">Primary color: </label>
                <input class="input-color-picker" type="color" data-id="u_t_primary_color" id="u_t_primary_color" name="settings[u_t_primary_color]" value="<?php echo get_option('u_t_primary_color'); ?>"><br>                
            </div>
            <div class="col-md-3 d_flex">
                <label class="t_s_color" for="favcolor">Secondary color: </label>
                <input class="input-color-picker2" type="color" data-id="u_t_secondary_color" id="u_t_secondary_color" name="settings[u_t_secondary_color]" value="<?php echo get_option('u_t_secondary_color'); ?>"><br>
            </div>
        </div>
    </div>
</div>