<a href="/MGPayout" class="btn btn-primary btn-sm">
  Payout
</a>

<?php if(!empty($payins['list'])) :?>
<table class="table">
    <thead>
        <th>#</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Origin</th>
        <th>Date and time</th>
    </thead>

    <tbody>
        <?php foreach($payins['list'] as $key => $row) :?>
            <tr>
                <td><?php echo ++$key?></td>
                <td><?php echo $row->amount?></td>
                <td><?php echo $row->type?></td>
                <td><?php echo $row->origin?></td>
                <td><?php echo $row->dateandtime?></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>
<?php else:?>
  <h1>No Payins</h1>
<?php endif;?>
