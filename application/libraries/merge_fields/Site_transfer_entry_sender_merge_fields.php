<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Site_transfer_entry_sender_merge_fields extends App_merge_fields
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
                    'site-transfer-entry-sender',
                ],
            ],
            [
                'name'      => 'Commodity name',
                'key'       => '{commodity_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'site-transfer-entry-sender',
                ],
            ],
            [
                'name'      => 'From stock name',
                'key'       => '{from_stock_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'site-transfer-entry-sender',
                ],
            ],
            [
                'name'      => 'To stock name',
                'key'       => '{to_stock_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'site-transfer-entry-sender',
                ],
            ],
            [
                'name'      => 'Site transfer link title',
                'key'       => '{site_transfer_link_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'site-transfer-entry-sender',
                ],
            ],
            [
                'name'      => 'Site transfer link',
                'key'       => '{site_transfer_link}',
                'available' => [
                    
                ],
                'templates' => [
                    'site-transfer-entry-sender',
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
        $fields['{from_stock_name}'] =  $data->from_stock_name;
        $fields['{to_stock_name}'] =  $data->to_stock_name;
        $fields['{site_transfer_link_title}'] =  $data->site_transfer_link_title;
        $fields['{site_transfer_link}'] =  $data->site_transfer_link;

        return $fields;
    }
}

?>