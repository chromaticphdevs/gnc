<?php build('content')?>
<div class="container-fluid">
    <?php echo wControlButtonLeft('Bank Accounts',[
        $navigationHelper->setNav('', 'Bank List', '/UserBankController/index')
    ])?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Add Bank Detail')) ?>
        <div class="card-body">
            <?php
                Flash::show();
                
                Form::open([
                    'method' => 'post'
                ]);

                Form::hidden('user_id', whoIs('id'));
            ?>

                <div class="form-group">
                    <?php
                        Form::label('Organization');
                        Form::select('organization_id', arr_layout_keypair($banks, 'id', 'meta_value'), '', [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Account Number');
                        Form::text('account_number', '', [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Account Name');
                        Form::text('account_name', '', [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php Form::submit('', 'Save', [
                        'class' => 'btn btn-primary'
                    ])?>
                </div>
            <?php Form::close() ?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy() ?>
