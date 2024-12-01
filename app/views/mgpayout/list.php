<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Payout'))?>
            <div class="card-body">
                <h3><b>Total: &#8369; <?php echo to_number($total_payout); ?></b></h3>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Amount</th>
                            <th>Date & time</th>
                        </thead>

                        <tbody>
                            <?php foreach($payoutList as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->username?></td>
                                    <td><?php echo $row->fullname?></td>
                                    <td>&#8369;<?php echo  to_number($row->amount)?></td>
                                    <td><?php
                                            $date=date_create($row->created_at);
                                            echo date_format($date,"M d, Y");
                                            $time=date_create($row->created_at);
                                            echo date_format($time," h:i A");
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>