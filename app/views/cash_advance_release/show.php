<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loan Release Preview'))?>
            <div class="card-body">
                <a href="/CashAdvanceReleaseController/index">Back to loan releases</a>
                <?php Flash::show()?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) :?>
                        <tr>
                            <td>Actions</td>
                            <td>
                                <?php if(!isEqual($cashAdvanceRelease->loan_status, 'terminated')) :?>
                                    <a href="/CashAdvanceReleaseController/edit/<?php echo $cashAdvanceRelease->id ?>" class="btn btn-primary">
                                    Edit Released Loan</a>
                                <?php endif?>

                                <?php if(isEqual($cashAdvanceRelease->loan_status, 'released')) :?>
                                    <a href="/CashAdvanceReleaseController/terminate/<?php echo $cashAdvanceRelease->id ?>" class="btn btn-warning">
                                    Loan Termination</a>
                                <?php endif?>

                                <?php if(isEqual($cashAdvanceRelease->loan_status, 'released')) :?>
                                    <a href="/CashAdvancePaymentController/create/<?php echo seal($cashAdvanceRelease->ca_id) ?>" class="btn btn-info">
                                    Make Payment</a>
                                <?php endif?>
                            </td>
                        </tr>
                        <?php endif?>
                        <tr>
                            <td>Reference</td>
                            <td><?php echo $cashAdvanceRelease->release_reference?></td>
                        </tr>
                        <tr> 
                            <td>Status</td>
                            <td><?php echo $cashAdvanceRelease->loan_status?></td>
                        </tr>
                        <tr>
                            <td>Loan Reference</td>
                            <td><?php echo $cashAdvanceRelease->loan_reference?> 
                                <a href="/CashAdvance/agreement/<?php echo seal($cashAdvanceRelease->ca_id)?>">View Agreement</a> | 
                                <a href="/CashAdvance/loan/<?php echo seal($cashAdvanceRelease->ca_id)?>">View Loan</a> | 
                                <a href="/LedgerController/showCashAdvance/<?php echo seal($cashAdvanceRelease->ca_id)?>" target="_blank">View Ledger</a> |
                                <a href="/LoanLogController/loan_log/<?php echo $cashAdvanceRelease->ca_id?>">View Penalties</a> |
                            </td>
                        </tr>

                        <tr>
                            <td>Borrower Name</td>
                            <td>
                                <?php echo $cashAdvanceRelease->member_name?>
                                <a href="/AccountProfile/index?userid=<?php echo $cashAdvanceRelease->user_id?>">View User</a>
                            </td>
                        </tr>

                        <tr>
                            <td>Loan Amount</td>
                            <td><?php echo ui_html_amount($cashAdvanceRelease->amount)?></td>
                        </tr>

                        <tr>
                            <td>Initial Balance</td>
                            <td>
                                <div><?php echo ui_html_amount($cashAdvanceRelease->loan_net)?></div>
                                <section style="font-size: .75rem;">
                                    <div>Service Fee : 
                                        <?php echo ui_html_amount($cashAdvanceRelease->loan_service_fee)?> (<?php echo LOAN_CHARGES['SERVICE_FEE_RATE']?>%)</div>
                                    <div>Attornees Fee : 
                                        <?php echo ui_html_amount($cashAdvanceRelease->loan_attornees_fee)?> (<?php echo LOAN_CHARGES['ATTORNEES_FEE_RATE']?>%)</div>
                                    <div>Loan Interest Amount  : 
                                        <?php echo ui_html_amount($cashAdvanceRelease->loan_interest_rate_amount)?> (<?php echo LOAN_CHARGES['LOAN_INTEREST_FEE_RATE']?>%)</div>
                                </section>
                            </td>
                        </tr>

                        <tr>
                            <td>Total Payment</td>
                            <td>
                                <?php echo ui_html_amount($totalPayment)?>
                                <a href="/CashAdvancePaymentController/ledger/<?php echo seal($cashAdvanceRelease->ca_id)?>">Show All</a>
                            </td>
                        </tr>

                        <tr>
                            <td>Balance</td>
                            <td><?php echo ui_html_amount($cashAdvanceRelease->loan_balance)?></td>
                        </tr>

                        <tr>
                            <td>Release Date</td>
                            <td><?php echo $cashAdvanceRelease->entry_date?></td>
                        </tr>

                        <tr>
                            <td>Due Date</td>
                            <td>
                                <div><?php echo $cashAdvanceRelease->due_date?> (<?php echo $cashAdvanceRelease->due_date_no_of_days?> days)</div>
                                <div>
                                    <?php
                                        $day_before_due_date = date_difference_by_day($cashAdvanceRelease->due_date, today());
                                        if($day_before_due_date < 0) {
                                            $day_before_due_date = abs($day_before_due_date);
                                            echo "<span class='badge badge-danger'>Past due for {$day_before_due_date} days<span>";
                                        } else {
                                            $day_before_due_date = abs($day_before_due_date);
                                            echo "<span class='badge badge-primary'>{$day_before_due_date} Days before past due <span>";
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Bank Transfer Details</td>
                            <td>
                                <ul class="list-unstyled">
                                    <li>Reference : <?php echo $cashAdvanceRelease->external_reference?> </li>
                                    <li>Bank Name : <?php echo $cashAdvanceRelease->bank_org_name?></li>
                                    <li>Account No : <?php echo $cashAdvanceRelease->account_no?></li>
                                    <li>Account Name : <?php echo $cashAdvanceRelease->account_name?></li>
                                </ul>
                            </td>
                        </tr>
                        <?php if($penalties['totalAmount'] > 0) :?>
                        <tr>
                            <td>Penalties</td>
                            <td>
                                <?php echo ui_html_amount($penalties['totalAmount'])?>
                                <div>
                                    <a href="/CashAdvanceReleaseController/penalty?loan_reference=<?php echo $cashAdvanceRelease->loan_reference?>">Show all</a>
                                </div>
                            </td>
                        </tr>
                        <?php endif?>
                    </table>
                    <a href="/ImageUploaderController/imageCropper?q=<?php echo seal([
                        'returnURL' => '/CashAdvanceReleaseController/show/'.$cashAdvanceRelease->id,
                        'userId'    => $cashAdvanceRelease->user_id,
                        'sourceFor' => 'loan_release_image',
                        'sourceId'  => $cashAdvanceRelease->id
                    ])?>">Manage Image Proof</a>
                    <div>
                        <?php if($cashAdvanceRelease->image_proof) :?>
                            <img src="<?php echo PATH_PUBLIC.DS.'assets/loan_release_images/'.$cashAdvanceRelease->image_proof?>" alt="">
                        <?php else :?>
                            <p>No Image Proof</p>
                        <?php endif?>
                    </div>

                    <a href="/CashAdvancePaymentController/search" class="btn btn-primary">Process Next Payment</a>
                </div>
            </div>
        </div>
    </div>
<?php endbuild() ?>
<?php occupy() ?>