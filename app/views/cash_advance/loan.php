<?php build('content') ?>
<div class="container-fluid">
    <?php
        echo wControlButtonRight('', [
            $navigationHelper->setnav('', 'List', '/FNCashAdvance/index', [
                'icon' => 'fa fa-list'
            ])
        ]);
    ?>
    <div class="col-md-12 col-lg-6 mx-auto">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loan View'))?>
            <div class="card-body">
                <?php Flash::show()?>
                <a href="/FNCashAdvance/index" class="btn btn-sm btn-primary">Loan List</a>
                <div class="mb-3 text-center">
                    <h1><?php echo ui_html_amount($loan->balance)?></h1>
                    <?php if($cashAdvanceRelease) :?>
                        <span class="badge badge-primary">Remaining Balance</span>
                    <?php else :?>
                        <a href="/CashAdvance/modifyloanAmount/<?php echo seal($loan->id)?>" class="badge badge-danger" >Change Amount</a>
                    <?php endif?>
                    <?php if(isEqual(whoIs('type'), USER_TYPES['MEMBER']) && ($loan->balance > 0) && !isEqual($loan->status, 'terminated')) :?>
                        <div class="mt-3">
                            <a href="/CashAdvancePaymentController/create/<?php echo seal($loan->id)?>" 
                            class="btn btn-primary">Add Payment</a>
                        </div>
                    <?php endif?>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Status</td>
                            <td>
                            <?php echo wTruOrFalseText(isEqual($loan->status, 'pending'), ['Waiting for admin approval', $loan->status], [
                                'orange', 'green'
                            ])?> 
                            <?php if($cashAdvanceRelease) :?>
                                #<?php echo $cashAdvanceRelease->release_reference?>
                            <?php endif?>
                            </td>
                        </tr>
                        <tr>
                            <td>Reference</td>
                            <td>#
                                <?php if(isEqual(whoIs('type'), [USER_TYPES['ADMIN'], USER_TYPES['ENCODER_A']]) && $cashAdvanceRelease):?>
                                    <a href="/CashAdvanceReleaseController/show/<?php echo $cashAdvanceRelease->id?>"><?php echo $loan->code?></a>
                                <?php else :?>
                                    <?php echo $loan->code?>
                                <?php endif?>
                            </td>
                        </tr>
                        <tr>
                            <td>Loan Date</td>
                            <td><?php echo get_date($loan->date, 'M d, Y')?></td>
                        </tr>
                        
                        <?php if($cashAdvanceRelease && !isEqual($loan->status, 'paid')) :?>
                        <tr>
                            <td>Due Date</td>
                            <td>
                                <div>
                                    <?php echo $cashAdvanceRelease->due_date?> (<?php echo $cashAdvanceRelease->due_date_no_of_days?> days)</div>
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
                        <?php endif?>

                        <tr>
                            <td>Loan Amount</td>
                            <td><?php echo ui_html_amount($loan->amount)?></td>
                        </tr>

                        <tr>
                            <td>Initial Balance</td>
                            <td>
                                <div><?php echo ui_html_amount($loan->net)?></div>
                                <section style="font-size: .75rem;">
                                    <div>Service Fee : 
                                        <?php echo ui_html_amount($loan->service_fee)?> (<?php echo LOAN_CHARGES['SERVICE_FEE_RATE']?>%)</div>
                                    <div>Attornees Fee : 
                                        <?php echo ui_html_amount($loan->attornees_fee)?> (<?php echo LOAN_CHARGES['ATTORNEES_FEE_RATE']?>%)</div>
                                    <div>Loan Interest Amount  : 
                                        <?php echo ui_html_amount($loan->interest_rate_amount)?> (<?php echo LOAN_CHARGES['LOAN_INTEREST_FEE_RATE']?>%)</div>
                                </section>
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td><?php echo $loan->payment_method?></td>
                        </tr>

                        <?php if($cashAdvanceRelease) :?>
                            <tr>
                                <td>Accounts Ledger</td>
                                <td> <a href="/LedgerController/showCashAdvance/<?php echo seal($cashAdvanceRelease->ca_id)?>" target="_blank">View Ledger</a></td>
                            </tr>
                        <?php endif?>

                        <tr><td colspan="2" style="background-color: blue; color:#fff">Borrower</td></tr>

                        <tr>
                            <td>Primary</td>
                            <td>
                                <div><?php echo $loan->borrower_fullname?></div>
                                <div><?php echo $loan->borrower_address?></div>
                            </td>
                        </tr>

                        <tr>
                            <td>Co-Borrower</td>
                            <td>
                                <?php foreach($coborrowers as $key => $row) :?>
                                    <div class="mb-3">
                                        <div><?php echo $row->firstname . ' ' .$row->lastname?></div>
                                        <div><?php echo $row->address?></div>
                                    </div>
                                <?php endforeach?>
                            </td>
                        </tr>

                        <tr>
                            <td>Agreement</td>
                            <td>
                                <a href="<?php echo "/CashAdvance/agreement/".seal($loan->id)?>" target="_blank">Show Agreement</a>
                            </td>
                        </tr>

                        <?php if($payments) :?>
                            <tr><td colspan="2" style="background-color: blue; color:#fff">Payments</td></tr>
                            <tr>
                                <td>
                                    <div>Payments</div>
                                </td>
                                <td>
                                    <?php $totalPayment = 0?>
                                    <?php foreach($payments as $key => $row) :?>
                                        <?php
                                            $totalPayment += $row->amount;
                                            $className = '';
                                            if($key > 0) {
                                                $className = 'hidden';
                                            }    
                                        ?>
                                        <div class="payments <?php echo $className?>">
                                            <a href="/CashAdvancePaymentController/show/<?php echo seal($row->id)?>?type=receipt" target="_blank"><?php echo $row->entry_date?> | <?php echo ui_html_amount($row->amount)?></a>
                                        </div>
                                    <?php endforeach?>
                                    <?php if($key > 0) :?>
                                       <a href="/CashAdvancePaymentController/ledger/<?php echo seal($loan->id)?>">Show All</a>
                                    <?php endif?>
                                    <h5 class="mt-3">Total Payment : <?php echo ui_html_amount($totalPayment)?></h5>
                                </td>
                            </tr>
                        <?php endif?>
                    </table>
                </div>

                <?php if($cashAdvanceRelease->image_proof ?? '') :?>
                    <p>Image Proof</p>
                    <img src="<?php echo PATH_PUBLIC.DS.'assets/loan_release_images/'.$cashAdvanceRelease->image_proof?>" alt="">
                <?php else :?>
                    <p>No Image Proof</p>
                <?php endif?>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php build('scripts') ?>
   <script>
        $(document).ready(function(){
            let hiddenPayments = $('div.payments.hidden');
            hiddenPayments.hide();

            if($('#showAllPayment')) {
                $("#showAllPayment").click(function(){
                    hiddenPayments.toggle();
                });
            }
        });
   </script>
<?php endbuild() ?>
<?php occupy()?>