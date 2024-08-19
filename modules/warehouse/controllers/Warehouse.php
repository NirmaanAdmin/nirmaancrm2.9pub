<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * warehouse controler
 */
class warehouse extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('warehouse_model');
		require_once module_dir_path(WAREHOUSE_MODULE_NAME) . '/third_party/excel/PHPExcel.php';
	}

	/**
	 * setting
	 * @return view
	 */
	public function setting() {
		if (!has_permission('warehouse', '', 'edit') && !is_admin() && !has_permission('warehouse', '', 'create')) {
			access_denied('warehouse');
		}
		$data['group'] = $this->input->get('group');

		$data['title'] = _l('setting');
		$data['tab'][] = 'commodity_type';
		$data['tab'][] = 'commodity_group';
		$data['tab'][] = 'sub_group';
		$data['tab'][] = 'units';
		$data['tab'][] = 'colors';
		$data['tab'][] = 'bodys';
		$data['tab'][] = 'sizes';
		$data['tab'][] = 'styles';
		if(ACTIVE_BRAND_MODEL_SERIES == true){

			$data['tab'][] = 'brand';
			$data['tab'][] = 'model';
			$data['tab'][] = 'series';
		}

		$data['tab'][] = 'warehouse_custom_fields';
		$data['tab'][] = 'inventory';
		$data['tab'][] = 'rule_sale_price';
		$data['tab'][] = 'inventory_setting';
		$data['tab'][] = 'approval_setting';

		//reset data
		if(is_admin()){
			$data['tab'][] = 'reset_data';
		}
		if ($data['group'] == '') {
			$data['group'] = 'commodity_type';
			$data['commodity_types'] = $this->warehouse_model->get_commodity_type();

		} elseif ($data['group'] == 'commodity_group') {
			$data['commodity_group_types'] = $this->warehouse_model->get_commodity_group_type();

		} elseif ($data['group'] == 'units') {
			$data['unit_types'] = $this->warehouse_model->get_unit_type();

		} elseif ($data['group'] == 'bodys') {
			$data['body_types'] = $this->warehouse_model->get_body_type();

		} elseif ($data['group'] == 'sizes') {
			$data['size_types'] = $this->warehouse_model->get_size_type();

		} elseif ($data['group'] == 'styles') {
			$data['style_types'] = $this->warehouse_model->get_style_type();

		} elseif ($data['group'] == 'inventory') {
			$data['inventory_min'] = $this->warehouse_model->get_inventory_min();

		} elseif ($data['group'] == 'approval_setting') {
			$data['staffs'] = $this->staff_model->get();
			$data['approval_setting'] = $this->warehouse_model->get_approval_setting();

		} elseif ($data['group'] == 'sub_group') {

			$data['sub_groups'] = $this->warehouse_model->get_sub_group();
			$data['item_group'] = $this->warehouse_model->get_item_group();

		} elseif ($data['group'] == 'colors') {

			$data['colors'] = $this->warehouse_model->get_color();
		}elseif($data['group'] == 'brand'){
			$data['brands'] = $this->warehouse_model->get_brand();

		}elseif($data['group'] == 'model'){
			$data['list_brands'] = $this->warehouse_model->get_brand();
			$data['models'] = $this->warehouse_model->get_model();

		}elseif($data['group'] == 'series'){
			$data['list_models'] = $this->warehouse_model->get_model();
			$data['series_l'] = $this->warehouse_model->get_series();

		}elseif($data['group'] == 'warehouse_custom_fields'){
			$data['warehouses'] = $this->warehouse_model->get_warehouse();
			$data['custom_fields_warehouse'] = $this->warehouse_model->get_custom_fields_warehouse();

			$this->db->where('fieldto', 'warehouse_name');
			$data['wh_custom_fields'] = $this->db->get(db_prefix().'customfields')->result_array();

		}

		if ($data['group'] == 'commodity_type') {
			$data['commodity_types'] = $this->warehouse_model->get_commodity_type();

		}

		if($data['group'] == 'rule_sale_price'){
			$data['warehouses'] = $this->warehouse_model->get_warehouse();
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];

		$this->load->view('manage_setting', $data);
	}

	/**
	 * commodity type
	 * @param  integer $id
	 * @return redirect
	 */
	public function commodity_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_commodity_type($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('commodity_type'));

				} else {
					set_alert('warning', _l('Add_commodity_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=commodity_type'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_commodity_type($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('commodity_type'));
				} else {
					set_alert('warning', _l('updated_commodity_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=commodity_type'));
			}
		}
	}

	/**
	 * delete commodity type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_commodity_type($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=commodity_type'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_commodity_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('commodity_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('commodity_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('commodity_type')));
		}
		redirect(admin_url('warehouse/setting?group=commodity_type'));
	}

	/**
	 * unit type
	 * @param  integer $id
	 * @return redirect
	 */
	public function unit_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_unit_type($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('unit_type'));

				} else {
					set_alert('warning', _l('Add_unit_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=units'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_unit_type($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('unit_type'));
				} else {
					set_alert('warning', _l('updated_unit_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=units'));
			}
		}
	}

	/**
	 * delete unit type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_unit_type($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=units'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_unit_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('unit_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('unit_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('unit_type')));
		}
		redirect(admin_url('warehouse/setting?group=units'));
	}

	/**
	 * size type
	 * @param  integer $id
	 * @return redirect
	 */
	public function size_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_size_type($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('size_type'));

				} else {
					set_alert('warning', _l('Add_size_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=sizes'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_size_type($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('size_type'));
				} else {
					set_alert('warning', _l('updated_size_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=sizes'));
			}
		}
	}

	/**
	 * delete size type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_size_type($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=sizes'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_size_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('size_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('size_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('size_type')));
		}
		redirect(admin_url('warehouse/setting?group=sizes'));
	}

	/**
	 * style type
	 * @param  integer $id
	 * @return redirect
	 */
	public function style_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {
				$mess = $this->warehouse_model->add_style_type($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('style_type'));

				} else {
					set_alert('warning', _l('Add_style_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=styles'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_style_type($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('style_type'));
				} else {
					set_alert('warning', _l('updated_style_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=styles'));
			}
		}
	}
	/**
	 * delete style type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_style_type($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=styles'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}


		$response = $this->warehouse_model->delete_style_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('style_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('style_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('style_type')));
		}
		redirect(admin_url('warehouse/setting?group=styles'));
	}

	/**
	 * body type
	 * @param  integer $id
	 * @return redirect
	 */
	public function body_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_body_type($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('body_type'));

				} else {
					set_alert('warning', _l('Add_body_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=bodys'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_body_type($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('body_type'));
				} else {
					set_alert('warning', _l('updated_body_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=bodys'));
			}
		}
	}

	/**
	 * delete body type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_body_type($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=bodys'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}


		$response = $this->warehouse_model->delete_body_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('body_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('body_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('body_type')));
		}
		redirect(admin_url('warehouse/setting?group=bodys'));
	}

	/**
	 * commodty group type
	 * @param  integer $id
	 * @return redirect
	 */
	public function commodity_group_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_commodity_group_type($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('commodity_group_type'));

				} else {
					set_alert('warning', _l('Add_commodity_group_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=commodity_group'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_commodity_group_type($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('commodity_group_type'));
				} else {
					set_alert('warning', _l('updated_commodity_group_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=commodity_group'));
			}
		}
	}

	/**
	 * delete commodity group type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_commodity_group_type($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=commodity_group'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}


		$response = $this->warehouse_model->delete_commodity_group_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('commodity_group_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('commodity_group_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('commodity_group_type')));
		}
		redirect(admin_url('warehouse/setting?group=commodity_group'));
	}

	/**
	 * warehouse_
	 * @param  integer $id
	 * @return redirect
	 */

	public function warehouse_($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_warehouse($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('warehouse'));

				} else {
					set_alert('warning', _l('Add_warehouse_false'));
				}
				redirect(admin_url('warehouse/warehouse_mange'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_warehouse($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('warehouse'));
				} else {
					set_alert('warning', _l('updated_warehouse_false'));
				}

				redirect(admin_url('warehouse/warehouse_mange'));
			}
		}
	}

	/**
	 * delete warehouse
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_warehouse($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=warehouse'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_warehouse($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('warehouse')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('warehouse')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('warehouse')));
		}
		redirect(admin_url('warehouse/warehouse_mange'));
	}

	/**
	 * table commodity list
	 *
	 * @return array
	 */
	public function table_commodity_list() {
		$this->app->get_table_data(module_views_path('warehouse', 'table_commodity_list'));
	}

	/**
	 * commodity list
	 * @param  integer $id
	 * @return load view
	 */
	public function commodity_list($id = '') {
		$this->load->model('departments_model');
		$this->load->model('staff_model');

		$data['units'] = $this->warehouse_model->get_unit_add_commodity();
		$data['commodity_types'] = $this->warehouse_model->get_commodity_type_add_commodity();
		$data['commodity_groups'] = $this->warehouse_model->get_commodity_group_add_commodity();
		$data['warehouses'] = $this->warehouse_model->get_warehouse_add_commodity();
		$data['taxes'] = get_taxes();
		$data['styles'] = $this->warehouse_model->get_style_add_commodity();
		$data['models'] = $this->warehouse_model->get_body_add_commodity();
		$data['sizes'] = $this->warehouse_model->get_size_add_commodity();
		//filter
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['commodity_filter'] = $this->warehouse_model->get_commodity_active();
		$data['sub_groups'] = $this->warehouse_model->get_sub_group();
		$data['colors'] = $this->warehouse_model->get_color_add_commodity();
		$data['item_tags'] = $this->warehouse_model->get_item_tag_filter();

		$data['title'] = _l('commodity_list');

		$data['proposal_id'] = $id;

		$this->load->view('commodity_list', $data);
	}

	/**
	 * get commodity data ajax
	 * @param  integer $id
	 * @return view
	 */
	public function get_commodity_data_ajax($id) {

		$data['id'] = $id;
		$data['commodites'] = $this->warehouse_model->get_commodity($id);
		$data['inventory_commodity'] = $this->warehouse_model->get_inventory_commodity($id);
		$data['commodity_file'] = $this->warehouse_model->get_warehourse_attachments($id);
		$this->load->view('commodity_detail', $data);
	}

	/**
	 * add commodity list
	 * @param  integer $id
	 * @return redirect
	 */
	public function add_commodity_list($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_commodity($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('commodity_list'));

				} else {
					set_alert('warning', _l('Add_commodity_list_false'));
				}
				redirect(admin_url('warehouse/commodity_list'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_warehouse($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('commodity_list'));
				} else {
					set_alert('warning', _l('updated_commodity_list_false'));
				}

				redirect(admin_url('warehouse/commodity_list'));
			}
		}
	}

	/**
	 * delete commodity
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_commodity($id) {
		if (!$id) {
			redirect(admin_url('warehouse/commodity_list'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_commodity($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('commodity_list')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('commodity_list')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('commodity_list')));
		}
		redirect(admin_url('warehouse/commodity_list'));
	}

	/**
	 * table manage goods receipt
	 * @param  integer $id
	 * @return array
	 */
	public function table_manage_goods_receipt() {
		$this->app->get_table_data(module_views_path('warehouse', 'manage_goods_receipt/table_manage_goods_receipt'));
	}

	/**
	 * manage purchase
	 * @param  integer $id
	 * @return view
	 */
	public function manage_purchase($id = '') {
		$data['title'] = _l('stock_received_manage');
		$data['purchase_id'] = $id;
		$this->load->view('manage_goods_receipt/manage_purchase', $data);
	}

	/**
	 * manage goods receipt
	 * @param  integer $id
	 * @return view
	 */
	public function manage_goods_receipt($id = '') {
		$this->load->model('clients_model');

		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_goods_receipt($data);


				if ($mess) {
					if($data['save_and_send_request'] == 'true'){
						$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '1', 'addedfrom' => get_staff_user_id()]);
					}

					set_alert('success', _l('added_successfully'));

				} else {
					set_alert('warning', _l('Add_stock_received_docket_false'));
				}
				redirect(admin_url('warehouse/manage_purchase/'.$mess));

			}else{

				$id = $this->input->post('id');
				$mess = $this->warehouse_model->update_goods_receipt($data);

				if($data['save_and_send_request'] == 'true'){
					$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '1', 'addedfrom' => get_staff_user_id()]);
				}

				if ($mess) {
					set_alert('success', _l('updated_successfully'));

				} else {
					set_alert('warning', _l('update_stock_received_docket_false'));
				}
				redirect(admin_url('warehouse/manage_purchase/'.$id));
			}

		}
		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['title'] = _l('goods_receipt');

		$data['commodity_codes'] = $this->warehouse_model->get_commodity();

		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		if (get_status_modules_wh('purchase')) {
			$this->load->model('purchase/purchase_model');
			$this->load->model('departments_model');
			$this->load->model('staff_model');
			$this->load->model('projects_model');

			$data['pr_orders'] = get_pr_order();
			$data['pr_orders_status'] = true;

			$data['vendors'] = $this->purchase_model->get_vendor();

			$data['projects'] = $this->projects_model->get();
			$data['staffs'] = $this->staff_model->get();
			$data['departments'] = $this->departments_model->get();


		} else {
			$data['pr_orders'] = [];
			$data['pr_orders_status'] = false;
		}


		$data['taxes'] = $this->warehouse_model->get_taxes();
		$data['goods_code'] = $this->warehouse_model->create_goods_code();
		$data['staff'] = $this->warehouse_model->get_staff();
		$data['current_day'] = (date('Y-m-d'));

		//check status module purchase
		if($id != ''){
			$goods_receipt = $this->warehouse_model->get_goods_receipt($id);
			if (!$goods_receipt) {
				blank_page('Stock received Not Found', 'danger');
			}
			$data['goods_receipt_detail'] = json_encode($this->warehouse_model->get_goods_receipt_detail($id));

			$data['goods_receipt'] = $goods_receipt;

		}

		$this->load->view('manage_goods_receipt/purchase', $data);

	}

	/**
	 * copy pur request
	 * @param  integer $pur request
	 * @return json encode
	 */
	public function coppy_pur_request($pur_request) {

		$pur_request_detail = $this->warehouse_model->get_pur_request($pur_request);

		echo json_encode([

			'result' => $pur_request_detail[0] ? $pur_request_detail[0] : '',
			'total_tax_money' => $pur_request_detail[1] ? $pur_request_detail[1] : '',
			'total_goods_money' => $pur_request_detail[2] ? $pur_request_detail[2] : '',
			'value_of_inventory' => $pur_request_detail[3] ? $pur_request_detail[3] : '',
			'total_money' => $pur_request_detail[4] ? $pur_request_detail[4] : '',
			'total_row' => $pur_request_detail[5] ? $pur_request_detail[5] : '',
		]);
	}

	/**
	 * copy pur vender
	 * @param  integer $pủ request
	 * @return json encode
	 */
	public function copy_pur_vender($pur_request) {

		$pur_vendor = $this->warehouse_model->get_vendor_ajax($pur_request);

		echo json_encode([

			'userid' => $pur_vendor['id'] ? $pur_vendor['id'] : '',
			'buyer' => $pur_vendor['buyer'] ? $pur_vendor['buyer'] : '',
			'project' => $pur_vendor['project'] ? $pur_vendor['project'] : '',
			'type' => $pur_vendor['type'] ? $pur_vendor['type'] : '',
			'department' => $pur_vendor['department'] ? $pur_vendor['department'] : '',
			'requester' => $pur_vendor['requester'] ? $pur_vendor['requester'] : '',

		]);
	}

	/**
	 * view purchase
	 * @param  integer $id
	 * @return view
	 */
	public function view_purchase($id) {
		//approval
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if ((isset($send_mail_approve)) && $send_mail_approve != '') {
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 1);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 1);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 1);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 1);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['goods_receipt_detail'] = $this->warehouse_model->get_goods_receipt_detail($id);

		$data['goods_receipt'] = $this->warehouse_model->get_goods_receipt($id);

		$data['title'] = _l('stock_received_info');
		$check_appr = $this->warehouse_model->get_approve_setting('1');
		$data['check_appr'] = $check_appr;

		$this->load->view('manage_goods_receipt/view_purchase', $data);

	}

	/**
	 * edit purchase
	 * @param  integer $id
	 * @return view
	 */
	public function edit_purchase($id) {

		//check exist
		$goods_receipt = $this->warehouse_model->get_goods_receipt($id);
		if (!$goods_receipt) {
			blank_page('Stock received Not Found', 'danger');
		}

		//approval
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if ((isset($send_mail_approve)) && $send_mail_approve != '') {
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 1);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 1);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 1);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 1);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['goods_receipt_detail'] = json_encode($this->warehouse_model->get_goods_receipt_detail($id));
		$data['taxes'] = $this->warehouse_model->get_taxes();

		$data['goods_receipt'] = $goods_receipt;

		$data['title'] = _l('stock_received_info');

		$check_appr = $this->warehouse_model->get_approve_setting('1');
		$data['check_appr'] = $check_appr;

		$this->load->view('manage_goods_receipt/edit_purchase', $data);

	}

	public function add_goods_receipt() {

	}

	/**
	 * commodity code change
	 * @param  integer $val
	 * @return json encode
	 */
	public function commodity_code_change($val) {

		$value = $this->warehouse_model->get_commodity_hansometable($val);
		echo json_encode([
			'value' => get_object_vars($value),
		]);
		die;
	}

	/**
	 * update inventory min
	 * @param  integer $id
	 * @return redirect
	 */
	public function update_inventory_min($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			$success = $this->warehouse_model->update_inventory_min($data, $id);
			if ($success) {
				set_alert('success', _l('updated_successfully') . ' ' . _l('inventory'));
			} else {
				set_alert('warning', _l('updated_inventory_false'));
			}

			redirect(admin_url('warehouse/setting?group=inventory'));
		}
	}

	/**
	 * table warehouse history
	 *
	 * @return array
	 */
	public function table_warehouse_history() {
		$this->app->get_table_data(module_views_path('warehouse', 'table_warehouse_history'));
	}

	/**
	 * warehouse history
	 *
	 * @return view
	 */
	public function warehouse_history() {
		$data['title'] = _l('warehouse_history');

		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['commodity_filter'] = $this->warehouse_model->get_commodity();
		$this->load->view('warehouse/warehouse_history', $data);
	}

	/**
	 * approval setting
	 * @return redirect
	 */
	public function approval_setting() {
		if ($this->input->post()) {
			$data = $this->input->post();
			if ($data['approval_setting_id'] == '') {
				$message = '';
				$success = $this->warehouse_model->add_approval_setting($data);
				if ($success) {
					$message = _l('added_successfully', _l('approval_setting'));
				}
				set_alert('success', $message);
				redirect(admin_url('warehouse/setting?group=approval_setting'));
			} else {
				$message = '';
				$id = $data['approval_setting_id'];
				$success = $this->warehouse_model->edit_approval_setting($id, $data);
				if ($success) {
					$message = _l('updated_successfully', _l('approval_setting'));
				}
				set_alert('success', $message);
				redirect(admin_url('warehouse/setting?group=approval_setting'));
			}
		}
	}

	/**
	 * delete approval setting
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_approval_setting($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=approval_setting'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_approval_setting($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('approval_setting')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('payment_mode')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('approval_setting')));
		}
		redirect(admin_url('warehouse/setting?group=approval_setting'));
	}

	/**
	 * get html approval setting
	 * @param  integer $id
	 * @return html
	 */
	public function get_html_approval_setting($id = '') {
		$index=0;
		$html = '';
		$staffs = $this->staff_model->get();
		$approver = [
			0 => ['id' => 'direct_manager', 'name' => _l('direct_manager')],
			1 => ['id' => 'department_manager', 'name' => _l('department_manager')],
			2 => ['id' => 'staff', 'name' => _l('staff')]];
			$action = [
				1 => ['id' => 'approve', 'name' => _l('approve')],
				0 => ['id' => 'sign', 'name' => _l('sign')],
			];
			if (is_numeric($id)) {
				$approval_setting = $this->warehouse_model->get_approval_setting($id);

				$setting = json_decode($approval_setting->setting);

				foreach ($setting as $key => $value) {
					$index++;
					if ($key == 0) {
						$html .= '<div id="item_approve">
						<div class="col-md-11">
						<div class="col-md-4 hide"> ' .
						render_select('approver[' . $key . ']', $approver, array('id', 'name'), 'task_single_related', $value->approver) . '
						</div>
						<div class="col-md-8">
						' . render_select('staff[' . $key . ']', $staffs, array('staffid', 'full_name'), 'staff', $value->staff) . '
						</div>
						<div class="col-md-4 ">
						' . render_select('action[' . $key . ']', $action, array('id', 'name'), 'action_label', $value->action) . '
						</div>
						</div>
						<div class="col-md-1 button_class" >
						<span class="pull-bot">
						<button name="add" class="btn new_wh_approval btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
						</span>
						</div>
						</div>';
					} else {
						$html .= '<div id="item_approve">
						<div class="col-md-11">
						<div class="col-md-4 hide">
						' .
						render_select('approver[' . $key . ']', $approver, array('id', 'name'), 'task_single_related', $value->approver) . '
						</div>
						<div class="col-md-8">
						' . render_select('staff[' . $key . ']', $staffs, array('staffid', 'full_name'), 'staff', $value->staff) . '
						</div>
						<div class="col-md-4 ">
						' . render_select('action[' . $key . ']', $action, array('id', 'name'), 'action_label', $value->action) . '
						</div>
						</div>
						<div class="col-md-1 button_class" >
						<span class="pull-bot">
						<button name="add" class="btn remove_wh_approval btn-danger" data-ticket="true" type="button"><i class="fa fa-minus"></i></button>
						</span>
						</div>
						</div>';
					}
				}
			} else {
				$html .= '<div id="item_approve">
				<div class="col-md-11">
				<div class="col-md-4 hide"> ' .
				render_select('approver[0]', $approver, array('id', 'name'), 'task_single_related') . '
				</div>
				<div class="col-md-8">
				' . render_select('staff[0]', $staffs, array('staffid', 'full_name'), 'staff') . '
				</div>
				<div class="col-md-4 ">
				' . render_select('action[0]', $action, array('id', 'name'), 'action_label') . '
				</div>
				</div>
				<div class="col-md-1 button_class">
				<span class="pull-bot">
				<button name="add" class="btn new_wh_approval btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
				</span>
				</div>
				</div>';
			}

			echo json_encode([
				'html' => $html,
				'index' => $index,

			]);
		}

	/**
	 * send request approve
	 * @return json
	 */
	public function send_request_approve() {

		$data = $this->input->post();
		if($data['rel_type'] == '1'){
			$message = 'Send request approval fail';
			$success = $this->warehouse_model->send_request_approve($data);

		}elseif($data['rel_type'] == '2'){
			/*check send request with type =2 , inventory delivery voucher*/
			$check_r = $this->warehouse_model->check_inventory_delivery_voucher($data);

			if($check_r['flag_export_warehouse'] == 1){
				$message = 'Send request approval fail';
				$success = $this->warehouse_model->send_request_approve($data);

			}else{
				$message = $check_r['str_error'];
				$success = false;

				echo json_encode([
					'success' => $success,
					'message' => $message,
				]);
				die;

			}
		}elseif($data['rel_type'] == '3'){
			$message = 'Send request approval fail';
			$success = $this->warehouse_model->send_request_approve($data);

		}elseif($data['rel_type'] == '4'){
			/*check send request with type = 4 , internal delivery note*/
			$check_r = $this->warehouse_model->check_internal_delivery_note_send_request($data);

			if($check_r['flag_internal_delivery_warehouse'] == 1){
				$message = 'Send request approval fail';
				$success = $this->warehouse_model->send_request_approve($data);

			}else{
				$message = $check_r['str_error'];
				$success = false;

				echo json_encode([
					'success' => $success,
					'message' => $message,
				]);
				die;

			}

		}

		if ($success === true) {
			$message = 'Send request approval success';
			$data_new = [];
			$data_new['send_mail_approve'] = $data;
			$this->session->set_userdata($data_new);
		}elseif($success === false){
			$message = _l('no_matching_process_found');
			$success = false;

		} else {
			$message = _l('could_not_find_approver_with', _l($success));
			$success = false;
		}
		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}

	/**
	 * approve request
	 * @param  integer $id
	 * @return json
	 */
	public function approve_request() {
		$data = $this->input->post();

		$data['staff_approve'] = get_staff_user_id();
		$success = false;
		$code = '';
		$signature = '';

		if (isset($data['signature'])) {
			$signature = $data['signature'];
			unset($data['signature']);
		}
		$status_string = 'status_' . $data['approve'];
		$check_approve_status = $this->warehouse_model->check_approval_details($data['rel_id'], $data['rel_type']);


		if (isset($data['approve']) && in_array(get_staff_user_id(), $check_approve_status['staffid'])) {

			$success = $this->warehouse_model->update_approval_details($check_approve_status['id'], $data);

			$message = _l('approved_successfully');

			if ($success) {
				if ($data['approve'] == 1) {
					$message = _l('approved_successfully');
					$data_log = [];

					if ($signature != '') {
						$data_log['note'] = "signed_request";
					} else {
						$data_log['note'] = "approve_request";
					}
					if ($signature != '') {
						switch ($data['rel_type']) {
						// case 'stock_import 1':
							case 1:
							$path = WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;
						// case 'stock_export 2':
							case 2:
							$path = WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;

							case 3:
							$path = WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;

							case 4:
							$path = WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;


							default:
							$path = WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER;
							break;
						}
						warehouse_process_digital_signature_image($signature, $path, 'signature_' . $check_approve_status['id']);
						$message = _l('sign_successfully');
					}
					$data_log['rel_id'] = $data['rel_id'];
					$data_log['rel_type'] = $data['rel_type'];
					$data_log['staffid'] = get_staff_user_id();
					$data_log['date'] = date('Y-m-d H:i:s');

					$this->warehouse_model->add_activity_log($data_log);

					$check_approve_status = $this->warehouse_model->check_approval_details($data['rel_id'], $data['rel_type']);

					if ($check_approve_status === true) {
						$this->warehouse_model->update_approve_request($data['rel_id'], $data['rel_type'], 1);
					}
				} else {
					$message = _l('rejected_successfully');
					$data_log = [];
					$data_log['rel_id'] = $data['rel_id'];
					$data_log['rel_type'] = $data['rel_type'];
					$data_log['staffid'] = get_staff_user_id();
					$data_log['date'] = date('Y-m-d H:i:s');
					$data_log['note'] = "rejected_request";
					$this->warehouse_model->add_activity_log($data_log);
					$this->warehouse_model->update_approve_request($data['rel_id'], $data['rel_type'], '-1');
				}
			}
		}

		$data_new = [];
		$data_new['send_mail_approve'] = $data;
		$this->session->set_userdata($data_new);
		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die();
	}

	/**
	 * stock import pdf
	 * @param  integer $id
	 * @return pdf file view
	 */
	public function stock_import_pdf($id) {
		if (!$id) {
			redirect(admin_url('warehouse/manage_goods_receipt/manage_purchase'));
		}

		$stock_import = $this->warehouse_model->get_stock_import_pdf_html($id);
		try {
			$pdf = $this->warehouse_model->stock_import_pdf($stock_import);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';

		if ($this->input->get('output_type')) {
			$type = $this->input->get('output_type');
		}

		if ($this->input->get('print')) {
			$type = 'I';
		}

		$pdf->Output('goods_receipt_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);
	}

	/**
	 * send mail
	 * @param  integer $id
	 * @return json
	 */
	public function send_mail() {
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			if ((isset($data)) && $data != '') {
				$this->warehouse_model->send_mail($data);

				$success = 'success';
				echo json_encode([
					'success' => $success,
				]);
			}
		}
	}

	/**
	 * manage delivery
	 * @param  integer $id
	 * @return view
	 */
	public function manage_delivery($id = '') {
		$data['delivery_id'] = $id;
		$data['title'] = _l('stock_delivery_manage');
		$this->load->view('manage_goods_delivery/manage_delivery', $data);
	}

	/**
	 * goods delivery
	 * @return view
	 */
	public function goods_delivery($id ='', $edit_approval = false) {

		$this->load->model('clients_model');
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();



			if (!$this->input->post('id')) {
				$mess = $this->warehouse_model->add_goods_delivery($data);
				if ($mess) {

					if($data['save_and_send_request'] == 'true'){
						$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '2', 'addedfrom' => get_staff_user_id()]);
					}

					set_alert('success', _l('added_successfully'));

				} else {
					set_alert('warning', _l('Add_stock_delivery_docket_false'));
				}
				redirect(admin_url('warehouse/manage_delivery/'.$mess));

			}else{
				$id = $this->input->post('id');
				if($data['edit_approval'] == 'true'){
					$mess = $this->warehouse_model->update_goods_delivery_approval($data);

				}else{
					$mess = $this->warehouse_model->update_goods_delivery($data);

				}

				if($data['save_and_send_request'] == 'true'){
					$this->save_and_send_request_send_mail(['rel_id' => $id, 'rel_type' => '2', 'addedfrom' => get_staff_user_id()]);
				}

				if ($mess) {
					set_alert('success', _l('updated_successfully'));

				} else {
					set_alert('warning', _l('update_stock_delivery_docket_false'));
				}
				redirect(admin_url('warehouse/manage_delivery/'.$id));
			}

		}
		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();
		$data['taxes'] = $this->warehouse_model->get_taxes();

		$data['title'] = _l('goods_delivery');

		$data['commodity_codes'] = $this->warehouse_model->get_commodity();

		$data['warehouses'] = $this->warehouse_model->get_warehouse();


		if (get_status_modules_wh('purchase')) {
			if ($this->db->field_exists('delivery_status' ,db_prefix() . 'pur_orders')) { 
				$this->load->model('purchase/purchase_model');
				$this->load->model('departments_model');
				$this->load->model('staff_model');
				$this->load->model('projects_model');

				$data['pr_orders'] = $this->warehouse_model->get_pr_order_delivered();
				$data['pr_orders_status'] = true;

				$data['vendors'] = $this->purchase_model->get_vendor();

				$data['projects'] = $this->projects_model->get();
				$data['staffs'] = $this->staff_model->get();
				$data['departments'] = $this->departments_model->get();
			}else{
				$data['pr_orders'] = [];
				$data['pr_orders_status'] = false;
			}

		} else {
			$data['pr_orders'] = [];
			$data['pr_orders_status'] = false;
		}
		
		$data['customer_code'] = $this->clients_model->get();
		$data['invoices'] = $this->warehouse_model->get_invoices();
		$data['goods_code'] = $this->warehouse_model->create_goods_delivery_code();
		$data['staff'] = $this->warehouse_model->get_staff();
		$data['current_day'] = date('Y-m-d');

		if($id != ''){
			$goods_delivery = $this->warehouse_model->get_goods_delivery($id);
			if (!$goods_delivery) {
				blank_page('Stock export Not Found', 'danger');
			}
			$data['goods_delivery_detail'] = json_encode($this->warehouse_model->get_goods_delivery_detail($id));

			$data['goods_delivery'] = $goods_delivery;
		}

		//edit note after approval
		$data['edit_approval'] = $edit_approval;
		$data['projects']    = $this->projects_model->get_items();

		$this->load->view('manage_goods_delivery/delivery', $data);

	}

	/**
	 * commodity goods delivery change
	 * @param  integer $val
	 * @return json
	 */
	public function commodity_goods_delivery_change($val) {

		if ($val != 'null') {
			$value = $this->warehouse_model->commodity_goods_delivery_change($val);

			echo json_encode([
				'value' => $value['commodity_value'],
				'warehouse_inventory' => $value['warehouse_inventory'],
				'guarantee_new' => $value['guarantee_new'],
			]);
			die;
		}
	}

	/**
	 * table manage delivery
	 * @return array
	 */
	public function table_manage_delivery() {
		$this->app->get_table_data(module_views_path('warehouse', 'manage_goods_delivery/table_manage_delivery'));
	}

	/**
	 * edit delivery
	 * @param  integer $id
	 * @return view
	 */
	public function edit_delivery($id) {
		//check exist
		$goods_delivery = $this->warehouse_model->get_goods_delivery($id);
		if (!$goods_delivery) {
			blank_page('Stock export Not Found', 'danger');
		}

		//approval
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if ((isset($send_mail_approve)) && $send_mail_approve != '') {
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 2);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 2);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 2);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 2);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['goods_delivery_detail'] = json_encode($this->warehouse_model->get_goods_delivery_detail($id));

		$data['goods_delivery'] = $goods_delivery;
		$data['taxes'] = $this->warehouse_model->get_taxes();

		$data['title'] = _l('stock_export_info');
		$check_appr = $this->warehouse_model->get_approve_setting('2');
		$data['check_appr'] = $check_appr;

		$this->load->view('manage_goods_delivery/edit_delivery', $data);

	}

	/**
	 * stock export pdf
	 * @param  integer $id
	 * @return pdf file view
	 */
	public function stock_export_pdf($id) {
		if (!$id) {
			redirect(admin_url('warehouse/manage_goods_delivery/manage_delivery'));
		}

		$stock_export = $this->warehouse_model->get_stock_export_pdf_html($id);

		try {
			$pdf = $this->warehouse_model->stock_export_pdf($stock_export);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';

		if ($this->input->get('output_type')) {
			$type = $this->input->get('output_type');
		}

		if ($this->input->get('print')) {
			$type = 'I';
		}

		$pdf->Output('goods_delivery_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);
	}

	/**
	 * manage report
	 * @return view
	 */
	public function manage_report() {
		$data['group'] = $this->input->get('group');

		$data['title'] = _l('als_report');
		$data['tab'][] = 'stock_summary_report';
		$data['tab'][] = 'inventory_inside';
		$data['tab'][] = 'inventory_valuation_report';

		switch ($data['group']) {
			case 'stock_summary_report':
			$data['title'] = _l('stock_summary_report');

			break;
			case 'inventory_valuation_report':
			$data['title'] = _l('inventory_valuation_report');

			break;
			case 'inventory_inside':
			$data['title'] = _l('inventory_inside');

			break;


			default:
			$data['title'] = _l('stock_summary_report');
			$data['group'] = 'stock_summary_report';
			break;
		}
		$data['commodity_filter'] = $this->warehouse_model->get_commodity_active();
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();

		$data['tabs']['view'] = 'report/' . $data['group'];

		$this->load->view('report/manage_report', $data);
	}

	/**
	 * get data stock summary report
	 * @return json
	 */
	public function get_data_stock_summary_report() {
		if ($this->input->post()) {
			$data = $this->input->post();

			$stock_summary_report = $this->warehouse_model->get_stock_summary_report_view($data);
		}

		echo json_encode([
			'value' => $stock_summary_report,
		]);
		die();
	}

	/**
	 * stock summary report pdf
	 * @return pdf view file
	 */
	public function stock_summary_report_pdf() {
		$data = $this->input->post();
		if (!$data) {
			redirect(admin_url('warehouse/report/manage_report'));
		}

		$stock_summary_report = $this->warehouse_model->get_stock_summary_report($data);

		try {
			$pdf = $this->warehouse_model->stock_summary_report_pdf($stock_summary_report);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';

		if ($this->input->get('output_type')) {
			$type = $this->input->get('output_type');
		}

		if ($this->input->get('print')) {
			$type = 'I';
		}

		$pdf->Output('stock_summary_report.pdf', $type);
	}

	/**
	 * view delivery
	 * @param  integer $id
	 * @return view
	 */
	public function view_delivery($id) {
		//approval
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if ((isset($send_mail_approve)) && $send_mail_approve != '') {
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 2);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 2);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 2);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 2);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['goods_delivery_detail'] = $this->warehouse_model->get_goods_delivery_detail($id);

		$data['goods_delivery'] = $this->warehouse_model->get_goods_delivery($id);

		$data['title'] = _l('stock_export_info');
		$check_appr = $this->warehouse_model->get_approve_setting('2');
		$data['check_appr'] = $check_appr;

		$this->load->view('manage_goods_delivery/view_delivery', $data);

	}

	/**
	 * check quantity inventory
	 * @return json
	 */
	public function check_quantity_inventory() {
		$data = $this->input->post();
		if ($data != 'null') {
			/*check without checking warehouse*/
			if($this->warehouse_model->check_item_without_checking_warehouse($data['commodity_id']) == true){
				//checking

				$value = $this->warehouse_model->get_quantity_inventory($data['warehouse_id'], $data['commodity_id']);

				$quantity = 0;
				if ($value != null) {

					if ((float) get_object_vars($value)['inventory_number'] < (float) $data['quantity']) {
						$message = _l('in_stock');
						$quantity = (float)get_object_vars($value)['inventory_number'];
					} else {
						$message = true;
						$quantity = (float)get_object_vars($value)['inventory_number'];
					}

				} else {
					$message = _l('Product_does_not_exist_in_stock');
				}

			}else{
				//without checking
				$message = true;
				$quantity = 0;

			}

			echo json_encode([
				'message' => $message,
				'value' => $quantity,
			]);
			die;
		}
	}

	/**
	 *  quantity inventory
	 * @return json
	 */
	public function quantity_inventory() {
		$data = $this->input->post();
		if ($data != 'null') {

			$value = $this->warehouse_model->get_adjustment_stock_quantity($data['warehouse_id'], $data['commodity_id'], $data['lot_number'], $data['expiry_date']);

			$unit = $this->warehouse_model->get_commodity_hansometable($data['commodity_id']);
			$quantity = 0;
			if ($value != null) {

				$message = _l('in_stock');
				$quantity = get_object_vars($value)['inventory_number'];

			} else {
				$message = _l('Product_does_not_exist_in_stock');
			}

			echo json_encode([
				'message' => $message,
				'value' => $quantity,
				'unit' => $unit->unit_id,
			]);
			die;
		}
	}

	/**
	 * check quantity inventory onsubmit
	 * @return json
	 */
	public function check_quantity_inventory_onsubmit() {
		$data = $this->input->post();
		$flag = 0;
		$message = true;

		$str_error='';

		$arr_available_quantity=[];

		
		if ($data['hot_delivery'] != 'null') {
			foreach ($data['hot_delivery'] as $delivery_value) {
				if ( $delivery_value[0] != '' ) {
					if($delivery_value[1] != '' || $data['warehouse_id'] != ''){
						//check without checking warehouse
						
						if($data['warehouse_id'] != ''){
							$delivery_value[1] = $data['warehouse_id'];
						}

						$commodity_name='';
						$item_value = $this->warehouse_model->get_commodity($delivery_value[0]);

						if($item_value){
							$commodity_name .= $item_value->commodity_code.'_'.$item_value->description;
						}

						if($this->warehouse_model->check_item_without_checking_warehouse($delivery_value[0]) == true){

							$value = $this->warehouse_model->get_quantity_inventory($delivery_value[1], $delivery_value[0]);

							if ($value != null) {
								array_push($arr_available_quantity, (float) get_object_vars($value)['inventory_number']);
								// if ((float) get_object_vars($value)['inventory_number'] < (float) $delivery_value[2]) {
								if ((float) get_object_vars($value)['inventory_number'] < (float) $delivery_value[4]) {
									$flag = 1;
									$str_error .= $commodity_name._l('not_enough_inventory').', '._l('available_quantity').': '.(float) get_object_vars($value)['inventory_number'].'<br/>';
								}
							} else {
								$flag = 1;
								$str_error .=$commodity_name. _l('Product_does_not_exist_in_stock').'<br/>';
							}
						}

					}else{
						$flag = 1;
						$str_error .= _l('please_choose_from_stock_name').'<br/>';
					}
				}

			}
			
			if ($flag == 1) {
				$message = false;

			} else {
				$message = true;
			}

			echo json_encode([
				'message' => $message,
				'str_error' => $str_error,
				'arr_available_quantity' => $arr_available_quantity,

			]);
			die;
		}
	}

	/**
	 * manage stock take
	 * @param  integer $id
	 * @return view
	 */
	public function manage_stock_take($id = '') {
		$data['stock_take_id'] = $id;
		$data['title'] = _l('stock_take');
		$this->load->view('manage_stock_take/manage', $data);
	}

	/**
	 * table manage stock table
	 * @return array
	 */
	public function table_manage_stock_take() {
		$this->app->get_table_data(module_views_path('warehouse', 'manage_stock_take/table_manage_stock_take'));
	}

	/**
	 * stock take
	 * @param  integer $id
	 * @return view
	 */
	public function stock_take() {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_goods_receipt($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('stock_take'));

				} else {
					set_alert('warning', _l('Add_stock_take_false'));
				}
				redirect(admin_url('warehouse/manage_stock_take'));

			}
		}
		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['title'] = _l('inventory_goods_materials');

		$data['commodity_codes'] = $this->warehouse_model->get_commodity();

		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		if (get_status_modules_wh('purchase')) {
			$data['pr_orders'] = get_pr_order();
		} else {
			$data['pr_orders'] = [];
		}

		$data['vendors'] = $this->warehouse_model->get_vendor();

		$data['goods_code'] = $this->warehouse_model->create_goods_code();
		$data['staff'] = $this->warehouse_model->get_staff();

		$this->load->view('manage_stock_take/stock_take', $data);

	}

	/**
	 * commodity list add edit
	 * @param  integer $id
	 * @return json
	 */
	public function commodity_list_add_edit($id = '') {
		$data = $this->input->post();

		if ($data) {

			if (!isset($data['id'])) {
				$data['long_descriptions'] = $this->input->post('long_descriptions', false);
				$data['tags'] = $data['formdata'][7]['value'];

				$ids = $this->warehouse_model->add_commodity_one_item($data);
				if ($ids) {

					// handle commodity list add edit file
					$success = true;
					$message = _l('added_successfully');
					set_alert('success', $message);
					/*upload multifile*/
					echo json_encode([
						'url' => admin_url('warehouse/view_commodity_detail/' . $ids),
						'commodityid' => $ids,
					]);
					die;

				}
				echo json_encode([
					'url' => admin_url('warehouse/commodity_list'),
				]);
				die;

			} else {
				
				$data['tags'] = $data['formdata'][8]['value'];

				$data['long_descriptions'] = $this->input->post('long_descriptions', false);

				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->update_commodity_one_item($data, $id);

				/*update file*/

				if ($success == true) {

					$message = _l('updated_successfully');
					set_alert('success', $message);
				}

				echo json_encode([
					'url' => admin_url('warehouse/view_commodity_detail/' . $id),
					'commodityid' => $id,
				]);
				die;

			}
		}

	}

	/**
	 * get commodity file url
	 * @param  integer $commodity_id
	 * @return json
	 */
	public function get_commodity_file_url($commodity_id) {
		$arr_commodity_file = $this->warehouse_model->get_warehourse_attachments($commodity_id);
		/*get images old*/
		$images_old_value = '';

		if (count($arr_commodity_file) > 0) {
			foreach ($arr_commodity_file as $key => $value) {
				$images_old_value .= '<div class="dz-preview dz-image-preview image_old' . $value["id"] . '">';

				$images_old_value .= '<div class="dz-image">';
				if (file_exists(WAREHOUSE_ITEM_UPLOAD . $value["rel_id"] . '/' . $value["file_name"])) {
					$images_old_value .= '<img class="image-w-h" data-dz-thumbnail alt="' . $value["file_name"] . '" src="' . site_url('modules/warehouse/uploads/item_img/' . $value["rel_id"] . '/' . $value["file_name"]) . '">';
				} elseif(file_exists('modules/purchase/uploads/item_img/'. $value["rel_id"] . '/' . $value["file_name"])) {
					$images_old_value .= '<img class="image-w-h" data-dz-thumbnail alt="' . $value["file_name"] . '" src="' . site_url('modules/purchase/uploads/item_img/' . $value["rel_id"] . '/' . $value["file_name"]) . '">';
				}

				if (file_exists(WAREHOUSE_ITEM_UPLOAD . $value["rel_id"] . '/' . $value["file_name"])) {
					$images_old_value .= '</div>';

					$images_old_value .= '<div class="dz-error-mark">';
					$images_old_value .= '<a class="dz-remove" data-dz-remove>Remove file';
					$images_old_value .= '</a>';
					$images_old_value .= '</div>';

					$images_old_value .= '<div class="remove_file">';
					$images_old_value .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,' . $value["id"] . '); return false;"><i class="fa fa fa-times"></i></a>';
					$images_old_value .= '</div>';

					$images_old_value .= '</div>';
				}
			}
		}

		echo json_encode([
			'arr_images' => $images_old_value,
		]);
		die();

	}

	/**
	 * sub group
	 * @param  integer $id
	 * @return redirect
	 */
	public function sub_group($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_sub_group($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . ' ' . _l('sub_group'));

				} else {
					set_alert('warning', _l('Add_sub_group_false'));
				}
				redirect(admin_url('warehouse/setting?group=sub_group'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_sub_group($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . ' ' . _l('sub_group'));
				} else {
					set_alert('warning', _l('updated_sub_group_false'));
				}

				redirect(admin_url('warehouse/setting?group=sub_group'));
			}
		}
	}

	/**
	 * delete sub group
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_sub_group($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=sub_group'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}


		$response = $this->warehouse_model->delete_sub_group($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('sub_group')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('sub_group')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('sub_group')));
		}
		redirect(admin_url('warehouse/setting?group=sub_group'));
	}

	/**
	 * add commodity attachment
	 * @param  integer $id
	 * @return json
	 */
	public function add_commodity_attachment($id) {

		handle_commodity_attachments($id);
		echo json_encode([

			'url' => admin_url('warehouse/commodity_list'),
		]);
	}

	/**
	 * import xlsx commodity
	 * @param  integer $id
	 * @return view
	 */
	public function import_xlsx_commodity() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			access_denied('warehouse');
		}
		$this->load->model('staff_model');
		$data_staff = $this->staff_model->get(get_staff_user_id());

		/*get language active*/
		if ($data_staff) {
			if ($data_staff->default_language != '') {
				$data['active_language'] = $data_staff->default_language;

			} else {

				$data['active_language'] = get_option('active_language');
			}

		} else {
			$data['active_language'] = get_option('active_language');
		}
		$data['title'] = _l('import_excel');

		$this->load->view('warehouse/import_excel', $data);
	}

	/**
	 * import file xlsx commodity
	 * @return json
	 */
	public function import_file_xlsx_commodity() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			access_denied(_l('warehouse'));
		}

		$total_row_false = 0;
		$total_rows_data = 0;
		$dataerror = 0;
		$total_row_success = 0;
		$total_rows_data_error = 0;
		$filename='';

		if ($this->input->post()) {

			/*delete file old before export file*/
			$path_before = COMMODITY_ERROR.'FILE_ERROR_COMMODITY'.get_staff_user_id().'.xlsx';
			if(file_exists($path_before)){
				unlink(COMMODITY_ERROR.'FILE_ERROR_COMMODITY'.get_staff_user_id().'.xlsx');
			}

			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {
				//do_action('before_import_leads');

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
					$tmpDir = TEMP_FOLDER . '/' . time() . uniqid() . '/';

					if (!file_exists(TEMP_FOLDER)) {
						mkdir(TEMP_FOLDER, 0755);
					}

					if (!file_exists($tmpDir)) {
						mkdir($tmpDir, 0755);
					}

					// Setup our new file path
					$newFilePath = $tmpDir . $_FILES['file_csv']['name'];

					if (move_uploaded_file($tmpFilePath, $newFilePath)) {
						$import_result = true;
						$rows = [];

						$objReader = new PHPExcel_Reader_Excel2007();
						$objReader->setReadDataOnly(true);
						$objPHPExcel = $objReader->load($newFilePath);
						$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
						$sheet = $objPHPExcel->getActiveSheet();

						//innit  file exel error start

						$dataError = new PHPExcel();
						$dataError->setActiveSheetIndex(0);
						//create header file

						// add style to the header
						$styleArray = array(
							'font' => array(
								'bold' => true,

							),

							'borders' => array(
								'top' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
								),
							),
							'fill' => array(

								'rotation' => 90,
								'startcolor' => array(
									'argb' => 'FFA0A0A0',
								),
								'endcolor' => array(
									'argb' => 'FFFFFFFF',
								),
							),
						);

						// set the names of header cells
						$dataError->setActiveSheetIndex(0)

						->setCellValue("A1", "(*)" . _l('commodity_code'))
						->setCellValue("B1", "(*)" . _l('commodity_name'))
						->setCellValue("C1", _l('commodity_barcode'))
						->setCellValue("D1", _l('sku_code'))
						->setCellValue("E1", _l('sku_name'))
						->setCellValue("F1", _l('Tags'))
						->setCellValue("G1", _l('description'))

						->setCellValue("H1", _l('commodity_type'))
						->setCellValue("I1", _l('unit_id'))
						->setCellValue("J1", "(*)" . _l('commodity_group'))
						->setCellValue("K1", _l('sub_group'))
						->setCellValue("L1", _l('_profit_rate'). "(%)")
						->setCellValue("M1", _l('purchase_price'))
						->setCellValue("N1", "(*)" . _l('rate'))
						->setCellValue("O1", _l('tax'))
						->setCellValue("P1", _l('origin'))
						->setCellValue("Q1", _l('style_id'))
						->setCellValue("R1", _l('model_id'))
						->setCellValue("S1", _l('size_id'))
						->setCellValue("T1", _l('_color'))
						->setCellValue("U1", _l('guarantee_month'))
						->setCellValue("V1", _l('minimum_inventory'))
						->setCellValue("W1", _l('error'));


						/*set style for header*/
						$dataError->getActiveSheet()->getStyle('A1:W1')->applyFromArray($styleArray);

						// auto fit column to content

						foreach (range('A', 'W') as $columnID) {
							$dataError->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);

						}

						$dataError->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$dataError->getActiveSheet()->getStyle('A1:W1')->getFill()->getStartColor()->setARGB('29bb04');
						// Add some data
						$dataError->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
						$dataError->getActiveSheet()->getStyle('A1:W1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

						/*set header middle alignment*/
						$dataError->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$dataError->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						/*set row1 height*/
						$dataError->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

						//init file error end

						// start row write 2
						$numRow = 2;
						$total_rows = 0;

						$total_rows_actualy = 0;

						$flag_insert_id = 0;
						
						//get data for compare

						foreach ($rowIterator as $row) {
							$rowIndex = $row->getRowIndex();
							if ($rowIndex > 1) {
								$rd = array();
								$flag = 0;
								$flag2 = 0;
								$flag_mail = 0;
								$string_error = '';
								$flag_contract_form = 0;

								$flag_id_commodity_type;
								$flag_id_unit_id;
								$flag_id_commodity_group;
								$flag_id_sub_group;
								$flag_id_warehouse_id;
								$flag_id_tax;
								$flag_id_style_id;
								$flag_id_model_id;
								$flag_id_size_id;



								$value_cell_commodity_code = $sheet->getCell('A' . $rowIndex)->getValue();
								$value_cell_description = $sheet->getCell('B' . $rowIndex)->getValue();

								$value_cell_commodity_group = $sheet->getCell('J' . $rowIndex)->getValue();

								$value_cell_commodity_type = $sheet->getCell('H' . $rowIndex)->getValue();
								$value_cell_unit_id = $sheet->getCell('I' . $rowIndex)->getValue();

								$value_cell_sub_group = $sheet->getCell('K' . $rowIndex)->getValue();
								$value_cell_warranty = $sheet->getCell('U' . $rowIndex)->getValue();
								$value_cell_tax = $sheet->getCell('O' . $rowIndex)->getValue();
								$value_cell_style_id = $sheet->getCell('Q' . $rowIndex)->getValue();
								$value_cell_model_id = $sheet->getCell('R' . $rowIndex)->getValue();
								$value_cell_size_id = $sheet->getCell('S' . $rowIndex)->getValue();
								$value_cell_minimum_inventory = $sheet->getCell('V' . $rowIndex)->getValue();


								$value_cell_rate = $sheet->getCell('N' . $rowIndex)->getValue();
								$value_cell_purchase_price = $sheet->getCell('M' . $rowIndex)->getValue();

								$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';

								$reg_day = '#^(((1)[0-2]))(\/)\d{4}-(3)[0-1])(\/)(((0)[0-9])-[0-2][0-9]$#'; /*yyyy-mm-dd*/

								/*check null*/
								if (is_null($value_cell_commodity_code) == true) {
									$string_error .= _l('commodity_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_commodity_group) == true) {
									$string_error .= _l('commodity_group') . _l('not_yet_entered');
									$flag = 1;
								}


								if (is_null($value_cell_description) == true) {
									$string_error .= _l('commodity_name') . _l('not_yet_entered');
									$flag = 1;
								}

								//check commodity_type exist  (input: id or name contract)
								if (is_null($value_cell_commodity_type) != true && $value_cell_commodity_type != '0' ) {
									/*case input  id*/
									if (is_numeric($value_cell_commodity_type)) {

										$this->db->where('commodity_type_id', $value_cell_commodity_type);
										$commodity_type_value = $this->db->count_all_results(db_prefix() . 'ware_commodity_type');

										if ($commodity_type_value == 0) {
											$string_error .= _l('commodity_type') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_type*/
											$flag_id_commodity_type = $value_cell_commodity_type;
										}

									} else {
										/*case input name*/
										$this->db->like(db_prefix() . 'ware_commodity_type.commondity_code', $value_cell_commodity_type);

										$commodity_type_value = $this->db->get(db_prefix() . 'ware_commodity_type')->result_array();
										if (count($commodity_type_value) == 0) {
											$string_error .= _l('commodity_type') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_type*/

											$flag_id_commodity_type = $commodity_type_value[0]['commodity_type_id'];
										}
									}

								}

								//check unit_code exist  (input: id or name contract)
								if (is_null($value_cell_unit_id) != true && ( $value_cell_unit_id != '0')) {
									/*case input id*/
									if (is_numeric($value_cell_unit_id)) {

										$this->db->where('unit_type_id', $value_cell_unit_id);
										$unit_id_value = $this->db->count_all_results(db_prefix() . 'ware_unit_type');

										if ($unit_id_value == 0) {
											$string_error .= _l('unit_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id unit_id*/
											$flag_id_unit_id = $value_cell_unit_id;
										}

									} else {
										/*case input name*/
										$this->db->like(db_prefix() . 'ware_unit_type.unit_code', $value_cell_unit_id);

										$unit_id_value = $this->db->get(db_prefix() . 'ware_unit_type')->result_array();
										if (count($unit_id_value) == 0) {
											$string_error .= _l('unit_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get unit_id*/
											$flag_id_unit_id = $unit_id_value[0]['unit_type_id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_commodity_group) != true && ($value_cell_commodity_group != '0')) {
									/*case input id*/
									if (is_numeric($value_cell_commodity_group)) {

										$this->db->where('id', $value_cell_commodity_group);
										$commodity_group_value = $this->db->count_all_results(db_prefix() . 'items_groups');

										if ($commodity_group_value == 0) {
											$string_error .= _l('commodity_group') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_group*/
											$flag_id_commodity_group = $value_cell_commodity_group;
										}

									} else {
										/*case input name*/
										$this->db->like(db_prefix() . 'items_groups.commodity_group_code', $value_cell_commodity_group);

										$commodity_group_value = $this->db->get(db_prefix() . 'items_groups')->result_array();
										if (count($commodity_group_value) == 0) {
											$string_error .= _l('commodity_group') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_group*/

											$flag_id_commodity_group = $commodity_group_value[0]['id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_warranty) != true) {
									/*case input id*/
									if (!is_numeric($value_cell_warranty)) {
										/*case input name*/
										$string_error .= _l('guarantee_month') . _l('_check_invalid');
										$flag2 = 1;
										
									}

								}


								//check taxes exist  (input: id or name contract)
								if (is_null($value_cell_tax) != true && ($value_cell_tax!= '0')) {
									/*case input id*/
									if (is_numeric($value_cell_tax)) {

										$this->db->where('id', $value_cell_tax);
										$cell_tax_value = $this->db->count_all_results(db_prefix() . 'taxes');

										if ($cell_tax_value == 0) {
											$string_error .= _l('tax') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id cell_tax*/
											$flag_id_tax = $value_cell_tax;
										}

									} else {
										/*case input name*/
										$this->db->like(db_prefix() . 'taxes.name', $value_cell_tax);

										$cell_tax_value = $this->db->get(db_prefix() . 'taxes')->result_array();
										if (count($cell_tax_value) == 0) {
											$string_error .= _l('tax') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id warehouse_id*/

											$flag_id_tax = $cell_tax_value[0]['id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_sub_group) != true) {
									/*case input id*/
									if (is_numeric($value_cell_sub_group)) {

										$this->db->where('id', $value_cell_sub_group);
										$sub_group_value = $this->db->count_all_results(db_prefix() . 'wh_sub_group');

										if ($sub_group_value == 0) {
											$string_error .= _l('sub_group') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id sub_group*/
											$flag_id_sub_group = $value_cell_sub_group;
										}

									} else {
										/*case input  name*/
										$this->db->like(db_prefix() . 'wh_sub_group.sub_group_code', $value_cell_sub_group);

										$sub_group_value = $this->db->get(db_prefix() . 'wh_sub_group')->result_array();
										if (count($sub_group_value) == 0) {
											$string_error .= _l('sub_group') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id sub_group*/

											$flag_id_sub_group = $sub_group_value[0]['id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_style_id) != true && ($value_cell_style_id != '0')) {
									/*case input id*/
									if (is_numeric($value_cell_style_id)) {

										$this->db->where('style_type_id', $value_cell_style_id);
										$style_id_value = $this->db->count_all_results(db_prefix() . 'ware_style_type');

										if ($style_id_value == 0) {
											$string_error .= _l('style_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id style_id*/
											$flag_id_style_id = $value_cell_style_id;
										}

									} else {
										/*case input  name*/
										$this->db->like(db_prefix() . 'ware_style_type.style_code', $value_cell_style_id);

										$style_id_value = $this->db->get(db_prefix() . 'ware_style_type')->result_array();
										if (count($style_id_value) == 0) {
											$string_error .= _l('style_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id style_id*/

											$flag_id_style_id = $style_id_value[0]['style_type_id'];
										}
									}

								}

								//check body_code exist  (input: id or name contract)
								if (is_null($value_cell_model_id) != true && ($value_cell_model_id != '0')) {
									/*case input id*/
									if (is_numeric($value_cell_model_id)) {

										$this->db->where('body_type_id', $value_cell_model_id);
										$model_id_value = $this->db->count_all_results(db_prefix() . 'ware_body_type');

										if ($model_id_value == 0) {
											$string_error .= _l('model_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id model_id*/
											$flag_id_model_id = $value_cell_model_id;
										}

									} else {
										/*case input name*/
										$this->db->like(db_prefix() . 'ware_body_type.body_code', $value_cell_model_id);

										$model_id_value = $this->db->get(db_prefix() . 'ware_body_type')->result_array();
										if (count($model_id_value) == 0) {
											$string_error .= _l('model_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id model_id*/

											$flag_id_model_id = $model_id_value[0]['body_type_id'];
										}
									}

								}

								//check size_code exist  (input: id or name contract)
								if (is_null($value_cell_size_id) != true && ($value_cell_size_id != '0')) {
									/*case input id*/
									if (is_numeric($value_cell_size_id)) {

										$this->db->where('size_type_id', $value_cell_size_id);
										$size_id_value = $this->db->count_all_results(db_prefix() . 'ware_size_type');

										if ($size_id_value == 0) {
											$string_error .= _l('size_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id size_id*/
											$flag_id_size_id = $value_cell_size_id;
										}

									} else {
										/*case input name*/
										$this->db->like(db_prefix() . 'ware_size_type.size_code', $value_cell_size_id);

										$size_id_value = $this->db->get(db_prefix() . 'ware_size_type')->result_array();
										if (count($size_id_value) == 0) {
											$string_error .= _l('size_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id size_id*/

											$flag_id_size_id = $size_id_value[0]['size_type_id'];
										}
									}

								}

								//check value_cell_rate input
								if (is_null($value_cell_rate) != true) {
									if (!is_numeric($value_cell_rate)) {
										$string_error .= _l('cell_rate') . _l('_check_invalid');
										$flag = 1;

									}

								}

								//check value_cell_rate input
								if (is_null($value_cell_purchase_price) != true) {
									if (!is_numeric($value_cell_purchase_price)) {
										$string_error .= _l('purchase_price') . _l('_check_invalid');
										$flag = 1;

									}

								}

								//check commodity min input
								if (is_null($value_cell_minimum_inventory) != true) {
									if (!is_numeric($value_cell_minimum_inventory)) {
										$string_error .= _l('inventory_min') . _l('_check_invalid');
										$flag = 1;

									}

								}

								

								

								if (($flag == 0) && ($flag2 == 0)) {


									/*staff id is HR_code, input is HR_CODE, insert => staffid*/
									$rd['commodity_code'] = $sheet->getCell('A' . $rowIndex)->getValue();
									$rd['commodity_barcode'] = $sheet->getCell('C' . $rowIndex)->getValue();
									$rd['sku_code'] = $sheet->getCell('D' . $rowIndex)->getValue();
									$rd['sku_name'] = $sheet->getCell('E' . $rowIndex)->getValue();
									$rd['description'] = $sheet->getCell('B' . $rowIndex)->getValue();
									$rd['tags'] = $sheet->getCell('F' . $rowIndex)->getValue();
									$rd['long_description'] = $sheet->getCell('G' . $rowIndex)->getValue();

									$rd['commodity_type'] = isset($flag_id_commodity_type) ? $flag_id_commodity_type : '';
									$rd['unit_id'] = isset($flag_id_unit_id) ? $flag_id_unit_id : '';
									$rd['group_id'] = isset($flag_id_commodity_group) ? $flag_id_commodity_group : '';
									$rd['sub_group'] = isset($flag_id_sub_group) ? $flag_id_sub_group : '';
									$rd['guarantee'] = $sheet->getCell('U' . $rowIndex)->getValue();
									$rd['tax'] = isset($flag_id_tax) ? $flag_id_tax : '';

									$rd['origin'] = $sheet->getCell('P' . $rowIndex)->getValue();

									$rd['style_id'] = isset($flag_id_style_id) ? $flag_id_style_id : '';
									$rd['model_id'] = isset($flag_id_model_id) ? $flag_id_model_id : '';
									$rd['size_id'] = isset($flag_id_size_id) ? $flag_id_size_id : '';
									$rd['color_id'] = 0;
									$rd['warehouse_id'] = 0;

									$rd['profif_ratio'] = $sheet->getCell('L' . $rowIndex)->getValue();

									$rd['rate'] = $sheet->getCell('N' . $rowIndex)->getValue();
									$rd['purchase_price'] = $sheet->getCell('M' . $rowIndex)->getValue();
									$rd['minimum_inventory'] = isset($value_cell_minimum_inventory) ? $value_cell_minimum_inventory : 0;

								}

								$flag_insert = false;

								if (get_staff_user_id() != '' && $flag == 0 && $flag2 == 0) {
									$rows[] = $rd;
									$result_value = $this->warehouse_model->import_xlsx_commodity($rd, $flag_insert_id);
									if ($result_value['status']) {
										$total_rows_actualy++;
										$flag_insert = true;

										if(isset($result_value['insert_id'])){
											$flag_insert_id = $result_value['insert_id'];
										}else{
											$flag_insert_id = 0;
										}
									}else{
										$flag_insert_id = 0;
										$string_error .= $result_value['message'];
									}
								}

								if (($flag == 1) || ($flag2 == 1) || ($flag_insert == false)) {
									$dataError->getActiveSheet()->setCellValue('A' . $numRow, $sheet->getCell('A' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('B' . $numRow, $sheet->getCell('B' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('C' . $numRow, $sheet->getCell('C' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('D' . $numRow, $sheet->getCell('D' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('E' . $numRow, $sheet->getCell('E' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('F' . $numRow, $sheet->getCell('F' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('G' . $numRow, $sheet->getCell('G' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('H' . $numRow, $sheet->getCell('H' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('I' . $numRow, $sheet->getCell('I' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('J' . $numRow, $sheet->getCell('J' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('K' . $numRow, $sheet->getCell('K' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('M' . $numRow, $sheet->getCell('M' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('N' . $numRow, $sheet->getCell('N' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('O' . $numRow, $sheet->getCell('O' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('P' . $numRow, $sheet->getCell('P' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('Q' . $numRow, $sheet->getCell('Q' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('R' . $numRow, $sheet->getCell('R' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('R' . $numRow, $sheet->getCell('R' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('S' . $numRow, $sheet->getCell('S' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('T' . $numRow, $sheet->getCell('T' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('U' . $numRow, $sheet->getCell('U' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('V' . $numRow, $sheet->getCell('V' . $rowIndex)->getValue());


									$dataError->getActiveSheet()->setCellValue('W' . $numRow, $string_error)->getStyle('W' . $numRow)->applyFromArray($styleArray);

									$numRow++;
									$total_rows_data_error++;
								}

								$total_rows++;
								$total_rows_data++;
							}

						}

						if ($total_rows_actualy != $total_rows) {
							$total_rows = $total_rows_actualy;
						}


						$total_rows = $total_rows;
						$data['total_rows_post'] = count($rows);
						$total_row_success = $total_rows_actualy;
						$total_row_false = $total_rows - (int)$total_rows_actualy;
						$dataerror = $dataError;
						$message = 'Not enought rows for importing';

						if(($total_rows_data_error > 0) || ($total_row_false != 0)){
							$objWriter = new PHPExcel_Writer_Excel2007($dataError);

							$filename = 'FILE_ERROR_COMMODITY' .get_staff_user_id().strtotime(date('Y-m-d H:i:s')). '.xlsx';
							$objWriter->save(str_replace($filename, WAREHOUSE_IMPORT_ITEM_ERROR.$filename, $filename));

							$filename = WAREHOUSE_IMPORT_ITEM_ERROR.$filename;


						}
						
						$import_result = true;
						@delete_dir($tmpDir);

					}
					
				} else {
					set_alert('warning', _l('import_upload_failed'));
				}
			}

		}
		echo json_encode([
			'message' =>'Not enought rows for importing',
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_rows_data_error,
			'total_rows' => $total_rows_data,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'total_rows_data_error' => $total_rows_data_error,
			'filename' => $filename,
		]);

	}

	/**
	 * delete commodity file
	 * @param  integer $attachment_id
	 * @return json
	 */
	public function delete_commodity_file($attachment_id) {
		if (!has_permission('warehouse', '', 'delete') && !is_admin()) {
			access_denied('warehouse');
		}

		$file = $this->misc_model->get_file($attachment_id);
		echo json_encode([
			'success' => $this->warehouse_model->delete_commodity_file($attachment_id),
		]);
	}

	/**
	 * [colors_setting description]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function colors_setting($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_color($data);
				if ($mess) {
					set_alert('success', _l('added_successfully'));

				} else {
					set_alert('warning', _l('Add_commodity_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=colors'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->update_color($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully'));
				} else {
					set_alert('warning', _l('updated_commodity_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=colors'));
			}
		}
	}

	/**
	 * [delete_color description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete_color($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=colors'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_color($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=colors'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=colors'));
		}

	}

	/**
	 * { loss adjustment }
	 */
	public function loss_adjustment() {
		$data['title'] = _l('loss_adjustment');
		$this->load->view('loss_adjustment/manage', $data);
	}

	/**
	 * { loss adjustment table }
	 */
	public function loss_adjustment_table() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {

				$time_filter = $this->input->post('time_filter');
				$date_create = $this->input->post('date_create');
				$type_filter = $this->input->post('type_filter');
				$status_filter = $this->input->post('status_filter');

				$query = '';
				if ($time_filter != '') {
					$query .= 'month(time) = month(\'' . $time_filter . '\') and day(time) = day(\'' . $time_filter . '\') and year(time) = year(\'' . $time_filter . '\') and ';
				}
				if ($date_create != '') {
					$query .= 'month(date_create) = month(\'' . $date_create . '\') and day(date_create) = day(\'' . $date_create . '\') and year(date_create) = year(\'' . $date_create . '\') and ';
				}
				if ($status_filter != '') {
					$query .= 'status = \'' . $status_filter . '\' and ';
				}
				$select = [

					'id',
					'id',
					'id',
					'id',
					'id',
					'id',
					'id',

				];
				$where = [(($query != '') ? ' where ' . rtrim($query, ' and ') : '')];

				$aColumns = $select;
				$sIndexColumn = 'id';
				$sTable = db_prefix() . 'wh_loss_adjustment';
				$join = [];

				$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [

					'time',
					'type',
					'reason',
					'addfrom',
					'status',
					'date_create',
				]);

				$output = $result['output'];
				$rResult = $result['rResult'];
				foreach ($rResult as $aRow) {
					$row = [];
					$allow_add = 0;
					if ($type_filter != '') {
						if ($type_filter == 'loss') {
							if ($aRow['type'] == 'loss') {
								$allow_add = 1;
							}
						}
						if ($type_filter == 'adjustment') {
							if ($aRow['type'] == 'adjustment') {
								$allow_add = 1;
							}
						}
						if ($type_filter == 'return') {
							if ($aRow['type'] == 'return') {
								$allow_add = 1;
							}
						}
					} else {
						$allow_add = 1;
					}

					$row[] = _l($aRow['type']);
					$row[] = _dt($aRow['time']);
					$row[] = _d($aRow['date_create']);

					$status = '';
					if ((int) $aRow['status'] == 0) {
						$status = '<div class="btn btn-warning" >' . _l('draft') . '</div>';
					} elseif ((int) $aRow['status'] == 1) {
						$status = '<div class="btn btn-success" >' . _l('Adjusted') . '</div>';
					} elseif((int) $aRow['status'] == -1){

						$status = '<div class="btn btn-danger" >' . _l('reject') . '</div>';

					}

					$row[] = $status;

					$row[] = $aRow['reason'];
					$row[] = get_staff_full_name($aRow['addfrom']);

					$option = '';

					if (is_admin() || has_permission('warehouse', '', 'view')) {

						$option .= '<a href="' . admin_url('warehouse/view_lost_adjustment/' . $aRow['id']) . '" class="btn btn-default btn-icon" >';
						$option .= '<i class="fa fa-eye"></i>';
						$option .= '</a>';
					}

					if (is_admin() || has_permission('warehouse', '', 'edit')) { 

						if ((int) $aRow['status'] == 0) {
							$option .= '<a href="' . admin_url('warehouse/add_loss_adjustment/' . $aRow['id']) . '" class="btn btn-default btn-icon" >';
							$option .= '<i class="fa fa-pencil-square-o"></i>';
							$option .= '</a>';
						}
					}

					if (is_admin() || has_permission('warehouse', '', 'delete')) { 

						$option .= '<a href="' . admin_url('warehouse/delete_loss_adjustment/' . $aRow['id']) . '" class="btn btn-danger btn-icon _delete">';
						$option .= '<i class="fa fa-remove"></i>';
						$option .= '</a>';
					}

					$row[] = $option;
					if ($allow_add == 1) {
						$output['aaData'][] = $row;
					}
				}

				echo json_encode($output);
				die();
			}
		}
	}

	/**
	 * add loss adjustment
	 * @param string $id
	 * @return view 
	 */
	public function add_loss_adjustment($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();
			$data['date_create'] = date('Y-m-d');
			$data['addfrom'] = get_staff_user_id();


			if ($data['id'] == '') {
				unset($data['id']);
				$id = $this->warehouse_model->add_loss_adjustment($data);
				if ($id) {
					$success = true;
					$message = _l('added_successfully');
					set_alert('success', $message);
				}

				redirect(admin_url('warehouse/view_lost_adjustment/' . $id));
			} else {
				$success = $this->warehouse_model->update_loss_adjustment($data);
				if ($success) {
					$message = _l('updated_successfully');
					set_alert('success', $message);
				}
				redirect(admin_url('warehouse/view_lost_adjustment/' . $id));
			}
			die;
		}

		$data['items'] = $this->warehouse_model->get_items_code_name();
		$data['unit'] = $this->warehouse_model->get_units_code_name();
		$data['warehouses'] = $this->warehouse_model->get_warehouse_code_name();
		$data['title'] = _l('loss_adjustment');
		if ($id != '') {
			$data['loss_adjustment'] = $this->warehouse_model->get_loss_adjustment($id);
			$data_lost = $this->warehouse_model->get_loss_adjustment_detailt_by_masterid($id);
			$data_row = [];
			foreach ($data_lost as $item) {
				array_push($data_row, array('items' => $item['items'], 'unit' => $item['unit'],'lot_number' => $item['lot_number'],'expiry_date' => $item['expiry_date'], 'current_number' => $item['current_number'], 'updates_number' => $item['updates_number'], 'loss_adjustment' => $item['loss_adjustment']));
			}
			$data['loss_adjustment_detailt'] = json_encode($data_row);
			$data['title'] = _l('update_loss_adjustment');
		}

		$data['current_day'] = date('Y-m-d');

		$this->load->view('loss_adjustment/add_loss_adjustment', $data);
	}

	/**
	 * adjust
	 * @param  [integer] $id 
	 * @return json     
	 */
	public function adjust($id) {
		$success = $this->warehouse_model->change_adjust($id);
		echo json_encode([
			'success' => $success,
		]);
		die;
	}

	/**
	 * { delete loss adjustment }
	 *
	 * @param      <type>  $id     The identifier
	 */
	public function delete_loss_adjustment($id) {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}


		$response = $this->warehouse_model->delete_loss_adjustment($id);
		if ($response == true) {
			set_alert('success', _l('deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('warehouse/loss_adjustment'));
	}

	/**
	 * { get data inventory valuation report }
	 *
	 * @return json
	 */
	public function get_data_inventory_valuation_report() {
		if ($this->input->post()) {
			$data = $this->input->post();

			$inventory_valuation_report = $this->warehouse_model->get_inventory_valuation_report_view($data);
		}

		echo json_encode([
			'value' => $inventory_valuation_report,
		]);
		die();
	}

	/**
	 * table out of stock
	 * @return [type]
	 */
	public function table_out_of_stock() {

		$this->app->get_table_data(module_views_path('warehouse', 'table_out_of_stock'));
	}

	/**
	 * table expired
	 * @return [type]
	 */
	public function table_expired() {

		$this->app->get_table_data(module_views_path('warehouse', 'table_expired'));
	}

	/**
	 * view commodity detail
	 * @param  [integer] $commodity_id
	 * @return [type]
	 */
	public function view_commodity_detail($commodity_id) {
		$commodity_item = get_commodity_name($commodity_id);

		if (!$commodity_item) {
			blank_page('commodity item Not Found', 'danger');
		}

		$data['commodity_item'] = $commodity_item;
		$data['commodity_file'] = $this->warehouse_model->get_warehourse_attachments($commodity_id);

		$this->load->view('view_commodity_detail', $data);

	}

	/**
	 * table view commodity detail
	 * @return [type]
	 */
	public function table_view_commodity_detail() {

		$this->app->get_table_data(module_views_path('warehouse', 'table_view_commodity_detail'));
	}

	/**
	 * delete goods receipt
	 * @param  [integer] $id
	 * @return redirect
	 */
	public function delete_goods_receipt($id) {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_goods_receipt($id);
		if ($response == true) {
			set_alert('success', _l('deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('warehouse/manage_purchase'));
	}

	/**
	 * delete_goods_delivery
	 * @param  [integer] $id
	 * @return [redirect]
	 */
	public function delete_goods_delivery($id) {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_goods_delivery($id);
		if ($response == true) {
			set_alert('success', _l('deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('warehouse/manage_delivery'));
	}

	/**
	 * Gets the commodity barcode.
	 */
	public function get_commodity_barcode() {
		$commodity_barcode = $this->warehouse_model->generate_commodity_barcode();

		echo json_encode([
			$commodity_barcode,
		]);
		die();
	}

	/**
	 * table inventory stock
	 * @return [type]
	 */
	public function table_inventory_stock() {

		$this->app->get_table_data(module_views_path('warehouse', 'table_inventory_stock'));
	}

	 /**
     * { tax change event }
     *
     * @param      <type>  $tax    The tax
     * @return   json
     */
	 public function tax_change($tax){
	 	$total_tax = $this->warehouse_model->get_taxe_value($tax);
	 	$tax_rate = 0;
	 	if($total_tax){
	 		$tax_rate = get_object_vars($total_tax)['taxrate'] + 0;
	 	}

	 	echo json_encode([
	 		'tax_rate' => $tax_rate,
	 	]);
	 }


    /**
     * get invoices fill data
     * @return json 
     */
    public function get_invoices_fill_data()
    {
    	$this->load->model('clients_model');
    	$address='';

    	$data = $this->input->post();
    	$customer_value = $this->clients_model->get($data['customer_id']);

    	if(isset($customer_value) && !is_array($customer_value)){
    		$address .= $customer_value->shipping_street.', '.$customer_value->shipping_city.', '.$customer_value->shipping_state.', '.get_country_name($customer_value->shipping_country);
    	}

    	$invoices = $this->warehouse_model->get_invoices_by_customer($data['customer_id']);

    	echo json_encode([
    		'invoices' => $invoices,
    		'address' => $address,

    	]);

    }

    /**
	 * manage delivery filter
	 * @param  integer $id
	 * @return view
	 */
    public function manage_delivery_filter($id = '') {


    	$data['invoice_id'] = $id;
    	$data['delivery_id'] = '';

    	$data['title'] = _l('stock_delivery_manage');
    	$this->load->view('manage_goods_delivery/manage_delivery', $data);
    }


	/**
	 * warehouse delete bulk action
	 * @return
	 */
	public function warehouse_delete_bulk_action()
	{
		if (!is_staff_member()) {
			ajax_access_denied();
		}

		$total_deleted = 0;

		if ($this->input->post()) {

			$ids                   = $this->input->post('ids');
			$rel_type                   = $this->input->post('rel_type');

			/*check permission*/
			switch ($rel_type) {
				case 'commodity_list':
				if (!has_permission('warehouse', '', 'delete') && !is_admin()) {
					access_denied('commodity_list');
				}
				break;


				default:
				break;
			}

			/*delete data*/
			if ($this->input->post('mass_delete')) {
				if (is_array($ids)) {
					foreach ($ids as $id) {

						switch ($rel_type) {
							case 'commodity_list':
							if ($this->warehouse_model->delete_commodity($id)) {
								$total_deleted++;
								break;
							}else{
								break;
							}

							default:

							break;
						}


					}
				}

				/*return result*/
				switch ($rel_type) {
					case 'commodity_list':
					set_alert('success', _l('total_commodity_list'). ": " .$total_deleted);
					break;

					default:
					break;

				}


			}

		}


	}


    /**
     * get subgroup fill data
     * @return html 
     */
    public function get_subgroup_fill_data()
    {
    	$data = $this->input->post();

    	$subgroup = $this->warehouse_model->list_subgroup_by_group($data['group_id']);

    	echo json_encode([
    		'subgroup' => $subgroup
    	]);

    }

    /**
     * warehouse selling price profif ratio
     * @return boolean 
     */
    public function warehouse_selling_price_profif_ratio(){
    	$data = $this->input->post();

    	if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
    		$success = false;
    		$message = _l('Not permission edit');

    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}

    	if($data != 'null'){
    		$value = $this->warehouse_model->update_warehouse_selling_price_profif_ratio($data);
    		if($value){
    			$success = true;
    			$message = _l('updated_successfully');
    		}else{
    			$success = false;
    			$message = _l('updated_false');
    		}
    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}
    }

    /**
     * warehouse the fractional part
     * @return boolean 
     */
    public function warehouse_the_fractional_part(){
    	$data = $this->input->post();
    	if($data != 'null'){
    		$value = $this->warehouse_model->update_warehouse_the_fractional_part($data);
    		if($value){
    			$success = true;
    			$message = _l('updated_successfully');
    		}else{
    			$success = false;
    			$message = _l('updated_false');
    		}
    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}
    }
    
	/**
     * warehouse integer part
     * @return boolean 
     */
	public function warehouse_integer_part(){
		$data = $this->input->post();
		if($data != 'null'){
			$value = $this->warehouse_model->update_warehouse_integer_part($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/**
	 * warehouse profit rate by purchase price sale
	 * @return boolean 
	 */
	public function warehouse_profit_rate_by_purchase_price_sale(){
		$data = $this->input->post();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_profit_rate_by_purchase_price_sale($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

    /**
     * setting rules for rounding prices
     * @return boolean 
     */
    public function setting_rules_for_rounding_prices(){
    	$data = $this->input->post();

    	if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
    		$success = false;
    		$message = _l('Not permission edit');

    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}

    	if($data != 'null'){
    		$value = $this->warehouse_model->update_rules_for_rounding_prices($data);
    		if($value){
    			$success = true;
    			$message = _l('updated_successfully');
    		}else{
    			$success = false;
    			$message = _l('updated_false');
    		}
    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}
    }

    /**
     * caculator sale price
     * @return float 
     */
    public function caculator_sale_price()
    {
    	$data = $this->input->post();
    	$sale_price = 0;

    	/*type : 0 purchase price, 1: sale price*/
    	$profit_type = get_warehouse_option('profit_rate_by_purchase_price_sale');
    	$the_fractional_part = get_warehouse_option('warehouse_the_fractional_part');
    	$integer_part = get_warehouse_option('warehouse_integer_part');

    	$profit_rate = reformat_currency_j($data['profit_rate']);
    	$purchase_price = reformat_currency_j($data['purchase_price']);

    	switch ($profit_type) {
    		case '0':
    			# Calculate the selling price based on the purchase price rate of profit
    			# sale price = purchase price * ( 1 + profit rate)
    		if( ($profit_rate =='') || ($profit_rate == '0')|| ($profit_rate == 'null') ){

    			$sale_price = (float)$purchase_price;
    		}else{
    			$sale_price = (float)$purchase_price*(1+((float)$profit_rate/100));

    		}
    		break;

    		case '1':
    			# Calculate the selling price based on the selling price rate of profit
    			# sale price = purchase price / ( 1 - profit rate)
    		if( ($profit_rate =='') || ($profit_rate == '0')|| ($profit_rate == 'null') ){

    			$sale_price = (float)$purchase_price;
    		}else{
    			$sale_price = (float)$purchase_price/(1-((float)$profit_rate/100));

    		}
    		break;
    		
    	}

    	//round sale_price
    	$sale_price = round($sale_price, (int)$the_fractional_part);

    	if($integer_part != '0'){
    		$integer_part = 0 - (int)($integer_part);
    		$sale_price = round($sale_price, $integer_part);
    	}

    	echo json_encode([
    		'sale_price' => $sale_price,
    	]);
    	die;

    }

    /**
	 * table inventory inside
	 *
	 * @return array
	 */
    public function table_inventory_inside() {

    	$this->app->get_table_data(module_views_path('warehouse', 'table_inventory_inside'));
    }
    
     /**
     * { purchase order setting }
     * @return  json
     */
     public function auto_create_goods_received_delivery_setting(){
     	$data = $this->input->post();

     	if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
     		$success = false;
     		$message = _l('Not permission edit');

     		echo json_encode([
     			'message' => $message,
     			'success' => $success,
     		]);
     		die;
     	}

     	if($data != 'null'){
     		$value = $this->warehouse_model->update_auto_create_received_delivery_setting($data);
     		if($value){
     			$success = true;
     			$message = _l('updated_successfully');
     		}else{
     			$success = false;
     			$message = _l('updated_false');
     		}
     		echo json_encode([
     			'message' => $message,
     			'success' => $success,
     		]);
     		die;
     	}
     }


    /**
     * update goods receipt warehouse
     * @return json 
     */
    public function update_goods_receipt_warehouse(){
    	$data = $this->input->post();

    	if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
    		$success = false;
    		$message = _l('Not permission edit');

    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}

    	if($data != 'null'){
    		$value = $this->warehouse_model->update_goods_receipt_warehouse($data);
    		if($value){
    			$success = true;
    			$message = _l('updated_successfully');
    		}else{
    			$success = false;
    			$message = _l('updated_false');
    		}
    		echo json_encode([
    			'message' => $message,
    			'success' => $success,
    		]);
    		die;
    	}
    }


    /**
     * coppy invoices
     * @param  integer $invoice_id 
     * @return json              
     */
    public function copy_invoices($invoice_id) {

    	$invoices_detail = $this->warehouse_model->copy_invoice($invoice_id);

    	echo json_encode([

    		'result' => $invoices_detail['goods_delivery_detail'],
    		'goods_delivery' => $invoices_detail['goods_delivery'],
    		'status' => $invoices_detail['status'],
    	]);
    }

	/**
	 * caculator purchase price
	 * @return json 
	 */
	public function caculator_profit_rate()
	{
		$data = $this->input->post();
		$profit_rate = 0;

		/*type : 0 purchase price, 1: sale price*/
		$profit_type = get_warehouse_option('profit_rate_by_purchase_price_sale');
		$the_fractional_part = get_warehouse_option('warehouse_the_fractional_part');
		$integer_part = get_warehouse_option('warehouse_integer_part');

		$purchase_price = reformat_currency_j($data['purchase_price']);
		$sale_price = reformat_currency_j($data['sale_price']);


		switch ($profit_type) {
			case '0':
    			# Calculate the selling price based on the purchase price rate of profit
    			# sale price = purchase price * ( 1 + profit rate)

			if( ($purchase_price =='') || ($purchase_price == '0')|| ($purchase_price == 'null') ){
				$profit_rate = 0;

			}else{
				$profit_rate = (((float)$sale_price/(float)$purchase_price)-1)*100;

			}
			break;

			case '1':
    			# Calculate the selling price based on the selling price rate of profit
    			# sale price = purchase price / ( 1 - profit rate)

			$profit_rate = (1-((float)$purchase_price/(float)$sale_price))*100;

			break;

		}


		echo json_encode([
			'profit_rate' => $profit_rate,
		]);
		die;

	}

   	/**
	 * warehouse delete bulk action
	 * @return
	 */
   	public function warehouse_export_item_checked()
   	{
   		if (!is_staff_member()) {
   			ajax_access_denied();
   		}

   		if ($this->input->post()) {

   			/*delete export file before export file*/
   			$path_before = COMMODITY_EXPORT.'export_excel_'.get_staff_user_id().'.xlsx';
   			if(file_exists($path_before)){
   				unlink(COMMODITY_EXPORT.'export_excel_'.get_staff_user_id().'.xlsx');
   			}

   			$ids                   = $this->input->post('ids');

   			$spreadsheet = new PHPExcel();
	        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
   			$spreadsheet -> setActiveSheetIndex(0);

	        // add style to the header
   			$styleArray = array(
   				'font' => array(
   					'bold' => true,

   				),

   				'borders' => array(
   					'top' => array(
   						'style' => PHPExcel_Style_Border::BORDER_THIN,
   					),
   				),
   				'fill' => array(

   					'rotation' => 90,
   					'startcolor' => array(
   						'argb' => 'FFA0A0A0',
   					),
   					'endcolor' => array(
   						'argb' => 'FFFFFFFF',
   					),
   				),
   			);


	        // set the names of header cells
   			$spreadsheet->setActiveSheetIndex(0)
   			->setCellValue("A1", "(*)" . _l('commodity_code'))
   			->setCellValue("B1", _l('commodity_name'))
   			->setCellValue("C1", _l('commodity_barcode'))
   			->setCellValue("D1", _l('sku_code'))
   			->setCellValue("E1", _l('sku_name'))
   			->setCellValue("F1", _l('Tags'))
   			->setCellValue("G1", _l('description'))

   			->setCellValue("H1", _l('commodity_type'))
   			->setCellValue("I1", _l('unit_id'))
   			->setCellValue("J1", "(*)" . _l('commodity_group'))
   			->setCellValue("K1", _l('sub_group'))
   			->setCellValue("L1", _l('_profit_rate'). "(%)")
   			->setCellValue("M1", _l('purchase_price'))
   			->setCellValue("N1", _l('rate'))
   			->setCellValue("O1", _l('tax'))
   			->setCellValue("P1", _l('origin'))
   			->setCellValue("Q1", _l('style_id'))
   			->setCellValue("R1", _l('model_id'))
   			->setCellValue("S1", _l('size_id'))
   			->setCellValue("T1", _l('_color'))
   			->setCellValue("U1", _l('guarantee_month'))
   			->setCellValue("V1", _l('minimum_inventory'));


   			/*set style for header*/
   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->applyFromArray($styleArray);

	        // auto fit column to content

   			foreach(range('A','U') as $columnID) {
   				$spreadsheet->getActiveSheet()->getColumnDimension($columnID)
   				->setAutoSize(true);

   			}

   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->getFill()->getStartColor()->setARGB('29bb04');
	        // Add some data
   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->getFont()->setBold(true);
   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 

   			/*set header middle alignment*/
   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

   			$spreadsheet->getActiveSheet()->getStyle('A1:V1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

   			/*set row1 height*/
   			$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);


	        // Add some data
   			$x= 2;
   			if(isset($ids)){
   				if(count($ids) > 0){
   					foreach ($ids as $value) {
   						$inventory_min=0;

   						$item = $this->db->query('select * from tblitems where active = 1 AND id ='.$value)->row();
   						/*get inventory min*/
   						$this->db->where('commodity_id', $value);
   						$inventory_value = $this->db->get(db_prefix() . 'inventory_commodity_min')->row();
   						if($inventory_value){
   							$inventory_min =  $inventory_value->inventory_number_min;
   						}


   						if($item){
   							$spreadsheet->setActiveSheetIndex(0)
   							->setCellValue("A".$x,$item->commodity_code)
   							->setCellValue("B".$x, $item->description)
   							->setCellValue("C".$x, $item->commodity_barcode)
   							->setCellValue("D".$x, $item->sku_code)
   							->setCellValue("E".$x, $item->sku_name)
   							->setCellValue("F".$x, $this->warehouse_model->get_tags_name($item->id))
   							->setCellValue("G".$x, $item->long_description)

   							->setCellValue("H".$x, $item->commodity_type)
   							->setCellValue("I".$x, $item->unit_id)
   							->setCellValue("J".$x, $item->group_id)
   							->setCellValue("K".$x, $item->sub_group)
   							->setCellValue("L".$x, $item->profif_ratio)
   							->setCellValue("M".$x, $item->purchase_price)
   							->setCellValue("N".$x, $item->rate)
   							->setCellValue("O".$x, $item->tax)
   							->setCellValue("P".$x, $item->origin)
   							->setCellValue("Q".$x, $item->style_id)
   							->setCellValue("R".$x, $item->model_id)
   							->setCellValue("S".$x, $item->size_id)
   							->setCellValue("T".$x, $item->color)
   							->setCellValue("U".$x, $item->guarantee)
   							->setCellValue("V".$x, $inventory_min);
   							$x++;
   						}
   					}

   				}

   			}

	        // Rename worksheet
   			$spreadsheet->getActiveSheet()->setTitle('Inventory Items Import Excel');

	        // Redirect output to a client’s web browser (Excel2007)
   			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   			header('Content-Disposition: attachment;filename="inventory_items_sheet.xlsx"');
   			header('Cache-Control: max-age=0');

	        // If you're serving to IE 9, then the following may be needed
   			header('Cache-Control: max-age=1');

	        // If you're serving to IE over SSL, then the following may be needed
	        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
	        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	        header('Pragma: public'); // HTTP/1.0

	        $writer = new PHPExcel_Writer_Excel2007($spreadsheet);

	        $filename = 'export_excel_'.get_staff_user_id().strtotime(date('Y-m-d H:i:s')).'.xlsx';
	        $writer->save(str_replace($filename, WAREHOUSE_EXPORT_ITEM.$filename, $filename));

	        echo json_encode(['success' => true,
	        	'filename' => WAREHOUSE_EXPORT_ITEM.$filename,
	        ]);

	        exit;


	    }


	}

    /**
     * get list job position training
     * @param  integer $id 
     * @return json     
     */
    public function get_item_longdescriptions($id){
    	$variation_html = $this->warehouse_model->get_variation_html($id);
    	$list = $this->warehouse_model->get_item_longdescriptions($id);
    	$item_html = $this->warehouse_model->get_list_parent_item(['id' => $id]);

    	$custom_fields_html = render_custom_fields('items', $id, [], ['items_pr' => true]);
    	$item_tags = $this->warehouse_model->get_list_item_tags($id);

    	if((get_tags_in($id,'item_tags') != null)){
    		$item_value = implode(',', get_tags_in($id,'item_tags')) ;
    	}else{

    		$item_value = '';
    	}

    	if(isset($list)){
    		$long_descriptions = $list->long_descriptions;
    		$description = $list->long_description;
    	}else{
    		$long_descriptions = '';
    		$description = '';

    	}
    	echo json_encode([ 
    		'long_descriptions' => $long_descriptions,
    		'description' => $description,
    		'custom_fields_html' => $custom_fields_html,
    		'item_tags' => $item_tags['htmltag'],
    		'item_value' => $item_value,
    		'variation_html' => $variation_html['html'],
    		'variation_index' => $variation_html['index'],
    		'item_html' => $item_html['item_options'],

    	]);
    }


    /**
     * revert goods receipt
     * @param  integer $id 
     * @return redirect        
     */
    public function revert_goods_receipt($id)
    {	
    	$response = $this->warehouse_model->revert_goods_receipt($id);

    	if ($response == true) {
    		set_alert('success', _l('deleted'));
    	} else {
    		set_alert('warning', _l('problem_deleting'));
    	}
    	redirect(admin_url('warehouse/manage_purchase'));

    }

    /**
     * revert goods delivery
     * @param  integer $id 
     * @return redirect    
     */
    public function revert_goods_delivery($id)
    {	
    	$response = $this->warehouse_model->revert_goods_delivery($id);

    	if ($response == true) {
    		set_alert('success', _l('deleted'));
    	} else {
    		set_alert('warning', _l('problem_deleting'));
    	}
    	redirect(admin_url('warehouse/manage_delivery'));

    }

    /**
	 * import xlsx opening stock
	 * @param  integer $id
	 * @return view
	 */
    public function import_opening_stock() {
    	if (!is_admin() && !has_permission('warehouse', '', 'create')) {
    		access_denied('warehouse');
    	}
    	$this->load->model('staff_model');
    	$data_staff = $this->staff_model->get(get_staff_user_id());

    	/*get language active*/
    	if ($data_staff) {
    		if ($data_staff->default_language != '') {
    			$data['active_language'] = $data_staff->default_language;

    		} else {

    			$data['active_language'] = get_option('active_language');
    		}

    	} else {
    		$data['active_language'] = get_option('active_language');
    	}
    	$data['title'] = _l('import_opening_stock');

    	$this->load->view('warehouse/import_excel_opening_stock', $data);
    }


	/**
	 * import file xlsx opening stock
	 * @return json 
	 */
	public function import_file_xlsx_opening_stock() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			access_denied(_l('warehouse'));
		}

		$total_row_false = 0;
		$total_rows_data = 0;
		$dataerror = 0;
		$total_row_success = 0;
		$total_rows_data_error = 0;
		$filename='';

		if ($this->input->post()) {

			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {
				//do_action('before_import_leads');

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
					$tmpDir = TEMP_FOLDER . '/' . time() . uniqid() . '/';

					if (!file_exists(TEMP_FOLDER)) {
						mkdir(TEMP_FOLDER, 0755);
					}

					if (!file_exists($tmpDir)) {
						mkdir($tmpDir, 0755);
					}

					// Setup our new file path
					$newFilePath = $tmpDir . $_FILES['file_csv']['name'];

					if (move_uploaded_file($tmpFilePath, $newFilePath)) {
						$import_result = true;
						$rows = [];

						$objReader = new PHPExcel_Reader_Excel2007();
						$objReader->setReadDataOnly(true);
						$objPHPExcel = $objReader->load($newFilePath);
						$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
						$sheet = $objPHPExcel->getActiveSheet();

						//innit  file exel error start

						$dataError = new PHPExcel();
						$dataError->setActiveSheetIndex(0);
						//create header file

						// add style to the header
						$styleArray = array(
							'font' => array(
								'bold' => true,

							),

							'borders' => array(
								'top' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
								),
							),
							'fill' => array(

								'rotation' => 90,
								'startcolor' => array(
									'argb' => 'FFA0A0A0',
								),
								'endcolor' => array(
									'argb' => 'FFFFFFFF',
								),
							),
						);

						// set the names of header cells
						$dataError->setActiveSheetIndex(0)

						->setCellValue("A1", "(*)" . _l('commodity_code'))
						->setCellValue("B1", "(*)" . _l('warehouse_code'))
						->setCellValue("C1", _l('lot_number'))
						->setCellValue("D1", _l('expiry_date'))
						->setCellValue("E1", "(*)" . _l('inventory_number'))

						->setCellValue("F1", _l('error'));


						/*set style for header*/
						$dataError->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);

						// auto fit column to content

						foreach (range('A', 'F') as $columnID) {
							$dataError->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);

						}

						$dataError->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$dataError->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('29bb04');
						// Add some data
						$dataError->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
						$dataError->getActiveSheet()->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

						/*set header middle alignment*/
						$dataError->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$dataError->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						/*set row1 height*/
						$dataError->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

						//init file error end

						// start row write 2
						$numRow = 2;
						$total_rows = 0;

						$total_rows_actualy = 0;
						
						//get data for compare

						foreach ($rowIterator as $row) {
							$rowIndex = $row->getRowIndex();
							if ($rowIndex > 1) {
								$rd = array();
								$flag = 0;
								$flag2 = 0;
								$flag_mail = 0;
								$string_error = '';
								$flag_contract_form = 0;

								$flag_id_commodity_code;
								$flag_id_warehouse_code;

								$value_cell_commodity_code = $sheet->getCell('A' . $rowIndex)->getValue();
								$value_cell_warehouse_code = $sheet->getCell('B' . $rowIndex)->getValue();
								$value_cell_lot_number = $sheet->getCell('C' . $rowIndex)->getValue();
								$value_cell_expiry_date = $sheet->getCell('D' . $rowIndex)->getValue();
								$value_cell_inventory_number = $sheet->getCell('E' . $rowIndex)->getValue();

								$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';

								$reg_day = '#^(((1)[0-2]))(\/)\d{4}-(3)[0-1])(\/)(((0)[0-9])-[0-2][0-9]$#'; /*yyyy-mm-dd*/

								/*check null*/
								if (is_null($value_cell_commodity_code) == true) {
									$string_error .= _l('commodity_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_warehouse_code) == true) {
									$string_error .= _l('warehouse_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_inventory_number) == true) {
									$string_error .= _l('inventory_number') . _l('not_yet_entered');
									$flag = 1;
								}
								

								//check commodity_code exist  (input: code or name item)
								if (is_null($value_cell_commodity_code) != true && $value_cell_commodity_code != '0' ) {
									/*case input  id*/
									$this->db->where('commodity_code', trim($value_cell_commodity_code, " "));
									$this->db->or_where('description', trim($value_cell_commodity_code, " "));
									$item_value =  $this->db->get(db_prefix().'items')->row();

									if ($item_value) {
										/*get id commodity_type*/
										$flag_id_commodity_code = $item_value->id;
									} else {
										$string_error .= _l('commodity_code') . _l('does_not_exist');
										$flag2 = 1;
									}


								}

								//check warehouse exist  (input: id or name warehouse)
								if (is_null($value_cell_warehouse_code) != true && ( $value_cell_warehouse_code != '0')) {
									/*case input id*/

									$this->db->where('warehouse_code', trim($value_cell_warehouse_code, " "));
									$this->db->or_where('warehouse_name', trim($value_cell_warehouse_code, " "));
									$warehouse_value = $this->db->get(db_prefix().'warehouse')->row();

									if ($warehouse_value) {
										/*get id unit_id*/
										$flag_id_warehouse_code = $warehouse_value->warehouse_id;

									} else {
										$string_error .= _l('_warehouse') . _l('does_not_exist');
										$flag2 = 1;
									}

								}

								if (is_null($value_cell_expiry_date) != true) {

									if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_cell_expiry_date, " "))) {
										$test = true;

									} else {
										$flag2 = 1;
										$string_error .= _l('expiry_date') . _l('invalid');

									}
								}


								// check inventory number
								if (!is_numeric(trim($value_cell_inventory_number, " "))) {

									$string_error .=_l('inventory_number'). _l('_not_a_number');
									$flag2 = 1; 	

								} 


								

								if (($flag == 1) || ($flag2 == 1)) {
									$dataError->getActiveSheet()->setCellValue('A' . $numRow, $sheet->getCell('A' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('B' . $numRow, $sheet->getCell('B' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('C' . $numRow, $sheet->getCell('C' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('D' . $numRow, $sheet->getCell('D' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('E' . $numRow, $sheet->getCell('E' . $rowIndex)->getValue());

									$dataError->getActiveSheet()->setCellValue('F' . $numRow, $string_error)->getStyle('F' . $numRow)->applyFromArray($styleArray);

									$numRow++;
									$total_rows_data_error++;
								}

								if (($flag == 0) && ($flag2 == 0)) {

									/*staff id is HR_code, input is HR_CODE, insert => staffid*/
									$rd['commodity_code'] = $flag_id_commodity_code;
									$rd['warehouse_id'] = $flag_id_warehouse_code;
									$rd['lot_number'] 	  = $sheet->getCell('C' . $rowIndex)->getValue();

									$rd['expiry_date'] = (trim($value_cell_expiry_date, " "));
									if(isset($rd['expiry_date'])){
										$rd['expiry_date'] = null;
									}else{
										$rd['expiry_date'] = $rd['expiry_date'];
									}

									$rd['quantities'] = $sheet->getCell('E' . $rowIndex)->getValue();
									$rd['date_manufacture'] = null;

								}

								if (get_staff_user_id() != '' && $flag == 0 && $flag2 == 0) {
									$rows[] = $rd;
									$result_value = $this->warehouse_model->add_inventory_manage($rd, 1);
									if ($result_value) {
										$total_rows_actualy++;
									}
								}

								$total_rows++;
								$total_rows_data++;
							}

						}

						if ($total_rows_actualy != $total_rows) {
							$total_rows = $total_rows_actualy;
						}


						$total_rows = $total_rows;
						$data['total_rows_post'] = count($rows);
						$total_row_success = count($rows);
						$total_row_false = $total_rows - (int) count($rows);
						$dataerror = $dataError;
						$message = 'Not enought rows for importing';

						if(($total_rows_data_error > 0) || ($total_row_false != 0)){
							$objWriter = new PHPExcel_Writer_Excel2007($dataError);

							$filename = 'FILE_ERROR_IMPORT_OPENING_STOCK' .get_staff_user_id().strtotime(date('Y-m-d H:i:s')). '.xlsx';
							$objWriter->save(str_replace($filename, WAREHOUSE_IMPORT_OPENING_STOCK.$filename, $filename));

							$filename = WAREHOUSE_IMPORT_OPENING_STOCK.$filename;


						}
						
						$import_result = true;
						@delete_dir($tmpDir);

					}
					
				} else {
					set_alert('warning', _l('import_opening_stock_failed'));
				}
			}

		}
		echo json_encode([
			'message' =>'Not enought rows for importing',
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_rows_data_error,
			'total_rows' => $total_rows_data,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'total_rows_data_error' => $total_rows_data_error,
			'filename' => $filename,
		]);

	}

	/**
	 * unserializeForm
	 * @param  [type] $str 
	 * @return [type]      
	 */
	public	function unserializeForm($str) {
		$strArray = explode("&", $str);
		foreach($strArray as $item) {
			$array = explode("=", $item);
			$returndata[] = $array;
		}
		return $returndata;
	}

	/**
	 * delete item tags
	 * @param  integer $tag_id 
	 * @return [type]         
	 */
	public function delete_item_tags($tag_id){

		$result = $this->warehouse_model->delete_tag_item($tag_id);
		if($result == 'true'){
			$message = _l('deleted');
			$status = 'true';
		}else{
			$message = _l('problem_deleting');
			$status = 'fasle';
		}

		echo json_encode([ 
			'message' => $message,
			'status' => $status,
		]);
	}

    /**
     * check warehouse onsubmit
     *  
     */
    public function check_warehouse_onsubmit() {
    	$data = $this->input->post();
    	$flag = 0;
    	$message = true;

    	if ($data['hot_delivery'] != 'null') {
    		foreach ($data['hot_delivery'] as $delivery_value) {
    			if ( $delivery_value[0] != '' ) {

    				/*case select warehouse handsome table*/
    				if($data['warehouse_id'] == ''){
    					if ( $delivery_value[1] == '' ) {
    						$flag = 1;
    					}
    				}
    			}

    		}
    		if ($flag == 1) {
    			$message = false;

    		} else {
    			$message = true;
    		}
    		echo json_encode([
    			'message' => $message,

    		]);
    		die;
    	}
    }

	/**
	 * view lost adjustment
	 * @param  integer $id 
	 * @return view
	 */
	public function view_lost_adjustment($id) {
		//approval
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if ((isset($send_mail_approve)) && $send_mail_approve != '') {
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 3);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 3);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 3);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 3);

		//get vaule render dropdown select

		$data['loss_adjustment'] = $this->warehouse_model->get_loss_adjustment($id);
		$data['loss_adjustment_detail']= $this->warehouse_model->get_loss_adjustment_detailt_by_masterid($id);

		$data['title'] = _l('loss_adjustment');


		$check_appr = $this->warehouse_model->get_approve_setting('3');
		$data['check_appr'] = $check_appr;

		$this->load->view('loss_adjustment/view_lost_adjustment', $data);

	}


	/**
	 * check lost adjustment before save
	 * @return json 
	 */
	public function check_lost_adjustment_before_save() {
		$data = $this->input->post();

		$result = $this->warehouse_model->check_lost_adjustment_before_save($data);
		if($result['flag_check'] == 1){
			$success = false;
			$message = $result['str_error'];
		}else{
			$success = true;
			$message = $result['str_error'];

		}

		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}

	/**
	 * [inventory_setting
	 * @return redirect 
	 */
	public function inventory_setting()
	{
		$data = $this->input->post();

		if ($data) {

			$success = $this->warehouse_model->update_inventory_setting($data);

			if ($success == true) {

				$message = _l('updated_successfully');
				set_alert('success', $message);
			}

			redirect(admin_url('warehouse/setting?group=inventory_setting'));

		}


	}


	/**
	 * manage internal delivery
	 * @param  string $id 
	 * @return view     
	 */
	public function manage_internal_delivery($id = '')
	{
		$data['internal_id'] = $id;
		$data['title'] = _l('internal_delivery_note');
		$this->load->view('manage_internal_delivery/manage', $data);
	}


	/**
	 * table internal delivery
	 * @return table 
	 */
	public function table_internal_delivery()
	{
		$this->app->get_table_data(module_views_path('warehouse', 'manage_internal_delivery/table_internal_delivery_note'));
	}


	/**
	 * add update internal delivery
	 * @param string $id 
	 */
	public function add_update_internal_delivery($id ='') {

		if ($this->input->post()) {

			$data = $this->input->post();
			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_internal_delivery($data);
				if ($mess) {
					set_alert('success', _l('added_successfully'));
					redirect(admin_url('warehouse/manage_internal_delivery/'.$mess));

				} else {
					set_alert('warning', _l('add_internal_delivery_note_false'));
				}


			}else{
				$id = $data['id'];
				unset($data['id']);

				$mess = $this->warehouse_model->update_internal_delivery($data,$id);
				
				if ($mess) {
					set_alert('success', _l('updated_successfully'));

				} else {
					set_alert('warning', _l('update_internal_delivery_note_false'));
				}
				redirect(admin_url('warehouse/manage_internal_delivery/'.$id));
			}

		}

		//get vaule render dropdown select
		$data['title'] = _l('internal_delivery_note');

		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();
		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		$data['goods_code'] = $this->warehouse_model->create_goods_delivery_code();
		$data['staff'] = $this->warehouse_model->get_staff();

		$data['current_day'] = date('Y-m-d');
		$this->load->model('currencies_model');
		$data['base_currency'] = $this->currencies_model->get_base_currency();

		if($id != ''){
			$internal_delivery = $this->warehouse_model->get_internal_delivery($id);
			if (!$internal_delivery) {
				blank_page('Internal delivery note Not Found', 'danger');
			}

			$data['internal_delivery_detail'] = json_encode($this->warehouse_model->get_internal_delivery_detail($id));
			$data['internal_delivery'] = $internal_delivery;
		}


		$this->load->view('manage_internal_delivery/add_internal_delivery', $data);

	}


	/**
	 * get quantity inventory
	 * @return [type] 
	 */
	public function get_quantity_inventory() {
		$data = $this->input->post();
		if ($data != 'null') {

			$value = $this->warehouse_model->get_quantity_inventory($data['warehouse_id'], $data['commodity_id']);

			$quantity = 0;
			if ($value != null) {

				$message = true;
				$quantity = get_object_vars($value)['inventory_number'];

			} else {
				$message = _l('Product_does_not_exist_in_stock');
			}

			
			echo json_encode([
				'message' => $message,
				'value' => $quantity,
			]);
			die;
		}
	}

	public function get_quantity_inventory_t() {
		$data = $this->input->post();
		if ($data != 'null') {

			$value = $this->warehouse_model->get_quantity_inventory($data['warehouse_id'], $data['commodity_id']);

			$quantity = 0;
			if ($value != null) {

				if ((float) get_object_vars($value)['inventory_number'] < (float) $data['quantity_export']) {
					$message = _l('not_enough_inventory');
					$quantity = get_object_vars($value)['inventory_number'];

				} else {
					$message = true;
					$quantity = get_object_vars($value)['inventory_number'];
				}

			} else {
				$message = _l('Product_does_not_exist_in_stock');
			}

			
			echo json_encode([
				'message' => $message,
				'value' => $quantity,
			]);
			die;
		}
	}


	/**
	 * delete internal delivery
	 * @param  interger $id 
	 * @return redirect    
	 */
	public function delete_internal_delivery($id) {
		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_internal_delivery($id);
		if ($response == true) {
			set_alert('success', _l('deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('warehouse/manage_internal_delivery'));
	}


	/**
	 * view internal delivery
	 * @param  integer $id 
	 * @return view     
	 */
	public function view_internal_delivery($id) {
		//approval
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if ((isset($send_mail_approve)) && $send_mail_approve != '') {
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 4);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 4);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 4);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 4);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['internal_delivery'] = $this->warehouse_model->get_internal_delivery($id);
		$data['internal_delivery_detail'] = $this->warehouse_model->get_internal_delivery_detail($id);

		$data['title'] = _l('internal_delivery_note');
		$check_appr = $this->warehouse_model->get_approve_setting('4');
		$data['check_appr'] = $check_appr;

		$this->load->view('manage_internal_delivery/view_internal_delivery', $data);

	}


	/**
	 * check internal delivery onsubmit
	 * 
	 * @return view     
	 */
	public function check_internal_delivery_onsubmit() {
		$data = $this->input->post();
		$flag = 0;
		$message = true;
		$str_error = '';

		if ($data['intenal_delivery'] != 'null') {
			foreach ($data['intenal_delivery'] as $intenal_delivery_value) {

				if ( $intenal_delivery_value[0] != '' ) {
					if($intenal_delivery_value[1] != ''){
						//check without checking warehouse
						$commodity_name='';
						$item_value = $this->warehouse_model->get_commodity($intenal_delivery_value['0']);

						if($item_value){
							$commodity_name .= $item_value->commodity_code.'_'.$item_value->description;
						}

						$value = $this->warehouse_model->get_quantity_inventory($intenal_delivery_value['1'], $intenal_delivery_value['0']);


						$quantity = 0;
						if ($value != null) {

							if ((float) get_object_vars($value)['inventory_number'] < (float) $intenal_delivery_value['5']) {
								$flag = 1;
								$str_error .= $commodity_name._l('not_enough_inventory').'<br/>';

							}

						} else {
							$flag = 1;
							$str_error .=$commodity_name. _l('Product_does_not_exist_in_stock').'<br/>';
						}

					}else{
						$flag = 1;
						$str_error .= _l('please_choose_from_stock_name').'<br/>';
					}

					if($intenal_delivery_value[2] == ''){
						$flag = 1;
						$str_error .= _l('please_choose_to_stock_name').'<br/>';
					}

					if($intenal_delivery_value[5] == '' || $intenal_delivery_value[5] == '0'){
						$flag = 1;
						$str_error .= _l('please_choose_quantity_export').'<br/>';
					}

				}

			}
			
			if ($flag == 1) {
				$message = false;

			} else {
				$message = true;
			}

			echo json_encode([
				'message' => $message,
				'str_error' => $str_error,

			]);
			die;
		}
	}

	/**
	 * check approval sign
	 * @return json 
	 */
	public function check_approval_sign() 
	{
		$data = $this->input->post();

		$success = true;
		$message = '';

		if($data['rel_type'] == '2'){
			/*check send request with type =2 , inventory delivery voucher*/
			$check_r = $this->warehouse_model->check_inventory_delivery_voucher($data);

			if($check_r['flag_export_warehouse'] == 1){
				$message = 'approval success';

			}else{
				$message = $check_r['str_error'];
				$success = false;

			}
		}elseif($data['rel_type'] == '4'){
			/*check send request with type = 4 , internal delivery note*/
			$check_r = $this->warehouse_model->check_internal_delivery_note_send_request($data);

			if($check_r['flag_internal_delivery_warehouse'] == 1){
				$message = 'approval success';

			}else{
				$message = $check_r['str_error'];
				$success = false;

			}

		}


		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}


	/**
	 * manage warehouse
	 * @param  string $id 
	 * @return [type]     
	 */
	public function warehouse_mange($id = '') {

		$data['title'] = _l('warehouse_manage');
		$data['warehouse_types'] = $this->warehouse_model->get_warehouse();

		$this->db->where('fieldto', 'warehouse_name');
		$data['wh_custom_fields_display'] = $this->db->get(db_prefix().'customfields')->result_array();


		$data['proposal_id'] = $id;

		$this->load->view('includes/warehouse', $data);
	}

	/**
	 * table warehouse name
	 *
	 * @return array
	 */
	public function table_warehouse_name() {
		$this->app->get_table_data(module_views_path('warehouse', 'manage_warehouse/table_warehouse_name'));
	}


	/**
	 * warehouse setting
	 * @param  string $id 
	 * @return [type]     
	 */
	public function add_warehouse($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {

				$mess = $this->warehouse_model->add_one_warehouse($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('warehouse'));

				} else {
					set_alert('warning', _l('Add_warehouse_false'));
				}
				redirect(admin_url('warehouse/warehouse_mange'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->update_one_warehouse($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . _l('warehouse'));
				} else {
					set_alert('warning', _l('updated_warehouse_false'));
				}

				redirect(admin_url('warehouse/warehouse_mange'));
			}
		}
	}


    /**
     * get item by id ajax
     * @param  integer $id 
     * @return [type]     
     */
    public function get_warehouse_by_id($id)
    {
    	if ($this->input->is_ajax_request()) {

    		$warehouse_value                     = $this->warehouse_model->get_warehouse($id);

    		$warehouse_value->warehouse_code   	= $warehouse_value->warehouse_code;
    		$warehouse_value->warehouse_name   	= $warehouse_value->warehouse_name;
    		$warehouse_value->warehouse_address   = nl2br($warehouse_value->warehouse_address);
    		$warehouse_value->note   = nl2br($warehouse_value->note);

    		$warehouse_value->custom_fields      = [];

    		$warehouse_value->custom_fields_html = wh_render_custom_fields('warehouse_name', $id, []);

    		$cf = get_custom_fields('warehouse_name');

    		foreach ($cf as $custom_field) {
    			$val = get_custom_field_value($id, $custom_field['id'], 'warehouse_name');
    			if ($custom_field['type'] == 'textarea') {
    				$val = clear_textarea_breaks($val);
    			}
    			$custom_field['value'] = $val;
    			$warehouse_value->custom_fields[] = $custom_field;
    		}

    		echo json_encode($warehouse_value);
    	}
    }

    /**
     * get warehouse custom fields html
     * @param  [type] $id 
     * @return [type]     
     */
    public function get_warehouse_custom_fields_html($id)
    {
    	if ($this->input->is_ajax_request()) {

    		$warehouse_value =[];
    		$warehouse_value['custom_fields_html'] = wh_render_custom_fields('warehouse_name', $id, []);

    		echo json_encode($warehouse_value);
    	}
    }


    /**
     * view warehouse detail
     * @param  integer $warehouse_id 
     * @return view               
     */
    public function view_warehouse_detail($warehouse_id) {
    	$warehouse_item = get_warehouse_name($warehouse_id);

    	if (!$warehouse_item) {
    		blank_page('Warehouse Not Found', 'danger');
    	}

    	$data['warehouse_item'] = $warehouse_item;
    	$data['warehouse_inventory'] = $this->warehouse_model->get_inventory_by_warehouse($warehouse_id);

    	$this->load->view('manage_warehouse/warehouse_view_detail', $data);

    }

	/**
	 * goods delivery copy pur order
	 * @param  integer $pur request
	 * @return json encode
	 */
	public function goods_delivery_copy_pur_order($pur_order) {

		$pur_request_detail = $this->warehouse_model->goods_delivery_get_pur_order($pur_order);



		echo json_encode([

			'result' => $pur_request_detail['result'] ? $pur_request_detail['result'] : '',
			'total_tax_money' => $pur_request_detail['total_tax_money'] ? $pur_request_detail['total_tax_money'] : '',
			'total_discount' => $pur_request_detail['total_discount'] ? $pur_request_detail['total_discount'] : '',
			'total_payment' => $pur_request_detail['total_payment'] ? $pur_request_detail['total_payment'] : '',
			'total_row' => $pur_request_detail['total_row'] ? $pur_request_detail['total_row'] : '',
		]);
	}

	 /**
     * Uploads a proposal attachment.
     *
     * @param      string  $id  The purchase order
     * @return redirect
     */
	 public function wh_proposal_attachment($id){

	 	wh_handle_propsal_file($id);

	 	redirect(admin_url('proposals/list_proposals/'.$id));
	 }

    /**
     * { preview obgy partograph file }
     *
     * @param      <type>  $id      The identifier
     * @param      <type>  $rel_id  The relative identifier
     * @return  view
     */
    public function file_proposal($id, $rel_id)
    {
    	$data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
    	$data['current_user_is_admin']             = is_admin();
    	$data['file'] = $this->warehouse_model->get_file($id, $rel_id);
    	if (!$data['file']) {
    		header('HTTP/1.0 404 Not Found');
    		die;
    	}

    	$this->load->view('proposal/_file', $data);
    }

    /**
     * { delete proposal attachment }
     *
     * @param      <type>  $id     The identifier
     */
    public function delete_proposal_attachment($id)
    {
    	$this->load->model('misc_model');
    	$file = $this->misc_model->get_file($id);
    	if ($file->staffid == get_staff_user_id() || is_admin()) {
    		echo html_entity_decode($this->warehouse_model->delete_wh_proposal_attachment($id));
    	} else {
    		header('HTTP/1.0 400 Bad error');
    		echo _l('access_denied');
    		die;
    	}
    }

    /**
	 * brands setting
	 * @param  string $id 
	 * @return [type]     
	 */
    public function brands_setting($id = '') {
    	if ($this->input->post()) {
    		$message = '';
    		$data = $this->input->post();

    		if (!$this->input->post('id')) {

    			$mess = $this->warehouse_model->add_brand($data);
    			if ($mess) {
    				set_alert('success', _l('added_successfully'));

    			} else {
    				set_alert('warning', _l('Add_brand_name_false'));
    			}
    			redirect(admin_url('warehouse/setting?group=brand'));

    		} else {
    			$id = $data['id'];
    			unset($data['id']);
    			$success = $this->warehouse_model->update_brand($data, $id);
    			if ($success) {
    				set_alert('success', _l('updated_successfully'));
    			} else {
    				set_alert('warning', _l('updated_brand_name_false'));
    			}

    			redirect(admin_url('warehouse/setting?group=brand'));
    		}
    	}
    }

	/**
	 * [delete_color
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_brand($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=brand'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_brand($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=brand'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=brand'));
		}

	}

	    /**
	 * brands setting
	 * @param  string $id 
	 * @return [type]     
	 */
	    public function models_setting($id = '') {
	    	if ($this->input->post()) {
	    		$message = '';
	    		$data = $this->input->post();

	    		if (!$this->input->post('id')) {

	    			$mess = $this->warehouse_model->add_model($data);
	    			if ($mess) {
	    				set_alert('success', _l('added_successfully'));

	    			} else {
	    				set_alert('warning', _l('Add_model_name_false'));
	    			}
	    			redirect(admin_url('warehouse/setting?group=model'));

	    		} else {
	    			$id = $data['id'];
	    			unset($data['id']);
	    			$success = $this->warehouse_model->update_model($data, $id);
	    			if ($success) {
	    				set_alert('success', _l('updated_successfully'));
	    			} else {
	    				set_alert('warning', _l('updated_model_name_false'));
	    			}

	    			redirect(admin_url('warehouse/setting?group=model'));
	    		}
	    	}
	    }

	/**
	 * [delete_color
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_model($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=model'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_model($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=model'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=model'));
		}

	}

	    /**
	 * brands setting
	 * @param  string $id 
	 * @return [type]     
	 */
	    public function series_setting($id = '') {
	    	if ($this->input->post()) {
	    		$message = '';
	    		$data = $this->input->post();

	    		if (!$this->input->post('id')) {

	    			$mess = $this->warehouse_model->add_series($data);
	    			if ($mess) {
	    				set_alert('success', _l('added_successfully'));

	    			} else {
	    				set_alert('warning', _l('Add_series_name_false'));
	    			}
	    			redirect(admin_url('warehouse/setting?group=series'));

	    		} else {
	    			$id = $data['id'];
	    			unset($data['id']);
	    			$success = $this->warehouse_model->update_series($data, $id);
	    			if ($success) {
	    				set_alert('success', _l('updated_successfully'));
	    			} else {
	    				set_alert('warning', _l('updated_series_name_false'));
	    			}

	    			redirect(admin_url('warehouse/setting?group=series'));
	    		}
	    	}
	    }

	/**
	 * [delete_color
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_series($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=series'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_series($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=series'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=series'));
		}

	}


	/**
	 * get brand value
	 * @param  integer $warehouse_id 
	 * @return json               
	 */
	public function get_item_proposal_value()
	{	
		$data = $this->input->post();

		$item = $this->warehouse_model->get_item_proposal_value($data);

		echo json_encode([
			'item_options' => $item['item_options'],
			'model_options' => $item['model_options'],
			'series_options' => $item['series_options'],

		]);
	}

    /**
     * Convert lead to client
     * @since  version 1.0.1
     * @return mixed
     */
    public function wh_convert_to_customer()
    {
    	if (!is_staff_member()) {
    		access_denied('Lead Convert to Customer');
    	}
    	$this->load->model('leads_model');

    	if ($this->input->post()) {
    		$default_country  = get_option('customer_default_country');
    		$data             = $this->input->post();
            //update proposal status
    		if (isset($data['proposal_id'])) {
    			$proposal_id = $data['proposal_id'];
    			unset($data['proposal_id']);

    			$this->db->where('id', $proposal_id);
    			$this->db->update(db_prefix().'proposals',[
    				'processing'=>'1',
    			]);

    		}

    		$data['password'] = $this->input->post('password', false);

    		$original_lead_email = $data['original_lead_email'];
    		unset($data['original_lead_email']);

    		if (isset($data['transfer_notes'])) {
    			$notes = $this->misc_model->get_notes($data['leadid'], 'lead');
    			unset($data['transfer_notes']);
    		}

    		if (isset($data['transfer_consent'])) {
    			$this->load->model('gdpr_model');
    			$consents = $this->gdpr_model->get_consents(['lead_id' => $data['leadid']]);
    			unset($data['transfer_consent']);
    		}

    		if (isset($data['merge_db_fields'])) {
    			$merge_db_fields = $data['merge_db_fields'];
    			unset($data['merge_db_fields']);
    		}

    		if (isset($data['merge_db_contact_fields'])) {
    			$merge_db_contact_fields = $data['merge_db_contact_fields'];
    			unset($data['merge_db_contact_fields']);
    		}

    		if (isset($data['include_leads_custom_fields'])) {
    			$include_leads_custom_fields = $data['include_leads_custom_fields'];
    			unset($data['include_leads_custom_fields']);
    		}

    		if ($data['country'] == '' && $default_country != '') {
    			$data['country'] = $default_country;
    		}

    		$data['billing_street']  = $data['address'];
    		$data['billing_city']    = $data['city'];
    		$data['billing_state']   = $data['state'];
    		$data['billing_zip']     = $data['zip'];
    		$data['billing_country'] = $data['country'];

    		$data['is_primary'] = 1;
    		$id                 = $this->clients_model->add($data, true);
    		if ($id) {
    			$primary_contact_id = get_primary_contact_user_id($id);

    			if (isset($notes)) {
    				foreach ($notes as $note) {
    					$this->db->insert(db_prefix() . 'notes', [
    						'rel_id'         => $id,
    						'rel_type'       => 'customer',
    						'dateadded'      => $note['dateadded'],
    						'addedfrom'      => $note['addedfrom'],
    						'description'    => $note['description'],
    						'date_contacted' => $note['date_contacted'],
    					]);
    				}
    			}
    			if (isset($consents)) {
    				foreach ($consents as $consent) {
    					unset($consent['id']);
    					unset($consent['purpose_name']);
    					$consent['lead_id']    = 0;
    					$consent['contact_id'] = $primary_contact_id;
    					$this->gdpr_model->add_consent($consent);
    				}
    			}
    			if (!has_permission('customers', '', 'view') && get_option('auto_assign_customer_admin_after_lead_convert') == 1) {
    				$this->db->insert(db_prefix() . 'customer_admins', [
    					'date_assigned' => date('Y-m-d H:i:s'),
    					'customer_id'   => $id,
    					'staff_id'      => get_staff_user_id(),
    				]);
    			}
    			$this->leads_model->log_lead_activity($data['leadid'], 'not_lead_activity_converted', false, serialize([
    				get_staff_full_name(),
    			]));
    			$default_status = $this->leads_model->get_status('', [
    				'isdefault' => 1,
    			]);
    			$this->db->where('id', $data['leadid']);
    			$this->db->update(db_prefix() . 'leads', [
    				'date_converted' => date('Y-m-d H:i:s'),
    				'status'         => $default_status[0]['id'],
    				'junk'           => 0,
    				'lost'           => 0,
    			]);
                // Check if lead email is different then client email
    			$contact = $this->clients_model->get_contact(get_primary_contact_user_id($id));
    			if ($contact->email != $original_lead_email) {
    				if ($original_lead_email != '') {
    					$this->leads_model->log_lead_activity($data['leadid'], 'not_lead_activity_converted_email', false, serialize([
    						$original_lead_email,
    						$contact->email,
    					]));
    				}
    			}
    			if (isset($include_leads_custom_fields)) {
    				foreach ($include_leads_custom_fields as $fieldid => $value) {
                        // checked don't merge
    					if ($value == 5) {
    						continue;
    					}
                        // get the value of this leads custom fiel
    					$this->db->where('relid', $data['leadid']);
    					$this->db->where('fieldto', 'leads');
    					$this->db->where('fieldid', $fieldid);
    					$lead_custom_field_value = $this->db->get(db_prefix() . 'customfieldsvalues')->row()->value;
                        // Is custom field for contact ot customer
    					if ($value == 1 || $value == 4) {
    						if ($value == 4) {
    							$field_to = 'contacts';
    						} else {
    							$field_to = 'customers';
    						}
    						$this->db->where('id', $fieldid);
    						$field = $this->db->get(db_prefix() . 'customfields')->row();
                            // check if this field exists for custom fields
    						$this->db->where('fieldto', $field_to);
    						$this->db->where('name', $field->name);
    						$exists               = $this->db->get(db_prefix() . 'customfields')->row();
    						$copy_custom_field_id = null;
    						if ($exists) {
    							$copy_custom_field_id = $exists->id;
    						} else {
                                // there is no name with the same custom field for leads at the custom side create the custom field now
    							$this->db->insert(db_prefix() . 'customfields', [
    								'fieldto'        => $field_to,
    								'name'           => $field->name,
    								'required'       => $field->required,
    								'type'           => $field->type,
    								'options'        => $field->options,
    								'display_inline' => $field->display_inline,
    								'field_order'    => $field->field_order,
    								'slug'           => slug_it($field_to . '_' . $field->name, [
    									'separator' => '_',
    								]),
    								'active'        => $field->active,
    								'only_admin'    => $field->only_admin,
    								'show_on_table' => $field->show_on_table,
    								'bs_column'     => $field->bs_column,
    							]);
    							$new_customer_field_id = $this->db->insert_id();
    							if ($new_customer_field_id) {
    								$copy_custom_field_id = $new_customer_field_id;
    							}
    						}
    						if ($copy_custom_field_id != null) {
    							$insert_to_custom_field_id = $id;
    							if ($value == 4) {
    								$insert_to_custom_field_id = get_primary_contact_user_id($id);
    							}
    							$this->db->insert(db_prefix() . 'customfieldsvalues', [
    								'relid'   => $insert_to_custom_field_id,
    								'fieldid' => $copy_custom_field_id,
    								'fieldto' => $field_to,
    								'value'   => $lead_custom_field_value,
    							]);
    						}
    					} elseif ($value == 2) {
    						if (isset($merge_db_fields)) {
    							$db_field = $merge_db_fields[$fieldid];
                                // in case user don't select anything from the db fields
    							if ($db_field == '') {
    								continue;
    							}
    							if ($db_field == 'country' || $db_field == 'shipping_country' || $db_field == 'billing_country') {
    								$this->db->where('iso2', $lead_custom_field_value);
    								$this->db->or_where('short_name', $lead_custom_field_value);
    								$this->db->or_like('long_name', $lead_custom_field_value);
    								$country = $this->db->get(db_prefix() . 'countries')->row();
    								if ($country) {
    									$lead_custom_field_value = $country->country_id;
    								} else {
    									$lead_custom_field_value = 0;
    								}
    							}
    							$this->db->where('userid', $id);
    							$this->db->update(db_prefix() . 'clients', [
    								$db_field => $lead_custom_field_value,
    							]);
    						}
    					} elseif ($value == 3) {
    						if (isset($merge_db_contact_fields)) {
    							$db_field = $merge_db_contact_fields[$fieldid];
    							if ($db_field == '') {
    								continue;
    							}
    							$this->db->where('id', $primary_contact_id);
    							$this->db->update(db_prefix() . 'contacts', [
    								$db_field => $lead_custom_field_value,
    							]);
    						}
    					}
    				}
    			}
                // set the lead to status client in case is not status client
    			$this->db->where('isdefault', 1);
    			$status_client_id = $this->db->get(db_prefix() . 'leads_status')->row()->id;
    			$this->db->where('id', $data['leadid']);
    			$this->db->update(db_prefix() . 'leads', [
    				'status' => $status_client_id,
    			]);

    			set_alert('success', _l('lead_to_client_base_converted_success'));

    			if (is_gdpr() && get_option('gdpr_after_lead_converted_delete') == '1') {
    				$this->leads_model->delete($data['leadid']);

    				$this->db->where('userid', $id);
    				$this->db->update(db_prefix() . 'clients', ['leadid' => null]);
    			}

    			log_activity('Created Lead Client Profile [LeadID: ' . $data['leadid'] . ', ClientID: ' . $id . ']');
    			hooks()->do_action('lead_converted_to_customer', ['lead_id' => $data['leadid'], 'customer_id' => $id]);
    			redirect(admin_url('proposals/list_proposals'));
    		}
    	}
    }


    /**
     * proposal convert processing
     * @return view 
     */
    public function proposal_convert_processing()
    {
    	$data = $this->input->post();

    	$status = false;
        //get proposal
    	$this->db->where('id', $data['proposal_id']);
    	$proposal_value = $this->db->get(db_prefix().'proposals')->row();
    	if($proposal_value){
    		if($proposal_value->processing == ''){
    			$this->db->where('id', $data['proposal_id']);
    			$this->db->update(db_prefix().'proposals',[
    				'processing'=>'1',
    			]);

    			$status = true;
    			$message  = _l('convert_proposal_success');
    		}else{
    			$message  = _l('proposal_has_been_converted');

    		}


    	}else{
    		$message  = _l('convert_proposal_false');

    	}

    	echo json_encode([

    		'status' => $status,
    		'message' => $message,

    	]);

    }


    public function custom_fields_setting($id = '') {
    	if ($this->input->post()) {
    		$message = '';
    		$data = $this->input->post();

    		if (!$this->input->post('id')) {

    			$mess = $this->warehouse_model->add_custom_fields_warehouse($data);
    			if ($mess) {
    				set_alert('success', _l('added_successfully'));

    			} else {
    				set_alert('warning', _l('Add_commodity_type_false'));
    			}
    			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));

    		} else {
    			$id = $data['id'];
    			unset($data['id']);
    			$success = $this->warehouse_model->update_custom_fields_warehouse($data, $id);
    			if ($success) {
    				set_alert('success', _l('updated_successfully'));
    			} else {
    				set_alert('warning', _l('updated_commodity_type_false'));
    			}

    			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
    		}
    	}
    }

	/**
	 * [delete_color description]
	 * @param  [type] $id  
	 * @return [type]      
	 */
	public function delete_custom_fields_warehouse($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$response = $this->warehouse_model->delete_custom_fields_warehouse($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
		}

	}


	/**
	 * check warehouse custom fields
	 * @param  [type] $id
	 * @return [type]    
	 */
	public function check_warehouse_custom_fields() {
		$data = $this->input->post();

		$success = $this->warehouse_model->check_warehouse_custom_fields($data);
		if($success){

			$message = _l('custom_fields');
		}else{
			$message = _l('custom_fields_have_been_created');
		}
		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}

	/**
	 * send goods delivery
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_delivery_ajax() {

		if(!has_permission('warehouse', '', 'create')  &&  !is_admin()) {
			access_denied('warehouse');
		}

		$id = $this->input->post('id');
		$data_result = $this->warehouse_model->delivery_note_get_data_send_mail($id);

		echo json_encode([
			'options' => $data_result['options'],
			'primary_email' => $data_result['primary_email'],
		]);
		die;

	}

	/**
	 * get primary contact
	 * @return [type] 
	 */
	public function get_primary_contact()
	{	
		$primary_email ='';

		$userid = $this->input->post('userid');
		$contact_value = $this->clients_model->get_contact($userid);
		if($contact_value){
			$primary_email 	= $contact_value->email;
		}

		echo json_encode([
			'primary_email' => $primary_email,
		]);
		die;

	}

	/**
	 * send_goods_delivery
	 * @return [type] 
	 */
	public function send_goods_delivery(){
		if($this->input->post()){
			$data = $this->input->post();

			if(isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != ''){

				if(file_exists(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/send_delivery_note/'. $data['goods_delivery'])){
					$delete_old = delete_dir(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/send_delivery_note/'. $data['goods_delivery']);
				}else{
					$delete_old = true;
				}

				if($delete_old == true){
					handle_send_delivery_note($data['goods_delivery']);
				}   
			}

			$send = $this->warehouse_model->send_delivery_note($data);
			if($send){
				set_alert('success',_l('send_delivery_note_by_email_successfully'));

			}else{
				set_alert('warning',_l('send_delivery_note_by_email_fail'));
			}
			redirect(admin_url('warehouse/manage_delivery/'.$data['goods_delivery']));

		}
	}


    /**
     * check sku duplicate
     * @return [type] 
     */
    public function check_sku_duplicate()
    {
    	$data = $this->input->post();
    	$result = $this->warehouse_model->check_sku_duplicate($data);
    	echo json_encode([
    		'message' => $result
    	]);
    	die;	
    }

    /**
     * stock internal delivery pdf
     * @param  [type] $id 
     * @return [type]     
     */
    public function stock_internal_delivery_pdf($id) {
		if (!$id) {
			redirect(admin_url('warehouse/manage_goods_delivery/manage_delivery'));
		}

		$stock_export = $this->warehouse_model->get_stock_internal_delivery_pdf_html($id);

		try {
			$pdf = $this->warehouse_model->stock_internal_delivery_pdf($stock_export);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';

		if ($this->input->get('output_type')) {
			$type = $this->input->get('output_type');
		}

		if ($this->input->get('print')) {
			$type = 'I';
		}

		$pdf->Output('goods_delivery_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);
	}


	/**
	 * item print barcode
	 * @return [type] 
	 */
	public function item_print_barcode()
	{
		$data = $this->input->post();

		$stock_export = $this->warehouse_model->get_print_barcode_pdf_html($data);
		
		try {
			$pdf = $this->warehouse_model->print_barcode_pdf($stock_export);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'I';

		if ($this->input->get('output_type')) {
			$type = $this->input->get('output_type');
		}

		if ($this->input->get('print')) {
			$type = 'I';
		}


		$pdf->Output('print_barcode_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);

	}

	/**
	 * save and send request send mail
	 * @return [type] 
	 */
	public function save_and_send_request_send_mail($data ='') {
		if ((isset($data)) && $data != '') {
			$this->warehouse_model->send_mail($data);

			$success = 'success';
			echo json_encode([
				'success' => $success,
			]);
		}
	}
	
	/**
	 * reset data
	 * @return [type] 
	 */
	public function reset_data()
	{

		if ( !is_admin()) {
			access_denied('warehouse');
		}
			//delete inventory_manage
			$this->db->truncate(db_prefix().'inventory_manage');
			//delete goods_receipt
			$this->db->truncate(db_prefix().'goods_receipt');
			//delete goods_receipt_detail
			$this->db->truncate(db_prefix().'goods_receipt_detail');
			//delete goods_delivery
			$this->db->truncate(db_prefix().'goods_delivery');
			//delete goods_delivery_detail
			$this->db->truncate(db_prefix().'goods_delivery_detail');
			//delete goods_delivery_invoices_pr_orders
			$this->db->truncate(db_prefix().'goods_delivery_invoices_pr_orders');
			//delete goods_transaction_detail
			$this->db->truncate(db_prefix().'goods_transaction_detail');
			//delete internal_delivery_note
			$this->db->truncate(db_prefix().'internal_delivery_note');
			//delete internal_delivery_note_detail
			$this->db->truncate(db_prefix().'internal_delivery_note_detail');
			//delete wh_loss_adjustment
			$this->db->truncate(db_prefix().'wh_loss_adjustment');
			//delete wh_loss_adjustment_detail
			$this->db->truncate(db_prefix().'wh_loss_adjustment_detail');
			//delete wh_approval_details
			$this->db->truncate(db_prefix().'wh_approval_details');
			//delete wh_activity_log
			$this->db->truncate(db_prefix().'wh_activity_log');

			//delete sub folder STOCK_EXPORT
			foreach(glob(WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

			    if(is_dir($file)) {
			    	delete_dir(WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER.$filename);
			    }
			}

			//delete sub folder STOCK_IMPORT
			foreach(glob(WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

			    if(is_dir($file)) {
			    	delete_dir(WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER.$filename);
			    }
			}

			//delete sub folder LOSS
			foreach(glob(WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

			    if(is_dir($file)) {
			    	delete_dir(WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER.$filename);
			    }
			}
			
			//delete sub folder INTERNAL
			foreach(glob(WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

			    if(is_dir($file)) {
			    	delete_dir(WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER.$filename);
			    }
			}
			
			//delete sub folder send delivery note
			foreach(glob('modules/warehouse/uploads/send_delivery_note/' . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

			    if(is_dir($file)) {
			    	delete_dir('modules/warehouse/uploads/send_delivery_note/'.$filename);
			    }
			}
			 
			

			//delete create task rel_type: "stock_import", "stock_export".
			$this->db->where('rel_type', 'stock_import');
			$this->db->or_where('rel_type', 'stock_export');
			$this->db->delete(db_prefix() . 'tasks');

			set_alert('success',_l('reset_data_successful'));
			
			redirect(admin_url('warehouse/setting?group=reset_data'));

	}

	/**
	 * get variation html add
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_variation_html_add(){
    	$variation_html = $this->warehouse_model->get_variation_html('');
    	$item_html = $this->warehouse_model->get_list_parent_item(['id' => '']);

    	echo json_encode([ 
    		'variation_html' => $variation_html['html'],
    		'variation_index' => $variation_html['index'],
    		'item_html' => $item_html['item_options'],

    	]);
    }

    /**
     * get variation from parent item
     * @return [type] 
     */
    public function get_variation_from_parent_item()
    {
    	$data = $this->input->post();

    	$this->warehouse_model->get_variation_from_parent_item($data);

    	echo json_encode([ 
    		'variation_html' => $variation_html['html'],
    		'variation_index' => $variation_html['index'],
    		'item_html' => $item_html['item_options'],

    	]);
    }

}