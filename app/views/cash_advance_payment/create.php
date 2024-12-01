<?php build('content') ?>
<div class="container-fluid">
    <div class="col-md-5 mx-auto">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Payment Form')) ?>
            <div class="card-body">
                <?php Flash::show() ?>
                <?php
                    Form::open([
                        'method' => 'post'
                    ]);
                    
                    Form::hidden('loan_id', $loanId);
                ?>
                    <div class="form-group">
                        <p>Creating Payment for <?php echo WordLib::get('cashAdvance')?> : #<?php echo $loan->code?></p>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Borrower Name');
                                    Form::text('', $loan->borrower_fullname, [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                    Form::label('Borrower Username');
                                    Form::text('', $loan->username, [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Balance');
                            Form::text('', $loan->balance, [
                                'class' => 'form-control',
                                'readonly' => true
                            ]);
                        ?>
                    </div>
                    <hr>

                    <div class="form-group">
                        <?php
                            Form::label('Bank Used');
                            echo '<select class="form-control" name="org_id" required>';
                            foreach(arr_layout_keypair($banks, 'id', 'meta_value') as $key => $val) {
                                if($key == $gotymeBankId) {
                                    echo "<option value='{$key}'>{$val}</option>";
                                }else{
                                    echo "<option value='{$key}' disabled>{$val}</option>";
                                }
                            }
                            echo '</select>';
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <?php
                            Form::label('Amount Paid');
                            Form::text('amount_paid', '', [
                                'placeholder' => '',
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Reference');
                            Form::text('external_reference', '', [
                                'placeholder' => '',
                                'class' => 'form-control',
                                'required' => true
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                            Form::label('Day of Payment');
                            Form::date('entry_date', get_date(today()), [
                                'placeholder' => '',
                                'class' => 'form-control',
                                'required' => true
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php Form::submit('', 'Post Payment', [
                            'class' => 'btn btn-primary btn-sm'
                        ])?>
                    </div>
                <?php Form::close() ?>
            </div>
        </div>
    </div>
</div>
<?php endbuild() ?>
<?php occupy() ?>