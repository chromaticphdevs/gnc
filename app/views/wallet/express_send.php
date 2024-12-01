<?php build('content') ?>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $title?></h4>
                
                <h2>Wallet : <?php echo to_number($availableEarning)?></h2>
            </div>
            
            <div class="card-body">
                <?php
                    Form::open([
                        'method' => 'post'
                    ]);

                    Form::hidden('userid', $whoIs['id'])
                ?>
                <div class="form-group">
                    <?php
                        Form::label('Send To*');
                        Form::text('recipient_username', '', [
                            'class' => 'form-control',
                            'required' => true
                        ]);
                        Form::small('Use recipient username');
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Amount*');
                        Form::text('amount', '', [
                            'class' => 'form-control',
                            'required' => true
                        ]);
                        Form::small('Amount to send');
                    ?>
                </div>
                
                <div class="form-group">
                    <?php
                        Form::label('notes');
                        Form::text('notes', '', [
                            'class' => 'form-control'
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php Form::submit('', 'Send', [
                        'class' => 'btn btn-primary'
                    ])?>
                </div>

                <?php Form::close()?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>