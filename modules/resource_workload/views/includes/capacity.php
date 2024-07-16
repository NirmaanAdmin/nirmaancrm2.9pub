<h4 class="total_capacity"><?php echo _l('total_capacity').': '.$data_capacity['total']['total_capacity']; ?></h4>
<br>
<h5><?php echo _l('list_of_billable_projects'); ?></h5>
<div id="capacity_billable"></div>
<div class="col-md-4 col-md-offset-8">
  <table class="table text-right">
    <tbody>
      <tr id="subtotal">
        <td>
          <span class="bold"><?php echo _l('billable_expected'); ?> :</span>
        </td>
        <td class="total_billable">
          <?php echo html_entity_decode($data_capacity['total']['billable']); ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<hr/>
<h5><?php echo _l('list_of_unbillable_projects'); ?></h5>
<div id="capacity_unbillable"></div>
<div class="col-md-4 col-md-offset-8">
  <table class="table text-right">
    <tbody>
      <tr id="subtotal">
        <td>
          <span class="bold"><?php echo _l('billable_expected'); ?> :</span>
        </td>
        <td class="total_unbillable">
          <?php echo html_entity_decode($data_capacity['total']['unbillable']); ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>