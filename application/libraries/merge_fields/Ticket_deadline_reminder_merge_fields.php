<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_deadline_reminder_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Staff first name',
                'key'       => '{staff_firstname}',
                'available' => [
                    
                ],
                'templates' => [
                    'ticket-deadline-reminder',
                ],
            ],
            [
                'name'      => 'Staff last name',
                'key'       => '{staff_lastname}',
                'available' => [
                    
                ],
                'templates' => [
                    'ticket-deadline-reminder',
                ],
            ],
            [
                'name'      => 'Ticket title',
                'key'       => '{ticket_title}',
                'available' => [
                    
                ],
                'templates' => [
                    'ticket-deadline-reminder',
                ],
            ],
            [
                'name'      => 'Ticket name',
                'key'       => '{ticket_name}',
                'available' => [
                    
                ],
                'templates' => [
                    'ticket-deadline-reminder',
                ],
            ],
            [
                'name'      => 'Due date',
                'key'       => '{duedate}',
                'available' => [
                    
                ],
                'templates' => [
                    'ticket-deadline-reminder',
                ],
            ],
            [
                'name'      => 'Ticket url',
                'key'       => '{ticket_url}',
                'available' => [
                    
                ],
                'templates' => [
                    'ticket-deadline-reminder',
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
        $fields['{staff_firstname}'] =  $data->staff_firstname;
        $fields['{staff_lastname}'] =  $data->staff_lastname;
        $fields['{ticket_title}'] =  $data->ticket_title;
        $fields['{ticket_name}'] =  $data->ticket_name;
        $fields['{duedate}'] =  $data->duedate;
        $fields['{ticket_url}'] =  $data->ticket_url;

        return $fields;
    }
}

?>