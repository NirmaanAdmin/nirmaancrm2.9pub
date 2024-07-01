<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * warehouse model
 */
class Warehouse_model extends App_Model {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * add commodity type
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_commodity_type($data, $id = false) {
		$commodity_type = str_replace(', ', '|/\|', $data['hot_commodity_type']);

		$data_commodity_type = explode(',', $commodity_type);
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_commodity_type as $commodity_type_key => $commodity_type_value) {
			if ($commodity_type_value == '') {
				$commodity_type_value = 0;
			}
			if (($commodity_type_key + 1) % 5 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $commodity_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'ware_commodity_type', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('commodity_type_id', $id);
					$this->db->update(db_prefix() . 'ware_commodity_type', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($commodity_type_key + 1) % 5) {
					case 1:
					$arr_temp['commondity_code'] = str_replace('|/\|', ', ', $commodity_type_value);
					if ($commodity_type_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['commondity_name'] = str_replace('|/\|', ', ', $commodity_type_value);
					break;
					case 3:
					$arr_temp['order'] = $commodity_type_value;
					break;
					case 4:
					//display 1: display (yes) , 0: not displayed (no)
					if ($commodity_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 *  get commodity type
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_commodity_type($id = false) {

		if (is_numeric($id)) {
			$this->db->where('commodity_type_id', $id);

			return $this->db->get(db_prefix() . 'ware_commodity_type')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from ' . db_prefix() . 'ware_commodity_type')->result_array();
		}

	}

	/**
	 * get commodity type add commodity
	 * @return array
	 */
	public function get_commodity_type_add_commodity() {

		return $this->db->query('select * from tblware_commodity_type where display = 1 order by tblware_commodity_type.order asc ')->result_array();

	}

	/**
	 * delete commodity type
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_commodity_type($id) {
		$this->db->where('commodity_type_id', $id);
		$this->db->delete(db_prefix() . 'ware_commodity_type');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * add unit type
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_unit_type($data, $id = false) {

		$unit_type = str_replace(', ', '|/\|', $data['hot_unit_type']);
		$data_unit_type = explode(',', $unit_type);
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_unit_type as $unit_type_key => $unit_type_value) {
			if ($unit_type_value == '') {
				$unit_type_value = 0;
			}
			if (($unit_type_key + 1) % 6 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $unit_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'ware_unit_type', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('unit_type_id', $id);
					$this->db->update(db_prefix() . 'ware_unit_type', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($unit_type_key + 1) % 6) {
					case 1:
					$arr_temp['unit_code'] = str_replace('|/\|', ', ', $unit_type_value);

					if ($unit_type_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['unit_name'] = str_replace('|/\|', ', ', $unit_type_value);
					break;
					case 3:
					$arr_temp['unit_symbol'] = $unit_type_value;
					break;
					case 4:
					$arr_temp['order'] = $unit_type_value;
					break;
					case 5:
					//display 1: display (yes) , 0: not displayed (no)
					if ($unit_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get unit type
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_unit_type($id = false) {

		if (is_numeric($id)) {
			$this->db->where('unit_type_id', $id);

			return $this->db->get(db_prefix() . 'ware_unit_type')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblware_unit_type')->result_array();
		}

	}

	/**
	 * get unit add commodity
	 * @return array
	 */
	public function get_unit_add_commodity() {
		return $this->db->query('select * from tblware_unit_type where display = 1 order by tblware_unit_type.order asc ')->result_array();
	}

	/**
	 * get unit code name
	 * @return array
	 */
	public function get_units_code_name() {
		return $this->db->query('select unit_type_id as id, unit_name as label from ' . db_prefix() . 'ware_unit_type')->result_array();
	}

	/**
	 * get warehouse code name
	 * @return array
	 */
	public function get_warehouse_code_name() {
		return $this->db->query('select warehouse_id as id, warehouse_name as label from ' . db_prefix() . 'warehouse')->result_array();
	}

	/**
	 * delete unit type
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_unit_type($id) {
		$this->db->where('unit_type_id', $id);
		$this->db->delete(db_prefix() . 'ware_unit_type');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * add size type
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_size_type($data, $id = false) {
		$size_type = str_replace(', ', '|/\|', $data['hot_size_type']);

		$data_size_type = explode(',', ($size_type));
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_size_type as $size_type_key => $size_type_value) {
			if ($size_type_value == '') {
				$size_type_value = 0;
			}
			if (($size_type_key + 1) % 6 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $size_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'ware_size_type', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('size_type_id', $id);
					$this->db->update(db_prefix() . 'ware_size_type', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($size_type_key + 1) % 6) {
					case 1:
					$arr_temp['size_code'] = str_replace('|/\|', ', ', $size_type_value);
					if ($size_type_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['size_name'] = str_replace('|/\|', ', ', $size_type_value);
					break;
					case 3:
					$arr_temp['size_symbol'] = $size_type_value;
					break;
					case 4:
					$arr_temp['order'] = $size_type_value;
					break;
					case 5:
					//display 1: display (yes) , 0: not displayed (no)
					if ($size_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get size type
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_size_type($id = false) {

		if (is_numeric($id)) {
			$this->db->where('size_type_id', $id);

			return $this->db->get(db_prefix() . 'ware_size_type')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblware_size_type')->result_array();
		}

	}

	/**
	 * get size add commodity
	 * @return array
	 */
	public function get_size_add_commodity() {

		return $this->db->query('select * from tblware_size_type where display = 1 order by tblware_size_type.order asc')->result_array();

	}

	/**
	 * delete size type
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_size_type($id) {
		$this->db->where('size_type_id', $id);
		$this->db->delete(db_prefix() . 'ware_size_type');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * add style type
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_style_type($data, $id = false) {
		$style_type = str_replace(', ', '|/\|', $data['hot_style_type']);

		$data_style_type = explode(',', ($style_type));
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_style_type as $style_type_key => $style_type_value) {
			if ($style_type_value == '') {
				$style_type_value = 0;
			}
			if (($style_type_key + 1) % 6 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $style_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'ware_style_type', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('style_type_id', $id);
					$this->db->update(db_prefix() . 'ware_style_type', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($style_type_key + 1) % 6) {
					case 1:
					$arr_temp['style_code'] = str_replace('|/\|', ', ', $style_type_value);
					if ($style_type_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['style_barcode'] = str_replace('|/\|', ', ', $style_type_value);
					break;
					case 3:
					$arr_temp['style_name'] = str_replace('|/\|', ', ', $style_type_value);
					break;
					case 4:
					$arr_temp['order'] = $style_type_value;
					break;
					case 5:
					//display 1: display (yes) , 0: not displayed (no)
					if ($style_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get style type
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_style_type($id = false) {

		if (is_numeric($id)) {
			$this->db->where('style_type_id', $id);

			return $this->db->get(db_prefix() . 'ware_style_type')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblware_style_type')->result_array();
		}

	}

	/**
	 * get style add commodity
	 * @return array
	 */
	public function get_style_add_commodity() {

		return $this->db->query('select * from tblware_style_type where display = 1 order by tblware_style_type.order asc')->result_array();

	}

	/**
	 * delete style type
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_style_type($id) {
		$this->db->where('style_type_id', $id);
		$this->db->delete(db_prefix() . 'ware_style_type');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * add body type
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_body_type($data, $id = false) {
		$body_type = str_replace(', ', '|/\|', $data['hot_body_type']);

		$data_body_type = explode(',', ($body_type));
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_body_type as $body_type_key => $body_type_value) {
			if ($body_type_value == '') {
				$body_type_value = 0;
			}
			if (($body_type_key + 1) % 5 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $body_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'ware_body_type', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('body_type_id', $id);
					$this->db->update(db_prefix() . 'ware_body_type', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($body_type_key + 1) % 5) {
					case 1:
					$arr_temp['body_code'] = str_replace('|/\|', ', ', $body_type_value);
					if ($body_type_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['body_name'] = str_replace('|/\|', ', ', $body_type_value);
					break;
					case 3:
					$arr_temp['order'] = $body_type_value;
					break;
					case 4:
					//display 1: display (yes) , 0: not displayed (no)
					if ($body_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get body type
	 * @param  boolean $id
	 * @return row or array
	 */
	public function get_body_type($id = false) {

		if (is_numeric($id)) {
			$this->db->where('body_type_id', $id);

			return $this->db->get(db_prefix() . 'ware_body_type')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblware_body_type')->result_array();
		}

	}

	/**
	 * get body add commodity
	 * @return array
	 */
	public function get_body_add_commodity() {

		return $this->db->query('select * from tblware_body_type where display = 1 order by tblware_body_type.order asc')->result_array();
	}

	/**
	 * delete body type
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_body_type($id) {
		$this->db->where('body_type_id', $id);
		$this->db->delete(db_prefix() . 'ware_body_type');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * add commodity group type
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_commodity_group_type($data, $id = false) {
		$data['commodity_group'] = str_replace(', ', '|/\|', $data['hot_commodity_group_type']);

		$data_commodity_group_type = explode(',', $data['commodity_group']);
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_commodity_group_type as $commodity_group_type_key => $commodity_group_type_value) {
			if ($commodity_group_type_value == '') {
				$commodity_group_type_value = 0;
			}
			if (($commodity_group_type_key + 1) % 5 == 0) {

				$arr_temp['note'] = str_replace('|/\|', ', ', $commodity_group_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'items_groups', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('id', $id);
					$this->db->update(db_prefix() . 'items_groups', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}

				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($commodity_group_type_key + 1) % 5) {
					case 1:
					if(is_numeric($id)){
						//update
						$arr_temp['commodity_group_code'] = str_replace('|/\|', ', ', $commodity_group_type_value);
						$flag_empty = 1;

					}else{
						//add
						$arr_temp['commodity_group_code'] = str_replace('|/\|', ', ', $commodity_group_type_value);

						if ($commodity_group_type_value != '0') {
							$flag_empty = 1;
						}
						
					}
					break;
					case 2:
					$arr_temp['name'] = str_replace('|/\|', ', ', $commodity_group_type_value);
					break;
					case 3:
					$arr_temp['order'] = $commodity_group_type_value;
					break;
					case 4:
					//display 1: display (yes) , 0: not displayed (no)
					if ($commodity_group_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get commodity group type
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_commodity_group_type($id = false) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'items_groups')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblitems_groups')->result_array();
		}

	}

	/**
	 * get commodity group add commodity
	 * @return array
	 */
	public function get_commodity_group_add_commodity() {

		return $this->db->query('select * from tblitems_groups where display = 1 order by tblitems_groups.order asc ')->result_array();
	}

	/**
	 * delete commodity group type
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_commodity_group_type($id) {
		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'items_groups');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * add warehouse
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_warehouse($data, $id = false) {

		$data['warehouse_type'] = str_replace(', ', '|/\|', $data['hot_warehouse_type']);

		$data_warehouse_type = explode(',', $data['warehouse_type']);

		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_warehouse_type as $warehouse_key => $warehouse_value) {
			if ($warehouse_value == '') {
				$warehouse_value = 0;
			}
			if (($warehouse_key + 1) % 6 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $warehouse_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'warehouse', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('warehouse_id', $id);
					$this->db->update(db_prefix() . 'warehouse', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($warehouse_key + 1) % 6) {
					case 1:
					$arr_temp['warehouse_code'] = str_replace('|/\|', ', ', $warehouse_value);
					if ($warehouse_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['warehouse_name'] = str_replace('|/\|', ', ', $warehouse_value);
					break;
					case 3:
					$arr_temp['warehouse_address'] = str_replace('|/\|', ', ', $warehouse_value);
					break;
					case 4:
					$arr_temp['order'] = $warehouse_value;
					break;
					case 5:
					//display 1: display (yes) , 0: not displayed (no)
					if ($warehouse_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get warehouse
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_warehouse($id = false) {

		if (is_numeric($id)) {
			$this->db->where('warehouse_id', $id);

			return $this->db->get(db_prefix() . 'warehouse')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblwarehouse')->result_array();
		}

	}

	/**
	 * get warehouse add commodity
	 * @return array
	 */
	public function get_warehouse_add_commodity() {

		return $this->db->query('select * from tblwarehouse where display = 1 order by tblwarehouse.order asc')->result_array();
	}

	/**
	 * delete warehouse
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_warehouse($id) {
		$this->db->where('warehouse_id', $id);
		$this->db->delete(db_prefix() . 'warehouse');
		if ($this->db->affected_rows() > 0) {
			/*delete customfieldsvalues*/
			$this->db->where('relid', $id);
			$this->db->where('fieldto', 'warehouse_name');
			$this->db->delete(db_prefix() . 'customfieldsvalues');

			return true;
		}
		return false;
	}

	/**
	 * add commodity
	 * @param array $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_commodity($data, $id = false) {
		$data['warehouse_type'] = str_replace(', ', '|/\|', $data['hot_warehouse_type']);
		$data_warehouse_type = explode(',', $data['warehouse_type']);

		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_warehouse_type as $warehouse_key => $warehouse_value) {
			$data_inventory_min = [];
			if ($warehouse_value == '') {
				$warehouse_value = 0;
			}
			if (($warehouse_key + 1) % 17 == 0) {
				$arr_temp['type_product'] = str_replace('|/\|', ', ', $warehouse_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'items', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$data_inventory_min['commodity_id'] = $insert_id;
						$data_inventory_min['commodity_code'] = $arr_temp['commodity_code'];
						$data_inventory_min['commodity_name'] = $arr_temp['description'];
						$this->add_inventory_min($data_inventory_min);
						$results++;
					}
				}
				if (is_numeric($id)) {
					$this->db->where('id', $id);
					$this->db->update(db_prefix() . 'items', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($warehouse_key + 1) % 17) {
					case 1:
					$arr_temp['commodity_code'] = str_replace('|/\|', ', ', $warehouse_value);
					break;
					case 2:
					$arr_temp['commodity_barcode'] = str_replace('|/\|', ', ', $warehouse_value);
					break;
					case 3:
					$arr_temp['description'] = str_replace('|/\|', ', ', $warehouse_value);
					break;
					case 4:
					$arr_temp['unit_id'] = $warehouse_value;
					if ($warehouse_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 5:
					$arr_temp['commodity_type'] = $warehouse_value;
					break;
					case 6:
					$arr_temp['warehouse_id'] = $warehouse_value;
					break;
					case 7:
					$arr_temp['group_id'] = $warehouse_value;
					break;
					case 8:
					$arr_temp['tax'] = $warehouse_value;
					break;
					case 9:
					$arr_temp['origin'] = str_replace('|/\|', ', ', $warehouse_value);
					break;
					case 10:
					$arr_temp['style_id'] = $warehouse_value;
					break;
					case 11:
					$arr_temp['model_id'] = $warehouse_value;
					break;
					case 12:
					$arr_temp['size_id'] = $warehouse_value;
					break;
					case 13:
					$arr_temp['images'] = $warehouse_value;
					break;
					case 14:
					$arr_temp['date_manufacture'] = $warehouse_value;
					break;
					case 15:
					$arr_temp['expiry_date'] = $warehouse_value;
					break;
					case 16:
					$arr_temp['rate'] = $warehouse_value;
					break;

				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * get commodity
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_commodity($id = false) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'items')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblitems')->result_array();
		}

	}

	/**
	 * get commodity code name
	 * @return array
	 */
	public function get_commodity_code_name() {
		return $this->db->query('select id as id, CONCAT(commodity_code,"_",description) as label from ' . db_prefix() . 'items where active = 1')->result_array();

	}

	/**
	 * get items code name
	 * @return array
	 */
	public function get_items_code_name() {
		return $this->db->query('select id as id, CONCAT(commodity_code," - " ,description) as label from ' . db_prefix() . 'items where active = 1')->result_array();

	}

	/**
	 * delete commodity
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_commodity($id) {
		
		hooks()->do_action('delete_item_on_woocommerce', $id);
		
		/*delete commodity min*/
		$this->db->where('commodity_id', $id);
		$this->db->delete(db_prefix() . 'inventory_commodity_min');
		/*delete file attachment*/
		$array_file= $this->get_warehourse_attachments($id);
		if(count($array_file) > 0 ){
			foreach ($array_file as $key => $file_value) {
				$this->delete_commodity_file($file_value['id']);
			}
		}
		
		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'items');
		if ($this->db->affected_rows() > 0) {

			return true;
		}
		return false;

	}

	/**
	 * get commodity hansometable
	 * @param  boolean $id
	 * @return object
	 */
	public function get_commodity_hansometable($id = false) {

		if (is_numeric($id)) {
			return $this->db->query('select description, rate, unit_id, taxrate, purchase_price,'.db_prefix().'items.tax,' . db_prefix() . 'taxes.name from ' . db_prefix() . 'items left join ' . db_prefix() . 'ware_unit_type on  ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id
				left join ' . db_prefix() . 'taxes on ' . db_prefix() . 'items.tax = ' . db_prefix() . 'taxes.id where ' . db_prefix() . 'items.id = ' . $id)->row();
		}
	}

	/**
	 * create goods code
	 * @return	string
	 */
	public function create_goods_code() {
		
		$goods_code = get_warehouse_option('inventory_received_number_prefix') . get_warehouse_option('next_inventory_received_mumber');
		
		return $goods_code;

	}

	/**
	 * add goods
	 * @param array $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_goods_receipt($data, $id = false) {


		$check_appr = $this->get_approve_setting('1');
		$data['approval'] = 0;
		if ($check_appr && $check_appr != false) {
			$data['approval'] = 0;
		} else {
			$data['approval'] = 1;
		}

		if(isset($data['save_and_send_request']) ){
			$save_and_send_request = $data['save_and_send_request'];
			unset($data['save_and_send_request']);
		}



		
		/*get suppier name from supplier code*/
		if (get_status_modules_wh('purchase')) {
			if($data['supplier_code'] != ''){
				$this->load->model('purchase/purchase_model');
				$client                = $this->purchase_model->get_vendor($id);
				if(count($client) > 0 ){
					$data['supplier_name'] = $client[0]['company'];
				}

			}
		}


		if (isset($data['hot_purchase'])) {
			$hot_purchase = $data['hot_purchase'];
			unset($data['hot_purchase']);
		}
		$data['goods_receipt_code'] = $this->create_goods_code();
		
		if(!$this->check_format_date($data['date_c'])){
			$data['date_c'] = to_sql_date($data['date_c']);
		}else{
			$data['date_c'] = $data['date_c'];
		}
		
		if(!$this->check_format_date($data['date_add'])){
			$data['date_add'] = to_sql_date($data['date_add']);
		}else{
			$data['date_add'] = $data['date_add'];
		}

		if(isset($data['expiry_date'])){
			if(!$this->check_format_date($data['expiry_date'])){
				$data['expiry_date'] = to_sql_date($data['expiry_date']);
			}else{
				$data['expiry_date'] = $data['expiry_date'];
			}
		}

		$data['addedfrom'] = get_staff_user_id();

		$data['total_tax_money'] = reformat_currency_j($data['total_tax_money']);

		$data['total_goods_money'] = reformat_currency_j($data['total_goods_money']);
		$data['value_of_inventory'] = reformat_currency_j($data['value_of_inventory']);

		$data['total_money'] = reformat_currency_j($data['total_money']);

		$this->db->insert(db_prefix() . 'goods_receipt', $data);
		$insert_id = $this->db->insert_id();

		/*update save note*/

		if(isset($hot_purchase)){
			$goods_receipt_detail = json_decode($hot_purchase);

			$es_detail = [];
			$row = [];
			$rq_val = [];
			$header = [];

			$header[] = 'commodity_code';
			$header[] = 'warehouse_id';
			$header[] = 'unit_id';
			$header[] = 'quantities';
			$header[] = 'unit_price';
			$header[] = 'tax';
			$header[] = 'goods_money';
			$header[] = 'tax_money';
			$header[] = 'discount';
			$header[] = 'discount_money';
			$header[] = 'lot_number';
			$header[] = 'date_manufacture';
			$header[] = 'expiry_date';
			$header[] = 'note';


			foreach ($goods_receipt_detail as $key => $value) {

				if($value[0] != ''){

	                	//case choose warehouse from select 
					if($data['warehouse_id'] != ''){
						$value[1] = $data['warehouse_id'];
					}

					/*check lotnumber*/
					$lot_number_value = trim($value[10]," ");
					if(isset($lot_number_value) && $lot_number_value != '0'){
						$value[10] = $lot_number_value;

					}else{
						$value[10] = '';
					}

					/*check date manufacture*/
					if(!$this->check_format_date($value[11])){
						$value[11] = to_sql_date($value[11]);
					}else{
						$value[11] = $value[11];
					}

					/*check expiry date*/
					if(!$this->check_format_date($value[12])){
						$value[12] = to_sql_date($value[12]);
					}else{
						$value[12] = $value[12];
					}


					$es_detail[] = array_combine($header, $value);
				}
			}
		}


		if (isset($insert_id)) {

			/*insert detail*/
			foreach($es_detail as $key => $rqd){

				$es_detail[$key]['goods_receipt_id'] = $insert_id;

			}

			$this->db->insert_batch(db_prefix().'goods_receipt_detail',$es_detail);

			/*write log*/
			$data_log = [];
			$data_log['rel_id'] = $insert_id;
			$data_log['rel_type'] = 'stock_import';
			$data_log['staffid'] = get_staff_user_id();
			$data_log['date'] = date('Y-m-d H:i:s');
			$data_log['note'] = "stock_import";

			$this->add_activity_log($data_log);

			/*update next number setting*/
			$this->update_inventory_setting(['next_inventory_received_mumber' =>  get_warehouse_option('next_inventory_received_mumber')+1]);

				//send request approval
			if($save_and_send_request == 'true'){

				$this->send_request_approve(['rel_id' => $insert_id, 'rel_type' => '1', 'addedfrom' => $data['addedfrom']]);

			}


		}

		//approval if not approval setting
		if (isset($insert_id)) {
			if ($data['approval'] == 1) {
				$this->update_approve_request($insert_id, 1, 1);
			}
		}

		return $insert_id > 0 ? $insert_id : false;

	}

	/**
	 * get goods receipt
	 * @param  integer $id
	 * @return array or object
	 */
	public function get_goods_receipt($id) {
		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'goods_receipt')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblgoods_receipt')->result_array();
		}
	}

	/**
	 * get goods receipt detail
	 * @param  integer $id
	 * @return array
	 */
	public function get_goods_receipt_detail($id) {
		if (is_numeric($id)) {
			$this->db->where('goods_receipt_id', $id);

			return $this->db->get(db_prefix() . 'goods_receipt_detail')->result_array();
		}
		if ($id == false) {
			return $this->db->query('select * from tblgoods_receipt_detail')->result_array();
		}
	}

	/**
	 * get purchase request
	 * @param  integer $pur_order
	 * @return array
	 */
	public function get_pur_request($pur_order) {

		$arr_pur_resquest = [];
		$total_goods_money = 0;
		$total_money = 0;
		$total_tax_money = 0;
		$value_of_inventory = 0;

		$sql = 'select item_code as commodity_code, ' . db_prefix() . 'items.description, ' . db_prefix() . 'items.unit_id, unit_price, quantity as quantities, ' . db_prefix() . 'pur_order_detail.tax as tax, into_money, (' . db_prefix() . 'pur_order_detail.total-' . db_prefix() . 'pur_order_detail.into_money) as tax_money, total as goods_money, wh_quantity_received from ' . db_prefix() . 'pur_order_detail
		left join ' . db_prefix() . 'items on ' . db_prefix() . 'pur_order_detail.item_code =  ' . db_prefix() . 'items.id
		left join ' . db_prefix() . 'taxes on ' . db_prefix() . 'taxes.id = ' . db_prefix() . 'pur_order_detail.tax where ' . db_prefix() . 'pur_order_detail.pur_order = ' . $pur_order;
		$results = $this->db->query($sql)->result_array();

		$arr_results=[];
		$index=0;
		foreach ($results as $key => $value) {

			if((float)$value['quantities'] - (float)$value['wh_quantity_received'] > 0){

				$arr_results[$index]['commodity_code'] = $value['commodity_code'];
				$arr_results[$index]['description'] = $value['description'];
				$arr_results[$index]['unit_id'] = $value['unit_id'];
				$arr_results[$index]['unit_price'] = $value['unit_price'];
				$arr_results[$index]['tax'] = $value['tax'];
				$arr_results[$index]['into_money'] = $value['into_money'];
				$arr_results[$index]['wh_quantity_received'] = $value['wh_quantity_received'];



				$total_goods_money += ((float)$value['quantities'] - (float)$value['wh_quantity_received'])*(float)$value['unit_price'];
				$arr_results[$index]['quantities'] = (float)$value['quantities'] - (float)$value['wh_quantity_received'];
				$arr_results[$index]['goods_money'] = ((float)$value['quantities'] - (float)$value['wh_quantity_received'])*(float)$value['unit_price'];

				//get tax value
				$tax_rate = 0 ;
				if($value['tax'] != null && $value['tax'] != '') {
					$arr_tax = explode('|', $value['tax']);
					foreach ($arr_tax as $tax_id) {

						$tax = $this->get_taxe_value($tax_id);
						if($tax){
							$tax_rate += (float)$tax->taxrate;		    	
						}

					}
				}

				$arr_results[$index]['tax_money'] = $total_goods_money*(float)$tax_rate/100;
				$total_tax_money += (float)$total_goods_money*(float)$tax_rate/100;

				$index++;
			}
			
		}


		$total_money = $total_goods_money + $total_tax_money;
		$value_of_inventory = $total_goods_money;

		$arr_pur_resquest[] = $arr_results;
		$arr_pur_resquest[] = $total_tax_money;
		$arr_pur_resquest[] = $total_goods_money;
		$arr_pur_resquest[] = $value_of_inventory;
		$arr_pur_resquest[] = $total_money;
		$arr_pur_resquest[] = count($arr_results);


		return $arr_pur_resquest;
	}

	/**
	 * get staff
	 * @param  string $id
	 * @param  array  $where
	 * @return array or object
	 */
	public function get_staff($id = '', $where = []) {
		$select_str = '*,CONCAT(firstname," ",lastname) as full_name';

		// Used to prevent multiple queries on logged in staff to check the total unread notifications in core/AdminController.php
		if (is_staff_logged_in() && $id != '' && $id == get_staff_user_id()) {
			$select_str .= ',(SELECT COUNT(*) FROM ' . db_prefix() . 'notifications WHERE touserid=' . get_staff_user_id() . ' and isread=0) as total_unread_notifications, (SELECT COUNT(*) FROM ' . db_prefix() . 'todos WHERE finished=0 AND staffid=' . get_staff_user_id() . ') as total_unfinished_todos';
		}

		$this->db->select($select_str);
		$this->db->where($where);

		if (is_numeric($id)) {
			$this->db->where('staffid', $id);
			$staff = $this->db->get(db_prefix() . 'staff')->row();

			if ($staff) {
				$staff->permissions = $this->get_staff_permissions($id);
			}

			return $staff;
		}
		$this->db->order_by('firstname', 'desc');

		return $this->db->get(db_prefix() . 'staff')->result_array();
	}

	/**
	 * update status goods
	 * @param  integer $pur_orders_id
	 * @return boolean
	 */
	public function update_status_goods($pur_orders_id) {
		$arr_temp['status_goods'] = 1;
		$this->db->where('id', $pur_orders_id);
		$this->db->update(db_prefix() . 'pur_orders', $arr_temp);
	}

	/**
	 * add goods transaction detail
	 * @param array $data
	 * @param string $status
	 */
	public function add_goods_transaction_detail($data, $status) {
		if ($status == '1') {
			$data_insert['goods_receipt_id'] = $data['goods_receipt_id'];
			$data_insert['purchase_price'] = $data['unit_price'];
			$data_insert['expiry_date'] = $data['expiry_date'];
			$data_insert['lot_number'] = $data['lot_number'];
			
		} elseif ($status == '2') {
			$data_insert['goods_receipt_id'] = $data['goods_delivery_id'];
			$data_insert['price'] = $data['unit_price'];
			$data_insert['expiry_date'] = $data['expiry_date'];
			$data_insert['lot_number'] = $data['lot_number'];

		}

		/*get old quantity by item, warehouse*/
		$inventory_value = $this->get_quantity_inventory($data['warehouse_id'], $data['commodity_code']);
		$old_quantity =  null;
		if($inventory_value){
			$old_quantity = $inventory_value->inventory_number;
		}

		$data_insert['goods_id'] = $data['id'];
		$data_insert['old_quantity'] = $old_quantity;

		$data_insert['commodity_id'] = $data['commodity_code'];
		$data_insert['quantity'] = $data['quantities'];
		$data_insert['date_add'] = date('Y-m-d H:i:s');
		$data_insert['warehouse_id'] = $data['warehouse_id'];
		$data_insert['note'] = $data['note'];
		$data_insert['status'] = $status;
		// status '1:Goods receipt note 2:Goods delivery note',
		$this->db->insert(db_prefix() . 'goods_transaction_detail', $data_insert);

		return true;
	}

	/**
	 * add inventory manage
	 * @param array $data
	 * @param string $status
	 */
	public function add_inventory_manage($data, $status) {
		// status '1:Goods receipt note 2:Goods delivery note',
		

		if ($status == 1) {

			if(isset($data['lot_number']) && $data['lot_number'] != '0' && $data['lot_number'] != ''){
				/*have value*/
				$this->db->where('lot_number', $data['lot_number']);

			}else{

				/*lot number is 0 or ''*/
				$this->db->group_start();

				$this->db->where('lot_number', '0');
				$this->db->or_where('lot_number', '');
				$this->db->or_where('lot_number', null);

				$this->db->group_end();
			}

			if($data['expiry_date'] == ''){

				$this->db->where('expiry_date', null);
			}else{
				$this->db->where('expiry_date', $data['expiry_date']);
			}

			$this->db->where('warehouse_id', $data['warehouse_id']);
			$this->db->where('commodity_id', $data['commodity_code']);

			$total_rows = $this->db->count_all_results('tblinventory_manage');

			if ($total_rows > 0) {
				$status_insert_update = false;
			} else {
				$status_insert_update = true;
			}

			if (!$status_insert_update) {
				//update
				$this->db->where('warehouse_id', $data['warehouse_id']);
				$this->db->where('commodity_id', $data['commodity_code']);

				if(isset($data['lot_number']) && $data['lot_number'] != '0' && $data['lot_number'] != ''){
					/*have value*/
					$this->db->where('lot_number', $data['lot_number']);

				}else{

					/*lot number is 0 or ''*/
					$this->db->group_start();

					$this->db->where('lot_number', '0');
					$this->db->or_where('lot_number', '');
					$this->db->or_where('lot_number', null);

					$this->db->group_end();
				}

				if($data['expiry_date'] == ''){

					$this->db->where('expiry_date', null);
				}else{
					$this->db->where('expiry_date', $data['expiry_date']);
				}


				$result = $this->db->get('tblinventory_manage')->row();
				$inventory_number = $result->inventory_number;
				$update_id = $result->id;

				if ($status == 1) {
					//Goods receipt
					$data_update['inventory_number'] = (int) $inventory_number + (int) $data['quantities'];
				} elseif ($status == 2) {
					// 2:Goods delivery note
					$data_update['inventory_number'] = (int) $inventory_number - (int) $data['quantities'];
				}

				//update
				$this->db->where('id', $update_id);
				$this->db->update(db_prefix() . 'inventory_manage', $data_update);
				return;

			} else {
				//insert
				$data_insert['warehouse_id'] = $data['warehouse_id'];
				$data_insert['commodity_id'] = $data['commodity_code'];
				$data_insert['inventory_number'] = $data['quantities'];
				$data_insert['date_manufacture'] = $data['date_manufacture'];
				$data_insert['expiry_date'] = $data['expiry_date'];
				$data_insert['lot_number'] = $data['lot_number'];

				$this->db->insert(db_prefix() . 'inventory_manage', $data_insert);

				return;

			}
		} else {
			//status == 2 export
			//update
			$this->db->where('warehouse_id', $data['warehouse_id']);
			$this->db->where('commodity_id', $data['commodity_code']);
			$this->db->order_by('id', 'ASC');
			$result = $this->db->get('tblinventory_manage')->result_array();

			$temp_quantities = $data['quantities'];

			$expiry_date = '';
			$lot_number = '';
			foreach ($result as $result_value) {
				if (($result_value['inventory_number'] != 0) && ($temp_quantities != 0)) {

					if ($temp_quantities >= $result_value['inventory_number']) {
						$temp_quantities = (float) $temp_quantities - (float) $result_value['inventory_number'];

						//log lot number
						if(($result_value['lot_number'] != null) && ($result_value['lot_number'] != '') ){
							if(strlen($lot_number) != 0){
								$lot_number .=','.$result_value['lot_number'].','.$result_value['inventory_number'];
							}else{
								$lot_number .= $result_value['lot_number'].','.$result_value['inventory_number'];
							}
						}
						
						//log expiry date
						if(($result_value['expiry_date'] != null) && ($result_value['expiry_date'] != '') ){
							if(strlen($expiry_date) != 0){
								$expiry_date .=','.$result_value['expiry_date'].','.$result_value['inventory_number'];
							}else{
								$expiry_date .= $result_value['expiry_date'].','.$result_value['inventory_number'];
							}
						}

						//update inventory
						$this->db->where('id', $result_value['id']);
						$this->db->update(db_prefix() . 'inventory_manage', [
							'inventory_number' => 0,
						]);

					} else {

						//log lot number
						if(($result_value['lot_number'] != null) && ($result_value['lot_number'] != '') ){
							if(strlen($lot_number) != 0){
								$lot_number .=','.$result_value['lot_number'].','.$temp_quantities;
							}else{
								$lot_number .= $result_value['lot_number'].','.$temp_quantities;
							}
						}

						//log expiry date
						if(($result_value['expiry_date'] != null) && ($result_value['expiry_date'] != '') ){
							if(strlen($expiry_date) != 0){
								$expiry_date .=','.$result_value['expiry_date'].','.$temp_quantities;
							}else{
								$expiry_date .= $result_value['expiry_date'].','.$temp_quantities;
							}
						}


						//update inventory
						$this->db->where('id', $result_value['id']);
						$this->db->update(db_prefix() . 'inventory_manage', [
							'inventory_number' => (float) $result_value['inventory_number'] - (float) $temp_quantities,
						]);

						$temp_quantities = 0;

					}

				}

			}

			//update good delivery detail
			$this->db->where('id', $data['id']);
			$this->db->update(db_prefix() . 'goods_delivery_detail', [
				'expiry_date' => $expiry_date,
				'lot_number' => $lot_number,
			]);
			
			//goods transaction detail log
			$data['expiry_date'] = $expiry_date;
			$data['lot_number'] = $lot_number;
			$this->add_goods_transaction_detail($data, 2);

		}

		return true;

	}

	/**
	 * check commodity exist inventory
	 * @param  integer $warehouse_id
	 * @param  integer $commodity_id
	 * @return boolean
	 */
	public function check_commodity_exist_inventory($warehouse_id, $commodity_id, $lot_number, $expiry_date) {

		if(isset($lot_number) && $lot_number != '0' && $lot_number != ''){
			/*have value*/
			$this->db->where('lot_number', $lot_number);

		}else{

			/*lot number is 0 or ''*/
			$this->db->group_start();

			$this->db->where('lot_number', '0');
			$this->db->or_where('lot_number', '');
			$this->db->or_where('lot_number', null);

			$this->db->group_end();
		}

		$this->db->where('warehouse_id', $warehouse_id);
		$this->db->where('commodity_id', $commodity_id);

		if($expiry_date == ''){
			$this->db->where('expiry_date', null);
		}else{
			$this->db->where('expiry_date', $expiry_date);
		}

		$total_rows = $this->db->count_all_results('tblinventory_manage');

		//if > 0 update, else insert
		return $total_rows > 0 ? false : true;

	}

	/**
	 * get inventory commodity
	 * @param  integer $commodity_id
	 * @return array
	 */
	public function get_inventory_commodity($commodity_id) {
		$sql = 'SELECT ' . db_prefix() . 'warehouse.warehouse_code, sum(inventory_number) as inventory_number, unit_name FROM ' . db_prefix() . 'inventory_manage
		LEFT JOIN ' . db_prefix() . 'items on ' . db_prefix() . 'inventory_manage.commodity_id = ' . db_prefix() . 'items.id
		LEFT JOIN ' . db_prefix() . 'ware_unit_type on ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id
		LEFT JOIN ' . db_prefix() . 'warehouse on ' . db_prefix() . 'inventory_manage.warehouse_id = ' . db_prefix() . 'warehouse.warehouse_id
		where commodity_id = ' . $commodity_id . ' group by ' . db_prefix() . 'inventory_manage.warehouse_id';
		return $this->db->query($sql)->result_array();

	}

	/**
	 * add inventory min
	 * @param array $data
	 * return boolean
	 */
	public function add_inventory_min($data) {
		$data['inventory_number_min'] = 0;
		$this->db->insert(db_prefix() . 'inventory_commodity_min', $data);
		return;
	}

	/**
	 * get inventory min
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_inventory_min($id = false) {
		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'inventory_commodity_min')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblinventory_commodity_min')->result_array();
		}
	}

	/**
	 * update inventory min
	 * @param  array $data
	 * @return boolean
	 */
	public function update_inventory_min($data) {
		$inventory_min = str_replace(', ', '|/\|', $data['inventory_min']);
		$data_inventory = explode(',', $inventory_min);

		$results = 0;
		$results_update = '';
		foreach ($data_inventory as $inventory_key => $inventory_value) {
			$data_inventory_min = [];

			if (($inventory_key + 1) % 6 == 0) {
				$arr_temp['inventory_number_max'] = $inventory_value != '' ? $inventory_value : 0;

				if (is_numeric($arr_temp['id'])) {

					$this->db->where('id', (int) $arr_temp['id']);
					unset($arr_temp['id']);
					$this->db->update(db_prefix() . 'inventory_commodity_min', $arr_temp);
				}

				$arr_temp = [];
			} else {
				switch (($inventory_key + 1) % 6) {
					case 1:
					$arr_temp['id'] = $inventory_value;
					break;
					case 5:
					$arr_temp['inventory_number_min'] = $inventory_value;
					break;

				}
			}

		}

		return true;

	}

	/**
	 * get commodity warehouse
	 * @param  boolean $id
	 * @return array
	 */
	public function get_commodity_warehouse($commodity_id = false) {
		if ($commodity_id != false) {

			$sql = 'SELECT ' . db_prefix() . 'warehouse.warehouse_name FROM ' . db_prefix() . 'inventory_manage
			LEFT JOIN ' . db_prefix() . 'warehouse on ' . db_prefix() . 'inventory_manage.warehouse_id = ' . db_prefix() . 'warehouse.warehouse_id
			where ' . db_prefix() . 'inventory_manage.commodity_id = ' . $commodity_id;

			return $this->db->query($sql)->result_array();
		}

	}

	/**
	 * get total inventory commodity
	 * @param  boolean $id
	 * @return object
	 */
	public function get_total_inventory_commodity($commodity_id = false) {
		if ($commodity_id != false) {

			$sql = 'SELECT sum(inventory_number) as inventory_number FROM ' . db_prefix() . 'inventory_manage
			where ' . db_prefix() . 'inventory_manage.commodity_id = ' . $commodity_id . ' order by ' . db_prefix() . 'inventory_manage.warehouse_id';

			return $this->db->query($sql)->row();
		}

	}

	/**
	 * add approval setting
	 * @param  array $data
	 * @return boolean
	 */
	public function add_approval_setting($data) {
		unset($data['approval_setting_id']);

		if (isset($data['approver'])) {
			$setting = [];
			foreach ($data['approver'] as $key => $value) {
				$node = [];
				$node['approver'] = 'staff';
				$node['staff'] = $data['staff'][$key];
				$node['action'] = $data['action'][$key];

				$setting[] = $node;
			}
			unset($data['approver']);
			unset($data['staff']);
			unset($data['action']);
		}

		$data['setting'] = json_encode($setting);

		$this->db->insert(db_prefix() . 'wh_approval_setting', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			return true;
		}
		return false;
	}

	/**
	 * edit approval setting
	 * @param  integer $id
	 * @param   array $data
	 * @return    boolean
	 */
	public function edit_approval_setting($id, $data) {
		unset($data['approval_setting_id']);

		if (isset($data['approver'])) {
			$setting = [];
			foreach ($data['approver'] as $key => $value) {
				$node = [];
				$node['approver'] = 'staff';
				$node['staff'] = $data['staff'][$key];
				$node['action'] = $data['action'][$key];

				$setting[] = $node;
			}
			unset($data['approver']);
			unset($data['staff']);
			unset($data['action']);
		}
		$data['setting'] = json_encode($setting);

		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'wh_approval_setting', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * delete approval setting
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_approval_setting($id) {
		if (is_numeric($id)) {
			$this->db->where('id', $id);
			$this->db->delete(db_prefix() . 'wh_approval_setting');

			if ($this->db->affected_rows() > 0) {
				return true;
			}
		}
		return false;
	}

	/**
	 * get approval setting
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_approval_setting($id = '') {
		if (is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'wh_approval_setting')->row();
		}
		return $this->db->get(db_prefix() . 'wh_approval_setting')->result_array();
	}

	/**
	 * get staff sign
	 * @param   integer $rel_id
	 * @param   string $rel_type
	 * @return  array
	 */
	public function get_staff_sign($rel_id, $rel_type) {
		$this->db->select('*');

		$this->db->where('rel_id', $rel_id);
		$this->db->where('rel_type', $rel_type);
		$this->db->where('action', 'sign');
		$approve_status = $this->db->get(db_prefix() . 'wh_approval_details')->result_array();
		if (isset($approve_status)) {
			$array_return = [];
			foreach ($approve_status as $key => $value) {
				array_push($array_return, $value['staffid']);
			}
			return $array_return;
		}
		return [];
	}

	/**
	 * check approval detail
	 * @param   integer $rel_id
	 * @param   string $rel_type
	 * @return  boolean
	 */
	public function check_approval_details($rel_id, $rel_type) {
		$this->db->where('rel_id', $rel_id);
		$this->db->where('rel_type', $rel_type);
		$approve_status = $this->db->get(db_prefix() . 'wh_approval_details')->result_array();

		if (count($approve_status) > 0) {
			foreach ($approve_status as $value) {
				if ($value['approve'] == -1) {
					return 'reject';
				}
				if ($value['approve'] == 0) {
					$value['staffid'] = explode(', ', $value['staffid']);
					return $value;
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * get list approval detail
	 * @param   integer $rel_id
	 * @param   string $rel_type
	 * @return  array
	 */
	public function get_list_approval_details($rel_id, $rel_type) {
		$this->db->select('*');
		$this->db->where('rel_id', $rel_id);
		$this->db->where('rel_type', $rel_type);
		return $this->db->get(db_prefix() . 'wh_approval_details')->result_array();
	}

	/**
	 * add activity log
	 * @param array $data
	 * return boolean
	 */
	public function add_activity_log($data) {
		$this->db->insert(db_prefix() . 'wh_activity_log', $data);
		return true;
	}

	/**
	 * get activity log
	 * @param   integer $rel_id
	 * @param   string $rel_type
	 * @return  array
	 */
	public function get_activity_log($rel_id, $rel_type) {
		$this->db->where('rel_id', $rel_id);
		$this->db->where('rel_type', $rel_type);
		return $this->db->get(db_prefix() . 'wh_activity_log')->result_array();
	}

	/**
	 * 	delete activiti log
	 * @param   integer $rel_id
	 * @param   string $rel_type
	 * @return  boolean
	 */
	public function delete_activity_log($rel_id, $rel_type) {
		$this->db->where('rel_id', $rel_id);
		$this->db->where('rel_type', $rel_type);
		$this->db->delete(db_prefix() . 'wh_activity_log');
		return true;
	}

	/**
	 *  send request approve
	 * @param  array $data
	 * @return boolean
	 */
	public function send_request_approve($data) {
		if (!isset($data['status'])) {
			$data['status'] = '';
		}

		$date_send = date('Y-m-d H:i:s');
		$data_new = $this->get_approve_setting($data['rel_type'], $data['status']);
		if(!$data_new){
			return false;
		}


		$this->delete_approval_details($data['rel_id'], $data['rel_type']);
		$list_staff = $this->staff_model->get();
		$list = [];
		$staff_addedfrom = $data['addedfrom'];
		$sender = get_staff_user_id();

		foreach ($data_new as $value) {
			$row = [];

			if ($value->approver !== 'staff') {
				$value->staff_addedfrom = $staff_addedfrom;
				$value->rel_type = $data['rel_type'];
				$value->rel_id = $data['rel_id'];

				$approve_value = $this->get_staff_id_by_approve_value($value, $value->approver);
				if (is_numeric($approve_value)) {
					$approve_value = $this->staff_model->get($approve_value)->email;
				} else {

					$this->db->where('rel_id', $data['rel_id']);
					$this->db->where('rel_type', $data['rel_type']);
					$this->db->delete('tblwh_approval_details');

					return $value->approver;
				}
				$row['approve_value'] = $approve_value;

				$staffid = $this->get_staff_id_by_approve_value($value, $value->approver);

				if (empty($staffid)) {
					$this->db->where('rel_id', $data['rel_id']);
					$this->db->where('rel_type', $data['rel_type']);
					$this->db->delete('tblwh_approval_details');

					return $value->approver;
				}

				$row['action'] = $value->action;
				$row['staffid'] = $staffid;
				$row['date_send'] = $date_send;
				$row['rel_id'] = $data['rel_id'];
				$row['rel_type'] = $data['rel_type'];
				$row['sender'] = $sender;
				$this->db->insert('tblwh_approval_details', $row);

			} else if ($value->approver == 'staff') {
				$row['action'] = $value->action;
				$row['staffid'] = $value->staff;
				$row['date_send'] = $date_send;
				$row['rel_id'] = $data['rel_id'];
				$row['rel_type'] = $data['rel_type'];
				$row['sender'] = $sender;

				$this->db->insert('tblwh_approval_details', $row);
			}
		}
		return true;
	}

	/**
	 * get approve setting
	 * @param  integer] $type
	 * @param  string $status
	 * @return object
	 */
	public function get_approve_setting($type, $status = '') {

		$this->db->select('*');
		$this->db->where('related', $type);
		$approval_setting = $this->db->get('tblwh_approval_setting')->row();
		if ($approval_setting) {
			return json_decode($approval_setting->setting);
		} else {
			return false;
		}

	}

	/**
	 * delete approval details
	 * @param  integer $rel_id
	 * @param  string $rel_type
	 * @return  boolean
	 */
	public function delete_approval_details($rel_id, $rel_type) {
		$this->db->where('rel_id', $rel_id);
		$this->db->where('rel_type', $rel_type);
		$this->db->delete(db_prefix() . 'wh_approval_details');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * get staff id by approve value
	 * @param  array $data
	 * @param  integer $approve_value
	 * @return boolean
	 */
	public function get_staff_id_by_approve_value($data, $approve_value) {
		$list_staff = $this->staff_model->get();
		$list = [];
		$staffid = [];

		if ($approve_value == 'department_manager') {
			$staffid = $this->departments_model->get_staff_departments($data->staff_addedfrom)[0]['manager_id'];
		} elseif ($approve_value == 'direct_manager') {
			$staffid = $this->staff_model->get($data->staff_addedfrom)->team_manage;
		}

		return $staffid;
	}

	/**
	 *  update approval details
	 * @param  integer $id
	 * @param  array $data
	 * @return boolean
	 */
	public function update_approval_details($id, $data) {
		$data['date'] = date('Y-m-d H:i:s');
		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'wh_approval_details', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * update approve request
	 * @param  integer $rel_ids
	 * @param  string $rel_type
	 * @param  integer $status
	 * @return boolean
	 */
	public function update_approve_request($rel_id, $rel_type, $status) {
		$data_update = [];

		switch ($rel_type) {
		//case 1: stock_import
			case '1':
			$data_update['approval'] = $status;
			$this->db->where('id', $rel_id);
			$this->db->update(db_prefix() . 'goods_receipt', $data_update);

			// //update history stock, inventoty manage after staff approved
			$goods_receipt_detail = $this->get_goods_receipt_detail($rel_id);

			/*check goods receipt from PO*/
			$flag_update_status_po = true;

			$from_po = false;
			$goods_receipt = $this->get_goods_receipt($rel_id);

			if($goods_receipt){
				if(isset($goods_receipt->pr_order_id) && ($goods_receipt->pr_order_id != 0) ){
					$from_po = true;
				}
			}

			foreach ($goods_receipt_detail as $goods_receipt_detail_value) {
				
				/*update Without checking warehouse*/		

				if($this->check_item_without_checking_warehouse($goods_receipt_detail_value['commodity_code']) == true){

					$this->add_goods_transaction_detail($goods_receipt_detail_value, 1);
					$this->add_inventory_manage($goods_receipt_detail_value, 1);

					//update po detail
					if($from_po){
						$update_status = $this->update_po_detail_quantity($goods_receipt->pr_order_id, $goods_receipt_detail_value);
						if($update_status['flag_update_status'] == false){
							$flag_update_status_po = false;
						}

					}

				}

			}

			/*update status po*/
			if($from_po == true && $flag_update_status_po == true){
				if (get_status_modules_wh('purchase')) {
					if ($this->db->field_exists('delivery_status' ,db_prefix() . 'pur_orders')) { 
						$this->db->where('id', $goods_receipt->pr_order_id);
						$this->db->update(db_prefix() . 'pur_orders', ['status_goods' => 1, 'delivery_status' => 1]);
					}
				}

			}



			return true;
			break;
			case '2':
			$data_update['approval'] = $status;
			$this->db->where('id', $rel_id);
			$this->db->update(db_prefix() . 'goods_delivery', $data_update);

			//update status invoice or pur order for this inventory delivery
			$goods_delivery = $this->get_goods_delivery($rel_id);

			if($goods_delivery){

				if(is_numeric($goods_delivery->invoice_id) && $goods_delivery->invoice_id != 0){
					$type = 'invoice';
					$rel_type = $goods_delivery->invoice_id;
				}elseif(is_numeric($goods_delivery->pr_order_id) && $goods_delivery->pr_order_id != 0){
					$type = 'purchase_orders';
					$rel_type = $goods_delivery->pr_order_id;

				}

				if(isset($type)){
					$this->db->insert(db_prefix().'goods_delivery_invoices_pr_orders', [
						'rel_id' 	=> $rel_id,
						'rel_type' 	=> $rel_type,
						'type' 		=> $type,
					]);

				}


			}

			//update history stock, inventoty manage after staff approved

			$goods_delivery_detail = $this->get_goods_delivery_detail($rel_id);
			foreach ($goods_delivery_detail as $goods_delivery_detail_value) {
				// add goods transaction detail (log) after update invetory number
				
				//update Without checking warehouse				
				if($this->check_item_without_checking_warehouse($goods_delivery_detail_value['commodity_code']) == true){

					$this->add_inventory_manage($goods_delivery_detail_value, 2);
				}

			}

			return true;
			break;


			case '3':
		//update lost adjustment
			if($status == 1){
				$status = $this->change_adjust($rel_id);

				return $status;
				break;

			}else{
				$this->db->where('id', $rel_id);
				$this->db->update(db_prefix() . 'wh_loss_adjustment', [
					'status' => -1,
				]);

			}

			return false;
			break;

			case '4':
		//internal delivery note
			
			$data_update['approval'] = $status;
			$this->db->where('id', $rel_id);
			$this->db->update(db_prefix() . 'internal_delivery_note', $data_update);
			//log
			// history stock, inventoty manage after staff approved

			$internal_delivery_detail = $this->get_internal_delivery_detail($rel_id);

			foreach ($internal_delivery_detail as $internal_delivery_detail_value) {
				// add goods transaction detail (log) after update invetory number
				
				$this->approval_internal_delivery_detail($internal_delivery_detail_value);

			}


			return false;
			break;

			default:
			return false;
			break;
		}
	}

	/**
	 * stock import pdf
	 * @param  integer $purchase
	 * @return  pdf view
	 */
	function stock_import_pdf($purchase) {
		return app_pdf('purchase', module_dir_path(WAREHOUSE_MODULE_NAME, 'libraries/pdf/Purchase_pdf.php'), $purchase);
	}

	/**
	 * get stock import pdf_html
	 * @param  integer $goods_receipt_id
	 * @return html
	 */
	public function get_stock_import_pdf_html($goods_receipt_id) {
		$this->load->model('currencies_model');
		$base_currency = $this->currencies_model->get_base_currency();

		// get_goods_receipt
		$goods_receipt = $this->get_goods_receipt($goods_receipt_id);
		// get_goods_receipt_detail
		$goods_receipt_detail = $this->get_goods_receipt_detail($goods_receipt_id);
		$company_name = get_option('invoice_company_name');
		$address = get_option('invoice_company_address');

		$day = date('d', strtotime($goods_receipt->date_add));
		$month = date('m', strtotime($goods_receipt->date_add));
		$year = date('Y', strtotime($goods_receipt->date_add));

		$html = '';
		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left">'.pdf_logo_url().'</td>
		<td class="text_right_weight "><h3>' . mb_strtoupper(_l('receiving')) . '</h3></td>
		</tr>

		<tr>
		<td class="text_right">#'.$goods_receipt->goods_receipt_code.'</td>
		</tr>
		</tbody>
		</table>
		<br><br><br>
		';	

		//organization_info
		$organization_info = '<div  class="bill_to_color">';
		$organization_info .= format_organization_info();
		$organization_info .= '</div>';

		//get vendor infor


		if (get_status_modules_wh('purchase') && ($goods_receipt->supplier_code != '') && ($goods_receipt->supplier_code != 0) ){
			if($goods_receipt){
				if(is_numeric($goods_receipt->supplier_code)){
					$supplier_value = $this->clients_model->get($goods_receipt->supplier_code);
					if($supplier_value){
						$customer_name .= $supplier_value->company;

						$supplier_value->client = $supplier_value;
						$supplier_value->clientid = '';
					}
				}

			}

			// Bill to
			$bill_to = '<b>' . _l('supplier_name') . '</b>';
			$bill_to .= '<div class="bill_to_color">';
			if(isset($supplier_value)){
				$bill_to .= format_customer_info($supplier_value, 'invoice', 'billing');
			}else{
				$bill_to .= wh_get_vendor_company_name($goods_receipt->supplier_code);
			}
			$bill_to .= '</div>';

		}else{
			// Bill to
			$bill_to = '<b>' . _l('supplier_name') . '</b>';
			$bill_to .= '<div class="bill_to_color">';
			$bill_to .= $goods_receipt->supplier_name;
			$bill_to .= '</div>';
		}

		//invoice_data_date
		$invoice_date = '<br /><b>' . _l('invoice_data_date') . ' ' . _d($goods_receipt->date_add) . '</b><br />';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left">'.$organization_info.'</td>
		<td rowspan="2" width="50%" class="text_right">'.$bill_to.'</td>
		</tr>
		</tbody>
		</table>
		<br><br>
		<br><br>
		';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left"></td>
		<td rowspan="2" width="50%" class="text_right">'.$invoice_date.'</td>
		</tr>
		</tbody>
		</table>
		<br><br><br>
		<br><br><br>
		';

		$html .= '<table class="table">
		<tbody>

		<tr>
		<th class="thead-dark-ip">'. _l('_order').'</th>
		<th class="thead-dark-ip">' . _l('commodity_code') . '</th>
		<th class="thead-dark-ip">' . _l('warehouse_name') . '</th>
		<th class="thead-dark-ip">' . _l('unit_name') . '</th>
		<th class="thead-dark-ip">' . _l('quantity') . '</th>
		<th class="thead-dark-ip">' . _l('unit_price') . '</th>
		<th class="thead-dark-ip">' . _l('total_money') . '</th>
		<th class="thead-dark-ip">' . _l('tax_money') . '</th>
		<th class="thead-dark-ip">' . _l('lot_number') . '</th>
		<th class="thead-dark-ip">' . _l('expiry_date') . '</th>

		</tr>';
		foreach ($goods_receipt_detail as $receipt_key => $receipt_value) {

			$commodity_name = (isset($receipt_value) ? $receipt_value['commodity_name'] : '');
			$quantities = (isset($receipt_value) ? $receipt_value['quantities'] : '');
			$unit_price = (isset($receipt_value) ? $receipt_value['unit_price'] : '');
			$goods_money = (isset($receipt_value) ? $receipt_value['goods_money'] : '');

			$commodity_code = get_commodity_name($receipt_value['commodity_code']) != null ? get_commodity_name($receipt_value['commodity_code'])->commodity_code : ''; 

			$commodity_name = get_commodity_name($receipt_value['commodity_code']) != null ? get_commodity_name($receipt_value['commodity_code'])->description : '';

			$unit_name = get_unit_type($receipt_value['unit_id']) != null ? get_unit_type($receipt_value['unit_id'])->unit_name : '';

			$warehouse_code = get_warehouse_name($receipt_value['warehouse_id']) != null ? get_warehouse_name($receipt_value['warehouse_id'])->warehouse_name : '';

			$tax_money =(isset($receipt_value['tax_money']) ? $receipt_value['tax_money'] : '');
			$expiry_date =(isset($receipt_value['expiry_date']) ? $receipt_value['expiry_date'] : '');
			$lot_number =(isset($receipt_value['lot_number']) ? $receipt_value['lot_number'] : '');

			$key = $receipt_key+1;

			$html .= '<tr>';
			$html .= '<td class="td_style_r_ep_c"><b>' . $key . '</b></td>
			<td class="td_style_r_ep_c"><b>' . $commodity_code . '_'. $commodity_name.'</b></td>
			<td class="td_style_r_ep_c">' . $warehouse_code . '</td>
			<td class="td_style_r_ep_c">' . $unit_name . '</td>
			<td class="td_style_r_ep_c">' . $quantities . '</td>
			<td class="td_style_r_ep_c">' . app_format_money((float) $unit_price, '') . '</td>
			<td class="td_style_r_ep_c">' . app_format_money((float) $goods_money, '') . '</td>
			<td class="td_style_r_ep_c">' . app_format_money((float) $tax_money, '') . '</td>
			<td class="td_style_r_ep_c">' . $lot_number . '</td>
			<td class="td_style_r_ep_c">' . _d($expiry_date) . '</td>
			</tr>';
		}

		$html .= '</tbody>
		</table>
		<br/>
		';

		$html .=  '<h4>' . _l('note_') . ':</h4>
		<p>' . $goods_receipt->description . '</p>';


		$html .= '<table class="table">
		<tbody>
		<tr>
		<td ></td>
		<td ></td>
		<td ></td>
		<td class="text_left"><b>' . _l('total_goods_money') . '</b></td>
		<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_receipt->total_goods_money, '') . '</td>
		</tr>
		<tr>
		<td ></td>
		<td ></td>
		<td ></td>
		<td class="text_left"><b>' . _l('total_money') . '</b></td>
		<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_receipt->total_money, '') . '</td>
		</tr>
		<tr>
		<td ></td>
		<td ></td>
		<td ></td>
		<td class="text_left"><b>' . _l('total_tax_money') . '</b></td>
		<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_receipt->total_tax_money, '') . '</td>
		</tr>
		<tr>
		<td ></td>
		<td ></td>
		<td ></td>
		<td class="text_left"><b>' . _l('value_of_inventory') . '</b></td>
		<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_receipt->value_of_inventory, '') . '</td>
		</tr>
		
		</tbody>
		</table>
		<br><br><br>
		';


		$html .= '<br>
		<br>
		<br>
		<br>
		<table class="table">
		<tbody>
		<tr>';
		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';

		return $html;
	}

	/**
	 * send mail
	 * @param  array $data
	 * @return
	 */
	public function send_mail($data ,$staffid = ''){
		if($staffid == ''){
			$staff_id = $staffid;
		}else{
			$staff_id = get_staff_user_id();
		}

		$this->load->model('emails_model');
		if (!isset($data['status'])) {
			$data['status'] = '';
		}
		$get_staff_enter_charge_code = '';
		$mes = 'notify_send_request_approve_project';
		$staff_addedfrom = 0;
		$additional_data = $data['rel_type'];
		$object_type = $data['rel_type'];
		switch ($data['rel_type']) {
		// case '1 : stock_import':
			case '1':
			$type = _l('stock_import');
			$staff_addedfrom = $this->get_goods_receipt($data['rel_id'])->addedfrom;
			$list_approve_status = $this->get_list_approval_details($data['rel_id'], $data['rel_type']);
			$mes = 'notify_send_request_approve_stock_import';
			$mes_approve = 'notify_send_approve_stock_import';
			$mes_reject = 'notify_send_rejected_stock_import';
			$link = 'warehouse/edit_purchase/' . $data['rel_id'];
			break;
			case '2':
			$type = _l('stock_export');
			$staff_addedfrom = $this->get_goods_delivery($data['rel_id'])->addedfrom;
			$list_approve_status = $this->get_list_approval_details($data['rel_id'], $data['rel_type']);
			$mes = 'notify_send_request_approve_stock_export';
			$mes_approve = 'notify_send_approve_stock_export';
			$mes_reject = 'notify_send_rejected_stock_export';
			$link = 'warehouse/edit_delivery/' . $data['rel_id'];
			break;
			case '3':
			$type = _l('loss_adjustment');
			$staff_addedfrom = $this->get_loss_adjustment($data['rel_id'])->addfrom;
			$list_approve_status = $this->get_list_approval_details($data['rel_id'], $data['rel_type']);
			$mes = 'notify_send_request_approve_loss_adjustment';
			$mes_approve = 'notify_send_approve_loss_adjustment';
			$mes_reject = 'notify_send_rejected_loss_adjustment';
			$link = 'warehouse/view_lost_adjustment/' . $data['rel_id'];
			break;

			case '4':
			$type = _l('internal_delivery_note');
			$staff_addedfrom = $this->get_internal_delivery($data['rel_id'])->addedfrom;
			$list_approve_status = $this->get_list_approval_details($data['rel_id'], $data['rel_type']);
			$mes = 'notify_send_request_approve_internal_delivery_note';
			$mes_approve = 'notify_send_approve_internal_delivery_note';
			$mes_reject = 'notify_send_rejected_internal_delivery_note';
			$link = 'warehouse/manage_internal_delivery/' . $data['rel_id'];
			break;


			default:

			break;
		}

		$check_approve_status = $this->check_approval_details($data['rel_id'], $data['rel_type'], $data['status']);
		if (isset($check_approve_status['staffid'])) {

			$mail_template = 'send-request-approve';

			if (!in_array(get_staff_user_id(), $check_approve_status['staffid'])) {
				foreach ($check_approve_status['staffid'] as $value) {
					if($value != ''){
					$staff = $this->staff_model->get($value);

					if($staff){
						$notified = add_notification([
							'description' => $mes,
							'touserid' => $staff->staffid,
							'link' => $link,
							'additional_data' => serialize([
								$additional_data,
							]),
						]);
						if ($notified) {
							pusher_trigger_notification([$staff->staffid]);
						}

						//send mail
						
						$this->emails_model->send_simple_email($staff->email, _l('request_approval'), _l('email_send_request_approve', $type) .' <a href="'.admin_url($link).'">'.admin_url($link).'</a> '._l('from_staff', get_staff_full_name($staff_addedfrom)));
					}
				}

				}
			}
		}

		if (isset($data['approve'])) {
			if ($data['approve'] == 1) {
				$mes = $mes_approve;
				$mail_template = 'email_send_approve';
			} else {
				$mes = $mes_reject;
				$mail_template = 'email_send_rejected';
			}

			$staff = $this->staff_model->get($staff_addedfrom);
			$notified = add_notification([
				'description' => $mes,
				'touserid' => $staff->staffid,
				'link' => $link,
				'additional_data' => serialize([
					$additional_data,
				]),
			]);
			if ($notified) {
				pusher_trigger_notification([$staff->staffid]);
			}

			//send mail
			
			$this->emails_model->send_simple_email($staff->email, _l('approval_notification'), _l($mail_template, $type.' <a href="'.admin_url($link).'">'.admin_url($link).'</a> ').' '._l('by_staff', get_staff_full_name(get_staff_user_id())));


			foreach ($list_approve_status as $key => $value) {
				$value['staffid'] = explode(', ', $value['staffid']);
				if ($value['approve'] == 1 && !in_array(get_staff_user_id(), $value['staffid'])) {
					foreach ($value['staffid'] as $staffid) {

						$staff = $this->staff_model->get($staffid);
						$notified = add_notification([
							'description' => $mes,
							'touserid' => $staff->staffid,
							'link' => $link,
							'additional_data' => serialize([
								$additional_data,
							]),
						]);
						if ($notified) {
							pusher_trigger_notification([$staff->staffid]);
						}

						//send mail
						$this->emails_model->send_simple_email($staff->email, _l('approval_notification'), _l($mail_template, $type. ' <a href="'.admin_url($link).'">'.admin_url($link).'</a>').' '._l('by_staff', get_staff_full_name($staff_id)));


					}
				}
			}

		}
	}

	/**
	 * create goods delivery code
	 * @return string
	 */
	public function create_goods_delivery_code() {

		$goods_code = get_warehouse_option('inventory_delivery_number_prefix') . (get_warehouse_option('next_inventory_delivery_mumber'));
		
		return $goods_code;
	}

	/**
	 * add goods delivery
	 * @param array  $data
	 * @param boolean $id
	 * return boolean
	 */
	public function add_goods_delivery($data, $id = false) {

		$check_appr = $this->get_approve_setting('2');
		$data['approval'] = 0;
		if ($check_appr && $check_appr != false) {
			$data['approval'] = 0;
		} else {
			$data['approval'] = 1;
		}

		if(isset($data['edit_approval'])){
			unset($data['edit_approval']);
		}

		if(isset($data['save_and_send_request'])){
			$save_and_send_request = $data['save_and_send_request'];
			unset($data['save_and_send_request']);
		}

		if (isset($data['hot_purchase'])) {
			$hot_purchase = $data['hot_purchase'];
			unset($data['hot_purchase']);
		}
		$data['goods_delivery_code'] = $this->create_goods_delivery_code();

		if(!$this->check_format_date($data['date_c'])){
			$data['date_c'] = to_sql_date($data['date_c']);
		}else{
			$data['date_c'] = $data['date_c'];
		}


		if(!$this->check_format_date($data['date_add'])){
			$data['date_add'] = to_sql_date($data['date_add']);
		}else{
			$data['date_add'] = $data['date_add'];
		}

		$data['total_money'] 	= reformat_currency_j($data['total_money']);
		$data['total_discount'] = reformat_currency_j($data['total_discount']);
		$data['after_discount'] = reformat_currency_j($data['after_discount']);

		$data['addedfrom'] = get_staff_user_id();


		$this->db->insert(db_prefix() . 'goods_delivery', $data);
		$insert_id = $this->db->insert_id();

		/*update save note*/


		if(isset($hot_purchase)){
			$goods_delivery_detail = json_decode($hot_purchase);

			$es_detail = [];
			$row = [];
			$rq_val = [];
			$header = [];

			$header[] = 'commodity_code';
			$header[] = 'warehouse_id';
			$header[] = 'available_quantity';
			$header[] = 'unit_id';
			$header[] = 'quantities';
			$header[] = 'unit_price';
			$header[] = 'tax_id';
			$header[] = 'total_money';
			$header[] = 'discount';
			$header[] = 'discount_money';
			$header[] = 'total_after_discount';
			$header[] = 'guarantee_period';
			$header[] = 'note';



			foreach ($goods_delivery_detail as $key => $value) {

				if($value[0] != ''){

	                	//case choose warehouse from select 
					/*get available quantity for case choose warheouse from select*/
					if($data['warehouse_id'] != ''){
						$value[1] = $data['warehouse_id'];

						$available_quantity = $this->get_quantity_inventory($data['warehouse_id'], $value[0]);

						if($available_quantity){
							$value[2] = $available_quantity->inventory_number;
						}

					}



					/*check unit*/
					if($value[3] != ''){
						$value[3] = $value[3];

					}else{
						$value[3] = $this->get_unitid_from_commodity_id($value[0]);
					}

					/*check guarantee period*/
					if($value[11] != ''){
						if(!$this->check_format_date($value[11])){
							$value[11] = to_sql_date($value[11]);
						}else{
							$value[11] = $value[11];
						}
					}else{
						$get_warranty = $this->get_warranty_from_commodity_id($value[0]);

						if(!$this->check_format_date($get_warranty)){
							$value[11] = to_sql_date($get_warranty);
						}else{
							$value[11] = $get_warranty;
						}


					}


					$es_detail[] = array_combine($header, $value);

				}
			}
		}

		if (isset($insert_id)) {

			/*insert detail*/
			foreach($es_detail as $key => $rqd){

				$es_detail[$key]['goods_delivery_id'] = $insert_id;

			}

			$this->db->insert_batch(db_prefix().'goods_delivery_detail',$es_detail);

			/*write log*/
			$data_log = [];
			$data_log['rel_id'] = $insert_id;
			$data_log['rel_type'] = 'stock_export';
			$data_log['staffid'] = get_staff_user_id();
			$data_log['date'] = date('Y-m-d H:i:s');
			$data_log['note'] = "stock_export";

			$this->add_activity_log($data_log);

			/*update next number setting*/
			$this->update_inventory_setting(['next_inventory_delivery_mumber' =>  get_warehouse_option('next_inventory_delivery_mumber')+1]);

				//send request approval
			if($save_and_send_request == 'true'){
				/*check send request with type =2 , inventory delivery voucher*/
				$check_r = $this->check_inventory_delivery_voucher(['rel_id' => $insert_id, 'rel_type' => '2']);

				if($check_r['flag_export_warehouse'] == 1){
					$this->send_request_approve(['rel_id' => $insert_id, 'rel_type' => '2', 'addedfrom' => $data['addedfrom']]);

				}
			}


		}

		//approval if not approval setting
		if (isset($insert_id)) {
			if ($data['approval'] == 1) {
				$this->update_approve_request($insert_id, 2, 1);
			}
		}

		return $insert_id > 0 ? $insert_id : false;

	}

	/**
	 * commodity goods delivery change
	 * @param  boolean $id
	 * @return  array
	 */
	public function commodity_goods_delivery_change($id = false) {

		if (is_numeric($id)) {
			$commodity_value = $this->db->query('select description, rate, unit_id, taxrate, purchase_price, guarantee, '.db_prefix().'items.tax, ' . db_prefix() . 'taxes.name from ' . db_prefix() . 'items left join ' . db_prefix() . 'ware_unit_type on  ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id
				left join ' . db_prefix() . 'taxes on ' . db_prefix() . 'items.tax = ' . db_prefix() . 'taxes.id where ' . db_prefix() . 'items.id = ' . $id)->row();

			$warehouse_inventory = $this->db->query('SELECT ' . db_prefix() . 'warehouse.warehouse_id as id, CONCAT(' . db_prefix() . 'warehouse.warehouse_code," - ", ' . db_prefix() . 'warehouse.warehouse_name) as label FROM ' . db_prefix() . 'inventory_manage
				LEFT JOIN ' . db_prefix() . 'warehouse on ' . db_prefix() . 'inventory_manage.warehouse_id = ' . db_prefix() . 'warehouse.warehouse_id
				where ' . db_prefix() . 'inventory_manage.commodity_id = ' . $id)->result_array();

		}

		$guarantee_new = '';
		if($commodity_value){
			if(($commodity_value->guarantee != '') && (($commodity_value->guarantee != null)))
				$guarantee_new = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$commodity_value->guarantee.' months'));
		}

		$data['guarantee_new'] = $guarantee_new;
		$data['commodity_value'] = $commodity_value;
		$data['warehouse_inventory'] = $warehouse_inventory;
		return $data;
	}

	/**
	 * get goods delivery
	 * @param  integer $id
	 * @return array or object
	 */
	public function get_goods_delivery($id) {
		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'goods_delivery')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblgoods_delivery')->result_array();
		}
	}

	/**
	 * get goods delivery detail
	 * @param  integer $id
	 * @return array
	 */
	public function get_goods_delivery_detail($id) {
		if (is_numeric($id)) {
			$this->db->where('goods_delivery_id', $id);

			return $this->db->get(db_prefix() . 'goods_delivery_detail')->result_array();
		}
		if ($id == false) {
			return $this->db->query('select * from tblgoods_delivery_detail')->result_array();
		}
	}

	/**
	 * get vendor
	 * @param  string $id
	 * @param  array  $where
	 * @return array or object
	 */
	public function get_vendor($id = '', $where = []) {
		$this->db->select(implode(',', prefixed_table_fields_array(db_prefix() . 'pur_vendor')) . ',' . get_sql_select_vendor_company());

		$this->db->join(db_prefix() . 'countries', '' . db_prefix() . 'countries.country_id = ' . db_prefix() . 'pur_vendor.country', 'left');
		$this->db->join(db_prefix() . 'pur_contacts', '' . db_prefix() . 'pur_contacts.userid = ' . db_prefix() . 'pur_vendor.userid AND is_primary = 1', 'left');

		if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
			$this->db->where($where);
		}

		if (is_numeric($id)) {

			$this->db->where(db_prefix() . 'pur_vendor.userid', $id);
			$vendor = $this->db->get(db_prefix() . 'pur_vendor')->row();

			if ($vendor && get_option('company_requires_vat_number_field') == 0) {
				$vendor->vat = null;
			}

			return $vendor;

		}

		$this->db->order_by('company', 'asc');

		return $this->db->get(db_prefix() . 'pur_vendor')->result_array();
	}

	/**
	 * get vendor ajax
	 * @param  integer $pur_orders_id
	 * @return object
	 */
	public function get_vendor_ajax($pur_orders_id) {
		$data = [];
		$sql = 'SELECT *, ' . db_prefix() . 'pur_orders.project, ' . db_prefix() . 'pur_orders.type, ' . db_prefix() . 'pur_orders.department, ' . db_prefix() . 'pur_request.requester FROM ' . db_prefix() . 'pur_vendor
		left join ' . db_prefix() . 'pur_orders on ' . db_prefix() . 'pur_vendor.userid = ' . db_prefix() . 'pur_orders.vendor
		left join ' . db_prefix() . 'pur_request on ' . db_prefix() . 'pur_orders.pur_request = ' . db_prefix() . 'pur_request.id
		where ' . db_prefix() . 'pur_orders.id = ' . $pur_orders_id;
		$result_array = $this->db->query($sql)->row();



		$data['id'] 		= $result_array->userid;
		$data['buyer'] 		= $result_array->buyer;
		$data['project'] 	= '';
		$data['type']      	= '';
		$data['department'] = '';
		$data['requester'] 	= '';

		if (get_status_modules_wh('purchase')) {
			if(isset($result_array->project)){
				$data['project'] 	.= $result_array->project;
			}
			if(isset($result_array->type)){
				$data['type']      	.= $result_array->type;
			}
			
			if(isset($result_array->department)){
				$data['department'] .= $result_array->department;
			}
			
			if(isset($result_array->requester)){
				$data['requester'] 	.= $result_array->requester;
			}
			
		}

		return $data;

	}

	/**
	 * stock export pdf
	 * @param  integer $delivery
	 * @return pdf view
	 */
	public function stock_export_pdf($delivery) {
		return app_pdf('delivery', module_dir_path(WAREHOUSE_MODULE_NAME, 'libraries/pdf/Delivery_pdf.php'), $delivery);
	}


	/**
	 * get stock export pdf_html
	 * @param  integer $goods_delivery_id
	 * @return string
	 */
	public function get_stock_export_pdf_html($goods_delivery_id) {
		$this->load->model('currencies_model');
		$base_currency = $this->currencies_model->get_base_currency();
		// get_goods_receipt
		$goods_delivery = $this->get_goods_delivery($goods_delivery_id);
		// get_goods_receipt_detail
		$goods_delivery_detail = $this->get_goods_delivery_detail($goods_delivery_id);
		$company_name = get_option('invoice_company_name');
		$address = get_option('invoice_company_address');

		$day = date('d', strtotime($goods_delivery->date_add));
		$month = date('m', strtotime($goods_delivery->date_add));
		$year = date('Y', strtotime($goods_delivery->date_add));

		$customer_name='';
		if($goods_delivery){
			if(is_numeric($goods_delivery->customer_code)){
				$customer_value = $this->clients_model->get($goods_delivery->customer_code);
				if($customer_value){
					$customer_name .= $customer_value->company;

					$customer_value->client = $customer_value;
					$customer_value->clientid = $customer_value->userid;
				}
			}


		}



		$html = '';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left">'.pdf_logo_url().'</td>
		<td class="text_right_weight "><h3>' . mb_strtoupper(_l('delivery')) . '</h3></td>
		</tr>

		<tr>
		<td class="text_right">#'.$goods_delivery->goods_delivery_code.'</td>
		</tr>
		</tbody>
		</table>
		<br><br><br>
		';

	     //organization_info
		$organization_info = '<div  class="bill_to_color">';
		$organization_info .= format_organization_info();
		$organization_info .= '</div>';

		$bill_to ='';
		$ship_to ='';
		if(isset($customer_value)){
			// Bill to
			$bill_to .= '<b>' . _l('Bill to') . '</b>';
			$bill_to .= '<div class="bill_to_color">';
			$bill_to .= format_customer_info($customer_value, 'invoice', 'billing');
			$bill_to .= '</div>';

			// ship to to
			$ship_to .= '<br /><b>' . _l('ship_to') . '</b>';
			$ship_to .= '<div  class="bill_to_color">';
			$ship_to .= format_customer_info($customer_value, 'invoice', 'shipping');
			$ship_to .= '</div>';
		}

	    //invoice_data_date
		$invoice_date = '<br /><b>' . _l('invoice_data_date') . ' ' . _d($goods_delivery->date_add) . '</b><br />';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left">'.$organization_info.'</td>
		<td rowspan="2" width="50%" class="text_right">'.$bill_to.'</td>
		</tr>
		</tbody>
		</table>
		<br><br>
		<br><br>
		';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left"></td>
		<td rowspan="2" width="50%" class="text_right">'.$ship_to.'</td>
		</tr>
		</tbody>
		</table>
		<br>
		';
		
		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left"></td>
		<td rowspan="2" width="50%" class="text_right">'.$invoice_date.'</td>
		</tr>
		</tbody>
		</table>
		<br><br><br>
		<br><br><br>
		';



		$html .= '<table class="table">
		<tbody>

		<tr>
		<th class=" thead-dark"><b>#</b></th>
		<th  class=" thead-dark">' ._l('commodity_name').'</th>
		<th  class=" thead-dark">' . _l('quantity') . '</th>
		<th  class=" thead-dark">' . _l('delivered') . '</th>
		<th  class=" thead-dark">' . _l('outstanding') . '</th>
		<th  class=" thead-dark">' . _l('unit_price') . '</th>
		<th  class=" thead-dark">' . _l('subtotal') . '</th>
		<th  class=" thead-dark">' . _l('total_money') . '</th>

		</tr>';
		foreach ($goods_delivery_detail as $delivery_key => $delivery_value) {

			$item_order = $delivery_key +1;

			$commodity_name = get_commodity_name($delivery_value['commodity_code']) != null ? get_commodity_name($delivery_value['commodity_code'])->description : '';

			$quantities = (isset($delivery_value) ? $delivery_value['quantities'] : '');
			$unit_price = (isset($delivery_value) ? $delivery_value['unit_price'] : '');

			$commodity_code = get_commodity_name($delivery_value['commodity_code']) != null ? get_commodity_name($delivery_value['commodity_code'])->commodity_code : '';

			$total_money = (isset($delivery_value) ? $delivery_value['total_money'] : '');
			$discount = (isset($delivery_value) ? $delivery_value['discount'] : '');
			$discount_money = (isset($delivery_value) ? $delivery_value['discount_money'] : '');
			$guarantee_period = (isset($delivery_value) ? _d($delivery_value['guarantee_period']) : '');

			$total_after_discount = (isset($delivery_value) ? $delivery_value['total_after_discount'] : '');


			$warehouse_name ='';

			if(isset($delivery_value['warehouse_id']) && ($delivery_value['warehouse_id'] !='')){
				$arr_warehouse = explode(',', $delivery_value['warehouse_id']);

				$str = '';
				if(count($arr_warehouse) > 0){

					foreach ($arr_warehouse as $wh_key => $warehouseid) {
						$str = '';
						if ($warehouseid != '' && $warehouseid != '0') {

							$team = get_warehouse_name($warehouseid);
							if($team){
								$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide">, </span></span>';

								$warehouse_name .= $str;
								if($wh_key%3 ==0){
									$warehouse_name .='<br/>';
								}
							}

						}
					}

				} else {
					$warehouse_name = '';
				}
			}


			$unit_name = '';
			if(isset($delivery_value['unit_id']) && ($delivery_value['unit_id'] !='')){
				$unit_name = get_unit_type($delivery_value['unit_id']) != null ? get_unit_type($delivery_value['unit_id'])->unit_name : '';
			}

			$lot_number ='';
			if(($delivery_value['lot_number'] != null) && ( $delivery_value['lot_number'] != '') ){
				$array_lot_number = explode(',', $delivery_value['lot_number']);
				foreach ($array_lot_number as $key => $lot_value) {

					if($key%2 ==0){
						$lot_number .= $lot_value;
					}else{
						$lot_number .= ' : '.$lot_value.' ';
					}

				}
			}

			$html .= '<tr>';
			$html .= '<td class=""><b>' . (float)$item_order . '</b></td>
			<td class="td_style_r_ep_c"><b>' . $commodity_code .'#'.$commodity_name . '</b></td>
			<td class="td_style_r_ep_c"><b>' . $quantities .' '.$unit_name. '</b></td>
			<td class="td_style_r_ep_c"><b>' . $quantities .' '.$unit_name. '</b></td>
			<td class="td_style_r_ep"><b>0.0</b></td>';

			if(get_warehouse_option('goods_delivery_pdf_display') == 1){
				$html .= ' <td class="td_style_r_ep"><b>' . app_format_money((float) $unit_price, '') . '</b></td>
				<td class="td_style_r_ep"><b>' . app_format_money((float) $total_money, '') . '</b></td>
				<td class="td_style_r_ep"><b>' . app_format_money((float) $total_after_discount, '') . '</b></td>';

			}else{
				$html .= '<td class="td_style_r_ep"><b></b></td>
				<td class="td_style_r_ep"><b></b></td>
				<td class="td_style_r_ep"><b></b></td>';

			}

			$html .= '</tr>';
		}

		$html .= '</tbody>';
		$html .= '</table>
		<br>
		<br>';

		if(get_warehouse_option('goods_delivery_pdf_display') == 1){

			$html .= '<table class="table">
			<tbody>
			<tr>
			<td ></td>
			<td ></td>
			<td ></td>
			<td class="text_left"><b>' . _l('subtotal') . '</b></td>
			<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_delivery->total_money, '') . '</td>
			</tr>
			<tr>
			<td ></td>
			<td ></td>
			<td ></td>
			<td class="text_left"><b>' . _l('total_discount') . '</b></td>
			<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_delivery->total_discount, '') . '</td>
			</tr>
			<tr>
			<td ></td>
			<td ></td>
			<td ></td>
			<td class="text_left"><b>' . _l('total_money') . '</b></td>
			<td class="text_right">' .$base_currency->symbol. app_format_money((float) $goods_delivery->after_discount, '') . '</td>
			</tr>
			</tbody>
			</table>
			<br><br><br>
			';
		}else{
			$html .= '<table class="table">
			<tbody>
			<tr>
			<td ></td>
			<td ></td>
			<td ></td>
			<td class="text_left"><b>' . _l('subtotal') . '</b></td>
			<td class="text_right">......................................</td>
			</tr>
			<tr>
			<td ></td>
			<td ></td>
			<td ></td>
			<td class="text_left"><b>' . _l('total_discount') . '</b></td>
			<td class="text_right">......................................</td>
			</tr>
			<tr>
			<td ></td>
			<td ></td>
			<td ></td>
			<td class="text_left"><b>' . _l('total_money') . '</b></td>
			<td class="text_right">......................................</td>
			</tr>
			
			</tbody>
			</table>
			<br><br><br>
			';
		}


		$html .= '

		<br>
		<br>
		<br>
		<br>
		<table class="table">
		<tbody>
		<tr>';



		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';
		return $html;
	}

	//stock summary report for pdf
	/**
	 * get stock summary report
	 * @param  array $data
	 * @return string
	 */
	public function get_stock_summary_report($data) {
		$from_date = $data['from_date'];
		$to_date = $data['to_date'];



		if(!$this->check_format_date($from_date)){
			$from_date = to_sql_date($from_date);
		}
		if(!$this->check_format_date($to_date)){
			$to_date = to_sql_date($to_date);
		}

		$where_warehouse_id = '';

		$where_warehouse_id_with_internal_i = '';
		$where_warehouse_id_with_internal_e = '';

		if (isset($data['warehouse_filter']) && count($data['warehouse_filter']) > 0) {
			$arr_warehouse_id =  $data['warehouse_filter'];

			foreach ($arr_warehouse_id as $warehouse_id) {
				if ($warehouse_id != '') {

					if ($where_warehouse_id == '') {
						$where_warehouse_id .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';

						$where_warehouse_id_with_internal_i .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name)';

						$where_warehouse_id_with_internal_e .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';

					} else {
						$where_warehouse_id .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';

						$where_warehouse_id_with_internal_i .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) ';

						$where_warehouse_id_with_internal_e .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name) ';

					}

				}
			}


			if ($where_warehouse_id != '') {
				$where_warehouse_id .= ')';

				$where_warehouse_id_with_internal_i .= ')';
				$where_warehouse_id_with_internal_e .= ')';
			}
		}


		$where_commodity_id = '';
		if (isset($data['commodity_filter']) && count($data['commodity_filter']) > 0) {
			$arr_commodity_id = $data['commodity_filter'];

			foreach ($arr_commodity_id as $commodity_id) {
				if ($commodity_id != '') {

					if ($where_commodity_id == '') {
						$where_commodity_id .= ' (find_in_set('.$commodity_id.', '.db_prefix().'goods_transaction_detail.commodity_id) ';
					} else {
						$where_commodity_id .= ' or find_in_set('.$commodity_id.', '.db_prefix().'goods_transaction_detail.commodity_id) ';
					}

				}
			}

			if ($where_commodity_id != '') {
				$where_commodity_id .= ')';
			}
		}

		if($where_commodity_id != ''){
			if($where_warehouse_id != ''){
				$where_warehouse_id .= ' AND '.$where_commodity_id;

				$where_warehouse_id_with_internal_i .= ' AND '.$where_commodity_id;
				$where_warehouse_id_with_internal_e .= ' AND '.$where_commodity_id;
			}else{
				$where_warehouse_id .= $where_commodity_id;

				$where_warehouse_id_with_internal_i .= $where_commodity_id;
				$where_warehouse_id_with_internal_e .= $where_commodity_id;
			}

		}

		//get_commodity_list in warehouse
		if (strlen($where_warehouse_id) > 0) {
			$commodity_lists = $this->db->query('SELECT commodity_id, ' . db_prefix() . 'items.commodity_code, ' . db_prefix() . 'items.rate, ' . db_prefix() . 'items.description as commodity_name, ' . db_prefix() . 'ware_unit_type.unit_name FROM ' . db_prefix() . 'goods_transaction_detail
				LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'goods_transaction_detail.commodity_id = ' . db_prefix() . 'items.id
				LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id  where 1=1 AND '.$where_warehouse_id  .' AND '.db_prefix().'items.active = 1 group by commodity_id')->result_array();

		}else{

			$commodity_lists = $this->db->query('SELECT commodity_id, ' . db_prefix() . 'items.commodity_code, ' . db_prefix() . 'items.rate, ' . db_prefix() . 'items.description as commodity_name, ' . db_prefix() . 'ware_unit_type.unit_name FROM ' . db_prefix() . 'goods_transaction_detail
				LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'goods_transaction_detail.commodity_id = ' . db_prefix() . 'items.id
				LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id where '.db_prefix().'items.active = 1 group by commodity_id')->result_array();
		}
		//import_openings
		//
		if (strlen($where_warehouse_id) > 0) {
			$import_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" AND '.$where_warehouse_id_with_internal_i)->result_array();

		}else{

			$import_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" ')->result_array();
		}


		$arr_import_openings = [];
		$arr_import_openings_amount = [];
		foreach ($import_openings as $import_opening_key => $import_opening_value) {
			if(isset($arr_import_openings[$import_opening_value['commodity_id']])){

				switch ($import_opening_value['status']) {
					case '1':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] += (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   += (float)$import_opening_value['quantity'];
					break;
					case '3':
					if(((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']) > 0){

						$arr_import_openings_amount[$import_opening_value['commodity_id']] += ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity'])*(float)$import_opening_value['purchase_price'];
						$arr_import_openings[$import_opening_value['commodity_id']] 	   += ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] += (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   += (float)$import_opening_value['quantity'];

					break;
					
				}


			}else{
				switch ($import_opening_value['status']) {
					case '1':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] = (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   = (float)$import_opening_value['quantity'];
					break;
					case '3':
					if(((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']) > 0){

						$arr_import_openings_amount[$import_opening_value['commodity_id']] = ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity'])*(float)$import_opening_value['purchase_price'];
						$arr_import_openings[$import_opening_value['commodity_id']] 	   = ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] = (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   = (float)$import_opening_value['quantity'];

					break;
					
				}

			}
		}


		//export_openings
		if (strlen($where_warehouse_id) > 0) {
			$export_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" AND '.$where_warehouse_id_with_internal_e)->result_array();

		}else{

			$export_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" ')->result_array();
		}

		$arr_export_openings = [];
		$arr_export_openings_amount = [];
		foreach ($export_openings as $export_opening_key => $export_opening_value) {
			//get purchase price of item, before version get sales price.
			// $purchase_price = $export_opening_value['price']
			
			$purchase_price = $this->get_purchase_price_from_commodity_id($export_opening_value['commodity_id']);

			if(isset($arr_export_openings[$export_opening_value['commodity_id']])){
				switch ($export_opening_value['status']) {
					case '2':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] += (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   += (float)$export_opening_value['quantity'];
					break;
					case '3':
					if(((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']) < 0){

						$arr_export_openings_amount[$export_opening_value['commodity_id']] += abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity'])*(float)$purchase_price;
						$arr_export_openings[$export_opening_value['commodity_id']] 	   += abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] += (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   += (float)$export_opening_value['quantity'];

					break;
					
				}

				
			}else{
				switch ($export_opening_value['status']) {
					case '2':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] = (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   = (float)$export_opening_value['quantity'];
					break;
					case '3':
					if(((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']) < 0){

						$arr_export_openings_amount[$export_opening_value['commodity_id']] = abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity'])*(float)$purchase_price;
						$arr_export_openings[$export_opening_value['commodity_id']] 	   = abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] = (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   = (float)$export_opening_value['quantity'];

					break;
					
				}
			}
		}

		//import_periods
		if (strlen($where_warehouse_id) > 0) {
			$import_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3 ) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" AND '.$where_warehouse_id_with_internal_i)->result_array();

		}else{

			$import_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" ')->result_array();
		}

		$arr_import_periods = [];
		$arr_import_periods_amount = [];
		foreach ($import_periods as $import_period_key => $import_period_value) {
			if(isset($arr_import_periods[$import_period_value['commodity_id']])){

				switch ($import_period_value['status']) {
					case '1':
					$arr_import_periods_amount[$import_period_value['commodity_id']] += (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   += (float)$import_period_value['quantity'];
					break;
					case '3':
					if(((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']) > 0){

						$arr_import_periods_amount[$import_period_value['commodity_id']] += ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity'])*(float)$import_period_value['purchase_price'];
						$arr_import_periods[$import_period_value['commodity_id']] 	   += ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_periods_amount[$import_period_value['commodity_id']] += (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   += (float)$import_period_value['quantity'];

					break;
					
				}


			}else{

				switch ($import_period_value['status']) {
					case '1':
					$arr_import_periods_amount[$import_period_value['commodity_id']] = (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   = (float)$import_period_value['quantity'];
					break;
					case '3':
					if(((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']) > 0){

						$arr_import_periods_amount[$import_period_value['commodity_id']] = ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity'])*(float)$import_period_value['purchase_price'];
						$arr_import_periods[$import_period_value['commodity_id']] 	   = ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_periods_amount[$import_period_value['commodity_id']] = (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   = (float)$import_period_value['quantity'];

					break;
					
				}

			}
		}
		

		//export_periods
		if (strlen($where_warehouse_id) > 0) {
			$export_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" AND'.$where_warehouse_id_with_internal_e)->result_array();

		}else{

			$export_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" ')->result_array();
		}

		$arr_export_periods = [];
		$arr_export_periods_amount = [];
		foreach ($export_periods as $export_period_key => $export_period_value) {
			//get purchase price of item, before version get sales price.
			// $purchase_price = $export_opening_value['price']
			
			$purchase_price = $this->get_purchase_price_from_commodity_id($export_period_value['commodity_id']);

			if(isset($arr_export_periods[$export_period_value['commodity_id']])){


				switch ($export_period_value['status']) {
					case '2':
					$arr_export_periods_amount[$export_period_value['commodity_id']] += (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   += (float)$export_period_value['quantity'];
					break;
					case '3':
					if(((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']) < 0){

						$arr_export_periods_amount[$export_period_value['commodity_id']] += abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity'])*(float)$purchase_price;
						$arr_export_periods[$export_period_value['commodity_id']] 	   += abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_periods_amount[$export_period_value['commodity_id']] += (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   += (float)$export_period_value['quantity'];

					break;
					
				}

				
			}else{
				switch ($export_period_value['status']) {
					case '2':
					$arr_export_periods_amount[$export_period_value['commodity_id']] = (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   = (float)$export_period_value['quantity'];
					break;
					case '3':
					if(((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']) < 0){

						$arr_export_periods_amount[$export_period_value['commodity_id']] = abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity'])*(float)$purchase_price;
						$arr_export_periods[$export_period_value['commodity_id']] 	   = abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_periods_amount[$export_period_value['commodity_id']] = (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   = (float)$export_period_value['quantity'];

					break;
					
				}

			}
		}

		//html for page
		$html = '';
		$html .= ' <p><h3 class="bold align_cen">' . mb_strtoupper(_l('stock_summary_report')) . '</h3></p>
		<br>
		<div class="col-md-12 pull-right">
		<div class="row">
		<div class="col-md-12 align_cen">
		<p>' . _l('from_date') . ' :  <span class="fstyle">' . _l('days') . '  ' . date('d', strtotime($from_date)) . '  ' . _l('month') . '  ' . date('m', strtotime($from_date)) . '  ' . _l('year') . '  ' . date('Y', strtotime($from_date)) . '  ' . '</p>
		<p>' . _l('to_date') . ' :  <span class="fstyle">' . _l('days') . '  ' . date('d', strtotime($to_date)) . '  ' . _l('month') . '  ' . date('m', strtotime($to_date)) . '  ' . _l('year') . '  ' . date('Y', strtotime($to_date)) . '  ' . '</p>
		</div>
		</div>
		</div>

		<table class="table">';
		$company_name = get_option('invoice_company_name');
		$address = get_option('invoice_company_address');
		$total_opening_quatity = 0;
		$total_opening_amount = 0;
		$total_import_period_quatity = 0;
		$total_import_period_amount = 0;
		$total_export_period_quatity = 0;
		$total_export_period_amount = 0;
		$total_closing_quatity = 0;
		$total_closing_amount = 0;

		$html .= '<tbody>
		<tr>
		<td class="bold width21">' . _l('company_name') . '</td>
		<td>' . $company_name . '</td>
		</tr>
		<tr>
		<td class="bold">' . _l('address') . '</td>
		<td>' . $address . '</td>
		</tr>
		</tbody>
		</table>
		<div class="col-md-12">
		<table class="table table-bordered">
		<tbody>
		<tr>
		<th colspan="1" class="th_style_stk">'._l('_order').'</th>
		<th  colspan="1" class="th_stk10">' . _l('commodity_code') . '</th>
		<th  colspan="1" class="th_stk10">' . _l('commodity_name') . '</th>
		<th  colspan="1" class="th_stk7">' . _l('unit_name') . '</th>
		<th  colspan="2" class="th_stk17">' . _l('opening_stock') . '</th>
		<th  colspan="2" class="th_stk17">' . _l('receipt_in_period') . '</th>
		<th  colspan="2" class="th_stk17">' . _l('issue_in_period') . '</th>
		<th  colspan="2" class="th_r_stk17">' . _l('closing_stock') . '</th>
		</tr>
		<tr>
		<th class="td_w5"></th>
		<th class="td_w10"></th>
		<th class="td_w10"></th>
		<th class="td_stk_w7"></th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th  class="td_stkw12">' . _l('Amount_') . '</th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th  class="td_stkw12">' . _l('Amount_') . '</th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th class="td_stkw12">' . _l('Amount_') . '</th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th class="td_stkw12s">' . _l('Amount_') . '</th>
		</tr>';
		foreach ($commodity_lists as $commodity_list_key => $commodity_list) {
			//get purchase price of item, before version get sales price.
						
			$purchase_price = $this->get_purchase_price_from_commodity_id($commodity_list['commodity_id']);

			$html .= '<tr>
			<td class="border_td">' . $commodity_list_key . '</td>
			<td class="border_td">' . $commodity_list['commodity_code'] . '</td>
			<td class="border_td">' . $commodity_list['commodity_name'] . '</td>
			<td class="border_td">' . $commodity_list['unit_name'] . '</td>';
			//import opening
			$stock_opening_quatity = 0;
			$stock_opening_amount = 0;

			$import_opening_quantity = isset($arr_import_openings[$commodity_list['commodity_id']]) ? $arr_import_openings[$commodity_list['commodity_id']] : 0;

			$export_opening_quantity = isset($arr_export_openings[$commodity_list['commodity_id']]) ? $arr_export_openings[$commodity_list['commodity_id']] : 0;

			$import_opening_amount = isset($arr_import_openings_amount[$commodity_list['commodity_id']]) ? $arr_import_openings_amount[$commodity_list['commodity_id']] : 0;

			$export_opening_amount = isset($arr_export_openings_amount[$commodity_list['commodity_id']]) ? $arr_export_openings_amount[$commodity_list['commodity_id']] : 0;
			

			$stock_opening_quatity = (float)$import_opening_quantity - (float)$export_opening_quantity;
			$stock_opening_amount = (float)$import_opening_amount - (float)$export_opening_amount;

			$total_opening_quatity += $stock_opening_quatity;
			$total_opening_amount += $stock_opening_amount;

			//import period
			$import_period_quatity = 0;
			$import_period_amount = 0;

			$import_period_quantity = isset($arr_import_periods[$commodity_list['commodity_id']]) ? $arr_import_periods[$commodity_list['commodity_id']] : 0;

			$import_period_quatity = $import_period_quantity;
			$import_period_amount = isset($arr_import_periods_amount[$commodity_list['commodity_id']]) ? $arr_import_periods_amount[$commodity_list['commodity_id']] : 0;

			$total_import_period_quatity += $import_period_quatity;
			$total_import_period_amount += $import_period_amount;

			//export period
			$export_period_quatity = 0;
			$export_period_amount = 0;

			$export_period_quantity = isset($arr_export_periods[$commodity_list['commodity_id']]) ? $arr_export_periods[$commodity_list['commodity_id']] : 0;

			$export_period_quatity = $export_period_quantity;
			$export_period_amount = isset($arr_export_periods_amount[$commodity_list['commodity_id']]) ? $arr_export_periods_amount[$commodity_list['commodity_id']] : 0;

			$total_export_period_quatity += $export_period_quatity;
			$total_export_period_amount += $export_period_amount;

			//closing
			$closing_quatity = 0;
			$closing_amount = 0;
			$closing_quatity = $stock_opening_quatity + $import_period_quatity - $export_period_quatity;
			// before get from fomular: $closing_amount = ($stock_opening_amount + $import_period_amount - $export_period_amount) after change below
			
			$closing_amount = $closing_quatity*(float)$purchase_price;

			$total_closing_quatity += $closing_quatity;
			$total_closing_amount += $closing_amount;

			$html .= '<td class="bor_alir">' . $stock_opening_quatity . '</td>
			<td class="bor_alir">' . app_format_money((float) $stock_opening_amount, '') . '</td>
			<td class="bor_alir">' . $import_period_quatity . '</td>
			<td class="bor_alir">' . app_format_money((float) $import_period_amount, '') . '</td>
			<td class="bor_alir">' . $export_period_quatity . '</td>
			<td class="bor_alir">' . app_format_money((float) $export_period_amount, '') . '</td>
			<td class="bor_alir">' . $closing_quatity . '</td>
			<td class="bor_r">' . app_format_money((float) $closing_amount, '') . '</td>
			</tr>';
		}
		$html .= '<tr>
		<th  colspan="4" class="th_stk_style">' . _l('total') . ' : </th>
		<th  colspan="1" class="th_stk_style">' . $total_opening_quatity . '</th>
		<th  colspan="1" class="th_stk_style">' . app_format_money((float) $total_opening_amount, '') . '</th>
		<th  colspan="1" class="th_stk_style">' . $total_import_period_quatity . '</th>
		<th  colspan="1" class="th_stk_style">' . app_format_money((float) $total_import_period_amount, '') . '</th>
		<th  colspan="1" class="th_stk_style">' . $total_export_period_quatity . '</th>
		<th  colspan="1" class="th_stk_style">' . app_format_money((float) $total_export_period_amount, '') . '</th>
		<th  colspan="1" class="th_stk_style">' . $total_closing_quatity . '</th>
		<th  colspan="1" class="th_st_spe">' . app_format_money((float) $total_closing_amount, '') . '</th>
		</tr>
		</tbody>
		</table>
		</div>';

		$html .= ' 
		<br>
		<br>';

		$html .= '
		<br>
		<br>
		<br>
		<br>';

		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';
		return $html;

	}

	/**
	 * stock summary report pdf
	 * @param  string $stock_report
	 * @return pdf view
	 */
	function stock_summary_report_pdf($stock_report) {
		return app_pdf('stock_summary_report', module_dir_path(WAREHOUSE_MODULE_NAME, 'libraries/pdf/Stock_summary_report_pdf.php'), $stock_report);
	}

	//get stock summary report for view
	/**
	 * get stock summary report view
	 * @param  array $data
	 * @return string
	 */
	public function get_stock_summary_report_view($data) {

		$from_date = $data['from_date'];
		$to_date = $data['to_date'];

		if(!$this->check_format_date($from_date)){
			$from_date = to_sql_date($from_date);
		}
		if(!$this->check_format_date($to_date)){
			$to_date = to_sql_date($to_date);
		}

		$where_warehouse_id = '';

		$where_warehouse_id_with_internal_i = '';
		$where_warehouse_id_with_internal_e = '';
		if (strlen($data['warehouse_id']) > 0) {
			$arr_warehouse_id =  explode(',', $data['warehouse_id']);

			foreach ($arr_warehouse_id as $warehouse_id) {
				if ($warehouse_id != '') {

					if ($where_warehouse_id == '') {
						$where_warehouse_id .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';

						$where_warehouse_id_with_internal_i .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name)';

						$where_warehouse_id_with_internal_e .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';
						


					} else {
						$where_warehouse_id .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';

						$where_warehouse_id_with_internal_i .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) ';

						$where_warehouse_id_with_internal_e .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name) ';
						
					}

				}
			}

			if ($where_warehouse_id != '') {
				$where_warehouse_id .= ')';

				$where_warehouse_id_with_internal_i .= ')';
				$where_warehouse_id_with_internal_e .= ')';
			}
		}

		$where_commodity_id = '';
		if (strlen($data['commodity_id']) > 0) {
			$arr_commodity_id =  explode(',', $data['commodity_id']);

			foreach ($arr_commodity_id as $commodity_id) {
				if ($commodity_id != '') {

					if ($where_commodity_id == '') {
						$where_commodity_id .= ' (find_in_set('.$commodity_id.', '.db_prefix().'goods_transaction_detail.commodity_id) ';
					} else {
						$where_commodity_id .= ' or find_in_set('.$commodity_id.', '.db_prefix().'goods_transaction_detail.commodity_id) ';
					}

				}
			}

			if ($where_commodity_id != '') {
				$where_commodity_id .= ')';
			}
		}

		if($where_commodity_id != ''){
			if($where_warehouse_id != ''){
				$where_warehouse_id .= ' AND '.$where_commodity_id;

				$where_warehouse_id_with_internal_i .= ' AND '.$where_commodity_id;
				$where_warehouse_id_with_internal_e .= ' AND '.$where_commodity_id;
			}else{
				$where_warehouse_id .= $where_commodity_id;

				$where_warehouse_id_with_internal_i .= $where_commodity_id;
				$where_warehouse_id_with_internal_e .= $where_commodity_id;
			}

		}



		//get_commodity_list in warehouse
		if (strlen($where_warehouse_id) > 0) {
			$commodity_lists = $this->db->query('SELECT commodity_id, ' . db_prefix() . 'items.commodity_code, ' . db_prefix() . 'items.rate, ' . db_prefix() . 'items.description as commodity_name, ' . db_prefix() . 'ware_unit_type.unit_name FROM ' . db_prefix() . 'goods_transaction_detail
				LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'goods_transaction_detail.commodity_id = ' . db_prefix() . 'items.id
				LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id where 1=1 AND  '.$where_warehouse_id. ' AND '.db_prefix().'items.active = 1 group by commodity_id')->result_array();

		}else{

			$commodity_lists = $this->db->query('SELECT commodity_id, ' . db_prefix() . 'items.commodity_code, ' . db_prefix() . 'items.rate, ' . db_prefix() . 'items.description as commodity_name, ' . db_prefix() . 'ware_unit_type.unit_name FROM ' . db_prefix() . 'goods_transaction_detail
				LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'goods_transaction_detail.commodity_id = ' . db_prefix() . 'items.id
				LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id where '.db_prefix().'items.active = 1 group by commodity_id')->result_array();
		}

		//import_openings
		// status = 1 inventory receipt voucher, status = 4 internal delivery voucher
		if (strlen($where_warehouse_id) > 0) {
			$import_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" AND '. $where_warehouse_id_with_internal_i)->result_array();

		}else{

			$import_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND  date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" ')->result_array();
		}



		$arr_import_openings = [];
		$arr_import_openings_amount = [];
		foreach ($import_openings as $import_opening_key => $import_opening_value) {
			if(isset($arr_import_openings[$import_opening_value['commodity_id']])){
				switch ($import_opening_value['status']) {
					case '1':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] += (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   += (float)$import_opening_value['quantity'];
					break;
					case '3':
					if(((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']) > 0){

						$arr_import_openings_amount[$import_opening_value['commodity_id']] += ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity'])*(float)$import_opening_value['purchase_price'];
						$arr_import_openings[$import_opening_value['commodity_id']] 	   += ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] += (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   += (float)$import_opening_value['quantity'];

					break;
					
				}

				
			}else{
				switch ($import_opening_value['status']) {
					case '1':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] = (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   = (float)$import_opening_value['quantity'];
					break;
					case '3':
					if(((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']) > 0){

						$arr_import_openings_amount[$import_opening_value['commodity_id']] = ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity'])*(float)$import_opening_value['purchase_price'];
						$arr_import_openings[$import_opening_value['commodity_id']] 	   = ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_openings_amount[$import_opening_value['commodity_id']] = (float)$import_opening_value['quantity']*(float)$import_opening_value['purchase_price'];
					$arr_import_openings[$import_opening_value['commodity_id']] 	   = (float)$import_opening_value['quantity'];

					break;
					
				}

			}
		}

		//export_openings
		if (strlen($where_warehouse_id) > 0) {

			$export_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" AND '. $where_warehouse_id_with_internal_e)->result_array();

		}else{

			$export_openings = $this->db->query('SELECT commodity_id, quantity as quantity , purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" ')->result_array();
		}


		$arr_export_openings = [];
		$arr_export_openings_amount = [];
		foreach ($export_openings as $export_opening_key => $export_opening_value) {
				//get purchase price of item, before version get sales price.
				// $purchase_price = $export_opening_value['price']
				
				$purchase_price = $this->get_purchase_price_from_commodity_id($export_opening_value['commodity_id']);

			if(isset($arr_export_openings[$export_opening_value['commodity_id']])){
				switch ($export_opening_value['status']) {
					case '2':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] += (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   += (float)$export_opening_value['quantity'];
					break;
					case '3':
					if(((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']) < 0){

						$arr_export_openings_amount[$export_opening_value['commodity_id']] += abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity'])*(float)$purchase_price;
						$arr_export_openings[$export_opening_value['commodity_id']] 	   += abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] += (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   += (float)$export_opening_value['quantity'];

					break;
					
				}

				
			}else{
				switch ($export_opening_value['status']) {
					case '2':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] = (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   = (float)$export_opening_value['quantity'];
					break;
					case '3':
					if(((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']) < 0){

						$arr_export_openings_amount[$export_opening_value['commodity_id']] = abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity'])*(float)$purchase_price;
						$arr_export_openings[$export_opening_value['commodity_id']] 	   = abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_openings_amount[$export_opening_value['commodity_id']] = (float)$export_opening_value['quantity']*(float)$purchase_price;
					$arr_export_openings[$export_opening_value['commodity_id']] 	   = (float)$export_opening_value['quantity'];

					break;
					
				}

			}
		}




		//import_periods
		if (strlen($where_warehouse_id) > 0) {
			$import_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" AND '.$where_warehouse_id_with_internal_i)->result_array();

		}else{

			$import_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status =3 ) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" ')->result_array();
		}


		$arr_import_periods = [];
		$arr_import_periods_amount = [];
		foreach ($import_periods as $import_period_key => $import_period_value) {
			if(isset($arr_import_periods[$import_period_value['commodity_id']])){

				switch ($import_period_value['status']) {
					case '1':
					$arr_import_periods_amount[$import_period_value['commodity_id']] += (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   += (float)$import_period_value['quantity'];
					break;
					case '3':
					if(((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']) > 0){

						$arr_import_periods_amount[$import_period_value['commodity_id']] += ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity'])*(float)$import_period_value['purchase_price'];
						$arr_import_periods[$import_period_value['commodity_id']] 	   += ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_periods_amount[$import_period_value['commodity_id']] += (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   += (float)$import_period_value['quantity'];

					break;
					
				}


			}else{
				switch ($import_period_value['status']) {
					case '1':
					$arr_import_periods_amount[$import_period_value['commodity_id']] = (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   = (float)$import_period_value['quantity'];
					break;
					case '3':
					if(((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']) > 0){

						$arr_import_periods_amount[$import_period_value['commodity_id']] = ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity'])*(float)$import_period_value['purchase_price'];
						$arr_import_periods[$import_period_value['commodity_id']] 	   = ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_periods_amount[$import_period_value['commodity_id']] = (float)$import_period_value['quantity']*(float)$import_period_value['purchase_price'];
					$arr_import_periods[$import_period_value['commodity_id']] 	   = (float)$import_period_value['quantity'];

					break;
					
				}


			}
		}

		//export_periods
		//
		if (strlen($where_warehouse_id) > 0) {
			$export_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" AND '.$where_warehouse_id_with_internal_e)->result_array();

		}else{

			$export_periods = $this->db->query('SELECT commodity_id, quantity as quantity, purchase_price, price, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" ')->result_array();
		}

		$arr_export_periods = [];
		$arr_export_periods_amount = [];
		foreach ($export_periods as $export_period_key => $export_period_value) {
				//get purchase price of item, before version get sales price.
				// $purchase_price = $export_opening_value['price']
				
				$purchase_price = $this->get_purchase_price_from_commodity_id($export_period_value['commodity_id']);

			if(isset($arr_export_periods[$export_period_value['commodity_id']])){

				switch ($export_period_value['status']) {
					case '2':
					$arr_export_periods_amount[$export_period_value['commodity_id']] += (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   += (float)$export_period_value['quantity'];
					break;
					case '3':
					if(((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']) < 0){

						$arr_export_periods_amount[$export_period_value['commodity_id']] += abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity'])*(float)$purchase_price;
						$arr_export_periods[$export_period_value['commodity_id']] 	   += abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_periods_amount[$export_period_value['commodity_id']] += (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   += (float)$export_period_value['quantity'];

					break;
					
				}


				
			}else{

				switch ($export_period_value['status']) {
					case '2':
					$arr_export_periods_amount[$export_period_value['commodity_id']] = (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   = (float)$export_period_value['quantity'];
					break;
					case '3':
					if(((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']) < 0){

						$arr_export_periods_amount[$export_period_value['commodity_id']] = abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity'])*(float)$purchase_price;
						$arr_export_periods[$export_period_value['commodity_id']] 	   = abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']);
					}
					break;
					case '4':
					$arr_export_periods_amount[$export_period_value['commodity_id']] = (float)$export_period_value['quantity']*(float)$purchase_price;
					$arr_export_periods[$export_period_value['commodity_id']] 	   = (float)$export_period_value['quantity'];

					break;
					
				}

				
			}
		}

		//html for page
		$html = '';
		$html .= ' <p><h3 class="bold align_cen">' . mb_strtoupper(_l('stock_summary_report')) . '</h3></p>
		<br>
		<div class="col-md-12 pull-right">
		<div class="row">
		<div class="col-md-12 align_cen">
		<p>' . _l('from_date') . ' :  <span class="fstyle">' . _l('days') . '  ' . date('d', strtotime($from_date)) . '  ' . _l('month') . '  ' . date('m', strtotime($from_date)) . '  ' . _l('year') . '  ' . date('Y', strtotime($from_date)) . '  ' . '</p>
		<p>' . _l('to_date') . ' :  <span class="fstyle">' . _l('days') . '  ' . date('d', strtotime($to_date)) . '  ' . _l('month') . '  ' . date('m', strtotime($to_date)) . '  ' . _l('year') . '  ' . date('Y', strtotime($to_date)) . '  ' . '</p>
		</div>
		</div>
		</div>

		<table class="table">';
		$company_name = get_option('invoice_company_name');
		$address = get_option('invoice_company_address');
		$total_opening_quatity = 0;
		$total_opening_amount = 0;
		$total_import_period_quatity = 0;
		$total_import_period_amount = 0;
		$total_export_period_quatity = 0;
		$total_export_period_amount = 0;
		$total_closing_quatity = 0;
		$total_closing_amount = 0;

		$html .= '<tbody>
		<tr>
		<td class="bold width21">' . _l('company_name') . '</td>
		<td>' . $company_name . '</td>
		</tr>
		<tr>
		<td class="bold">' . _l('address') . '</td>
		<td>' . $address . '</td>
		</tr>
		</tbody>
		</table>
		<div class="col-md-12">
		<table class="table table-bordered">
		<tbody>
		<tr>
		<th colspan="1" class="th_style_stk">'._l('_order').'</th>
		<th  colspan="1" class="th_stk10">' . _l('commodity_code') . '</th>
		<th  colspan="1" class="th_stk10">' . _l('commodity_name') . '</th>
		<th  colspan="1" class="th_stk7">' . _l('unit_name') . '</th>
		<th  colspan="2" class="th_stk17">' . _l('opening_stock') . '</th>
		<th  colspan="2" class="th_stk17">' . _l('receipt_in_period') . '</th>
		<th  colspan="2" class="th_stk17">' . _l('issue_in_period') . '</th>
		<th  colspan="2" class="th_r_stk17">' . _l('closing_stock') . '</th>
		</tr>
		<tr>
		<th class="td_w5"></th>
		<th class="td_w10"></th>
		<th class="td_w10"></th>
		<th class="td_stk_w7"></th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th  class="td_stkw12">' . _l('Amount_') . '</th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th  class="td_stkw12">' . _l('Amount_') . '</th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th class="td_stkw12">' . _l('Amount_') . '</th>
		<th  class="td_stkw5">' . _l('quantity') . '</th>
		<th class="td_stkw12s">' . _l('Amount_') . '</th>
		</tr>';
		foreach ($commodity_lists as $commodity_list_key => $commodity_list) {
			//get purchase price of item, before version get sales price.
						
			$purchase_price = $this->get_purchase_price_from_commodity_id($commodity_list['commodity_id']);

			$html .= '<tr>
			<td class="border_td">' . $commodity_list_key . '</td>
			<td class="border_td">' . $commodity_list['commodity_code'] . '</td>
			<td class="border_td">' . $commodity_list['commodity_name'] . '</td>
			<td class="border_td">' . $commodity_list['unit_name'] . '</td>';
			//import opening
			$stock_opening_quatity = 0;
			$stock_opening_amount = 0;

			$import_opening_quantity = isset($arr_import_openings[$commodity_list['commodity_id']]) ? $arr_import_openings[$commodity_list['commodity_id']] : 0;

			$export_opening_quantity = isset($arr_export_openings[$commodity_list['commodity_id']]) ? $arr_export_openings[$commodity_list['commodity_id']] : 0;

			$import_opening_amount = isset($arr_import_openings_amount[$commodity_list['commodity_id']]) ? $arr_import_openings_amount[$commodity_list['commodity_id']] : 0;

			$export_opening_amount = isset($arr_export_openings_amount[$commodity_list['commodity_id']]) ? $arr_export_openings_amount[$commodity_list['commodity_id']] : 0;
			

			$stock_opening_quatity = (float)$import_opening_quantity - (float)$export_opening_quantity;
			$stock_opening_amount = (float)$import_opening_amount - (float)$export_opening_amount;

			$total_opening_quatity += $stock_opening_quatity;
			$total_opening_amount += $stock_opening_amount;

			//import period
			$import_period_quatity = 0;
			$import_period_amount = 0;

			$import_period_quantity = isset($arr_import_periods[$commodity_list['commodity_id']]) ? $arr_import_periods[$commodity_list['commodity_id']] : 0;

			$import_period_quatity = $import_period_quantity;
			$import_period_amount = isset($arr_import_periods_amount[$commodity_list['commodity_id']]) ? $arr_import_periods_amount[$commodity_list['commodity_id']] : 0;

			$total_import_period_quatity += $import_period_quatity;
			$total_import_period_amount += $import_period_amount;

			//export period
			$export_period_quatity = 0;
			$export_period_amount = 0;

			$export_period_quantity = isset($arr_export_periods[$commodity_list['commodity_id']]) ? $arr_export_periods[$commodity_list['commodity_id']] : 0;

			$export_period_quatity = $export_period_quantity;
			$export_period_amount = isset($arr_export_periods_amount[$commodity_list['commodity_id']]) ? $arr_export_periods_amount[$commodity_list['commodity_id']] : 0;

			$total_export_period_quatity += $export_period_quatity;
			$total_export_period_amount += $export_period_amount;

			//closing
			$closing_quatity = 0;
			$closing_amount = 0;
			$closing_quatity = $stock_opening_quatity + $import_period_quatity - $export_period_quatity;
			// before get from fomular: $closing_amount = ($stock_opening_amount + $import_period_amount - $export_period_amount) after change below
			
			$closing_amount = $closing_quatity*(float)$purchase_price;

			$total_closing_quatity += $closing_quatity;
			$total_closing_amount += $closing_amount;

			$html .= '<td class="bor_alir">' . $stock_opening_quatity . '</td>
			<td class="bor_alir">' . app_format_money((float) $stock_opening_amount, '') . '</td>
			<td class="bor_alir">' . $import_period_quatity . '</td>
			<td class="bor_alir">' . app_format_money((float) $import_period_amount, '') . '</td>
			<td class="bor_alir">' . $export_period_quatity . '</td>
			<td class="bor_alir">' . app_format_money((float) $export_period_amount, '') . '</td>
			<td class="bor_alir">' . $closing_quatity . '</td>
			<td class="bor_r">' . app_format_money((float) $closing_amount, '') . '</td>
			</tr>';
		}
		$html .= '<tr>
		<th  colspan="4" class="th_stk_style">' . _l('total') . ' : </th>
		<th  colspan="1" class="th_stk_style">' . $total_opening_quatity . '</th>
		<th  colspan="1" class="th_stk_style">' . app_format_money((float) $total_opening_amount, '') . '</th>
		<th  colspan="1" class="th_stk_style">' . $total_import_period_quatity . '</th>
		<th  colspan="1" class="th_stk_style">' . app_format_money((float) $total_import_period_amount, '') . '</th>
		<th  colspan="1" class="th_stk_style">' . $total_export_period_quatity . '</th>
		<th  colspan="1" class="th_stk_style">' . app_format_money((float) $total_export_period_amount, '') . '</th>
		<th  colspan="1" class="th_stk_style">' . $total_closing_quatity . '</th>
		<th  colspan="1" class="th_st_spe">' . app_format_money((float) $total_closing_amount, '') . '</th>
		</tr>
		</tbody>
		</table>
		</div>';

		$html .= ' 
		<br>
		<br>';

		$html .= '
		<br>
		<br>
		<br>
		<br>';

		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';

		return $html;

	}

	/**
	 * get quantity inventory
	 * @param  integer $warehouse_id
	 * @param  integer $commodity_id
	 * @return object
	 */
	public function get_quantity_inventory($warehouse_id, $commodity_id) {

		$sql = 'SELECT warehouse_id, commodity_id, sum(inventory_number) as inventory_number from ' . db_prefix() . 'inventory_manage where warehouse_id = ' . $warehouse_id . ' AND commodity_id = ' . $commodity_id .' group by warehouse_id, commodity_id';
		$result = $this->db->query($sql)->row();
		//if > 0 update, else insert
		return $result;

	}

	/**
	 * get warehourse attachments
	 * @param  integer $commodity_id
	 * @return array
	 */
	public function get_warehourse_attachments($commodity_id) {

		$this->db->order_by('dateadded', 'desc');
		$this->db->where('rel_id', $commodity_id);
		$this->db->where('rel_type', 'commodity_item_file');

		return $this->db->get(db_prefix() . 'files')->result_array();

	}

	/**
	 * add commodity one item
	 * @param array $data
	 * @return integer
	 */
	public function add_commodity_one_item($data) {
		
		$arr_insert_cf=[];
		$arr_variation=[];
		/*get custom fields*/
		if(isset($data['formdata'])){
			$arr_custom_fields=[];

			$arr_variation_temp=[];
			$variation_name_temp='';
			$variation_option_temp='';

			foreach ($data['formdata'] as $value_cf) {
				if(preg_match('/^custom_fields/', $value_cf['name'])){
					$index =  str_replace('custom_fields[items][', '', $value_cf['name']);
					$index =  str_replace(']', '', $index);

					$arr_custom_fields[$index] = $value_cf['value'];

				}

				//get variation 
				$variation_name_index=0;
				if(preg_match('/^name/', $value_cf['name'])){
					$variation_name_temp = $value_cf['value'];
				}

				if(preg_match('/^options/', $value_cf['name'])){
					$variation_option_temp = $value_cf['value'];

					array_push($arr_variation, [
						'name' => $variation_name_temp,
						'options' => explode(',', $variation_option_temp),
					]);

					$variation_name_temp='';
					$variation_option_temp='';
				}

			}

			$arr_insert_cf['items_pr'] = $arr_custom_fields;

			$formdata = $data['formdata'];
			unset($data['formdata']);
		}

		$data['parent_attributes'] = json_encode($arr_variation);

		if (isset($data['custom_fields'])) {
			$custom_fields = $data['custom_fields'];
			unset($data['custom_fields']);
		}

		/*add data tblitem*/
		$data['rate'] = reformat_currency_j($data['rate']);

		if(isset($data['purchase_price']) && $data['purchase_price']){
			
			$data['purchase_price'] = reformat_currency_j($data['purchase_price']);
		}
		/*create sku code*/
		if($data['sku_code'] != ''){
			$data['sku_code'] = get_warehouse_option('item_sku_prefix').str_replace(' ', '', $data['sku_code']) ;

		}else{
			//data sku_code = group_character.sub_code.commodity_str_betwen.next_commodity_id; // X_X_000.id auto increment
			$data['sku_code'] = get_warehouse_option('item_sku_prefix').$this->create_sku_code($data['group_id'], isset($data['sub_group']) ? $data['sub_group'] : '' );
			/*create sku code*/
		}

		if(get_warehouse_option('barcode_with_sku_code') == 1){
			$data['commodity_barcode'] = $data['sku_code'];
		}

		$tags = '';
		if (isset($data['tags'])) {
			$tags = $data['tags'];
			unset($data['tags']);
		}


		$this->db->insert(db_prefix() . 'items', $data);
		$insert_id = $this->db->insert_id();

		/*add data tblinventory*/
		if ($insert_id) {
			$data_inventory_min['commodity_id'] = $insert_id;
			$data_inventory_min['commodity_code'] = $data['commodity_code'];
			$data_inventory_min['commodity_name'] = $data['description'];
			$this->add_inventory_min($data_inventory_min);

			/*habdle add tags*/
			handle_tags_save($tags, $insert_id, 'item_tags');


			/*handle custom fields*/

			if(isset($formdata)){
				$data_insert_cf = [];

				handle_custom_fields_post($insert_id, $arr_insert_cf, true);
			}

			hooks()->do_action('item_created', $insert_id);

			log_activity('New Warehouse Item Added [ID:' . $insert_id . ', ' . $data['description'] . ']');


		}

		return $insert_id;

	}

	/**
	 * update commodity one item
	 * @param  array $data
	 * @param  integer $id
	 * @return boolean
	 */
	public function update_commodity_one_item($data, $id) {

		if (isset($data['custom_fields'])) {
			$custom_fields = $data['custom_fields'];
			unset($data['custom_fields']);
		}

		$arr_insert_cf=[];
		$arr_variation=[];
		/*get custom fields, get variation value*/
		if(isset($data['formdata'])){
			$arr_custom_fields=[];

			$arr_variation_temp=[];
			$variation_name_temp='';
			$variation_option_temp='';

			foreach ($data['formdata'] as $value_cf) {
				if(preg_match('/^custom_fields/', $value_cf['name'])){
					$index =  str_replace('custom_fields[items][', '', $value_cf['name']);
					$index =  str_replace(']', '', $index);

					$arr_custom_fields[$index] = $value_cf['value'];

				}

				//get variation 
				$variation_name_index=0;
				if(preg_match('/^name/', $value_cf['name'])){
					$variation_name_temp = $value_cf['value'];
				}

				if(preg_match('/^options/', $value_cf['name'])){
					$variation_option_temp = $value_cf['value'];

					array_push($arr_variation, [
						'name' => $variation_name_temp,
						'options' => explode(',', $variation_option_temp),
					]);

					$variation_name_temp='';
					$variation_option_temp='';
				}


			}

			$arr_insert_cf['items'] = $arr_custom_fields;

			$formdata = $data['formdata'];
			unset($data['formdata']);
		}

		$data['parent_attributes'] = json_encode($arr_variation);

		/*handle custom fields*/

		if(isset($formdata)){
			$data_insert_cf = [];
			handle_custom_fields_post($id, $arr_insert_cf, true);
		}

		/*handle update item tag*/

		if(strlen($data['tags']) > 0){

			$this->db->where('rel_id', $id);
			$this->db->where('rel_type', 'item_tags');
			$arr_tag = $this->db->get(db_prefix() . 'taggables')->result_array();

			if(count($arr_tag) > 0){
	        	//update
				$arr_tag_insert =  explode(',', $data['tags']);
				/*get order last*/
				$total_tag = count($arr_tag);
				$tag_order_last = $arr_tag[$total_tag-1]['tag_order']+1;

				foreach ($arr_tag_insert as $value) {
					/*insert tbl tags*/  
					$this->db->insert(db_prefix() . 'tags', ['name' => $value]);
					$insert_tag_id = $this->db->insert_id();

					/*insert tbl taggables*/
					if($insert_tag_id){
						$this->db->insert(db_prefix() . 'taggables', ['rel_id' => $id, 'rel_type'=>'item_tags', 'tag_id' => $insert_tag_id, 'tag_order' => $tag_order_last]);
						$this->db->insert_id();

						$tag_order_last++;
					}

				}

			}else{
	        	//insert
				handle_tags_save($data['tags'], $id, 'item_tags');

			}
		}

		if (isset($data['tags'])) {
			unset($data['tags']);
		}


		$data['sku_code'] = str_replace(' ', '', $data['sku_code']) ;

		if(get_warehouse_option('barcode_with_sku_code') == 1){
			$data['commodity_barcode'] = $data['sku_code'];
		}


		$data['rate'] = reformat_currency_j($data['rate']);
		$data['purchase_price'] = reformat_currency_j($data['purchase_price']);

		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'items', $data);

		//update commodity min
		$this->db->where('commodity_id', $id);
		$data_inventory_min=[];
		$data_inventory_min['commodity_code'] = $data['commodity_code'];
		$data_inventory_min['commodity_name'] = $data['description'];
		$this->db->update(db_prefix() . 'inventory_commodity_min', $data_inventory_min);

		return true;
	}

	/**
	 * get sub group
	 * @param  boolean $id
	 * @return array  or object
	 */
	public function get_sub_group($id = false) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'wh_sub_group')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblwh_sub_group')->result_array();
		}

	}

	/**
	 * add sub group
	 * @param array  $data
	 * @param boolean $id
	 * @return boolean
	 */
	public function add_sub_group($data, $id = false) {
		$commodity_type = str_replace(', ', '|/\|', $data['hot_sub_group']);

		$data_commodity_type = explode(',', $commodity_type);
		$results = 0;
		$results_update = '';
		$flag_empty = 0;

		foreach ($data_commodity_type as $commodity_type_key => $commodity_type_value) {
			if ($commodity_type_value == '') {
				$commodity_type_value = 0;
			}
			if (($commodity_type_key + 1) % 6 == 0) {
				$arr_temp['note'] = str_replace('|/\|', ', ', $commodity_type_value);

				if ($id == false && $flag_empty == 1) {
					$this->db->insert(db_prefix() . 'wh_sub_group', $arr_temp);
					$insert_id = $this->db->insert_id();
					if ($insert_id) {
						$results++;
					}
				}
				if (is_numeric($id) && $flag_empty == 1) {
					$this->db->where('id', $id);
					$this->db->update(db_prefix() . 'wh_sub_group', $arr_temp);
					if ($this->db->affected_rows() > 0) {
						$results_update = true;
					} else {
						$results_update = false;
					}
				}
				$flag_empty = 0;
				$arr_temp = [];
			} else {

				switch (($commodity_type_key + 1) % 6) {
					case 1:
					$arr_temp['sub_group_code'] = str_replace('|/\|', ', ', $commodity_type_value);
					if ($commodity_type_value != '0') {
						$flag_empty = 1;
					}
					break;
					case 2:
					$arr_temp['sub_group_name'] = str_replace('|/\|', ', ', $commodity_type_value);
					break;
					case 3:
					$arr_temp['group_id'] = $commodity_type_value;
					break;
					case 4:
					$arr_temp['order'] = $commodity_type_value;
					break;
					case 5:
					//display 1: display (yes) , 0: not displayed (no)
					if ($commodity_type_value == 'yes') {
						$display_value = 1;
					} else {
						$display_value = 0;
					}
					$arr_temp['display'] = $display_value;
					break;
				}
			}

		}

		if ($id == false) {
			return $results > 0 ? true : false;
		} else {
			return $results_update;
		}

	}

	/**
	 * delete_sub_group
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_sub_group($id) {
		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'wh_sub_group');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * import xlsx commodity
	 * @param  array $data
	 * @return integer
	 */
	public function import_xlsx_commodity($data, $flag_insert_id) {
		if($data['commodity_barcode'] != ''){
			$data['commodity_barcode'] = $data['commodity_barcode'];
		}else{
			$data['commodity_barcode'] = $this->generate_commodity_barcode();
		}
		
		
		/*create sku code*/
		if($data['sku_code'] != ''){
			$data['sku_code'] = str_replace(' ', '', $data['sku_code']) ;
		}else{
			//data sku_code = group_character.sub_code.commodity_str_betwen.next_commodity_id; // X_X_000.id auto increment
			$data['sku_code'] = $this->create_sku_code($data['group_id'], isset($data['sub_group']) ? $data['sub_group'] : '' ,$flag_insert_id );
			/*create sku code*/
		}

		if(get_warehouse_option('barcode_with_sku_code') == 1){
			$data['commodity_barcode'] = $data['sku_code'];
		}


		/*caculator  pur, sale, profit*/
		if(isset($data['purchase_price']) && isset($data['rate']) && isset($data['profif_ratio'])){
			/*get profit*/

			$data['profif_ratio'] = $this->caculator_profit_rate_model($data['purchase_price'], $data['rate']);

		}elseif(isset($data['profif_ratio']) && isset($data['rate'])){
			/*get purchase*/
			$data['purchase_price'] = $this->caculator_purchase_price_model($data['profif_ratio'], $data['rate']);

		}elseif(isset($data['profif_ratio']) && isset($data['purchase_price'])){
			/*get rate*/
			$data['rate'] = $this->caculator_sale_price_model($data['purchase_price'], $data['profif_ratio']);

		}elseif(isset($data['purchase_price']) && isset($data['rate'])){
			/*get profit*/

			$data['profif_ratio'] = $this->caculator_profit_rate_model($data['purchase_price'], $data['rate']);
			
		}

		/*caculator  pur, sale, profit*/

		
		/*check update*/

		$item = $this->db->query('select * from tblitems where commodity_code = "'.$data['commodity_code'].'"')->row();

		if($item){
			//check sku code dulicate
			
			if($this->check_sku_duplicate(['sku_code' => $data['sku_code'], 'item_id' => $item->id]) == false){
				return ['status' => false, 'message' => _l('commodity_code').': '. $data['commodity_code'] ._l('wh_has').  _l('sku_code') ._l('exist')];
			}

			if(isset($data['tags'])){
				$tags_value =  $data['tags'];
				unset($data['tags']);
			}else{
				$tags_value ='';
			}
			unset($data['tags']);
			foreach ($data as $key => $data_value) {
				if(!isset($data_value)){
					unset($data[$key]);
				}
			}

			$minimum_inventory = 0;
			if(isset($data['minimum_inventory'])){
				$minimum_inventory = $data['minimum_inventory'];
				unset($data['minimum_inventory']);
			}


			//update
			$this->db->where('commodity_code', $data['commodity_code']);
			$this->db->update(db_prefix() . 'items', $data);

			/*habdle add tags*/
			handle_tags_save($tags_value, $item->id, 'item_tags');
			

			/*check update or insert inventory min with commodity code*/
			$this->db->where('commodity_code', $data['commodity_code']);
			$check_inventory_min = $this->db->get(db_prefix().'inventory_commodity_min')->row();

			if($check_inventory_min){
				//update
				$this->db->where('commodity_code', $data['commodity_code']);
				$this->db->update(db_prefix() . 'inventory_commodity_min', ['inventory_number_min' => $minimum_inventory]);

			}else{
				//get commodity_id
				$this->db->where('commodity_code', $data['commodity_code']);
				$items = $this->db->get(db_prefix().'items')->row();

				$item_id=0;
				if($items){
					$item_id = $items->id;
				}

				//insert
				$data_inventory_min['commodity_id'] = $item_id;
				$data_inventory_min['commodity_code'] = $data['commodity_code'];
				$data_inventory_min['commodity_name'] = $data['description'];
				$data_inventory_min['inventory_number_min'] = $minimum_inventory;
				$this->add_inventory_min($data_inventory_min);

			}


			if ($this->db->affected_rows() > 0) {
				return ['status' => true, 'message' => ''];
			}else{
				return ['status' => false, 'message' => _l('updated_false')];
			}
		}else{
			//check sku code dulicate
			if($this->check_sku_duplicate(['sku_code' => $data['sku_code'], 'item_id' => '']) == false){
				return ['status' => false, 'message' => _l('commodity_code').': '. $data['commodity_code'] ._l('wh_has').  _l('sku_code') ._l('exist')];
			}


			$minimum_inventory = 0;
			if(isset($data['minimum_inventory'])){
				$minimum_inventory = $data['minimum_inventory'];
				unset($data['minimum_inventory']);
			}

			$data['sku_code'] = get_warehouse_option('item_sku_prefix').$data['sku_code'];

			if(isset($data['tags'])){
				$tags_value =  $data['tags'];
				unset($data['tags']);
			}else{
				$tags_value ='';
			}

			unset($data['tags']);

			//insert
			$this->db->insert(db_prefix() . 'items', $data);
			$insert_id = $this->db->insert_id();

			/*habdle add tags*/
			if($insert_id){
				handle_tags_save($tags_value, $insert_id, 'item_tags');
			}

			/*add data tblinventory*/
			if ($insert_id) {
				$data_inventory_min['commodity_id'] = $insert_id;
				$data_inventory_min['commodity_code'] = $data['commodity_code'];
				$data_inventory_min['commodity_name'] = $data['description'];
				$data_inventory_min['inventory_number_min'] = $minimum_inventory;
				$this->add_inventory_min($data_inventory_min);

				return ['status' => true, 'message' => '', 'insert_id' => $insert_id];
			}

			return ['status' => false, 'message' => 'Add item false'];
		}


	}

	/**
	 * get commodity attachments delete
	 * @param  integer $id
	 * @return object
	 */
	public function get_commodity_attachments_delete($id) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'files')->row();
		}
	}

	//delete _commodity_file file for any
	/**
	 * delete commodity file
	 * @param  integer $attachment_id
	 * @return boolean
	 */
	public function delete_commodity_file($attachment_id) {
		$deleted = false;
		$attachment = $this->get_commodity_attachments_delete($attachment_id);

		if ($attachment) {
			if (empty($attachment->external)) {
				if (file_exists(WAREHOUSE_ITEM_UPLOAD . $attachment->rel_id . '/' . $attachment->file_name)) {
					unlink(WAREHOUSE_ITEM_UPLOAD . $attachment->rel_id . '/' . $attachment->file_name);
				} else {
					unlink('modules/purchase/uploads/item_img/' . $attachment->rel_id . '/' . $attachment->file_name);
				}
			}
			$this->db->where('id', $attachment->id);
			$this->db->delete(db_prefix() . 'files');
			if ($this->db->affected_rows() > 0) {
				$deleted = true;
				log_activity('commodity Attachment Deleted [commodityID: ' . $attachment->rel_id . ']');
			}
			if (file_exists(WAREHOUSE_ITEM_UPLOAD . $attachment->rel_id . '/' . $attachment->file_name)) {
				if (is_dir(WAREHOUSE_ITEM_UPLOAD . $attachment->rel_id)) {

					// Check if no attachments left, so we can delete the folder also
					$other_attachments = list_files(WAREHOUSE_ITEM_UPLOAD . $attachment->rel_id);
					if (count($other_attachments) == 0) {
						// okey only index.html so we can delete the folder also
						delete_dir(WAREHOUSE_ITEM_UPLOAD . $attachment->rel_id);
					}
				}
			} else {
				if (is_dir('modules/purchase/uploads/item_img/' . $attachment->rel_id)) {

					// Check if no attachments left, so we can delete the folder also
					$other_attachments = list_files('modules/purchase/uploads/item_img/' . $attachment->rel_id);
					if (count($other_attachments) == 0) {
						// okey only index.html so we can delete the folder also
						delete_dir('modules/purchase/uploads/item_img/' . $attachment->rel_id);
					}
				}
			}

		}

		return $deleted;
	}

	/**
	 * get color
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_color($id = false) {

		if (is_numeric($id)) {
			$this->db->where('color_id', $id);

			return $this->db->get(db_prefix() . 'ware_color')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblware_color')->result_array();
		}

	}

	/**
	 * create sku code
	 * @param  int commodity_group
	 * @param  int sub_group
	 * @return string
	 */
	public function create_sku_code($commodity_group, $sub_group, $flag_insert_id = false) {
		// input  commodity group, sub group
		//get commodity group from id
		$group_character = '';
		if (isset($commodity_group) && $commodity_group != '') {

			$sql_group_where = 'SELECT * FROM ' . db_prefix() . 'items_groups where id = "' . $commodity_group . '"';
			$group_value = $this->db->query($sql_group_where)->row();
			if ($group_value) {

				if ($group_value->commodity_group_code != '') {
					$group_character = mb_substr($group_value->commodity_group_code, 0, 1, "UTF-8") . '-';

				}
			}

		}

		//get sku code from sku id
		$sub_code = '';
		if (isset($sub_group) && $sub_group != '') {

			$sql_sub_group_where = 'SELECT * FROM ' . db_prefix() . 'wh_sub_group where id = "' . $sub_group . '"';
			$sub_group_value = $this->db->query($sql_sub_group_where)->row();
			if ($sub_group_value) {
				$sub_code = $sub_group_value->sub_group_code . '-';
			}

		}

		if($flag_insert_id != 0 && $flag_insert_id != false){
			$last_commodity_id = $flag_insert_id;
		}else{

			$sql_where = 'SELECT * FROM ' . db_prefix() . 'items order by id desc limit 1';
			$res = $this->db->query($sql_where)->row();
			$last_commodity_id = 0;
			if (isset($res)) {
				$last_commodity_id = $this->db->query($sql_where)->row()->id;
			}
		}
		$next_commodity_id = (int) $last_commodity_id + 1;


		// data_sku_code = group_character.sub_code.commodity_str_betwen.next_commodity_id; // X_X_000.id auto increment
		return $group_character . $sub_code .str_pad($next_commodity_id,5,'0',STR_PAD_LEFT);  // X_X_000.id auto increment

	}

	/**
	 * add color
	 * @param array $data
	 * @return integer
	 */
	public function add_color($data) {

		$option = 'off';
		if (isset($data['display'])) {
			$option = $data['display'];
			unset($data['display']);
		}

		if ($option == 'on') {
			$data['display'] = 1;
		} else {
			$data['display'] = 0;
		}

		$this->db->insert(db_prefix() . 'ware_color', $data);
		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	/**
	 * update color
	 * @param  array $data
	 * @param  integer $id
	 * @return boolean
	 */
	public function update_color($data, $id) {
		$option = 'off';
		if (isset($data['display'])) {
			$option = $data['display'];
			unset($data['display']);
		}

		if ($option == 'on') {
			$data['display'] = 1;
		} else {
			$data['display'] = 0;
		}

		$this->db->where('color_id', $id);
		$this->db->update(db_prefix() . 'ware_color', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return true;
	}

	/**
	 * delete color
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_color($id) {

		//delete job_p
		$this->db->where('color_id', $id);
		$this->db->delete(db_prefix() . 'ware_color');

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return false;
	}

	/**
	 * get color add commodity
	 * @return array
	 */
	public function get_color_add_commodity() {
		return $this->db->query('select * from tblware_color where display = 1 order by tblware_color.order asc ')->result_array();
	}

	/**
	 * Adds a loss adjustment.
	 *
	 * @param      <type>  $data   The data
	 *
	 * @return     <type>  (id loss addjustment) )
	 */
	public function add_loss_adjustment($data) {
		$check_appr = $this->get_approve_setting('3');
		$data_add['status'] = 0;
		if ($check_appr && $check_appr != false) {
			$data_add['status'] = 0;
		} else {
			$data_add['status'] = 1;
		}	

		if(!$this->check_format_date($data['time'])){
    		$data_add['time'] = to_sql_date($data['time'], true);
    	}else{
    		$data_add['time'] = $data['time'];
    	}

		$data_add['type'] = $data['type'];
		$data_add['reason'] = (isset($data['reason']) ? $data['reason'] : '');
		$data_add['addfrom'] = $data['addfrom'];
		$data_add['date_create'] = $data['date_create'];
		$data_add['warehouses'] = $data['warehouses'];

		$this->db->insert(db_prefix() . 'wh_loss_adjustment', $data_add);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			if (isset($data['pur_order_detail'])) {
				$pur_order_detail = explode(',', $data['pur_order_detail']);
				unset($data['pur_order_detail']);
				$es_detail = [];
				$row = [];
				$rq_val = [];
				$header = [];

				$header[] = 'items';
				$header[] = 'unit';
				$header[] = 'lot_number';
				$header[] = 'expiry_date';
				$header[] = 'current_number';
				$header[] = 'updates_number';
				$header[] = 'loss_adjustment';

				for ($i = 0; $i < count($pur_order_detail); $i++) {
					$row[] = $pur_order_detail[$i];
					if ((($i + 1) % 6) == 0) {
						$row[] = $insert_id;
						$rq_val[] = array_combine($header, $row);
						$row = [];
					}
				}
				foreach ($rq_val as $key => $rq) {
					
					if ($rq['items'] != '') {
						foreach ($rq_val[$key] as $key_d => $d_value) {
							if($key_d == 'expiry_date'){

								if(!$this->check_format_date($d_value)){
									$rq_val[$key][$key_d] = to_sql_date($d_value);
								}
							}

						}

						array_push($es_detail, $rq_val[$key]);
					}
				}

				$this->db->insert_batch(db_prefix() . 'wh_loss_adjustment_detail', $es_detail);
			}

			//approval if not approval setting
			if (isset($insert_id)) {
				if ($data_add['status'] == 1) {

					$this->change_adjust($insert_id);
				}
			}

			return $insert_id;
		}
		return false;

	}

	/**
	 * { update loss adjustment }
	 *
	 * @param      <type>   $data   The data
	 *
	 * @return     boolean
	 */
	public function update_loss_adjustment($data) {
		$affected_rows = 0;
		$data_add['time'] = to_sql_date($data['time'], true);
		$data_add['type'] = $data['type'];
		$data_add['reason'] = (isset($data['reason']) ? $data['reason'] : '');
		$data_add['addfrom'] = $data['addfrom'];
		$data_add['date_create'] = $data['date_create'];
		$data_add['warehouses'] = $data['warehouses'];
		$this->db->where('id', $data['id']);
		$this->db->update(db_prefix() . 'wh_loss_adjustment', $data_add);

		if (isset($data['pur_order_detail'])) {
			$pur_order_detail = explode(',', $data['pur_order_detail']);
			unset($data['pur_order_detail']);
			$es_detail = [];
			$row = [];
			$rq_val = [];
			$header = [];

			$header[] = 'items';
			$header[] = 'unit';
			$header[] = 'lot_number';
			$header[] = 'expiry_date';
			$header[] = 'current_number';
			$header[] = 'updates_number';
			$header[] = 'loss_adjustment';

			for ($i = 0; $i < count($pur_order_detail); $i++) {
				$row[] = $pur_order_detail[$i];
				if ((($i + 1) % 7) == 0) {
					$rq_val[] = array_combine($header, $row);
					$row = [];
				}
			}
			foreach ($rq_val as $key => $rq) {
				if ($rq['items'] != '') {
					foreach ($rq_val[$key] as $key_d => $d_value) {
						if($key_d == 'expiry_date'){

							if(!$this->check_format_date($d_value)){
								$rq_val[$key][$key_d] = to_sql_date($d_value);
							}
						}

					}

					array_push($es_detail, $rq_val[$key]);
				}
			}
			$this->db->where('loss_adjustment', $data['id']);
			$this->db->delete(db_prefix() . 'wh_loss_adjustment_detail');

			foreach ($es_detail as $key => $val) {
				$this->db->insert(db_prefix() . 'wh_loss_adjustment_detail', [
					'items' => $val['items'],
					'unit' => $val['unit'],
					'lot_number' => $val['lot_number'],
					'expiry_date' => $val['expiry_date'],
					'current_number' => $val['current_number'],
					'updates_number' => $val['updates_number'],
					'loss_adjustment' => $data['id'],
				]);
			}

		}

		return true;

	}

	/**
	 * { delete loss adjustment }
	 *
	 * @param      <type>   $id     The identifier
	 *
	 * @return     boolean
	 */
	public function delete_loss_adjustment($id) {
		$affected_rows = 0;
		$this->db->where('loss_adjustment', $id);
		$this->db->delete(db_prefix() . 'wh_loss_adjustment_detail');
		if ($this->db->affected_rows() > 0) {

			$affected_rows++;
		}

		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'wh_loss_adjustment');
		if ($this->db->affected_rows() > 0) {

			$affected_rows++;
		}

		//delete history
		$this->db->where('goods_receipt_id', $id);
		$this->db->where('status', 3);
		$this->db->delete(db_prefix() . 'goods_transaction_detail');


		if ($affected_rows > 0) {
			return true;
		}
		return false;
	}

	/**
	 * Gets the loss adjustment.
	 *
	 * @param      string  $id     The identifier
	 *
	 * @return     <type>  The loss adjustment.
	 */
	public function get_loss_adjustment($id = '') {
		if ($id == '') {
			return $this->db->get(db_prefix() . 'wh_loss_adjustment')->result_array();
		} else {
			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'wh_loss_adjustment')->row();
		}
	}

	/**
	 * Gets the loss adjustment detailt by masterid.
	 *
	 * @param      string  $id     The identifier
	 *
	 * @return     <type>  The loss adjustment detailt by masterid.
	 */
	public function get_loss_adjustment_detailt_by_masterid($id = '') {
		if ($id == '') {
			return $this->db->get(db_prefix() . 'wh_loss_adjustment_detail')->result_array();
		} else {
			$this->db->where('loss_adjustment', $id);
			return $this->db->get(db_prefix() . 'wh_loss_adjustment_detail')->result_array();
		}
	}

	/**
	 * { change adjust }
	 *
	 * @param      <type>  $id     The identifier
	 */
	public function change_adjust($id) {
		$loss_adjustment = $this->get_loss_adjustment($id);
		$detail = $this->get_loss_adjustment_detailt_by_masterid($id);

		$affected_rows = 0;
		foreach ($detail as $d) {
			$check = $this->check_commodity_exist_inventory($loss_adjustment->warehouses, $d['items'], $d['lot_number'], $d['expiry_date']);
			if ($check == false) {

				if(isset($d['lot_number']) && $d['lot_number'] != '0' && $d['lot_number'] != ''){
					/*have value*/
					$this->db->where('lot_number', $d['lot_number']);

				}else{

					/*lot number is 0 or ''*/
					$this->db->group_start();

					$this->db->where('lot_number', '0');
					$this->db->or_where('lot_number', '');
					$this->db->or_where('lot_number', null);

					$this->db->group_end();
				}

				$this->db->where('warehouse_id', $loss_adjustment->warehouses);
				$this->db->where('commodity_id', $d['items']);

				if($d['expiry_date'] == ''){

					$this->db->where('expiry_date', null);
				}else{
					$this->db->where('expiry_date', $d['expiry_date']);
				}


				$inventory_value = $this->db->get(db_prefix().'inventory_manage')->row();

				if($inventory_value){

					$this->db->where('id', $inventory_value->id);
				}else{
					return false;
				}

				$this->db->update(db_prefix() . 'inventory_manage', [
					'inventory_number' => $d['updates_number'],
				]);
				if ($this->db->affected_rows() > 0) {
					$affected_rows++;
				}

				$this->db->insert(db_prefix() . 'goods_transaction_detail', [
					'goods_receipt_id' => $id,
					'old_quantity' => $d['current_number'],
					'quantity' => $d['updates_number'],
					'date_add' => date('Y-m-d H:i:s'),
					'commodity_id' => $d['items'],
					'lot_number' => $d['lot_number'],
					'expiry_date' => $d['expiry_date'],
					'warehouse_id' => $loss_adjustment->warehouses,
					'status' => 3,
				]);

			} else {
				return false;
			}

		}

		if ($affected_rows > 0) {
			$this->db->where('id', $id);
			$this->db->update(db_prefix() . 'wh_loss_adjustment', [
				'status' => 1,
			]);

			return true;
		}
		return false;
	}

	/**
	 *@param array data
	 */
	public function get_inventory_valuation_report_view($data) {
		$from_date = $data['from_date'];
		$to_date = $data['to_date'];

		if(!$this->check_format_date($from_date)){
			$from_date = to_sql_date($from_date);
		}
		if(!$this->check_format_date($to_date)){
			$to_date = to_sql_date($to_date);
		}

		$where_warehouse_id = '';

		$where_warehouse_id_with_internal_i = '';
		$where_warehouse_id_with_internal_e = '';

		if (strlen($data['warehouse_id']) > 0) {
			$arr_warehouse_id =  explode(',', $data['warehouse_id']);

			foreach ($arr_warehouse_id as $warehouse_id) {
				if ($warehouse_id != '') {

					if ($where_warehouse_id == '') {
						$where_warehouse_id .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) ';

						$where_warehouse_id_with_internal_i .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name)';

						$where_warehouse_id_with_internal_e .= ' (find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) OR find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name)';

					} else {
						$where_warehouse_id .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.warehouse_id) ';

						$where_warehouse_id_with_internal_i .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.to_stock_name) ';

						$where_warehouse_id_with_internal_e .= ' or find_in_set('.$warehouse_id.', '.db_prefix().'goods_transaction_detail.from_stock_name) ';

					}

				}
			}

			if ($where_warehouse_id != '') {
				$where_warehouse_id .= ')';

				$where_warehouse_id_with_internal_i .= ')';
				$where_warehouse_id_with_internal_e .= ')';

			}
		}





		//get_commodity_list in warehouse
		if (strlen($data['warehouse_id']) > 0) {
			$commodity_lists = $this->db->query('SELECT commodity_id, ' . db_prefix() . 'items.commodity_code, ' . db_prefix() . 'items.rate, ' . db_prefix() . 'items.purchase_price, ' . db_prefix() . 'items.description as commodity_name, ' . db_prefix() . 'ware_unit_type.unit_name FROM ' . db_prefix() . 'goods_transaction_detail
				LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'goods_transaction_detail.commodity_id = ' . db_prefix() . 'items.id
				LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id where '.$where_warehouse_id. ' AND '.db_prefix().'items.active = 1 group by commodity_id ')->result_array();

		}else{

			$commodity_lists = $this->db->query('SELECT commodity_id, ' . db_prefix() . 'items.commodity_code, ' . db_prefix() . 'items.rate, ' . db_prefix() . 'items.purchase_price, ' . db_prefix() . 'items.description as commodity_name, ' . db_prefix() . 'ware_unit_type.unit_name FROM ' . db_prefix() . 'goods_transaction_detail
				LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'goods_transaction_detail.commodity_id = ' . db_prefix() . 'items.id
				LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'items.unit_id = ' . db_prefix() . 'ware_unit_type.unit_type_id where '.db_prefix().'items.active = 1 group by commodity_id')->result_array();
		}

		//import_openings
		if (strlen($data['warehouse_id']) > 0) {
			$import_openings = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" AND ' .$where_warehouse_id_with_internal_i)->result_array();

		}else{

			$import_openings = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '"')->result_array();
		}

		$arr_import_openings = [];

		foreach ($import_openings as $import_opening_key => $import_opening_value) {
			if(isset($arr_import_openings[$import_opening_value['commodity_id']])){
				switch ($import_opening_value['status']) {
					case '1':
					$arr_import_openings[$import_opening_value['commodity_id']]      += (float)$import_opening_value['quantity'];
					break;
					case '3':
					if(((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']) > 0){

						$arr_import_openings[$import_opening_value['commodity_id']]      += ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']);
					}
					break;
					case '4':

					$arr_import_openings[$import_opening_value['commodity_id']]      += (float)$import_opening_value['quantity'];

					break;

				}


			}else{
				switch ($import_opening_value['status']) {
					case '1':

					$arr_import_openings[$import_opening_value['commodity_id']]      = (float)$import_opening_value['quantity'];
					break;
					case '3':
					if(((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']) > 0){

						$arr_import_openings[$import_opening_value['commodity_id']]      = ((float)$import_opening_value['quantity'] - (float)$import_opening_value['old_quantity']);
					}
					break;
					case '4':
					$arr_import_openings[$import_opening_value['commodity_id']]      = (float)$import_opening_value['quantity'];

					break;

				}

			}
		}

		//export_openings
		if (strlen($data['warehouse_id']) > 0) {
			$export_openings = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '" AND '.$where_warehouse_id_with_internal_e )->result_array();

		}else{

			$export_openings = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3 ) AND date_format(date_add,"%Y-%m-%d") < "' . $from_date . '"')->result_array();
		}

		$arr_export_openings = [];
		foreach ($export_openings as $export_opening_key => $export_opening_value) {

			if(isset($arr_export_openings[$export_opening_value['commodity_id']])){
				switch ($export_opening_value['status']) {
					case '2':

					$arr_export_openings[$export_opening_value['commodity_id']]      += (float)$export_opening_value['quantity'];
					break;
					case '3':
					if(((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']) < 0){

						$arr_export_openings[$export_opening_value['commodity_id']]      += abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']);
					}
					break;
					case '4':

					$arr_export_openings[$export_opening_value['commodity_id']]      += (float)$export_opening_value['quantity'];

					break;

				}


			}else{
				switch ($export_opening_value['status']) {
					case '2':

					$arr_export_openings[$export_opening_value['commodity_id']]      = (float)$export_opening_value['quantity'];
					break;
					case '3':
					if(((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']) < 0){

						$arr_export_openings[$export_opening_value['commodity_id']]      = abs((float)$export_opening_value['quantity'] - (float)$export_opening_value['old_quantity']);
					}
					break;
					case '4':

					$arr_export_openings[$export_opening_value['commodity_id']]      = (float)$export_opening_value['quantity'];

					break;

				}

			}

		}

		//import_periods
		if (strlen($data['warehouse_id']) > 0) {
			$import_periods = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" AND '. $where_warehouse_id_with_internal_i)->result_array();

		}else{

			$import_periods = $this->db->query('SELECT commodity_id, quantity, status, old_quantity  FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 1 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '"')->result_array();
		}

		$arr_import_periods = [];
		foreach ($import_periods as $import_period_key => $import_period_value) {

			if(isset($arr_import_periods[$import_period_value['commodity_id']])){

				switch ($import_period_value['status']) {
					case '1':
					$arr_import_periods[$import_period_value['commodity_id']]      += (float)$import_period_value['quantity'];
					break;
					case '3':
					if(((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']) > 0){

						$arr_import_periods[$import_period_value['commodity_id']]      += ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']);
					}
					break;
					case '4':

					$arr_import_periods[$import_period_value['commodity_id']]      += (float)$import_period_value['quantity'];

					break;

				}


			}else{
				switch ($import_period_value['status']) {
					case '1':

					$arr_import_periods[$import_period_value['commodity_id']]      = (float)$import_period_value['quantity'];
					break;
					case '3':
					if(((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']) > 0){

						$arr_import_periods[$import_period_value['commodity_id']]      = ((float)$import_period_value['quantity'] - (float)$import_period_value['old_quantity']);
					}
					break;
					case '4':

					$arr_import_periods[$import_period_value['commodity_id']]      = (float)$import_period_value['quantity'];

					break;

				}


			}
		}

		//export_periods
		if (strlen($data['warehouse_id']) > 0) {
			$export_periods = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '" AND '.$where_warehouse_id_with_internal_e)->result_array();

		}else{

			$export_periods = $this->db->query('SELECT commodity_id, quantity, status, old_quantity FROM ' . db_prefix() . 'goods_transaction_detail
				where ( status = 2 OR status = 4 OR status = 3) AND "' . $from_date . '" <= date_format(date_add,"%Y-%m-%d") AND date_format(date_add,"%Y-%m-%d") <= "' . $to_date . '"')->result_array();
		}

		$arr_export_periods = [];
		foreach ($export_periods as $export_period_key => $export_period_value) {

			if(isset($arr_export_periods[$export_period_value['commodity_id']])){

				switch ($export_period_value['status']) {
					case '2':

					$arr_export_periods[$export_period_value['commodity_id']]      += (float)$export_period_value['quantity'];
					break;
					case '3':
					if(((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']) < 0){

						$arr_export_periods[$export_period_value['commodity_id']]      += abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']);
					}
					break;
					case '4':

					$arr_export_periods[$export_period_value['commodity_id']]      += (float)$export_period_value['quantity'];

					break;

				}



			}else{

				switch ($export_period_value['status']) {
					case '2':

					$arr_export_periods[$export_period_value['commodity_id']]      = (float)$export_period_value['quantity'];
					break;
					case '3':
					if(((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']) < 0){

						$arr_export_periods[$export_period_value['commodity_id']]      = abs((float)$export_period_value['quantity'] - (float)$export_period_value['old_quantity']);
					}
					break;
					case '4':

					$arr_export_periods[$export_period_value['commodity_id']]      = (float)$export_period_value['quantity'];

					break;

				}


			}

		}

		//html for page
		$html = '';
		$html .= ' <p><h3 class="bold align_cen">' . mb_strtoupper(_l('inventory_valuation_report')) . '</h3></p>

		<div class="col-md-12 pull-right">
		<div class="row">
		<div class="col-md-12 align_cen">
		<p>' . _l('from_date') . ' :  <span class="fstyle" >' . _l('days') . '  ' . date('d', strtotime($from_date)) . '  ' . _l('month') . '  ' . date('m', strtotime($from_date)) . '  ' . _l('year') . '  ' . date('Y', strtotime($from_date)) . '  ' . '</p>
		<p>' . _l('to_date') . ' :  <span class="fstyle">' . _l('days') . '  ' . date('d', strtotime($to_date)) . '  ' . _l('month') . '  ' . date('m', strtotime($to_date)) . '  ' . _l('year') . '  ' . date('Y', strtotime($to_date)) . '  ' . '</p>
		</div>
		</div>
		</div>

		<table class="table">';
		$company_name = get_option('invoice_company_name');
		$address = get_option('invoice_company_address');
		$total_opening_quatity = 0;
		$total_opening_amount = 0;
		$total_import_period_quatity = 0;
		$total_import_period_amount = 0;
		$total_export_period_quatity = 0;
		$total_export_period_amount = 0;
		$total_closing_quatity = 0;
		$total_closing_amount = 0;

		//rate
		$total_amount_sold = 0;
		$total_amount_purchased = 0;
		$total_expected_profit = 0;
		$total_sales_number = 0;
		//purchase

		$html .= '<tbody>
		<tr>
		<td class="bold width">' . _l('company_name') . '</td>
		<td>' . $company_name . '</td>
		</tr>
		<tr>
		<td class="bold">' . _l('address') . '</td>
		<td>' . $address . '</td>
		</tr>
		</tbody>
		</table>
		<div class="col-md-12">
		<table class="table table-bordered">
		<tbody>
		<tr>
		<th colspan="1" class="td_text">'. _l('_order').'</th>
		<th colspan="1" class="td_text">' . _l('commodity_code') . '</th>
		<th colspan="1" class="td_text">' . _l('commodity_name') . '</th>
		<th colspan="1" class="td_text">' . _l('unit_name') . '</th>

		<th colspan="1" class="td_text">' . _l('inventory_number') . '</th>
		<th colspan="1" class="td_text">' . _l('rate') . '</th>
		<th colspan="1" class="td_text">' . _l('purchase_price') . '</th>
		<th colspan="1" class="td_text">' . _l('amount_sold') . '</th>
		<th colspan="1" class="td_text">' . _l('amount_purchased') . '</th>
		<th colspan="1" class="td_text">' . _l('expected_profit') . '</th>

		</tr>';

		foreach ($commodity_lists as $commodity_list_key => $commodity_list) {

			$html .= '<tr>
			<td class="border_1">' . $commodity_list_key . '</td>
			<td class="border_1">' . $commodity_list['commodity_code'] . '</td>
			<td class="border_1">' . $commodity_list['commodity_name'] . '</td>
			<td class="border_1">' . $commodity_list['unit_name'] . '</td>';

			//sales
			$sales_number = 0;
			$export_period_quantity = isset($arr_export_periods[$commodity_list['commodity_id']]) ? $arr_export_periods[$commodity_list['commodity_id']] : 0;
			$sales_number = $export_period_quantity;
			$total_sales_number += (float) $export_period_quantity;

			//opening
			$stock_opening_quatity = 0;
			$stock_opening_amount = 0;

			$import_opening_quantity = isset($arr_import_openings[$commodity_list['commodity_id']]) ? $arr_import_openings[$commodity_list['commodity_id']] : 0;

			$export_opening_quantity = isset($arr_export_openings[$commodity_list['commodity_id']]) ? $arr_export_openings[$commodity_list['commodity_id']] : 0;

			$stock_opening_quatity = $import_opening_quantity - $export_opening_quantity;

			//import_period
			$import_period_quatity = 0;
			$import_period_amount = 0;

			$import_period_quantity = isset($arr_import_periods[$commodity_list['commodity_id']]) ? $arr_import_periods[$commodity_list['commodity_id']] : 0;

			$import_period_quatity = $import_period_quantity;

			//export_period
			$export_period_quatity = 0;
			$export_period_amount = 0;

			$export_period_quantity = isset($arr_export_periods[$commodity_list['commodity_id']]) ? $arr_export_periods[$commodity_list['commodity_id']] : 0;

			$export_period_quatity = $export_period_quantity;

			//closing
			$closing_quatity = 0;
			$expected_profit = 0;
			//eventory number
			$closing_quatity = (float) $stock_opening_quatity + (float) $import_period_quatity - (float) $export_period_quatity;
			//sale
			//
			$total_amount_sold += ((float) $closing_quatity * $commodity_list['rate']);
			$total_amount_purchased += ((float) $closing_quatity * $commodity_list['purchase_price']);
			$total_expected_profit += (((float) $closing_quatity * $commodity_list['rate']) - ((float) $closing_quatity * $commodity_list['purchase_price']));


			$total_closing_quatity += $closing_quatity;

			// Sell number

			$html .= '<td class="td_style_r">' . $closing_quatity . '</td>


			<td class="td_style_r">' . app_format_money((float)$commodity_list['rate'] , ''). '</td>
			<td class="td_style_r">' . app_format_money((float)$commodity_list['purchase_price'] , ''). '</td>
			<td class="td_style_r">' . app_format_money((float) ($closing_quatity * $commodity_list['rate']), '') . '</td>
			<td class="td_style_r">' . app_format_money((float) ($closing_quatity * $commodity_list['purchase_price']), '') . '</td>
			<td class="td_style_r">' . app_format_money((float) ((float) $closing_quatity * $commodity_list['rate'] - (float) $closing_quatity * $commodity_list['purchase_price']), '') . '</td>
			</tr>';
		}
		$html .= '<tr>
		<th colspan="4" class="td_text_r">' . _l('total') . ' : </th>
		<th colspan="1" class="td_text_r">' . $total_closing_quatity . '</th>


		<th colspan="1" class="td_text_r"></th>
		<th colspan="1" class="td_text_r"></th>

		<th colspan="1" class="td_text_r">' . app_format_money((float) ($total_amount_sold), '') . '</th>
		<th colspan="1" class="td_text_r">' . app_format_money((float) ($total_amount_purchased), '') . '</th>
		<th colspan="1" class="td_text_r">' . app_format_money((float) ($total_expected_profit), '') . '</th>
		</tr>
		</tbody>
		</table>
		</div>



		<br>
		<br>
		<br>
		<br>';

		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';

		return $html;

	}

	/**
	 * generate commodity barcode
	 *
	 * @return     string
	 */
	public function generate_commodity_barcode() {
		$item = false;
		do {
			$length = 11;
			$chars = '0123456789';
			$count = mb_strlen($chars);
			$password = '';
			for ($i = 0; $i < $length; $i++) {
				$index = rand(0, $count - 1);
				$password .= mb_substr($chars, $index, 1);
			}
			$this->db->where('commodity_barcode', $password);
			$item = $this->db->get(db_prefix() . 'items')->row();
		} while ($item);

		return $password;
	}

/**
 * delete goods receipt
 * @param  [integer] $id
 * @return [redirect]
 */
public function delete_goods_receipt($id) {
	$affected_rows = 0;

	$this->db->where('goods_receipt_id', $id);
	$this->db->delete(db_prefix() . 'goods_receipt_detail');
	if ($this->db->affected_rows() > 0) {

		$affected_rows++;
	}

	$this->db->where('id', $id);
	$this->db->delete(db_prefix() . 'goods_receipt');
	if ($this->db->affected_rows() > 0) {

		$affected_rows++;
	}

	if ($affected_rows > 0) {
		return true;
	}
	return false;
}

	/**
	 * delete goods delivery
	 * @param  [integer] $id
	 * @return [redirect]
	 */
	public function delete_goods_delivery($id) {
		$affected_rows = 0;

		$this->db->where('goods_delivery_id', $id);
		$this->db->delete(db_prefix() . 'goods_delivery_detail');
		if ($this->db->affected_rows() > 0) {

			$affected_rows++;
		}

		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'goods_delivery');
		if ($this->db->affected_rows() > 0) {

			$affected_rows++;
		}

		if ($affected_rows > 0) {
			return true;
		}
		return false;
	}

	/**
	 * check format date Y-m-d
	 *
	 * @param      String   $date   The date
	 *
	 * @return     boolean 
	 */
	public function check_format_date($date){
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
			return true;
		} else {
			return false;
		}
	}

	 /**
     * Gets the taxes.
     *
     * @return     <array>  The taxes.
     */
	 public function get_taxes()
	 {
	 	return $this->db->query('select id, name as label, taxrate from '.db_prefix().'taxes')->result_array();
	 }

    /**
     * get invoice by customer
     * @param  [type] $data 
     * @return array             
     */
    public function  get_invoices_by_customer($data)
    {

    	$this->db->where('clientid', $data);
    	$arr_invoice =  $this->db->get(db_prefix().'invoices')->result_array();
    	$options = '';
    	$options .= '<option value=""></option>';
    	foreach ($arr_invoice as $invoice) {

    		$options .= '<option value="' . $invoice['id'] . '">' . format_invoice_number($invoice['id']) . '</option>';
    	}
    	return $options;
    }

   	/**
     * Gets the taxes.
     *
     * @return     <array>  The taxes.
     */
   	public function get_taxe_value($id)
   	{
   		return $this->db->query('select id, name as label, taxrate from '.db_prefix().'taxes where id = '.$id)->row();
   	}

    /**
     * get goods delivery from invoice
     * @param  [integer] $invoice_id 
     * @return array             
     */
    public function  get_goods_delivery_from_invoice($invoice_id)
    {
    	$this->db->where('invoice_id', $invoice_id);
    	return $this->db->get(db_prefix() . 'goods_delivery')->result_array();
    }

    /**
     * get invoices
     * @param  boolean $id 
     * @return array      
     */
    public function  get_invoices($id = false)
    {

    	if (is_numeric($id)) {
    		$this->db->where('id', $id);

    		return $this->db->get(db_prefix() . 'invoices')->row();
    	}
    	if ($id == false) {
    		$arr_invoice = $this->get_invoices_goods_delivery('invoice');
    		return $this->db->query('select *, iv.id as id from '.db_prefix().'invoices as iv left join '.db_prefix().'projects as pj on pj.id = iv.project_id left join '.db_prefix().'clients as cl on cl.userid = iv.clientid  where iv.id NOT IN ("'.implode(", ", $arr_invoice).'") order by iv.id desc')->result_array();
    	}

    }


    /**
     * update goods delivery
     * @param [type]  $data 
     * @param boolean $id   
     */
    public function update_goods_delivery($data, $id = false) {


    	$check_appr = $this->get_approve_setting('2');
    	$data['approval'] = 0;
    	if ($check_appr && $check_appr != false) {
    		$data['approval'] = 0;
    	} else {
    		$data['approval'] = 1;
    	}

    	if (isset($data['hot_purchase'])) {
    		$hot_purchase = $data['hot_purchase'];
    		unset($data['hot_purchase']);
    	}

    	if(isset($data['edit_approval'])){
    		unset($data['edit_approval']);
    	}

    	if(isset($data['save_and_send_request']) ){
	    		$save_and_send_request = $data['save_and_send_request'];
	    		unset($data['save_and_send_request']);
    	}

    	if(!$this->check_format_date($data['date_c'])){
    		$data['date_c'] = to_sql_date($data['date_c']);
    	}else{
    		$data['date_c'] = $data['date_c'];
    	}


    	if(!$this->check_format_date($data['date_add'])){
    		$data['date_add'] = to_sql_date($data['date_add']);
    	}else{
    		$data['date_add'] = $data['date_add'];
    	}

    	$data['total_money'] 	= reformat_currency_j($data['total_money']);
    	$data['total_discount'] = reformat_currency_j($data['total_discount']);
    	$data['after_discount'] = reformat_currency_j($data['after_discount']);

    	$data['addedfrom'] = get_staff_user_id();

    	$goods_delivery_id = $data['id'];
    	unset($data['id']);

    	$this->db->where('id', $goods_delivery_id);
    	$this->db->update(db_prefix() . 'goods_delivery', $data);

    	$this->db->where('goods_delivery_id', $goods_delivery_id);
    	$this->db->delete(db_prefix().'goods_delivery_detail');


    	/*update googs delivery*/

    	if(isset($hot_purchase)){
    		$goods_delivery_detail = json_decode($hot_purchase);

    		$es_detail = [];
    		$row = [];
    		$rq_val = [];
    		$header = [];

    		$header[] = 'commodity_code';
    		$header[] = 'warehouse_id';
    		$header[] = 'available_quantity';
    		$header[] = 'unit_id';
    		$header[] = 'quantities';
    		$header[] = 'unit_price';
    		$header[] = 'tax_id';
    		$header[] = 'total_money';
    		$header[] = 'discount';
    		$header[] = 'discount_money';
    		$header[] = 'total_after_discount';
    		$header[] = 'guarantee_period';
    		$header[] = 'note';



    		foreach ($goods_delivery_detail as $key => $value) {

    			if($value[0] != ''){

	                	//case choose warehouse from select 
    				/*get available quantity for case choose warheouse from select*/
    				if($data['warehouse_id'] != ''){
    					$value[1] = $data['warehouse_id'];

    					$available_quantity = $this->get_quantity_inventory($data['warehouse_id'], $value[0]);

    					if($available_quantity){
    						$value[2] = $available_quantity->inventory_number;
    					}

    				}

    				/*check guarantee period*/

    				if(!$this->check_format_date($value[11])){
    					$value[11] = to_sql_date($value[11]);
    				}else{
    					$value[11] = $value[11];
    				}

    				$es_detail[] = array_combine($header, $value);

    			}
    		}
    	}

    	$results=0;
    	if (isset($goods_delivery_id)) {

    		/*insert detail*/
    		foreach($es_detail as $key => $rqd){

    			$es_detail[$key]['goods_delivery_id'] = $goods_delivery_id;

    		}

    		$this->db->insert_batch(db_prefix().'goods_delivery_detail',$es_detail);
    		if($this->db->affected_rows() > 0){
    			$results++;
    		}



    	}

			//send request approval
    	if($save_and_send_request == 'true'){
    		/*check send request with type =2 , inventory delivery voucher*/
    		$check_r = $this->check_inventory_delivery_voucher(['rel_id' => $goods_delivery_id, 'rel_type' => '2']);

    		if($check_r['flag_export_warehouse'] == 1){
    			$this->send_request_approve(['rel_id' => $goods_delivery_id, 'rel_type' => '2', 'addedfrom' => $data['addedfrom']]);

    		}
    	}


		//approval if not approval setting
    	if (isset($goods_delivery_id)) {
    		if ($data['approval'] == 1) {
    			$this->update_approve_request($goods_delivery_id, 2, 1);
    		}
    	}

    	return $results > 0 ? true : false;

    }


	/**
	 * update goods receipt
	 * @param  array  $data 
	 * @param  boolean $id   
	 * @return [type]        
	 */
	public function update_goods_receipt($data, $id = false) {



		$check_appr = $this->get_approve_setting('1');

		/*get suppier name from supplier code*/
		if (get_status_modules_wh('purchase')) {
			if($data['supplier_code'] != ''){
				$this->load->model('purchase/purchase_model');
				$client                = $this->purchase_model->get_vendor($id);
				if(count($client) > 0 ){
					$data['supplier_name'] = $client[0]['company'];
				}

			}
		}

		$data['approval'] = 0;
		if ($check_appr && $check_appr != false) {
			$data['approval'] = 0;
		} else {
			$data['approval'] = 1;
		}

		if(isset($data['save_and_send_request'])){
			$save_and_send_request = $data['save_and_send_request'];
			unset($data['save_and_send_request']);
		}



		if (isset($data['hot_purchase'])) {
			$hot_purchase = $data['hot_purchase'];
			unset($data['hot_purchase']);
		}

		
		if(!$this->check_format_date($data['date_c'])){
			$data['date_c'] = to_sql_date($data['date_c']);
		}else{
			$data['date_c'] = $data['date_c'];
		}
		
		if(!$this->check_format_date($data['date_add'])){
			$data['date_add'] = to_sql_date($data['date_add']);
		}else{
			$data['date_add'] = $data['date_add'];
		}

		if(isset($data['expiry_date'])){
			if(!$this->check_format_date($data['expiry_date'])){
				$data['expiry_date'] = to_sql_date($data['expiry_date']);
			}else{
				$data['expiry_date'] = $data['expiry_date'];
			}
		}


		$data['addedfrom'] = get_staff_user_id();

		$data['total_tax_money'] = reformat_currency_j($data['total_tax_money']);

		$data['total_goods_money'] = reformat_currency_j($data['total_goods_money']);
		$data['value_of_inventory'] = reformat_currency_j($data['value_of_inventory']);

		$data['total_money'] = reformat_currency_j($data['total_money']);

		$goods_receipt_id = $data['id'];
		unset($data['id']);

		$results = 0;

		$this->db->where('id', $goods_receipt_id);
		$this->db->update(db_prefix() . 'goods_receipt', $data);
		if ($this->db->affected_rows() > 0) {
			$results++;
		}

		$this->db->where('goods_receipt_id', $goods_receipt_id);
		$this->db->delete(db_prefix().'goods_receipt_detail');

		/*update save note*/

		if(isset($hot_purchase)){
			$goods_receipt_detail = json_decode($hot_purchase);

			$es_detail = [];
			$row = [];
			$rq_val = [];
			$header = [];

			$header[] = 'commodity_code';
			$header[] = 'warehouse_id';
			$header[] = 'unit_id';
			$header[] = 'quantities';
			$header[] = 'unit_price';
			$header[] = 'tax';
			$header[] = 'goods_money';
			$header[] = 'tax_money';
			$header[] = 'discount';
			$header[] = 'discount_money';
			$header[] = 'lot_number';
			$header[] = 'date_manufacture';
			$header[] = 'expiry_date';
			$header[] = 'note';


			foreach ($goods_receipt_detail as $key => $value) {

				if($value[0] != ''){

	                	//case choose warehouse from select 
					if($data['warehouse_id'] != ''){
						$value[1] = $data['warehouse_id'];
					}

					/*check lotnumber*/
					$lot_number_value = trim($value[10]," ");
					if(isset($lot_number_value) && $lot_number_value != '0'){
						$value[10] = $lot_number_value;

					}else{
						$value[10] = '';
					}

					/*check date manufacture*/
					if(!$this->check_format_date($value[11])){
						$value[11] = to_sql_date($value[11]);
					}else{
						$value[11] = $value[11];
					}

					/*check expiry date*/
					if(!$this->check_format_date($value[12])){
						$value[12] = to_sql_date($value[12]);
					}else{
						$value[12] = $value[12];
					}


					$es_detail[] = array_combine($header, $value);
				}
			}
		}


		if (isset($goods_receipt_id)) {

			/*insert detail*/
			foreach($es_detail as $key => $rqd){

				$es_detail[$key]['goods_receipt_id'] = $goods_receipt_id;

			}

			$this->db->insert_batch(db_prefix().'goods_receipt_detail',$es_detail);
			if($this->db->affected_rows() > 0){
				$results++;
			}

	            //send request approval
			if($save_and_send_request == 'true'){

				$this->send_request_approve(['rel_id' => $goods_receipt_id, 'rel_type' => '1', 'addedfrom' => $data['addedfrom']]);

			}



		}


		//approval if not approval setting
		if (isset($goods_receipt_id)) {
			if ($data['approval'] == 1) {
				$this->update_approve_request($goods_receipt_id, 1, 1);
			}
		}

		return $results > 0 ? $goods_receipt_id : false;

	}

	/**
	 * get commodity in_warehouse
	 * @param  array $warehouse 
	 * @return array            
	 */
	public function get_commodity_in_warehouse($warehouse){

		$array_commodity=[];
		$index=0;
		foreach ($warehouse as $warehouse_id) {
			$sql ='SELECT distinct commodity_id FROM '.db_prefix().'inventory_manage where warehouse_id = "'.$warehouse_id.'"';
			$array_data = $this->db->query($sql)->result_array();

			if(count($array_data)>0){
				foreach ($array_data as $c_key => $commodity_id) {
					if(!in_array($commodity_id['commodity_id'], $array_commodity)){
						$array_commodity[$index] = $commodity_id['commodity_id'];
						$index++;

					}
				}
			}

		}
		return $array_commodity;

	}

	/**
	 * get commodity alert
	 * @param  integer $status 
	 * @return array         
	 */
	public function get_commodity_alert($status){
		$array_commodity=[];
		$index=0;

		if($status == 1 ){
			/*1 : out of stock, 3: minmumstock, 4:maximum stock*/
			$sql ='SELECT commodity_id,  sum(inventory_number) as inventory_number FROM '.db_prefix().'inventory_manage group by commodity_id';
		}elseif($status == 2){
			/*2 : expired*/
			$sql ='SELECT commodity_id,  sum(inventory_number) as inventory_number, commodity_id, warehouse_id, expiry_date FROM '.db_prefix().'inventory_manage group by commodity_id, warehouse_id, expiry_date order by tblinventory_manage.commodity_id asc';
		}else{
			/*3: minmumstock, 4:maximum stock*/
			$sql ='SELECT commodity_id,  sum(inventory_number) as inventory_number, commodity_id, warehouse_id FROM '.db_prefix().'inventory_manage group by commodity_id, warehouse_id order by tblinventory_manage.commodity_id asc';
		}

		$array_data = $this->db->query($sql)->result_array();

		if(count($array_data)>0){
			foreach ($array_data as $c_key => $commodity_id) {
				if($status == 1){
					if($commodity_id['inventory_number'] == 0){
						if(!in_array($commodity_id['commodity_id'], $array_commodity)){
							$array_commodity[$index] = $commodity_id['commodity_id'];
							$index++;

						}
					}
				}elseif($status == 2){
					/*2 : expired*/
					if($commodity_id['expiry_date'] != null && $commodity_id['expiry_date'] != ''){
						if(!in_array($commodity_id['commodity_id'], $array_commodity)){

							$datediff  = strtotime($commodity_id['expiry_date']) - strtotime(date('Y-m-d'));
							$days_diff = floor($datediff / (60 * 60 * 24));

							if ($days_diff <= 30) {
								$array_commodity[$index] = $commodity_id['commodity_id'];
								$index++;

							}
						}

					}


				}elseif($status == 3){
					/*3: minmumstock*/
					$inventory_min = $this->get_inventory_min($commodity_id['commodity_id']);
					if($inventory_min){
						if($inventory_min->inventory_number_min >= $commodity_id['inventory_number']){
							if(!in_array($commodity_id['commodity_id'], $array_commodity)){
								$array_commodity[$index] = $commodity_id['commodity_id'];
								$index++;
							}
						}
					}

				}else{
					/*4: maximumstock*/
					$inventory_max = $this->get_inventory_min($commodity_id['commodity_id']);
					if($inventory_max){
						if($inventory_max->inventory_number_max <= $commodity_id['inventory_number']){
							if(!in_array($commodity_id['commodity_id'], $array_commodity)){
								$array_commodity[$index] = $commodity_id['commodity_id'];
								$index++;
							}
						}
					}

				}

			}
		}
		return $array_commodity;

	}


	/**
	 * get inventory by commodity
	 * @param  integer $commodity_id 
	 * @return object               
	 */
	public function get_inventory_by_commodity($commodity_id){

		$sql = 'SELECT sum(inventory_number) as inventory_number FROM ' . db_prefix() . 'inventory_manage
		where ' . db_prefix() . 'inventory_manage.commodity_id = ' . $commodity_id . ' group by ' . db_prefix() . 'inventory_manage.commodity_id';
		$data = $this->db->query($sql)->row(); 
		return $data;


	}

	/**
	 * check inventory min
	 * @param  integer $commodity_id 
	 * @return boolean               
	 */
	public function check_inventory_min($commodity_id)
	{	
		$status=true;
		$inventory_min=0;
		$this->db->where('commodity_id', $commodity_id);
		$result = $this->db->get(db_prefix() . 'inventory_commodity_min')->row();
		if($result){
			$inventory_min = $result->inventory_number_min;
		}

		$sql = 'SELECT sum(inventory_number) as inventory_number FROM ' . db_prefix() . 'inventory_manage
		where ' . db_prefix() . 'inventory_manage.commodity_id = ' . $commodity_id . ' group by ' . db_prefix() . 'inventory_manage.warehouse_id';

		$data = $this->db->query($sql)->result_array(); 
		if(count($data) > 0){
			foreach ($data as $key => $value) {
				if($value['inventory_number'] <= $inventory_min){
					$status = false;
				}
			}
		}

		return $status;
	}

	/**
	 * get item group
	 * @return array 
	 */
	public function get_item_group() {
		return $this->db->query('select id as id, CONCAT(name,"_",commodity_group_code) as label from ' . db_prefix() . 'items_groups')->result_array();
	}

	/**
	 * list subgroup by group
	 * @param  integer $group 
	 * @return string        
	 */
	public function list_subgroup_by_group($group)
	{
		$this->db->where('group_id', $group);
		$arr_subgroup = $this->db->get(db_prefix().'wh_sub_group')->result_array();

		$options = '';
		if(count($arr_subgroup) > 0){
			foreach ($arr_subgroup as $value) {

				$options .= '<option value="' . $value['id'] . '">' . $value['sub_group_name'] . '</option>';
			}

		}
		return $options;

	}


	/**
	 * update warehouse selling price profif ratio
	 * @param  array $data 
	 * @return boolean       
	 */
	public function update_warehouse_selling_price_profif_ratio($data)
	{

		$this->db->where('name','warehouse_selling_price_rule_profif_ratio');
		$this->db->update(db_prefix() . 'options', [
			'value' => $data['warehouse_selling_price_rule_profif_ratio'],
		]);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * update profit rate by purchase price sale
	 * @param  array $data 
	 * @return boolean       
	 */
	public function update_profit_rate_by_purchase_price_sale($data)
	{

		$this->db->where('name','profit_rate_by_purchase_price_sale');
		$this->db->update(db_prefix() . 'options', [
			'value' => $data['profit_rate_by_purchase_price_sale'],
		]);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

    /**
     * update rules for rounding prices
     * @param  array $data 
     * @return boolean       
     */
    public function update_rules_for_rounding_prices($data)
    {

    	if($data['type'] == 'warehouse_integer_part'){
    		$this->db->where('name','warehouse_the_fractional_part');
    		$this->db->update(db_prefix() . 'options', [
    			'value' => (int)0,
    		]);

    	}else{
    		$this->db->where('name','warehouse_integer_part');
    		$this->db->update(db_prefix() . 'options', [
    			'value' => (int)0,
    		]);
    	}

    	$this->db->where('name',$data['type']);
    	$this->db->update(db_prefix() . 'options', [
    		'value' => (int)$data['input_value'],
    	]);
    	if ($this->db->affected_rows() > 0) {
    		return true;
    	}else{
    		return false;
    	}
    }

	/**
	 * get average price inventory
	 * @param  integer $commodity_id     
	 * @param  integer $sale_price       
	 * @param  integer $profif_ratio_old 
	 * @return array                   
	 */
	public function get_average_price_inventory($commodity_id, $sale_price, $profif_ratio_old, $warehouse_filter='')
	{	

		$average_price_of_inventory=0;	// purchase price
		$quantity=0;
		$total_money=0;
		$profit_rate_actual=0;
		$trade_discounts=0;

		$item = false;

		/*type : 0 purchase price, 1: sale price*/
		$profit_type = get_warehouse_option('profit_rate_by_purchase_price_sale');

		/*update filter by warehouse*/
		if(is_array($warehouse_filter)){
			$str_warehouse = implode(',', $warehouse_filter);

			$where_staff ='find_in_set(warehouse_id, "'.$str_warehouse.'")';
			$this->db->where($where_staff);

		}

		$this->db->where('commodity_id', $commodity_id);
		$this->db->where('inventory_number !=', '0');
		$arr_inventory = $this->db->get(db_prefix().'inventory_manage')->result_array();


		if(count($arr_inventory) > 0){
			foreach ($arr_inventory as $inventory_value) {
				$this->db->where('expiry_date', $inventory_value['expiry_date']);
				$this->db->where('lot_number', $inventory_value['lot_number']);
				$this->db->where('status', '1');
				$this->db->where('commodity_id', $commodity_id);
				$commodity_import = $this->db->get(db_prefix().'goods_transaction_detail')->row();

				if(isset($commodity_import)){

					$quantity 	 += (float)$inventory_value['inventory_number'];
					$total_money += (float)$commodity_import->purchase_price *(float)$inventory_value['inventory_number'];
				}
			}
			$item =  true;
		}

		if($quantity != 0){
			$average_price_of_inventory = (float)$total_money/(float)$quantity;
		}

		if($average_price_of_inventory != 0){
			/*caculator profit rate*/
			switch ($profit_type) {
				case '0':
	    			# Calculate the selling price based on the purchase price rate of profit
	    			# sale price = purchase price * ( 1 + profit rate)
				$profit_rate_actual = (((float)$sale_price/(float)$average_price_of_inventory)-(float)1)*100;

				break;

				case '1':

	    			# Calculate the selling price based on the selling price rate of profit
	    			# sale price = purchase price / ( 1 - profit rate)

				$profit_rate_actual = ((float)1 -((float)$average_price_of_inventory/(float)$sale_price))*100;

				break;

			}

		}

		if( ($profif_ratio_old !='') && ($profif_ratio_old != '0') && ($profif_ratio_old != 'null') ){
			$trade_discounts = (((float)$profit_rate_actual - (float)$profif_ratio_old)/(float)$profif_ratio_old)*100;
		}

		$data=[];
		$data['average_price_of_inventory'] = $average_price_of_inventory;
		$data['profit_rate_actual'] = $profit_rate_actual;
		$data['trade_discounts'] = $trade_discounts;
		$data['item'] = $item;

		return $data;
	}


	 /**
     * { update purchase setting }
     *
     * @param      <type>   $data   The data
     *
     * @return     boolean 
     */
	 public function update_auto_create_received_delivery_setting($data)
	 {

	 	$val = $data['input_name_status'] == 'true' ? 1 : 0;

	 	$this->db->where('name',$data['input_name']);
	 	$this->db->update(db_prefix() . 'options', [
	 		'value' => $val,
	 	]);
	 	if ($this->db->affected_rows() > 0) {
	 		return true;
	 	}else{
	 		return false;
	 	}
	 }

    /**
     * auto create goods receipt with purchase order
     * @param  array $data 
     *      
     */
    public function auto_create_goods_receipt_with_purchase_order($data)
    {
    	$this->load->model('clients_model');

    	$arr_pur_resquest = [];
    	$total_goods_money = 0;
    	$total_money = 0;
    	$total_tax_money = 0;
    	$value_of_inventory = 0;

    	$sql = 'select item_code as commodity_code, ' . db_prefix() . 'items.description, ' . db_prefix() . 'items.unit_id, unit_price, quantity as quantities, ' . db_prefix() . 'pur_order_detail.tax as tax, into_money, (' . db_prefix() . 'pur_order_detail.total-' . db_prefix() . 'pur_order_detail.into_money) as tax_money, total as goods_money from ' . db_prefix() . 'pur_order_detail
    	left join ' . db_prefix() . 'items on ' . db_prefix() . 'pur_order_detail.item_code =  ' . db_prefix() . 'items.id
    	left join ' . db_prefix() . 'taxes on ' . db_prefix() . 'taxes.id = ' . db_prefix() . 'pur_order_detail.tax where ' . db_prefix() . 'pur_order_detail.pur_order = ' . $data['id'];
    	$results = $this->db->query($sql)->result_array();

    	foreach ($results as $key => $value) {
    		$total_goods_money += $value['into_money'];
    		$total_tax_money += $value['tax_money'];

    	}

    	$total_money = $total_goods_money + $total_tax_money;
    	$value_of_inventory = $total_goods_money;

    	/*get purchase order*/
    	$this->db->where('id', $data['id']);
    	$purchase_order = $this->db->get(db_prefix().'pur_orders')->row();

    	$arr_pur_resquest['date_c']			= '';
    	$arr_pur_resquest['date_add']		= '';
    	$arr_pur_resquest['supplier_name']	= '';
    	$arr_pur_resquest['buyer_id']		= '';
    	$arr_pur_resquest['pr_order_id']	= $data['id'];
    	$arr_pur_resquest['description']	= '';
    	$arr_pur_resquest['addedfrom']	= '';

    	if($purchase_order){

    		$supplier_name = $this->clients_model->get($purchase_order->vendor);

    		$arr_pur_resquest['date_c']			= $purchase_order->order_date;
    		$arr_pur_resquest['date_add']		= $purchase_order->delivery_date;
    		$arr_pur_resquest['supplier_name']	= isset($supplier_name) ? $supplier_name->company: '';
    		$arr_pur_resquest['buyer_id']		= $purchase_order->buyer;
    		$arr_pur_resquest['pr_order_id']	= $data['id'];
    		$arr_pur_resquest['description']	= $purchase_order->vendornote;
    		$arr_pur_resquest['addedfrom']	= $purchase_order->addedfrom;
    	}

    	$arr_pur_resquest['goods_receipt_detail'] = $results;
    	$arr_pur_resquest['total_tax_money'] = $total_tax_money;
    	$arr_pur_resquest['total_goods_money'] = $total_goods_money;
    	$arr_pur_resquest['value_of_inventory'] = $value_of_inventory;
    	$arr_pur_resquest['total_money'] = $total_money;
    	$arr_pur_resquest['total_results'] = count($results);

    	$status = $this->add_goods_receipt_from_purchase_order($arr_pur_resquest);

    	return $status;

    	
    }


    /**
     * update goods receipt warehouse
     * @param  array $data 
     * @return boolean       
     */
    public function update_goods_receipt_warehouse($data)
    {

    	$this->db->where('name',$data['input_name']);
    	$this->db->update(db_prefix() . 'options', [
    		'value' => $data['input_name_status'],
    	]);
    	if ($this->db->affected_rows() > 0) {
    		return true;
    	}else{
    		return false;
    	}
    }

    public function add_goods_receipt_from_purchase_order($data_insert)
    {
    	
    	$warehouse_id =  get_warehouse_option('auto_create_goods_received');

    	$data['approval'] = 1;

    	if (isset($data['hot_purchase'])) {
    		$hot_purchase = $data['hot_purchase'];
    		unset($data['hot_purchase']);
    	}

    	$data['goods_receipt_code'] = $this->create_goods_code();

    	if(!$this->check_format_date($data_insert['date_c'])){
    		$data['date_c'] = to_sql_date($data_insert['date_c']);
    	}else{
    		$data['date_c'] = $data_insert['date_c'];
    	}

    	if(!$this->check_format_date($data_insert['date_add'])){
    		$data['date_add'] = to_sql_date($data_insert['date_add']);
    	}else{
    		$data['date_add'] = $data_insert['date_add'];
    	}

    	$data['addedfrom'] =  $data_insert['addedfrom'];

    	$data['total_tax_money'] = reformat_currency_j($data_insert['total_tax_money']);

    	$data['total_goods_money'] = reformat_currency_j($data_insert['total_goods_money']);
    	$data['value_of_inventory'] = reformat_currency_j($data_insert['value_of_inventory']);

    	$data['total_money'] = reformat_currency_j($data_insert['total_money']);
    	$data['supplier_name'] = $data_insert['supplier_name'];
    	$data['buyer_id'] = $data_insert['buyer_id'];
    	$data['pr_order_id'] = $data_insert['pr_order_id'];
    	$data['description'] = $data_insert['description'];


    	$this->db->insert(db_prefix() . 'goods_receipt', $data);
    	$insert_id = $this->db->insert_id();

    	$results=0;

    	if (isset($insert_id) && (count($data_insert['goods_receipt_detail']) > 0) ) {

    		foreach ($data_insert['goods_receipt_detail'] as $purchase_key => $purchase_value) {
    			if(isset($purchase_value['description'])){
    				unset($purchase_value['description']);
    			}
    			if(isset($purchase_value['into_money'])){
    				unset($purchase_value['into_money']);
    			}

    			$purchase_value['warehouse_id'] = $warehouse_id;
    			$purchase_value['goods_receipt_id'] = $insert_id;

    			$this->db->insert(db_prefix() . 'goods_receipt_detail', $purchase_value);
    			$insert_detail = $this->db->insert_id();

    			$results++;

    		}

    		$data_log = [];
    		$data_log['rel_id'] = $insert_id;
    		$data_log['rel_type'] = 'stock_import';
    		$data_log['staffid'] = get_staff_user_id();
    		$data_log['date'] = date('Y-m-d H:i:s');
    		$data_log['note'] = "stock_import";

    		$this->add_activity_log($data_log);

    	}

    	if(isset($insert_id)){
    		/*update next number setting*/
    		$this->update_inventory_setting(['next_inventory_received_mumber' =>  get_warehouse_option('next_inventory_received_mumber')+1]);
    	}

		//approval if not approval setting
    	if (isset($insert_id)) {
    		if ($data['approval'] == 1) {
    			$this->update_approve_request($insert_id, 1, 1);
    		}
    	}

    	return $results > 0 ? true : false;


    }


    /**
     * get itemid from name
     * @param  string $name 
     * @return integer       
     */
    public function get_itemid_from_name($name)
    {	
    	$item_id=0;

    	$this->db->where('description', $name);
    	$item_value = $this->db->get(db_prefix().'items')->row();

    	if($item_value){
    		$item_id = $item_value->id;
    	}

    	return $item_id;

    }


    /**
     * get tax id from taxname taxrate
     * @param  string $taxname 
     * @param  string $taxrate 
     * @return integer          
     */
    public function get_tax_id_from_taxname_taxrate($taxname, $taxrate)
    {	$tax_id = 0;
    	$this->db->where('name', $taxname);
    	$this->db->where('taxrate', $taxrate);

    	$tax_value = $this->db->get(db_prefix().'taxes')->row();

    	if($tax_value){
    		$tax_id = $tax_value->id;
    	}
    	return $tax_id;
    }



    /**
     * auto_create_goods_delivery_with_invoice
     * @param  integer $invoice_id 
     *              
     */
    public function auto_create_goods_delivery_with_invoice($invoice_id, $invoice_update='')
    {

    	$this->db->where('id', $invoice_id);
    	$invoice_value = $this->db->get(db_prefix().'invoices')->row();

    	if($invoice_value){

    		/*get value for goods delivery*/

    		$data['goods_delivery_code'] = $this->create_goods_delivery_code();

    		if(!$this->check_format_date($invoice_value->date)){
    			$data['date_c'] = to_sql_date($invoice_value->date);
    		}else{
    			$data['date_c'] = $invoice_value->date;
    		}


    		if(!$this->check_format_date($invoice_value->date)){
    			$data['date_add'] = to_sql_date($invoice_value->date);

    		}else{
    			$data['date_add'] = $invoice_value->date;
    		}

    		$data['customer_code'] 	= $invoice_value->clientid;
    		$data['invoice_id'] 	= $invoice_id;
    		$data['addedfrom'] 	= $invoice_value->addedfrom;
    		$data['description'] 	= $invoice_value->adminnote;
    		$data['address'] 	= $this->get_shipping_address_from_invoice($invoice_id);

    		$data['total_money'] 	= (float)$invoice_value->subtotal + (float)$invoice_value->total_tax;
    		$data['total_discount'] = $invoice_value->discount_total;
    		$data['after_discount'] = $invoice_value->total;

    		/*get data for goods delivery detail*/
    		/*get item in invoices*/
    		$this->db->where('rel_id', $invoice_id);
    		$this->db->where('rel_type', 'invoice');
    		$arr_itemable = $this->db->get(db_prefix().'itemable')->result_array();

    		$arr_item_insert=[];
    		$index=0;

    		if(count($arr_itemable) > 0){
    			foreach ($arr_itemable as $key => $value) {
    				$commodity_code = $this->get_itemid_from_name($value['description']);
					//get_unit_id
    				$unit_id = $this->get_unitid_from_commodity_name($value['description']);
					//get warranty
    				$warranty = $this->get_warranty_from_commodity_name($value['description']);

    				if($commodity_code != 0){
    					/*get item from name*/
    					$arr_item_insert[$index]['commodity_code'] = $commodity_code;
    					$arr_item_insert[$index]['quantities'] = $value['qty'] + 0;
    					$arr_item_insert[$index]['unit_price'] = $value['rate'] + 0;
    					$arr_item_insert[$index]['tax_id'] = '';
    					$arr_item_insert[$index]['unit_id'] = $unit_id;
    					$arr_item_insert[$index]['guarantee_period'] = $warranty;

    					$arr_item_insert[$index]['total_money'] = (float)$value['qty']*(float)$value['rate'];
    					$arr_item_insert[$index]['total_after_discount'] = (float)$value['qty']*(float)$value['rate'];

    					/*update after : goods_delivery_id, warehouse_id*/

    					/*get tax item*/
    					$this->db->where('itemid', $value['id']);
    					$this->db->where('rel_id', $invoice_id);
    					$this->db->where('rel_type', "invoice");

    					$item_tax = $this->db->get(db_prefix().'item_tax')->result_array();

    					if(count($item_tax) > 0){
    						foreach ($item_tax as $tax_value) {
    							$tax_id = $this->get_tax_id_from_taxname_taxrate($tax_value['taxname'], $tax_value['taxrate']);

    							if($tax_id != 0){
    								if(strlen($arr_item_insert[$index]['tax_id']) != ''){
    									$arr_item_insert[$index]['tax_id'] .= '|'.$tax_id;
    								}else{
    									$arr_item_insert[$index]['tax_id'] .= $tax_id;

    								}
    							}


    							$arr_item_insert[$index]['total_money'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;

    							$arr_item_insert[$index]['total_after_discount'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;

    						}
    					}

    					$index++;
    				}


    			}
    		}

    		$data_insert=[];

    		$data_insert['goods_delivery'] = $data;
    		$data_insert['goods_delivery_detail'] = $arr_item_insert;

    		if($invoice_update != ''){
				//case invoice update
    			$status = $this->add_goods_delivery_from_invoice_update($invoice_id, $data_insert);

    		}else{
				//case invoice add
    			$status = $this->add_goods_delivery_from_invoice($data_insert, $invoice_id);

    		}

    		if($status){
    			return true;
    		}else{
    			return false;
    		}

    	}

    	return false;

    }


    /**
     * add goods delivery from invoice
     * @param array $data_insert 
     */
    public function add_goods_delivery_from_invoice($data_insert, $invoice_id ='')
    {
    	$results=0;
    	$flag_export_warehouse = 1;


    	$this->db->insert(db_prefix() . 'goods_delivery', $data_insert['goods_delivery']);
    	$insert_id = $this->db->insert_id();


    	if (isset($insert_id)) {

    		foreach ($data_insert['goods_delivery_detail'] as $delivery_detail_key => $delivery_detail_value) {
    			/*check export warehouse*/

				//checking Do not save the quantity of inventory with item
    			if($this->check_item_without_checking_warehouse($delivery_detail_value['commodity_code']) == true){

    				$inventory = $this->get_inventory_by_commodity($delivery_detail_value['commodity_code']);

    				if($inventory){
    					$inventory_number =  $inventory->inventory_number;

    					if((float)$inventory_number < (float)$delivery_detail_value['quantities'] ){
    						$flag_export_warehouse = 0;
    					}

    				}else{
    					$flag_export_warehouse = 0;
    				}

    			}


    			$delivery_detail_value['goods_delivery_id'] = $insert_id;
    			$this->db->insert(db_prefix() . 'goods_delivery_detail', $delivery_detail_value);
    			$insert_detail = $this->db->insert_id();

    			$results++;

    		}

    		$data_log = [];
    		$data_log['rel_id'] = $insert_id;
    		$data_log['rel_type'] = 'stock_export';
    		$data_log['staffid'] = get_staff_user_id();
    		$data_log['date'] = date('Y-m-d H:i:s');
    		$data_log['note'] = "stock_export";

    		$this->add_activity_log($data_log);

    		/*update next number setting*/
    		$this->update_inventory_setting(['next_inventory_delivery_mumber' =>  get_warehouse_option('next_inventory_delivery_mumber')+1]);



    	}


		//check inventory warehouse => export warehouse
    	if($flag_export_warehouse == 1){
			//update approval
    		$data_update['approval'] = 1;
    		$this->db->where('id', $insert_id);
    		$this->db->update(db_prefix() . 'goods_delivery', $data_update);

			//update log for table goods_delivery_invoices_pr_orders
    		$this->db->insert(db_prefix() . 'goods_delivery_invoices_pr_orders', [
    			"rel_id" => $insert_id,
    			"rel_type" => $invoice_id,
    			"type" => 'invoice',
    		]);

			//update history stock, inventoty manage after staff approved
    		$goods_delivery_detail = $this->get_goods_delivery_detail($insert_id);

    		foreach ($goods_delivery_detail as $goods_delivery_detail_value) {
				// add goods transaction detail (log) after update invetory number
				// 
				// check Without checking warehouse

    			if($this->check_item_without_checking_warehouse($goods_delivery_detail_value['commodity_code']) == true){
    				$this->add_inventory_from_invoices($goods_delivery_detail_value);
    			}

    		}
    	}


    	return $results > 0 ? true : false;


    }


    /**
     * add inventory from invoices
     * @param array $data 
     */
    public function add_inventory_from_invoices($data)
    {		

    	$available_quantity_n =0;

    	$available_quantity = $this->get_inventory_by_commodity($data['commodity_code']);
    	if($available_quantity){
    		$available_quantity_n = $available_quantity->inventory_number;
    	}


    	$data['warehouse_id']='';
    		//status == 2 export
			//update
    	$this->db->where('commodity_id', $data['commodity_code']);
    	$this->db->order_by('id', 'ASC');

    	$result = $this->db->get('tblinventory_manage')->result_array();

    	$temp_quantities = $data['quantities'];

    	$expiry_date = '';
    	$lot_number = '';
    	foreach ($result as $result_value) {
    		if (($result_value['inventory_number'] != 0) && ($temp_quantities != 0)) {

    			if ($temp_quantities >= $result_value['inventory_number']) {
    				$temp_quantities = (float) $temp_quantities - (float) $result_value['inventory_number'];

						//log lot number
    				if(($result_value['lot_number'] != null) && ($result_value['lot_number'] != '') ){
    					if(strlen($lot_number) != 0){
    						$lot_number .=','.$result_value['lot_number'].','.$result_value['inventory_number'];
    					}else{
    						$lot_number .= $result_value['lot_number'].','.$result_value['inventory_number'];
    					}
    				}

						//log expiry date
    				if(($result_value['expiry_date'] != null) && ($result_value['expiry_date'] != '') ){
    					if(strlen($expiry_date) != 0){
    						$expiry_date .=','.$result_value['expiry_date'].','.$result_value['inventory_number'];
    					}else{
    						$expiry_date .= $result_value['expiry_date'].','.$result_value['inventory_number'];
    					}
    				}

						//update inventory
    				$this->db->where('id', $result_value['id']);
    				$this->db->update(db_prefix() . 'inventory_manage', [
    					'inventory_number' => 0,
    				]);

						//add warehouse id get from inventory manage
    				if(strlen($data['warehouse_id']) != 0){
    					$data['warehouse_id'] .= ','.$result_value['warehouse_id'];
    				}else{
    					$data['warehouse_id'] .= $result_value['warehouse_id'];

    				}

    			} else {

						//log lot number
    				if(($result_value['lot_number'] != null) && ($result_value['lot_number'] != '') ){
    					if(strlen($lot_number) != 0){
    						$lot_number .=','.$result_value['lot_number'].','.$temp_quantities;
    					}else{
    						$lot_number .= $result_value['lot_number'].','.$temp_quantities;
    					}
    				}

						//log expiry date
    				if(($result_value['expiry_date'] != null) && ($result_value['expiry_date'] != '') ){
    					if(strlen($expiry_date) != 0){
    						$expiry_date .=','.$result_value['expiry_date'].','.$temp_quantities;
    					}else{
    						$expiry_date .= $result_value['expiry_date'].','.$temp_quantities;
    					}
    				}


						//update inventory
    				$this->db->where('id', $result_value['id']);
    				$this->db->update(db_prefix() . 'inventory_manage', [
    					'inventory_number' => (float) $result_value['inventory_number'] - (float) $temp_quantities,
    				]);

						//add warehouse id get from inventory manage
    				if(strlen($data['warehouse_id']) != 0){
    					$data['warehouse_id'] .= ','.$result_value['warehouse_id'];
    				}else{
    					$data['warehouse_id'] .= $result_value['warehouse_id'];

    				}

    				$temp_quantities = 0;

    			}

    		}

    	}

			//update good delivery detail
    	$this->db->where('id', $data['id']);
    	$this->db->update(db_prefix() . 'goods_delivery_detail', [
    		'expiry_date' => $expiry_date,
    		'lot_number' => $lot_number,
    		'warehouse_id' => $data['warehouse_id'],
    		'available_quantity' => $available_quantity_n,
    	]);

			//goods transaction detail log
    	$data['expiry_date'] = $expiry_date;
    	$data['lot_number'] = $lot_number;
    	$this->add_goods_transaction_detail($data, 2);

    	return true;


    }


    /**
     * copyinvoice
     * @param  integer $invoice_id 
     * @return array             
     */
    public function copy_invoice($invoice_id)
    {

    	
    	$this->db->where('id', $invoice_id);
    	$invoice_value = $this->db->get(db_prefix().'invoices')->row();
    	$data_insert=[];
    	$status = false;

    	if($invoice_value){
    		$status = true;;

    		/*get value for goods delivery*/

    		$data['goods_delivery_code'] = $this->create_goods_delivery_code();

    		if(!$this->check_format_date($invoice_value->date)){
    			$data['date_c'] = to_sql_date($invoice_value->date);
    		}else{
    			$data['date_c'] = $invoice_value->date;
    		}


    		if(!$this->check_format_date($invoice_value->date)){
    			$data['date_add'] = to_sql_date($invoice_value->date);

    		}else{
    			$data['date_add'] = $invoice_value->date;
    		}


    		$data['customer_code'] 	= $invoice_value->clientid;
    		$data['invoice_id'] 	= $invoice_id;
    		$data['addedfrom'] 	= $invoice_value->addedfrom;
    		$data['description'] 	= $invoice_value->adminnote;
    		$data['address'] 	= $invoice_value->shipping_street.', '.$invoice_value->shipping_city.', '.$invoice_value->shipping_state.', '.get_country_name($invoice_value->shipping_country);

    		$data['total_money'] 	= (float)$invoice_value->subtotal + (float)$invoice_value->total_tax;
    		$data['total_discount'] = $invoice_value->discount_total;
    		$data['after_discount'] = $invoice_value->total;

    		/*get data for goods delivery detail*/
    		/*get item in invoices*/
    		$this->db->where('rel_id', $invoice_id);
    		$this->db->where('rel_type', 'invoice');
    		$arr_itemable = $this->db->get(db_prefix().'itemable')->result_array();

    		$arr_item_insert=[];
    		$index=0;

    		if(count($arr_itemable) > 0){
    			foreach ($arr_itemable as $key => $value) {
    				$commodity_code = $this->get_itemid_from_name($value['description']);
    				if($commodity_code != 0){
    					/*get item from name*/
    					$arr_item_insert[$index]['commodity_code'] = $commodity_code;
    					$arr_item_insert[$index]['quantities'] = $value['qty'] + 0;
    					$arr_item_insert[$index]['rate'] = $value['rate'] + 0;
    					$arr_item_insert[$index]['tax_id'] = '';

    					$arr_item_insert[$index]['total_money'] = (float)$value['qty']*(float)$value['rate'];
    					$arr_item_insert[$index]['total_after_discount'] = (float)$value['qty']*(float)$value['rate'];

    					/*update after : goods_delivery_id, warehouse_id*/

    					/*get tax item*/
    					$this->db->where('itemid', $value['id']);
    					$this->db->where('rel_id', $invoice_id);
    					$this->db->where('rel_type', "invoice");

    					$item_tax = $this->db->get(db_prefix().'item_tax')->result_array();

    					if(count($item_tax) > 0){
    						foreach ($item_tax as $tax_value) {
    							$tax_id = $this->get_tax_id_from_taxname_taxrate($tax_value['taxname'], $tax_value['taxrate']);

    							if($tax_id != 0){
    								if(strlen($arr_item_insert[$index]['tax_id']) != ''){
    									$arr_item_insert[$index]['tax_id'] .= '|'.$tax_id;
    								}else{
    									$arr_item_insert[$index]['tax_id'] .= $tax_id;

    								}
    							}


    							$arr_item_insert[$index]['total_money'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;

    							$arr_item_insert[$index]['total_after_discount'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;

    						}
    					}

    					$index++;
    				}


    			}
    		}



    		$data_insert['goods_delivery'] = $data;
    		$data_insert['goods_delivery']['total_row'] = count($arr_item_insert);

    		$data_insert['goods_delivery_detail'] = $arr_item_insert;
    		$data_insert['status'] = $status;


    	}

    	return $data_insert ;



    }


    /**
     * get commodity active
     * @return array 
     */
    public function get_commodity_active()
    {	

    	return  $this->db->query('select * from tblitems where active = 1')->result_array();

    }

    /**
     * get job position training de
     * @param  integer $id 
     * @return object      
     */
    public function get_item_longdescriptions($id){

    	$this->db->where('id', $id);
    	return  $this->db->get(db_prefix() . 'items')->row();

    }

    /**
     * revert goods receipt
     * @param  string $value 
     * @return [type]        
     */
    public function revert_goods_receipt($goods_receipt)
    {
    	$count_result=0;
    	$arr_goods_receipt_detail = $this->get_goods_receipt_detail($goods_receipt);
    	if(count($arr_goods_receipt_detail) > 0){
    		foreach ($arr_goods_receipt_detail as $goods_receipt_detail_value) {
    			$re_revert_inventory_manage = $this->revert_inventory_manage($goods_receipt_detail_value, 1);
    			if($re_revert_inventory_manage){
    				$count_result++;
    			}

    			$re_revert_goods_transaction_detail = $this->revert_goods_transaction_detail($goods_receipt_detail_value, 1);
    			if($re_revert_goods_transaction_detail){
    				$count_result++;
    			}

    		}

    		//delete goods receipt (goods receipt, goods receipt detail)
    		$re_delete_goods_receipt =  $this->delete_goods_receipt($goods_receipt);
    		if($re_delete_goods_receipt){
    			$count_result++;
    		}

    	}

    	if($count_result > 0){
    		return true;
    	}else{
    		return true;
    	}
    	
    }


    /**
     * revert goods delivery
     * @param  integer $goods_delivery 
     * @return                  
     */
    public function revert_goods_delivery($goods_delivery)
    {	
    	$count_result=0;

    	$goods_delivery_value = $this->get_goods_delivery($goods_delivery);
    	
    	$invoice = false;
    	if($goods_delivery_value){
    		if( ($goods_delivery_value->invoice_id != '') && ($goods_delivery_value->invoice_id != 0) ){
    			$invoice = true;
    		}
    	}

    	$arr_goods_delivery_detail = $this->get_goods_delivery_detail($goods_delivery);
    	if(count($arr_goods_delivery_detail) > 0){
    		foreach ($arr_goods_delivery_detail as $goods_delivery_detail_value) {

    			$re_revert_inventory_manage = $this->revert_inventory_manage($goods_delivery_detail_value, 2, $invoice);
    			if($re_revert_inventory_manage){
    				$count_result++;
    			}

    			$re_revert_goods_transaction_detail = $this->revert_goods_transaction_detail($goods_delivery_detail_value, 2);
    			if($re_revert_goods_transaction_detail){
    				$count_result++;
    			}

    		}

    		//delete goods delivery (goods delivery, goods delivery detail)
    		
    		$re_delete_goods_delivery = $this->delete_goods_delivery($goods_delivery);
    		if($re_revert_goods_transaction_detail){
    			$count_result++;
    		}

    	}

    	if($count_result > 0){
    		return true;
    	}else{
    		return true;
    	}

    }


	/**
	 * revert inventory manage
	 * @param  string $value 
	 * @return [type]        
	 */
	public function revert_inventory_manage($data, $status, $invoice = false)
	{


		if ($status == 1) {
    	// status '1:Goods receipt note 2:Goods delivery note',
    		//revert goods receipt

			$this->db->where('warehouse_id', $data['warehouse_id']);
			$this->db->where('commodity_id', $data['commodity_code']);
			$this->db->where('expiry_date', $data['expiry_date']);
			$this->db->where('lot_number', $data['lot_number']);
			$total_rows = $this->db->count_all_results('tblinventory_manage');

			if ($total_rows > 0) {
				$status_insert_update = false;
			} else {
				$status_insert_update = true;
			}

			if (!$status_insert_update) {
				//update
				$this->db->where('warehouse_id', $data['warehouse_id']);
				$this->db->where('commodity_id', $data['commodity_code']);
				$this->db->where('expiry_date', $data['expiry_date']);
				$this->db->where('lot_number', $data['lot_number']);

				$result = $this->db->get('tblinventory_manage')->row();
				$inventory_number = $result->inventory_number;
				$update_id = $result->id;

				
				//Goods receipt
				$data_update['inventory_number'] = (int) $inventory_number - (int) $data['quantities'];
				if((float)$data_update['inventory_number'] < 0){
					$data_update['inventory_number'] = 0;
				}

				//update
				$this->db->where('id', $update_id);
				$this->db->update(db_prefix() . 'inventory_manage', $data_update);
				if ($this->db->affected_rows() > 0) {
					return true;
				}else{
					return false;
				}

			} else {
				//insert
				$data_insert['warehouse_id'] = $data['warehouse_id'];
				$data_insert['commodity_id'] = $data['commodity_code'];
				$data_insert['inventory_number'] = $data['quantities'];
				$data_insert['date_manufacture'] = $data['date_manufacture'];
				$data_insert['expiry_date'] = $data['expiry_date'];
				$data_insert['lot_number'] = $data['lot_number'];

				$this->db->insert(db_prefix() . 'inventory_manage', $data_insert);

				$insert_id = $this->db->insert_id();
				if($insert_id){
					return true;
				}else{
					return false;
				}


			}
			
		}else{
			$result_with_invoice=0;
			//status == 2 export
			//revert goods delivery
			if($invoice == false){
				$total_quatity_revert = $data['quantities'];
				//goods delivery not with invoice
				//with key lot number
				if( ($data['lot_number'] != '') && (isset($data['lot_number'])) ){

					$arr_lot_quantity = explode(',', $data['lot_number']);

					foreach ($arr_lot_quantity as $key => $value) {

						if($key%2 == 0){
							$lot_number = '';

							$lot_number = $value;
						}else{
							$quantities = '';

							$quantities = $value;

							$this->db->where('warehouse_id', $data['warehouse_id']);
							$this->db->where('commodity_id', $data['commodity_code']);
							$this->db->where('lot_number', $lot_number);
							$this->db->order_by('id', 'ASC');
							$result = $this->db->get('tblinventory_manage')->row();

							if($result){
								$total_quatity_revert = (float)$total_quatity_revert-(float)$result->inventory_number;

								$new_inventory = (float)$result->inventory_number+(float)$quantities;
								$this->db->where('id', $result->id);
								$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$new_inventory]);

								if ($this->db->affected_rows() > 0) {
									$result_with_invoice++;
								}

							}



						}

					}



				}elseif( ($data['expiry_date'] != '') && (isset($data['expiry_date'])) ){
				//with key expiry date
					$arr_expiry_date = explode(',', $data['expiry_date']);

					foreach ($arr_expiry_date as $key => $value) {

						if($key%2 == 0){
							$expiry_date = '';

							$expiry_date = $value;
						}else{
							$quantities = '';

							$quantities = $value;

							$this->db->where('warehouse_id', $data['warehouse_id']);
							$this->db->where('commodity_id', $data['commodity_code']);
							$this->db->where('expiry_date', $expiry_date);
							$this->db->order_by('id', 'ASC');
							$result = $this->db->get('tblinventory_manage')->row();

							if($result){
								$total_quatity_revert = (float)$total_quatity_revert-(float)$result->inventory_number;

								$new_inventory = (float)$result->inventory_number+(float)$quantities;
								$this->db->where('id', $result->id);
								$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$new_inventory]);

								if ($this->db->affected_rows() > 0) {
									$result_with_invoice++;
								}
								
							}

						}

					}

				}else{
				//no expiry date, lot number, add the first
				//
					$this->db->where('warehouse_id', $data['warehouse_id']);
					$this->db->where('commodity_id', $data['commodity_code']);
					$this->db->order_by('id', 'ASC');
					$result = $this->db->get('tblinventory_manage')->row();

					if($result){
						$new_inventory = (float)$result->inventory_number+(float)$data['quantities'];
						$this->db->where('id', $result->id);
						$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$new_inventory]);

						if ($this->db->affected_rows() > 0) {
							$result_with_invoice++;
						}

						
					}


				}

				//check last update
				if($total_quatity_revert > 0){
					$this->db->where('warehouse_id', $data['warehouse_id']);
					$this->db->where('commodity_id', $data['commodity_code']);
					$this->db->order_by('id', 'ASC');
					$result = $this->db->get('tblinventory_manage')->row();

					if($result){

						$total_quatity_revert = (float)$result->inventory_number+(float)$total_quatity_revert;
						$this->db->where('id', $result->id);
						$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$total_quatity_revert]);

						if ($this->db->affected_rows() > 0) {
							$result_with_invoice++;
						}

					}


				}


			}else{
				//with invoice

				$total_quatity_revert = $data['quantities'];
				//goods delivery with invoice
				

				$arr_warehouse = explode(',', $data['warehouse_id']);
					//with key lot number
				if( ($data['lot_number'] != '') && (isset($data['lot_number'])) ){
					$index_warehouse = 0;

					$arr_lot_quantity = explode(',', $data['lot_number']);


					foreach ($arr_lot_quantity as $key => $value) {

						if($key%2 == 0){

							$lot_number = '';

							$lot_number = $value;
						}else{
							$quantities = '';

							$quantities = $value;

							if(count($arr_lot_quantity)/2 == count($arr_warehouse)){
								if(isset($arr_warehouse[$index_warehouse])){
									$this->db->where('warehouse_id', $arr_warehouse[$index_warehouse]);
									$index_warehouse++;

								}else{
									$this->db->where('warehouse_id', $arr_warehouse[0]);

								}
							}

							$this->db->where('commodity_id', $data['commodity_code']);
							$this->db->where('lot_number', $lot_number);
							$this->db->order_by('id', 'ASC');
							$result = $this->db->get('tblinventory_manage')->row();

							if($result){
								$total_quatity_revert = (float)$total_quatity_revert-(float)$quantities;

								$new_inventory = (float)$result->inventory_number+(float)$quantities;
								$this->db->where('id', $result->id);
								$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$new_inventory]);

								if ($this->db->affected_rows() > 0) {
									$result_with_invoice++;
								}


							}



						}

					}

				}elseif( ($data['expiry_date'] != '') && (isset($data['expiry_date'])) ){
					$index_warehouse = 0;
					//with key expiry date
					$arr_expiry_date = explode(',', $data['expiry_date']);

					foreach ($arr_expiry_date as $key => $value) {


						if($key%2 == 0){
							$expiry_date = '';

							$expiry_date = $value;
						}else{
							$quantities = '';

							$quantities = $value;



							if(count($arr_expiry_date)/2 == count($arr_warehouse)){
								if(isset($arr_warehouse[$index_warehouse])){
									$this->db->where('warehouse_id', $arr_warehouse[$index_warehouse]);
									$index_warehouse++;

								}else{
									$this->db->where('warehouse_id', $arr_warehouse[0]);

								}
							}


							$this->db->where('commodity_id', $data['commodity_code']);
							$this->db->where('expiry_date', $expiry_date);
							$this->db->order_by('id', 'ASC');
							$result = $this->db->get('tblinventory_manage')->row();



							if($result){
								$total_quatity_revert = (float)$total_quatity_revert-(float)$quantities;

								$new_inventory = (float)$result->inventory_number+(float)$quantities;

								$this->db->where('id', $result->id);
								$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$new_inventory]);

								if ($this->db->affected_rows() > 0) {
									$result_with_invoice++;
								}

							}

						}

					}

				}else{


					//no expiry date, lot number, add the first
					//
					$this->db->where('warehouse_id', $arr_warehouse[0]);
					$this->db->where('commodity_id', $data['commodity_code']);
					$this->db->order_by('id', 'ASC');
					$result = $this->db->get('tblinventory_manage')->row();

					if($result){
						$total_quatity_revert = 0;

						$new_inventory = (float)$result->inventory_number+(float)$data['quantities'];
						$this->db->where('id', $result->id);
						$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$new_inventory]);

						if ($this->db->affected_rows() > 0) {
							$result_with_invoice++;
						}

					}


				}
				

				//check last update
				if($total_quatity_revert > 0){

					$this->db->where('warehouse_id', $arr_warehouse[0]);
					$this->db->where('commodity_id', $data['commodity_code']);
					$this->db->order_by('id', 'ASC');
					$result = $this->db->get('tblinventory_manage')->row();

					if($result){

						$total_quatity_revert = (float)$result->inventory_number+(float)$total_quatity_revert;
						$this->db->where('id', $result->id);
						$this->db->update(db_prefix().'inventory_manage', ['inventory_number'=>$total_quatity_revert]);

						if ($this->db->affected_rows() > 0) {
							$result_with_invoice++;
						}


					}

				}


			}

			if($result_with_invoice > 0){
				return true;
			}
			return false;

		}


	}


    /**
     * revert_goods_transaction_detail
     * @param  string $value 
     * @return [type]        
     */
    public function revert_goods_transaction_detail($data, $status)
    {

    	if($status == 1){
    		$this->db->where('goods_receipt_id', $data['goods_receipt_id']);

    	}else{

    		$this->db->where('goods_receipt_id', $data['goods_delivery_id']);
    	}

    	$this->db->where('status', $status);

    	$this->db->delete(db_prefix() . 'goods_transaction_detail');
    	if ($this->db->affected_rows() > 0) {
    		return true;
    	}
    	return false;

    }

    /**
     * update goods delivery approval
     * @param  array  $data 
     * @param  boolean $id   
     *  
     */
    public function update_goods_delivery_approval($data, $id = false)
    {
    	$results = 0;


    	$data_update=[];

    	if (isset($data['hot_purchase'])) {
    		$hot_purchase = $data['hot_purchase'];
    		unset($data['hot_purchase']);
    	}

    	if(isset($data['save_and_send_request'])){
	    	$save_and_send_request = $data['save_and_send_request'];
	    	unset($data['save_and_send_request']);
    	}

    	$goods_delivery_id = $data['id'];
    	unset($data['id']);

    	$data_update['description'] = $data['description'];

    	$this->db->where('id', $goods_delivery_id);
    	$this->db->update(db_prefix() . 'goods_delivery', $data_update);

    	if ($this->db->affected_rows() > 0) {
    		$results++;
    	} 

    	/*update googs delivery*/

    	if(isset($hot_purchase)){
    		$goods_delivery_detail = json_decode($hot_purchase);

    		$es_detail = [];
    		$row = [];
    		$rq_val = [];

    		foreach ($goods_delivery_detail as $key => $value) {

    			if($value[0] != '' && isset($value[13])){

    				$this->db->where('id', $value[13]);
    				$this->db->where('goods_delivery_id', $goods_delivery_id);
    				$this->db->update(db_prefix() . 'goods_delivery_detail', ['note' => $value[12]]);

    				if ($this->db->affected_rows() > 0) {

    					$results++;
    				} 
    			}
    		}
    	}


    	return $results > 0 ? true : false;

    }

	/**
	 * get unitid from commodity name
	 * @param  string $name 
	 * @return integer       
	 */
	public function get_unitid_from_commodity_name($name)
	{	
		$unit_id=0;

		$this->db->where('description', $name);
		$item_value = $this->db->get(db_prefix().'items')->row();

		if($item_value){
			$unit_id = $item_value->unit_id;
		}

		return $unit_id;

	}


    /**
     * get warranty from commodity name
     * @param  string $name 
     * @return string       
     */
    public function get_warranty_from_commodity_name($name)
    {	
    	$guarantee_new = '';

    	$this->db->where('description', $name);
    	$item_value = $this->db->get(db_prefix().'items')->row();

    	if($item_value){

    		if(($item_value->guarantee != '') && (($item_value->guarantee != null)))
    			$guarantee_new = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$item_value->guarantee.' months'));

    	}

    	return $guarantee_new;

    }


    /**
     * get unitid from commodity id
     * @param  integer $id 
     * @return integer     
     */
    public function get_unitid_from_commodity_id($id)
    {	
    	$unit_id=0;

    	$this->db->where('id', $id);
    	$item_value = $this->db->get(db_prefix().'items')->row();

    	if($item_value){
    		$unit_id = $item_value->unit_id;
    	}

    	return $unit_id;

    }

    /**
     * get warranty from commodity id
     * @param  integer $id 
     * @return string     
     */
    public function get_warranty_from_commodity_id($id)
    {	
    	$guarantee_new = '';

    	$this->db->where('id', $id);
    	$item_value = $this->db->get(db_prefix().'items')->row();

    	if($item_value){

    		if(($item_value->guarantee != '') && (($item_value->guarantee != null)))
    			$guarantee_new = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$item_value->guarantee.' months'));

    	}

    	return $guarantee_new;

    }

    /**
     * get shipping address from invoice
     * @param  integer $invoice_id 
     * @return string             
     */
    public function get_shipping_address_from_invoice($invoice_id)
    {	
    	$address='';

    	$this->db->where('id', $invoice_id);
    	$invoice_value = $this->db->get(db_prefix().'invoices')->row();
    	if($invoice_value){
    		$address = $invoice_value->shipping_street;
    	}

    	return $address;

    }

    /**
     * check item without checking warehouse
     * @param  integer $id 
     * @return boolean     
     */
    public function check_item_without_checking_warehouse($id)
    {	
    	$status =  true;
    	$this->db->where('id', $id);
    	$item_value = $this->db->get(db_prefix().'items')->row();
    	if($item_value){
    		$checking_warehouse = $item_value->without_checking_warehouse;
    		if($checking_warehouse == 1){
    			$status = false;
    		}
    	}

    	return $status;


    }


    /**
     * import xlsx opening stock
     * @param  array $data 
     * @return integer       
     */
    public function import_xlsx_opening_stock($data) {


    	/*check update*/

    	$item = $this->db->query('select * from tblitems where commodity_code = "'.$data['commodity_code'].'"')->row();

    	if($item){
    		foreach ($data as $key => $data_value) {
    			if(!isset($data_value)){
    				unset($data[$key]);
    			}
    		}

    		$minimum_inventory = 0;
    		if(isset($data['minimum_inventory'])){
    			$minimum_inventory = $data['minimum_inventory'];
    			unset($data['minimum_inventory']);
    		}

			//update
    		$this->db->where('commodity_code', $data['commodity_code']);
    		$this->db->update(db_prefix() . 'items', $data);

    		/*check update or insert inventory min with commodity code*/
    		$this->db->where('commodity_code', $data['commodity_code']);
    		$check_inventory_min = $this->db->get(db_prefix().'inventory_commodity_min')->row();

    		if($check_inventory_min){
				//update
    			$this->db->where('commodity_code', $data['commodity_code']);
    			$this->db->update(db_prefix() . 'inventory_commodity_min', ['inventory_number_min' => $minimum_inventory]);

    		}else{
				//get commodity_id
    			$this->db->where('commodity_code', $data['commodity_code']);
    			$items = $this->db->get(db_prefix().'items')->row();

    			$item_id=0;
    			if($items){
    				$item_id = $items->id;
    			}

				//insert
    			$data_inventory_min['commodity_id'] = $item_id;
    			$data_inventory_min['commodity_code'] = $data['commodity_code'];
    			$data_inventory_min['commodity_name'] = $data['description'];
    			$data_inventory_min['inventory_number_min'] = $minimum_inventory;
    			$this->add_inventory_min($data_inventory_min);

    		}


    		if ($this->db->affected_rows() > 0) {
    			return true;
    		}
    	}else{
			//insert
    		$this->db->insert(db_prefix() . 'items', $data);
    		$insert_id = $this->db->insert_id();

    		/*add data tblinventory*/
    		if ($insert_id) {
    			$data_inventory_min['commodity_id'] = $insert_id;
    			$data_inventory_min['commodity_code'] = $data['commodity_code'];
    			$data_inventory_min['commodity_name'] = $data['description'];
    			$data_inventory_min['inventory_number_min'] = $data['minimum_inventory'];
    			$this->add_inventory_min($data_inventory_min);
    		}

    		return $insert_id;
    	}


    }


	/**
	 * caculator purchase price
	 * @return json 
	 */
	public function caculator_profit_rate_model($purchase_price, $sale_price)
	{

		$profit_rate = 0;

		/*type : 0 purchase price, 1: sale price*/
		$profit_type = get_warehouse_option('profit_rate_by_purchase_price_sale');
		$the_fractional_part = get_warehouse_option('warehouse_the_fractional_part');
		$integer_part = get_warehouse_option('warehouse_integer_part');

		$purchase_price = reformat_currency_j($purchase_price);
		$sale_price = reformat_currency_j($sale_price);


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
		return $profit_rate;

	}


     /**
     * caculator sale price
     * @return float 
     */
     public function caculator_sale_price_model($purchase_price, $profit_rate)
     {

     	$sale_price = 0;

     	/*type : 0 purchase price, 1: sale price*/
     	$profit_type = get_warehouse_option('profit_rate_by_purchase_price_sale');
     	$the_fractional_part = get_warehouse_option('warehouse_the_fractional_part');
     	$integer_part = get_warehouse_option('warehouse_integer_part');

     	$profit_rate = reformat_currency_j($profit_rate);
     	$purchase_price = reformat_currency_j($purchase_price);

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

     	return $sale_price;

     }

    /**
     * caculator purchase price model
     * @return float 
     */
    public function caculator_purchase_price_model($profit_rate, $sale_price)
    {

    	$purchase_price = 0;

    	/*type : 0 purchase price, 1: sale price*/
    	$profit_type = get_warehouse_option('profit_rate_by_purchase_price_sale');
    	$the_fractional_part = get_warehouse_option('warehouse_the_fractional_part');
    	$integer_part = get_warehouse_option('warehouse_integer_part');

    	$profit_rate = reformat_currency_j($profit_rate);
    	$sale_price = reformat_currency_j($sale_price);


    	switch ($profit_type) {
    		case '0':
    			# Calculate the selling price based on the purchase price rate of profit
    			# sale price = purchase price * ( 1 + profit rate)
    		if( ($profit_rate =='') || ($profit_rate == '0')|| ($profit_rate == 'null') ){
    			$purchase_price = (float)$sale_price;

    		}else{
    			$purchase_price = (float)$sale_price/(1+((float)$profit_rate/100));

    		}
    		break;

    		case '1':
    			# Calculate the selling price based on the selling price rate of profit
    			# sale price = purchase price / ( 1 - profit rate)
    		if( ($profit_rate =='') || ($profit_rate == '0')|| ($profit_rate == 'null') ){
    			$purchase_price = (float)$sale_price;
    		}else{

    			$purchase_price = (float)$purchase_price*(1-((float)$profit_rate/100));

    		}
    		break;
    		
    	}

    	//round purchase_price
    	$purchase_price = round($purchase_price, (int)$the_fractional_part);

    	if($integer_part != '0'){
    		$integer_part = 0 - (int)($integer_part);
    		$purchase_price = round($purchase_price, $integer_part);
    	}

    	return $purchase_price;
    }

    /**
     * get list item tags
     * @param  integer $id 
     * @return [type]     
     */
    public function get_list_item_tags($id){
    	$data=[];

    	/* get list tinymce start*/
    	$this->db->from(db_prefix() . 'taggables');
    	$this->db->join(db_prefix() . 'tags', db_prefix() . 'tags.id = ' . db_prefix() . 'taggables.tag_id', 'left');

    	$this->db->where(db_prefix() . 'taggables.rel_id', $id);
    	$this->db->where(db_prefix() . 'taggables.rel_type', 'item_tags');
    	$this->db->order_by('tag_order', 'ASC');

    	$item_tags = $this->db->get()->result_array();

    	$html_tags='';
    	foreach ($item_tags as $tag_value) {
    		$html_tags .='<li class="tagit-choice ui-widget-content ui-state-default ui-corner-all tagit-choice-editable tag-id-'.$tag_value['id'].' true" value="'.$tag_value['id'].'">
    		<span class="tagit-label">'.$tag_value['name'].'</span>
    		<a class="tagit-close">
    		<span class="text-icon">×</span>
    		<span class="ui-icon ui-icon-close"></span>
    		</a>
    		</li>';
    	}


    	$data['htmltag']    = $html_tags;  

    	return $data;

    }


    /**
     * delete tag item
     * @param  integer $tag_id 
     * @return [type]         
     */
    public function delete_tag_item($tag_id){
    	$count_af = 0;
    	/* delete taggables*/
    	$this->db->where(db_prefix() . 'taggables.tag_id', $tag_id);
    	$this->db->delete(db_prefix() . 'taggables');
    	if ($this->db->affected_rows() > 0) {
    		$count_af++;
    	}

    	/*delete tag*/
    	$this->db->where(db_prefix() . 'tags.id', $tag_id);
    	$this->db->delete(db_prefix() . 'tags');
    	if ($this->db->affected_rows() > 0) {
    		$count_af++;
    	}

    	return $count_af > 0 ?  true :  false;
    }


    /**
     * inventory_cancel_invoice
     * @param  integer $invoice_id 
     *              
     */
    public function inventory_cancel_invoice($invoice_id)
    {
    	/*get inventory delivery by invoice_id with status approval*/ 
    	$this->db->where('invoice_id', $invoice_id);
    	$this->db->where('approval', 1);
    	$arr_goods_delivery = $this->db->get(db_prefix().'goods_delivery')->result_array();

    	if(count($arr_goods_delivery) > 0){
    		foreach ($arr_goods_delivery as $value) {

    			$this->revert_goods_delivery($value['id']);

    		}
    	}else{
    		$this->db->where('invoice_id', $invoice_id);
    		$this->db->where('approval != ', 1);
    		$arr_goods_delivery = $this->db->get(db_prefix().'goods_delivery')->result_array();

    		if(count($arr_goods_delivery) > 0){
    			foreach ($arr_goods_delivery as $value) {

    				$this->delete_goods_delivery($value['id']);

    			}
    		}

    	}
    	return true;

    }


    /**
     * items send notification inventory warning
     * @return boolean        
     */
    public function items_send_notification_inventory_warning()
    {
    	$string_commodity_active = $this->array_commodity_id_active();

    	$string_notification='';
    	$arr_item=[];

    	$now = time();
    	$inventorys_cronjob_active = get_option('inventorys_cronjob_active');

    	$inventory_auto_operations_hour = get_option('inventory_auto_operations_hour');
    	$automatically_send_items_expired_before = get_option('automatically_send_items_expired_before');
    	$inventory_cronjob_notification_recipients = get_option('inventory_cronjob_notification_recipients');

    	/*get inventory stock, expiry date*/
    	$this->db->select('commodity_id, warehouse_id, sum(inventory_number) as inventory_number');
    	if(strlen($string_commodity_active) > 0){
    		$str_where = 'commodity_id IN ('.$string_commodity_active.')';
    		$this->db->where($str_where);
    	}

    	$this->db->group_by(array("commodity_id", "warehouse_id"));
    	$arr_inventory_stock=  $this->db->get(db_prefix().'inventory_manage')->result_array();
    	foreach ($arr_inventory_stock as $value) {
    		if(!in_array($value['commodity_id'], $arr_item)){

    			$link = 'warehouse/view_commodity_detail/' . $value['commodity_id'];

	            //get_inventory_min
    			$inventory_min= $this->get_inventory_min_cron($value['commodity_id']);

    			$sku_code='';
    			$warehouse_code='';

    			$item_value = $this->get_commodity($value['commodity_id']);
    			$warehouse_value = $this->get_warehouse($value['warehouse_id']);

    			if($item_value){
    				$sku_code .= $item_value->sku_code;
    			}

    			if($warehouse_value){
    				$warehouse_code .= $warehouse_value->warehouse_code;
    			}

    			if($inventory_min){
    				if($value['inventory_number'] <= $inventory_min->inventory_number_min){


    					$string_notification .='<a href="'.admin_url($link).'">'. _l('sku_code').': '.$sku_code.' - '._l('warehouse_code').': '.$warehouse_code.' - '._l('inventory_minimum').': '.$inventory_min->inventory_number_min.' - '._l('inventory_number_').': '.$value['inventory_number'].'</a>'.'<br/>';

    				}
    			}
    			/*check expiry date*/
    			$this->db->select('commodity_id, warehouse_id,expiry_date, sum(inventory_number) as inventory_number');
    			$this->db->where('commodity_id', $value['commodity_id']);
    			$this->db->group_by(array("commodity_id","expiry_date", "warehouse_id"));
    			$arr_expiry_date=  $this->db->get(db_prefix().'inventory_manage')->result_array();

    			if( count($arr_expiry_date) >0){
    				foreach ($arr_expiry_date as $ex_value) {
    					if($ex_value['expiry_date'] != null && $ex_value['expiry_date'] != ''){

    						$datediff  = strtotime($ex_value['expiry_date']) - strtotime(date('Y-m-d'));
    						$days_diff = floor($datediff / (60 * 60 * 24));

    						if ($days_diff <= $automatically_send_items_expired_before) {



    							$string_notification .= '<a href="'.admin_url($link).'">'. _l('sku_code').': '.$sku_code.' - '._l('warehouse_code').': '.$warehouse_code.' - '._l('exriry_date').': '.$ex_value['expiry_date'].'</a>'.'<br/>';

    						}

    					}
    				}
    			}





    		}
    		$arr_item[] = $value['commodity_id'];

    	}


    	if(strlen($inventory_cronjob_notification_recipients) != 0){

	        //send notification
    		if($string_notification != ''){
    			$data_send_mail=[];
    			$arr_staff_id = explode(',', $inventory_cronjob_notification_recipients);

    			foreach ($arr_staff_id as $staffid) {

    				$notified = add_notification([
    					'description' => _l('inventory_warning').$string_notification,
    					'touserid' => $staffid,
    					'additional_data' => serialize([
    						$string_notification,
    					]),
    				]);
    				if ($notified) {
    					pusher_trigger_notification([$staffid]);
    				}

    				/*send mail*/
    				$staff = $this->staff_model->get($staffid);
    				$staff->id=1;
    				if($staff){

    					$data_send_mail['string_notification']=$string_notification;
    					$data_send_mail['email']=$staff->email;
    					$data_send_mail['staff_name']=$staff->firstname.' '.$staff->lastname;


    					$template = mail_template('inventory_warning_to_staff', 'warehouse', array_to_object($data_send_mail));

    					$template->send();


    				}

    			}


    		}


    	}

         //send mail

    	return true;


    }

    /**
     * get item tag filter
     * @return array 
     */
    public function get_item_tag_filter()
    {
    	return $this->db->query('select * FROM '.db_prefix().'taggables left join '.db_prefix().'tags on '.db_prefix().'taggables.tag_id =' .db_prefix().'tags.id where '.db_prefix().'taggables.rel_type = "item_tags"')->result_array();
    }

    /**
     * check inventory delivery voucher
     * @param  array $data 
     * @return string       
     */
    public function check_inventory_delivery_voucher($data)
    {

    	$flag_export_warehouse = 1;

    	$str_error='';

    	/*get goods delivery detail*/
    	$this->db->where('goods_delivery_id', $data['rel_id']);
    	$goods_delivery_detail = $this->db->get(db_prefix().'goods_delivery_detail')->result_array();


    	if (count($goods_delivery_detail) > 0) {

    		foreach ($goods_delivery_detail as $delivery_detail_key => $delivery_detail_value) {

    			$sku_code='';
    			$commodity_code='';

    			$item_value = $this->get_commodity($delivery_detail_value['commodity_code']);
    			if($item_value){
    				$sku_code .= $item_value->sku_code;
    				$commodity_code .= $item_value->commodity_code;
    			}

    			/*check export warehouse*/

				//checking Do not save the quantity of inventory with item
    			if($this->check_item_without_checking_warehouse($delivery_detail_value['commodity_code']) == true){

    				$inventory = $this->get_quantity_inventory($delivery_detail_value['warehouse_id'],$delivery_detail_value['commodity_code']);

    				if($inventory){
    					$inventory_number =  $inventory->inventory_number;

    					if((float)$inventory_number < (float)$delivery_detail_value['quantities'] ){
    						$str_error .= _l('item_has_sku_code'). $sku_code. ','. _l('commodity_code').' '. $commodity_code.':  '._l('not_enough_inventory');
    						$flag_export_warehouse =  0;
    					}

    				}else{
    					$str_error .=_l('item_has_sku_code'). $sku_code. ','. _l('commodity_code').' '. $commodity_code.':  '._l('not_enough_inventory');
    					$flag_export_warehouse =  0;

    				}

    			}


    		}

    	}

    	$result=[];
    	$result['str_error'] = $str_error;
    	$result['flag_export_warehouse'] = $flag_export_warehouse;

    	return $result ;


    }


    /**
     * update po detail quantity
     * @param  integer $po_id                
     * @param  array $goods_receipt_detail 
     *                        
     */
    public function update_po_detail_quantity($po_id, $goods_receipt_detail)
    {
    	$flag_update_status = true;

    	$this->db->where('pur_order', $po_id);
    	$this->db->where('item_code', $goods_receipt_detail['commodity_code']);

    	$pur_order_detail = $this->db->get(db_prefix().'pur_order_detail')->row();

    	if($pur_order_detail){
    		//check quantity in purchase order detail = wh_quantity_received
    		$wh_quantity_received = (float)($pur_order_detail->wh_quantity_received) + (float)$goods_receipt_detail['quantities'];

    		if($pur_order_detail->quantity > $wh_quantity_received){
    			$flag_update_status = false;
    		}

    		//wh_quantity_received in purchase order detail 

    		$this->db->where('pur_order', $po_id);
    		$this->db->where('item_code', $goods_receipt_detail['commodity_code']);
    		$this->db->update(db_prefix() . 'pur_order_detail', ['wh_quantity_received' => $wh_quantity_received]);

    		if ($this->db->affected_rows() > 0) {
    			$results_update = true;
    		} else {
    			$results_update = false;
    			$flag_update_status =  false;

    		}

    	}

    	$results=[];
    	$results['flag_update_status']=$flag_update_status;
    	return $results;

    }

    /**
     * array commodity id active
     * @return array 
     */
    public function array_commodity_id_active()
    {	
    	$data=[];
    	$this->db->select('id');
    	$this->db->where('active', 1);
    	$arr_item = $this->db->get(db_prefix().'items')->result_array();

    	if(count($arr_item) > 0){
    		foreach ($arr_item as $value) {
    			array_push($data, $value['id']);
    		}
    	}
    	return implode(',',$data );

    }

    /**
     * get inventory min cron
     * @param  integer $id 
     * @return [type]     
     */
    public function get_inventory_min_cron($id) {

    	$this->db->where('commodity_id', $id);

    	return $this->db->get(db_prefix() . 'inventory_commodity_min')->row();


    }


	/**
	 * check lost adjustment before save
	 * @param  array $data 
	 * @return boolean       
	 */
	public function check_lost_adjustment_before_save($data)
	{


		$flag_check = 0;
		$str_error = '';

		foreach ($data['hot_delivery'] as $d) {
			// items: d[0], lot_number: d2, expiry_date: d3
			if($d[0]){

				$check = $this->check_commodity_exist_inventory($data['warehouse_id'], $d[0], $d[2], $d[3]);
				if ($check == true) {
					$flag_check = 1;

					$commodity_code='';
					$commodity_name='';

					$item_value = $this->get_commodity($d[0]);
					if($item_value){
						$commodity_code .= $item_value->commodity_code;
						$commodity_name .= $item_value->description;
					}

					$str_error .= 'Item :'.$commodity_code.'-'.$commodity_name.' with '. _l('lot_number').'-' .$d[2].','._l('expiry_date').'-'. $d[3]._l('not_in_inventory').'<br/>';
				} 

			}

		}

		$data=[];
		$data['flag_check']=$flag_check;
		$data['str_error']=$str_error;

		return $data;



	}


	/**
	 * update inventory setting
	 * @param  array $data 
	 * @return boolean       
	 */
	public function update_inventory_setting($data)
	{
		$affected_rows=0;
		foreach ($data as $key => $value) {

			$this->db->where('name',$key);
			$this->db->update(db_prefix() . 'options', [
				'value' => $value,
			]);

			if ($this->db->affected_rows() > 0) {
				$affected_rows++;
			}

		}

		if($affected_rows > 0){
			return true;
		}else{
			return false;
		}



	}


	/**
	 * invoice update delete goods delivery detail
	 * @param  integer $invoice_id 
	 * @return              
	 */
	public function invoice_update_delete_goods_delivery_detail($invoice_id)
	{
		/*get inventory delivery by invoice_id with status approval*/ 
		$this->db->where('invoice_id', $invoice_id);
		$this->db->where('approval', 1);
		$arr_goods_delivery = $this->db->get(db_prefix().'goods_delivery')->result_array();

		if(count($arr_goods_delivery) > 0){
			foreach ($arr_goods_delivery as $value) {

				$this->revert_goods_delivery_from_invoice_update($value['id']);

			}
		}else{
			$this->db->where('invoice_id', $invoice_id);
			$this->db->where('approval ', 0);
			$arr_goods_delivery = $this->db->get(db_prefix().'goods_delivery')->result_array();

			if(count($arr_goods_delivery) > 0){
				foreach ($arr_goods_delivery as $key => $value) {

					$this->db->where('goods_delivery_id', $value['id']);
					$this->db->delete(db_prefix() . 'goods_delivery_detail');


				}
			}

		}
		return true;

	}


    /**
     * revert goods delivery from invoice update
     * @param  integer $goods_delivery 
     * @return [type]                 
     */
    public function revert_goods_delivery_from_invoice_update($goods_delivery)
    {	
    	$count_result=0;

    	$goods_delivery_value = $this->get_goods_delivery($goods_delivery);
    	
    	$invoice = false;
    	if($goods_delivery_value){
    		if( ($goods_delivery_value->invoice_id != '') && ($goods_delivery_value->invoice_id != 0) ){
    			$invoice = true;
    		}
    	}

    	$arr_goods_delivery_detail = $this->get_goods_delivery_detail($goods_delivery);
    	if(count($arr_goods_delivery_detail) > 0){
    		foreach ($arr_goods_delivery_detail as $goods_delivery_detail_value) {

    			$re_revert_inventory_manage = $this->revert_inventory_manage($goods_delivery_detail_value, 2, $invoice);
    			if($re_revert_inventory_manage){
    				$count_result++;
    			}

    			$re_revert_goods_transaction_detail = $this->revert_goods_transaction_detail($goods_delivery_detail_value, 2);
    			if($re_revert_goods_transaction_detail){
    				$count_result++;
    			}

    		}

    		//delete goods delivery  detail not delete goods delivery
    		
    		$this->db->where('goods_delivery_id', $goods_delivery);
    		$this->db->delete(db_prefix() . 'goods_delivery_detail');

    		if($re_revert_goods_transaction_detail){
    			$count_result++;
    		}

    	}

    	if($count_result > 0){
    		return true;
    	}else{
    		return true;
    	}

    }


    /**
     * add_goods delivery from invoice update
     * @param array $data_insert 
     */
    public function add_goods_delivery_from_invoice_update($invoice_id, $data_insert)
    {

    	$flag_insert = 0;

    	/*get goods delivery from invoice*/
    	$this->db->where('invoice_id', $invoice_id);
    	$goods_delivery_update = $this->db->get(db_prefix().'goods_delivery')->result_array();
    	
    	if(count($goods_delivery_update) > 0){
    		foreach ($goods_delivery_update as $value) {

    			$this->db->where('id',$value['id']);

    			$this->db->update(db_prefix() . 'goods_delivery', [
    				'customer_code' => $data_insert['goods_delivery']['customer_code'],
    				'description' => $data_insert['goods_delivery']['description'],
    				'address' => $data_insert['goods_delivery']['address'],
    				'total_money' => $data_insert['goods_delivery']['total_money'],
    				'total_discount' => $data_insert['goods_delivery']['total_discount'],
    				'after_discount' => $data_insert['goods_delivery']['after_discount'],
    				'approval' => 0,
    			]);

    			$insert_id = $value['id'];
    		}
    		//update
    		
    	}else{

    		//insert new
    		$this->db->insert(db_prefix() . 'goods_delivery', $data_insert['goods_delivery']);
    		$insert_id = $this->db->insert_id();

    		$flag_insert = 1;

    	}

    	$results=0;
    	$flag_export_warehouse = 1;


    	if (isset($insert_id)) {

    		foreach ($data_insert['goods_delivery_detail'] as $delivery_detail_key => $delivery_detail_value) {
    			/*check export warehouse*/

				//checking Do not save the quantity of inventory with item
    			if($this->check_item_without_checking_warehouse($delivery_detail_value['commodity_code']) == true){

    				$inventory = $this->get_inventory_by_commodity($delivery_detail_value['commodity_code']);

    				if($inventory){
    					$inventory_number =  $inventory->inventory_number;

    					if((float)$inventory_number < (float)$delivery_detail_value['quantities'] ){
    						$flag_export_warehouse = 0;
    					}

    				}else{
    					$flag_export_warehouse = 0;
    				}

    			}


    			$delivery_detail_value['goods_delivery_id'] = $insert_id;
    			$this->db->insert(db_prefix() . 'goods_delivery_detail', $delivery_detail_value);
    			$insert_detail = $this->db->insert_id();

    			$results++;

    		}

    		$data_log = [];
    		$data_log['rel_id'] = $insert_id;
    		$data_log['rel_type'] = 'stock_export';
    		$data_log['staffid'] = get_staff_user_id();
    		$data_log['date'] = date('Y-m-d H:i:s');
    		$data_log['note'] = "stock_export";

    		$this->add_activity_log($data_log);

    		if($flag_insert == 1){
    			/*update next number setting*/
    			$this->update_inventory_setting(['next_inventory_delivery_mumber' =>  get_warehouse_option('next_inventory_delivery_mumber')+1]);

    		}


    	}


		//check inventory warehouse => export warehouse
    	if($flag_export_warehouse == 1){
			//update approval
    		$data_update['approval'] = 1;
    		$this->db->where('id', $insert_id);
    		$this->db->update(db_prefix() . 'goods_delivery', $data_update);

			//update history stock, inventoty manage after staff approved
    		$goods_delivery_detail = $this->get_goods_delivery_detail($insert_id);

    		foreach ($goods_delivery_detail as $goods_delivery_detail_value) {
				// add goods transaction detail (log) after update invetory number
				// 
				// check Without checking warehouse

    			if($this->check_item_without_checking_warehouse($goods_delivery_detail_value['commodity_code']) == true){
    				$this->add_inventory_from_invoices($goods_delivery_detail_value);
    			}

    		}
    	}


    	return $results > 0 ? true : false;


    }


    /**
     * add internal delivery
     * @param array $data 
     */
    public function add_internal_delivery($data) {

    	$check_appr = $this->get_approve_setting('4');
    	$data['approval'] = 0;
    	if ($check_appr && $check_appr != false) {
    		$data['approval'] = 0;
    	} else {
    		$data['approval'] = 1;
    	}

    	if(isset($data['edit_approval'])){
    		unset($data['edit_approval']);
    	}

    	if (isset($data['hot_internal_delivery'])) {
    		$hot_internal_delivery = $data['hot_internal_delivery'];
    		unset($data['hot_internal_delivery']);
    	}

    	$data['internal_delivery_code'] = $this->create_internal_delivery_code();

    	if(!$this->check_format_date($data['date_c'])){
    		$data['date_c'] = to_sql_date($data['date_c']);
    	}else{
    		$data['date_c'] = $data['date_c'];
    	}


    	if(!$this->check_format_date($data['date_add'])){
    		$data['date_add'] = to_sql_date($data['date_add']);
    	}else{
    		$data['date_add'] = $data['date_add'];
    	}

    	$data['datecreated'] = date('Y-m-d H:i:s');

    	$data['total_amount'] 	= reformat_currency_j($data['total_amount']);
    	$data['addedfrom'] = get_staff_user_id();


    	$this->db->insert(db_prefix() . 'internal_delivery_note', $data);
    	$insert_id = $this->db->insert_id();

    	/*update save note*/

    	if(isset($hot_internal_delivery)){
    		$internal_delivery_detail = json_decode($hot_internal_delivery);

    		$es_detail = [];
    		$row = [];
    		$rq_val = [];
    		$header = [];

    		$header[] = 'commodity_code';
    		$header[] = 'from_stock_name';
    		$header[] = 'to_stock_name';
    		$header[] = 'unit_id';
    		$header[] = 'available_quantity';
    		$header[] = 'quantities';
    		$header[] = 'unit_price';
    		$header[] = 'into_money';
    		$header[] = 'note';


    		foreach ($internal_delivery_detail as $key => $value) {

    			if($value[0] != ''){

    				$es_detail[] = array_combine($header, $value);

    			}
    		}
    	}


    	if (isset($insert_id)) {

    		/*insert detail*/
    		foreach($es_detail as $key => $rqd){

    			$es_detail[$key]['internal_delivery_id'] = $insert_id;

    		}

    		$this->db->insert_batch(db_prefix().'internal_delivery_note_detail',$es_detail);

    		/*write log*/
    		$data_log = [];
    		$data_log['rel_id'] = $insert_id;
    		$data_log['rel_type'] = 'internal_delivery';
    		$data_log['staffid'] = get_staff_user_id();
    		$data_log['date'] = date('Y-m-d H:i:s');
    		$data_log['note'] = "internal_delivery_note";

    		$this->add_activity_log($data_log);

    		/*update next number setting*/
    		$this->update_inventory_setting(['next_internal_delivery_mumber' =>  get_warehouse_option('next_internal_delivery_mumber')+1]);


    	}

		//approval if not approval setting
    	if (isset($insert_id)) {
    		if ($data['approval'] == 1) {
    			$this->update_approve_request($insert_id, 4, 1);
    		}
    	}

    	return $insert_id > 0 ? $insert_id : false;

    }


    public function create_internal_delivery_code() {

    	$internal_delivery_code = get_warehouse_option('internal_delivery_number_prefix') . (get_warehouse_option('next_internal_delivery_mumber'));

    	return $internal_delivery_code;
    }


	/**
	 * get internal delivery
	 * @param  integer $id 
	 * @return array     
	 */
	public function get_internal_delivery($id) {
		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'internal_delivery_note')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblinternal_delivery_note')->result_array();
		}
	}

	/**
	 * get internal delivery detail
	 * @param  integer $id
	 * @return array
	 */
	public function get_internal_delivery_detail($id) {
		if (is_numeric($id)) {
			$this->db->where('internal_delivery_id', $id);

			return $this->db->get(db_prefix() . 'internal_delivery_note_detail')->result_array();
		}
		if ($id == false) {
			return $this->db->query('select * from tblinternal_delivery_note_detail')->result_array();
		}
	}


	/**
	 * delete internal delivery
	 * @param  integer $id 
	 * @return boolean     
	 */
	public function delete_internal_delivery($id) {
		$affected_rows = 0;

		$this->db->where('internal_delivery_id', $id);
		$this->db->delete(db_prefix() . 'internal_delivery_note_detail');
		if ($this->db->affected_rows() > 0) {

			$affected_rows++;
		}

		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'internal_delivery_note');
		if ($this->db->affected_rows() > 0) {

			$affected_rows++;
		}

		if ($affected_rows > 0) {
			return true;
		}
		return false;
	}


	/**
	 * update internal delivery
	 * @param  array $data 
	 * @param  integer $id   
	 * @return boolean       
	 */
	public function update_internal_delivery($data, $id)
	{
		$affectedRows = 0;

		if (isset($data['hot_internal_delivery'])) {
			$hot_internal_delivery = $data['hot_internal_delivery'];
			unset($data['hot_internal_delivery']);
		}

		if(!$this->check_format_date($data['date_c'])){
			$data['date_c'] = to_sql_date($data['date_c']);
		}else{
			$data['date_c'] = $data['date_c'];
		}


		if(!$this->check_format_date($data['date_add'])){
			$data['date_add'] = to_sql_date($data['date_add']);
		}else{
			$data['date_add'] = $data['date_add'];
		}

		$data['datecreated'] = date('Y-m-d H:i:s');

		$data['total_amount'] 	= reformat_currency_j($data['total_amount']);
		$data['addedfrom'] = get_staff_user_id();


		if(isset($hot_internal_delivery)){
			$internal_delivery_detail = json_decode($hot_internal_delivery);

			$es_detail = [];
			$row = [];
			$rq_val = [];
			$header = [];


			$header[] = 'commodity_code';
			$header[] = 'from_stock_name';
			$header[] = 'to_stock_name';
			$header[] = 'unit_id';
			$header[] = 'available_quantity';
			$header[] = 'quantities';
			$header[] = 'unit_price';
			$header[] = 'into_money';
			$header[] = 'note';
			$header[] = 'id';
			$header[] = 'internal_delivery_id';

			foreach ($internal_delivery_detail as $key => $value) {
				if($value[0] != ''){
					$es_detail[] = array_combine($header, $value);
				}
			}
		}


		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'internal_delivery_note', $data);

		if ($this->db->affected_rows() > 0) {
			$affectedRows++;
		}

		$row = [];
		$row['update'] = []; 
		$row['insert'] = []; 
		$row['delete'] = [];
		$total = [];

		$total['total_amount'] = 0;


		foreach ($es_detail as $key => $value) {
			if($value['id'] != ''){
				$row['delete'][] = $value['id'];
				$row['update'][] = $value;
			}else{
				unset($value['id']);
				$value['internal_delivery_id'] = $id;
				$row['insert'][] = $value;
			}

			$total['total_amount'] += (float)$value['quantities']*(float)$value['unit_price'];

		}

		$this->db->where('id',$id);
		$this->db->update(db_prefix().'internal_delivery_note',$total);
		if ($this->db->affected_rows() > 0) {
			$affectedRows++;
		}

		if(empty($row['delete'])){
			$row['delete'] = ['0'];
		}
		$row['delete'] = implode(",",$row['delete']);
		$this->db->where('id NOT IN ('.$row['delete'] .') and internal_delivery_id ='.$id);
		$this->db->delete(db_prefix().'internal_delivery_note_detail');
		if($this->db->affected_rows() > 0){
			$affectedRows++;
		}

		if(count($row['insert']) != 0){
			$this->db->insert_batch(db_prefix().'internal_delivery_note_detail', $row['insert']);
			if($this->db->affected_rows() > 0){
				$affectedRows++;
			}
		}
		if(count($row['update']) != 0){
			$this->db->update_batch(db_prefix().'internal_delivery_note_detail', $row['update'], 'id');
			if($this->db->affected_rows() > 0){
				$affectedRows++;
			}
		}


		if ($affectedRows > 0) {


			return true;
		}

		return false;
	}

    /**
     * approval internal delivery detail
     * @param  array $data 
     * @return [type]       
     */
    public function approval_internal_delivery_detail($data)
    {

    	/*step 1 inventory delivery note*/
    	$this->db->where('warehouse_id', $data['from_stock_name']);
    	$this->db->where('commodity_id', $data['commodity_code']);
    	$this->db->order_by('id', 'ASC');
    	$result = $this->db->get('tblinventory_manage')->result_array();

    	$temp_quantities = $data['quantities'];
    	$old_quantities = $data['available_quantity'];

    	$expiry_date = '';
    	$lot_number = '';

    	$data_log=[];

    	foreach ($result as $result_value) {
    		if (($result_value['inventory_number'] != 0) && ($temp_quantities != 0)) {

    			if ($temp_quantities >= $result_value['inventory_number']) {
    				$temp_quantities = (float) $temp_quantities - (float) $result_value['inventory_number'];


						//log data
    				array_push($data_log, [
    					'goods_receipt_id' 	=> $data['internal_delivery_id'],
    					'goods_id' 			=> $data['id'],
    					'old_quantity' 			=> $old_quantities,
    					'quantity' 			=> $result_value['inventory_number'],
    					'date_add' 			=> date('Y-m-d H:i:s'),
    					'commodity_id' 		=> $data['commodity_code'],
    					'note' 				=> $data['note'],
    					'status' 			=> 4,
    					'purchase_price' 	=> $data['unit_price'],
    					'expiry_date' 		=> $result_value['expiry_date'],
    					'lot_number' 		=> $result_value['lot_number'],
    					'from_stock_name' 	=> $data['from_stock_name'],
    					'to_stock_name' 	=> $data['to_stock_name'],
    				]);

    				$old_quantities = (float)$old_quantities - (float)$result_value['inventory_number'];

						//update inventory
    				$this->db->where('id', $result_value['id']);
    				$this->db->update(db_prefix() . 'inventory_manage', [
    					'inventory_number' => 0,
    				]);

						//import warehouse
    				$data_inventory_received=[];
    				$data_inventory_received['lot_number'] 		= $result_value['lot_number'];
    				$data_inventory_received['expiry_date']		= $result_value['expiry_date'];
    				$data_inventory_received['warehouse_id']	= $data['to_stock_name'];
    				$data_inventory_received['commodity_code']	= $data['commodity_code'];
    				$data_inventory_received['quantities']		= $result_value['inventory_number'];
    				$data_inventory_received['date_manufacture']		= $result_value['date_manufacture'];

    				$this->add_inventory_manage($data_inventory_received, 1);

    			} else {


						//log data
    				array_push($data_log, [
    					'goods_receipt_id' 	=> $data['internal_delivery_id'],
    					'goods_id' 			=> $data['id'],
    					'old_quantity' 		=> $old_quantities,
    					'quantity' 			=> $temp_quantities,
    					'date_add' 			=> date('Y-m-d H:i:s'),
    					'commodity_id' 		=> $data['commodity_code'],
    					'note' 				=> $data['note'],
    					'status' 			=> 4,
    					'purchase_price' 	=> $data['unit_price'],
    					'expiry_date' 		=> $result_value['expiry_date'],
    					'lot_number' 		=> $result_value['lot_number'],
    					'from_stock_name' 	=> $data['from_stock_name'],
    					'to_stock_name' 	=> $data['to_stock_name'],
    				]);

    				$old_quantities = (float)$old_quantities - (float)$temp_quantities;

						//update inventory
    				$this->db->where('id', $result_value['id']);
    				$this->db->update(db_prefix() . 'inventory_manage', [
    					'inventory_number' => (float) $result_value['inventory_number'] - (float) $temp_quantities,
    				]);


						//import warehouse
    				$data_inventory_received=[];
    				$data_inventory_received['lot_number'] 		= $result_value['lot_number'];
    				$data_inventory_received['expiry_date']		= $result_value['expiry_date'];
    				$data_inventory_received['warehouse_id']	= $data['to_stock_name'];
    				$data_inventory_received['commodity_code']	= $data['commodity_code'];
    				$data_inventory_received['quantities']		= $temp_quantities;
    				$data_inventory_received['date_manufacture']		= $result_value['date_manufacture'];

    				$this->add_inventory_manage($data_inventory_received, 1);

    				$temp_quantities = 0;

    			}

    		}

    	}

			//goods transaction detail log
    	$this->db->insert_batch(db_prefix(). 'goods_transaction_detail', $data_log);

    	return true;

    }



    public function check_internal_delivery_note_send_request($data)
    {


    	$flag_internal_delivery_warehouse = 1;

    	$str_error='';

    	/*get goods delivery detail*/
    	$this->db->where('internal_delivery_id', $data['rel_id']);
    	$internal_delivery_detail = $this->db->get(db_prefix().'internal_delivery_note_detail')->result_array();


    	if (count($internal_delivery_detail) > 0) {

    		foreach ($internal_delivery_detail as $delivery_detail_key => $delivery_detail_value) {

    			$sku_code='';
    			$commodity_code='';

    			$item_value = $this->get_commodity($delivery_detail_value['commodity_code']);
    			if($item_value){
    				$sku_code .= $item_value->sku_code;
    				$commodity_code .= $item_value->commodity_code;
    			}

    			/*check internal delivery note warehouse*/

    			$inventory = $this->get_quantity_inventory($delivery_detail_value['from_stock_name'], $delivery_detail_value['commodity_code']);

    			if($inventory){
    				$inventory_number =  $inventory->inventory_number;

    				if((float)$inventory_number < (float)$delivery_detail_value['quantities'] ){
    					$str_error .= _l('item_has_sku_code'). $sku_code. ','. _l('commodity_code').' '. $commodity_code.':  '._l('not_enough_inventory');
    					$flag_internal_delivery_warehouse =  0;
    				}

    			}else{
    				$str_error .=_l('item_has_sku_code'). $sku_code. ','. _l('commodity_code').' '. $commodity_code.':  '._l('not_enough_inventory');
    				$flag_internal_delivery_warehouse =  0;

    			}

    		}

    	}

    	$result=[];
    	$result['str_error'] = $str_error;
    	$result['flag_internal_delivery_warehouse'] = $flag_internal_delivery_warehouse;

    	return $result ;


    }


    /**
     * add one warehouse
     * @param [type] $data 
     */
    public function add_one_warehouse($data) {

    	$option = 'off';
    	if (isset($data['display'])) {
    		$option = $data['display'];
    		unset($data['display']);
    	}

    	if ($option == 'on') {
    		$data['display'] = 1;
    	} else {
    		$data['display'] = 0;
    	}

    	if (isset($data['custom_fields'])) {
    		$custom_fields = $data['custom_fields'];
    		unset($data['custom_fields']);
    	}

    	$this->db->insert(db_prefix() . 'warehouse', $data);
    	$insert_id = $this->db->insert_id();

    	if ($insert_id) {
    		if (isset($custom_fields)) {
    			handle_custom_fields_post($insert_id, $custom_fields);
    		}

    		return $insert_id;
    	}


    	return false;
    }

	/**
	 * update color
	 * @param  array $data
	 * @param  integer $id
	 * @return boolean
	 */
	public function update_one_warehouse($data, $id) {
		$option = 'off';
		if (isset($data['display'])) {
			$option = $data['display'];
			unset($data['display']);
		}

		if ($option == 'on') {
			$data['display'] = 1;
		} else {
			$data['display'] = 0;
		}

		if (isset($data['custom_fields'])) {
			$custom_fields = $data['custom_fields'];
			unset($data['custom_fields']);
		}

		$affectedRows = 0;

		$this->db->where('warehouse_id', $id);
		$this->db->update(db_prefix() . 'warehouse', $data);

		if ($this->db->affected_rows() > 0) {
			$affectedRows++;
		}

		if (isset($custom_fields)) {
			if (handle_custom_fields_post($id, $custom_fields)) {
				$affectedRows++;
			}
		}

		if ($affectedRows > 0) {
			return true;
		}

		return true;
	}


	/**
	 * get inventory by warehouse
	 * @param  integer $warehouse_id 
	 * @return array               
	 */
	public function get_inventory_by_warehouse($warehouse_id) {
		
		$sql = 'SELECT sum(inventory_number) as inventory_number, commodity_id, warehouse_id FROM '.db_prefix().'inventory_manage
		where '.db_prefix().'inventory_manage.warehouse_id = '.$warehouse_id.' 
		group by commodity_id
		order by '.db_prefix().'inventory_manage.commodity_id asc';

		return $this->db->query($sql)->result_array();

	}


	/**
	 * get invoices goods delivery
	 * @return mixed 
	 */
	public function get_invoices_goods_delivery($type)
	{
		$this->db->where('type', $type);
		$goods_delivery_invoices_pr_orders = $this->db->get(db_prefix().'goods_delivery_invoices_pr_orders')->result_array();

		$array_id = [];
		foreach ($goods_delivery_invoices_pr_orders as $value) {
			array_push($array_id, $value['rel_type']);
		}

		return $array_id;

	}


    /**
	 * get purchase request
	 * @param  integer $pur_order
	 * @return array
	 */
    public function goods_delivery_get_pur_order($pur_order) {

    	$arr_pur_resquest = [];

    	$subtotal = 0;
    	$total_discount = 0;
    	$total_payment = 0;
    	$total_tax_money = 0;


    	$this->db->select('item_code as commodity_code, '.db_prefix().'items.description, ' .db_prefix().'items.unit_id , unit_price as rate, quantity as quantities, '.db_prefix().'pur_order_detail.tax as tax_id, '.db_prefix().'pur_order_detail.total as total_money, '.db_prefix().'pur_order_detail.total, '.db_prefix().'pur_order_detail.discount_% as discount, '.db_prefix().'pur_order_detail.discount_money, '.db_prefix().'pur_order_detail.total_money as total_after_discount, '.db_prefix().'items.guarantee');
    	$this->db->join(db_prefix() . 'items', '' . db_prefix() . 'pur_order_detail.item_code = ' . db_prefix() . 'items.id', 'left');
    	$this->db->where(db_prefix().'pur_order_detail.pur_order = '. $pur_order);

    	$arr_results = $this->db->get(db_prefix() . 'pur_order_detail')->result_array();


    	$index=0;
    	$status = false;
    	if(count($arr_results) > 0){
    		$status = false;

    		foreach ($arr_results as $key => $value) {
    			/*caculatoe guarantee*/
    			$guarantee_new = '';
    			if($value){
    				if(($value['guarantee'] != '') && (($value['guarantee'] != null)))
    					$guarantee_new = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$value['guarantee'].' months'));
    			}

    			$arr_results[$key]['guarantee_period'] = $guarantee_new;

    			/*caculator subtotal*/
    			/*total discount*/
    			/*total payment*/

    			$total_goods_money = (float)$value['quantities']*(float)$value['rate'];

					//get tax value
    			$tax_rate = 0 ;
    			if($value['tax_id'] != null && $value['tax_id'] != '') {
    				$arr_tax = explode('|', $value['tax_id']);
    				foreach ($arr_tax as $tax_id) {

    					$tax = $this->get_taxe_value($tax_id);
    					if($tax){
    						$tax_rate += (float)$tax->taxrate;		    	
    					}

    				}
    			}


    			$after_tax_money = (($total_goods_money*(float)$tax_rate)/100)+($total_goods_money);
    			$discount = $after_tax_money*(float)$value['discount']/100;

    			$total_discount += (float)$discount;
    			$total_tax_money += (($total_goods_money*(float)$tax_rate)/100)+($total_goods_money);
    			$total_payment += (float)$after_tax_money - (float)$discount;


    		}
    	}


    	$arr_pur_resquest['result'] = $arr_results;
    	$arr_pur_resquest['total_tax_money'] = $total_tax_money;
    	$arr_pur_resquest['total_discount'] = $total_discount;
    	$arr_pur_resquest['total_payment'] = $total_payment;
    	$arr_pur_resquest['total_row'] = count($arr_results);


    	return $arr_pur_resquest;
    }


	/**
	 * get pr order delivered
	 * @return [type] 
	 */
	public function  get_pr_order_delivered()
	{

		$arr_purchase_orders = $this->get_invoices_goods_delivery('purchase_orders');

		return $this->db->query('select * from tblpur_orders where approve_status = 2 AND delivery_status = 1 AND id NOT IN ("'.implode(", ", $arr_purchase_orders).'") order by id desc')->result_array();


	}


    /**
     * get client lead
     * @param  string $id    
     * @param  array  $where 
     * @return array        
     */
    
    public function get_client_lead($id = '', $q)
    {	
    	//customer where
    	$where = '';
    	if ($q){
    		$where .= '(company LIKE "%' . $q . '%" OR CONCAT(firstname, " ", lastname) LIKE "%' . $q . '%" OR email LIKE "%' . $q . '%" OR vat LIKE "%'. $q .'%") AND '.db_prefix().'clients.active = 1';
    	}

    	$data_clients = $this->wh_get_client($where);

    	foreach ($data_clients as $key => $value) {
    		$data_clients[$key]['proposal_wh'] = 'customer';
    	}

        //lead where
    	$data_leads = $this->wh_search_leads($q, 0, [
    		'junk' => 0,
    	]);

    	foreach ($data_leads as $key => $value) {
    		$data_leads[$key]['proposal_wh'] = 'lead';
    	}

    	return array_merge($data_clients, $data_leads);
    }


    /**
     * wh search leads
     * @param  string  $q     
     * @param  integer $limit 
     * @param  array   $where 
     * @return array         
     */
    public function wh_search_leads($q, $limit = 0, $where = [])
    {

    	$has_permission_view = has_permission('leads', '', 'view');

    	if (is_staff_member()) {
            // Leads
    		$this->db->select();
    		$this->db->from(db_prefix() . 'leads');

    		if (!$has_permission_view) {
    			$this->db->where('(assigned = ' . get_staff_user_id() . ' OR addedfrom = ' . get_staff_user_id() . ' OR is_public=1)');
    		}

    		if (!startsWith($q, '#')) {
    			$this->db->where('(name LIKE "%' . $q . '%"
    				OR title LIKE "%' . $q . '%"
    				OR company LIKE "%' . $q . '%"
    				OR zip LIKE "%' . $q . '%"
    				OR city LIKE "%' . $q . '%"
    				OR state LIKE "%' . $q . '%"
    				OR address LIKE "%' . $q . '%"
    				OR email LIKE "%' . $q . '%"
    				OR phonenumber LIKE "%' . $q . '%"
    				OR vat LIKE "%' . $q . '%"
    			)');
    		} else {
    			$this->db->where('id IN
    				(SELECT rel_id FROM ' . db_prefix() . 'taggables WHERE tag_id IN
    				(SELECT id FROM ' . db_prefix() . 'tags WHERE name="' . strafter($q, '#') . '")
    				AND ' . db_prefix() . 'taggables.rel_type=\'lead\' GROUP BY rel_id HAVING COUNT(tag_id) = 1)
    				');
    		}


    		$this->db->where($where);

    		if ($limit != 0) {
    			$this->db->limit($limit);
    		}
    		$this->db->order_by('name', 'ASC');
    		return $this->db->get()->result_array();
    	}

    	return [];
    }


    /**
     * wh get client
     * @param  string $id    
     * @param  array  $where 
     * @return array        
     */
    public function wh_get_client($where = [])
    {
    	$this->db->select(implode(',', prefixed_table_fields_array(db_prefix() . 'clients')) . ',' . get_sql_select_client_company());

    	$this->db->join(db_prefix() . 'countries', '' . db_prefix() . 'countries.country_id = ' . db_prefix() . 'clients.country', 'left');
    	$this->db->join(db_prefix() . 'contacts', '' . db_prefix() . 'contacts.userid = ' . db_prefix() . 'clients.userid AND is_primary = 1', 'left');

    	if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
    		$this->db->where($where);
    	}


    	$this->db->order_by('company', 'asc');

    	return $this->db->get(db_prefix() . 'clients')->result_array();
    }

    /**
     * Gets the proposal attachments.
     *
     * @param      <type>  $id     The proposal
     *
     * @return     <type>  The proposal attachments.
     */
    public function get_proposal_attachments($id){

    	$this->db->where('rel_id',$id);
    	$this->db->where('rel_type','wh_proposal');
    	return $this->db->get(db_prefix().'files')->result_array();
    }

     /**
     * Gets the file.
     *
     * @param      <type>   $id      The file id
     * @param      boolean  $rel_id  The relative identifier
     *
     * @return     boolean  The file.
     */
     public function get_file($id, $rel_id = false)
     {
     	$this->db->where('id', $id);
     	$file = $this->db->get(db_prefix().'files')->row();

     	if ($file && $rel_id) {
     		if ($file->rel_id != $rel_id) {
     			return false;
     		}
     	}
     	return $file;
     }

     /**
     * Gets the part attachments.
     *
     * @param      <type>  $surope  The surope
     * @param      string  $id      The identifier
     *
     * @return     <type>  The part attachments.
     */
     public function get_wh_proposal_attachments($surope, $id = '')
     {
        // If is passed id get return only 1 attachment
     	if (is_numeric($id)) {
     		$this->db->where('id', $id);
     	} else {
     		$this->db->where('rel_id', $assets);
     	}
     	$this->db->where('rel_type', 'wh_proposal');
     	$result = $this->db->get(db_prefix().'files');
     	if (is_numeric($id)) {
     		return $result->row();
     	}

     	return $result->result_array();
     }


     /**
     * { delete purorder attachment }
     *
     * @param      <type>   $id     The identifier
     *
     * @return     boolean 
     */
     public function delete_wh_proposal_attachment($id)
     {
     	$attachment = $this->get_wh_proposal_attachments('', $id);

     	$deleted    = false;
     	if ($attachment) {
     		if (empty($attachment->external)) {
     			unlink(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/proposal/'. $attachment->rel_id . '/' . $attachment->file_name);
     		}
     		$this->db->where('id', $attachment->id);
     		$this->db->delete('tblfiles');
     		if ($this->db->affected_rows() > 0) {
     			$deleted = true;
     		}

     		if (is_dir(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/proposal/'. $attachment->rel_id)) {
                // Check if no attachments left, so we can delete the folder also
     			$other_attachments = list_files(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/proposal/'. $attachment->rel_id);
     			if (count($other_attachments) == 0) {
                    // okey only index.html so we can delete the folder also
     				delete_dir(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/proposal/'. $attachment->rel_id);
     			}
     		}
     	}

     	return $deleted;
     }

    /**
	 * get brand
	 * @param  boolean $id
	 * @return array or object
	 */
    public function get_brand($id = false) {

    	if (is_numeric($id)) {
    		$this->db->where('id', $id);

    		return $this->db->get(db_prefix() . 'wh_brand')->row();
    	}
    	if ($id == false) {
    		return $this->db->query('select * from tblwh_brand')->result_array();
    	}

    }

    /**
	 * add brand
	 * @param array $data
	 * @return integer
	 */
    public function add_brand($data) {

    	$this->db->insert(db_prefix() . 'wh_brand', $data);
    	$insert_id = $this->db->insert_id();

    	return $insert_id;
    }

	/**
	 * update brand
	 * @param  array $data
	 * @param  integer $id
	 * @return boolean
	 */
	public function update_brand($data, $id) {

		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'wh_brand', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return true;
	}

	/**
	 * delete brand
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_brand($id) {
		//delete model
		$this->db->where('brand_id', $id);
		$arr_model = $this->db->get(db_prefix() . 'wh_model')->result_array();

		if(count($arr_model) > 0){
			foreach ($arr_model as $value) {
				$this->delete_model($value['id']);
			}
		}
		

		//delete brand
		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'wh_brand');

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return false;
	}

	/**
	 * get model
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_model($id = false) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'wh_model')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblwh_model')->result_array();
		}

	}

    /**
	 * add model
	 * @param array $data
	 * @return integer
	 */
    public function add_model($data) {

    	$this->db->insert(db_prefix() . 'wh_model', $data);
    	$insert_id = $this->db->insert_id();

    	return $insert_id;
    }

	/**
	 * update model
	 * @param  array $data
	 * @param  integer $id
	 * @return boolean
	 */
	public function update_model($data, $id) {

		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'wh_model', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return true;
	}

	/**
	 * delete model
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_model($id) {

		//delete series
		$this->db->where('model_id', $id);
		$arr_series = $this->db->get(db_prefix() . 'wh_series')->result_array();

		if(count($arr_series) > 0){
			foreach ($arr_series as $value) {
				$this->delete_series($value['id']);
			}
		}

		//delete model
		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'wh_model');

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return false;
	}

	/**
	 * get series
	 * @param  boolean $id
	 * @return array or object
	 */
	public function get_series($id = false) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'wh_series')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblwh_series')->result_array();
		}

	}

    /**
	 * add series
	 * @param array $data
	 * @return integer
	 */
    public function add_series($data) {

    	$this->db->insert(db_prefix() . 'wh_series', $data);
    	$insert_id = $this->db->insert_id();

    	return $insert_id;
    }

	/**
	 * update series
	 * @param  array $data
	 * @param  integer $id
	 * @return boolean
	 */
	public function update_series($data, $id) {

		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'wh_series', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return true;
	}

	/**
	 * delete series
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete_series($id) {

		//delete series
		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'wh_series');

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return false;
	}

	/**
	 * get item proposal value
	 * @param  array $data 
	 * @return [type]           
	 */
	public function get_item_proposal_value($data)
	{

	    //brand where

		$model_id = [];
		$model_options = '';

		$series_id = [];
		$series_options = '';

		$items_id = [];
		$item_options = '';


		$model_id_selected= $data['model_id'];
		$series_id_selected= $data['series_id'];

		if($data['status'] == 'brand_id'){
			$data['model_id'] ='';
		}

		if(isset($data['brand_id']) && $data['brand_id'] !=''){


			$items_id = [];

			$model_id = [];
			$model_options = '';

			$series_id = [];
			$series_options = '';


	    	//select model from brand
			$this->db->where('brand_id', $data['brand_id']);
			$arr_model = $this->db->get(db_prefix().'wh_model')->result_array();

			$model_options .=' <option value=""></option>';
			foreach ($arr_model as $model) {

				$select='';
				if($model['id'] == $model_id_selected){
					$select .= 'selected';
				}

				$model_options .= '<option value="' . $model['id'] . '" '.$select.'>' . $model['name'] . '</option>';
				array_push($model_id, $model['id']);
			}


		    	//select series from model
			if(count($model_id) > 0){
				$this->db->where_in('model_id', $model_id);
				$arr_series = $this->db->get(db_prefix().'wh_series')->result_array();

				foreach ($arr_series as $series) {

					array_push($series_id, $series['id']);
				}

				if(count($series_id) > 0){
					$this->db->where_in('series_id', $series_id);
					$arr_items = $this->db->get(db_prefix().'items')->result_array();

					foreach ($arr_items as $item) {

						array_push($items_id, $item['id']);
					}

				}

			}



		}

		if(isset($data['model_id']) && $data['model_id'] !=''){

			$items_id = [];

			$series_id = [];
			$series_options = '';

	    	//select model from brand
			$this->db->where('model_id', $data['model_id']);
			$arr_series = $this->db->get(db_prefix().'wh_series')->result_array();


			$series_options .=' <option value=""></option>';
			foreach ($arr_series as $series) {
				$select='';
				if($series['id'] == $series_id_selected){
					$select .= 'selected';
				}

				$series_options .= '<option value="' . $series['id'] . '" '.$select.'>' . $series['name'] . '</option>';
				array_push($series_id, $series['id']);
			}


		    	//select item from series
			if(count($series_id) > 0){
				$this->db->where_in('series_id', $series_id);
				$arr_items = $this->db->get(db_prefix().'items')->result_array();

				foreach ($arr_items as $item) {

					array_push($items_id, $item['id']);
				}

			}

		}

		if(isset($data['series_id']) && $data['series_id'] != ''){
			$items_id = [];
			$item_options = '';

	    	//select item from series
			$this->db->where('series_id', $data['series_id']);
			$arr_items = $this->db->get(db_prefix().'items')->result_array();
			foreach ($arr_items as $item) {
				array_push($items_id, $item['id']);
			}

		}

	    //get item from []
		$items = [];
		
		if(count($items_id) > 0){

			$this->db->order_by('name', 'asc');
			$groups = $this->db->get(db_prefix() . 'items_groups')->result_array();

			array_unshift($groups, [
				'id'   => 0,
				'name' => '',
			]);

			foreach ($groups as $group) {
				$this->db->select('*,' . db_prefix() . 'items_groups.name as group_name,' . db_prefix() . 'items.id as id');
				$this->db->where('group_id', $group['id']);
				$this->db->join(db_prefix() . 'items_groups', '' . db_prefix() . 'items_groups.id = ' . db_prefix() . 'items.group_id', 'left');
				$this->db->order_by('description', 'asc');
				$this->db->where_in(db_prefix().'items.id', $items_id);

				if(isset($data['warehouse_id']) && $data['warehouse_id'] != ''){
					$this->db->where_in(db_prefix().'items.warehouse_id', $data['warehouse_id']);
				}

				$_items = $this->db->get(db_prefix() . 'items')->result_array();

				if (count($_items) > 0) {
					$item_options .=' <option value=""></option>';
					$item_options .= '<optgroup data-group-id="'.$_items[0]['group_id'].'" label="'.$_items[0]['group_name'].'">';
					foreach ($_items as $i) {

						$item_options .= '<option value="'.$i['id'].'" data-subtext="'. strip_tags(mb_substr($i['long_description'],0,200)).'...' .'">('.app_format_number($item['rate']) .') '.$i['description'].'</option>';

					}
					$item_options .= ' </optgroup>';
				}
			}

		}

		$data_return =[];
		$data_return['item_options'] = $item_options;
		$data_return['model_options'] = $model_options;
		$data_return['series_options'] = $series_options;

		return $data_return;

	}


	/**
	 * get custom fields warehouse
	 * @param  boolean $id 
	 * @return [type]      
	 */
	public function get_custom_fields_warehouse($id = false) {

		if (is_numeric($id)) {
			$this->db->where('id', $id);

			return $this->db->get(db_prefix() . 'wh_custom_fields')->row();
		}
		if ($id == false) {
			return $this->db->query('select * from tblwh_custom_fields')->result_array();
		}

	}

	/**
	 * add custom fields warehouse
	 * @param array $data 
	 */
	public function add_custom_fields_warehouse($data) {

		if(is_array($data['warehouse_id'])){
			$data['warehouse_id'] = implode(',', $data['warehouse_id']);
		}


		$this->db->insert(db_prefix() . 'wh_custom_fields', $data);
		$insert_id = $this->db->insert_id();

		return $insert_id;
	}


	/**
	 * update custom fields warehouse
	 * @param  array $data 
	 * @param  integer $id   
	 * @return [type]       
	 */
	public function update_custom_fields_warehouse($data, $id) {

		if(is_array($data['warehouse_id'])){
			$data['warehouse_id'] = implode(',', $data['warehouse_id']);
		}

		$this->db->where('id', $id);
		$this->db->update(db_prefix() . 'wh_custom_fields', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return true;
	}


	/**
	 * delete custom fields warehouse
	 * @param integer $id 
	 * @return [type]     
	 */
	public function delete_custom_fields_warehouse($id) {

		$this->db->where('id', $id);
		$this->db->delete(db_prefix() . 'wh_custom_fields');

		if ($this->db->affected_rows() > 0) {
			return true;
		}

		return false;
	}


	/**
	 * check warehouse custom fields
	 * @param  [type] $data 
	 * @return [type]       
	 */
	public function check_warehouse_custom_fields($data)
	{	

		if(isset($data['id'])){
			$custom_fields_value = $this->get_custom_fields_warehouse($data['id']);
			if($custom_fields_value->custom_fields_id == $data['custom_fields_id']){
				return true;
			}else{
				$this->db->where('custom_fields_id', $data['custom_fields_id']);
				$this->db->where('id', $data['id']);

				$custom_fields = $this->db->get(db_prefix() . 'wh_custom_fields')->result_array();

				if(count($custom_fields) > 0){
					return false;
				}
				return true;
			}

		}else{
			return $this->check_warehouse_custom_fields_one($data['custom_fields_id']);
		}

	}


	/**
	 * check warehouse custom fields one
	 * @param  integer $custom_fields_id 
	 * @return [type]                   
	 */
	public function check_warehouse_custom_fields_one($custom_fields_id)
	{
		$this->db->where('custom_fields_id', $custom_fields_id);
		$custom_fields = $this->db->get(db_prefix() . 'wh_custom_fields')->row();
		if($custom_fields){
			return false;
		}
		return true;

	}

	/**
	 * get adjustment stock quantity
	 * @param  [type] $warehouse_id 
	 * @param  [type] $commodity_id 
	 * @param  [type] $lot_number   
	 * @param  [type] $expiry_date  
	 * @return [type]               
	 */
	public function get_adjustment_stock_quantity($warehouse_id, $commodity_id, $lot_number, $expiry_date) {

		if(isset($lot_number) && $lot_number != '0' && $lot_number != ''){
			/*have value*/
			$this->db->where('lot_number', $lot_number);

		}else{

			/*lot number is 0 or ''*/
			$this->db->group_start();

			$this->db->where('lot_number', '0');
			$this->db->or_where('lot_number', '');
			$this->db->or_where('lot_number', null);

			$this->db->group_end();
		}

		$this->db->where('warehouse_id', $warehouse_id);
		$this->db->where('commodity_id', $commodity_id);

		if($expiry_date == ''){
			$this->db->where('expiry_date', null);

		}else{
			$this->db->where('expiry_date', $expiry_date);
		}

		return $this->db->get(db_prefix() . 'inventory_manage')->row();


	}


	/**
	 * delivery note get data send mail
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delivery_note_get_data_send_mail($id)
	{
		$options ='';
		$primary_email='';
		$goods_delivery_userid ='';
		$goods_delivery = $this->get_goods_delivery($id);

		if($goods_delivery){
			$goods_delivery_userid = $goods_delivery->customer_code;
		}

		$array_customer = $this->clients_model->get();

		foreach ($array_customer as $key => $value) {
			$select='';
			if($value['userid'] == $goods_delivery_userid){
				$select .=' selected';

				$contact_value = $this->clients_model->get_contact($value['userid']);
				if($contact_value){
					$primary_email 	= $contact_value->email;
				}

			}
			$options .= '<option value="' . $value['userid'].'" '.$select.'>' . $value['company'] . '</option>';
		}

		$data=[];
		$data['options'] = $options;
		$data['primary_email'] = $primary_email;

		return $data;

	}


	/**
	 * get tags name
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_tags_name($id){
		/* get list tinymce start*/
		$this->db->from(db_prefix() . 'taggables');
		$this->db->join(db_prefix() . 'tags', db_prefix() . 'tags.id = ' . db_prefix() . 'taggables.tag_id', 'left');

		$this->db->where(db_prefix() . 'taggables.rel_id', $id);
		$this->db->where(db_prefix() . 'taggables.rel_type', 'item_tags');
		$this->db->order_by('tag_order', 'ASC');

		$item_tags = $this->db->get()->result_array();

		$array_tags_name = [];
		foreach ($item_tags as $tag_value) {
			array_push($array_tags_name, $tag_value['name']);
		}

		return implode(",", $array_tags_name);

	}

    /**
     * send delivery note
     * @param  [type] $data 
     * @return [type]       
     */
    public function send_delivery_note($data){

    	$staff_id = get_staff_user_id();

    	$inbox = array();

    	$inbox['to'] = $data['email'];
    	$inbox['sender_name'] = get_staff_full_name($staff_id);
    	$inbox['subject'] = _strip_tags($data['subject']);
    	$inbox['body'] = _strip_tags($data['content']);        
    	$inbox['body'] = nl2br_save_html($inbox['body']);
    	$inbox['date_received']      = date('Y-m-d H:i:s');
    	$inbox['from_email'] = get_option('smtp_email');

    	$companyname =  get_option('companyname');

    	if(strlen(get_option('smtp_host')) > 0 && strlen(get_option('smtp_password')) > 0 && strlen(get_option('smtp_username')) > 0){

    		$ci = &get_instance();
    		$ci->email->initialize();
    		$ci->load->library('email');    
    		$ci->email->clear(true);
    		$ci->email->from($inbox['from_email'], $inbox['sender_name']);
    		$ci->email->to($inbox['to']);

    		$ci->email->subject($inbox['subject']);

    		$email_footer = get_option('email_footer');
    		$email_footer = str_replace('{companyname}', $companyname, $email_footer);
    		$ci->email->message(get_option('email_header') . $inbox['body'] . $email_footer);

    		$attachment_url = site_url(WAREHOUSE_PATH.'send_delivery_note/'.$data['goods_delivery'].'/'.$_FILES['attachment']['name']);
    		$ci->email->attach($attachment_url);
    		if($ci->email->send(true)){
            	//write activity if delivery created from invoice
    			if(isset($data['invoice_id'])){
    				$this->load->model('invoices_model');
    				$this->invoices_model->log_invoice_activity($data['invoice_id'], _l('delivery_slip_sent_to_email_address').' '.$data['email']);

    			}
    			return true;
    		}else{
    			return false;

    		}
    	}

    	return false;
    }


    /**
     * check sku duplicate
     * @param  [type] $data 
     * @return [type]       
     */
    public function check_sku_duplicate($data)
    {	
    	if(isset($data['item_id']) && $data['item_id'] != ''){
    	//check update
    		$this->db->where('sku_code', $data['sku_code']);
    		$this->db->where('id != ', $data['item_id']);

    		$items = $this->db->get(db_prefix() . 'items')->result_array();

    		if(count($items) > 0){
    			return false;
    		}
    		return true;

    	}elseif(isset($data['sku_code']) && $data['sku_code'] != ''){
    	//check insert
    		$this->db->where('sku_code', $data['sku_code']);
    		$items = $this->db->get(db_prefix() . 'items')->row();
    		if($items){
    			return false;
    		}
    		return true;
    	}

    	return true;

    }

    /**
     * stock internal delivery pdf
     * @param  [type] $internal 
     * @return [type]           
     */
	public function stock_internal_delivery_pdf($internal) {
		return app_pdf('internal', module_dir_path(WAREHOUSE_MODULE_NAME, 'libraries/pdf/Internal_pdf.php'), $internal);
	}


	/**
	 * get stock internal delivery pdf_html
	 * @param  [type] $internal_delivery_id 
	 * @return [type]                    
	 */
	public function get_stock_internal_delivery_pdf_html($internal_delivery_id) {
		$this->load->model('currencies_model');
		$base_currency = $this->currencies_model->get_base_currency();
		// get_goods_receipt
		$internal_delivery = $this->get_internal_delivery($internal_delivery_id);
		// get_goods_receipt_detail
		$internal_delivery_detail = $this->get_internal_delivery_detail($internal_delivery_id);
		$company_name = get_option('invoice_company_name');
		$address = get_option('invoice_company_address');

		$day = date('d', strtotime($internal_delivery->date_add));
		$month = date('m', strtotime($internal_delivery->date_add));
		$year = date('Y', strtotime($internal_delivery->date_add));


		$html = '';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left">'.pdf_logo_url().'</td>
		<td class="text_right_weight "><h3>' . mb_strtoupper(_l('delivery')) . '</h3></td>
		</tr>

		<tr>
		<td class="text_right">#'.$internal_delivery->internal_delivery_code.' - '.$internal_delivery->internal_delivery_name.'</td>
		</tr>
		</tbody>
		</table>
		<br>
		';

	     //organization_info
		$organization_info = '<div  class="bill_to_color">';
		$organization_info .= format_organization_info();
		$organization_info .= '</div>';


	    //invoice_data_date
		$invoice_date = '<br /><b>' . _l('invoice_data_date') . ' ' . _d($internal_delivery->date_add) . '</b><br />';

		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left">'.$organization_info.'</td>
		<td rowspan="2" width="50%" class="text_right"></td>
		</tr>
		</tbody>
		</table>
		<br><br>
		<br><br>
		';

		
		$html .= '<table class="table">
		<tbody>
		<tr>
		<td rowspan="2" width="50%" class="text-left"></td>
		<td rowspan="2" width="50%" class="text_right">'.$invoice_date.'</td>
		</tr>
		</tbody>
		</table>
		<br><br><br>
		<br><br><br>
		';



		$html .= '<table class="table">
		<tbody>

		<tr>
		<th width="5%" class=" thead-dark-ip"><b>#</b></th>
		<th width="20%" class=" thead-dark-ip">' ._l('commodity_name').'</th>
		<th width="15%" class=" thead-dark-ip">' . _l('from_stock_name') . '</th>
		<th width="15%" class=" thead-dark-ip">' . _l('to_stock_name') . '</th>
		<th width="10%" class=" thead-dark-ip">' . _l('available_quantity') . '</th>
		<th width="10%" class=" thead-dark-ip">' . _l('quantity_export') . '</th>
		<th width="10%" class=" thead-dark-ip">' . _l('unit_price') . '</th>
		<th width="15%" class=" thead-dark-ip">' . _l('into_money') . '</th>

		</tr>';

		$warehouse_address 	= '';
		$array_warehouse	= [];
		foreach ($internal_delivery_detail as $delivery_key => $delivery_value) {
			$flag_from_warehouse = true;
			$flag_to_warehouse   = true;

			

			$item_order = $delivery_key +1;

			$commodity_name = get_commodity_name($delivery_value['commodity_code']) != null ? get_commodity_name($delivery_value['commodity_code'])->description : '';

			$available_quantity = (isset($delivery_value) ? $delivery_value['available_quantity'] : '');
			$quantities = (isset($delivery_value) ? $delivery_value['quantities'] : '');
			$unit_price = (isset($delivery_value) ? $delivery_value['unit_price'] : '');
			$into_money = (isset($delivery_value) ? $delivery_value['into_money'] : '');

			$commodity_code = get_commodity_name($delivery_value['commodity_code']) != null ? get_commodity_name($delivery_value['commodity_code'])->commodity_code : '';


			$from_stock_name ='';
			if(isset($delivery_value['from_stock_name']) && ($delivery_value['from_stock_name'] !='')){
				$arr_warehouse = explode(',', $delivery_value['from_stock_name']);

				$str = '';
				if(count($arr_warehouse) > 0){

					foreach ($arr_warehouse as $wh_key => $warehouseid) {
						$str = '';
						if ($warehouseid != '' && $warehouseid != '0') {

							$team = get_warehouse_name($warehouseid);
							if($team){
								$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide"> </span></span>';

								$from_stock_name .= $str;
								if($wh_key%3 ==0){
									$from_stock_name .='<br/>';
								}

								//get warehouse address
								if(!in_array($warehouseid, $array_warehouse)){
									$warehouse_address .= '<b>' .$team->warehouse_name .' : </b>'. wh_get_warehouse_address($warehouseid) .'.'.'<br/>';
								}
							}

						}
					}

				} else {
					$from_stock_name = '';
				}
			}

			$to_stock_name ='';
			if(isset($delivery_value['to_stock_name']) && ($delivery_value['to_stock_name'] !='')){
				$arr_warehouse = explode(',', $delivery_value['to_stock_name']);

				$str = '';
				if(count($arr_warehouse) > 0){

					foreach ($arr_warehouse as $wh_key => $warehouseid) {
						$str = '';
						if ($warehouseid != '' && $warehouseid != '0') {

							$team = get_warehouse_name($warehouseid);
							if($team){
								$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide"> </span></span>';

								$to_stock_name .= $str;
								if($wh_key%3 ==0){
									$to_stock_name .='<br/>';
								}
								//get warehouse address
								if(!in_array($warehouseid, $array_warehouse)){
									$warehouse_address .= '<b>' .$team->warehouse_name .' : </b>'. wh_get_warehouse_address($warehouseid) .'.'.'<br/>';
								}
							}

						}
					}

				} else {
					$to_stock_name = '';
				}
			}
			


			$unit_name = '';
			if(isset($delivery_value['unit_id']) && ($delivery_value['unit_id'] !='')){
				$unit_name = get_unit_type($delivery_value['unit_id']) != null ? get_unit_type($delivery_value['unit_id'])->unit_name : '';
			}

			$html .= '<tr>';
			$html .= '<td class=""><b>' . (float)$item_order . '</b></td>
			<td class=""><b>' . $commodity_code .'#'.$commodity_name . '</b></td>
			<td class="td_style_r_ep_c">' . $from_stock_name. '</td>
			<td class="td_style_r_ep_c">' . $to_stock_name. '</td>
			<td class="td_style_r_ep_c">' . $available_quantity .' '.$unit_name. '</td>
			<td class="td_style_r_ep">' . $quantities .' '.$unit_name. '</td>';

			$html .= ' <td class="td_style_r_ep">' . app_format_money((float) $unit_price, '') . '</td>
			<td class="td_style_r_ep"><b>' . app_format_money((float) $into_money, '') . '</b></td>';
			
			$html .= '</tr>';
		}

		$html .= '</tbody>';
		$html .= '</table>
		<br>
		<br>';



		$html .= '<table class="table">
		<tbody>
		<tr>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td class="text_left"><b>' . _l('total_amount') . '</b></td>
		<td class="text_right">' .$base_currency->symbol. app_format_money((float) $internal_delivery->total_amount, '') . '</td>
		</tr>
		</tbody>
		</table>
		<br>
		';


		$html .=  '<h4 class="note-align">' . _l('warehouse_address') . ':</h4>
		<p>' . $warehouse_address . '</p>';
		
		$html .=  '<h4 class="note-align">' . _l('note_') . ':</h4>
		<p>' . $internal_delivery->description . '</p>';


		$html .= '<table class="table">
		<tbody>
		<tr>
		<td class="fw_width35"><h4>' . _l('deliver_name') . '</h4></td>
		<td class="fw_width30"><h4>' . _l('stocker') . '</h4></td>
		<td class="fw_width30"><h4>' . _l('chief_accountant') . '</h4></td>

		</tr>
		<tr>


		<td class="fw_width35 fstyle">' . _l('sign_full_name') . '</td>
		<td class="fw_width30 fstyle ">' . _l('sign_full_name') . '</td>
		<td class="fw_width30 fstyle">' . _l('sign_full_name') . '</td>
		</tr>

		</tbody>
		</table>

		<br>
		<br>
		<br>
		<br>
		<table class="table">
		<tbody>
		<tr>';



		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';
		return $html;
	}



	public function print_barcode_pdf($print_barcode) {
		return app_pdf('print_barcode', module_dir_path(WAREHOUSE_MODULE_NAME, 'libraries/pdf/Print_barcode_pdf.php'), $print_barcode);
	}


	/**
	 * get stock internal delivery pdf_html
	 * @param  [type] $internal_delivery_id 
	 * @return [type]                    
	 */
	public function get_print_barcode_pdf_html($data) {
		$html ='';

		$html .= '<table class="table">
		<tbody>';
		

		if($data['select_item'] == 0){
			//select all
			$array_commodity = $this->get_commodity();
			$html_child='';
			foreach ($array_commodity as $key => $value) {
				if(!file_exists(WAREHOUSE_PRINT_ITEM. md5($value['commodity_barcode']).'.svg')){
				    $this->getBarcode($value['commodity_barcode']);
				}

				$html_child .= '<td><span class="print-item"><img class="images_w_table" src="' . site_url('modules/warehouse/uploads/print_item/' . md5($value['commodity_barcode']).'.svg') . '" alt="' . $value['commodity_barcode'] . '" ></span><span class="print-item-code">'.$value['commodity_barcode'].'</span></td>';

				if(($key+1)%4 == 0 ){
					$html .= '<tr>'.$html_child.'</tr>';
					$html_child='';
				}elseif(($key+1)%4 != 0 && ($key+1 == count($array_commodity))){
					$html .= '<tr>'.$html_child.'</tr>';
					$html_child='';
				}
			}



		}else{
			//select item check
			if(isset($data['item_select_print_barcode'])){

				$sql_where ='select * from '.db_prefix().'items where id IN ('.implode(", ", $data['item_select_print_barcode']).') order by id desc';
				$array_commodity =  $this->db->query($sql_where)->result_array();

				$html_child='';
				foreach ($array_commodity as $key => $value) {

				    if(!file_exists(WAREHOUSE_PRINT_ITEM. md5($value['commodity_barcode']).'.svg')){
					    $this->getBarcode($value['commodity_barcode']);
					}

					$html_child .= '<td><span class="print-item"><img class="images_w_table" src="' . site_url('modules/warehouse/uploads/print_item/' . md5($value['commodity_barcode']).'.svg') . '" alt="' . $value['commodity_barcode'] . '" ></span><span class="print-item-code">'.$value['commodity_barcode'].'</span></td>';


					if(($key+1)%4 == 0 ){
						$html .= '<tr>'.$html_child.'</tr>';
						$html_child='';
					}elseif(($key+1)%4 != 0 && ($key+1 == count($array_commodity))){
						$html .= '<tr>'.$html_child.'</tr>';
						$html_child='';
					}
				}
			}
		}

		$html .= '</tbody>
		</table>
		<br><br><br>
		';

		$html .= '<link href="' . module_dir_url(WAREHOUSE_MODULE_NAME, 'assets/css/pdf_style.css') . '"  rel="stylesheet" type="text/css" />';
		return $html;
	}
	

	/**
	 * getBarcode
	 * @param  [type] $sample 
	 * @return [type]         
	 */
	function getBarcode($sample)
	{
	    if (!$sample) {
	        echo "";
	    } else {
	        $barcodeobj = new TCPDFBarcode($sample, 'EAN13');
	        $code = $barcodeobj->getBarcodeSVGcode(4, 70, 'black');
			file_put_contents(WAREHOUSE_PRINT_ITEM.md5($sample).'.svg', $code);

			return true;
	    }
	}


	/**
	 * get purchase price from commodity id
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_purchase_price_from_commodity_id($id, $sale_price = false)
    {	
    	$purchase_price=0;

    	$this->db->where('id', $id);
    	$item_value = $this->db->get(db_prefix().'items')->row();

    	if($item_value){
    		if($sale_price == false){
	    		$purchase_price = $item_value->purchase_price;
	    	}else{
	    		$purchase_price = $item_value->rate;

	    	}
    	}

    	return $purchase_price;
    }

    /**
     * get list parent item
     * @return [type] 
     */

    public function get_list_parent_item($data)
	{
		 $item_options = '';

		if(isset($data['id']) && $data['id'] != ''){
			/*get main item for case update*/
			//get parent id checked
			$this->db->where('id', $data['id']);
			$item_value = $this->db->get(db_prefix().'items')->row();

			if($item_value){
				$parent_id = $item_value->parent_id;
			}else{
				$parent_id = '';
			}


			$sql_where = "id != ".$data['id']." AND ( parent_id is null OR parent_id = '') ";
			$this->db->where($sql_where);

			$list_item = $this->db->get(db_prefix().'items')->result_array();

    		$item_options .= '<option value=""></option>';

			foreach ($list_item as $item) {

	            	$select='';

	            	if($item['id'] == $parent_id){           
	            		$select .= 'selected';
	            	}
              		$item_options .= '<option value="' . $item['id'] . '" '.$select.'>' . $item['commodity_code'] . ' - '.$item['description']. '</option>';
	            }

		}else{
			/*get sub main item for case create new*/
        	$this->db->where('parent_id', null);
        	$this->db->or_where('parent_id', '');
    		$arr_item = $this->db->get(db_prefix().'items')->result_array();

    		$item_options .= '<option value=""></option>';
    		foreach ($arr_item as $item) {
    			$item_options .= '<option value="' . $item['id'] . '">' . $item['commodity_code'] . ' - '.$item['description']. '</option>';
            }

		}
	   
    	$data_return =[];
    	$data_return['item_options'] = $item_options;

		return $data_return;

	}

    /**
     * get variation html
     * @param  [type] $id 
     * @return [type]     
     */
    public function get_variation_html($id)
    {
    	$index=0;
		$html = '';

    	if (is_numeric($id)) {

    			$item = $this->get_commodity($id);

    			if($item){
					$variation_value = json_decode($item->parent_attributes);

					if($variation_value){
						foreach ($variation_value as $key => $value) {
							$index++;
							if ($key == 0) {
								$variation_attr =[];
		                        $variation_attr['row'] = '1';

								$html .= '<div id="item_approve">
								<div class="col-md-11">
								<div class="col-md-4">
								' . render_input('name['.$key.']','variation_name', $value->name, 'text') . '
								</div>
								<div class="col-md-8">
								<div class="options_wrapper">
								<span class="pull-left fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Populate the field by separating the options by coma. eq. apple,orange,banana"></span>
								' . render_textarea('options['.$key.']', 'variation_options', implode(",", $value->options) , $variation_attr) . '
								</div>
								</div>
								</div>
								<div class="col-md-1 new_vendor_requests_button" >
								<span class="pull-bot">
								<button name="add" class="btn new_wh_approval btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
								</span>
								</div>
								</div>';
							} else {
								$html .= '<div id="item_approve">
								<div class="col-md-11">
								<div class="col-md-4">
								' . render_input('name['.$key.']','variation_name', $value->name, 'text') . '
								</div>
								<div class="col-md-8">
								<div class="options_wrapper">
								<span class="pull-left fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Populate the field by separating the options by coma. eq. apple,orange,banana"></span>
								' . render_textarea('options['.$key.']', 'variation_options', implode(",", $value->options) , $variation_attr) . '
								</div>
								</div>
								</div>
								<div class="col-md-1 new_vendor_requests_button" >
								<span class="pull-bot">
								<button name="add" class="btn remove_wh_approval btn-danger" data-ticket="true" type="button"><i class="fa fa-minus"></i></button>
								</span>
								</div>
								</div>';
							}
						}
					}else{
						$html = $this->parent_variation_sample_html();
					}
				}else{
					$html = $this->parent_variation_sample_html();
				}
			} else {

				$html = $this->parent_variation_sample_html();
			}

		return ['index' => $index, 'html' => $html];

    }


    /**
     * parent variation sample html
     * @return [type] 
     */
    public function parent_variation_sample_html()
    {	
    	$html ='';
    	$variation_attr =[];
        $variation_attr['row'] = '1';

		$html .= '<div id="item_approve">
		<div class="col-md-11">
		<div class="col-md-4">
		' .  render_input('name[0]','variation_name', '', 'text') . '
		</div>
		<div class="col-md-8">
			<div class="options_wrapper">
			<span class="pull-left fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Populate the field by separating the options by coma. eq. apple,orange,banana"></span>
			' . render_textarea('options[0]', 'variation_options', '' , $variation_attr) . '
			</div>
			</div>
		</div>
		<div class="col-md-1 new_vendor_requests_button">
		<span class="pull-bot">
		<button name="add" class="btn new_wh_approval btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
		</span>
		</div>
		</div>';

		return $html;
    }


    /**
     * get variation from parent item
     * @param  [type] $data 
     * @return [type]       
     */
    public function get_variation_from_parent_item($data)
    {
    	//parent_id, item_id
    	$index=0;
		$html = '';
    	
    	if(isset($data['item_id']) && $data['item_id'] != 0 && $data['item_id'] != ''){
    	// update
    	//case has parent id, don't parent_id
    		if(isset($data['parent_id']) && $data['parent_id'] != ''){
    			//child item
    			$item_value = $this->get_commodity($data['items_id']);

    			if($item_value->parent_id == $data['parent_id']){

    			}else{
    				$parent_value = $this->get_commodity($data['parent_id']);
    				$parent_variation = json_encode($parent_value->parent_attributes);

    			}
    			
    		}else{
    			//parent item
    		}
    	
    	}else{
    	//insert
    	//case has parent_id, don't parent_id
    		if(isset($data['parent_id']) && $data['parent_id'] != ''){
    			//child item
    		}else{
    			//parent item
    		}
    	
    	}
    }
}