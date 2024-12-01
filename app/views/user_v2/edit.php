<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonLeft('', [
            $navigationHelper->setnav('', 'Back to profile', '/AccountProfile/index/?userid='.$user->id)
        ])?>
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Edit User'))?>
            <div class="card-body">
                <h1>Edit User : <?php echo $user->fullname?>(<?php echo $user->username?>)</h1>
                <?php Flash::show() ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <?php echo wCardHeader(wCardTitle('General')) ?>
                            <div class="card-body">
                                <?php Form::open([
                                    'method' => 'post'
                                ]) ?>
                                    <div class="form-group">
                                        <?php
                                            Form::label('First Name');
                                            Form::text('firstname', $user->firstname, [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::label('Last Name');
                                            Form::text('lastname', $user->lastname, [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_general', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>
                            </div>
                            <div class="card-footer">
                                <h4>Danger Zone</h4>
                                <a href="#" class="btn btn-danger btn-lg mt-3">Disable Account</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <?php echo wCardHeader(wCardTitle('Secondaary')) ?>
                            <div class="card-body">
                                <?php Form::open([
                                    'method' => 'post'
                                ]) ?>
                                    <div class="form-group">
                                        <?php
                                            Form::label('Email');
                                            Form::text('email', $user->email, [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::label('Mobile');
                                            Form::text('mobile', $user->mobile, [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::label('Adddress');
                                            Form::text('address', $user->address, [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_secondary', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>

                                <?php echo wDivider(60)?>

                                <?php Form::open([
                                    'method' => 'post'
                                ])?>
                                    <div class="form-group">
                                        <?php
                                            Form::label('Username');
                                            Form::text('username', $user->username, [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_change_username', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>

                                <?php echo wDivider(40)?>

                                <?php Form::open([
                                    'method' => 'post'
                                ])?>
                                    <div class="form-group">
                                        <?php
                                            Form::label('Password');
                                            Form::password('password', '', [
                                                'class' => 'form-control',
                                                'required' => true
                                            ])
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_change_password', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <?php echo wCardHeader(wCardTitle('Network')) ?>
                            <div class="card-body">
                                <?php Form::open([
                                    'method' => 'post'
                                ]) ?>
                                    <div class="form-group">
                                        <?php
                                            Form::label(WordLib::get('directSponsor'));
                                            Form::text('direct_sponsor', '', [
                                                'class' => 'form-control',
                                                'required' => true,
                                                'placeholder' => 'Enter new ' .WordLib::get('directSponsor') . ' username '
                                            ]);

                                            Form::small($user->sponsor_fullname);
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_sponsor', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>
                            </div>

                            <div class="card-body">
                                <?php Form::open([
                                    'method' => 'post'
                                ]) ?>
                                    <div class="form-group">
                                        <?php
                                            Form::label(WordLib::get('upline'));
                                            Form::text('upline', '', [
                                                'class' => 'form-control',
                                                'required' => true,
                                                'placeholder' => 'Enter new ' .WordLib::get('upline') . ' username '
                                            ]);

                                            Form::small($user->upline_fullname);
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_connection', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>
                            </div>

                            <div class="card-body">
                                <?php Form::open([
                                    'method' => 'post'
                                ]) ?>
                                    <div class="form-group">
                                        <?php
                                            Form::label(WordLib::get('loanProcessor'));
                                            Form::text('loan_processor', '', [
                                                'class' => 'form-control',
                                                'required' => true,
                                                'placeholder' => 'Enter new ' .WordLib::get('loanProcessor') . ' username '
                                            ]);
                                            
                                            if($loanProcessor) {
                                                Form::small($loanProcessor->fullname);
                                            }
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            Form::submit('btn_loan_processor', 'Save Changes', [
                                                'class' => 'btn btn-primary'
                                            ]);
                                        ?>
                                    </div>
                                <?php Form::close()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?> 
<?php occupy()?>