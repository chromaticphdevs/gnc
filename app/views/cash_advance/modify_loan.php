<?php build('content') ?>
    <div class="container-fluid">
        <?php
            echo wControlButtonLeft('', [
                $navigationHelper->setNav('', 'Back', '/CashAdvance/loan/'. seal($loan->id))
            ]);
        ?>
        <div class="col-md-6">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Modify Loan'))?>
                <div class="card-body">
                    <?php Flash::show()?>
                    <?php
                        Form::open([
                            'method' => 'post'
                        ])
                    ?>

                        <div class="form-group">
                            <?php
                                Form::label('Borrower');
                                Form::text('', $loan->borrower_fullname, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Loan Amount');
                                Form::text('loan_amount', ui_html_amount($loan->amount), [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id'  => 'loanAmount',
                                    'data-amount' => $loan->amount
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Service Fee');
                                Form::text('service_fee', '', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'id' => 'serviceFee'
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Attornees Fee');
                                Form::text('attornees_fee', '', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'id' => 'attorneesFee'
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Loan Interest ');
                                Form::text('interest_rate_amount', '', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'id' => 'loanInterestFeeRate'
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Total Balance');
                                Form::text('', '', [
                                    'class' => 'form-control',
                                    'id' => 'totalBalance',
                                    'readonly' => true
                                ]);
                            ?>
                            <p>The Total amount of the customer will pay</p>
                        </div>
                        <div class="form-group">
                            <?php
                                Form::submit('', 'Update Loan Amount', [
                                    'class' => 'btn btn-primary btn-sm'
                                ])
                            ?>

                            <a href="/CashAdvance/loan/<?php echo seal($loan->id)?>" class="btn btn-danger btn-sm">Cancel</a>
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