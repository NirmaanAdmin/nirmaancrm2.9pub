<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_110 extends App_module_migration
{
    public function up()
    {
        add_option('subscription_product_notify_days', '["7","3"]');
        add_option('subscription_product_public', '0');
        create_email_template('Your subscription will be renewed soon !', '<span> Hello {contact_firstname} ,&nbsp;</span><br /><br />Your Subscription will be expiring soon. Details below.<br /><br />view link : {subscription_link}<br /><br /><br />Kind Regards<br /><br /><span>{email_signature}</span>', 'subscriptions', 'subscription renewal notification (Sent to customer)', 'subscription-products-to-customer');

        $CI = &get_instance();
        if (!$CI->db->field_exists('created_from', 'subscription_products')) {
            $CI->load->dbforge();
            $fields =  array(
                'created_from' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE
                )
            );
            $CI->dbforge->add_column('subscription_products', $fields);
        }

        if (!$CI->db->field_exists('last_notified', 'subscriptions')) {
            $CI->load->dbforge();
            $fields =  array(
                'last_notified' => array(
                    'type' => 'DATE',
                    'null' => TRUE
                )
            );
            $CI->dbforge->add_column('subscriptions', $fields);
        }

        $this->update_products();
    }

    public function update_products()
    {
        $CI = &get_instance();
        $CI->db->set('created_from', get_staff_user_id());
        $CI->db->where('created_from IS NULL', null , false);
        $CI->db->update(db_prefix() . 'subscription_products');
    }
}
