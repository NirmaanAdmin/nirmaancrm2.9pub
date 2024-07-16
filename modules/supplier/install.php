<?php

defined('BASEPATH') or exit('No direct script access allowed');


if (!$CI->db->field_exists('is_supplier', db_prefix() . 'clients'))
{
    $CI->db->query('ALTER TABLE `tblclients` ADD `is_supplier` BOOLEAN  NOT NULL AFTER `show_primary_contact`;');    
}
$items = db_prefix() . 'items';
 if (!$CI->db->field_exists('userid', $items)) {

$CI->db->query("ALTER TABLE `" . $items . "` ADD `userid` INT(11) DEFAULT NULL AFTER `id`;");

}
$clients = db_prefix() . 'clients';
if (!$CI->db->field_exists('is_preffered', $clients)) {
	$CI->db->query("ALTER TABLE `" . $clients . "` ADD `is_preffered` INT(11) DEFAULT '0'  AFTER `company`;");
}


