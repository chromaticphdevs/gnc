<?php build('content') ?>
<h3>Payout</h3>
<table class="table">
    <thead>
        <th>#</th>
        <th>Username</th>
        <th>Fullname</th>
        <th>Amount</th>
        <th>Cheque</th>
        <th>Preview</th>
    </thead>

    <tbody>
        <?php foreach($payout['itemList'] as $key => $row) :?>
            <tr>
                <td><?php echo ++$key?></td>
                <td><?php echo $row->username?></td>
                <td><?php echo $row->fullname?></td>
                <td><?php echo to_number($row->amount)?></td>
                <td>
                    <?php if($row->cheque) :?>
                        <p>Has Cheque</p>
                    <?php else:?>
                        <button>Add Cheque</button>
                    <?php endif;?>
                </td>
                <td>
                    <a href="#">View</a>
                </td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>
<?php endbuild()?>

<?php occupy('templates.layout')?>