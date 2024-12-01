<?php build('content') ?>
<div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Change Password'))?>
        <div class="card-body">
            <?php Flash::show() ?>
            <form action="" method="post">
                <input type="hidden" name="userid" 
                value="<?php echo $account->id?>">

                <div class="form-group">
                    <label for="#">Password</label>
                    <input type="text" class="form-control" name="password">
                </div>

                <input type="submit" value="Save Information"
                class="btn btn-primary btn-sm">
            </form>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>