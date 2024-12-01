<?php build('content') ?>
<div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Create loan for verified users'))?>
        <div class="card-body">
            <p>Can be used for renewal of loans</p>
            <?php Flash::show()?>
            <?php
                Form::open([
                    'method' => 'post'
                ]);
            ?>
                <div class="form-group">
                    <?php
                        Form::label('Username');
                        Form::text('username', '', [
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>

                <div class="form-group">
                    <?php Form::submit('', 'Autoloan', [
                        'class' => 'btn btn-primary'
                    ])?>
                </div>
            <?php Form::close() ?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>