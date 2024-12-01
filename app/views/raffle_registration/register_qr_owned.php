<?php build('content') ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Register User</h4>
                <?php Flash::show()?>
            </div>
            <div class="card-body">
                <?php if(!isset($_GET['isVerifiedEmail'])) :?>
                    <?php
                        Form::open([
                            'method' => 'post'
                        ]);  
                    ?>
                    <div class="form-group">
                        <?php
                            Form::label('Email *');
                            Form::text('email' , '' , [
                                'class' => 'form-control',
                                'requried' => true
                            ]);
                        ?>
                    </div>
                    <?php Form::submit('verify_email' , 'Verify Email' , ['class' => 'btn btn-primary']); ?>
                <?php Form::close();?>
                <?php else:?>
                    <!-- do some checks -->
                    <?php
                        $isVerifiedEmail = $_GET['isVerifiedEmail'] ?? '';
                        $isVerifiedEmail = unseal($isVerifiedEmail);

                        $email = $isVerifiedEmail['email'] ?? 'gonzalesmarkangeloph@gmail.com';
                        $date = $isVerifiedEmail['date'] ?? Date('Y-m-d');

                        if($date != date($date)) {
                            dump("Expired Registration Link.");
                        }

                        Form::open([
                            'method' => 'post',
                            'action' => '',
                            'id'  => 'form_main'
                        ]);

                        Form::hidden('qr_id' , $owned_code->id);
                    ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('First Name *');
                                    Form::text('firstname' , '' , [
                                        'class' => 'form-control',
                                        'required' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                            <?php
                                Form::label('Last Name *');
                                Form::text('lastname' , '' , [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Username *');
                                    Form::text('username' , '' , [
                                        'class' => 'form-control',
                                        'required' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php Form::label('Password *');?>
                                <?php
                                    Form::password('password' , '' , [
                                        'class' => 'form-control',
                                        'id'    => 'passwordText'
                                    ]);
                                ?>
                                <label for="showPassword">
                                    <input type="checkbox" id="showPassword">
                                    Show Password
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    Form::label('Email *');
                                    Form::text('email' , $email , [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ]);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                    Form::label('Phone Number');
                                    Form::text('mobile' , '' , [
                                        'class' => 'form-control'
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- CUSTOMER SPECIFIC INPUT -->
                    <div id="id_upline_and_direct_sponsor">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        Form::label('Direct Sponsor');
                                        Form::hidden('direct_sponsor' , $owned_code->direct_id);
                                        Form::text('' , $owned_code->direct_name , [
                                            'class' => 'form-control',
                                            'readonly' => true
                                        ]);
                                        Form::small('Direct Sponsor Username');
                                    ?>
                                </div>

                                <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php
                                            Form::label('Upline');
                                            Form::hidden('upline' , $upline['id'] , [
                                                'class' => 'form-control'
                                            ]);
                                            Form::text('' , $upline['name'] , [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]);
                                            Form::small('Upline Username');
                                        ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php
                                            Form::label('Position');
                                            Form::hidden('position' , $position , [
                                                'class' => 'form-control'
                                            ]);
                                            Form::text('' , $position , [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php Form::submit('owned_qr_register' , 'Register' , ['class' => 'btn btn-primary']); ?>
                    <?php Form::close()?>

                <?php endif?>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
  <script>
    $(document).ready(function(){
        $('#showPassword').click(function(){
            // alert('hey');
            if($('#passwordText').attr('type') == 'password') {
                $('#passwordText').attr('type', 'text');
            } else {
                $('#passwordText').attr('type', 'password');
            }
        });
    });
  </script>
<?php endbuild()?>
<?php occupy('templates/baselayout')?>