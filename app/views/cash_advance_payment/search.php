<?php build('content') ?>
<div class="container-fluid">
    <?php echo wControlButtonRight('', [
        $navigationHelper->setnav('', 'Payments', '/CashAdvancePaymentController/index')
    ])?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Search Loan')) ?>
        <div class="card-body">
            <div class="col-md-5 mx-auto">
                <?php Flash::show() ?>
                <?php
                    Form::open([
                        'method' => 'post'
                    ])
                ?>
                    <div class="form-group">
                        <?php
                            Form::label('Search here.');
                            Form::text('keyword', '', [
                                'placeholder' => 'Search by username or Loan Reference',
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php Form::submit('', 'Search', [
                            'class' => 'btn btn-primary btn-sm'
                        ])?>
                    </div>
                <?php Form::close() ?>
            </div>
            <?php echo wDivider()?>
            <a href="/CashAdvancePaymentController/index">Show all payments</a>
            <?php if($recentPayments):?>
                <h1>Recent Payments</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Borrower Name</th>
                            <th>Cash Advance</th>
                            <th>Amount</th>
                            <th>Ending Balance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php foreach($recentPayments as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->payer_fullname?></td>
                                    <td><?php echo $row->loan_reference?></td>
                                    <td><?php echo ui_html_amount($row->amount)?></td>
                                    <td><?php echo ui_html_amount($row->ending_balance)?></td>
                                    <td><?php echo wTruOrFalseText(isEqual($row->payment_status, 'approved'), 
                                        ['Approved', $row->payment_status], ['#1cc88a', '#f6c23e']) ?></td>
                                    <td>
                                        <a href="/CashAdvancePaymentController/show/<?php echo seal($row->id)?>">Show</a>
                                    </td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            <?php endif?>
        </div>
    </div>
</div>
<?php endbuild() ?>
<?php occupy() ?>