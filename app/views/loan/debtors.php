<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loan Balance'))?>
            <div class="card-body">
                <a href="/LoanController/">Loans</a>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </thead>

                        <tbody>
                            <?php foreach($debtors as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->email?></td>
                                    <td><?php echo $row->fullname?></td>
                                    <td><?php echo $row->loan_limit?></td>
                                    <td><?php echo $row->total_loan_amount?></td>
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