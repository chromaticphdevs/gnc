<?php build('content') ?>
<h3>Change Password</h3>
<form class="form" method="post">
    <?php  $userid = Session::get('USERSESSION')['id']?>
    <input type="hidden" name="userid" value="<?php echo $userid;?>">
    <div class="col-md-5">
    <div class="form-group">
        <label>New Password</label>
        <input type="text" name="password" placeholder="your new password" class="form-control">
    </div>

    <input type="submit" name="" class="btn btn-success">
</form>
<?php endbuild()?>

<?php occupy('templates.layout') ?>