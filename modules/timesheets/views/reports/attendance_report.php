<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="attendance_report" class="hide reports_fr">

   <table class="table table-attendance_report scroll-responsive">
      <thead>
         <tr>
            <!-- <th>ID #</th> -->
            <th><?php echo _l('employee_code'); ?></th>
            <th style="min-width: 180px;padding-left: 10px; padding-right: 10px;"><?php echo _l('full_name'); ?></th>
            <th><?php echo _l('position'); ?></th>
            <th><?php echo _l('department'); ?></th>
            <th><?php echo _l('total_shift'); ?></th>
            <th><?php echo _l('actual_sum'); ?></th>            
         </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
         <!-- <td></td> -->
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
      </tfoot>
   </table>
</div>
