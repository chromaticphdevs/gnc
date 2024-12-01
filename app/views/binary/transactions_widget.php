<h3>Transactions</h3>
<?php if($transactions):?>
    <div class="x_well">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Date</th>
                <th>Left Vol</th>
                <th>Right Vol</th>
                <th>Left Carry</th>
                <th>Right Carry</th>
                <th>Pair</th>
                <th>Amount</th>
                <th>Description</th>
            </thead>

            <tbody>
                <?php foreach($transactions as $key => $row) :?>
                    <tr>
                        <td><?php echo ++$key?></td>
                        <td><?php echo date_long($row->created_at , 'M d,Y')?></td>
                        <td><?php echo $row->left_vol?></td>
                        <td><?php echo $row->right_vol?></td>
                        <td><?php echo $row->left_carry?></td>
                        <td><?php echo $row->right_carry?></td>
                        <td><?php echo $row->pair?></td>
                        <td><?php echo to_number($row->amount)?></td>
                        <td>
                            <p><?php echo $row->description?></p>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
<?php else:?>
    <div class="x_well">
        <div class="text-center">
            <p>No Transactions Found.</p>
        </div>
    </div>
<?php endif;?>
