<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This class describes a resource workload.
 */
class Resource_workload extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('resource_workload_model');
		$this->load->model('departments_model');
		$this->load->model('roles_model');
		$this->load->model('projects_model');

	}
	/**
	 * manage resource workload
	 * @return view
	 */
	public function index() {
		$this->load->model('staff_model');
		$data_fill = [];
		$data_fill['staff'] = [];
		$data_fill['department'] = [];
		$data_fill['role'] = [];
		$data_fill['project'] = [];
		$data_fill['from_date'] = date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))));
		$data_fill['to_date'] = date('Y-m-d');

        $data['type'] = $this->input->get('type');
        $data['tab'][] = 'workload';
        $data['tab'][] = 'chart';
        $data['tab'][] = 'timeline';
        $data['tab'][] = 'kanban';
        $data['tab'][] = 'capacity';
        if ($data['type'] == '') {
            $data['type'] = 'workload';
        }

        if ($data['type'] == 'workload') {
			$data['data_workload'] = $this->resource_workload_model->get_data_workload($data_fill);
			$data['nestedheaders'] = $this->resource_workload_model->get_nestedheaders_workload(date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d')))), date('Y-m-d'));
			$data['columns'] = $this->resource_workload_model->get_columns_workload(date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d')))), date('Y-m-d'));
        }elseif ($data['type'] == 'chart'){
            $list_staffids           = $this->resource_workload_model->get_staff_workload($data_fill, true);
            $standard_workload = $this->resource_workload_model->get_standard_workload_by_list_staff($list_staffids, $data_fill['from_date'], $data_fill['to_date']);
			$data['data_workload'] = $this->resource_workload_model->get_data_workload($data_fill);
			$data['estimate_stats'] = json_encode($this->resource_workload_model->estimate_stats($data['data_workload'], $standard_workload['standard_workload']));
			$department_stats = $this->resource_workload_model->department_stats($data['data_workload'], $standard_workload['standard_workload']);
			$data['department_stats'] = json_encode($department_stats['department_stats']);
			$data['spent_stats'] = json_encode($this->resource_workload_model->spent_stats($data['data_workload'], $standard_workload['standard_workload']));
			$data['column_department'] = json_encode($department_stats['column_department']);
        }elseif ($data['type'] == 'timeline'){
			$data['data_timeline'] = $this->resource_workload_model->get_data_timeline($data_fill);
        }elseif ($data['type'] == 'kanban'){
        	
        }elseif ($data['type'] == 'capacity'){
			$data['data_capacity'] = $this->resource_workload_model->get_data_capacity($data_fill);
        }

		$data['staffs'] = $this->staff_model->get('', ['active' => 1]);
		$data['projects'] = $this->projects_model->get();
		$data['departments'] = $this->departments_model->get();
		$data['roles'] = $this->roles_model->get();
		$data['title'] = _l('resource_workload');
        $data['tabs']['view'] = 'includes/' . $data['type'];

		$this->load->view('resource_workload', $data);
	}

	/**
	 * Gets the data workload.
	 * @return json data workload
	 */
	public function get_data_workload() {
		$data = $this->input->post();
		$data_workload = $this->resource_workload_model->get_data_workload($data);
		$nestedheaders = $this->resource_workload_model->get_nestedheaders_workload($data['from_date'], $data['to_date']);
		$columns = $this->resource_workload_model->get_columns_workload($data['from_date'], $data['to_date']);
		echo json_encode([
			'columns' => $columns,
			'nestedheaders' => $nestedheaders,
			'data_workload' => $data_workload['data'],
			'data_total' => $data_workload['data_total'],
			'data_tooltip' => $data_workload['data_tooltip'],
			'data_overload' => $data_workload['data_overload'],
			'data_timesheets' => $data_workload['data_timesheets']
		]);
		die();
	}

	/**
	 * Gets the data capacity.
	 * @return json data capacity
	 */
	public function get_data_capacity() {
		$data = $this->input->post();
		$data_capacity = $this->resource_workload_model->get_data_capacity($data);
		echo json_encode([
			'billable' => $data_capacity['billable'],
			'unbillable' => $data_capacity['unbillable'],
			'total' => [
				'billable' => $data_capacity['total']['billable'],
				'unbillable' => $data_capacity['total']['unbillable'],
				'total_capacity' => $data_capacity['total']['total_capacity'],
			],
		]);
		die();
	}

	/**
	 * Gets the data timeline.
	 * @return json data timeline
	 */
	public function get_data_timeline() {
		$data = $this->input->post();
		$data_timeline = $this->resource_workload_model->get_data_timeline($data);
		echo json_encode([
			'data_timeline' => $data_timeline,
		]);
		die();
	}

	/**
	 * Gets the data chart.
	 * @return json data chart
	 */
	public function get_data_chart() {
		$data = $this->input->post();
		$data_workload = $this->resource_workload_model->get_data_workload($data);
		$nestedheaders = $this->resource_workload_model->get_nestedheaders_workload($data['from_date'], $data['to_date']);
		$columns = $this->resource_workload_model->get_columns_workload($data['from_date'], $data['to_date']);
		echo json_encode([
			'columns' => $columns,
			'nestedheaders' => $nestedheaders,
			'data_workload' => $data_workload['data'],
			'data_tooltip' => $data_workload['data_tooltip'],
		]);
		die();
	}

	/**
	 * task date change
	 */
	public function task_date_change() {
		$data = $this->input->post();
		$success = $this->resource_workload_model->task_date_change($data);
		
		echo json_encode($success);
		die();
	}
	
	/**
	 * workload kanban
	 */
	public function workload_kanban()
    {
    	$this->load->model('staff_model');

        $data['staffs_exclude_completed_tasks'] = true;
        $filter = $this->input->get();
        $data['staffs'] = $this->resource_workload_model->get_staff_workload($filter);

        $from_date = '';
		$to_date = '';
		$staffsTasksWhere = '';
		if ($this->input->get('from_date')) {
		    $from_date  = $this->input->get('from_date');
		    if(!$this->resource_workload_model->check_format_date($from_date)){
		        $from_date = to_sql_date($from_date);
		    }
		}

		if ($this->input->get('to_date')) {
		    $to_date  = $this->input->get('to_date');
		    if(!$this->resource_workload_model->check_format_date($to_date)){
		        $to_date = to_sql_date($to_date);
		    }
		}

		if($from_date != '' && $to_date != ''){
		    $staffsTasksWhere = 'IF(duedate IS NOT NULL,((startdate <= "'.$from_date.'" and duedate >= "'.$from_date.'") or (startdate <= "'.$to_date.'" and duedate >= "'.$to_date.'") or (startdate > "'.$from_date.'" and duedate < "'.$to_date.'")), (startdate <= "'.$from_date.'" or (startdate > "'.$from_date.'" and startdate <= "'.$to_date.'")))';
		}elseif($from_date != ''){
		    $staffsTasksWhere = '(startdate >= "'.$from_date.'" or IF(duedate IS NOT NULL, duedate >= "'.$from_date.'", 1=1))';
		}elseif($to_date != ''){
		    $staffsTasksWhere = '(startdate <= "'.$to_date.'" or IF(duedate IS NOT NULL,duedate <= "'.$to_date.'", 1=1))';
		}

		foreach ($data['staffs'] as $key => $staff) {
			$data['staffs'][$key]['tasks'] = $this->resource_workload_model->do_workload_kanban_query($staff['staffid'], 1, $staffsTasksWhere);
 			$data['staffs'][$key]['total_pages'] = ceil($this->resource_workload_model->do_workload_kanban_query($staff['staffid'], 1, $staffsTasksWhere, true)/10);
		}
        echo html_entity_decode($this->load->view('workload_kanban', $data, true));
    }

    /**
     * manage setting
     */
    public function setting()
    {
    	$data['group'] = $this->input->get('group');

        $data['title']                 = _l('setting');
        $data['tab'][] = 'customize_standard_workload';
        $data['tab'][] = 'manage_dayoff';
        $data['tab'][] = 'general_settings';

        if($data['group'] == ''){
        	$data['group'] = 'customize_standard_workload';
        	$data['tabs']['view'] = 'customize_standard_workload';
        	$data['staffs'] = $this->resource_workload_model->get_staff_select();
        	$data['standard_workload'] = $this->resource_workload_model->get_list_standard_workload();
        }elseif($data['group'] == 'manage_dayoff'){
        	$data['departments'] = $this->departments_model->get();
        	$data['tabs']['view'] = $data['group'];
        	$data['holiday'] = $this->resource_workload_model->get_dayoff();
        }elseif($data['group'] == 'customize_standard_workload'){
        	$data['staffs'] = $this->resource_workload_model->get_staff_select();
        	$data['tabs']['view'] = $data['group'];
        	$data['standard_workload'] = $this->resource_workload_model->get_list_standard_workload();
        }elseif($data['group'] == 'general_settings'){
        	$data['check_timesheets'] = $this->resource_workload_model->get_status_modules_all('timesheets');
			$data['staffs'] = $this->staff_model->get('', ['active' => 1]);
        	$data['tabs']['view'] = $data['group'];
        }
    	$this->load->view('manage_setting', $data);
    }

    /**
     * Adds an update dayoff.
     */
    public function add_update_dayoff($id = ''){
    	$data = $this->input->post();
        if($data){
        	if(isset($data['id'])){
	            $id = $data['id'];
	            unset($data['id']);
	        }else{
	            $id = '';
	        }
            if($id == ''){
                $ids = $this->resource_workload_model->add_dayoff($data);
                if ($ids) {
                    $success = true;
                    $message = _l('added_successfully', _l('date_off'));
                    set_alert('success', $message);
                }
                redirect(admin_url('resource_workload/setting?group=manage_dayoff'));
            }else{
                $success = $this->resource_workload_model->update_dayoff($data,$id);
                if($success == true){
                    $message = _l('updated_successfully', _l('date_off'));
                    set_alert('success', $message);
                }
                redirect(admin_url('resource_workload/setting?group=manage_dayoff'));
            }
        }
    }

    /**
     * delete day off
     *
     * @param      int  $id     The identifier
     */
    public function delete_dayoff($id){
        if (!$id) {
            redirect(admin_url('resource_workload/setting'));
        }
        $response = $this->resource_workload_model->delete_dayoff($id);
        if($response == true) {
            set_alert('success', _l('deleted', _l('date_off')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('date_off')));
        }
        redirect(admin_url('resource_workload/setting?group=manage_dayoff'));
    }

    /**
     * Adds a standard workload.
     */
    public function add_standard_workload(){
    	$data = $this->input->post();
        if($data){
        	$data = json_decode($data['staff_shifting_data']);

            $ids = $this->resource_workload_model->add_standard_workload($data);
            if ($ids) {
                $message = _l('updated_successfully', _l('customize_standard_workload'));
                set_alert('success', $message);
            }
        }
        redirect(admin_url('resource_workload/setting?group=customize_standard_workload'));
    }

    /**
     * delete standard workload
     *
     * @param      int  $id     The identifier
     */
    public function delete_standard_workload($id){
        if (!$id) {
            redirect(admin_url('resource_workload/setting?group=customize_standard_workload'));
        }
        $response = $this->resource_workload_model->delete_standard_workload($id);
        if($response == true) {
            set_alert('success', _l('deleted', _l('date_off')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('date_off')));
        }
        redirect(admin_url('resource_workload/setting?group=customize_standard_workload'));
    }

    /**
     * update general setting
     */
    public function update_setting(){
    	$data = $this->input->post();
    	$success = $this->resource_workload_model->update_setting($data);
        if($success == true){
            $message = _l('updated_successfully', _l('general_settings'));
            set_alert('success', $message);
        }
        redirect(admin_url('resource_workload/setting?group=general_settings'));
    }

    /**
     * get data workload chart
     */
    public function workload_chart(){
    	$data_fill = $this->input->post();
    	$data_workload = $this->resource_workload_model->get_data_workload($data_fill);

    	if($data_fill['to_date'] == ''){
            $from_date = date('Y-m-d');
        }else{
            $from_date   = $data_fill['from_date'];
            if (!$this->resource_workload_model->check_format_date($from_date)) {
                $from_date = to_sql_date($data_fill['from_date']);
            }
        }

        if($data_fill['to_date'] == ''){
            $to_date = date('Y-m-d');
        }else{
            $to_date   = $data_fill['to_date'];
            if (!$this->resource_workload_model->check_format_date($to_date)) {
                $to_date = to_sql_date($data_fill['to_date']);
            }
        }

        $list_staffids           = $this->resource_workload_model->get_staff_workload($data_fill, true);
        $standard_workload = $this->resource_workload_model->get_standard_workload_by_list_staff($list_staffids, $from_date, $to_date);
    	$estimate_stats = $this->resource_workload_model->estimate_stats($data_workload, $standard_workload['standard_workload']);
		$d_stats = $this->resource_workload_model->department_stats($data_workload, $standard_workload['standard_workload']);
		$department_stats = $d_stats['department_stats'];
		$column_department = $d_stats['column_department'];
		$spent_stats = $this->resource_workload_model->spent_stats($data_workload, $standard_workload['standard_workload']);

		echo json_encode([
			'estimate_stats' => $estimate_stats,
			'spent_stats' => $spent_stats,
			'department_stats' => $department_stats,
			'column_department' => $column_department
		]);
		die();
    }

    /**
     * update task assigned
     */
    public function update_task_assigned()
    {
        if ($this->input->post()) {
            $this->resource_workload_model->update_task_assigned($this->input->post());
        }
    }

    /**
     * workload kanban load more }
     */
    public function workload_kanban_load_more()
    {
        $staffid     = $this->input->get('staffid');
        $page       = $this->input->get('page');
        $from_date = '';
		$to_date = '';
		$staffsTasksWhere = '';
		if ($this->input->get('from_date')) {
		    $from_date  = $this->input->get('from_date');
		    if(!$this->resource_workload_model->check_format_date($from_date)){
		        $from_date = to_sql_date($from_date);
		    }
		}

		if ($this->input->get('to_date')) {
		    $to_date  = $this->input->get('to_date');
		    if(!$this->resource_workload_model->check_format_date($to_date)){
		        $to_date = to_sql_date($to_date);
		    }
		}

		if($from_date != '' && $to_date != ''){
		    $staffsTasksWhere = 'IF(duedate IS NOT NULL,((startdate <= "'.$from_date.'" and duedate >= "'.$from_date.'") or (startdate <= "'.$to_date.'" and duedate >= "'.$to_date.'") or (startdate > "'.$from_date.'" and duedate < "'.$to_date.'")), (startdate <= "'.$from_date.'" or (startdate > "'.$from_date.'" and startdate <= "'.$to_date.'")))';
		}elseif($from_date != ''){
		    $staffsTasksWhere = '(startdate >= "'.$from_date.'" or IF(duedate IS NOT NULL, duedate >= "'.$from_date.'", 1=1))';
		}elseif($to_date != ''){
		    $staffsTasksWhere = '(startdate <= "'.$to_date.'" or IF(duedate IS NOT NULL,duedate <= "'.$to_date.'", 1=1))';
		}
        $tasks = $this->resource_workload_model->do_workload_kanban_query($staffid, $page, $staffsTasksWhere);
        foreach ($tasks as $task) {
            $this->load->view('resource_workload/_workload_kanban_card', ['task' => $task, 'staffid' => $staffid]);
        }
    }

    public function insert_data()
    {
    	ini_set('max_execution_time', 900);
    	$staffs = $this->staff_model->get();
    	foreach ($staffs as $key => $value) {
    		for ($j=1; $j < 5; $j++) { 
		    	for ($i=14; $i <= 20; $i++) {
		    		$data = [
		    			'name' => 'Task test '.$j.': 2021-01-'.$i . ' | 2021-01-'.($i+1) .' | '.$value['firstname'].' '.$value['lastname'],
		    			'hourly_rate' => '0',
		    			'milestone' => '',
		    			'startdate' => '2021-01-'.$i,
		    			'duedate' => '2021-01-'.($i+1),
		    			'priority' => '2',
		    			'repeat_every' => '',
		    			'repeat_every_custom' => '1',
		    			'repeat_type_custom' => 'day',
		    			'rel_type' => '',
		    			'rel_id' => '',
		    			'tags' => '',
		    			'description' => '',
		    			'custom_fields' => ['tasks' => [ 1 => 16]],
		    		];

		    		$task_id = $this->tasks_model->add($data);

		    		$this->db->insert(db_prefix() . 'task_assigned', [
                        'taskid'        => $task_id,
                        'staffid'       => $value['staffid'],
                        'assigned_from' => get_staff_user_id(),
                    ]);

		    		$start_time = to_sql_date('2021-01-'.$i.' 8:00:00', true);
		            $end_time   = to_sql_date('2021-01-'.$i.' 16:00:00', true);
		            $start_time = strtotime($start_time);
		            $end_time   = strtotime($end_time);

                    $this->db->insert(db_prefix() . 'taskstimers', [
                        'task_id'        => $task_id,
                        'staff_id'       => $value['staffid'],
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);

                    $start_time = to_sql_date('2021-01-'.($i+1).' 9:00:00', true);
		            $end_time   = to_sql_date('2021-01-'.($i+1).' 16:00:00', true);
		            $start_time = strtotime($start_time);
		            $end_time   = strtotime($end_time);

                    $this->db->insert(db_prefix() . 'taskstimers', [
                        'task_id'        => $task_id,
                        'staff_id'       => $value['staffid'],
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);
		    	}
    		}
    	}
    }
}