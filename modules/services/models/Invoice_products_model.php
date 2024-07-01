<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Invoice_products_model extends App_Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        // Invoice product table name
        $this->table = db_prefix() . 'invoice_products';

        $this->load->model('invoices_model');
        $this->load->model('subscription_products_model');
    }

    /**
     * Add new Invoice product to db
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
     * Gets a single Product from Invoice product table in db
     * @param int $id of Invoice product
     * @return object
     */
    public function get($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * updates Invoice product in db
     * @param int $id of Invoice product
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
        return $this->db->error();
    }

    /**
     * deletes Invoice product form db
     * @param int $id of Invoice product to delete
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return $this->db->error();
    }

    /**
     * gets all Invoice products in db for logged in client
     * @return array
     */
    public function get_all($category = null)
    {
        $this->load->model('client_groups_model');
        $client_id = get_client_user_id();
        $client_groups = $this->client_groups_model->get_customer_groups($client_id);


        $this->db->group_start();
        foreach ($client_groups as $cgroup) {
            $this->db->or_where('customer_group', $cgroup['groupid']);
        }
        $this->db->or_where('customer_group');
        $this->db->group_end();

        $this->db->group_start();
        $this->db->or_where('client_id', $client_id);
        $this->db->or_where('client_id');
        $this->db->group_end();

        if($category){
            $this->db->where('group', $category);
        }

        return $this->db->get($this->table)->result();
    }

    /**
     * Add new purchase
     * @param array $data array of fields
     * @return int|boolean if successfull $insertid else false if failed
     */
    public function record_purchase($data)
    {
        $this->db->insert(db_prefix() . 'product_purchase_log', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }
        return false;
    }
}
