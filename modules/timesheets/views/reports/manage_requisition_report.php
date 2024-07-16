<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="requisition_report" class="hide reports_fr">
   <table class="table table-requisition_report scroll-responsive">
      <thead>
         <tr>
            <th><?php echo _l('staffid'); ?></th>
            <th><?php echo _l('staff_name'); ?></th>
            <th ><?php echo _l('Subject'); ?></th>
            <th><?php echo _l('start_time'); ?></th>
            <th><?php echo _l('end_time'); ?></th>
            <th><?php echo _l('number_of_days'); ?></th>
            <th><?php echo _l('reason'); ?></th>
            <th><?php echo _l('Type'); ?></th>
         </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
      </tfoot>
   </table>
</div>
