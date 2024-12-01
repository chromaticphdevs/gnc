<?php build('content') ?>
    <div class="container-fluid">
        <div class="col-md-5 col-sm-12">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Payment Details')) ?>
                <div class="card-body">
                    <?php Flash::show()?>
                    <h1>Balance : <?php echo ui_html_amount($loan->balance)?></h1>

                    <?php if(isEqual($payment->payment_status, 'approved')) :?>
                    <span class="badge badge-success">Payment Successful</span>
                        <a href="<?php echo URL.DS.'/CashAdvancePaymentController/show/'.seal($payment->id).'?type=receipt'?>"
                            target="_blank">
                            <span class="badge badge-primary">Show Receipt</span>
                        </a>
                    <?php endif?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Reference</td>
                                <td><?php echo $payment->payment_reference?></td>
                            </tr>
                            <tr>
                                <td>Loan Reference</td>
                                <td><a href="/CashAdvance/loan/<?php echo seal($payment->ca_id)?>"><?php echo $payment->loan_reference?></a></td>
                            </tr>
                            <tr>
                                <td>Borrower Name</td>
                                <td><?php echo $loan->borrower_fullname?></td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td><?php echo $payment->bank_name?></td>
                            </tr>
                            <tr>
                                <td>Amount Paid</td>
                                <td><?php echo ui_html_amount($payment->amount)?></td>
                            </tr>
                            <tr>
                                <td>Date of payment</td>
                                <td><?php echo $payment->entry_date?></td>
                            </tr>
                            <tr>
                                <td>Running Balance</td>
                                <td><?php echo ui_html_amount($payment->running_balance)?></td>
                            </tr>
                            <tr>
                                <td>Ending Balance</td>
                                <td><?php echo ui_html_amount($payment->ending_balance)?></td>
                            </tr>
                            <tr>
                                <td>Payment Reference</td>
                                <td><?php echo $payment->external_reference?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <p>Image Proof</p>
                        <img src="<?php echo PATH_PUBLIC.DS. 'assets/cash_advance_payments/' . $payment->image_proof?>" alt=""
                            style="width: 100%; max-width:300px">
                    </div>
                    <?php if($whoIs['type'] == USER_TYPES['ADMIN']) :?>
                        <a href="/CashAdvancePaymentController/approve/<?php echo seal($payment->id)?>?token=<?php echo $token?>" class="btn btn-primary mt-3">Approve Payment</a>
                        <a href="/CashAdvancePaymentController/decline/<?php echo seal($payment->id)?>?token=<?php echo $token?>" class="btn btn-danger mt-3">Decline Payment</a>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy() ?>