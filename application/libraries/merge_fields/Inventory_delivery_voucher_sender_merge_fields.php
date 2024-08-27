<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_delivery_voucher_sender_merge_fields extends App_merge_fields
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
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Commodity name',
                'key'       => '{commodity_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Project name',
                'key'       => '{project_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Invoice no',
                'key'       => '{invoice_no}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Invoice link',
                'key'       => '{invoice_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Invoice link title',
                'key'       => '{invoice_link_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Delivery voucher link title',
                'key'       => '{delivery_voucher_link_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
                ],
            ],
            [
                'name'      => 'Delivery voucher link',
                'key'       => '{delivery_voucher_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'inventory-delivery-voucher-sender',
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
        $fields['{invoice_no}'] =  $data->invoice_no;
        $fields['{invoice_link}'] =  $data->invoice_link;
        $fields['{invoice_link_title}'] =  $data->invoice_link_title;
        $fields['{delivery_voucher_link_title}'] =  $data->delivery_voucher_link_title;
        $fields['{delivery_voucher_link}'] =  $data->delivery_voucher_link;

        return $fields;
    }
}

?>