<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo WordLib::get('cashAdvance')?> Payments</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Loan Reference</th>
                        <th>Borrower</th>
                        <th>Payment Posted</th>
                        <th>Status</th>
                        <th>Amount Paid</th>
                        <th>Running Balance</th>
                        <th>Ending Balance</th>
                    </thead>

                    <tbody>
                        <?php $totalBalance = 0?>
                        <?php foreach($cash_advance_payments as $key => $row) :?>
                            <?php $totalBalance += $row->amount?>
                            <tr>
                                <td><a href="/CashAdvancePaymentController/show/<?php echo seal($row->id)?>"><?php echo $row->loan_reference?></a></td>
                                <td><?php echo $row->payer_fullname?></td>
                                <td><?php echo $row->entry_date?></td>
                                <td><?php echo $row->payment_status?></td>
                                <td><?php echo ui_html_amount($row->amount)?></td>
                                <td><?php echo ui_html_amount($row->running_balance)?></td>
                                <td><?php echo ui_html_amount($row->ending_balance)?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <hr>
            <h4>Total : <?php echo ui_html_amount($totalBalance)?> </h4>
        </div>
    </div>
<?php endbuild()?>
<?php occupy() ?>