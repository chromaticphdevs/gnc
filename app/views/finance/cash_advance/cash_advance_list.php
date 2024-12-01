<?php build('content') ?>
<?php echo $title ?? ''?>
<table class="table">
    <thead>
        <th>#</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>phone</th>
        <th>email</th>
        <th>Amount</th>
        <th>Payment</th>
        <th>Balance</th>
        <th></th>
    </thead>

     <tbody>
           <?php $counter = 1;?>
           <?php foreach($results as $key => $row) :?>
           <?php $balance = $row->balance?>
           <?php if($balance > 0) :?>
            <tr>
                  <td><?php echo $counter ?></td>
                  <td><?php echo $row->user->fullname; ?></td>
                  <td><?php echo $row->user->username; ?></td>
                  <td><?php echo $row->user->mobile; ?></td>
                  <td><?php echo $row->user->email; ?></td>
                  <td><?php echo to_number($row->amount); ?></td>
                  <td><?php echo to_number($row->payment); ?></td>
                  <td><?php echo to_number($balance); ?> </td>
                  <td>
                    <a class="btn btn-success btn-sm" href="/FNCashAdvancePayment/make_payment/?userid=<?php echo seal($row->user->id)?>&loan_id=<?php echo $row->id ?>">&nbsp;Make Payment&nbsp;</a>
                  </td>


            </tr>
          <?php endif;?>
          <?php $counter++;?>
          <?php endforeach;?>
    </tbody>
</table>
<?php endbuild()?>

<?php occupy('templates/layout')?>
