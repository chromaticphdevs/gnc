<?php build('content')?>
<?php Flash::show()?>
<div class="col-md-5">
  <form class="" action="/FNCashAdvancePayment/payByEarning"
  method="post" enctype="multipart/form-data">
  <input type="hidden" name="user_id" value="<?php echo $user['info']->id?>">
  <input type="hidden" name="total_earning" value="<?php echo $user['totalEarning']?>">
  <input type="hidden" name="loan_id" value="<?php echo $loan_id?>">
  <div class="form-group">
    <label for="">Outstanding Balance</label>
    <input type="text"  name="amount" class="form-control" value="<?php echo $user['balance']?>" readonly/>
  </div>

  <div class="form-group">
    <label for="">Amount</label>
    <input type="number"  name="amount" class="form-control" autocomplete="off" required />
  </div>
  <?php
    if($user['balance'] > 0 ) {
      ?>
        <input type="submit" name="" value="Save Payment"
        class="btn btn-primary btn-sm">
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
 <!-- <section class="form-pera-e">
    <section>
      <h4>Pera - E Account Number :<?php echo $pera->account_number?></h4>
    </section>

    <div class="">
      <?php
        Form::open([
          'method' => 'post',
          'action' => '/FNCashAdvancePaymentOnline/pay'
        ]);

        Form::hidden('payer[key]' , $pera->api_key);
        Form::hidden('payer[secret]' , $pera->api_secret);

        Form::hidden('payee[key]' , $peraAuth['key']);
        Form::hidden('payee[secret]' , $peraAuth['secret']);

        Form::hidden('user_id' , $user['info']->id);
        Form::hidden('loan_id' , $loan_id);
      ?>

      <div class="form-group">
        <label for="">Outstanding Balance</label>
        <input type="text"  name="amount" class="form-control" value="<?php echo $user['balance']?>" readonly/>
      </div>

      <div class="form-group">
        <?php
          Form::label('Amount');
          Form::text('amount' , '' , [
            'class' => 'form-control'
          ])
        ?>
      </div>

      <div class="form-group">
        <?php
          Form::submit('', 'Send Money' , [
            'class' => 'btn btn-primary btn-sm'
          ]);
        ?>
      </div>

      

      <?php Form::close()?>
    </div>
  </section>-->
</div>

<div class="col-md-7">
  <table class="table">
    <thead>
      <tr>
        <th>Initial Cash Advance</th>
        <th><?php echo $user['totalCashAdvance']?></th>
      </tr>
      <tr>
        <th>Payments</th>
        <th><?php echo $user['payments']?></th>
      </tr>
      <tr>
        <th>Balance</th>
        <th><?php echo $user['balance']?></th>
      </tr>
    </thead>
  </table>

  <h3>Available Earnings : <b><?php echo number_format($user['totalEarning'] , 2)?></b></h3>

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
              <td><?php echo $row->amount; ?></td>
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
   <h3>Total Payment : <b><?php echo number_format($user['payments'] , 2)?></b></h3>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>
