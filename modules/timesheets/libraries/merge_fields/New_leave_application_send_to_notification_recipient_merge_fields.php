<?php

defined('BASEPATH') or exit('No direct script access allowed');

class new_leave_application_send_to_notification_recipient_merge_fields extends App_merge_fields
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
                'name'      => 'Staff id',
                'key'       => '{staff_id}',
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
       $fields['{staff_id}'] = $data->staff_name;
       $fields['{staff_name}'] = $data->staff_name;
       $fields['{link}'] = $data->link;
       $fields['{date_time}'] = $data->date_time;
       return $fields;
   }
}
