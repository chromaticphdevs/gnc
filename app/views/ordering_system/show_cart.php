<?php build('content')?>


<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

<h2><b><a href="/OrderingSystem/create?user_id=<?php echo $_GET['user_id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-shopping-basket" aria-hidden="true">Back to Shop</i></a></b></h2>
  <br>
<h4>Process Payment</h4>
<?php Flash::show('purchase_message')?>
<table class="table">
 <tr>
    <td>Upload Image</td>
    <td><?php Form::file('payment_picture' , $input['required'])?></td>
  </tr>
 <tr>
    <td>Delivery Fee:</td>
    <td><?php Form::text('delivery_fee' , '' ,$input['required'])?></td>
  </tr>

  <tr>
    <td>Shipping Details:</td>
    <td><?php Form::text('shipping_details' , '' ,$input['required'])?></td>
  </tr>

  <tr>
    <td>Payment Notes:</td>
    <td><?php Form::text('note' , '' ,$input['required'])?></td>
  </tr>


  <tr>
    <td>
      <?php
        Form::submit('submit' , 'Submit Payment' , [
          'class' => 'btn btn-success btn-sm form-confirm',
          'form'  => $input['form']
        ])
      ?>

    </td>
  </tr>
</table>


<?php
  Form::open([
    'method' => 'post',
    'action' => '/OrderingSystem/store',
    'id'     => $input['form'],
    'enctype' => 'multipart/form-data'
  ]);

  Form::hidden('user_id' , $userInfo->id);
  Form::hidden('total_purchase' , $total);

  Form::close();
?>

<div style="overflow-x:auto;">
    <h1><b>Total:  &#8369; <?php echo to_number($total) ?> </b></h1>
    <h2><b><i class="fa fa-shopping-cart" aria-hidden="true">Cart</i></b></h2>
    <table id="customers">
          <thead>
              <th>#</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Sub Total</th>
              <th></th>
          </thead>

           <tbody>
                 <?php $counter = 1;?>
                 <?php if(!empty($myCart)):?>
                   <?php foreach($myCart as $key => $value) :?>
                      <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo $value->product_name; ?></td>
                            <td><?php echo $value->quantity; ?></td>
                            <td><?php echo $value->amount; ?></td>
                            <td> <a href="/OrderingSystem/remove_item/<?php echo $key; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                      </tr>
                    <?php $counter++;?>
                    <?php endforeach;?>
                <?php endif;?>
          </tbody>
      </table>

    </div>
  </div>

<?php endbuild()?>
<?php occupy('templates/layout')?>
