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
            unset($data['draft']);
        }

        if(isset($data['perform'])) {
            unset($data['perform']);
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
            unset($data['draft']);
        }

        if(isset($data['perform'])) {
            unset($data['perform']);
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

    public function add_perform_inspection($data, $label, $id)
    {
        if ($label == "setting_out") {
            $this->add_setting_out($data, $label, $id);
        } else if($label == "excavation") {
            $this->add_excavation($data, $label, $id);
        } else if($label == "anti_termite") {
            $this->add_anti_termite($data, $label, $id);
        } else if($label == "reinforcement") {
            $this->add_reinforcement($data, $label, $id);
        } 
    }

    public function update_perform_inspection($data, $label, $id, $checklist_id)
    {
        if ($label == "setting_out") {
            $this->update_setting_out($data, $label, $id, $checklist_id);
        } else if($label == "excavation") {
            $this->update_excavation($data, $label, $id, $checklist_id);
        } else if($label == "anti_termite") {
            $this->update_anti_termite($data, $label, $id, $checklist_id);
        } else if($label == "reinforcement") {
            $this->update_reinforcement($data, $label, $id, $checklist_id);
        }
    }

    public function get_checklist_data($label, $id)
    {
        if (is_numeric($id)) {
            $this->db->where('inspection_id', $id);
            return $this->db->get(db_prefix() . $label)->result_array();
        }
    }

    public function add_setting_out($data, $label, $id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');
        $data['inspection_id'] = $id;
        $this->db->insert(db_prefix() . $label, $data);
        $insert_id = $this->db->insert_id();
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $insert_id;
    }

    public function update_setting_out($data, $label, $id, $checklist_id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $this->db->where('id', $checklist_id);
        $this->db->update(db_prefix().$label, $data);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $checklist_id;
    }

    public function close_inspection($id, $status)
    {
        $data = array();
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $data);
    }

    public function add_excavation($data, $label, $id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        $uploadedFiles5 = array();
        if(isset($_FILES['attachment5'])) {
            $uploadedFiles5 = handle_quality_attachments_array($label, $id, 'attachment5');
        }

        $uploadedFiles6 = array();
        if(isset($_FILES['attachment6'])) {
            $uploadedFiles6 = handle_quality_attachments_array($label, $id, 'attachment6');
        }

        $uploadedFiles7 = array();
        if(isset($_FILES['attachment7'])) {
            $uploadedFiles7 = handle_quality_attachments_array($label, $id, 'attachment7');
        }

        $uploadedFiles8 = array();
        if(isset($_FILES['attachment8'])) {
            $uploadedFiles8 = handle_quality_attachments_array($label, $id, 'attachment8');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        if(!empty($uploadedFiles5)) {
            $data['attachment5'] = $uploadedFiles5[0]['file_name'];
        }

        if(!empty($uploadedFiles6)) {
            $data['attachment6'] = $uploadedFiles6[0]['file_name'];
        }

        if(!empty($uploadedFiles7)) {
            $data['attachment7'] = $uploadedFiles7[0]['file_name'];
        }

        if(!empty($uploadedFiles8)) {
            $data['attachment8'] = $uploadedFiles8[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');
        $data['inspection_id'] = $id;
        $this->db->insert(db_prefix() . $label, $data);
        $insert_id = $this->db->insert_id();
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $insert_id;
    }

    public function update_excavation($data, $label, $id, $checklist_id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        $uploadedFiles5 = array();
        if(isset($_FILES['attachment5'])) {
            $uploadedFiles5 = handle_quality_attachments_array($label, $id, 'attachment5');
        }

        $uploadedFiles6 = array();
        if(isset($_FILES['attachment6'])) {
            $uploadedFiles6 = handle_quality_attachments_array($label, $id, 'attachment6');
        }

        $uploadedFiles7 = array();
        if(isset($_FILES['attachment7'])) {
            $uploadedFiles7 = handle_quality_attachments_array($label, $id, 'attachment7');
        }

        $uploadedFiles8 = array();
        if(isset($_FILES['attachment8'])) {
            $uploadedFiles8 = handle_quality_attachments_array($label, $id, 'attachment8');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        if(!empty($uploadedFiles5)) {
            $data['attachment5'] = $uploadedFiles5[0]['file_name'];
        }

        if(!empty($uploadedFiles6)) {
            $data['attachment6'] = $uploadedFiles6[0]['file_name'];
        }

        if(!empty($uploadedFiles7)) {
            $data['attachment7'] = $uploadedFiles7[0]['file_name'];
        }

        if(!empty($uploadedFiles8)) {
            $data['attachment8'] = $uploadedFiles8[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $this->db->where('id', $checklist_id);
        $this->db->update(db_prefix().$label, $data);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $checklist_id;
    }

    public function add_anti_termite($data, $label, $id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        $uploadedFiles5 = array();
        if(isset($_FILES['attachment5'])) {
            $uploadedFiles5 = handle_quality_attachments_array($label, $id, 'attachment5');
        }

        $uploadedFiles6 = array();
        if(isset($_FILES['attachment6'])) {
            $uploadedFiles6 = handle_quality_attachments_array($label, $id, 'attachment6');
        }

        $uploadedFiles7 = array();
        if(isset($_FILES['attachment7'])) {
            $uploadedFiles7 = handle_quality_attachments_array($label, $id, 'attachment7');
        }

        $uploadedFiles8 = array();
        if(isset($_FILES['attachment8'])) {
            $uploadedFiles8 = handle_quality_attachments_array($label, $id, 'attachment8');
        }

        $uploadedFiles9 = array();
        if(isset($_FILES['attachment9'])) {
            $uploadedFiles9 = handle_quality_attachments_array($label, $id, 'attachment9');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        if(!empty($uploadedFiles5)) {
            $data['attachment5'] = $uploadedFiles5[0]['file_name'];
        }

        if(!empty($uploadedFiles6)) {
            $data['attachment6'] = $uploadedFiles6[0]['file_name'];
        }

        if(!empty($uploadedFiles7)) {
            $data['attachment7'] = $uploadedFiles7[0]['file_name'];
        }

        if(!empty($uploadedFiles8)) {
            $data['attachment8'] = $uploadedFiles8[0]['file_name'];
        }

        if(!empty($uploadedFiles9)) {
            $data['attachment9'] = $uploadedFiles9[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');
        $data['inspection_id'] = $id;
        $this->db->insert(db_prefix() . $label, $data);
        $insert_id = $this->db->insert_id();
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $insert_id;
    }

    public function update_anti_termite($data, $label, $id, $checklist_id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        $uploadedFiles5 = array();
        if(isset($_FILES['attachment5'])) {
            $uploadedFiles5 = handle_quality_attachments_array($label, $id, 'attachment5');
        }

        $uploadedFiles6 = array();
        if(isset($_FILES['attachment6'])) {
            $uploadedFiles6 = handle_quality_attachments_array($label, $id, 'attachment6');
        }

        $uploadedFiles7 = array();
        if(isset($_FILES['attachment7'])) {
            $uploadedFiles7 = handle_quality_attachments_array($label, $id, 'attachment7');
        }

        $uploadedFiles8 = array();
        if(isset($_FILES['attachment8'])) {
            $uploadedFiles8 = handle_quality_attachments_array($label, $id, 'attachment8');
        }

        $uploadedFiles9 = array();
        if(isset($_FILES['attachment9'])) {
            $uploadedFiles9 = handle_quality_attachments_array($label, $id, 'attachment9');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        if(!empty($uploadedFiles5)) {
            $data['attachment5'] = $uploadedFiles5[0]['file_name'];
        }

        if(!empty($uploadedFiles6)) {
            $data['attachment6'] = $uploadedFiles6[0]['file_name'];
        }

        if(!empty($uploadedFiles7)) {
            $data['attachment7'] = $uploadedFiles7[0]['file_name'];
        }

        if(!empty($uploadedFiles8)) {
            $data['attachment8'] = $uploadedFiles8[0]['file_name'];
        }

        if(!empty($uploadedFiles9)) {
            $data['attachment9'] = $uploadedFiles9[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $this->db->where('id', $checklist_id);
        $this->db->update(db_prefix().$label, $data);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $checklist_id;
    }

    public function add_reinforcement($data, $label, $id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        $uploadedFiles5 = array();
        if(isset($_FILES['attachment5'])) {
            $uploadedFiles5 = handle_quality_attachments_array($label, $id, 'attachment5');
        }

        $uploadedFiles6 = array();
        if(isset($_FILES['attachment6'])) {
            $uploadedFiles6 = handle_quality_attachments_array($label, $id, 'attachment6');
        }

        $uploadedFiles7 = array();
        if(isset($_FILES['attachment7'])) {
            $uploadedFiles7 = handle_quality_attachments_array($label, $id, 'attachment7');
        }

        $uploadedFiles8 = array();
        if(isset($_FILES['attachment8'])) {
            $uploadedFiles8 = handle_quality_attachments_array($label, $id, 'attachment8');
        }

        $uploadedFiles9 = array();
        if(isset($_FILES['attachment9'])) {
            $uploadedFiles9 = handle_quality_attachments_array($label, $id, 'attachment9');
        }

        $uploadedFiles10 = array();
        if(isset($_FILES['attachment10'])) {
            $uploadedFiles10 = handle_quality_attachments_array($label, $id, 'attachment10');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        if(!empty($uploadedFiles5)) {
            $data['attachment5'] = $uploadedFiles5[0]['file_name'];
        }

        if(!empty($uploadedFiles6)) {
            $data['attachment6'] = $uploadedFiles6[0]['file_name'];
        }

        if(!empty($uploadedFiles7)) {
            $data['attachment7'] = $uploadedFiles7[0]['file_name'];
        }

        if(!empty($uploadedFiles8)) {
            $data['attachment8'] = $uploadedFiles8[0]['file_name'];
        }

        if(!empty($uploadedFiles9)) {
            $data['attachment9'] = $uploadedFiles9[0]['file_name'];
        }

        if(!empty($uploadedFiles10)) {
            $data['attachment10'] = $uploadedFiles10[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');
        $data['inspection_id'] = $id;
        $this->db->insert(db_prefix() . $label, $data);
        $insert_id = $this->db->insert_id();
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $insert_id;
    }

    public function update_reinforcement($data, $label, $id, $checklist_id)
    {
        $uploadedFiles1 = array();
        if(isset($_FILES['attachment1'])) {
            $uploadedFiles1 = handle_quality_attachments_array($label, $id, 'attachment1');
        }

        $uploadedFiles2 = array();
        if(isset($_FILES['attachment2'])) {
            $uploadedFiles2 = handle_quality_attachments_array($label, $id, 'attachment2');
        }

        $uploadedFiles3 = array();
        if(isset($_FILES['attachment3'])) {
            $uploadedFiles3 = handle_quality_attachments_array($label, $id, 'attachment3');
        }

        $uploadedFiles4 = array();
        if(isset($_FILES['attachment4'])) {
            $uploadedFiles4 = handle_quality_attachments_array($label, $id, 'attachment4');
        }

        $uploadedFiles5 = array();
        if(isset($_FILES['attachment5'])) {
            $uploadedFiles5 = handle_quality_attachments_array($label, $id, 'attachment5');
        }

        $uploadedFiles6 = array();
        if(isset($_FILES['attachment6'])) {
            $uploadedFiles6 = handle_quality_attachments_array($label, $id, 'attachment6');
        }

        $uploadedFiles7 = array();
        if(isset($_FILES['attachment7'])) {
            $uploadedFiles7 = handle_quality_attachments_array($label, $id, 'attachment7');
        }

        $uploadedFiles8 = array();
        if(isset($_FILES['attachment8'])) {
            $uploadedFiles8 = handle_quality_attachments_array($label, $id, 'attachment8');
        }

        $uploadedFiles9 = array();
        if(isset($_FILES['attachment9'])) {
            $uploadedFiles9 = handle_quality_attachments_array($label, $id, 'attachment9');
        }

        $uploadedFiles10 = array();
        if(isset($_FILES['attachment10'])) {
            $uploadedFiles10 = handle_quality_attachments_array($label, $id, 'attachment10');
        }

        if(!empty($uploadedFiles1)) {
            $data['attachment1'] = $uploadedFiles1[0]['file_name'];
        }

        if(!empty($uploadedFiles2)) {
            $data['attachment2'] = $uploadedFiles2[0]['file_name'];
        }

        if(!empty($uploadedFiles3)) {
            $data['attachment3'] = $uploadedFiles3[0]['file_name'];
        }

        if(!empty($uploadedFiles4)) {
            $data['attachment4'] = $uploadedFiles4[0]['file_name'];
        }

        if(!empty($uploadedFiles5)) {
            $data['attachment5'] = $uploadedFiles5[0]['file_name'];
        }

        if(!empty($uploadedFiles6)) {
            $data['attachment6'] = $uploadedFiles6[0]['file_name'];
        }

        if(!empty($uploadedFiles7)) {
            $data['attachment7'] = $uploadedFiles7[0]['file_name'];
        }

        if(!empty($uploadedFiles8)) {
            $data['attachment8'] = $uploadedFiles8[0]['file_name'];
        }

        if(!empty($uploadedFiles9)) {
            $data['attachment9'] = $uploadedFiles9[0]['file_name'];
        }

        if(!empty($uploadedFiles10)) {
            $data['attachment10'] = $uploadedFiles10[0]['file_name'];
        }

        $idata = array();
        if(isset($data['draft'])) {
            $idata['status'] = 1;
            unset($data['draft']);
        }

        if(isset($data['submit'])) {
            $idata['status'] = 2;
            unset($data['submit']);
        }

        $this->db->where('id', $checklist_id);
        $this->db->update(db_prefix().$label, $data);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inspections', $idata);
        return $checklist_id;
    }
}
