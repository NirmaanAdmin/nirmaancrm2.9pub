<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'1',
	db_prefix() . 'items.id',
	'commodity_code',
	'description',
	'sku_code',
	'group_id',
	db_prefix() . 'items.warehouse_id',
	'(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'items.id and rel_type="item_tags" ORDER by tag_order ASC) as tags',
	'commodity_barcode',
	'unit_id',
	'rate',
	'purchase_price',
	'tax',
	'origin',
	'2',	//minimum stock
	'3',	//maximum stock
];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'items';

$where = [];

$warehouse_ft = $this->ci->input->post('warehouse_ft');
$commodity_ft = $this->ci->input->post('commodity_ft');
$alert_filter = $this->ci->input->post('alert_filter');

$tags_ft = $this->ci->input->post('item_filter');

$join= [];



$where[] = 'AND '.db_prefix().'items.active = 1';

if (isset($warehouse_ft)) {
	$arr_commodity_id = $this->ci->warehouse_model->get_commodity_in_warehouse($warehouse_ft);

	$where[] = 'AND '.db_prefix().'items.id IN (' . implode(', ', $arr_commodity_id) . ')';
	
}

if (isset($commodity_ft)) {
	$where_commodity_ft = '';
	foreach ($commodity_ft as $commodity_id) {
		if ($commodity_id != '') {
			if ($where_commodity_ft == '') {
				$where_commodity_ft .= ' AND (tblitems.id = "' . $commodity_id . '"';
			} else {
				$where_commodity_ft .= ' or tblitems.id = "' . $commodity_id . '"';
			}
		}
	}
	if ($where_commodity_ft != '') {
		$where_commodity_ft .= ')';
		array_push($where, $where_commodity_ft);
	}
}

/*alert_filter*/
if (isset($alert_filter)) {
	if ($alert_filter != '') {
		if ($alert_filter == "1") {
			//out of stock
			$arr_commodity_id = $this->ci->warehouse_model->get_commodity_alert($alert_filter);
			if(count($arr_commodity_id) > 0){
				$where[] = 'AND '.db_prefix().'items.id IN (' . implode(', ', $arr_commodity_id) . ')';

			}


		} else {
			//exprired
			$arr_commodity_id = $this->ci->warehouse_model->get_commodity_alert($alert_filter);

			if(count($arr_commodity_id) > 0){
				$where[] = 'AND '.db_prefix().'items.id IN (' . implode(', ', $arr_commodity_id) . ')';
			}

		}
	}
}


//tags filter
if (isset($tags_ft)) {
	$where_tags_ft = '';
	foreach ($tags_ft as $commodity_id) {
		if ($commodity_id != '') {
			if ($where_tags_ft == '') {
				$where_tags_ft .= ' AND (tblitems.id = "' . $commodity_id . '"';
			} else {
				$where_tags_ft .= ' or tblitems.id = "' . $commodity_id . '"';
			}
		}
	}
	if ($where_tags_ft != '') {
		$where_tags_ft .= ')';
		array_push($where, $where_tags_ft);
	}
}


$custom_fields = get_custom_fields('items', [
    'show_on_table' => 1,
    ]);
    

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);

    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'items.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="items_pr" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'items.id', db_prefix() . 'items.description', db_prefix() . 'items.unit_id', db_prefix() . 'items.commodity_code', db_prefix() . 'items.commodity_barcode', db_prefix() . 'items.commodity_type', db_prefix() . 'items.warehouse_id', db_prefix() . 'items.origin', db_prefix() . 'items.color_id', db_prefix() . 'items.style_id', db_prefix() . 'items.model_id', db_prefix() . 'items.size_id', db_prefix() . 'items.rate', db_prefix() . 'items.tax', db_prefix() . 'items.group_id', db_prefix() . 'items.long_description', db_prefix() . 'items.sku_code', db_prefix() . 'items.sku_name', db_prefix() . 'items.sub_group', db_prefix() . 'items.color', db_prefix() . 'items.guarantee', db_prefix().'items.profif_ratio', db_prefix().'items.without_checking_warehouse', db_prefix().'items.parent_id']);

$output = $result['output'];
$rResult = $result['rResult'];



	foreach ($rResult as $aRow) {
		$row = [];
		for ($i = 0; $i < count($aColumns); $i++) {

			 if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
	            $_data = $aRow[strafter($aColumns[$i], 'as ')];
	        } else {
				$_data = $aRow[$aColumns[$i]];
	        }


			/*get commodity file*/
			$arr_images = $this->ci->warehouse_model->get_warehourse_attachments($aRow['id']);
			if($aColumns[$i] == db_prefix() . 'items.id'){
				if (count($arr_images) > 0) {

					if (file_exists(WAREHOUSE_ITEM_UPLOAD . $arr_images[0]['rel_id'] . '/' . $arr_images[0]['file_name'])) {
						$_data = '<img class="images_w_table" src="' . site_url('modules/warehouse/uploads/item_img/' . $arr_images[0]['rel_id'] . '/' . $arr_images[0]['file_name']) . '" alt="' . $arr_images[0]['file_name'] . '" >';
					} elseif(file_exists('modules/purchase/uploads/item_img/' . $arr_images[0]['rel_id'] . '/' . $arr_images[0]['file_name'])) {
						$_data = '<img class="images_w_table" src="' . site_url('modules/purchase/uploads/item_img/' . $arr_images[0]['rel_id'] . '/' . $arr_images[0]['file_name']) . '" alt="' . $arr_images[0]['file_name'] . '" >';
					}else{
						$_data = '<img class="images_w_table" src="' . site_url('modules/warehouse/uploads/nul_image.jpg') . '" alt="nul_image.jpg">';
					}

				} else {

					$_data = '<img class="images_w_table" src="' . site_url('modules/warehouse/uploads/nul_image.jpg') . '" alt="nul_image.jpg">';
				}
			}

			if ($aColumns[$i] == 'commodity_code') {
				$code = '<a href="' . admin_url('warehouse/view_commodity_detail/' . $aRow['id']) . '">' . $aRow['commodity_code'] . '</a>';
				$code .= '<div class="row-options">';

				$code .= '<a href="' . admin_url('warehouse/view_commodity_detail/' . $aRow['id']) . '" >' . _l('view') . '</a>';

				if (has_permission('warehouse', '', 'edit') || is_admin()) {
					$code .= ' | <a href="#" onclick="edit_commodity_item(this); return false;"  data-commodity_id="' . $aRow['id'] . '" data-description="' . $aRow['description'] . '" data-unit_id="' . $aRow['unit_id'] . '" data-commodity_code="' . $aRow['commodity_code'] . '" data-commodity_barcode="' . $aRow['commodity_barcode'] . '" data-commodity_type="' . $aRow['commodity_type'] . '" data-origin="' . $aRow['origin'] . '" data-color_id="' . $aRow['color_id'] . '" data-style_id="' . $aRow['style_id'] . '" data-model_id="' . $aRow['model_id'] . '" data-size_id="' . $aRow['size_id'] . '"  data-rate="' . app_format_money($aRow['rate'], '') . '" data-group_id="' . $aRow['group_id'] . '" data-tax="' . $aRow['tax'] . '"  data-warehouse_id="' . $aRow['warehouse_id'] . '" data-sku_code="' . $aRow['sku_code'] . '" data-sku_name="' . $aRow['sku_name'] . '" data-sub_group="' . $aRow['sub_group'] . '" data-purchase_price="' . $aRow['purchase_price'] . '" data-color="' . $aRow['color'] . '" data-guarantee="' . $aRow['guarantee'] . '" data-profif_ratio="' . $aRow['profif_ratio'] . '" data-without_checking_warehouse="' . $aRow['without_checking_warehouse'] . '" data-parent_id="' . $aRow['parent_id'] . '" >' . _l('edit') . '</a>';
				}
				if (has_permission('warehouse', '', 'delete') || is_admin()) {
					$code .= ' | <a href="' . admin_url('warehouse/delete_commodity/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
				}

				$code .= '</div>';

				$_data = $code;

			}elseif($aColumns[$i] == '1'){
				$_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
			} elseif ($aColumns[$i] == 'description') {
				$inventory = $this->ci->warehouse_model->check_inventory_min($aRow['id']);

				if ($inventory) {
					$_data = '<a href="#" onclick="show_detail_item(this);return false;" data-name="' . $aRow['description'] . '"  data-commodity_id="' . $aRow['id'] . '"  >' . $aRow['description'] . '</a>';
				} else {

					$_data = '<a href="#" class="text-danger"  onclick="show_detail_item(this);return false;" data-name="' . $aRow['description'] . '" data-warehouse_id="' . $aRow['warehouse_id'] . '" data-commodity_id="' . $aRow['id'] . '"  >' . $aRow['description'] . '</a>';
					
				}

			}elseif($aColumns[$i] == 'sku_code'){
				$_data = '<span class="label label-tag tag-id-1"><span class="tag">' . $aRow['sku_code'] . '</span><span class="hide">, </span></span>&nbsp';
			} elseif ($aColumns[$i] == 'group_id') {
				$_data = get_wh_group_name($aRow['group_id']) != null ? get_wh_group_name($aRow['group_id'])->name : '';
			} elseif ($aColumns[$i] == db_prefix() . 'items.warehouse_id') {
				$_data ='';
				$arr_warehouse = get_warehouse_by_commodity($aRow['id']);

				$str = '';
				if(count($arr_warehouse) > 0){
					foreach ($arr_warehouse as $wh_key => $warehouseid) {
						$str = '';
						if ($warehouseid['warehouse_id'] != '' && $warehouseid['warehouse_id'] != '0') {
							//get inventory quantity
							$inventory_quantity = $this->ci->warehouse_model->get_quantity_inventory($warehouseid['warehouse_id'], $aRow['id']);
							$quantity_by_warehouse =0;
							if($inventory_quantity){
								$quantity_by_warehouse = $inventory_quantity->inventory_number;
							}

							$team = get_warehouse_name($warehouseid['warehouse_id']);
							if($team){
								$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . ': ( '.$quantity_by_warehouse.' )</span><span class="hide">, </span></span>&nbsp';

								$_data .= $str;
								if($wh_key%3 ==0){
									$_data .='<br/>';
								}
							}

						}
					}

				} else {
					$_data = '';
				}


			}elseif($aColumns[$i] == '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'items.id and rel_type="item_tags" ORDER by tag_order ASC) as tags'){
				
				$_data = render_tags($aRow['tags']);

			} elseif ($aColumns[$i] == 'unit_id') {
				if ($aRow['unit_id'] != null) {
					$_data = get_unit_type($aRow['unit_id']) != null ? get_unit_type($aRow['unit_id'])->unit_name : '';
				} else {
					$_data = '';
				}
			} elseif ($aColumns[$i] == 'rate') {
				$_data = app_format_money((float) $aRow['rate'], '');
			} elseif ($aColumns[$i] == 'purchase_price') {
				$_data = app_format_money((float) $aRow['purchase_price'], '');

			} elseif ($aColumns[$i] == 'tax') {
				$_data ='';
				$tax_rate = get_tax_rate($aRow['tax']);
				if($aRow['tax']){
					if($tax_rate && $tax_rate != null && $tax_rate != 'null'){
						$_data = $tax_rate->name;
					}
				}

			} elseif ($aColumns[$i] == 'commodity_barcode') {
				/*inventory number*/
				$inventory_number = 0;
        		$inventory = $this->ci->warehouse_model->get_inventory_by_commodity($aRow['id']);

        		if($inventory){
        			$inventory_number =  $inventory->inventory_number;
        		}
				$_data = $inventory_number;

			} elseif ($aColumns[$i] == 'origin') {

        		$inventory = $this->ci->warehouse_model->check_inventory_min($aRow['id']);


				if ($inventory) {
					$_data = '';
				} else {
					$_data = '<span class="label label-tag tag-id-1 label-tabus "><span class="tag text-danger">' . _l('unsafe_inventory') . '</span><span class="hide">, </span></span>&nbsp';
				}
			} elseif ($aColumns[$i] == '2') {
				/*3: minmumstock, maximum stock*/
				$minmumstock = '';

				$inventory_min = $this->ci->warehouse_model->get_inventory_min($aRow['id']);
				if($inventory_min){

					$minmumstock .= $inventory_min->inventory_number_min ;
				}


				$_data =  $minmumstock;

			}elseif ($aColumns[$i] == '3') {
				/*3: minmumstock, maximum stock*/
				$maxmumstock = '';

				$inventory_min = $this->ci->warehouse_model->get_inventory_min($aRow['id']);
				if($inventory_min){

					$maxmumstock .= $inventory_min->inventory_number_max ;
				}

				$_data = $maxmumstock;

			}


			$row[] = $_data;

		}
		$output['aaData'][] = $row;
	}

