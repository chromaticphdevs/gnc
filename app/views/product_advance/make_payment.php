<?php build('content')?>
<h4>Payment</h4>
<?php Flash::show('purchase_message')?>
<table class="table">
  <tr>
    <td>Fullname:</td>
    <td><strong><?php echo $userInfo->fullname; ?></strong></td>
  </tr>

  <tr>
    <td>Status/Level</td>
    <td><strong><?php echo $userInfo->status; ?></strong></td>
  </tr>

  <tr>
    <td>Email:</td>
    <td><strong><?php echo $userInfo->email; ?></strong></td>
  </tr>
  <tr>
    <td>Mobile Number:</td>
    <td><strong><?php echo $userInfo->mobile; ?></strong></td>
  </tr>
  <tr>
    <td>Upload Image</td>
    <td><?php Form::file('payment_picture' , $input['required'])?></td>
  </tr>

  <tr>
    <td>Amount</td>
    <td><?php Form::text('amount' , $_GET['amount'] ,[
      'class' => 'form-control',
      'form'  => $input['form'],
      'id'    => 'amount',
      'readonly' => true
      ])?>
    </td>
  </tr>

  <tr>
    <td><?php Form::hidden('loan_id' , $loan_id ,$input['required'])?></td>
  </tr>

  <tr>
    <td>
      <?php
        Form::submit('submit' , 'Submit Payment' , [
          'class' => 'btn btn-primary btn-sm form-confirm',
          'form'  => $input['form']
        ])
      ?>
      <a href="ProductPurchase/" class="btn btn-danger btn-sm">Cancel</a>
    </td>
  </tr>
</table>


<?php
  Form::open([
    'method' => 'post',
    'action' => '/FNProductAdvance/payment',
    'id'     => $input['form'],
    'enctype' => 'multipart/form-data'
  ]);

  Form::hidden('user_id' , $userInfo->id);

  Form::close();
?>

<?php endbuild()?>

<?php occupy('templates/layout')?>
