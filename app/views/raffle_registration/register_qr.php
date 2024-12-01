<?php build('content') ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Register User</h4>
                <?php Flash::show()?>
            </div>
            <div class="card-body">
                <?php if( !$whoIs ) :?>
                    <p><span class="badge badge-primary">READ:</span>  <span  class="text-primary">If you have an existing account with us, 
                        please login first before scanning coffee QRS.</span> </p>
                <?php else:?>
                    <a href="/<?php echo request()->url()?>?code=<?php echo $_GET['code']?>&collect=true" class="btn btn-primary btn-sm">Collect Code</a>
                        <i class="fa fa-info-circle" title="Collect this qr-code and share it to other people to include on your network."></i>
                    <hr>
                <?php endif?>
                <?php
                    Form::open([
                        'method' => 'post',
                        'action' => '',
                        'id'  => 'form_main'
                    ]);

                    Form::hidden('qr_id' , $code_instance->id);
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
                            <?php
                                Form::label('Password *');
                                Form::password('password' , '' , [
                                    'class' => 'form-control'
                                ]);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                Form::label('Email *');
                                Form::text('email' , '' , [
                                    'class' => 'form-control'
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
                                    Form::label('Direct Sponsor(Username)');
                                    Form::text('direct_sponsor' , $whoIs['username'] ?? '', [
                                        'class' => 'form-control',
                                        'required' => true
                                    ]);
                                    Form::small('Direct Sponsor Username');
                                ?>
                            </div>

                            <div class="col-md-6">
                               <div class="row">
                                   <div class="col-md-8">
                                    <?php
                                        Form::label('Upline (Username)');
                                        Form::text('upline' , $whoIs['username'] ?? '', [
                                            'class' => 'form-control',
                                            'required' => true
                                        ]);
                                        Form::small('Upline Username');
                                    ?>
                                   </div>

                                   <div class="col-md-4">
                                    <?php
                                        Form::label('Position*');
                                        Form::select('position' , ['LEFT' , 'RIGHT'] , '' , [
                                            'class' => 'form-control',
                                            'required' => true
                                        ]);
                                    ?>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php Form::submit('qr_register' , 'Register' , ['class' => 'btn btn-primary']); ?>
                <?php Form::close()?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/baselayout')?>