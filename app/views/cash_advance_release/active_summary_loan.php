<?php build('content') ?>
<?php
    $totalRemainingBalance = 0;
    $totalRecentPayment = 0;
    $totalPayment = 0;
?>
<div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Loan With Balance Summary')) ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Borrower</th>
                        <th title="Recent Payment Date">Payment Date</th>
                        <th title="Due Date">Due Date</th>
                        <th title="No. Of days before due date">#days</th>
                        <th title="Past Due Flag">Past Due Flag</th>
                        <th title="Recent External Reference">Payment Reference</th>
                        <th style="width: 2%;">Payment Amount</th>
                        <th style="width: 3%;">Total Payment</th>
                        <th title="Remaining balance" style="width: 3%;">Remaining Balance</th>
                        <th>Action</th>
                    </thead>
                    <?php if($loanSummaryArray) :?>
                    <tbody>
                        <?php foreach($loanSummaryArray as $key => $row) : ?>
                            <?php 
                                $totalRemainingBalance += $row->balance;
                                $totalRecentPayment += $row->last_payment_amount;
                                $totalPayment += $row->total_payment;
                                $day_before_due_date = date_difference_by_day($row->due_date, today());
                            ?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->borrower_fullname?></td>
                                <td><?php echo empty($row->last_payment_date) ? 'No Payment' : $row->last_payment_date?></td>
                                <td><?php echo $row->due_date ?? ''?></td>
                                <td>
                                    <?php
                                        if($day_before_due_date < 0) {
                                            $day_before_due_datetext = abs($day_before_due_date);
                                            echo "<span class='badge badge-danger'>Past due for {$day_before_due_datetext} days<span>";
                                        } else {
                                            $day_before_due_datetext = abs($day_before_due_date);
                                            echo "<span class='badge badge-primary'>{$day_before_due_datetext} Days before past due <span>";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php if($day_before_due_date > 0) :?>
                                        Yes
                                    <?php else :?>
                                        No
                                    <?php endif?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($row->external_reference)) {
                                            ?> 
                                                <a href="/CashAdvancePaymentController/show/<?php echo seal($row->last_payment_id)?>">
                                                    <?php echo $row->external_reference?>
                                                </a>
                                            <?php
                                        } else {
                                           ?> 
                                            N/A
                                           <?php
                                        }
                                    ?>
                                </td>
                                <td><?php echo ui_html_amount($row->last_payment_amount)?></td>
                                <td><?php echo ui_html_amount($row->total_payment)?></td>
                                <td><?php echo ui_html_amount($row->balance)?></td>
                                <td> <a href="/CashAdvance/loan/<?php echo seal($row->loan_id)?>">Show Loan</a> </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                    <?php endif?>
                </table>
                <?php if(empty($loanSummaryArray)) :?>
                    <p class="text-center">No items found.</p>
                <?php endif?>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <td>
                            <div>Recent Payment</div>
                            <input type="text" value="<?php echo ui_html_amount($totalRecentPayment)?>" class="form-control" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div>Remaining Balance</div>
                            <input type="text" value="<?php echo ui_html_amount($totalRemainingBalance)?>" class="form-control" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Total Payment</div>
                            <input type="text" value="<?php echo ui_html_amount($totalPayment)?>" class="form-control" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Receivables</div>
                            <input type="text" value="<?php echo ui_html_amount($totalRemainingBalance - $totalPayment)?>" class="form-control" readonly>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>

