<?php build('content') ?>
    <div class="container-fluid">
        <div class="col-md-5">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Add New Member')) ?>

                <div class="card-body">
                    <?php
                        Form::open([
                            'method' => 'post'
                        ])
                    ?>
                        <p class="alert alert-info">
                            Create account for your referral, after submit your referral must confirm the registration through email. <br>
                            Credentials will also be sent to their email.
                        </p>
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
                                        Form::label('Email *');
                                        Form::text('email' , '', [
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

                        <div class="form-group">
                            <?php
                                Form::label('Address');
                                Form::text('address' , '' , [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                        </div>

                        <!-- CUSTOMER SPECIFIC INPUT -->
                        <div id="id_upline_and_direct_sponsor">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                            Form::label(WordLib::get('directSponsor'));
                                            Form::hidden('direct_sponsor' , $whoIs['id']);
                                            Form::text('' , $whoIs['firstname']. ' ' . $whoIs['lastname'], [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]);
                                            Form::small(WordLib::get('directSponsor'). ' Username');
                                        ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php
                                            Form::label(WordLib::get('upline'));
                                            Form::hidden('upline' , $whoIs['id'] , [
                                                'class' => 'form-control'
                                            ]);
                                            Form::text('' , $whoIs['firstname'] . ' ' .$whoIs['lastname'] , [
                                                'class' => 'form-control',
                                                'readonly' => true
                                            ]);
                                            Form::small(WordLib::get('upline'). ' Username');
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($loanProcessor)) :?>
                            <div class="form-group">
                                <?php 
                                    Form::label(WordLib::get('loanProcessor'));
                                    Form::hidden('loan_processor_id' , $whoIs['id'] , [
                                        'class' => 'form-control'
                                    ]);
                                    Form::text('', $whoIs['firstname'] . ' ' .$whoIs['lastname'], [
                                        'class' => 'form-control',
                                        'readonly' => true
                                    ])
                                ?>
                            </div>
                            <?php endif?>
                        </div>

                        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                    <?php Form::close()?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>