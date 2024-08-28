<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WebApi extends ClientsController
{
    public function save_staff()
    {
        $result = array();
        if ($this->input->post()) {
            $data = $this->input->post();
            $firstname = isset($data['firstname']) ? $data['firstname'] : '';
            $lastname = isset($data['lastname']) ? $data['lastname'] : '';
            $email = isset($data['email']) ? $data['email'] : '';
            $data['password'] = 'Nirmaan@123';
            $data['send_welcome_email'] = 'on';
            $data['role'] = isset($data['role']) ? $data['role'] : 1;
            $permissions = json_encode($this->roles_model->get($data['role'])->permissions);
            $data['permissions'] = json_decode($permissions, TRUE);

            if(empty($firstname) || empty($lastname) || empty($email)) {
                $result['status'] = 400;
                $result['message'] = "Required data have not found.";
            } else {
                $this->db->where('email', $email);
                $emailVal = $this->db->get(db_prefix() . 'staff')->row();
                if ($emailVal) {
                    $result['status'] = 400;
                    $result['message'] = "Email already exists.";
                } else {
                    $id = $this->staff_model->add($data);
                    if ($id) {
                        $result['status'] = 200;
                        $result['message'] = "Staff have added.";
                    } else {
                        $result['status'] = 400;
                        $result['message'] = "Something went wrong.";
                    }
                }
            }
        } else {
            $result['status'] = 400;
            $result['message'] = "Data have not found.";
        }
        echo json_encode($result);
    }

    public function save_vendor()
    {
        $this->db->query("ALTER TABLE `tblpur_vendor` CHANGE `address` `address` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $path = base_url('assets/uploads/vendors.csv');

        $file = fopen($path, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
          $single = array();
          $single = $line;
          if(!empty($single)) {
            $data = array();
            $data['company'] = $single[1];
            $data['address'] = $single[2];
            $data['vat'] = $single[5];
            $data['country'] = 102;
            $pos = strpos($single[3], 'Applicable');
            if ($pos === false) {
                $data['state'] = $single[3];
            }
            $data['datecreated'] = date('Y-m-d H:i:s');
            $data['addedfrom'] = 1;
            $this->db->insert(db_prefix() . 'pur_vendor', $data);
          }
        }
        fclose($file);
        echo "Success";
        die();
    }
}