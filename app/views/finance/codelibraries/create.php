<?php build('content')?>
<div class="row">
    <div class="col-md-6">
        <h4>Code Libraries / Create</h4>
    </div>
    <div class="col-md-6 text-right">
        <a href="/FNCodeStorage/" class="btn btn-primary">
            <i class="fa fa-list"></i>
        </a>
    </div>
</div>

<div class="well">
    <?php
        Form::open([
            'method' => 'post',
            'action' => '/FNCodeStorage/store'
        ])
    ?>  

    <div class="form-group">
        <?php
            Form::label('name');
            Form::text('name' , '' , ['class' => 'form-control' , 'required' => '']);
        ?>
    </div>

    <div class="form-group">
        <?php
            Form::label('Quantity');
            Form::text('box_eq' , '' , ['class' => 'form-control' , 'required' => '']);
        ?>
    </div>

    <div class="form-group">
        <?php
            Form::label('Price');
            Form::text('amount' , '' , ['class' => 'form-control' , 'required' => '']);
        ?>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <?php 
                Form::label('DRC Amount');
                Form::text('drc_amount' , '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>

        <div class="col-md-3">
            <?php 
                Form::label('UNILEVEL Amount');
                Form::text('unilevel_amount' , '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>


        <div class="col-md-3">
            <?php 
                Form::label('Binary Points');
                Form::text('binary_point' , '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>

        <div class="col-md-3">
            <?php 
                Form::label('Activation Level');
                Form::select('level' , $activationLevels , '' ,
                    ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-3">
            <?php
                Form::label('Max Pair');
                Form::number('max_pair', '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>

        <div class="col-md-3">
            <?php
                Form::label('Distribution');
                Form::number('distribution', '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>
    </div>

    <?php
        Form::submit('' , 'Save Code Library' , ['class' => 'btn btn-primary btn-sm'])
    ?>
    <?php Form::close()?>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>