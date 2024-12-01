<?php build('content') ?>
<div class="container-fluid">
    <div class="col-md-5 mx-auto">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loan Termination'))?>
            <div class="card-body">
                <a href="/CashAdvanceReleaseController/show/<?php echo $cashAdvanceRelease->id?>">Back</a>
                <?php Flash::show()?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Loan Reference</td>
                            <td><?php echo $cashAdvanceRelease->loan_reference?></td>
                        </tr>

                        <tr>
                            <td>Borrower Name</td>
                            <td><?php echo $cashAdvanceRelease->member_name?></td>
                        </tr>

                        <tr>
                            <td>Initial Balance</td>
                            <td><?php echo ui_html_amount($cashAdvanceRelease->loan_net)?></td>
                        </tr>

                        <tr>
                            <td>Total Payment</td>
                            <td><?php echo ui_html_amount($totalPayment)?></td>
                        </tr>

                        <tr>
                            <td>Balance</td>
                            <td><?php echo ui_html_amount($cashAdvanceRelease->loan_balance)?></td>
                        </tr>

                        <tr>
                            <td>Release Date</td>
                            <td><?php echo $cashAdvanceRelease->entry_date?></td>
                        </tr>
                    </table>
                </div>

                <div class="text-center" id="terminationOptions">
                    <h4 class="mb-3">Before Terminating this loan, select termination processs</h4>
                    <label for="reCreateLoanYes">
                        <input type="radio" id="reCreateLoanYes" name="re_create_loan" value="yes" form="terminateForm">
                        Transfer Balance to new loan
                    </label>

                    <label for="reCreateLoanNo">
                        <input type="radio" id="reCreateLoanNo" name="re_create_loan" value="no" form="terminateForm">
                        Terminate Only
                    </label>
                </div>

                <div class="text-center" style="margin-top: 50px; background:#eee; padding:15px">
                    <h5>Penalties</h5>
                    <div class="mb-3">
                        <h3>Total Penalty : <?php echo ui_html_amount($penaltySummary['accuiredPenaltyTotal'])?></h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <th>#</th>
                                <th>Date</th>
                                <th>Accuired Penalty</th>
                                <th>Amount</th>
                            </thead>

                            <tbody>
                                <?php $hiddenRows = 0;?>
                                <?php foreach($penaltySummary['accuiredPenalties'] as $key => $row) :?>
                                    <?php 
                                        $class = '';
                                        
                                        if($key > 10) {
                                            $class = 'penalty-row-hidden';
                                            $hiddenRows++;
                                        }
                                    ?>
                                    <tr class="<?php echo $class?>">
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo get_date($row, 'M d, Y')?></td>
                                        <td>Attornees Fee</td>
                                        <td><?php echo ui_html_amount(LOAN_CHARGES['LATE_PAYMENT_ATTORNEES_FEE_AMOUNT'])?></td>
                                    </tr>
                                <?php endforeach?>

                                <?php if($hiddenRows) :?>
                                    <tr>
                                        <td colspan="4"><a href="javascript:void(0)" id="showAllAttFee">Show all</a></td>
                                    </tr>
                                <?php endif?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <?php
                        Form::open([
                            'method' => 'post',
                            'action' => '',
                            'id' => 'terminateForm'
                        ])
                    ?>
                        <section id="terminationOptionYes">
                            <div class="form-group">
                                <?php
                                    Form::label('New Loan Amount');
                                    Form::text('', ($cashAdvanceRelease->loan_balance) - $cashAdvanceRelease->loan_attornees_fee, [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ])
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                    Form::label('Attornees Fee');
                                    Form::text('attornees_fee', $penaltySummary['accuiredPenaltyTotal'], [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ])
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                    Form::label('Total Balance');
                                    Form::text('', ui_html_amount($cashAdvanceRelease->loan_balance + $penaltySummary['accuiredPenaltyTotal']), [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ])
                                ?>
                            </div>
                        </section>

                        <div class="form-group text-center">
                            <?php Form::submit('', 'Terminate', [
                                'class' => 'btn btn-danger btn-block form-confirm',
                                'id' => 'terminateBtn'
                            ])?>
                        </div>
                    <?php Form::close()?>
                </div>
            </div>
            </div>
    </div>
</div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            var showAttFee = false;

            $('#terminateBtn').hide();

            $("input[name='re_create_loan']").change(function(){
                let isCreateLoan = $(this).val();

                if(isCreateLoan == 'yes') {
                    $('#terminationOptionYes').show();
                } else {
                    $('#terminationOptionYes').hide();
                }

                $('#terminateBtn').show();
            });

            $('#showAllAttFee').click(function(){
                if(showAttFee) {
                    $('.penalty-row-hidden').hide();
                } else {
                    $('.penalty-row-hidden').show();
                }

                showAttFee = !showAttFee;
            });
        });
    </script>
<?php endbuild()?>
<?php build('styles') ?>
    <style>
        #terminationOptions input[type="radio"] {
            width: 20px;
            height: 20px;
        }

        #terminationOptionYes {
            display: none;
        }

        #terminationOptions {
            font-size: 1.4em;
        }
        .penalty-row-hidden {
            display: none;
        }
    </style>
<?php endbuild()?>
<?php occupy()?>