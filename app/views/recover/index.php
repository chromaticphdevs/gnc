<?php build('content') ?>
<div class="container">
    <div class="col-md-5 mx-auto">
        <div class="card mt-5">
            <?php echo wCardHeader(wCardTitle('Forgot Password')) ?>
            <div class="card-body">
                <?php if(! isset($_GET['email'])) :?>
                    <form method="get" id="member_login" action="">
                        <div><input type="text" name="email" placeholder="Eg.forgotmypassword@email.com" class="form-control"></div>
                        <small class="text-danger">Use the email of your account</small>
                        <div><button type="submit" class="btn btn-primary">Send</button></div>
                    </form>
                <?php else:?>
                    <?php foreach($userList as $user) :?>
                        <form method="post" action="" style="margin-top: 5px; border-bottom:2px solid #000; padding:10px">
                            <input type="hidden" name="userid" value="<?php echo base64_encode(serialize($user->id))?>">
                            <input type="hidden" name="email" value="<?php echo $user->email?>">
                            
                            <div class="inline">
                                <div class="row">
                                    <div class="col-md-10"><?php echo $user->username;?></div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm" 
                                        data-username="<?php echo $user->username?>">Send</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endforeach;?>
                <?php endif?>
            </div>

            <div class="separator"> <br>
                <?php Flash::show() ?> 
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php occupy('templates/tmp/landing')?>