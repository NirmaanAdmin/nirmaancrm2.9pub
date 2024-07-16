<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * get client details for a call log
 * @since  2.2.0
 * @param  mixed  $id call id
 * @return boolean
 */
// function get_call_log_for($id = null) {
//    if(!$id) return false;

// 	$CI = &get_instance();

// 	$CI->db->select('*');
// 	$CI->db->where('staffid', $id);
// 	$staff = $CI->db->get('tblstaff')->row();

// 	if (!$staff) {
// 		return false;
// 	}

// 	return array('fullname'=> $staff->firstname . ' ' . $staff->lastname, 'staffid' => $staff->staffid);
// }

// function get_driver_name_by_id($id) {
// 	$CI =& get_instance();
// 	$row = $CI->db->select('firstname,lastname')->where('staffid',$id)->get('tblstaff')->row();
// 	return $row->firstname.' '.$row->lastname;
// }
// function get_roles() {
// 	$CI = &get_instance();
// 	$query = $CI->db->get('tblroles');
// 	return $query->result();
// }
// function get_role_id_by_name($role_name) {
// 	$CI = &get_instance();
// 	return $CI->db->select('roleid')->where('name',$role_name)->get('tblroles')->row()->roleid;
// }
