<?php build('content')?>
<?php Flash::show()?>
<div class="col-md-5">
  <form class="" action="/CAOnlinePayment/store"
  method="post" enctype="multipart/form-data">
  <input type="hidden" name="user_id" value="<?php echo $user['info']->id?>">
  <input type="hidden" name="loan_id" value="<?php echo $loan_id?>">
  <input type="hidden" name="loan_code" value="<?php echo $user['loan_info']->code?>">
  <input type="hidden" name="bank_account" value="<?php echo $user['bank_account']?>">
  <div class="form-group">
    <h3>Outstanding Balance: <b>&#8369;<?php echo $user['balance']?></b></h3>
    <input type="hidden"  name="amount" class="form-control" value="<?php echo $user['balance']?>" readonly/>
  </div>
  <br> <br>
  <div class="form-group">
    <h4><b>Enter Amount:</b></h4>
    <input type="number"  name="amount" class="form-control" autocomplete="off"  min="1" max="<?php echo $user['balance']?>" required/>
  </div>
  <?php
    if($user['balance'] > 0 ) {
      ?>
        <input type="submit" name="" value="Pay with Pera-e"
        class="btn btn-primary btn-sm form-confirm">
      <?php
    }else{
      ?>
        <p class='text-info'>
          No unsettled cash advance
        </p>
      <?php
    }
  ?>
  </form>

  <br>
  <hr>
</div>

<div class="col-md-7">
  <table class="table">
    <thead>
      <tr>
        <th>Initial Cash Advance</th>
        <th><b>&#8369;<?php echo $user['totalCashAdvance']?></b></th>
      </tr>
      <tr>
        <th>Payments</th>
        <th><b>&#8369;<?php echo $user['payments']?></b></th>
      </tr>
      <tr>
        <th>Balance</th>
        <th><b>&#8369;<?php echo $user['balance']?></b></th>
      </tr>
    </thead>
  </table>

<!-- payment history-->
 <br>
  <br>
  <h4>Payment History</h4>
    <table class="table">
    <thead>
  
        <th>Amount</th>
        <th>Category</th>
        <th>Date & Time</th>

    </thead>

       <?php foreach($user['payments_history'] as $key => $row) :?>
            <tr>
              <td>&#8369;<?php echo $row->amount; ?></td>
              <td><?php echo $row->category; ?></td>
              <td>  <?php
                              $date=date_create($row->date_time);
                              echo date_format($date,"M d, Y");
                              $time=date_create($row->date_time);
                              echo date_format($time," h:i A");
                    ?>
                </td>
            </tr>
      <?php endforeach; ?>

  </table>
   <h3>Total Payment : <b>&#8369;<?php echo number_format($user['payments'] , 2)?></b></h3>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>
