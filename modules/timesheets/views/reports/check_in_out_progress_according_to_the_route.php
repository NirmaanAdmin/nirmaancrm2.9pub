<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="check_in_out_progress_according_to_the_route" class="hide reports_fr scroll-responsive">
   <?php 
   $col_header = [];
   $col_footer = [];
   $col_header[] = '<th>'._l('staff').'</th>';
   $col_footer[] = '<td></td>';
   $month = date('m');
   $year = date('Y');
   $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
   for ($d = 1; $d <= $days_in_month; $d++) {
      $time = mktime(12, 0, 0, $month, $d, (int)$year);
      if (date('m', $time) == $month) {
         $col_header[] = '<th>'.date('D d', $time).'</th>';
         $col_footer[] = '<td></td>';
      }
   }
   ?>
   <table class="table table-check_in_out_progress_according_to_the_route_report scroll-responsive">
    <thead>
      <tr>
         <?php 
         foreach ($col_header as $key => $header) {
            echo html_entity_decode($header);            
         }
         ?>
      </tr>
   </thead>
   <tbody></tbody>
   <tfoot>
      <tr>
         <?php
         foreach ($col_footer as $key => $footer) {
            echo html_entity_decode($footer);            
         }
         ?>
      </tr>
   </tfoot>
</table>
</div>
