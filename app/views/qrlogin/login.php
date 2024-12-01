<?php build('content') ?>
    <?php Flash::show()?>
    <?php if(!$user) :?>
    <div class="col-sm-12 col-md-3 mx-auto mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">QR LOGIN</h4>
                <?php Flash::show()?>
            </div>

            <div class="card-body">
                <?php
                    Form::open([
                        'method' => 'post'
                    ]);
                ?>

                <div class="form-group">
                    <?php
                        Form::label('Username');
                        Form::text('username' , '' , ['class' => 'form-control', 'required' => true]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Password');
                        Form::password('password' , '' , ['class' => 'form-control', 'required' => true]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Group');
                        Form::select('group_id' , $groups, '' , ['class' => 'form-control','required' => true]);
                    ?>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-sm btn-success" value="Login">
                </div>
                <?php Form::close()?>
            </div>
        </div>
    </div>
    <?php endif?>
    
    <?php if($user) :?>
    <div class="col-sm-12 col-md-3 mx-auto mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Account</h4>
                <?php Flash::show()?>
            </div>

            <div class="card-body">
                <h1><?php echo $user->firstname . ' ' . $user->lastname?></h1>
                    You are already logged in, you can now close this page.
                <hr>
            </div>
        </div>
    </div>
    <?php endif?>
<?php endbuild()?>

<?php build('scripts')?>
    <script>
        $(document).ready(function(){
            $("#duration").html(
                dateDifference(new Date(),new Date($("#clockInTime").val()))
            );
        })
    </script>
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>