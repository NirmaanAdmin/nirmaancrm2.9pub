<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
     
    
    'pur_rq_name',
    'requester',
    'department', 
    'request_date',
    'status',
    'id',
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'pur_request';
$join         = [ 'LEFT JOIN '.db_prefix().'departments ON '.db_prefix().'departments.departmentid = '.db_prefix().'pur_request.department' ];
$where = [];


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','name','pur_rq_code']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

   for ($i = 0; $i < count($aColumns); $i++) {

        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i] == 'request_date'){
            $_data = _dt($aRow['request_date']);
        }elseif($aColumns[$i] == 'requester'){
            $_data = '<a href="' . admin_url('staff/profile/' . $aRow['requester']) . '">' . staff_profile_image($aRow['requester'], [
                'staff-profile-image-small',
                ]) . '</a>';
            $_data .= ' <a href="' . admin_url('staff/profile/' . $aRow['requester']) . '">' . get_staff_full_name($aRow['requester']) . '</a>';
        }elseif($aColumns[$i] == 'department'){
            $_data = $aRow['name'];
        }elseif ($aColumns[$i] == 'status') {
            $_data = get_status_approve($aRow['status']);
        }elseif($aColumns[$i] == 'pur_rq_name'){
            $name = '<a href="' . admin_url('purchase/view_pur_request/' . $aRow['id'] ).'">'.$aRow['pur_rq_code'].' - ' . $aRow['pur_rq_name'] . '</a>';

            $name .= '<div class="row-options">';

            $name .= '<a href="' . admin_url('purchase/view_pur_request/' . $aRow['id'] ).'" >' . _l('view') . '</a>';

            if ( (has_permission('recruitment', '', 'edit') || is_admin()) &&  $aRow['status'] != 2) {
                $name .= ' | <a href="' . admin_url('purchase/pur_request/' . $aRow['id'] ).'" >' . _l('edit') . '</a>';
            }

            if (has_permission('recruitment', '', 'delete') || is_admin()) {
                $name .= ' | <a href="' . admin_url('purchase/delete_pur_request/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
            }

            $name .= '</div>';

            $_data = $name;
        }elseif($aColumns[$i] == 'id'){
            if($aRow['status'] == 2){
                $_data = '<div class="btn-group mright5" data-toggle="tooltip" title="'._l('request_quotation_tooltip').'">
                           <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-file-pdf-o"></i><span class="caret"></span></a>
                           <ul class="dropdown-menu dropdown-menu-right">
                              <li class="hidden-xs"><a href="'. admin_url('purchase/request_quotation_pdf/'.$aRow['id'].'?output_type=I').'">'. _l('view_pdf').'</a></li>
                              <li class="hidden-xs"><a href="'. admin_url('purchase/request_quotation_pdf/'.$aRow['id'].'?output_type=I').'" target="_blank">'. _l('view_pdf_in_new_window').'</a></li>
                              <li><a href="'.admin_url('purchase/request_quotation_pdf/'.$aRow['id']).'">'. _l('download').'</a></li>
                           </ul>
                           </div>';

                $_data .= '<a href="#" onclick="send_request_quotation('.$aRow['id'].'); return false;" class="btn btn-success" ><i class="fa fa-envelope" data-toggle="tooltip" title="'. _l('request_quotation') .'"></i></a>';

            }else{
                $_data = '';
            }
        }

        $row[] = $_data;
    }
    $output['aaData'][] = $row;

}
