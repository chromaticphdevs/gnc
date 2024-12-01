<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonLeft('', [
            $navigationHelper->setNav('', 'Debtors', '/LoanController/debtors'),
            $navigationHelper->setNav('', 'Loan', '/LoanController/boxOfCoffee'),
            $navigationHelper->setNav('', 'Payment', '/LoanController/payment'),
        ])?>
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loans'))?>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Reference</th>
                            <th>User</th>
                            <th>Remarks</th>
                            <th>Amount</th>
                            <th>Pay</th>
                        </thead>

                        <tbody>
                            <?php foreach($loans as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->reference?></td>
                                    <td><?php echo $row->fullname?></td>
                                    <td><?php echo $row->record_remarks?></td>
                                    <td><?php echo $row->remaining_balance?> <i>(<?php echo $row->amount?>)</i> </td>
                                    <td>
                                        <a href="/PaymentController/pay/<?php echo $row->user_id?>">Pay</a>
                                    </td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>