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


<h4>Advance Payment</h4>
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
    <td>Select Code</td>
    <td>
      <?php $input['required']['id'] = 'code_id'?>
      <?php Form::select('code_id' , arr_layout_keypair($codes , 'id' , 'name') , '' , $input['required'])?>
      <?php unset($input['required']['id'])?>
      <small id="code_message"></small>
      <!--<a href="/FNCodeStorage/create" target="_blank">Can't find code? create it here</a>-->
    </td>
  </tr>

  <tr>
    <td>Amount</td>
    <td><?php Form::text('amount' , '' ,[
      'class' => 'form-control',
      'form'  => $input['form'],
      'id'    => 'amount',
      'readonly' => true
      ])?>
    </td>
  </tr>

  <tr>
    <td>Quantity</td>
    <td><?php Form::number('quantity' , '' ,[
      'class' => 'form-control',
      'form'  => $input['form'],
      'id'    => 'quantity',
      'readonly' => true
      ])?></td>
  </tr>


  <tr>
    <td>
      <?php
        Form::submit('submit' , 'Add to Cart' , [
          'class' => 'btn btn-primary btn-sm',
          'form'  => $input['form']
        ])
      ?>

      <a href="OrderingSystem/" class="btn btn-danger btn-sm">Cancel</a>
    </td>
  </tr>
</table>


<?php
  Form::open([
    'method' => 'post',
    'action' => '/OrderingSystem/add_cart',
    'id'     => $input['form'],
    'enctype' => 'multipart/form-data'
  ]);

  Form::hidden('user_id' , $userInfo->id);
  Form::hidden('product_name' , $userInfo->id, ['id' => 'product_name']);

  Form::close();
?>

<div style="overflow-x:auto;">
   <h1><b><i class="fa fa-cart-plus" aria-hidden="true">Cart</i></b></h1>
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
                 <?php $total = 0;?>
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
                    <?php $total += $value->amount; ?>
                    <?php endforeach;?>
                <?php endif;?>
          </tbody>
      </table>
        <h1><b>Total:  &#8369; <?php echo to_number($total) ?> </b></h1>

       <br> 
        <a href="/OrderingSystem/show_cart?user_id=<?php echo $userInfo->id; ?>" class="btn btn-success btn-sm">Proccess</a>
        <a href="/OrderingSystem/reset_cart" class="btn btn-danger btn-sm form-confirm">Reset Cart</a>
      <br> <br> <br>

  <h2 onclick="myFunction()"><b>Product Advance</b></h2>
  <div id="ProductLoanTable">
    <table class="table">
          <thead>
              <th>#</th>
              <th>Loan Number</th>
              <th>Date & Time</th>   
              <th>Full Name</th>
              <th>Amount</th>
              <th>Delivery Fee</th>
              <th>Payment</th>
              <th>Balance</th>
              <th>Package</th>
              <th>Status</th>
               <th></th>
          </thead>

           <tbody>
                 <?php $counter = 1;?>
                 <?php foreach($loans as $data) :?>
                    <tr>
                          <td><?php echo $counter ?></td>
                          <td>#<?php echo $data->code; ?></td>
                          <td>
                          <?php
                              $date=date_create($data->date_time);
                              echo date_format($date,"M d, Y");
                              $time=date_create($data->date_time);
                              echo date_format($time," h:i A");
                            ?>
                          </td>   
                          <td><?php echo $data->fullname; ?></td>
                          <td><?php echo $data->amount; ?></td>
                          <td><?php echo $data->delivery_fee; ?></td>
                          <td><?php echo $data->payment; ?></td>
                          <td><?php echo ($data->amount + $data->delivery_fee ?? 0) - $data->payment; ?></td>
                          <td><?php echo $data->package; ?></td>
                          <td style="text-align: center;">
                                <?php if($data->status == "Approved" ):?>
                                  <h4><b><span class="label label-info">NOT PAID</span></b></h4>
                                <?php elseif($data->status == "Return" ):?>
                                  <h4><b><span class="label label-warning">Retured</span></b></h4>
                                <?php else:?>
                                   <h4><b><span class="label label-success">PAID</span></b></h4>
                                <?php endif;?>
                          </td>
                          <td style="text-align: center;">
                                <?php if($data->status == "Approved" ):?>
                                  
                                  <a class="btn btn-success btn-sm" href="/ProductLoan/show/<?php echo seal($data->id)?>"> Make Payment</a>
                                <?php endif;?>
                          </td>
                    </tr>
                  <?php $counter++;?>
                  <?php endforeach;?>
          </tbody>
      </table>
    </div>
  </div>

<?php endbuild()?>


<?php build('scripts')?>
  <script type="text/javascript">
    $(document).ready(function()
    {
      function multiply(baseAmount , multiplyTo)
      {
        /*if values are empty*/
        if(baseAmount == '' || multiplyTo == '')
        return baseAmount;

        baseAmount = parseFloat(baseAmount);
        multiplyTo = parseFloat(multiplyTo);

        return baseAmount * multiplyTo;
      }
        /***SELECT CODE ***/

        $("#code_id").change(function(evt)
        {
          let codeId = $(this).val();
          //hide quantity tr
          $("#quantity_tr").css('display' , 'none');


          console.log(codeId);

          $.post(get_url('API_Codelibrary/get') ,
          {
            code_id: codeId
          }, function(response) {

            console.log(response);
            
            response = JSON.parse(response);
            /*NO RESULT*/
            if(response.data == false) return;

            let data = response.data;

            $("#product_name").val(data.name);

            if(data.category == 'non-activation' && data.box_eq == 1) {
              $("#amount").val(data.amount_discounted);
              $("#amount").attr('data-baseamount' , data.amount_discounted );
              $("#quantity").val(data.box_eq);
              $("#quantity").removeAttr('readonly');
            }else{
              $("#amount").val(data.amount_original);
              $("#amount").attr('data-baseamount' , data.amount_original );
              $("#quantity").val(data.box_eq);
              $("#quantity").attr('readonly' , true);
            }

            $("#code_message").html(
              `Category:${data.category}`
            );
          });
        });

        /*** END OF SELECT CODE ***/

        $("#quantity").keyup(function(evt) {

          let baseAmount = $("#amount").attr('data-baseamount');
          let quantity   = $(this).val();

          let total = multiply(baseAmount, quantity );

          $("#amount").val(total);
        });

         var x = document.getElementById("ProductLoanTable");
         x.style.display = "none";
    });


    function myFunction() 
    {
      var x = document.getElementById("ProductLoanTable");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
  </script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
