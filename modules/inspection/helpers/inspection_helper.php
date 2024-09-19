<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Check whether column exists in a table
 * Custom function because Codeigniter is caching the tables and this is causing issues in migrations
 * @param  string $column column name to check
 * @param  string $table table name to check
 * @return boolean
 */
/**
 * Determines whether the specified identifier is empty vendor company.
 *
 * @param      <type>   $id     The identifier
 *
 * @return     boolean  True if the specified identifier is empty vendor company, False otherwise.
 */

function done_by_list_ids($data)
{
	$result = '';
	if(!empty($data)) {
		$result = explode(',', $data);
		sort($result);
		$result = implode(',', $result);
	}
    return $result;
}

function done_by_list_names($data)
{
	$CI = & get_instance();
	$result = '';
	$result = $CI->db->query('SELECT GROUP_CONCAT(firstname, \' \', lastname) as full_name FROM '.db_prefix().'staff WHERE '.db_prefix().'staff.staffid IN ('.$data.') ORDER BY '.db_prefix().'staff.staffid ASC')->result_array();
	if(!empty($result)) {
		$result = $result[0]['full_name'];
	}
	return $result;
    
}

?>