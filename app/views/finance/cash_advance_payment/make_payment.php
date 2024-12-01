<?php build('content')?>
<?php Flash::show()?>
<div class="row">
  <div class="col-md-5">
    <form class="" action="/FNCashAdvancePayment/store"
      method="post" enctype="multipart/form-data">

      <input type="hidden" name="user_id" value="<?php echo $user->id?>">
      <div class="form-group">
        <label for="">Outstanding Balance</label>
        <input type="text"  name="amount" class="form-control" value="<?php echo $balance?>" readonly/>
      </div>
      <input type="hidden" name="loan_id" value="<?php echo $_GET['loan_id']?>">
      <div class="form-group">
        <label for="">Amount</label>
        <input type="number"  name="amount" class="form-control" autocomplete="off" required />
      </div>

      <input type="submit" name="" value="Save Payment" class="btn btn-primary btn-sm">
    </form>

  </div>


  <div class="col-md-7">
    <h3><?php echo $user->fullname?></h3>
     <div style="overflow-x:auto;">

    <table class="table">
      <thead>
        <tr>
          <th>Username</th>
          <th><?php echo $user->username?></th>
        </tr>

        <tr>
          <th>Account Level</th>
          <th><?php echo $user->status?></th>
        </tr>
      </thead>
    </table>

      <table class="table">
          <thead>
              <th>Username</th>
              <th>Available Earnings</th>

          </thead>

           <tbody>

                 <?php for($row = 0; $row < count($earning_info); $row++) :?>

                       <tr>

                        <td><?php echo $earning_info[$row][1] ?></td>
                        <td>&#8369;<?php echo to_number($earning_info[$row][2]); ?></td>

                      </tr>

                <?php endfor; ?>
          </tbody>
      </table>
  </div>

  </div>
</div>
<?php endbuild()?>



<?php occupy('templates/layout')?>
