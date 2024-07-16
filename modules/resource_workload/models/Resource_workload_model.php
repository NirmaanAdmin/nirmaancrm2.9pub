<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This class describes a resource workload model.
 */
class Resource_workload_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Gets the data workload.
     *
     * @param      object  $data_fill  The data fill
     *
     * @return     array   The data workload.
     */
    public function get_data_workload($data_fill, $only_data = false)
    {
        if($data_fill['to_date'] == ''){
            $from_date = date('Y-m-d');
        }else{
            $from_date   = $data_fill['from_date'];
            if (!$this->check_format_date($from_date)) {
                $from_date = to_sql_date($data_fill['from_date']);
            }
        }
        if($data_fill['to_date'] == ''){
            $to_date = date('Y-m-d');
        }else{
            $to_date   = $data_fill['to_date'];
            if (!$this->check_format_date($to_date)) {
                $to_date = to_sql_date($data_fill['to_date']);
            }
        }

        $staffsTasksWhere = '';

        $where_project = '';
        if (isset($data_fill['project'])) {
            foreach ($data_fill['project'] as $key => $value) {
                if ($where_project == '') {
                    $where_project = '(rel_type = "project" and rel_id = ' . $value . ')';
                } else {
                    $where_project .= ' or (rel_type = "project" and rel_id = ' . $value . ')';
                }
            }
            if ($where_project != '') {
                $staffsTasksWhere .= ' and (' . $where_project . ') ';
            }
        }
        $list_staffids           = $this->get_staff_workload($data_fill, true);
        $staffsTasks      = $this->get_staff_task_workload($data_fill, $staffsTasksWhere);
        $staffsTasks_recurring      = $this->get_staff_workload_recurring($data_fill, $staffsTasksWhere);
        $staffsTasks_recurring_ids = [];
        foreach ($staffsTasks_recurring as $key => $task) {
            if(in_array($task['taskid'], $staffsTasks_recurring_ids)){
                continue;
            }
        	$node = [];
        	$type                = $task['recurring_type'];
            $repeat_every        = $task['repeat_every'];
            $last_recurring_date = $task['last_recurring_date'];
            $task_date           = $task['startdate'];
            $cycles = $task['cycles'];
            $total_cycles = $task['total_cycles'];
            // Current date
            $date = new DateTime(date('Y-m-d'));
            while ($total_cycles <= $cycles) {
	            // Check if is first recurring
	            if (!$last_recurring_date) {
	                $last_recurring_date = date('Y-m-d', strtotime($task_date));
	            } else {
	                $last_recurring_date = date('Y-m-d', strtotime($last_recurring_date));
	            }

	            $re_create_at = date('Y-m-d', strtotime('+' . $repeat_every . ' ' . strtoupper($type), strtotime($last_recurring_date)));
	            if ($to_date >= $re_create_at) {
		            $node = $task;
		            $node['startdate'] = $re_create_at;
	                $last_recurring_date = $node['startdate'];
                    $node['taskid'] = 0;
	                $overwrite_params = [
	                    'startdate'           => $re_create_at,
	                    'status'              => hooks()->apply_filters('recurring_task_status', 1),
	                    'recurring_type'      => null,
	                    'repeat_every'        => 0,
	                    'cycles'              => 0,
	                    'recurring'           => 0,
	                    'custom_recurring'    => 0,
	                    'last_recurring_date' => null,
	                    'is_recurring_from'   => $task['taskid'],
	                ];

	                if (!empty($task['duedate'])) {
	                    $dStart                      = new DateTime($task['startdate']);
	                    $dEnd                        = new DateTime($task['duedate']);
	                    $dDiff                       = $dStart->diff($dEnd);
		            	$node['duedate'] = date('Y-m-d', strtotime('+' . $dDiff->days . ' days', strtotime($re_create_at)));
	                }
	                   $staffsTasks[] = $node;
	            }else{
		        	$total_cycles++;
	            }
	            if($cycles != 0){
		        	$total_cycles++;
	            }
	        }
            $staffsTasks_recurring_ids[] =  $task['taskid'];
        }
        $data             = [];
        $data_overload    = [];
        $data_timesheets_return  = [];
        $data_tooltip_2   = [];
        $data_tooltip     = [];
        $total_capacity   = 0;
        $total_estimate   = 0;
        $total_spent_time = 0;
        $task_from_date = $from_date;
        $task_to_date = $to_date;
        $data_array = [];
        $data_assigned = [];
        foreach ($staffsTasks as $key => $value) {
            if(strtotime($task_from_date) > strtotime($value['startdate']) && $value['startdate'] != ''){
                $task_from_date = $value['startdate'];
            }

            if(strtotime($task_to_date) < strtotime($value['duedate']) && $value['duedate'] != ''){
                $task_to_date = $value['duedate'];
            }

            $data_assigned[$value['taskid']][] = $value['staffid'];
            $data_assigned[$value['taskid']] = array_unique($data_assigned[$value['taskid']]);

            if(isset($data_array[$value['staffid'].'_'.$value['taskid']]) && $value['taskid'] != 0){
                if(isset($value['total_logged_time'])){
                    $data_array[$value['staffid'].'_'.$value['taskid']]['taskstimers'][] = ['total_logged_time' => $value['total_logged_time'], 'start_time' => date('Y-m-d', strtotime(to_sql_date(_dt($value['start_time'], true), true))), 'end_time' => date('Y-m-d', strtotime(to_sql_date(_dt($value['end_time'], true), true)))];
                }
            }else{
                $node = [];
                $node['staffid'] = $value['staffid'];
                $node['full_name'] = $value['full_name'];
                $node['role_name'] = $value['role_name'];
                $node['name'] = $value['name'];
                $node['department_name'] = $value['department_name'];
                $node['taskid'] = $value['taskid'];
                $node['startdate'] = $value['startdate'];
                $node['duedate'] = $value['duedate'];
                $node['datefinished'] = $value['datefinished'];
                $node['estimate_hour'] = $value['estimate_hour'];

                if(isset($value['total_logged_time']) && $value['taskid'] != 0){
                    $node['taskstimers'][] = ['total_logged_time' => $value['total_logged_time'], 'start_time' => date('Y-m-d', strtotime(to_sql_date(_dt($value['start_time'], true), true))), 'end_time' => date('Y-m-d', strtotime(to_sql_date(_dt($value['end_time'], true), true)))];
                }
                if($value['taskid'] != 0){
                    $data_array[$value['staffid'].'_'.$value['taskid']] = $node;
                }else{
                    $data_array[$value['taskid'].'_'.$key] = $node;
                }
            }
        }
        
        $standard_workload_by_list_staff = $this->get_standard_workload_by_list_staff($list_staffids, $task_from_date, $task_to_date);
        $standard_workload = $standard_workload_by_list_staff['standard_workload'];
        $data_timesheets = $standard_workload_by_list_staff['data_timesheets'];
        $date_working = $this->check_range_date_working($list_staffids, $task_from_date, $task_to_date);
        foreach ($data_array as $key => $value) {
            $staffid = $value['staffid'];
            if (!isset($data[$staffid]['capacity'])) {
                $data[$staffid]['staff_id']   = $value['staffid'];
                $data[$staffid]['staff_name'] = $value['full_name'];
                $data[$staffid]['staff_role'] = $value['role_name'];
                $data[$staffid]['capacity']   = $this->get_total_standard_workload($standard_workload, $date_working[$staffid], $value['staffid'], $from_date, $to_date);
                $total_capacity += $data[$staffid]['capacity'];
                $data[$staffid]['staff_department'] = $value['department_name'];
                
                $data[$staffid] = $this->create_array_data_workload($from_date, $to_date, $data[$staffid]);
                if ($only_data == false) {
                    $data_tooltip_2[$staffid] = $this->create_array_data_tooltip_workload($data_timesheets, $value['staffid'], $from_date, $to_date, []);
                }
            }
            if(!is_numeric($value['taskid'])){
                continue;
            }
            if ($value['duedate'] == '') {
                if ($value['datefinished'] == '') {
                    $value['duedate'] = date('Y-m-d');
                } else {
                    $value['duedate'] = date('Y-m-d', strtotime($value['datefinished']));
                }
            }
            $note        = [];
            $taskstimers = [];
            $total_time  = [];
            if(isset($value['taskstimers'])){
                $total_time  = $value['taskstimers'];

                foreach ($total_time as $t) {
                    if ($t['end_time'] == $t['start_time']) {
                        if (isset($taskstimers[$t['end_time']])) {
                            $taskstimers[$t['end_time']] += $t['total_logged_time'];
                        } else {
                            $taskstimers[$t['end_time']] = $t['total_logged_time'];
                        }
                    } else {
                        $n_day  = $this->get_number_day($date_working[$staffid], $t['start_time'], $t['end_time']);
                        
                        if($n_day == 0){
                            continue;
                        }
                        
                        $s_date = $t['start_time'];
                        $e_date = $t['end_time'];

                        while (strtotime($s_date) <= strtotime($e_date)) {
                            if (isset($taskstimers[$s_date])) {
                                $taskstimers[$s_date] += $t['total_logged_time'] / $n_day;
                            } else {
                                $taskstimers[$s_date] = $t['total_logged_time'] / $n_day;
                            }

                            $s_date = date('Y-m-d', strtotime('+1 day', strtotime($s_date)));
                        }
                    }
                }
            }

            foreach ($taskstimers as $keytaskstimers => $taskstimer) {
                if (isset($data[$staffid][date('d_m_Y', strtotime($keytaskstimers)) . '_s'])) {

                    $data[$staffid][date('d_m_Y', strtotime($keytaskstimers)) . '_s'] += round($taskstimer, 2);
                    if ($taskstimer > 0 && $only_data == false) {
                        $data_tooltip_2[$staffid][$value['staffid'] . '_' . date('d_m_Y', strtotime($keytaskstimers)) . '_s'] .= $value['name'] . ': ' . round($taskstimer, 2) . ' ' . _l('hours') . "\n";

                        $total_spent_time += $taskstimer;
                    }
                }
            }
            if(isset($data_assigned[$value['taskid']]) && count($data_assigned[$value['taskid']]) > 0){
                $note['estimate_hour'] = $value['estimate_hour'] / count($data_assigned[$value['taskid']]);
            }else{
                $note['estimate_hour'] = $value['estimate_hour'];
            }

            if ($note['estimate_hour'] > 0 || $total_time != []) {

                $number_day = $this->get_number_day($date_working[$staffid], $value['startdate'], $value['duedate']);

                if ($number_day > 0) {
                    $f_date = $value['startdate'];
                    $t_date = $value['duedate'];

                    $estimate_hour = $note['estimate_hour'];

                    $_estimate_hour = 0;

                    while (strtotime($f_date) <= strtotime($t_date)) {
                        $total_time = 0;
                        if (isset($taskstimers[$f_date])) {
                            $total_time = $taskstimers[$f_date];
                        }

                        if ($estimate_hour > 0 || $total_time > 0) {
                            if (isset($date_working[$staffid][$f_date]) && $date_working[$staffid][$f_date] == '1') {
                                if ($this->get_total_standard_workload($standard_workload, $date_working[$staffid], $value['staffid'], $value['startdate'], $value['duedate']) < $note['estimate_hour']) {
                                    $_estimate_hour = round($note['estimate_hour'] / ($number_day), 2);
                                } else {
                                    if ($estimate_hour >= $standard_workload[$value['staffid']][$f_date]) {
                                        $_estimate_hour = $standard_workload[$value['staffid']][$f_date];
                                        $estimate_hour = $estimate_hour - $standard_workload[$value['staffid']][$f_date];
                                    } else {
                                        $_estimate_hour = $estimate_hour;
                                        $estimate_hour  = 0;
                                    }
                                }
                                if (isset($data[$staffid][date('d_m_Y', strtotime($f_date)) . '_e'])) {
                                    $data[$staffid][date('d_m_Y', strtotime($f_date)) . '_e'] += round($_estimate_hour, 2);
                                    if ($_estimate_hour > 0 && $only_data == false) {
                                        $data_tooltip_2[$staffid][$value['staffid'] . '_' . date('d_m_Y', strtotime($f_date)) . '_e'] .= $value['name'] . ': ' . round($_estimate_hour, 2) . ' ' . _l('hours') . "\n";
                                        $total_estimate += $_estimate_hour;
                                    }
                                }

                            }
                        } else {
                            $f_date = $t_date;
                        }

                        $f_date = date('Y-m-d', strtotime('+1 day', strtotime($f_date)));
                    }
                } else {
                    if (isset($data[$staffid][date('d_m_Y', strtotime($value['startdate'])) . '_e'])) {
                        $data[$staffid][date('d_m_Y', strtotime($value['startdate'])) . '_e'] += round($note['estimate_hour'], 2);
                        if ($note['estimate_hour'] > 0 && $only_data == false) {
                            $data_tooltip_2[$staffid][$value['staffid'] . '_' . date('d_m_Y', strtotime($value['startdate'])) . '_e'] .= $value['name'] . ': ' . round($note['estimate_hour'], 2) . ' ' . _l('hours') . "\n";

                            $total_estimate += $note['estimate_hour'];
                        }
                    }
                }
            }
        }

        $data_return2 = [];
        $row          = 0;
        foreach ($data as $val) {
            $int = 5;
            if ($only_data == false) {
                foreach ($data_tooltip_2[$val['staff_id']] as $key_tooltip => $tooltip) {
                    $n            = [];
                    $n['row']     = $row;
                    $n['col']     = $int;
                    $n['comment'] = ['value' => $tooltip];
                    array_push($data_tooltip, $n);
                    $int++;
                }
            }
            $row++;
            $overload = [];
            $leave = [];
            foreach ($val as $key => $value) {
                if ($only_data == false) {
                    if (!(strpos($key, '_e') === false) || !(strpos($key, '_s') === false)) {
                        $k                 = explode('_', $key);
                        if ($standard_workload[$val['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]] < $value && $value > 0) {
                            $overload[$key] = 1;
                        }
                        if (isset($data_timesheets[$val['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]])) {
                            $leave[$key] = 1;
                        }
                    }
                }
                if (!is_array($value) && $value > 0) {
                    $val[$key] = $value . '';
                }
            }
            $data_return2[]  = $val;
            $data_overload[] = $overload;
            $data_timesheets_return[] = $leave;
        }

        $data_return                  = [];
        $data_return['data']          = $data_return2;
        $data_return['data_total']    = ['capacity' => round($total_capacity, 2), 'estimate' => round($total_estimate, 2), 'spent_time' => round($total_spent_time, 2)];
        $data_return['data_tooltip']  = $data_tooltip;
        $data_return['data_overload'] = $data_overload;
        $data_return['data_timesheets'] = $data_timesheets_return;

        return $data_return;
    }

    /**
     * Gets the data timeline.
     *
     * @param      object  $data_fill  The data fill
     *
     * @return     array   The data timeline.
     */
    public function get_data_timeline($data_fill)
    {
        $from_date = $data_fill['from_date'];
        $to_date   = $data_fill['to_date'];
        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($data_fill['from_date']);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($data_fill['to_date']);
        }
        $staffs           = $this->get_staff_workload($data_fill);
        $staffsTasksWhere = [];
        if ($from_date != '' && $to_date != '') {
            $staffsTasksWhere = 'IF(duedate IS NOT NULL,((startdate <= "' . $from_date . '" and duedate >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and duedate >= "' . $to_date . '") or (startdate > "' . $from_date . '" and duedate < "' . $to_date . '")), IF(datefinished IS NOT NULL,((startdate <= "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $to_date . '") or (startdate > "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") < "' . $to_date . '")),(startdate <= "' . $from_date . '" or (startdate > "' . $from_date . '" and startdate <= "' . $to_date . '"))))';
        } elseif ($from_date != '') {
            $staffsTasksWhere = '(startdate >= "' . $from_date . '" or IF(duedate IS NOT NULL, duedate >= "' . $from_date . '", IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '", 1=1)))';
        } elseif ($to_date != '') {
            $staffsTasksWhere = '(startdate <= "' . $to_date . '" or IF(duedate IS NOT NULL,duedate <= "' . $to_date . '",IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") <= "' . $to_date . '", 1=1)))';
        }

        if (isset($data_fill['project'])) {
            $where_project = '';
            foreach ($data_fill['project'] as $key => $value) {
                if ($where_project == '') {
                    $where_project = '(rel_type = "project" and rel_id = ' . $value . ')';
                } else {
                    $where_project .= ' or (rel_type = "project" and rel_id = ' . $value . ')';
                }
            }
            if ($where_project != '') {
                $staffsTasksWhere .= ' and (' . $where_project . ') ';
            }
        }

        $data         = [];
        $data_tooltip = [];
        $data_color   = [];
        $data_check   = [];
        foreach ($staffs as $key => $value) {
            $row          = [];
            $row['id']    = 'staff_' . $value['staffid'];
            $row['start'] = $from_date;
            $row['end']   = $to_date;
            $row['name']  = $value['full_name'];
            $data[]       = $row;

            $staff_task = $this->tasks_model->get_tasks_by_staff_id($value['staffid'], $staffsTasksWhere);
            foreach ($staff_task as $key_task => $task) {
                $note                 = [];
                $note['start']        = $task['startdate'];
                $note['progress']     = 100;
                $status               = get_task_status_by_id($task['status']);
                $note['name']         = $task['name'] . ' - ' . $status['name'];
                $note['id']           = $task['id'];
                $note['dependencies'] = 'staff_' . $value['staffid'];
                if ($task['duedate'] != null) {
                    $note['end'] = $task['duedate'];
                } else {
                    if ($task['datefinished'] == '') {
                        $note['end'] = $to_date;
                    } else {
                        $note['end'] = date('Y-m-d', strtotime($task['datefinished']));
                    }
                }
                $note['total_time']    = round(($this->tasks_model->calc_task_total_time($task['id'], ' AND staff_id=' . $value['staffid']) / 60) / 60, 2);
                $note['estimate_hour'] = round($this->get_estimate_hour($task['id']), 2);

                switch ($task['rel_type']) {
                    case 'project':
                        $note['custom_class'] = 'br_project';
                        break;
                    case 'ticket':
                        $note['custom_class'] = 'br_ticket';
                        break;
                    case 'lead':
                        $note['custom_class'] = 'br_lead';
                        break;
                    case 'customer':
                        $note['custom_class'] = 'br_customer';
                        break;
                    case 'contract':
                        $note['custom_class'] = 'br_contract';
                        break;
                    case 'invoice':
                        $note['custom_class'] = 'br_invoice';
                        break;
                    case 'estimate':
                        $note['custom_class'] = 'br_estimate';
                        break;
                    case 'proposal':
                        $note['custom_class'] = 'br_proposal';
                        break;
                }
                $data[] = $note;
            }
            $int = 4;
        }
        if ($data == []) {
            $data[][] = [];
        }
        return $data;
    }

    /**
     * Creates an array data workload.
     *
     * @param      String  $from_date  The from date format dd/mm/YYYY
     * @param      String  $to_date    To date format dd/mm/YYYY
     * @param      array   $array      The array
     *
     * @return     array
     */
    public function create_array_data_workload($from_date, $to_date, $array)
    {

        $visible = [];
        $visible[1] = get_option('staff_workload_monday_visible');
        $visible[2] = get_option('staff_workload_tuesday_visible');
        $visible[3] = get_option('staff_workload_thursday_visible');
        $visible[4] = get_option('staff_workload_wednesday_visible');
        $visible[5] = get_option('staff_workload_friday_visible');
        $visible[6] = get_option('staff_workload_saturday_visible');
        $visible[7] = get_option('staff_workload_sunday_visible');

        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }

        while (strtotime($from_date) <= strtotime($to_date)) {
            if($visible[date('N', strtotime($from_date))] == 1){
                $array[date('d_m_Y', strtotime($from_date)) . '_e'] = 0;
                $array[date('d_m_Y', strtotime($from_date)) . '_s'] = 0;
            }
            $from_date                                          = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $array;
    }

    /**
     * Creates an array data timeline.
     *
     * @param      String  $from_date  The from date format dd/mm/YYYY
     * @param      String  $to_date    To date format dd/mm/YYYY
     * @param      array   $array      The array
     *
     * @return     array
     */
    public function create_array_data_timeline($from_date, $to_date, $array)
    {
        $from_date = to_sql_date($from_date);
        $to_date   = to_sql_date($to_date);
        while (strtotime($from_date) <= strtotime($to_date)) {
            $array[date('d_m', strtotime($from_date))] = [];
            $from_date                                 = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $array;
    }

    /**
     * Creates an array data tooltip workload.
     *
     * @param      string  $staffid    The staffid
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     * @param      array   $array      The array
     *
     * @return     array
     */
    public function create_array_data_tooltip_workload($data_timesheets, $staffid, $from_date, $to_date, $array)
    {
        $visible = [];
        $visible[1] = get_option('staff_workload_monday_visible');
        $visible[2] = get_option('staff_workload_tuesday_visible');
        $visible[3] = get_option('staff_workload_thursday_visible');
        $visible[4] = get_option('staff_workload_wednesday_visible');
        $visible[5] = get_option('staff_workload_friday_visible');
        $visible[6] = get_option('staff_workload_saturday_visible');
        $visible[7] = get_option('staff_workload_sunday_visible');

        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }

        while (strtotime($from_date) <= strtotime($to_date)) {
            if($visible[date('N', strtotime($from_date))] == 1){
                if(isset($data_timesheets[$staffid][$from_date])){
                    $array[$staffid . '_' . date('d_m_Y', strtotime($from_date)) . '_e'] = _l('leave').': '.$data_timesheets[$staffid][$from_date]. ' ' . _l('hours'). "\n".'-------------------------------------------------------'. "\n";
                    $array[$staffid . '_' . date('d_m_Y', strtotime($from_date)) . '_s'] = _l('leave').': '.$data_timesheets[$staffid][$from_date]. ' ' . _l('hours'). "\n".'-------------------------------------------------------------'. "\n";
                }else{
                    $array[$staffid . '_' . date('d_m_Y', strtotime($from_date)) . '_e'] = '';
                    $array[$staffid . '_' . date('d_m_Y', strtotime($from_date)) . '_s'] = '';
                }
            }
            $from_date                                                           = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $array;
    }

    /**
     * Creates an array data tooltip timeline.
     *
     * @param      string  $staffid    The staffid
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     * @param      array   $array      The array
     *
     * @return     array
     */
    public function create_array_data_tooltip_timeline($staffid, $from_date, $to_date, $array)
    {
        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }

        while (strtotime($from_date) <= strtotime($to_date)) {
            $array[$staffid . '_' . date('d_m', strtotime($from_date))] = '';
            $from_date                                                  = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $array;
    }

    /**
     * Gets the nestedheaders workload.
     *
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     *
     * @return     array   The nestedheaders workload.
     */
    public function get_nestedheaders_workload($from_date, $to_date)
    {
        $visible = [];
        $visible[1] = get_option('staff_workload_monday_visible');
        $visible[2] = get_option('staff_workload_tuesday_visible');
        $visible[3] = get_option('staff_workload_thursday_visible');
        $visible[4] = get_option('staff_workload_wednesday_visible');
        $visible[5] = get_option('staff_workload_friday_visible');
        $visible[6] = get_option('staff_workload_saturday_visible');
        $visible[7] = get_option('staff_workload_sunday_visible');

        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }

        $nestedheaders    = [];
        $nestedheaders[0] = [['label' => _l('staff'), 'colspan' => 5]];
        $nestedheaders[1] = [_l('name'), '', _l('capacity'), _l('department'), _l('role')];
        while (strtotime($from_date) <= strtotime($to_date)) {
            if($visible[date('N', strtotime($from_date))] == 1){
                array_push($nestedheaders[0], ['label' => _l('wd_'.strtolower(date('l', strtotime($from_date)))).' '.date('d/m', strtotime($from_date)), 'colspan' => 2]);
                array_push($nestedheaders[1], 'E');
                array_push($nestedheaders[1], 'S');
            }
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $nestedheaders;
    }

    /**
     * Gets the nestedheaders timeline.
     *
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     *
     * @return     array   The nestedheaders timeline.
     */
    public function get_nestedheaders_timeline($from_date, $to_date)
    {
        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }

        $nestedheaders    = [];
        $nestedheaders[0] = [['label' => _l('staff'), 'colspan' => 4]];
        $nestedheaders[1] = [_l('name'), '', _l('department'), _l('role')];
        while (strtotime($from_date) <= strtotime($to_date)) {

            array_push($nestedheaders[1], date('l d/m', strtotime($from_date)));
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $nestedheaders;
    }

    /**
     * Gets the columns workload.
     *
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     *
     * @return     array   The columns workload.
     */
    public function get_columns_workload($from_date, $to_date)
    {
        $visible = [];
        $visible[1] = get_option('staff_workload_monday_visible');
        $visible[2] = get_option('staff_workload_tuesday_visible');
        $visible[3] = get_option('staff_workload_thursday_visible');
        $visible[4] = get_option('staff_workload_wednesday_visible');
        $visible[5] = get_option('staff_workload_friday_visible');
        $visible[6] = get_option('staff_workload_saturday_visible');
        $visible[7] = get_option('staff_workload_sunday_visible');
        
        
        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }
        $columns = [['data' => 'staff_name', 'type' => 'text', 'readOnly' => true],
            ['data' => 'staff_id', 'type' => 'text', 'readOnly' => true],
            ['data' => 'capacity', 'type' => 'text', 'readOnly' => true],
            ['data' => 'staff_department', 'type' => 'text', 'readOnly' => true],
            ['data' => 'staff_role', 'type' => 'text', 'readOnly' => true]];
        while (strtotime($from_date) <= strtotime($to_date)) {
            if($visible[date('N', strtotime($from_date))] == 1){
                array_push($columns, ['data' => date('d_m_Y', strtotime($from_date)) . '_e', 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => [
                    'pattern' => '0.00',
                ]]);
                array_push($columns, ['data' => date('d_m_Y', strtotime($from_date)) . '_s', 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => [
                    'pattern' => '0.00',
                ]]);
            }
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $columns;
    }

    /**
     * Gets the columns timeline.
     *
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     *
     * @return     array   The columns timeline.
     */
    public function get_columns_timeline($from_date, $to_date)
    {
        $from_date = to_sql_date($from_date);
        $to_date   = to_sql_date($to_date);
        $columns   = [['data' => 'staff_name', 'type' => 'text', 'readOnly' => true],
            ['data' => 'staff_id', 'type' => 'text', 'readOnly' => true],
            ['data' => 'staff_department', 'type' => 'text', 'readOnly' => true],
            ['data' => 'staff_role', 'type' => 'text', 'readOnly' => true]];
        while (strtotime($from_date) <= strtotime($to_date)) {
            array_push($columns, ['data' => date('d_m', strtotime($from_date)), 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => [
                'pattern' => '0.0',
            ]]);
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $columns;
    }

    /**
     * Gets the staff workload.
     *
     * @param      object  $data   The data
     *
     * @return     array   The staff workload.
     */
    public function get_staff_workload($data, $only_id = false)
    {
        if (isset($data['project']) && !is_array($data['project']) && $data['project'] != '') {
            $data['project'] = explode(',', $data['project']);
        }

        if (isset($data['department']) && !is_array($data['department']) && $data['department'] != '') {
            $data['department'] = explode(',', $data['department']);
        }

        if (isset($data['role']) && !is_array($data['role']) && $data['role'] != '') {
            $data['role'] = explode(',', $data['role']);
        }

        if (isset($data['staff']) && !is_array($data['staff']) && $data['staff'] != '') {
            $data['staff'] = explode(',', $data['staff']);
        }

        $where_project = '';
        if (!empty($data['project'])) {
            foreach ($data['project'] as $key => $value) {
                if ($where_project == '') {
                    $where_project .= '(('.$value . ' in (select project_id from '.db_prefix() . 'project_members where '.db_prefix() . 'project_members.staff_id = '.db_prefix().'staff.staffid))';
                } else {
                    $where_project .= ' or ('.$value . ' in (select project_id from '.db_prefix() . 'project_members where '.db_prefix() . 'project_members.staff_id = '.db_prefix().'staff.staffid))';
                }
            }
            $where_project .= ')';
        }
        $where_department = '';
        if (!empty($data['department'])) {
            foreach ($data['department'] as $key => $value) {
                if ($where_department == '') {
                    $where_department .= '(('.$value . ' in (select departmentid from '.db_prefix() . 'staff_departments where '.db_prefix() . 'staff_departments.staffid = '.db_prefix().'staff.staffid))';
                } else {
                    $where_department .= ' or ('.$value . ' in (select departmentid from '.db_prefix() . 'staff_departments where '.db_prefix() . 'staff_departments.staffid = '.db_prefix().'staff.staffid))';
                }
            }
            $where_department .= ')';
        }
        $where_role = '';
        if (!empty($data['role'])) {
            foreach ($data['role'] as $key => $value) {
                if ($where_role == '') {
                    $where_role .= '(' . db_prefix() . 'staff.role = ' . $value;
                } else {
                    $where_role .= ' or ' . db_prefix() . 'staff.role = ' . $value;
                }
            }
            $where_role .= ')';
        }
        $where_staff = '';
        if (!empty($data['staff'])) {
            foreach ($data['staff'] as $key => $value) {
                if ($where_staff == '') {
                    $where_staff .= '(' . db_prefix() . 'staff.staffid = ' . $value;
                } else {
                    $where_staff .= ' or ' . db_prefix() . 'staff.staffid = ' . $value;
                }
            }
            $where_staff .= ')';
        }

        $staff_exception = get_option('staff_workload_exception');

        $where_staff_exception = '';
        if($staff_exception != ''){
            $list_staff_exception = explode(',', $staff_exception);
            foreach ($list_staff_exception as $key => $value) {
                if($where_staff_exception == ''){
                    $where_staff_exception .= ' '.db_prefix().'staff.staffid != '.$value;
                }else{
                    $where_staff_exception .= ' and '.db_prefix().'staff.staffid != '.$value;
                }
            }
        }

        $this->db->select('*, CONCAT(firstname, \' \', lastname) as full_name,' . db_prefix() . 'staff.staffid as staffid, ' . db_prefix() . 'roles.name as role_name, (SELECT GROUP_CONCAT('.db_prefix().'departments.name SEPARATOR " ,") FROM '.db_prefix().'staff_departments JOIN '.db_prefix().'departments ON '.db_prefix().'departments.departmentid = '.db_prefix().'staff_departments.departmentid WHERE '.db_prefix().'staff_departments.staffid='.db_prefix().'staff.staffid ORDER BY '.db_prefix().'staff.staffid) as department_name');
        $this->db->join(db_prefix() . 'roles', db_prefix() . 'staff.role=' . db_prefix() . 'roles.roleid', 'left');
        if ($where_role !== '') {
            $this->db->where($where_role);
        }
        if ($where_department !== '') {
            $this->db->where($where_department);
        }
        if ($where_project !== '') {
            $this->db->where($where_project);
        }
        if ($where_staff !== '') {
            $this->db->where($where_staff);
        }

        if ($where_staff_exception !== '') {
            $this->db->where($where_staff_exception);
        }
        $this->db->where('active', 1);
        $list_staffs = $this->db->get(db_prefix() . 'staff')->result_array();
        if($only_id){
            $list_ids = [];
            foreach ($list_staffs as $key => $value) {
                $list_ids[] = $value['staffid'];
            }
            return $list_ids;
        }
        return $list_staffs;
    }

    /**
     * Gets the staff workload.
     *
     * @param      object  $data   The data
     *
     * @return     array   The staff workload.
     */
    public function get_staff_task_workload($data, $where = [])
    {

        

        $from_date = $data['from_date'];
        $to_date   = $data['to_date'];
        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($data['from_date']);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($data['to_date']);
        }

        if (isset($data['project']) && !is_array($data['project']) && $data['project'] != '') {
            $data['project'] = explode(',', $data['project']);
        }

        if (isset($data['department']) && !is_array($data['department']) && $data['department'] != '') {
            $data['department'] = explode(',', $data['department']);
        }

        if (isset($data['role']) && !is_array($data['role']) && $data['role'] != '') {
            $data['role'] = explode(',', $data['role']);
        }

        if (isset($data['staff']) && !is_array($data['staff']) && $data['staff'] != '') {
            $data['staff'] = explode(',', $data['staff']);
        }
        $where_project = '';
        if (!empty($data['project'])) {
            foreach ($data['project'] as $key => $value) {
                if ($where_project == '') {
                    $where_project .= ' and (('.$value . ' in (select project_id from '.db_prefix() . 'project_members where '.db_prefix() . 'project_members.staff_id = '.db_prefix().'staff.staffid))';
                } else {
                    $where_project .= ' or ('.$value . ' in (select project_id from '.db_prefix() . 'project_members where '.db_prefix() . 'project_members.staff_id = '.db_prefix().'staff.staffid))';
                }
            }
            $where_project .= ')';
        }
        $where_department = '';
        if (!empty($data['department'])) {
            foreach ($data['department'] as $key => $value) {
                if ($where_department == '') {
                    $where_department .= ' and (('.$value . ' in (select departmentid from '.db_prefix() . 'staff_departments where '.db_prefix() . 'staff_departments.staffid = '.db_prefix().'staff.staffid))';
                } else {
                    $where_department .= ' or ('.$value . ' in (select departmentid from '.db_prefix() . 'staff_departments where '.db_prefix() . 'staff_departments.staffid = '.db_prefix().'staff.staffid))';
                }
            }
            $where_department .= ')';
        }
        $where_role = '';
        if (!empty($data['role'])) {
            foreach ($data['role'] as $key => $value) {
                if ($where_role == '') {
                    $where_role .= ' and (' . db_prefix() . 'staff.role = ' . $value;
                } else {
                    $where_role .= ' or ' . db_prefix() . 'staff.role = ' . $value;
                }
            }
            $where_role .= ')';
        }
        $where_staff = '';
        if (!empty($data['staff'])) {
            foreach ($data['staff'] as $key => $value) {
                if ($where_staff == '') {
                    $where_staff .= ' and (' . db_prefix() . 'staff.staffid = ' . $value;
                } else {
                    $where_staff .= ' or ' . db_prefix() . 'staff.staffid = ' . $value;
                }
            }
            $where_staff .= ')';
        }

        $staffsTasksWhere = '';
        if ($from_date != '' && $to_date != '') {
            $staffsTasksWhere = 'IF(duedate IS NOT NULL,((startdate <= "' . $from_date . '" and duedate >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and duedate >= "' . $to_date . '") or (startdate > "' . $from_date . '" and duedate < "' . $to_date . '")), IF(datefinished IS NOT NULL,((startdate <= "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $to_date . '") or (startdate > "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") < "' . $to_date . '")),(startdate <= "' . $from_date . '" or (startdate > "' . $from_date . '" and startdate <= "' . $to_date . '"))))';
        } elseif ($from_date != '') {
            $staffsTasksWhere = '(startdate >= "' . $from_date . '" or IF(duedate IS NOT NULL, duedate >= "' . $from_date . '", IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '", 1=1)))';
        } elseif ($to_date != '') {
            $staffsTasksWhere = '(startdate <= "' . $to_date . '" or IF(duedate IS NOT NULL,duedate <= "' . $to_date . '",IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") <= "' . $to_date . '", 1=1)))';
        }

        $taskstimesWhere = '';
        if ($from_date != '' && $to_date != '') {
            $taskstimesWhere = 'IF(end_time IS NOT NULL,(((from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $from_date . '") and FROM_UNIXTIME(end_time, \'%Y-%m-%d\') >= "' . $from_date . '") or (from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $to_date . '" and FROM_UNIXTIME(end_time, \'%Y-%m-%d\') >= "' . $to_date . '") or (from_unixtime(start_time, \'%Y-%m-%d\') > "' . $from_date . '" and FROM_UNIXTIME(end_time, \'%Y-%m-%d\') < "' . $to_date . '")), (from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $from_date . '" or (from_unixtime(start_time, \'%Y-%m-%d\') > "' . $from_date . '" and from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $to_date . '")))';
        } elseif ($from_date != '') {
            $taskstimesWhere = '(from_unixtime(start_time, \'%Y-%m-%d\') >= "' . $from_date . '" or IF(FROM_UNIXTIME(end_time, \'%Y-%m-%d\') IS NOT NULL, FROM_UNIXTIME(end_time, \'%Y-%m-%d\') >= "' . $from_date . '",  1=1))';
        } elseif ($to_date != '') {
            $taskstimesWhere = '(from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $to_date . '" or IF(FROM_UNIXTIME(end_time, \'%Y-%m-%d\') IS NOT NULL,FROM_UNIXTIME(end_time, \'%Y-%m-%d\') <= "' . $to_date . '", 1=1))';
        }
        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
        }else{
            $where = '';
        }

        $staff_exception = get_option('staff_workload_exception');

        $where_staff_exception = '';
        if($staff_exception != ''){
            $list_staff_exception = explode(',', $staff_exception);
            foreach ($list_staff_exception as $key => $value) {
                $where_staff_exception .= ' and '.db_prefix().'staff.staffid != '.$value;
            }
        }
       
        $list_staffs = $this->db->query('SELECT CASE
                WHEN end_time is NULL THEN (' . time() . '-start_time) / 60 / 60
                ELSE (end_time-start_time) / 60 / 60
                END as total_logged_time, start_time, end_time ,firstname, lastname, CONCAT(firstname, \' \', lastname) as full_name, `' . db_prefix() . 'staff`.`staffid` as `staffid`, `' . db_prefix() . 'roles`.`name` as `role_name`, `' . db_prefix() . 'tasks`.`id` as `taskid`, `' . db_prefix() . 'tasks`.`name` as `name`, `' . db_prefix() . 'customfieldsvalues`.`value` as estimate_hour, recurring_type, repeat_every, last_recurring_date, startdate, duedate, cycles, total_cycles, datefinished, rel_type, rel_id, (SELECT GROUP_CONCAT('.db_prefix().'departments.name SEPARATOR " ,") FROM '.db_prefix().'staff_departments JOIN '.db_prefix().'departments ON '.db_prefix().'departments.departmentid = '.db_prefix().'staff_departments.departmentid WHERE '.db_prefix().'staff_departments.staffid='.db_prefix().'staff.staffid ORDER BY '.db_prefix().'staff.staffid) as department_name FROM `' . db_prefix() . 'staff` 
            LEFT JOIN `' . db_prefix() . 'roles` ON `' . db_prefix() . 'staff`.`role`=`' . db_prefix() . 'roles`.`roleid` 
            LEFT JOIN `' . db_prefix() . 'task_assigned` ON `' . db_prefix() . 'staff`.`staffid`=`' . db_prefix() . 'task_assigned`.`staffid` and ' . db_prefix() . 'task_assigned.taskid in (select ' . db_prefix() . 'tasks.id from ' . db_prefix() . 'tasks where (' .$staffsTasksWhere.' OR ' .db_prefix() . 'tasks.id IN (select task_id FROM ' . db_prefix() . 'taskstimers where ' . $taskstimesWhere . ')) '.$where.')
            LEFT JOIN `' . db_prefix() . 'tasks` ON `' . db_prefix() . 'tasks`.`id`=`' . db_prefix() . 'task_assigned`.`taskid`
            LEFT JOIN `' . db_prefix() . 'customfields` ON `' . db_prefix() . 'customfields`.`fieldto` = "tasks" and `' . db_prefix() . 'customfields`.`slug` = "tasks_estimate_hour"
            LEFT JOIN `' . db_prefix() . 'customfieldsvalues` ON `' . db_prefix() . 'customfieldsvalues`.`relid`=`' . db_prefix() . 'tasks`.`id` and `' . db_prefix() . 'customfieldsvalues`.`fieldid` = `' . db_prefix() . 'customfields`.`id`
            LEFT JOIN `' . db_prefix() . 'taskstimers` ON `' . db_prefix() . 'staff`.`staffid`=`' . db_prefix() . 'taskstimers`.`staff_id` and `' . db_prefix() . 'taskstimers`.`task_id` = `' . db_prefix() . 'tasks`.`id`
            WHERE `' . db_prefix() . 'staff`.`active` = 1 ' .$where_role.$where_department.$where_project.$where_staff.$where_staff_exception)->result_array();
        return $list_staffs;
    }

    /**
     * Gets the staff workload.
     *
     * @param      object  $data   The data
     *
     * @return     array   The staff workload.
     */
    public function get_staff_workload_recurring($data, $where_task = [])
    {

        if (isset($data['project']) && !is_array($data['project']) && $data['project'] != '') {
            $data['project'] = explode(',', $data['project']);
        }

        if (isset($data['department']) && !is_array($data['department']) && $data['department'] != '') {
            $data['department'] = explode(',', $data['department']);
        }

        if (isset($data['role']) && !is_array($data['role']) && $data['role'] != '') {
            $data['role'] = explode(',', $data['role']);
        }

        if (isset($data['staff']) && !is_array($data['staff']) && $data['staff'] != '') {
            $data['staff'] = explode(',', $data['staff']);
        }
        $where_project = '';
        if (!empty($data['project'])) {
            foreach ($data['project'] as $key => $value) {
                if ($where_project == '') {
                    $where_project .= '(('.$value . ' in (select project_id from '.db_prefix() . 'project_members where '.db_prefix() . 'project_members.staff_id = '.db_prefix().'staff.staffid))';
                } else {
                    $where_project .= ' or ('.$value . ' in (select project_id from '.db_prefix() . 'project_members where '.db_prefix() . 'project_members.staff_id = '.db_prefix().'staff.staffid))';
                }
            }
            $where_project .= ')';
        }
        $where_department = '';
        if (!empty($data['department'])) {
            foreach ($data['department'] as $key => $value) {
                if ($where_department == '') {
                    $where_department .= '(('.$value . ' in (select departmentid from '.db_prefix() . 'staff_departments where '.db_prefix() . 'staff_departments.staffid = '.db_prefix().'staff.staffid))';
                } else {
                    $where_department .= ' or ('.$value . ' in (select departmentid from '.db_prefix() . 'staff_departments where '.db_prefix() . 'staff_departments.staffid = '.db_prefix().'staff.staffid))';
                }
            }
            $where_department .= ')';
        }
        $where_role = '';
        if (!empty($data['role'])) {
            foreach ($data['role'] as $key => $value) {
                if ($where_role == '') {
                    $where_role .= '(' . db_prefix() . 'staff.role = ' . $value;
                } else {
                    $where_role .= ' or ' . db_prefix() . 'staff.role = ' . $value;
                }
            }
            $where_role .= ')';
        }
        $where_staff = '';
        if (!empty($data['staff'])) {
            foreach ($data['staff'] as $key => $value) {
                if ($where_staff == '') {
                    $where_staff .= '(' . db_prefix() . 'staff.staffid = ' . $value;
                } else {
                    $where_staff .= ' or ' . db_prefix() . 'staff.staffid = ' . $value;
                }
            }
            $where_staff .= ')';
        }

        $staff_exception = get_option('staff_workload_exception');

        $where_staff_exception = '';
        if($staff_exception != ''){
            $list_staff_exception = explode(',', $staff_exception);
            foreach ($list_staff_exception as $key => $value) {
                if($where_staff_exception == ''){
                    $where_staff_exception .= ' '.db_prefix().'staff.staffid != '.$value;
                }else{
                    $where_staff_exception .= ' and '.db_prefix().'staff.staffid != '.$value;
                }
            }
        }

        if ((is_array($where_task) && count($where_task) > 0) || (is_string($where_task) && $where_task != '')) {
        }else{
            $where_task = '';
        }
        $this->db->select('CASE
                WHEN end_time is NULL THEN (' . time() . '-start_time) / 60 / 60
                ELSE (end_time-start_time) / 60 / 60
                END as total_logged_time, start_time, end_time, CONCAT(firstname, \' \', lastname) as full_name,' . db_prefix() . 'staff.staffid as staffid, ' . db_prefix() . 'roles.name as role_name, ' . db_prefix() . 'tasks.id as taskid, `' . db_prefix() . 'tasks`.`name` as `name`, `' . db_prefix() . 'customfieldsvalues`.`value` as estimate_hour, recurring_type, repeat_every, last_recurring_date, startdate, duedate, cycles, total_cycles, datefinished, rel_type, rel_id, (SELECT GROUP_CONCAT('.db_prefix().'departments.name SEPARATOR " ,") FROM '.db_prefix().'staff_departments JOIN '.db_prefix().'departments ON '.db_prefix().'departments.departmentid = '.db_prefix().'staff_departments.departmentid WHERE '.db_prefix().'staff_departments.staffid='.db_prefix().'staff.staffid ORDER BY '.db_prefix().'staff.staffid) as department_name');
        $this->db->join(db_prefix() . 'roles', db_prefix() . 'staff.role=' . db_prefix() . 'roles.roleid', 'left');
        $this->db->join(db_prefix() . 'task_assigned', db_prefix() . 'staff.staffid=' . db_prefix() . 'task_assigned.staffid ', 'left');
        $this->db->join(db_prefix() . 'tasks', db_prefix() . 'tasks.id=' . db_prefix() . 'task_assigned.taskid ' . $where_task, 'left');
        $this->db->join(db_prefix() . 'customfields', '`' . db_prefix() . 'customfields`.`fieldto` = "tasks" and `' . db_prefix() . 'customfields`.`slug` = "tasks_estimate_hour"', 'left');
        $this->db->join(db_prefix() . 'customfieldsvalues', '`' . db_prefix() . 'customfieldsvalues`.`relid`=`' . db_prefix() . 'tasks`.`id` and `' . db_prefix() . 'customfieldsvalues`.`fieldid` = `' . db_prefix() . 'customfields`.`id`', 'left');
        $this->db->join(db_prefix() . 'taskstimers', '`' . db_prefix() . 'staff`.`staffid`=`' . db_prefix() . 'taskstimers`.`staff_id` and `' . db_prefix() . 'taskstimers`.`task_id` = `' . db_prefix() . 'tasks`.`id`', 'left');
        if ($where_role !== '') {
            $this->db->where($where_role);
        }
        if ($where_department !== '') {
            $this->db->where($where_department);
        }
        if ($where_project !== '') {
            $this->db->where($where_project);
        }
        if ($where_staff !== '') {
            $this->db->where($where_staff);
        }

        if ($where_staff_exception !== '') {
            $this->db->where($where_staff_exception);
        }
        $this->db->where(db_prefix() . 'staff.active', 1);

        $this->db->where('`recurring` = 1 and (`cycles` != `total_cycles` OR `cycles`=0)');
        $list_staffs = $this->db->get(db_prefix() . 'staff')->result_array();

        return $list_staffs;
    }

    /**
     * Gets the name relative type.
     *
     * @param      int  $id        The identifier
     * @param      string  $rel_type  The relative type
     *
     * @return     string  The name relative type.
     */
    public function get_name_rel_type($id, $rel_type)
    {
        switch ($rel_type) {
            case 'project':
                $this->load->model('Projects_model');
                return $this->Projects_model->get($id)->name;
                break;
            case 'ticket':
                $this->load->model('Tickets_model');
                return $this->Tickets_model->get($id)->subject;
                break;
            case 'lead':
                $this->load->model('Leads_model');
                return $this->Leads_model->get($id)->name;
                break;
            case 'customer':
                $this->load->model('Clients_model');
                return $this->Clients_model->get($id)->company;
                break;
            case 'contract':
                $this->load->model('Contracts_model');
                return $this->Contracts_model->get($id)->subject;
                break;
            case 'invoice':
                return format_invoice_number($id);
                break;
            case 'estimate':
                $this->load->model('Estimates_model');
                return $this->Estimates_model->get($id)->category_name;
                break;
            case 'proposal':
                return format_proposal_number($id);
                break;
            case 'account_planning':
                $this->db->where('id', $id);
                return $this->db->get(db_prefix() . 'account_planning')->row()->subject;
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * Gets the color relative type.
     *
     * @param      string  $rel_type  The relative type
     *
     * @return     string  The color relative type.
     */
    public function get_color_rel_type($rel_type)
    {
        switch ($rel_type) {
            case 'project':
                return '84C529';
                break;
            case 'ticket':
                return '8085E9';
                break;
            case 'lead':
                return 'cc66ff';
                break;
            case 'customer':
                return '03a9f4';
                break;
            case 'contract':
                return 'ff6f00';
                break;
            case 'invoice':
                return 'ff9900';
                break;
            case 'estimate':
                return 'ff5050';
                break;
            case 'proposal':
                return '3333cc';
                break;
            case 'account_planning':
                return '993333';
                break;
            case 'expense':
                return '2af509';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * get data estimate stats
     *
     * @return  object
     */
    public function estimate_stats($data, $standard_workload)
    {
        $total_normal   = 0;
        $total_overload = 0;
        foreach ($data['data'] as $workload) {
            foreach ($workload as $key => $value) {
                if (!(strpos($key, '_e') === false)) {
                    $key               = explode('_', $key);
                    $overload          = $value - $standard_workload[$workload['staff_id']][$key[2] . '-' . $key[1] . '-' . $key[0]];
                    if ($overload > 0) {
                        $total_overload += $overload;
                        $total_normal += $standard_workload[$workload['staff_id']][$key[2] . '-' . $key[1] . '-' . $key[0]];
                    } else {
                        $total_normal += $value;
                    }
                }
            }
        }

        $chart = [];

        $status_1      = ['name' => _l('overload'), 'color' => '#fc2d42', 'y' => 0];
        $status_2      = ['name' => _l('normal'), 'color' => '#84c529', 'y' => 0];
        $status_1['y'] = round($total_overload, 1);
        $status_2['y'] = round($total_normal, 1);
        if ($status_1['y'] > 0) {
            array_push($chart, $status_1);
        }
        if ($status_2['y'] > 0) {
            array_push($chart, $status_2);
        }
        return $chart;
    }

    /**
     * Gets the estimate hour.
     *
     * @param      int   $task_id  The task identifier
     *
     * @return     integer  The estimate hour.
     */
    public function get_estimate_hour($task_id)
    {
        $this->db->where('fieldto', 'tasks');
        $this->db->where('slug', 'tasks_estimate_hour');
        $customfield_estimate_hour = $this->db->get(db_prefix() . 'customfields')->row();
        $value                     = 0;
        if (isset($customfield_estimate_hour->id)) {
            $this->db->where('fieldid', $customfield_estimate_hour->id);
            $this->db->where('relid', $task_id);
            $customfieldsvalues = $this->db->get(db_prefix() . 'customfieldsvalues')->row();
            if (isset($customfieldsvalues->id)) {
                $value = $customfieldsvalues->value;
            }

        }
        return $value;

    }

    /**
     * get data spent stats
     *
     * @return    object
     */
    public function spent_stats($data, $standard_workload)
    {
        $total_normal   = 0;
        $total_overload = 0;
        foreach ($data['data'] as $workload) {
            foreach ($workload as $key => $value) {
                if (!(strpos($key, '_s') === false)) {
                    $key               = explode('_', $key);
                    $overload          = $value - $standard_workload[$workload['staff_id']][$key[2] . '-' . $key[1] . '-' . $key[0]];
                    if ($overload > 0) {
                        $total_overload += $overload;
                        $total_normal += $standard_workload[$workload['staff_id']][$key[2] . '-' . $key[1] . '-' . $key[0]];
                    } else {
                        $total_normal += $value;
                    }
                }
            }
        }

        $chart = [];

        $status_1      = ['name' => _l('overload'), 'color' => '#ff9900', 'y' => 0];
        $status_2      = ['name' => _l('normal'), 'color' => '#66ccff', 'y' => 0];
        $status_1['y'] = round($total_overload, 1);
        $status_2['y'] = round($total_normal, 1);
        if ($status_1['y'] > 0) {
            array_push($chart, $status_1);
        }
        if ($status_2['y'] > 0) {
            array_push($chart, $status_2);
        }
        return $chart;
    }

    /**
     * get data department stats
     *
     * @return   object
     */
    public function department_stats($data,$standard_workload)
    {
        $not_in_department = _l('not_in_department');
        $total_normal      = 0;
        $total_overload    = 0;
        $department        = array();
        foreach ($data['data'] as $workload) {
            $dept_text = $not_in_department;
            foreach ($workload as $key => $value) {
                if (!(strpos($key, 'staff_department') === false)) {
                    if (trim($value) != '') {
                        $dept_text = explode(',', $value);
                        foreach ($dept_text as $department_name) {
                            if (!isset($department[$department_name])) {
                                $department[$department_name]                      = array();
                                $department[$department_name]['estimate_overload'] = 0;
                                $department[$department_name]['estimate_normal']   = 0;
                                $department[$department_name]['spent_overload']    = 0;
                                $department[$department_name]['spent_normal']      = 0;
                            }
                        }
                    }else{
                        if (!isset($department[$dept_text])) {
                            $department[$dept_text]                      = array();
                            $department[$dept_text]['estimate_overload'] = 0;
                            $department[$dept_text]['estimate_normal']   = 0;
                            $department[$dept_text]['spent_overload']    = 0;
                            $department[$dept_text]['spent_normal']      = 0;
                        }
                    }
                }
                if(is_array($dept_text)){
                    foreach ($dept_text as $department_name) {
                        if (!(strpos($key, '_e') === false)) {
                            $k                 = explode('_', $key);
                            $overload          = $value - $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                            if ($overload > 0) {
                                $department[$department_name]['estimate_overload'] += $overload;
                                $department[$department_name]['estimate_normal'] += $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                            } else {
                                $department[$department_name]['estimate_normal'] += $value;
                            }
                        }
                        if (!(strpos($key, '_s') === false)) {
                            $k                 = explode('_', $key);
                            $overload          = $value - $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                            if ($overload > 0) {
                                $department[$department_name]['spent_overload'] += $overload;
                                $department[$department_name]['spent_normal'] += $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                            } else {
                                $department[$department_name]['spent_normal'] += $value;
                            }
                        }
                    }
                }else{
                    if (!(strpos($key, '_e') === false)) {
                        $k                 = explode('_', $key);
                        $overload          = $value - $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                        if ($overload > 0) {
                            $department[$dept_text]['estimate_overload'] += $overload;
                            $department[$dept_text]['estimate_normal'] += $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                        } else {
                            $department[$dept_text]['estimate_normal'] += $value;
                        }
                    }
                    if (!(strpos($key, '_s') === false)) {
                        $k                 = explode('_', $key);
                        $overload          = $value - $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                        if ($overload > 0) {
                            $department[$dept_text]['spent_overload'] += $overload;
                            $department[$dept_text]['spent_normal'] += $standard_workload[$workload['staff_id']][$k[2] . '-' . $k[1] . '-' . $k[0]];
                        } else {
                            $department[$dept_text]['spent_normal'] += $value;
                        }
                    }
                }
            }
        }
        $chart = [];

        $status_1 = ['name' => _l('estimate_overload'), 'data' => [], 'stack' => 'male', 'color' => '#fc2d42'];
        $status_2 = ['name' => _l('estimate_normal'), 'data' => [], 'stack' => 'male', 'color' => '#84c529'];
        $status_3 = ['name' => _l('spent_normal'), 'data' => [], 'stack' => 'female', 'color' => '#66ccff'];
        $status_4 = ['name' => _l('spent_overload'), 'data' => [], 'stack' => 'female', 'color' => '#ff9900'];

        $columns = array();
        foreach ($department as $key => $dept) {
            array_push($status_1['data'], round($dept['estimate_overload'], 1));
            array_push($status_2['data'], round($dept['estimate_normal'], 1));
            array_push($status_4['data'], round($dept['spent_overload'], 1));
            array_push($status_3['data'], round($dept['spent_normal'], 1));

            array_push($columns, $key);
        }
        array_push($chart, $status_1);
        array_push($chart, $status_2);
        array_push($chart, $status_4);
        array_push($chart, $status_3);
        $result                      = array();
        $result['department_stats']  = $chart;
        $result['column_department'] = $columns;
        return $result;
    }

    /**
     * Gets the column department statistics.
     *
     * @return     object
     */
    public function get_column_department_stats()
    {
        $departments = $this->departments_model->get();
        $department  = [];
        foreach ($departments as $key => $value) {
            array_push($department, $value['name']);
        }
        return $department;
    }

    /**
     * check format date Y-m-d
     *
     * @param      String   $date   The date
     *
     * @return     boolean
     */
    public function check_format_date($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the number day.
     *
     * @param      string   $from_date  The from date
     * @param      string   $to_date    To date
     *
     * @return     integer  The number day.
     */
    public function get_number_day($date_working, $from_date, $to_date)
    {
        $count = 0;
        if ($to_date == '') {
            $to_date = date('Y-m-d');
        }
        for ($i = 0; $i < 5; $i++) {
            if (strtotime($from_date) <= strtotime($to_date)) {
                if(isset($date_working[$from_date])){
                    if ($date_working[$from_date] == 1) {
                        $count++;
                    }
                }

                $from_date = date('Y-m-d', strtotime($from_date . ' + 1 days'));
                $i         = 0;
            } else {
                $i = 10;
            }
        }

        return $count;
    }

    /**
     * check date working
     *
     * @param      array   $list_staffids   The list staff id
     * @param      String   $from_date   The from date
     * @param      String   $to_date   The to date
     *
     * @return     array
     */
    public function check_range_date_working($list_staffids, $from_date, $to_date)
    {

        $date_working = [];

        $working_days    = [];
        $working_days[1] = get_option('staff_workload_monday');
        $working_days[2] = get_option('staff_workload_tuesday');
        $working_days[3] = get_option('staff_workload_wednesday');
        $working_days[4] = get_option('staff_workload_thursday');
        $working_days[5] = get_option('staff_workload_friday');
        $working_days[6] = get_option('staff_workload_saturday');
        $working_days[7] = get_option('staff_workload_sunday');

        if(get_option('integrated_timesheet_holiday') == 1 && $this->get_status_modules_all('timesheets')){
            $this->db->select('*, (SELECT GROUP_CONCAT('.db_prefix().'staff_departments.departmentid SEPARATOR " ,") FROM '.db_prefix().'staff_departments WHERE '.db_prefix().'staff_departments.staffid='.db_prefix().'staff.staffid ORDER BY '.db_prefix().'staff.staffid) as department_ids');
            $this->db->where('active', 1);
            $this->db->join(db_prefix() . 'day_off', '('.db_prefix() . 'day_off.department = "" and ' . db_prefix() . 'day_off.position = "") or (find_in_set(role,'. db_prefix() . 'day_off.position) or ('. db_prefix() . 'day_off.position = ""))', 'left');

            $staff_dayoff = $this->db->get(db_prefix() . 'staff')->result_array();
            foreach ($staff_dayoff as $key => $value) {
                $check_department = false;
                if($value['department'] == ''){
                    $check_department = true;
                }else{
                    $department_ids = explode(',', $value['department_ids']);
                    $department = explode(',', $value['department']);

                    foreach ($department_ids as $department_id) {
                        foreach ($department as $val) {
                            if($department_id == $val){
                                $check_department = true;
                                break;
                            }
                        }

                        if($check_department == true){
                            break;
                        }
                    }
                }
                if($check_department){
                    if(isset($date_working[$value['staffid']])){
                        $date_working[$value['staffid']][$value['break_date']] = '0';
                    }else{
                        $date_working[$value['staffid']] = [];
                        $date_working[$value['staffid']][$value['break_date']] = '0';
                    }
                }
            }
        }else{
            $this->db->where('date >= "'. $from_date.'"');
            $this->db->where('date <= "'. $to_date.'"');
            $workload_dayoff = $this->db->get(db_prefix() . 'workload_dayoff')->result_array();
            foreach ($workload_dayoff as $key => $value) {
                foreach ($list_staffids as $staffid) {
                    $date_working[$staffid][$value['date']] = '0';
                }
            }
        }
        
        while (strtotime($from_date) <= strtotime($to_date)) {
            foreach ($list_staffids as $staffid) {
                if(!isset($date_working[$staffid][$from_date])){
                    $date_working[$staffid][$from_date] = $working_days[date('N',strtotime($from_date))];
                }
            }
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $date_working;
    }

    /**
     * task date change
     *
     * @param      object   $data   The data
     *
     * @return     boolean
     */
    public function task_date_change($data)
    {
        $this->load->model('tasks_model');
        $list_staffids           = $this->get_staff_workload([], true);
        $date_working = $this->check_range_date_working($list_staffids, $data['start_date'], $data['end_date']);

        $this->db->where('fieldto', 'tasks');
        $this->db->where('name', 'Estimate hour');
        $estimate_fields = $this->db->get(db_prefix() . 'customfields')->row();
        $affectedRows    = 0;
        $estimate        = 0;
        if ($estimate_fields) {
            $task_assignees = $this->tasks_model->get_task_assignees($data['task_id']);
            $staffid        = '';

            if (isset($task_assignees[0]['assigneeid'])) {
                $staffid = $task_assignees[0]['assigneeid'];
            }

            if ($staffid == '') {
                $number_day        = $this->get_number_day($date_working[$staffid], $data['start_date'], $data['end_date']);
                $standard_workload = get_option('standard_workload');
                if ($standard_workload == '') {
                    $standard_workload = 0;
                }
                $estimate = $number_day * $standard_workload;
            } else {
                $f_date = $data['start_date'];
                $t_date = $data['end_date'];

                while (strtotime($f_date) <= strtotime($t_date)) {
                    if ($date_working[$staffid][$f_date]) {
                        $standard_workload = $this->get_standard_workload_by_staff($staffid, $f_date);

                        $estimate += $standard_workload;
                    }

                    $f_date = date('Y-m-d', strtotime('+1 day', strtotime($f_date)));
                }
            }

            $this->db->where('relid', $data['task_id']);
            $this->db->where('fieldid', $estimate_fields->id);
            $this->db->where('fieldto', 'tasks');
            $_fields = $this->db->get(db_prefix() . 'customfieldsvalues')->row();

            if ($_fields) {
                $this->db->where('relid', $data['task_id']);
                $this->db->where('fieldid', $estimate_fields->id);
                $this->db->where('fieldto', 'tasks');
                $this->db->update(db_prefix() . 'customfieldsvalues', ['value' => $estimate]);

                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            } else {
                $this->db->where('relid', $data['task_id']);
                $this->db->where('fieldid', $estimate_fields->id);
                $this->db->where('fieldto', 'tasks');
                $this->db->insert(db_prefix() . 'customfieldsvalues', ['relid' => $data['task_id'],
                    'fieldto'                                                      => 'tasks',
                    'fieldid'                                                      => $estimate_fields->id,
                    'value'                                                        => $estimate]);
                $insert_id = $this->db->insert_id();
                if ($insert_id) {
                    $affectedRows++;
                }
            }
        }

        $this->db->where('id', $data['task_id']);
        $this->db->update(db_prefix() . 'tasks', ['startdate' => $data['start_date'], 'duedate' => $data['end_date']]);

        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Does a workload kanban query.
     *
     * @param      int   $staff_id  The staff identifier
     * @param      integer  $page      The page
     * @param      array    $where     The where
     * @param      boolean  $count     The count
     *
     * @return     object
     */
    public function do_workload_kanban_query($staff_id, $page = 1, $where = [], $count = false)
    {
        if ($count == false) {
            if ($page > 1) {
                $page--;
                $position = ($page * 10);
                $this->db->limit(10, $position);
            } else {
                $this->db->limit(10);
            }
        }

        return $this->get_tasks($staff_id, $where, true, $count);
    }

    /**
     * Gets the tasks.
     *
     * @param      string   $staff_id            The staff identifier
     * @param      array    $where               The where
     * @param      boolean  $apply_restrictions  The apply restrictions
     * @param      boolean  $count               The count
     *
     * @return     array   The tasks.
     */
    public function get_tasks($staff_id = '', $where = [], $apply_restrictions = false, $count = false)
    {

        $select = implode(', ', prefixed_table_fields_array(db_prefix() . 'tasks')) . ',
        (SELECT SUM(CASE
            WHEN end_time is NULL THEN ' . time() . '-start_time
            ELSE end_time-start_time
            END) FROM ' . db_prefix() . 'taskstimers WHERE task_id=' . db_prefix() . 'tasks.id) as total_logged_time,
           ' . get_sql_select_task_assignees_ids() . ' as assignees_ids
        ';

        $select .= ',(SELECT staffid FROM ' . db_prefix() . 'task_assigned WHERE taskid=' . db_prefix() . 'tasks.id AND staffid=' . get_staff_user_id() . ') as current_user_is_assigned, billable, (SELECT '.db_prefix().'projects.name FROM '.db_prefix().'projects  WHERE '.db_prefix().'projects.id='.db_prefix().'tasks.rel_id and '.db_prefix().'tasks.rel_type = "project") as project_name';

        $this->db->select($select);

        if ($staff_id != '') {
            $this->db->where('(' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . $staff_id . '))');
        }

        $this->db->where($where);

        $this->db->order_by('FIELD(status, 5), duedate IS NULL ASC, duedate', '', false);

        if ($count == false) {
            $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();
        } else {
            $tasks = $this->db->count_all_results(db_prefix() . 'tasks');
        }

        return $tasks;
    }

    /**
     * Gets the dayoff.
     *
     * @return     array  The dayoff.
     */
    public function get_dayoff()
    {
        return $this->db->get(db_prefix() . 'workload_dayoff')->result_array();
    }
    /**
     * Adds a dayoff.
     *
     * @param      object   $data   The data
     *
     * @return     boolean
     */
    public function add_dayoff($data)
    {
        $data['addedfrom']   = get_staff_user_id();
        $data['datecreated'] = date('Y-m-d H:i:s');

        if (!$this->check_format_date($data['date'])) {
            $data['date'] = to_sql_date($data['date']);
        }
        $this->db->insert(db_prefix() . 'workload_dayoff', $data);

        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return true;
        }
        return false;
    }

    /**
     * update dayoff
     *
     * @param      object   $data   The data
     * @param      int   $id     The identifier
     *
     * @return     boolean
     */
    public function update_dayoff($data, $id)
    {
        if (!$this->check_format_date($data['date'])) {
            $data['date'] = to_sql_date($data['date']);
        }
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'workload_dayoff', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Gets the department name.
     *
     * @param      int  $departmentid  The departmentid
     *
     * @return     string  The department name.
     */
    public function get_department_name($departmentid)
    {
        $department = $this->db->query('select ' . db_prefix() . 'departments.name from ' . db_prefix() . 'departments where departmentid = ' . $departmentid)->row();
        if ($department) {
            return $department->name;
        }
        return '';
    }

    /**
     * delete day off
     *
     * @param      int   $id     The identifier
     *
     * @return     boolean
     */
    public function delete_dayoff($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'workload_dayoff');
        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Gets the list standard workload.
     *
     * @return    array  The list standard workload.
     */
    public function get_list_standard_workload()
    {
        $this->load->model('staff_model');
        $staff = $this->staff_model->get('', ['active' => 1]);

        $standard_workload = $this->db->get(db_prefix() . 'standard_workload')->result_array();

        $working_days    = [];
        $working_days[1] = get_option('staff_workload_monday');
        $working_days[2] = get_option('staff_workload_tuesday');
        $working_days[3] = get_option('staff_workload_wednesday');
        $working_days[4] = get_option('staff_workload_thursday');
        $working_days[5] = get_option('staff_workload_friday');
        $working_days[6] = get_option('staff_workload_saturday');
        $working_days[7] = get_option('staff_workload_sunday');

        $list_staff = [];
        foreach ($standard_workload as $key => $value) {
            $list_staff[] = $value['staffid'];
        }
        $st = get_option('standard_workload');
        foreach ($staff as $key => $value) {
            if (!in_array($value['staffid'], $list_staff)) {
                $node            = [];
                $node['staffid'] = $value['staffid'];
                if ($working_days[1] == 1) {
                    $node['monday'] = $st;
                }
                if ($working_days[2] == 1) {
                    $node['tuesday'] = $st;
                }
                if ($working_days[3] == 1) {
                    $node['wednesday'] = $st;
                }
                if ($working_days[4] == 1) {
                    $node['thursday'] = $st;
                }
                if ($working_days[5] == 1) {
                    $node['friday'] = $st;
                }
                if ($working_days[6] == 1) {
                    $node['saturday'] = $st;
                }
                if ($working_days[7] == 1) {
                    $node['sunday'] = $st;
                }

                $standard_workload[] = $node;
            }
        }

        return $standard_workload;
    }

    /**
     * Gets the staff standard workload.
     *
     * @return     array  The staff standard workload.
     */
    public function get_staff_standard_workload()
    {
        $this->db->where('(select count(*) from ' . db_prefix() . 'standard_workload where staffid = ' . db_prefix() . 'staff.staffid) = 0');
        $data       = $this->db->get(db_prefix() . 'staff')->result_array();
        $list_staff = [];
        foreach ($data as $key => $value) {
            $list_staff[] = $value['staffid'];
        }
        $staffs = $this->staff_model->get('', ['active' => 1]);
        foreach ($staffs as $key => $value) {
            if (is_array($value['staffid'], $list_staff)) {

            }
        }
    }

    /**
     * Adds a standard workload.
     *
     * @return     boolean
     */
    public function add_standard_workload($data)
    {
        $affectedRows = 0;

        foreach ($data as $key => $value) {
            if ($value[0] != '' && $value[0] != null) {
                $this->db->where('id', $value[0]);
                $this->db->update(db_prefix() . 'standard_workload',
                    [
                        'staffid'   => $value[1],
                        'monday'    => $value[2],
                        'tuesday'   => $value[3],
                        'wednesday' => $value[4],
                        'thursday'  => $value[5],
                        'friday'    => $value[6],
                        'saturday'  => $value[7],
                        'sunday'    => $value[8],
                    ]);
                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            } else {
                $this->db->insert(db_prefix() . 'standard_workload', [
                    'staffid'   => $value[1],
                    'monday'    => $value[2],
                    'tuesday'   => $value[3],
                    'wednesday' => $value[4],
                    'thursday'  => $value[5],
                    'friday'    => $value[6],
                    'saturday'  => $value[7],
                    'sunday'    => $value[8],
                ]);
                $insert_id = $this->db->insert_id();
                if ($insert_id) {
                    $affectedRows++;
                }
            }
        }
        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * delete standard workload
     *
     * @param      int   $id     The identifier
     *
     * @return     boolean
     */
    public function delete_standard_workload($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'standard_workload');
        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }

    /**
     * update general setting
     *
     * @param      array   $data   The data
     *
     * @return     boolean
     */
    public function update_setting($data)
    {
        $affectedRows = 0;
        if (!isset($data['staff_workload_monday'])) {
            $data['staff_workload_monday'] = 0;
        }
        if (!isset($data['staff_workload_tuesday'])) {
            $data['staff_workload_tuesday'] = 0;
        }
        if (!isset($data['staff_workload_thursday'])) {
            $data['staff_workload_thursday'] = 0;
        }
        if (!isset($data['staff_workload_wednesday'])) {
            $data['staff_workload_wednesday'] = 0;
        }
        if (!isset($data['staff_workload_friday'])) {
            $data['staff_workload_friday'] = 0;
        }
        if (!isset($data['staff_workload_saturday'])) {
            $data['staff_workload_saturday'] = 0;
        }
        if (!isset($data['staff_workload_sunday'])) {
            $data['staff_workload_sunday'] = 0;
        }

        if (!isset($data['staff_workload_monday_visible'])) {
            $data['staff_workload_monday_visible'] = 0;
        }
        if (!isset($data['staff_workload_tuesday_visible'])) {
            $data['staff_workload_tuesday_visible'] = 0;
        }
        if (!isset($data['staff_workload_thursday_visible'])) {
            $data['staff_workload_thursday_visible'] = 0;
        }
        if (!isset($data['staff_workload_wednesday_visible'])) {
            $data['staff_workload_wednesday_visible'] = 0;
        }
        if (!isset($data['staff_workload_friday_visible'])) {
            $data['staff_workload_friday_visible'] = 0;
        }
        if (!isset($data['staff_workload_saturday_visible'])) {
            $data['staff_workload_saturday_visible'] = 0;
        }
        if (!isset($data['staff_workload_sunday_visible'])) {
            $data['staff_workload_sunday_visible'] = 0;
        }


        if (!isset($data['integrated_timesheet_holiday'])) {
            $data['integrated_timesheet_holiday'] = 0;
        }
        if (!isset($data['integrated_timesheet_leave'])) {
            $data['integrated_timesheet_leave'] = 0;
        }

        if (!isset($data['staff_workload_exception'])) {
            $data['staff_workload_exception'] = '';
        }else{
            $data['staff_workload_exception'] = implode(',', $data['staff_workload_exception']);
        }

        foreach ($data as $key => $value) {
            $this->db->where('name', $key);
            $this->db->update(db_prefix() . 'options', [
                'value' => $value,
            ]);
            if ($this->db->affected_rows() > 0) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Gets the standard workload by staff.
     *
     * @param      int  $staffid  The staffid
     *
     * @return     float  The standard workload by staff.
     */
    public function get_standard_workload_by_staff($staffid, $date)
    {
        if (!$this->check_format_date($date)) {
            $date = to_sql_date($date);
        }
        
        if(get_option('integrated_timesheet_leave') == 1 && $this->get_status_modules_all('timesheets')){
            
        }else{
            $this->db->where('staffid', $staffid);
            $standard_workload = $this->db->get(db_prefix() . 'standard_workload')->row();

            if ($standard_workload) {
                $working_days    = [];
                $working_days[1] = $standard_workload->monday;
                $working_days[2] = $standard_workload->tuesday;
                $working_days[3] = $standard_workload->wednesday;
                $working_days[4] = $standard_workload->thursday;
                $working_days[5] = $standard_workload->friday;
                $working_days[6] = $standard_workload->saturday;
                $working_days[7] = $standard_workload->sunday;

                return $working_days[date('N', strtotime($date))];
            } else {
                return get_option('standard_workload');
            }
        }

    }

    /**
     * Gets the standard workload by list staff.
     *
     * @param      int  $list_staff  The list staff id
     * @param      string  $from_date 
     * @param      string  $to_date 
     *
     * @return     array  The standard workload by list staff.
     */
    public function get_standard_workload_by_list_staff($list_staff, $from_date, $to_date)
    {
        $from_date_filter = $from_date;
        if (!$this->check_format_date($from_date)) {
            $from_date_filter = to_sql_date($from_date);
        }

        $to_date_filter = $to_date;
        if (!$this->check_format_date($to_date)) {
            $to_date_filter = to_sql_date($to_date);
        }

        $where_staff = '';
        if(count($list_staff) > 0){
            $where_staff = 'find_in_set(staffid, "'.implode(',', $list_staff).'")';
        }

        if($where_staff != ''){
            $this->db->where($where_staff);
        }

        $standard_workload = $this->db->get(db_prefix() . 'standard_workload')->result_array();

        $standard_workload_default = get_option('standard_workload');
        $working_days    = [];
        $from_date = $from_date_filter;
        $to_date = $to_date_filter;
        while (strtotime($from_date) <= strtotime($to_date)) {
            foreach ($standard_workload as $key => $value) {
                switch (date('N', strtotime($from_date))) {
                    case 1:
                        $working_days[$value['staffid']][$from_date] = $value['monday'] ? $value['monday'] : 0;;
                        break;
                    case 2:
                        $working_days[$value['staffid']][$from_date] = $value['tuesday'] ? $value['tuesday'] : 0;;
                        break;
                    case 3:
                        $working_days[$value['staffid']][$from_date] = $value['wednesday'] ? $value['wednesday'] : 0;;
                        break;
                    case 4:
                        $working_days[$value['staffid']][$from_date] = $value['thursday'] ? $value['thursday'] : 0;;
                        break;
                    case 5:
                        $working_days[$value['staffid']][$from_date] = $value['friday'] ? $value['friday'] : 0;;
                        break;
                    case 6:
                        $working_days[$value['staffid']][$from_date] = $value['saturday'] ? $value['saturday'] : 0;
                        break;
                    case 7:
                        $working_days[$value['staffid']][$from_date] = $value['sunday'] ? $value['sunday'] : 0;
                        break;
                    
                    default:
                        break;
                }
            }

            foreach ($list_staff as $staffid) {
                if(!isset($working_days[$staffid][$from_date])){
                    $working_days[$staffid][$from_date] = $standard_workload_default;
                }
            }
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }

        $from_date = $from_date_filter;
        $to_date = $to_date_filter;
        $data_timesheets = [];
        if(get_option('integrated_timesheet_leave') == 1 && $this->get_status_modules_all('timesheets')){
            $whereStaff = '';
            if(count($list_staff) > 0){
                $whereStaff = 'find_in_set(staff_id, "'.implode(',', $list_staff).'")';
            }

            if($whereStaff != ''){
                $this->db->where($whereStaff);
            }

            $timesheetsWhere = [];
            if ($from_date != '' && $to_date != '') {
                $timesheetsWhere = 'IF(end_time IS NOT NULL,(((start_time <= "' . $from_date . '") and end_time >= "' . $from_date . '") or (start_time <= "' . $to_date . '" and end_time >= "' . $to_date . '") or (start_time > "' . $from_date . '" and end_time < "' . $to_date . '")), (start_time <= "' . $from_date . '" or (start_time > "' . $from_date . '" and start_time <= "' . $to_date . '")))';
            } elseif ($from_date != '') {
                $timesheetsWhere = '(start_time >= "' . $from_date . '" or IF(end_time IS NOT NULL, end_time >= "' . $from_date . '",  1=1))';
            } elseif ($to_date != '') {
                $timesheetsWhere = '(start_time <= "' . $to_date . '" or IF(end_time IS NOT NULL,end_time <= "' . $to_date . '", 1=1))';
            }
            $this->db->where($timesheetsWhere);
            $this->db->where('status', '1');
            $this->db->where('rel_type', '1');

            $timesheets = $this->db->get(db_prefix() . 'timesheets_requisition_leave')->result_array();

            foreach ($timesheets as $key => $value) {
                $date_leave = $value['start_time'];
                $number_of_leaving_day = $value['number_of_leaving_day'];

                while ($number_of_leaving_day > 0 && strtotime($date_leave) <= strtotime($value['end_time'])) {
                    if(isset($working_days[$value['staff_id']][$date_leave]) && $working_days[$value['staff_id']][$date_leave] > 0){
                        if($number_of_leaving_day == 0.5){
                            if(isset($data_timesheets[$value['staff_id']][$date_leave])){
                                $data_timesheets[$value['staff_id']][$date_leave] += $working_days[$value['staff_id']][$date_leave] * 0.5;
                            }else{
                                if(!isset($data_timesheets[$value['staff_id']])){
                                    $data_timesheets[$value['staff_id']] = [];
                                }
                                $data_timesheets[$value['staff_id']][$date_leave] = $working_days[$value['staff_id']][$date_leave] * 0.5;
                            }
                        }else{
                            if(isset($data_timesheets[$value['staff_id']][$date_leave])){
                                $data_timesheets[$value['staff_id']][$date_leave] += $working_days[$value['staff_id']][$date_leave];
                            }else{
                                if(!isset($data_timesheets[$value['staff_id']])){
                                    $data_timesheets[$value['staff_id']] = [];
                                }
                                $data_timesheets[$value['staff_id']][$date_leave] = $working_days[$value['staff_id']][$date_leave];
                            }
                        }
                        $number_of_leaving_day--;
                    }

                    $date_leave = date('Y-m-d', strtotime('+1 day', strtotime($date_leave)));
                }
            }
        }
        $from_date = $from_date_filter;
        $to_date = $to_date_filter;

        while (strtotime($from_date) <= strtotime($to_date)) {
            foreach ($list_staff as $staffid) {
                if(isset($data_timesheets[$staffid][$from_date])){
                    if($working_days[$staffid][$from_date] > $data_timesheets[$staffid][$from_date]){
                        $working_days[$staffid][$from_date] = $working_days[$staffid][$from_date] - $data_timesheets[$staffid][$from_date];
                    }else{
                        $working_days[$staffid][$from_date] = 0;
                    }
                }
            }
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return ['standard_workload' => $working_days, 'data_timesheets' => $data_timesheets];
    }

    /**
     * Gets the staff select.
     *
     * @return     array   The staff select.
     */
    public function get_staff_select()
    {
        $staff      = $this->staff_model->get('', ['active' => 1]);
        $list_staff = [];
        foreach ($staff as $key => $value) {
            $note          = [];
            $note['id']    = $value['staffid'];
            $note['label'] = trim($value['firstname'] . ' ' . $value['lastname']);
            $list_staff[]  = $note;
        }
        return $list_staff;
    }

    /**
     * Gets the total standard workload.
     *
     * @param      int  $staffid  The staffid
     * @param      Date  $f_date   The f date
     * @param      Date  $t_date   The t date
     *
     * @return     array   The staff select.
     */
    public function get_total_standard_workload($standard_workload, $date_working, $staffid, $f_date, $t_date)
    {
        $total = 0;
        while (strtotime($f_date) <= strtotime($t_date)) {
            if(isset($date_working[$f_date])){
                if ($date_working[$f_date] == 1) {
                    $total += $standard_workload[$staffid][$f_date];
                }
            }

            $f_date = date('Y-m-d', strtotime('+1 day', strtotime($f_date)));
        }
        return $total;
    }

    /**
     * update task assigned
     *
     * @param      object  $data   The data
     */
    public function update_task_assigned($data)
    {
        $this->db->where('taskid', $data['task_id']);
        $this->db->delete(db_prefix() . 'task_assigned');

        $this->db->insert(db_prefix() . 'task_assigned', [
            'taskid'        => $data['task_id'],
            'staffid'       => $data['staff_id'],
            'assigned_from' => get_staff_user_id(),
        ]);
    }

    /**
     * get tasks by staff id
     * @param  integer $staffid
     * @param  string $from_date
     * @param  string $to_date
     * @param  array  $where
     * @return array
     */
    public function get_tasks_by_staff_id($staffid, $from_date, $to_date, $where = [])
    {
        $staffsTasksWhere = [];
        if ($from_date != '' && $to_date != '') {
            $staffsTasksWhere = 'IF(duedate IS NOT NULL,((startdate <= "' . $from_date . '" and duedate >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and duedate >= "' . $to_date . '") or (startdate > "' . $from_date . '" and duedate < "' . $to_date . '")), IF(datefinished IS NOT NULL,((startdate <= "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $to_date . '") or (startdate > "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") < "' . $to_date . '")),(startdate <= "' . $from_date . '" or (startdate > "' . $from_date . '" and startdate <= "' . $to_date . '"))))';
        } elseif ($from_date != '') {
            $staffsTasksWhere = '(startdate >= "' . $from_date . '" or IF(duedate IS NOT NULL, duedate >= "' . $from_date . '", IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '", 1=1)))';
        } elseif ($to_date != '') {
            $staffsTasksWhere = '(startdate <= "' . $to_date . '" or IF(duedate IS NOT NULL,duedate <= "' . $to_date . '",IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") <= "' . $to_date . '", 1=1)))';
        }

        $taskstimesWhere = [];
        if ($from_date != '' && $to_date != '') {
            $taskstimesWhere = 'IF(end_time IS NOT NULL,(((from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $from_date . '") and FROM_UNIXTIME(end_time, \'%Y-%m-%d\') >= "' . $from_date . '") or (from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $to_date . '" and FROM_UNIXTIME(end_time, \'%Y-%m-%d\') >= "' . $to_date . '") or (from_unixtime(start_time, \'%Y-%m-%d\') > "' . $from_date . '" and FROM_UNIXTIME(end_time, \'%Y-%m-%d\') < "' . $to_date . '")), (from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $from_date . '" or (from_unixtime(start_time, \'%Y-%m-%d\') > "' . $from_date . '" and from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $to_date . '")))';
        } elseif ($from_date != '') {
            $taskstimesWhere = '(from_unixtime(start_time, \'%Y-%m-%d\') >= "' . $from_date . '" or IF(FROM_UNIXTIME(end_time, \'%Y-%m-%d\') IS NOT NULL, FROM_UNIXTIME(end_time, \'%Y-%m-%d\') >= "' . $from_date . '",  1=1))';
        } elseif ($to_date != '') {
            $taskstimesWhere = '(from_unixtime(start_time, \'%Y-%m-%d\') <= "' . $to_date . '" or IF(FROM_UNIXTIME(end_time, \'%Y-%m-%d\') IS NOT NULL,FROM_UNIXTIME(end_time, \'%Y-%m-%d\') <= "' . $to_date . '", 1=1))';
        }
        $this->db->select('duedate, datefinished, id, name, startdate, rel_type');
        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
            $this->db->where($where);
        }

        $this->db->where('(' . $staffsTasksWhere . ' OR id IN (select task_id FROM ' . db_prefix() . 'taskstimers where ' . $taskstimesWhere . ' and staff_id = ' . $staffid . '))');

        $this->db->where('(id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . $staffid . '))');

        return $this->db->get(db_prefix() . 'tasks')->result_array();
    }

    /**
     * get status modules for all
     * @param  string $module_name
     * @return boolean
     */
    function get_status_modules_all($module_name)
    {
        $sql    = 'select * from ' . db_prefix() . 'modules where module_name = "' . $module_name . '" AND active =1 ';
        $module = $this->db->query($sql)->row();
        if ($module) {
            return true;
        } else {
            return false;
        }
    }

        /**
     * Gets the data workload.
     *
     * @param      object  $data_fill  The data fill
     *
     * @return     array   The data workload.
     */
    public function get_data_capacity($data_fill){
        if($data_fill['to_date'] == ''){
            $from_date = date('Y-m-d');
        }else{
            $from_date   = $data_fill['from_date'];
            if (!$this->check_format_date($from_date)) {
                $from_date = to_sql_date($data_fill['from_date']);
            }
        }
        if($data_fill['to_date'] == ''){
            $to_date = date('Y-m-d');
        }else{
            $to_date   = $data_fill['to_date'];
            if (!$this->check_format_date($to_date)) {
                $to_date = to_sql_date($data_fill['to_date']);
            }
        }

        $where_project = '';
        if (!empty($data_fill['project'])) {
            foreach ($data_fill['project'] as $key => $value) {
                if ($where_project == '') {
                    $where_project .= ' and (rel_id = '.$value;
                } else {
                    $where_project .= ' or rel_id = '.$value;
                }
            }
            $where_project .= ')';
        }

        $tasksWhere = ' rel_type = "project"'. $where_project;

        if ($from_date != '' && $to_date != '') {
            $tasksWhere .= ' and IF(duedate IS NOT NULL,((startdate <= "' . $from_date . '" and duedate >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and duedate >= "' . $to_date . '") or (startdate > "' . $from_date . '" and duedate < "' . $to_date . '")), IF(datefinished IS NOT NULL,((startdate <= "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '") or (startdate <= "' . $to_date . '" and date_format(datefinished, "%Y-%m-%d") >= "' . $to_date . '") or (startdate > "' . $from_date . '" and date_format(datefinished, "%Y-%m-%d") < "' . $to_date . '")),(startdate <= "' . $from_date . '" or (startdate > "' . $from_date . '" and startdate <= "' . $to_date . '"))))';
        } elseif ($from_date != '') {
            $tasksWhere .= ' and (startdate >= "' . $from_date . '" or IF(duedate IS NOT NULL, duedate >= "' . $from_date . '", IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") >= "' . $from_date . '", 1=1)))';
        } elseif ($to_date != '') {
            $tasksWhere .= ' and (startdate <= "' . $to_date . '" or IF(duedate IS NOT NULL,duedate <= "' . $to_date . '",IF(datefinished IS NOT NULL, date_format(datefinished, "%Y-%m-%d") <= "' . $to_date . '", 1=1)))';
        }

        $tasks      = $this->get_tasks('', $tasksWhere);

        $total_capacity = 0;
        $list_staffids           = $this->get_staff_workload($data_fill, true);
        $standard_workload_by_list_staff = $this->get_standard_workload_by_list_staff($list_staffids, $from_date, $to_date);
        $standard_workload = $standard_workload_by_list_staff['standard_workload'];
        $data_timesheets = $standard_workload_by_list_staff['data_timesheets'];
        $date_working = $this->check_range_date_working($list_staffids, $from_date, $to_date);


        foreach ($list_staffids as $key => $value) {
            $total_capacity += $this->get_total_standard_workload($standard_workload, $date_working[$value], $value, $from_date, $to_date);
        }

        $data             = ['billable' => [], 'unbillable' => []];
        $total_billable  = 0;
        $total_unbillable  = 0;
        foreach ($tasks as $key => $value) {
            if($value['billable'] == 1){
                if (isset($data['billable'][$value['rel_id']])) {
                    $data['billable'][$value['rel_id']]['total'] += $value['total_logged_time'];
                }else{
                    $data['billable'][$value['rel_id']]['project'] = $value['project_name'];
                    $data['billable'][$value['rel_id']]['total'] = $value['total_logged_time'];
                }
                $total_billable += $value['total_logged_time'];
            }else{
                if (isset($data['unbillable'][$value['rel_id']])) {
                    $data['unbillable'][$value['rel_id']]['total'] += $value['total_logged_time'];
                }else{
                    $data['unbillable'][$value['rel_id']]['project'] = $value['project_name'];
                    $data['unbillable'][$value['rel_id']]['total'] = $value['total_logged_time'];
                }
                $total_unbillable += $value['total_logged_time'];
            }
        }

        $billable = [];
        $unbillable = [];
        foreach ($data['billable'] as $key => $value) {
            $node = [];
            $node['project'] = $value['project'];
            $node['total'] = round($value['total'] / 60 / 60, 2).' '._l('hours');
            $billable[] = $node;
        }

        foreach ($data['unbillable'] as $key => $value) {
            $node = [];
            $node['project'] = $value['project'];
            $node['total'] = round($value['total'] / 60 / 60, 2).' '._l('hours');
            $unbillable[] = $node;
        }
        $total = round($total_billable / 60 / 60, 2) + round($total_unbillable / 60 / 60, 2);
        if($total == 0){
            $billable_percent = 0;
            $unbillable_percent = 0;
        }else{
            $billable_percent = round((round($total_billable / 60 / 60, 2)/ $total) * 100, 2);
            $unbillable_percent = round((round($total_unbillable / 60 / 60, 2)/ $total) * 100, 2);
        }
        $data_return                  = [];
        $data_return['billable']          = $billable;
        $data_return['unbillable']          = $unbillable;
        $data_return['total']['billable'] = round($total_billable / 60 / 60, 2).' '._l('hours').' ('.$billable_percent.'%)';
        $data_return['total']['unbillable'] = round($total_unbillable / 60 / 60, 2).' '._l('hours').' ('.$unbillable_percent.'%)';
        $data_return['total']['total_capacity'] = round($total_capacity, 2).' '._l('hours');
        return $data_return;
    }


}
