<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Loan-admin by pass'))?>
            <div class="card-body">
                <?php if(!isset($user)) :?>
                <div class="col-md-6 mx-auto">
                    <?php Flash::show()?>
                    <?php
                        Form::open([
                            'method' => 'get'
                        ])
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
                            <?php Form::submit('', 'Search User', [
                                'class' => 'btn btn-primary'
                            ])?>
                        </div>
                    <?php Form::close()?>
                </div>
                <?php else :?>  
                    <?php if(!$user) :?>
                        <p>User not found..</p>
                    <?php else :?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Name</td>
                                    <td><?php echo userVerfiedText($user);?> <?php echo $user->firstname?> <?php echo $user->lastname?></td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $user->email?></td>
                                </tr>
                            </table>
                        </div>

                        <?php 
                            Form::open([
                                'method' => 'post'
                            ]);

                            Form::hidden('username', trim($user->username));
                        ?>

                            <input type="submit" class="btn btn-primary btn-lg" value="Create Loan And Release">

                        <?php Form::close()?>
                    <?php endif?>
                <?php endif?>
            </div>
        </div>
    </div>
<?php endbuild()?> 
<?php occupy()?>