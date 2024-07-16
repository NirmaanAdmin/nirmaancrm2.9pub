<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/API_timesheets_Controller.php';

class Api_timesheets extends API_timesheets_Controller {
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('timesheets_model');
	}

	/**
	 * @api {post} /timesheet/api/login Request login user
	 * @apiVersion 0.0.0
	 * @apiName Login
	 * @apiGroup Authentication
	 *
	 * @apiParam {String} username     Mandatory User name.
	 * @apiParam {string} password     Mandatory Password.
	 *
	 * @apiParamExample {json} Request-Example:
	 *     	{
	 *        "username": "ABC@gmail.com",
	 *        "password": "123456"
	 * 		}
	 *
	 * @apiSuccess {Boolean} status Request status.
	 * @apiSuccess {Object} user information.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *          "status": true,
	 *          "result": {
	 *               "staffid": "1",
	 *               "fullName": "Lương Thị Thùy",
	 *               "email": "info.gstsvn1108@gmail.com",
	 *               "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImluZm8uZ3N0c3ZuMTEwOEBnbWFpbC5jb20iLCJwYXNzd29yZCI6IjEyMzQ1NmFAIiwiQVBJX1RJTUUiOjE1NzQzOTU4NTl9.226_EbTsVzVQLSEZutt_-GQe9VDUOmBLgae89qlSGQ8",
	 *          }
	 *     }
	 */
	public function login_post()
	{
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('username', 'User name', 'trim|required', array('is_unique' => 'username is missing'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required', array('is_unique' => 'password is missing'));
		if ($this->form_validation->run() == FALSE)
		{
			// form validation error
			$message = array(
				'status' => FALSE,
				'error' => $this->form_validation->error_array(),
				'message' => validation_errors() 
			);
			$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
		} else {
			// you user authentication code will go here, you can compare the user with the database or whatever
			$payload = [
				'username' => $this->input->post('username', TRUE),
				'password' => $this->input->post('password', TRUE),
			];


			// generate a token

			$token = $this->authorization_token->generateToken($payload);
			$data = $this->Timesheets_model->login($payload['username'], $payload['password']);
			if($data == FALSE){
				$this->response(
					[
						'status' => false,
						"message" => "Username or password is incorrect."
						
					], 200);
			}else{
				$this->db->where('staffid', $data['staffid']);
				$this->db->update(db_prefix() . 'staff', ['token' => $token]);
				$this->response(
					[
						'status' => true,
						"result" => [
							"staffid" => $data['staffid'],
							"fullName" => $data['full_name'],
							"email" => $data['email'],
							"token" => $token,
						]
					], 200);
			}
		}
	}

	/**
	 * @api {post} /accounting/api/logout Request logout user
	 * @apiVersion 0.0.0
	 * @apiName Logout
	 * @apiGroup Authentication
	 *
	 * @apiHeader {String} authtoken Basic Access Authentication token.
	 *
	 */

	public function logout_post()
	{
		// load authorization token library
		$is_valid_token = $this->authorization_token->validateToken();
		$token = $this->authorization_token->get_token();
		$check_token = $this->Accounting_model->check_token_logout($token);
		if($is_valid_token['status'] == false){
			$message = array(
				'status' => FALSE,
				'message' => $is_valid_token['message']
			);
			$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
		}else{
			if($check_token == false)
			{
				$message = array(
					'status' => FALSE,
					'message' => 'Incorrect token'
				);
				$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
				
			}else{
				// logout
				$data = $this->Timesheets_model->logout();
			}
		}
	}

 	/**
	 *  @api {post} /timesheets/api/check_in_out Request check-in/out
	 * @apiVersion 0.0.0
	 * @apiName check in/out
	 * @apiGroup Attendance
	 *
	 * @apiParam {Number} staff_id 						Mandatory Staff ID
	 * @apiParam {String} type_check 					Mandatory Value is 1 or 2 (1: Ckeck-in, 2: Check-out)
	 * @apiParam {String} edit_date 					Attendance date is customized by the user
	 * @apiParam {Number} point_id 					    ID of point for the case of attendance by route
	 * @apiParam {String} location_user 				User coordinates are separated by commas. Example: 13783745453.6743563465784
	 * @apiParam {String} ip_address 					IP address of user
	 * @apiParam {Number} send_notify 					1: Send notification, 0: Don't send notification
	 *
	 * @apiParamExample {Json} Request-Example:
	 * {
		    "staff_id":1,
		    "type_check":2,
		    "edit_date":"",
		    "point_id":"",
		    "location_user":"",
		    "ip_address":"",
		    "send_notify":0
	 * }
	 * 
	 *
	 * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} message Check out successfull.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
			    "status": true,
			    "message": "Check out successfull"
     *     }
     *
     * @apiError {Boolean} status Request status.
     * @apiError {String} message Check out not successfull.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1  200 OK
     *     {
			    "status": false,
			    "message": "Check out not successfull"
     *     }
     * 
     */
	public function check_in_out_post() {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required', array('is_unique' => 'staff_id is missing'));
		$this->form_validation->set_rules('type_check', 'Type', 'trim|required', array('is_unique' => 'type_check is missing'));
		if ($this->form_validation->run() == FALSE)
		{
			// form validation error
			$message = array(
				'status' => FALSE,
				'error' => $this->form_validation->error_array(),
				'message' => validation_errors() 
			);
			$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
		} else {
			$this->load->helper('timesheets');
			$this->load->helper('email_templates');
			$this->load->model('departments_model');
			$type = $this->input->post('type_check', TRUE);
			$payload = [
				'staff_id' => $this->input->post('staff_id', TRUE),
				'type_check' => $type,
				'edit_date' => $this->input->post('edit_date', TRUE),
				'point_id' => $this->input->post('point_id', TRUE),
				'location_user' => $this->input->post('location_user', TRUE),
				'ip_address' => $this->input->post('ip_address', TRUE)
			];
			$re = $this->timesheets_model->check_in($payload);
			if (is_numeric($re)) {
				// Error
				if ($re == 2) {
					$this->response(
						[
							'status' => FALSE,
							'message' => _l('your_current_location_is_not_allowed_to_take_attendance')
						], 200);
				}
				if ($re == 3) {
					$this->response(
						[
							'status' => FALSE,
							'message' => _l('location_information_is_unknown')
						], 200);
				}
				if ($re == 4) {
					$this->response(
						[
							'status' => FALSE,
							'message' => _l('route_point_is_unknown')
						], 200);
				}
				if ($re == 5) {
					$this->response(
						[
							'status' => FALSE,
							'message' => _l('ts_access_denie')
						], 200);
				}
				if ($re == 6) {
					$this->response(
						[
							'status' => FALSE,
							'message' => _l('ts_cannot_get_client_ip_address')
						], 200);
				}
			} else {
				if ($re == true) {
					if ($type == 1) {
						$this->response(
							[
								'status' => TRUE,
								'message' => _l('check_in_successfull')
							], 200);
					} else {
						$this->response(
							[
								'status' => TRUE,
								'message' => _l('check_out_successfull')
							], 200);
					}
				} else {
					if ($type == 1) {
						$this->response(
							[
								'status' => FALSE,
								'message' => _l('check_in_not_successfull')
							], 200);
					} else {
						$this->response(
							[
								'status' => FALSE,
								'message' => _l('check_out_not_successfull')
							], 200);
					}
				}
			}
		}
	}

 	/**
	 *  @api {post} /timesheets/api/add_leave_application Request add leave application
	 * @apiVersion 0.0.0
	 * @apiName Add leave application
	 * @apiGroup Attendance
	 *
	 * @apiParam {Number} subject 										Mandatory Subject
	 * @apiParam {String} staff_id 										Mandatory Staff ID
	 * @apiParam {Number=1,2,3,4,6} rel_type 							Mandatory Type (1: Leave, 2: Late for work, 3: Go out, 4: Go on business, 6: Go home early)
	 * @apiParam {String} type_of_leave 								Type of leave (Mandatory only for Leave type)
	 * @apiParam {String} used_to 										Array of expense names used for go on business travel (For Go on business type)
	 * @apiParam {Number} amoun_of_money 								Array of names used for go on business travel (For Go on business type)
	 * @apiParam {Number} advance_payment_reason 						Advance payment reason
	 * @apiParam {Number} number_of_leaving_day 						Number of leaving day
	 * @apiParam {Number} start_time 									Leave start time
	 * @apiParam {Number} end_time 										Leave end time
	 * @apiParam {Number} followers_id 									Followers ID
	 * @apiParam {Number} handover_recipients 							Handover recipients ID
	 * @apiParam {Number} reason 										Reason for leave
	 *
	 * @apiParamExample {Json} Request-Example:
	 * {
			"subject":"Go on business",
			"staff_id":1,
			"rel_type":4,
			"type_of_leave":"8",
			"used_to":{"0":"Hotel's money","1":"Eating money","2":"Travel money"},
			"amoun_of_money":{"0":"100","1":"50","2":"70"},
			"advance_payment_reason":"Advance payment reason",
			"number_of_leaving_day":2,
			"start_time":"2022-04-20 09:37:27",
			"end_time":"2022-04-21 09:37",
			"followers_id":2,
			"handover_recipients":0,
			"reason":"Reason"
	 * }
	 * 
	 *
	 * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} message Created successfull.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
			    "status": true,
			    "message": "Created successfull"
     *     }
     *
     * @apiError {Boolean} status Request status.
     * @apiError {String} message Created unsuccessfull.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1  200 OK
     *     {
			    "status": false,
			    "message": "Created unsuccessfull"
     *     }
     * 
     */
	public function add_leave_application_post() {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required', array('is_unique' => 'staff_id is missing'));
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required', array('is_unique' => 'subject is missing'));
		$this->form_validation->set_rules('rel_type', 'Rel type', 'trim|required', array('is_unique' => 'rel_type is missing'));
		$this->form_validation->set_rules('start_time', 'Start time', 'trim|required', array('is_unique' => 'start_time is missing'));
		$this->form_validation->set_rules('end_time', 'End time', 'trim|required', array('is_unique' => 'end_time is missing'));
		if ($this->form_validation->run() == FALSE)
		{
			// form validation error
			$message = array(
				'status' => FALSE,
				'error' => $this->form_validation->error_array(),
				'message' => validation_errors() 
			);
			$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
		} else {
			$rel_type = $this->input->post('rel_type', TRUE);
			if($rel_type == 1){
				$this->form_validation->set_rules('type_of_leave', 'Type of leave', 'trim|required', array('is_unique' => 'type_of_leave is missing'));
				$this->form_validation->set_rules('number_of_leaving_day', 'Number of leaving day', 'trim|required', array('is_unique' => 'number_of_leaving_day is missing'));
			}
			if ($this->form_validation->run() == FALSE && $rel_type == 1)
			{
				// form validation error
				$message = array(
					'status' => FALSE,
					'error' => $this->form_validation->error_array(),
					'message' => validation_errors() 
				);
				$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
			} else {
				$this->load->helper('timesheets');
				$this->load->helper('email_templates');
				$this->load->model('departments_model');
				define('TIMESHEETS_MODULE_NAME', 'timesheets');
				define('TIMESHEETS_MODULE_UPLOAD_FOLDER', module_dir_path(TIMESHEETS_MODULE_NAME, 'uploads'));
				$used_to = $this->input->post('used_to', TRUE);
				$amoun_of_money = $this->input->post('amoun_of_money', TRUE);
				$rel_type = $this->input->post('rel_type', TRUE);
				if($rel_type == 4){
					$check_array_valid = true;
					foreach($used_to as $key => $row){
						if(!isset($amoun_of_money[$key])){
							$check_array_valid = false;
							break;							
						}
					}
					if(!$check_array_valid){
						$this->response(
							[
								'status' => FALSE,
								'message' => _l('amount_of_money').' '._l('ts_does_not_match').' '._l('used_to')
							], 200);
					}
				}
				$data = [
					"subject" => $this->input->post('subject', TRUE),
					"staff_id" => $this->input->post('staff_id', TRUE),
					"rel_type" => $rel_type,
					"type_of_leave" => $this->input->post('type_of_leave', TRUE),
					"according_to_the_plan" => $this->input->post('according_to_the_plan', TRUE),
					"used_to" => $used_to,
					"amoun_of_money" => $amoun_of_money,
					"request_date" => date('Y-m-d'),
					"advance_payment_reason" => $this->input->post('advance_payment_reason', TRUE),
					"number_of_leaving_day" => $this->input->post('number_of_leaving_day', TRUE),
					"start_time" => $this->input->post('start_time', TRUE),
					"end_time" => $this->input->post('end_time', TRUE),
					"followers_id" => $this->input->post('followers_id', TRUE),
					"handover_recipients" => $this->input->post('handover_recipients', TRUE),
					"reason" => $this->input->post('reason', TRUE)
				];
				if ($data['rel_type'] == 1) {
					$data['start_time'] = date('Y-m-d', strtotime($this->timesheets_model->format_date_time($data['start_time'])));
					$data['end_time'] = date('Y-m-d', strtotime($this->timesheets_model->format_date_time($data['end_time'])));
				} else {
					$data['start_time'] = $this->timesheets_model->format_date_time($data['start_time']);
					$data['end_time'] = $this->timesheets_model->format_date_time($data['end_time']);
				}
				if (isset($data['according_to_the_plan'])) {
					$data['according_to_the_plan'] = 0;
				}

				$rel_type = '';
				if ($data['rel_type'] == '1') {
					switch ($data['type_of_leave']) {
						case 8:
						$rel_type = 'Leave';
						break;
						case 2:
						$rel_type = 'maternity_leave';
						break;
						case 4:
						$rel_type = 'private_work_without_pay';
						break;
						case 1:
						$rel_type = 'sick_leave';
						break;
					}
					// Rel type is custom type
					if ($rel_type == '') {
						$rel_type = $data['type_of_leave'];
					}
				} elseif ($data['rel_type'] == '2') {
					$data['end_time'] = $data['start_time'];
					$rel_type = 'late';
				} elseif ($data['rel_type'] == '3') {
					$data['end_time'] = $data['start_time'];
					$rel_type = 'Go_out';
				} elseif ($data['rel_type'] == '4') {
					$rel_type = 'Go_on_bussiness';
				} elseif ($data['rel_type'] == '5') {
					$rel_type = 'quit_job';
				} elseif ($data['rel_type'] == '6') {
					$data['end_time'] = $data['start_time'];
					$rel_type = 'early';
				}

				$data['type_of_leave_text'] = $rel_type;
				$result = $this->timesheets_model->add_requisition_ajax($data);
				if ($result != '') {
					$data_app['rel_id'] = $result;
					$data_app['rel_type'] = $rel_type;
					$data_app['addedfrom'] = $data['staff_id'];
					$data['rel_id'] = $result;
					$data['rel_type'] = $rel_type;
					$data['addedfrom'] = $data['staff_id'];

					$check_proccess = $this->timesheets_model->get_approve_setting($rel_type, false, $data['staff_id']);
					$check = '';
					if ($check_proccess) {
						if ($check_proccess->choose_when_approving == 0) {
							$this->timesheets_model->send_request_approve($data_app, $data['staff_id']);
						}
					}

					$followers_id = $data['followers_id'];
					$staffid = $data['staff_id'];
					$subject = $data['subject'];
					$link = 'timesheets/requisition_detail/' . $result;
					if ($followers_id != '') {
						if ($staffid != $followers_id) {
							$notification_data = [
								'description' => _l('you_are_added_to_follow_the_leave_application') . '-' . $subject,
								'touserid' => $followers_id,
								'link' => $link,
							];
							$notification_data['additional_data'] = serialize([
								$subject,
							]);
							if (add_notification($notification_data)) {
								pusher_trigger_notification([$followers_id]);
							}
						}
					}
					// Send to receipient
					$this->timesheets_model->notify_create_new_leave($result, $rel_type);
					$this->response(
						[
							'status' => TRUE,
							'message' => _l('ts_created_successfully')
						], 200);
				} else {
					$this->response(
						[
							'status' => FALSE,
							'message' => _l('ts_created_unsuccessfully')
						], 200);
				}
			}
		}
	}


	/**
     * @api {get} /timesheet/api/staff/:id Request get staff information
     * @apiVersion 0.0.0
     * @apiName Get staff
     * @apiGroup Other informations
     *
  	 * @apiParam {Number} id Staff ID.
     *
     * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} result Staff data or staff list.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
			"status": true,
			    "result": {
			        "staffid": "1",
			        "email": "sales@gsts.vn",
			        "firstname": "GTSSolution",
			        "lastname": "GTS",
			        "facebook": null,
			        "linkedin": null,
			        "phonenumber": null,
			        "skype": null,
			        "password": "$2a$08$zfW8Nl.6hKjuCGKpcX64.uujh8BoDSgctH/vYgZXPjj4/LXbWPwZG",
			        "datecreated": "2021-05-28 18:04:20",
			        "profile_image": null,
			        "last_ip": "127.0.0.1",
			        "last_login": "2022-04-20 08:20:08",
			        "last_activity": "2022-04-20 11:47:20",
			        "last_password_change": null,
			        "new_pass_key": null,
			        "new_pass_key_requested": null,
			        "admin": "1",
			        "role": null,
			        "active": "1",
			        "default_language": "english",
			        "direction": null,
			        "media_path_slug": null,
			        "is_not_staff": "0",
			        "hourly_rate": "0.00",
			        "two_factor_auth_enabled": "0",
			        "two_factor_auth_code": null,
			        "two_factor_auth_code_requested": null,
			        "email_signature": null,
			        "birthday": null,
			        "birthplace": null,
			        "sex": null,
			        "marital_status": null,
			        "nation": null,
			        "religion": null,
			        "identification": null,
			        "days_for_identity": null,
			        "home_town": null,
			        "resident": null,
			        "current_address": null,
			        "literacy": null,
			        "orther_infor": null,
			        "job_position": null,
			        "workplace": null,
			        "place_of_issue": null,
			        "account_number": null,
			        "name_account": null,
			        "issue_bank": null,
			        "records_received": null,
			        "Personal_tax_code": null,
			        "google_auth_secret": null,
			        "team_manage": "0",
			        "staff_identifi": null,
			        "status_work": null,
			        "date_update": null,
			        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6InNhbGVzQGdzdHMudm4iLCJwYXNzd29yZCI6IkdUU1NvbHV0aW9uMjYwNUAiLCJBUElfVElNRSI6MTY1MDM3MjIxM30.O8D2l87DOdP2rLllFPo64tgCPcku597tp_W2pAxCkhA",
			        "full_name": "GTSSolution GTS",
			        "permissions": []
			    }
	 *   }
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 Not Found
     *     {
     *       "status": false,
     *       "message": "Staff Data Does Not Exist."
     *     }
     */
	public function staff_get($id = '')
	{
		$is_valid_token = $this->authorization_token->validateToken();
		$token = $this->authorization_token->get_token();
		$check_token = $this->timesheets_model->check_token_logout($token);
		if($is_valid_token['status'] == false){
			$message = array(
				'status' => FALSE,
				'errorCode' => 1,
				'message' => $is_valid_token['message']
			);
			$this->response($message, API_Controller::HTTP_NOT_FOUND);
		}else{
			if($check_token == false)
			{
				$message = array(
					'status' => FALSE,
					'errorCode' => 1,
					'message' => 'Incorrect token.'
				);
				$this->response($message, API_Controller::HTTP_NOT_FOUND);

			}else{
				$data = [];			
				if(is_numeric($id)){
					$data = $this->staff_model->get($id);			
				}
				else{
					$data = $this->staff_model->get();					
				}
				if($data)
				{
					// Set the response and exit
					$this->response(
						[
							'status' => true,
							"result" => $data
						],
						200); 
				}
				else
				{
					// Data not exist
					$this->response(
						[
							'status' => FALSE,
							'message' => 'Staff Data Does Not Exist'
						], 200);
				}
			}
		}
	}

	/**
     * @api {get} /timesheet/api/type_of_leave_custom Request get type of leave custom list
     * @apiVersion 0.0.0
     * @apiName Type of leave custom list
     * @apiGroup Other informations
     *
     *
     * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} result Type of leave custom list.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
			  "status": true,
			  "result": [
			        {
			            "id": "1",
			            "type_name": "Type leave 1",
			            "slug": "type-leave-1",
			            "symbol": "L1",
			            "date_creator": "2022-04-14 10:36:53"
			        }
			  ]
	 *   }
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 Not Found
     *     {
     *       "status": false,
     *       "message": "No data"
     *     }
     */
	public function type_of_leave_custom_get()
	{
		$is_valid_token = $this->authorization_token->validateToken();
		$token = $this->authorization_token->get_token();
		$check_token = $this->timesheets_model->check_token_logout($token);
		if($is_valid_token['status'] == false){
			$message = array(
				'status' => FALSE,
				'errorCode' => 1,
				'message' => $is_valid_token['message']
			);
			$this->response($message, API_Controller::HTTP_NOT_FOUND);
		}else{
			if($check_token == false)
			{
				$message = array(
					'status' => FALSE,
					'errorCode' => 1,
					'message' => 'Incorrect token.'
				);
				$this->response($message, API_Controller::HTTP_NOT_FOUND);

			}else{
				$data = $this->timesheets_model->get_type_of_leave();
				if($data)
				{
					// Set the response and exit
					$this->response(
						[
							'status' => true,
							"result" => $data
						],
						200); 
				}
				else
				{
					// Data not exist
					$this->response(
						[
							'status' => FALSE,
							'message' => 'No data'
						], 200);
				}
			}
		}
	}

	/**
	 *  @api {post} /timesheets/api/calculate_number_days_off Request get number day off
	 * @apiVersion 0.0.0
	 * @apiName Get number day off
	 * @apiGroup Other informations
	 *
	 * @apiParam {Number} staff_id 										Mandatory Staff ID
	 * @apiParam {String} start_time 									Mandatory Start time
	 * @apiParam {String} end_time 										Mandatory End time
	 *
	 * @apiParamExample {Json} Request-Example:
	 * {
			"staff_id":1,
			"start_time":"2022-04-20",
			"end_time":"2022-04-25"
	 * }
	 * 
	 *
	 * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} result Number day off.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
			    "status": true,
			    "result": 4
     *     }
     * 
     */
    public function calculate_number_days_off_post() {
    	$_POST = json_decode(file_get_contents("php://input"), true);
    	$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required', array('is_unique' => 'staff_id is missing'));
    	$this->form_validation->set_rules('start_time', 'Start time', 'trim|required', array('is_unique' => 'start_time is missing'));
    	$this->form_validation->set_rules('end_time', 'End time', 'trim|required', array('is_unique' => 'end_time is missing'));
    	if ($this->form_validation->run() == FALSE)
    	{
			// form validation error
    		$message = array(
    			'status' => FALSE,
    			'error' => $this->form_validation->error_array(),
    			'message' => validation_errors() 
    		);
    		$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
    	} else {
    		$this->load->helper('timesheets');
    		$this->load->helper('email_templates');
    		$this->load->model('departments_model');
    		$staff_id = $this->input->post('staff_id', TRUE);
    		$start_time = $this->input->post('start_time', TRUE);
    		$end_time = $this->input->post('end_time', TRUE);
    		$list_af_date = [];
    		if ($start_time != '' && $end_time != '') {
    			if ($start_time && $end_time) {
    				if (strtotime($start_time) <= strtotime($end_time)) {
    					$list_date = $this->timesheets_model->get_list_date($start_time, $end_time);
    					foreach ($list_date as $key => $next_start_date) {
    						$data_work_time = $this->timesheets_model->get_hour_shift_staff($staff_id, $next_start_date);
    						$data_day_off = $this->timesheets_model->get_day_off_staff_by_date($staff_id, $next_start_date);
    						if ($data_work_time > 0 && count($data_day_off) == 0) {
    							$list_af_date[] = $next_start_date;
    						}
    					}
    				}
    			}
    		}
    		$count = count($list_af_date);
    		$this->response(
    			[
    				'status' => true,
    				"result" => $count
    			],
    			200); 
    	}
    }

	/**
	 *  @api {post} /timesheets/api/get_date_leave Request get date leave
	 * @apiVersion 0.0.0
	 * @apiName Get date leave
	 * @apiGroup Other informations
	 *
	 * @apiParam {Number} staff_id 										Mandatory Staff ID
	 * @apiParam {String} start_time 									Mandatory Start time
	 * @apiParam {Number} number_of_days 								Mandatory Number of days
	 *
	 * @apiParamExample {Json} Request-Example:
	 * {
			"staff_id":1,
			"number_of_days":4,
			"start_time":"2022-04-20"
	 * }
	 * 
	 *
	 * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} result End date.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
			    "status": true,
			    "result": 2022-04-25"
     *     }
     * 
     */
    public function get_date_leave_post() {
    	$_POST = json_decode(file_get_contents("php://input"), true);
    	$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required', array('is_unique' => 'staff_id is missing'));
    	$this->form_validation->set_rules('start_time', 'Start time', 'trim|required', array('is_unique' => 'start_time is missing'));
    	$this->form_validation->set_rules('number_of_days', 'Number of days', 'trim|required', array('is_unique' => 'number_of_days is missing'));
    	if ($this->form_validation->run() == FALSE)
    	{
			// form validation error
    		$message = array(
    			'status' => FALSE,
    			'error' => $this->form_validation->error_array(),
    			'message' => validation_errors() 
    		);
    		$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
    	} else {
    		$this->load->helper('timesheets');
    		$this->load->helper('email_templates');
    		$this->load->model('departments_model');
    		$staffid = $this->input->post('staff_id', TRUE);
    		$start_time = $this->input->post('start_time', TRUE);
    		$number_of_days = $this->input->post('number_of_days', TRUE);

    		$start_date = date('Y-m-d');
    		if (!$this->timesheets_model->check_format_date_ymd($start_time)) {
    			$start_date = to_sql_date($start_time);
    		} else {
    			$start_date = $start_time;
    		}
    		$ceiling_number_of_days = ceil($number_of_days);

    		$list_date = [];
    		$i = 0;
    		while (count($list_date) != $ceiling_number_of_days) {

    			$next_start_date = date('Y-m-d', strtotime($start_date . ' +' . $i . ' day'));
    			$data_work_time = $this->timesheets_model->get_hour_shift_staff($staffid, $next_start_date);
    			$data_day_off = $this->timesheets_model->get_day_off_staff_by_date($staffid, $next_start_date);
    			if ($data_work_time > 0 && count($data_day_off) == 0) {
    				$list_date[] = $next_start_date;
    			}
    			$i++;
    			if ($i > 100) {
    				break;
    			}
    		}
    		$end_date = $start_date;
    		if(isset($list_date[count($list_date) - 1])){
    			$end_date = ($list_date[count($list_date) - 1]);
    		}
    		$this->response(
    			[
    				'status' => true,
    				"result" => $end_date
    			],
    			200); 
    	}
    }


	/**
	 *  @api {post} /timesheets/api/get_history_check_in_out Request get history check-in/out
	 * @apiVersion 0.0.0
	 * @apiName Get history check-in/out
	 * @apiGroup Other informations
	 *
	 * @apiParam {Number} staff_id 										Mandatory Staff ID
	 * @apiParam {String} date 									Mandatory Date
	 *
	 * @apiParamExample {Json} Request-Example:
	 * {
			"staff_id":1,
			"date":"2022-04-20"
	 * }
	 * 
	 *
	 * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} result History check-in/out
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
			    "status": true,
			    "result": [
			        {
			            "id": "24",
			            "staff_id": "1",
			            "date": "2022-04-20 08:20:21",
			            "type_check": "2",
			            "type": "W",
			            "route_point_id": "0",
			            "workplace_id": "0"
			        },
			        {
			            "id": "25",
			            "staff_id": "1",
			            "date": "2022-04-20 08:21:03",
			            "type_check": "2",
			            "type": "W",
			            "route_point_id": "0",
			            "workplace_id": "0"
			        },
			        {
			            "id": "26",
			            "staff_id": "1",
			            "date": "2022-04-20 10:48:00",
			            "type_check": "2",
			            "type": "W",
			            "route_point_id": "0",
			            "workplace_id": "0"
			        }
			    ]
     *     }
     * 
     */
    public function get_history_check_in_out_post() {
    	$_POST = json_decode(file_get_contents("php://input"), true);
    	$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required', array('is_unique' => 'staff_id is missing'));
    	$this->form_validation->set_rules('date', 'Date', 'trim|required', array('is_unique' => 'date is missing'));
    	if ($this->form_validation->run() == FALSE)
    	{
			// form validation error
    		$message = array(
    			'status' => FALSE,
    			'error' => $this->form_validation->error_array(),
    			'message' => validation_errors() 
    		);
    		$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
    	} else {
    		$this->load->helper('timesheets');
    		$this->load->helper('email_templates');
    		$this->load->model('departments_model');
    		$staffid = $this->input->post('staff_id', TRUE);
    		$date = $this->input->post('date', TRUE);
    		$result = $this->timesheets_model->get_list_check_in_out($date, $staffid);
    		$this->response(
    			[
    				'status' => true,
    				"result" => $result
    			],
    			200); 
    	}
    }

    /**
     * @api {get} /timesheet/api/get_timesheets_option/:option_name Request get timesheet option
     * @apiVersion 0.0.0
     * @apiName Get timesheets option
     * @apiGroup Other informations
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
			  "status": true,
			  "result": "1"
	 *   }
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 Not Found
     *     {
     *       "status": false,
     *       "message": "No data"
     *     }
     */
	public function get_timesheets_option_get($option = '')
	{
		$is_valid_token = $this->authorization_token->validateToken();
		$token = $this->authorization_token->get_token();
		$check_token = $this->timesheets_model->check_token_logout($token);
		if($is_valid_token['status'] == false){
			$message = array(
				'status' => FALSE,
				'errorCode' => 1,
				'message' => $is_valid_token['message']
			);
			$this->response($message, API_Controller::HTTP_NOT_FOUND);
		}else{
			if($check_token == false)
			{
				$message = array(
					'status' => FALSE,
					'errorCode' => 1,
					'message' => 'Incorrect token.'
				);
				$this->response($message, API_Controller::HTTP_NOT_FOUND);

			}else{
				$this->load->helper('timesheets');
				$data = get_timesheets_option($option);
				if($data)
				{
					// Set the response and exit
					$this->response(
						[
							'status' => true,
							"result" => $data
						],
						200); 
				}
				else
				{
					// Data not exist
					$this->response(
						[
							'status' => FALSE,
							'message' => 'No data'
						], 200);
				}
			}
		}
	}


	/**
	 *  @api {post} /timesheets/api/get_route_point_check_in_out Request get route list point check in out
	 * @apiVersion 0.0.0
	 * @apiName Get route point list check in out
	 * @apiGroup Other informations
	 *
	 * @apiParam {Number} staff_id 					Mandatory Staff ID
	 * @apiParam {String} date 						Mandatory Date
	 * @apiParam {String} latitude 					Mandatory latitude
	 * @apiParam {String} longitude 				Mandatory longitude
	 *
	 * @apiParamExample {Json} Request-Example:
	 * {
			"staff_id":1,
			"date":"2022-04-20",
			"latitude":"657566756",
			"longitude":"45645654"
	 * }
	 * 
	 *
	 * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} result Route point list
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
			    "status": true,
    			"result": []
     *     }
     * 
     */
    public function get_route_point_check_in_out_post() {
    	$_POST = json_decode(file_get_contents("php://input"), true);
    	$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required', array('is_unique' => 'staff_id is missing'));
    	$this->form_validation->set_rules('date', 'Date', 'trim|required', array('is_unique' => 'date is missing'));
    	$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required', array('is_unique' => 'latitude is missing'));
    	$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required', array('is_unique' => 'longitude is missing'));
    	if ($this->form_validation->run() == FALSE)
    	{
			// form validation error
    		$message = array(
    			'status' => FALSE,
    			'error' => $this->form_validation->error_array(),
    			'message' => validation_errors() 
    		);
    		$this->response($message, API_timesheets_Controller::HTTP_NOT_FOUND);
    	} else {
    		$this->load->helper('timesheets');
    		$this->load->helper('email_templates');
    		$this->load->model('departments_model');
    		$staff = $this->input->post('staff_id', TRUE);
    		$date = $this->input->post('date', TRUE);
    		$latitude = $this->input->post('latitude', TRUE);
    		$longitude = $this->input->post('longitude', TRUE);
    		$result = [];
    		$point_id = '';
    		$data_setting_rooute = get_timesheets_option('allow_attendance_by_route');
    		if ($data_setting_rooute && $data_setting_rooute == 1) {
    			if ($staff != '' && $date != '') {
    				$obj = $this->timesheets_model->get_next_point($staff, $date, $latitude, $longitude);
    				$point_id = $obj->id;
    				$data_route = $this->timesheets_model->get_route_by_fillter($staff, $date);
    				foreach ($data_route as $key => $val) {
    					$route = $this->timesheets_model->get_route_point($val['route_point_id']);
    					if ($route) {
    						$route_point_id = $route->id;
    						$result[] = ['route_point_id' => $route_point_id, 'selected' => (($point_id == $route_point_id) ? true : false), 'route_name' => $route->name];
    						if ($obj->type == 'order') {
    							if ($point_id == $route_point_id) {
    								break;
    							}
    						}
    					}
    				}
    			}
    		}
    		$this->response(
    			[
    				'status' => true,
    				"result" => $result
    			],
    			200); 
    	}
    }

    	/**
     * @api {get} /timesheet/api/server_time Request get server time
     * @apiVersion 0.0.0
     * @apiName Get server time
     * @apiGroup Other informations
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
			  "status": true,
			  "result": "2022-04-14 10:36:53"
	 *   }
     *
     */
	public function server_time_get()
	{
		$is_valid_token = $this->authorization_token->validateToken();
		$token = $this->authorization_token->get_token();
		$check_token = $this->timesheets_model->check_token_logout($token);
		if($is_valid_token['status'] == false){
			$message = array(
				'status' => FALSE,
				'errorCode' => 1,
				'message' => $is_valid_token['message']
			);
			$this->response($message, API_Controller::HTTP_NOT_FOUND);
		}else{
			if($check_token == false)
			{
				$message = array(
					'status' => FALSE,
					'errorCode' => 1,
					'message' => 'Incorrect token.'
				);
				$this->response($message, API_Controller::HTTP_NOT_FOUND);

			}else{
				// Set the response and exit
				$this->response(
					[
						'status' => true,
						"result" => date('Y-m-d H:i:s')
					],
					200); 
			}
		}
	}

}

