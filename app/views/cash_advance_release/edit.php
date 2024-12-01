<?php build('content') ?>
    <div class="container-fluid">
        <?php
            echo wControlButtonLeft('', [
                $navigationHelper->setNav('', 'Back', '/CashAdvanceReleaseController/show/'. $cashAdvanceRelease->id)
            ]);
        ?>
        <div class="col-md-6">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Edit Released Loan'))?>
                <div class="card-body">
                    <?php Flash::show()?>
                    <?php
                        Form::open([
                            'method' => 'post'
                        ])
                    ?>
                        <div class="form-group">
                            <?php
                                Form::label('Loan Reference');
                                Form::text('', $cashAdvanceRelease->loan_reference, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Borrower');
                                Form::text('', $cashAdvanceRelease->member_name, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Release Date');
                                Form::date('entry_date', date('Y-m-d', strtotime($cashAdvanceRelease->entry_date)), [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Days before due date');
                                Form::number('due_date_no_of_days', $cashAdvanceRelease->due_date_no_of_days, [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>

                            <div>Current Due Date : <?php echo $cashAdvanceRelease->due_date?> </div>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Loan Amount');
                                Form::text('loan_amount', ui_html_amount($loan->ca_amount), [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id'  => 'loanAmount',
                                    'data-amount' => $loan->ca_amount
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Service Fee' . ' (' . LOAN_CHARGES['SERVICE_FEE_RATE']. '%' . ')');
                                Form::text('service_fee', '', [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id' => 'serviceFee'
                                ]);
                            ?>
                            <p>Automatically calculated as <?php echo LOAN_CHARGES['SERVICE_FEE_RATE']?>% of loan amount, put 0 if loan has no service fee</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Attornees Fee' . ' (' . LOAN_CHARGES['ATTORNEES_FEE_RATE']. '%' . ')');
                                Form::text('attornees_fee', '', [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id' => 'attorneesFee'
                                ]);
                            ?>
                            <div>Current Attornee Fee : <?php echo $cashAdvanceRelease->loan_attornees_fee?></div>
                            <p>Automatically calculated as <?php echo LOAN_CHARGES['ATTORNEES_FEE_RATE']?>% of loan amount, 
                            put 0 if loan has no attornees fee</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Loan Interest ' . ' (' . LOAN_CHARGES['LOAN_INTEREST_FEE_RATE']. '%' . ')');
                                Form::text('interest_rate_amount', '', [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id' => 'loanInterestFeeRate'
                                ]);
                            ?>
                            <p>Automatically calculated as <?php echo LOAN_CHARGES['LOAN_INTEREST_FEE_RATE']?>% of loan amount, put 0 if loan has no attornees fee</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Total Balance');
                                Form::text('', '', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'id' => 'totalBalance'
                                ]);
                            ?>
                            <p>The Total amount of the customer will pay</p>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Total Payment');
                                Form::text('', ui_html_amount($totalPayment), [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::submit('', 'Update Loan Amount', [
                                    'class' => 'btn btn-primary btn-sm'
                                ])
                            ?>

                            <a href="/CashAdvanceReleaseController/show/<?php echo $cashAdvanceRelease->id?>" class="btn btn-danger btn-sm">Cancel Update</a>
                        </div>
                    <?php Form::close()?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild() ?>

<?php build('scripts') ?>
    <script src="<?php echo URL.DS.'js/loan_form/form_computation.js'?>"></script>
<?php endbuild()?>
<?php occupy() ?>