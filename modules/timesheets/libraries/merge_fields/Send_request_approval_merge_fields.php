<?php

defined('BASEPATH') or exit('No direct script access allowed');

class send_request_approval_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Approver',
                'key'       => '{approver}',
                'available' => [
                    'timesheets_attendance_mgt',
                ],
            ],
            [
                'name'      => 'Staff name',
                'key'       => '{staff_name}',
                'available' => [
                    'timesheets_attendance_mgt',
                ],
            ],
            [
                'name'      => 'Link',
                'key'       => '{link}',
                'available' => [
                    'timesheets_attendance_mgt',
                ],
            ]
        ];
    }

    /**
     * Merge field for appointments
     * @param  mixed $attendance 
     * @return array
     */
    public function format($data)
    {        
         $fields['{approver}'] = $data->approver;
         $fields['{staff_name}'] = $data->staff_name;
         $fields['{link}'] = $data->link;
        return $fields;
    }
}
