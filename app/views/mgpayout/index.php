<?php build('content')?>
<h3>Saved Payouts : <?php echo to_number($data['payoutTotal'])?></h3>
<a href="/MGPayout/create" class="btn btn-primary">Generate Payout</a>
<?php if(isset($filter)):?>
<a href="/MGPayout/index">Clear Filter</a>
<?php endif;?>
<div class="well">
  <table class="table">
    <thead>
      <th>#</th>
      <th>Token</th>
      <th>Full Name</th>
      <th>Username</th>
      <th>Amount</th>
      <th>Staff</th>
      <th>Description</th>
    </thead>

    <tbody>
      <?php foreach($payouts as $key => $row) :?>
        <tr>
          <td><?php echo ++$key?></td>
          <td> <a href="?payoutToken=<?php echo $row->payout_token?>" title="payout item groupings"><?php echo $row->payout_token?></a> </td>
          <td><?php echo $row->cx_full_name?></td>
          <td><?php echo $row->cx_username?></td>
          <td><?php echo to_number($row->amount)?></td>
          <td>
            <label for="" title="Staff who triggered the payout"> <?php echo $row->staff_username?></label>
          </td>
          <td><?php echo $row->description?></td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>
