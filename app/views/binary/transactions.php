<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Team Transactions'))?>
            <div class="card-body">
                <?php if($transactions):?>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Counter1 Vol</th>
                            <th>Counter2 Vol</th>
                            <th>Counter1 Carry</th>
                            <th>Counter2 Carry</th>
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
                    <?php else:?>
                    <div class="text-center">
                        <p>No Transactions Found.</p>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates.layout')?>
