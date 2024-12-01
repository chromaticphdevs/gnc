<?php build('content')?>
    <div class="card col-md-5">
        <div class="card-header">
            <h4 class="card-title">Collect QR Code</h4>
        </div>
        <div class="card-body">
            <?php
                Form::open([
                    'method' => 'post',
                    'action' => ''
                ]);
                
                Form::hidden('direct_id' , whoIs()['id']);
                Form::hidden('upline_id' , whoIs()['id']);
                Form::hidden('user_id' , whoIs()['id']);
                Form::hidden('code_id' , $code_instance->id);
            ?>
            <div class="form-group">
                <?php
                    Form::label('Form Code');
                    Form::text('' , $code , ['class' => 'form-control' , 'readonly' => true])
                ?>
            </div>
            <div class="form-group">
                <?php
                    Form::label('Recruit Position *');
                    Form::select('position' , ['LEFT' , 'RIGHT'] , '' ,['class' => 'form-control' , 'required' => true]);
                ?>
            </div>

            <div class="form-group">
                <?php
                    Form::submit('collect' , 'Save Collected Codes',['class' => 'btn btn-primary btn-sm']);
                ?>
            </div>

            <?php Form::close()?>
        </div>
    </div>
<?php endbuild()?>

<?php occupy('templates/layout')?>