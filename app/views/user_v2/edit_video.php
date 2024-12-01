<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Upload Video'))?>
            <div class="card-body">
                <?php 
                    Form::open([
                        'method' => 'post',
                        'enctype' => 'multipart/form-data'
                    ]); 
                    
                    Form::hidden('user_id', $user['id']);
                ?>   

                    <div class="form-group">
                        <?php
                            Form::label('File');
                            Form::file('file',[
                                'class' => 'form-control'
                            ])
                        ?>
                    </div>

                    <div class="form-grorup">
                        <?php Form::submit('', 'Upload Video', [
                            'class' => 'btn btn-primary'
                        ]) ?>
                    </div>
                <?php Form::close() ?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>