<?php build('content')?>
    <div class="col-md-7"> 
        <?php if( !empty(whoIs()) ) :?>
            <form action="" method="post">
                <input type="hidden" name="user_id" value="<?php echo whoIs('id')?>">
                <input type="submit" value="Collect">
            </form>
        <?php endif?>

        <?php
            Form::open([
                'method' => 'post',
                'action' => ''
            ]);

            Form::hidden('code' , $code);
        ?>

        <h1>QR Registration</h1>
        <div class="form-group">
            <?php
                Form::label('Full Name *');
                Form::text('full_name' , '' , [
                    'class' => 'form-control',
                    'required' => true
                ]);
            ?>
        </div>

        <div class="form-group">
            <?php
                Form::label('Mobile Number *');
                Form::text('mobile_number' , '' , [
                    'class' => 'form-control',
                    'required' => true
                ]);
            ?>
        </div>
        
        <div class="form-group">
            <?php
                Form::label('City *');
                Form::text('city' , '' , [
                    'class' => 'form-control',
                    'required' => true
                ]);
            ?>
        </div>

        <div class="form-group">
            <?php
                Form::label('Barangay *');
                Form::text('barangay' , '' , [
                    'class' => 'form-control',
                    'required' => true
                ]);
            ?>
        </div>

        <div class="form-group">
            <?php
                Form::label('Full Address *');
                Form::text('address' , '' , [
                    'class' => 'form-control',
                    'required' => true
                ]);
            ?>
        </div>

        <div class="form-group">
            <?php Form::submit('' , 'Save Entry' , [
                'class' => 'btn btn-primary btn-sm'
            ])?>
        </div>
        <?php Form::close()?>
    </div>
<?php endbuild()?>
<?php occupy('templates/baselayout')?>