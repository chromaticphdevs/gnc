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
            'action' => '/FNCodeStorage/store_new'
        ])
    ?>  


    <div class="form-group">
        <?php 
            Form::label('Select Product');
            Form::select('product_id', 
                  arr_layout_keypair($products , 'id' , 'name'), 
                  '' , ['class' => 'form-control' , 'required' => '']);
        ?>
    </div>

    <div class="form-group">
        <?php 
            Form::label('Select Code Library');
            Form::select('code_id', 
                  arr_layout_keypair($codelibraries , 'id' , 'name'), 
                  '' , ['class' => 'form-control' , 'required' => '']);
        ?>
    </div>

    <div class="form-group row">

        <div class="col-md-4">
            <?php 
                Form::label('Original Amount');
                Form::number('oroginal_price' , '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>

        <div class="col-md-4">
            <?php 
                Form::label('Discounted Amount');
                Form::number('discounted_price' , '' , ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>

        <div class="col-md-4">
            <?php 
                Form::label('Select Code Library Category');
                Form::select('code_category', $code_library_category, '' ,
                 ['class' => 'form-control' , 'required' => '']);
            ?>
        </div>


    </div>

    <br>
    <?php
        Form::submit('' , 'Save Code Library' , ['class' => 'btn btn-primary'])
    ?>
    <?php Form::close()?>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>