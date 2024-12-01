<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonLeft('', [
            $navigationHelper->setnav('', 'Back', '/LoanProcessorVideoController/index')
        ]);
        ?>

        <div class="col-md-5 mx-auto">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Add Approval Video for your processed loans')) ?>
                <div class="card-body">
                    <?php Flash::show()?>
                    <?php Form::open([
                        'method' => 'post',
                        'enctype' => 'multipart/form-data'
                    ]) ?>
                        <div class="text-center">
                            <p>Upload video of approval for this member</p>
                            <h1><?php echo $member->fullname?></h1>
                        </div>

                        <?php echo wDivider(70) ?>
                        <div class="form-group">
                            <?php
                                Form::label('Video to upload');
                                Form::file('file', [
                                    'class' => 'form-control',
                                    'required' => true
                                ])
                            ?>
                        </div>

                        <div class="form-group">
                            <?php Form::submit('', 'Upload Video', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                        </div>
                    <?php Form::close() ?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>