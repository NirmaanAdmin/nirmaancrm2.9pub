<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php if (is_admin()) {?>
<a href="#" onclick="permissions_update(0,0,' hide'); return false;" class="btn btn-info mbot10"><?php echo _l('ts_add'); ?></a>
<?php }?>
<table class="table table-hr-profile-permission">
  <thead>
    <th><?php echo _l('staff_name'); ?></th>
    <th><?php echo _l('role'); ?></th>
    <th><?php echo _l('staff_dt_email'); ?></th>
    <th><?php echo _l('phone'); ?></th>
    <th><?php echo _l('options'); ?></th>
  </thead>
  <tbody>
  </tbody>
</table>
<div id="modal_wrapper"></div>

