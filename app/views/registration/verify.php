<?php build('content')?>
<div class="container-login100">
    <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
        <h3 class="text-center">Account Verification</h3>
        <?php Flash::show()?>
        <hr>
        <?php 
            Form::open([
                'method' => 'post',
                'action' => '/RegisterVerification/update'
            ]);

            Form::hidden('id' , $verificationid);
            
            Form::text('code' , '' ,[
                'id' => 'code',
                'placeholder' => 'Verification Code',
                'required' => '' ,
                'class' => 'input100'
            ]);

            print <<<EOF
                <p style='font-weight:bold; font-size:1em'> Please Enter the Four digit verification code sent to your
                <span style='color:red;'>{$via}</span> 
                to Activate {$user->firstname} {$user->lastname}<p><hr>
            EOF;

            Form::submit('' , 'Verify',[
                'class' => 'login100-form-btn'
            ]);

            Form::close();
        ?>
    </div>
</div>
<?php endbuild();?>

<?php occupy('templates.baselayout')?>