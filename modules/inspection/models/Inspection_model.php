<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inspection_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_inspection_types()
    {
       $inspection_types = $this->db->query('select id, name from '.db_prefix().'inspection_types')->result_array();
       return $inspection_types;
    }

    public function get_vendor($id = '', $where = [])
    {
        $this->db->select(implode(',', prefixed_table_fields_array(db_prefix() . 'pur_vendor')) . ',' . get_sql_select_vendor_company());

        $this->db->join(db_prefix() . 'countries', '' . db_prefix() . 'countries.country_id = ' . db_prefix() . 'pur_vendor.country', 'left');
        $this->db->join(db_prefix() . 'pur_contacts', '' . db_prefix() . 'pur_contacts.userid = ' . db_prefix() . 'pur_vendor.userid AND is_primary = 1', 'left');

        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
            $this->db->where($where);
        }

        if (is_numeric($id)) {

            $this->db->where(db_prefix().'pur_vendor.userid', $id);
            $vendor = $this->db->get(db_prefix() . 'pur_vendor')->row();

            if ($vendor && get_option('company_requires_vat_number_field') == 0) {
                $vendor->vat = null;
            }


            return $vendor;

        }

        $this->db->order_by('company', 'asc');

        return $this->db->get(db_prefix() . 'pur_vendor')->result_array();
    }

    public function get_staffs() 
    {
        $this->db->select(db_prefix() . 'staff.staffid as id, CONCAT(firstname," ",lastname) AS name', FALSE);
        $staffs = $this->db->get(db_prefix() . 'staff')->result_array();
        return $staffs;
    }

    /**
     * Add new inspection
     * @param mixed $data All $_POST data
     * @return mixed
     */
    public function add($data)
    {
        if(isset($data['done_by'])) {
            $data['done_by'] = implode(',', $data['done_by']);
        } else {
            $data['done_by'] = NULL;
        }

        if(isset($data['reviewers'])) {
            $data['reviewers'] = implode(',', $data['reviewers']);
        } else {
            $data['reviewers'] = NULL;
        }

        if (isset($data['repeat_every']) && $data['repeat_every'] != '') {
            $data['recurring'] = 1;
            if ($data['repeat_every'] == 'custom') {
                $data['repeat_every']     = $data['repeat_every_custom'];
                $data['recurring_type']   = $data['repeat_type_custom'];
                $data['custom_recurring'] = 1;
            } else {
                $_temp                    = explode('-', $data['repeat_every']);
                $data['recurring_type']   = $_temp[1];
                $data['repeat_every']     = $_temp[0];
                $data['custom_recurring'] = 0;
            }
        } else {
            $data['recurring']    = 0;
            $data['repeat_every'] = null;
        }

        if (isset($data['repeat_type_custom']) && isset($data['repeat_every_custom'])) {
            unset($data['repeat_type_custom']);
            unset($data['repeat_every_custom']);
        }

        $tags = '';
        if (isset($data['tags'])) {
            $tags = $data['tags'];
            unset($data['tags']);
        }

        if(isset($data['draft'])) {
            $data['status'] = 0;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $data['status'] = 1;
            unset($data['submit']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');

        $this->db->insert(db_prefix() . 'inspections', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            handle_tags_save($tags, $insert_id, 'inspection');
            log_activity('New Inspection Added [ID:' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * @param  integer (optional)
     * @return object
     * Get single inspection
     */
    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'inspections')->row();
        }

        return $this->db->get(db_prefix() . 'inspections')->result_array();
    }

    /**
     * Update inspection
     * @param  mixed $data All $_POST data
     * @param  mixed $id inspection id
     * @return boolean
     */
    public function update($data, $id)
    {
        if(isset($data['done_by'])) {
            $data['done_by'] = implode(',', $data['done_by']);
        } else {
            $data['done_by'] = NULL;
        }

        if(isset($data['reviewers'])) {
            $data['reviewers'] = implode(',', $data['reviewers']);
        } else {
            $data['reviewers'] = NULL;
        }

        $inspection = $this->get($id);
        if ($inspection->repeat_every != '' && $data['repeat_every'] == '') {
            $data['cycles']              = 0;
            $data['total_cycles']        = 0;
            $data['last_recurring_date'] = null;
        }

        if ($data['repeat_every'] != '') {
            $data['recurring'] = 1;
            if ($data['repeat_every'] == 'custom') {
                $data['repeat_every']     = $data['repeat_every_custom'];
                $data['recurring_type']   = $data['repeat_type_custom'];
                $data['custom_recurring'] = 1;
            } else {
                $_temp                    = explode('-', $data['repeat_every']);
                $data['recurring_type']   = $_temp[1];
                $data['repeat_every']     = $_temp[0];
                $data['custom_recurring'] = 0;
            }
        } else {
            $data['recurring'] = 0;
        }

        if (isset($data['repeat_type_custom']) && isset($data['repeat_every_custom'])) {
            unset($data['repeat_type_custom']);
            unset($data['repeat_every_custom']);
        }

        if (isset($data['tags'])) {
            if (handle_tags_save($data['tags'], $id, 'inspection')) {
                $affectedRows++;
            }
            unset($data['tags']);
        }

        if(isset($data['draft'])) {
            $data['status'] = 0;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $data['status'] = 1;
            unset($data['submit']);
        }

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Inspection Updated [ID:' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Delete inspection
     * @param  mixed $id inspection id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'inspections');
        if ($this->db->affected_rows() > 0) {
            log_activity('Inspection Deleted [ID:' . $id . ']');

            return true;
        }

        return false;
    }

    public function get_inspection_type($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'inspection_types')->row();
        }

        return $this->db->get(db_prefix() . 'inspection_types')->result_array();
    }
}
