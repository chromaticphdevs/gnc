<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
        <?php echo wCardHeader(wCardTitle('Loan Logs'))?>
            <div class="card-body">
                <?php $totalAmount = 0 ?>
                <div class="table table-bordered table-sm">
                    <table class="table-sm table table-bordered">
                        <thead>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                        </thead>

                        <?php foreach($loan_logs as $key => $row) :?>
                            <?php $totalAmount += $row->amount?>
                            <tr>
                                <td><?php echo $row->penalty_date?></td>
                                <td><?php echo ui_html_amount($row->amount * - 1)?></td>
                                <td><?php echo $row->remarks?></td>
                            </tr>
                        <?php endforeach?>
                    </table>
                </div>
                <h3 class="mt-3"><?php echo ui_html_amount($totalAmount)?></h3>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>