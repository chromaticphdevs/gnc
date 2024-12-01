<?php build('content') ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Agreement</h4>
        </div>

        <div class="card-body">
            <?php Flash::show()?>
            <?php 
                Form::open([
                    'method' => 'post'
                ]);

                Form::hidden('user_id', $userId);
            ?>
            <div class="group-section">
                <legend>Borrower</legend>
                <div class="form-group">
                    <?php
                        Form::label('Name');
                        Form::text('borrower_name', $borrowerName, [
                            'placeholder' => 'Borrower Complete Name',
                            'class' => 'form-control',
                            'readonly' => true
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Address');
                        Form::textarea('borrower_address', $user->address, [
                            'placeholder' => 'Borrower Address',
                            'class' => 'form-control',
                            'readonly' => true
                        ]);
                    ?>
                </div>
            </div>

            <div class="group-section">
                <legend>Co Borrower (1)</legend>
                <div class="form-group">
                    <?php
                        Form::label('Borrower Name');
                        Form::text("coborrower[1][name]", '', [
                            'placeholder' => 'Borrower Complete Name',
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Mobile Number');
                        Form::text("coborrower[1][mobile_number]", '', [
                            'placeholder' => 'Mobile Number',
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <label for="cboxusera">
                        <?php Form::checkbox('coborrower[1][add]','add', ['id' => 'cboxusera'])?> Check to add
                    </label>
                </div>

                <legend>Co Borrower (2)</legend>
                <div class="form-group">
                    <?php
                        Form::label('Borrower Name');
                        Form::text("coborrower[2][name]", '', [
                            'placeholder' => 'Borrower Complete Name',
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Mobile Number');
                        Form::text("coborrower[2][mobile_number]", '', [
                            'placeholder' => 'Mobile Number',
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <label for="cboxuserb">
                        <?php Form::checkbox('coborrower[2][add]','add', ['id' => 'cboxuserb'])?> Check to add
                    </label>
                </div>
            </div>
                
            <div class="group-section">
                <div class="form-group">
                    <?php
                        Form::label('Amount Loan');
                        Form::text("loan[amount]", $amount, [
                            'placeholder' => 'Amount loan in number',
                            'class' => 'form-control',
                            'readonly' => true
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Interest Rate');
                        Form::text('loan[interest_rate]', $loanInterestRate, [
                            'placeholder' => 'Interest Rate',
                            'class' => 'form-control',
                            'readonly' => true
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Payment Method');
                        Form::text('loan[payment_method]', $loanPaymentMethod, [
                            'placeholder' => 'Payment Method',
                            'class' => 'form-control',
                            'readonly' => true
                        ]);
                    ?>
                </div>
            </div>

            <div class="text-center" style="margin-bottom: 20px;">
                <label for="checkboxLoanAgreement">
                    <input type="checkbox" id="checkboxLoanAgreement" name="loan[cbox_agreement]" required>
                    I Verify all informations above are correct
                </label>
            </div>
            <?php Form::close()?>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php build('headers')?>
    <style>
        .group-section{
            border: 1px solid #eee;
            padding: 8px;
            margin-bottom: 5px;
        }
    </style>
<?php endbuild()?>
<?php occupy()?>