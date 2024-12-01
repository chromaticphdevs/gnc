<?php build('content')?>
<div class="container-fluid">
    <?php echo wControlButtonLeft('Bank Accounts',[
        $navigationHelper->setNav('', 'Bank List', '/UserBankController/index')
    ])?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Add Bank Detail')) ?>
        <div class="card-body">
            <?php Flash::show()?>
            <?php
                Form::open([
                    'method' => 'post'
                ]);

                Form::hidden('id', $userBank->id);
            ?>

                <div class="form-group">
                    <?php
                        Form::label('Organization');
                        Form::select('organization_id', arr_layout_keypair($banks, 'id', 'meta_value'), $userBank->organization_id, [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Account Number');
                        Form::text('account_number', $userBank->account_number, [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Account Name');
                        Form::text('account_name', $userBank->account_name, [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php Form::submit('', 'Save', [
                        'class' => 'btn btn-primary'
                    ])?>

                    <a href="/UserBankController/delete/<?php echo $userBank->id?>" class="btn btn-primary btn-danger form-confirm">Delete</a>
                </div>
            <?php Form::close() ?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy() ?>
