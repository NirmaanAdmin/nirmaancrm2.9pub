<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_receiving_voucher_sender_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Creator name',
                'key'       => '{creator_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'Commodity name',
                'key'       => '{commodity_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'Project name',
                'key'       => '{project_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'PO name',
                'key'       => '{po_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'PO no',
                'key'       => '{po_no}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'PO link',
                'key'       => '{po_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'PO link title',
                'key'       => '{po_link_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'Stock recieving docket title',
                'key'       => '{stock_recieving_docket_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
                ],
            ],
            [
                'name'      => 'Stock recieving docket link',
                'key'       => '{stock_recieving_docket_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-receiving-voucher-sender',
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
        $fields['{creator_name}'] =  $data->contact_firstname." ".$data->contact_lastname;
        $fields['{commodity_name}'] =  $data->commodity_name;
        $fields['{project_name}'] =  $data->project_name;
        $fields['{po_name}'] =  $data->po_name;
        $fields['{po_no}'] =  $data->po_no;
        $fields['{po_link}'] =  $data->po_link;
        $fields['{po_link_title}'] =  $data->po_link_title;
        $fields['{stock_recieving_docket_title}'] =  $data->stock_recieving_docket_title;
        $fields['{stock_recieving_docket_link}'] =  $data->stock_recieving_docket_link;

        return $fields;
    }
}

?>