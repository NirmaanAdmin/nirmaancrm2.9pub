<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_order_to_approver_merge_fields extends App_merge_fields
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
                    'purchase-order-to-approver',
                ],
            ],
            [
                'name'      => 'Contact lastname',
                'key'       => '{contact_lastname}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-order-to-approver',
                ],
            ],
            [
                'name'      => 'Po id',
                'key'       => '{po_id}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-order-to-approver',
                ],
            ],
            [
                'name'      => 'PO name',
                'key'       => '{po_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-order-to-approver',
                ],
            ],
            [
                'name'      => 'Project name',
                'key'       => '{project_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-order-to-approver',
                ],
            ],
            [
                'name'      => 'Purchase order link',
                'key'       => '{purchase_order_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-order-to-approver',
                ],
            ],
            [
                'name'      => 'Purchase order title',
                'key'       => '{purchase_order_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'purchase-order-to-approver',
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
        $po_id = $data->po_id;
        $this->ci->load->model('purchase/purchase_model');


        $fields = [];

        $this->ci->db->where('id', $po_id);

        $po = $this->ci->db->get(db_prefix() . 'pur_orders')->row();


        if (!$po) {
            return $fields;
        }

        $fields['{contact_firstname}'] =  $data->contact_firstname;
        $fields['{contact_lastname}'] =  $data->contact_lastname;
        $fields['{po_id}'] =  $po->pur_order_number;
        $fields['{po_name}'] =  $po->pur_order_name;
        $fields['{project_name}'] =  get_project_name_by_id($po->project_id);
        $fields['{purchase_order_title}'] = site_url('purchase/vendors_portal/pur_order/' . $po->id.'/'.$po->hash);
        $fields['{purchase_order_link}'] = site_url('purchase/vendors_portal/pur_order/' . $po->id.'/'.$po->hash);

        return $fields;
    }
}
