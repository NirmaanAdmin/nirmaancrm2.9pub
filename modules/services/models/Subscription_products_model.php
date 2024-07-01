<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Subscription_products_model extends App_Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        // subscription product table name
        $this->table = db_prefix() . 'subscription_products';
        $this->load->model('subscriptions_model');
    }

    /**
     * Add new subscription product to db
     * @param array $data array of fields
     * @return int|boolean if successfull $insertid else false if failed
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    /**
     * Gets a single Product from subscription product table in db
     * @param int $id of subscription product
     * @return object
     */
    public function get($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * updates subscription product in db
     * @param int $id of subscription product
     * @param data array of fields to edit
     * @return boolean
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * deletes subscription product form db
     * @param int $id of subscription product to delete
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * gets all subscription products in db for logged in client
     * @return array
     */
    public function get_all($category = null)
    {
        $this->load->model('client_groups_model');
        $client_id = get_client_user_id();
        $client_groups = $this->client_groups_model->get_customer_groups($client_id);


        $this->db->group_start();
        foreach ($client_groups as $group) {
            $this->db->or_where('customer_group', $group['groupid']);
        }
        $this->db->or_where('customer_group');
        $this->db->group_end();

        $this->db->group_start();
        $this->db->or_where('client_id', $client_id);
        $this->db->or_where('client_id');
        $this->db->group_end();

        if ($category) {
            $this->db->where('group', $category);
        }

        return $this->db->get($this->table)->result();
    }

    public function send_email_template($id, $cc = '', $template = 'subscription_products_to_customer')
    {
        $subscription = $this->subscriptions_model->get_by_id($id);

        $contact = $this->clients_model->get_contact(get_primary_contact_user_id($subscription->clientid));

        if (!$contact) {
            return false;
        }

        $sent = send_mail_template($template, 'services', $subscription, $contact, $cc);

        return $sent ? true : false;
    }

    function get_group($id = null, $order = false)
    {
        if (is_numeric($id)) {
            return $this->db->get(db_prefix() . 'products_groups')->row();
        }

        if ($order) {
            $this->db->order_by('order', 'ASC');
            $this->db->order_by('id', 'ASC');
        }

        return $this->db->get(db_prefix() . 'products_groups')->result();
    }

    function create_group($data)
    {
        $this->db->insert('products_groups', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }
        return false;
    }

    function update_group($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('products_groups', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    function delete_group($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('products_groups');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
}
