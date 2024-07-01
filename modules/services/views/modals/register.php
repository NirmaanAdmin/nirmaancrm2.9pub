<div class="modal fade" id="subscriptionProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="text-uppercase register-heading"><?php echo _l('clients_register_heading'); ?></span>
                </h4>
            </div>
            <?php echo form_open('', ['id' => 'register-form-modal']); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <!-- register form -->
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="bold register-contact-info-heading"><?php echo _l('client_register_contact_info'); ?></h4>
                                <div class="form-group mtop15 register-firstname-group">
                                    <label class="control-label" for="firstname"><span class="text-danger">*</span><?php echo _l('clients_firstname'); ?></label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo set_value('firstname'); ?>">
                                    <?php echo form_error('firstname'); ?>
                                </div>
                                <div class="form-group register-lastname-group">
                                    <label class="control-label" for="lastname"><span class="text-danger">*</span><?php echo _l('clients_lastname'); ?></label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo set_value('lastname'); ?>">
                                    <?php echo form_error('lastname'); ?>
                                </div>
                                <div class="form-group register-email-group">
                                    <label class="control-label" for="email"><span class="text-danger">*</span><?php echo _l('clients_email'); ?></label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>">
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="form-group register-contact-phone-group">
                                    <label class="control-label" for="contact_phonenumber"><?php echo _l('clients_phone'); ?></label>
                                    <input type="text" class="form-control" name="contact_phonenumber" id="contact_phonenumber" value="<?php echo set_value('contact_phonenumber'); ?>">
                                </div>
                                <div class="form-group register-website-group">
                                    <label class="control-label" for="website"><?php echo _l('client_website'); ?></label>
                                    <input type="text" class="form-control" name="website" id="website" value="<?php echo set_value('website'); ?>">
                                </div>
                                <div class="form-group register-position-group">
                                    <label class="control-label" for="title"><?php echo _l('contact_position'); ?></label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title'); ?>">
                                </div>
                                <div class="form-group register-password-group">
                                    <label class="control-label" for="password"><span class="text-danger">*</span><?php echo _l('clients_register_password'); ?></label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <?php echo form_error('password'); ?>
                                </div>
                                <div class="form-group register-password-repeat-group">
                                    <label class="control-label" for="passwordr"><span class="text-danger">*</span><?php echo _l('clients_register_password_repeat'); ?></label>
                                    <input type="password" class="form-control" name="passwordr" id="passwordr">
                                    <?php echo form_error('passwordr'); ?>
                                </div>
                                <div class="register-contact-custom-fields">
                                    <?php echo render_custom_fields('contacts', '', array('show_on_client_portal' => 1)); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="bold register-company-info-heading"><?php echo _l('client_register_company_info'); ?></h4>
                                <div class="form-group mtop15 register-company-group">
                                    <label class="control-label" for="company">
                                        <?php if (get_option('company_is_required') == 1) { ?>
                                            <span class="text-danger">*</span>
                                        <?php } ?>
                                        <?php echo _l('clients_company'); ?>
                                    </label>
                                    <input type="text" class="form-control" name="company" id="company" value="<?php echo set_value('company'); ?>">
                                    <?php echo form_error('company'); ?>
                                </div>
                                <?php if (get_option('company_requires_vat_number_field') == 1) { ?>
                                    <div class="form-group register-vat-group">
                                        <label class="control-label" for="vat"><?php echo _l('clients_vat'); ?></label>
                                        <input type="text" class="form-control" name="vat" id="vat" value="<?php echo set_value('vat'); ?>">
                                    </div>
                                <?php } ?>
                                <div class="form-group register-company-phone-group">
                                    <label class="control-label" for="phonenumber"><?php echo _l('clients_phone'); ?></label>
                                    <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo set_value('phonenumber'); ?>">
                                </div>
                                <div class="form-group register-country-group">
                                    <label class="control-label" for="lastname"><?php echo _l('clients_country'); ?></label>
                                    <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" data-live-search="true" name="country" class="form-control" id="country">
                                        <option value=""></option>
                                        <?php foreach (get_all_countries() as $country) { ?>
                                            <option value="<?php echo $country['country_id']; ?>" <?php if (get_option('customer_default_country') == $country['country_id']) {
                                                                                                        echo ' selected';
                                                                                                    } ?> <?php echo set_select('country', $country['country_id']); ?>><?php echo $country['short_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group register-city-group">
                                    <label class="control-label" for="city"><?php echo _l('clients_city'); ?></label>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city'); ?>">
                                </div>
                                <div class="form-group register-address-group">
                                    <label class="control-label" for="address"><?php echo _l('clients_address'); ?></label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address'); ?>">
                                </div>
                                <div class="form-group register-zip-group">
                                    <label class="control-label" for="zip"><?php echo _l('clients_zip'); ?></label>
                                    <input type="text" class="form-control" name="zip" id="zip" value="<?php echo set_value('zip'); ?>">
                                </div>
                                <div class="form-group register-state-group">
                                    <label class="control-label" for="state"><?php echo _l('clients_state'); ?></label>
                                    <input type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state'); ?>">
                                </div>
                                <div class="register-company-custom-fields">
                                    <?php echo render_custom_fields('customers', '', array('show_on_client_portal' => 1)); ?>
                                </div>
                            </div>
                            <?php if (is_gdpr() && get_option('gdpr_enable_terms_and_conditions') == 1) { ?>
                                <div class="col-md-12 register-terms-and-conditions-wrapper">
                                    <div class="text-center">
                                        <div class="checkbox">
                                            <input type="checkbox" name="accept_terms_and_conditions" id="accept_terms_and_conditions" <?php echo set_checkbox('accept_terms_and_conditions', 'on'); ?>>
                                            <label for="accept_terms_and_conditions">
                                                <?php echo _l('gdpr_terms_agree', terms_url()); ?>
                                            </label>
                                        </div>
                                        <?php echo form_error('accept_terms_and_conditions'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (get_option('use_recaptcha_customers_area') == 1 && get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != '') { ?>
                                <div class="col-md-12 register-recaptcha">
                                    <div class="g-recaptcha" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>"></div>
                                    <?php echo form_error('g-recaptcha-response'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div id="hidden-field"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" autocomplete="off" class="btn btn-info"><?php echo _l('continue'); ?></button>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>


<script>
    "use strict"

    $(".servicesForm").submit(function(e) {
        $(this).show();
        $('#hidden-field').html("");
        e.preventDefault();
        $.each($(this).find(':input'), function(index, field) {
            if (index > 0)
                $(field).clone().appendTo('#hidden-field').addClass('hidden');
        });

        $('#subscriptionProduct').modal({
            show: true
        });

    });

    $(() => {
        $('#register-form-modal').appFormValidator({
            rules: {
                firstname: "required",
                lastname: 'required',
                email: {
                    <?php if (hooks()->apply_filters('contact_email_required', "true") === "true") { ?>
                        required: true,
                    <?php } ?>
                    email: true,
                    // Use this hook only if the contacts are not logging into the customers area and you are not using support tickets piping.
                    <?php if (hooks()->apply_filters('contact_email_unique', "true") === "true") { ?>
                        remote: {
                            url: admin_url + "misc/contact_email_exists",
                            type: 'post',
                            data: {
                                email: function() {
                                    return $('#register-form-modal input[name="email"]').val();
                                },
                            }
                        }
                    <?php } ?>
                },
                company: {
                    required: {
                        depends: function() {
                            return <?php echo get_option('company_is_required') == 1 ? 1 : 0 ?>
                        }
                    },
                },
                password: "required",
                passwordr: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    remote: "<?php echo  _l('email_exists') ?>"
                }
            }
        });
    });
</script>