<?php build('content') ?>
    <div class="container-fluid">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Payment Details')) ?>
                <div class="card-body">
                    <?php if(isEqual($payment->payment_status, 'approved')) :?>
                        <span class="badge badge-success">Payment Successful</span>
                        <a href="<?php echo URL.DS.'/CashAdvancePaymentController/show/'.seal($payment->id).'?type=receipt'?>"
                            target="_blank">
                            <span class="badge badge-primary">Show Receipt</span>
                        </a>
                    <?php else:?>
                        <span class="badge badge-warning"><?php echo ucwords($payment->payment_status)?></span>
                    <?php endif?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Payment Reference</td>
                                <td><?php echo $payment->payment_reference?></td>
                            </tr>
                            <tr>
                                <td>Loan Reference</td>
                                <td><?php echo $payment->loan_reference?></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Borrower Name</td>
                                <td><?php echo $payment->payer_fullname?></td>
                            </tr>
                            <tr>
                                <td>Amount Paid</td>
                                <td><?php echo ui_html_amount($payment->amount)?></td>
                            </tr>
                            <tr>
                                <td>Remaining Balance</td>
                                <td><?php echo ui_html_amount($payment->ending_balance)?></td>
                            </tr>
                            <tr>
                                <td>Bank Used</td>
                                <td><?php echo $payment->bank_name?></td>
                            </tr>
                            <tr>
                                <td>Bank Payment Reference</td>
                                <td><?php echo $payment->external_reference?></td>
                            </tr>
                        </table>
                    </div>
                    <a href="/ImageUploaderController/imageCropper?q=<?php echo seal([
                        'returnURL' => '/CashAdvancePaymentController/imageproof/'.$paymentId,
                        'userId'    => $payment->payer_id,
                        'sourceFor' => 'cash_advance_payment_proof',
                        'sourceId'  => $payment->id
                    ])?>" class="btn btn-primary btn-lg btn-block">Image Proof</a>
                    
                    <?php echo wDivider()?>
                        <img src="<?php echo PATH_PUBLIC.DS.'assets/cash_advance_payments/'.$payment->image_proof?>" alt="">
                    <?php echo wDivider()?>

                    <?php if(isEqual($whoIs['type'], [USER_TYPES['ADMIN'], USER_TYPES['ENCODER_A']])) :?>
                        <a href="/CashAdvancePaymentController/search" class="btn btn-primary">Process Next Payment</a>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild() ?>

<?php occupy()?> 