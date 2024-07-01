<script>
    $(function() {
        "use strict"
        appValidateForm('#stripeProductsForm', {
            name: 'required',
            price: 'required',
            description: 'required',
            stripe_plan_id: 'required',
            currency: 'required',
            quantity: {
                required: true,
                min: 1,
            }
        });

        $('#stripeProductsForm').on('dirty.areYouSure', function() {
            $('#prorateWrapper').removeClass('hide');
        });

        $('#stripeProductsForm').on('clean.areYouSure', function() {
            $('#prorateWrapper').addClass('hide');
        });

        if ($("#related_to").val() == '') {
            $("div#customers").hide();
            $("div#customer_groups").hide();
        } else if ($("#related_to").val() == "customers") {
            $("div#customers").show();
            $("div#customer_groups").hide();
        } else if ($("#related_to").val() == "customer_groups") {
            $("div#customer_groups").show();
            $("div#customers").hide();
        }

        $("#related_to").change(function() {
            if ($(this).val() == "customers") {
                $("div#customers").show();
                $("div#customer_groups").hide();
            } else if ($(this).val() == "customer_groups") {
                $("div#customer_groups").show();
                $("div#customers").hide();
            }
        });

        if ($("#is_recurring").val() == '') {
            $("#recurring").hide();
        } else if ($("#is_recurring").val() == "0") {
            $("#recurring").hide();
        } else if ($("#is_recurring").val() == "1") {
            $("#recurring").show();
        }

        $("#is_recurring").change(function() {
            if ($(this).val() == "1") {
                $("#recurring").show();
            } else {
                $("#recurring").hide();
            }
        });

        $('#editSettings').click(function() {
            $("#modal_wrapper").load("<?php echo admin_url('services/products/modal'); ?>", {}, function() {

                $('#editSettings').button('reset');

                if ($('.modal-backdrop.fade').hasClass('in')) {
                    $('.modal-backdrop.fade').remove();
                }

                if ($('#productSettingsModal').is(':hidden')) {
                    $('#productSettingsModal').modal({
                        show: true
                    });
                }
                appValidateForm($("#productSettings-form"), {
                    subscription_product_public: "required",
                    'days[]': {
                        required: true,
                        minlength: 1
                    }

                }, function(form) {
                    $('button[type="submit"], button.close_btn').prop('disabled', true);
                    $('button[type="submit"]').html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
                    form.submit();
                }, {
                    'days[]': "Please select at least 1 day"
                });
            })
        });
    });
</script>