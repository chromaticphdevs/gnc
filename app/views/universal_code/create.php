<?php build('content')?>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Codes</h4>
            <a href="/CodeBatchController/index">Back List</a>
        </div>
        <div class="card-body">
            <?php
                Form::open([
                    'method' => 'post',
                    'action' => ''
                ])
            ?>
            <div class="form-group">
                <?php
                    Form::label('Batch Quantity *');
                    Form::number('quantity' , '' , ['class' => 'form-control' , 'required' => true]);
                    Form::small('72 codes per batch')
                ?>
            </div>
            
            <div class="form-group">
                <?php
                    Form::label('Description');
                    Form::textarea('description' , '' , [
                        'class' => 'form-control'
                    ]);
                ?>
            </div>

            <div class="form-group">
                <?php Form::submit('' , 'Generate Code' , [
                    'class' => 'btn btn-primary btn-sm'
                ])?>
            </div>
            <?php Form::close()?>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>