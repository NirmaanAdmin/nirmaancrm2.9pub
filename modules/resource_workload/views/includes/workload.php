<label><?php echo _l('note_workload'); ?></label>
<div id="workload"></div>
<div class="col-md-4 col-md-offset-8">
  <table class="table text-right">
    <tbody>
      <tr id="subtotal">
        <td><span class="bold"><?php echo _l('total_capacity'); ?> :</span>
        </td>
        <td class="total_capacity">
          <?php echo round($data_workload['data_total']['capacity'], 2); ?>
        </td>
      </tr>
      <tr>
        <td><span class="bold"><?php echo _l('total_estimated_time'); ?> :</span>
        </td>
        <td class="total_estimated_time">
          <?php echo round($data_workload['data_total']['estimate'], 2); ?>
        </td>
      </tr>
      <tr>
        <td><span class="bold"><?php echo _l('total_spent_time'); ?> :</span>
        </td>
        <td class="total_spent_time">                                      
          <?php echo round($data_workload['data_total']['spent_time'], 2); ?>
        </td>
      </tr>
      <tr>
        <td><span class="bold"><?php echo _l('total_available_cap'); ?> :</span>
        </td>
        <td class="total_available_cap">                                      
          <?php echo round(($data_workload['data_total']['capacity'] - $data_workload['data_total']['estimate']), 2); ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>