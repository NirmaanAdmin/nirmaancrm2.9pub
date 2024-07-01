<?php

defined('BASEPATH') or exit('No direct script access allowed');


$aColumns = [
    '1',
    'id',
    'commodity_code',
    'description',
    'group_id',
    'unit_id',
    'rate',
    'purchase_price',
    'tax',
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'items';



$where = [];


$join =[];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'commodity_barcode', 
    'group_id' ,
    'long_description' ,  
    'sku_code',  
    'sku_name',  
    ]);


$output  = $result['output'];
$rResult = $result['rResult'];


foreach ($rResult as $aRow) {
     $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        /*get commodity file*/
        if ($aColumns[$i] == 'id') {
            $arr_images = $this->ci->purchase_model->get_item_attachments($aRow['id']);
            if(count($arr_images) > 0){
                if(file_exists(PURCHASE_MODULE_ITEM_UPLOAD_FOLDER .$arr_images[0]['rel_id'] .'/'.$arr_images[0]['file_name'])){
                    $_data = '<img class="images_w_table" src="' . site_url('modules/purchase/uploads/item_img/' . $arr_images[0]['rel_id'] .'/'.$arr_images[0]['file_name']).'" alt="'.$arr_images[0]['file_name'] .'" >';
                }else{
                    $_data = '<img class="images_w_table" src="' . site_url('modules/warehouse/uploads/item_img/' . $arr_images[0]['rel_id'] .'/'.$arr_images[0]['file_name']).'" alt="'.$arr_images[0]['file_name'] .'" >';
                }

            }else{

                $_data = '<img class="images_w_table" src="' . site_url('modules/purchase/uploads/nul_image.jpg' ).'" alt="nul_image.jpg">';
            }
        }


         if($aColumns[$i] == 'commodity_code') {
             $code = '<a href="' . admin_url('purchase/commodity_detail/' . $aRow['id'] ).'" onclick="init_commodity_detail('.$aRow['id'].'); return false;">' . $aRow['commodity_code'] . '</a>';
              $code .= '<div class="row-options">';

            $code .= '<a href="' . admin_url('purchase/commodity_detail/' . $aRow['id'] ).'" onclick="init_commodity_detail('.$aRow['id'].'); return false;">' . _l('view') . '</a>';
            if (has_permission('purchase', '', 'edit') || is_admin()) {
                $code .= ' | <a href="#" onclick="edit_commodity_item(this); return false;"  data-commodity_id="'.$aRow['id'].'" data-description="'.$aRow['description'].'" data-unit_id="'.$aRow['unit_id'].'" data-commodity_code="'.$aRow['commodity_code'].'" data-commodity_barcode="'.$aRow['commodity_barcode'].'" data-long_description="'.$aRow['long_description'].'" data-rate="'.app_format_money($aRow['rate'],'').'" data-group_id="'.$aRow['group_id'].'" data-tax="'.$aRow['tax'].'"  data-sku_code="'.$aRow['sku_code'].'" data-sku_name="'.$aRow['sku_name'].'" data-purchase_price="'.$aRow['purchase_price'].'" >' . _l('edit') . '</a>';
            }
            if (has_permission('purchase', '', 'delete') || is_admin()) {
                $code .= ' | <a href="' . admin_url('purchase/delete_commodity/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
            }

            $code .= '</div>';


            $_data = $code;

        }elseif ($aColumns[$i] == 'description') {
            
            $_data = $aRow['description'];

        }elseif ($aColumns[$i] == 'unit_id') {
            if($aRow['unit_id'] != null){
                $_data = get_unit_type_item($aRow['unit_id']) != null ? get_unit_type_item($aRow['unit_id'])->unit_name : '';
            }else{
                $data = '';
            }
        }elseif ($aColumns[$i] == 'rate') {
            $_data = app_format_money((float)$aRow['rate'],'');
        }elseif($aColumns[$i] == 'purchase_price'){
            $_data = app_format_money((float)$aRow['purchase_price'],'');

        }elseif ($aColumns[$i] == 'tax') {
            $_data ='';
            $tax_rate = get_tax_rate_item($aRow['tax']);
            if($aRow['tax']){
                if($tax_rate && $tax_rate != null && $tax_rate != 'null'){
                    $_data = $tax_rate->name;
                }
            }

        }elseif ($aColumns[$i] == 'group_id') {
            if($aRow['group_id'] != null){
                $_data = get_group_name_item($aRow['group_id']) != null ? get_group_name_item($aRow['group_id'])->name : '';
            }else{
                $_data = '';
            }
        }elseif($aColumns[$i] == '1'){
                $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
            }
     
     
    $row[] = $_data;
        
    }
    $output['aaData'][] = $row;
}

