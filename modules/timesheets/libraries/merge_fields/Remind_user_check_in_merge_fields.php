<?php

defined('BASEPATH') or exit('No direct script access allowed');

class remind_user_check_in_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Staff name',
                'key'       => '{staff_name}',
                'available' => [
                    'timesheets_attendance_mgt',
                ],
            ],
            [
                'name'      => 'Date time',
                'key'       => '{date_time}',
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
         $fields['{staff_name}'] = $data->staff_name;
         $fields['{date_time}'] = $data->date_time;
        return $fields;
    }
}
