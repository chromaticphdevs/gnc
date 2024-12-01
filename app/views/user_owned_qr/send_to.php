<?php build('content') ?>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">SEND TO</h4>
                <a href="/UserOwnedQRController/index">Back to list</a>
            </div>

            <div class="card-body">
                <?php
                    Form::open([
                        'method' => 'post',
                        'action' => ''
                    ]);
                    Form::hidden('user_code_id' , $code->id);
                ?>

                    <div class="form-group">
                        <?php
                            Form::label('Username');
                            Form::text('username' , '' , [
                                'class' => 'form-control'
                            ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?php Form::submit('' , 'Send Now' , ['class' => 'btn btn-primary btn-sm'])?>
                    </div>
                <?php Form::close()?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>