<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_request_to_sender_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Contact firstname',
                'key'       => '{contact_firstname}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Contact lastname',
                'key'       => '{contact_lastname}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Status',
                'key'       => '{status_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Status extra',
                'key'       => '{status_extra}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Purchase id',
                'key'       => '{purchase_id}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Purchase name',
                'key'       => '{purchase_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Project name',
                'key'       => '{project_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Purchase request link',
                'key'       => '{purchase_request_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
            [
                'name'      => 'Purchase request title',
                'key'       => '{purchase_request_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-request-to-sender',
                ],
            ],
        ];
    }

    /**
     * Merge field for appointments
     * @param  mixed $teampassword 
     * @return array
     */
    public function format($data)
    {
        $po_id = $data->pur_request_id;
        $this->ci->load->model('purchase/purchase_model');


        $fields = [];

        $this->ci->db->where('id', $po_id);

        $po = $this->ci->db->get(db_prefix() . 'pur_request')->row();


        if (!$po) {
            return $fields;
        }

        $fields['{contact_firstname}'] =  $data->contact_firstname;
        $fields['{contact_lastname}'] =  $data->contact_lastname;
        $fields['{status_name}'] =  ($po->status == 2) ? 'approved' : 'rejected';
        $fields['{status_extra}'] =  ($po->status == 2) ? 'approval' : 'rejection';
        $fields['{purchase_id}'] =  $po->pur_rq_code;
        $fields['{purchase_name}'] =  $po->pur_rq_name;
        $fields['{project_name}'] =  get_project_name_by_id($po->project_id);
        $fields['{purchase_request_title}'] = site_url('purchase/vendors_portal/pur_request/' . $po->id.'/'.$po->hash);
        $fields['{purchase_request_link}'] = site_url('purchase/vendors_portal/pur_request/' . $po->id.'/'.$po->hash);

        return $fields;
    }
}
