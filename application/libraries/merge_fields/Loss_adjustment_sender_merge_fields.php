<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loss_adjustment_sender_merge_fields extends App_merge_fields
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
                    'loss-adjustment-sender',
                ],
            ],
            [
                'name'      => 'Commodity name',
                'key'       => '{commodity_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'loss-adjustment-sender',
                ],
            ],
            [
                'name'      => 'Item name',
                'key'       => '{item_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'loss-adjustment-sender',
                ],
            ],
            [
                'name'      => 'Type',
                'key'       => '{type}',
                'available' => [
                    
                ],
                'templates' => [
                    'loss-adjustment-sender',
                ],
            ],
            [
                'name'      => 'Warehouse name',
                'key'       => '{warehouse_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'loss-adjustment-sender',
                ],
            ],
            [
                'name'      => 'Loss adjusment link title',
                'key'       => '{loss_adjusment_link_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'loss-adjustment-sender',
                ],
            ],
            [
                'name'      => 'Loss adjusment link',
                'key'       => '{loss_adjusment_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'loss-adjustment-sender',
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
        $fields['{item_name}'] =  $data->item_name;
        $fields['{type}'] =  $data->type;
        $fields['{warehouse_name}'] =  $data->warehouse_name;
        $fields['{loss_adjusment_link_title}'] =  $data->loss_adjusment_link_title;
        $fields['{loss_adjusment_link}'] =  $data->loss_adjusment_link;

        return $fields;
    }
}

?>