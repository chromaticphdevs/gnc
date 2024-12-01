<?php build('content')?>
<div class="col-md-5">
  <h3>Account Activation</h3>
  <form action="" method="post">
    <div class="form-group">
      <label for="#">Activation Code</label>
      <input type="text" name="activationCode" class="form-control" placeholder="Enter your activation code">
    </div>

    <input type="submit" class="btn btn-primary btn-sm" value="Activate Code">
  </form>
</div>
<?php endbuild()?>

<?php occupy('templates.layout')?>