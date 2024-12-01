<?php build('content')?>
<h4>Product Loan</h4>
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
    <td>Delivery Fee:</td>
    <td><?php Form::text('delivery_fee' , 95 ,$input['required'])?></td>
  </tr>

  <tr>
    <td>Shipping Details:</td>
    <td><?php Form::text('shipping_details' , '' ,$input['required'])?></td>
  </tr>

  <tr>
    <td>
      <?php
        Form::submit('submit' , 'Process' , [
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
    'action' => '/FNProductAdvance/make',
    'id'     => $input['form'],
    'enctype' => 'multipart/form-data'
  ]);

  Form::hidden('user_id' , $userInfo->id);

  Form::close();
?>


<div style="overflow-x:auto;">
  <h2><b>Product Advance</b></h2>
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
                                <?php if($data->status != "Paid" ):?>
                                   <h4><b><span class="label label-info">NOT PAID</span></b></h4>
                                <?php else:?>
                                   <h4><b><span class="label label-success">PAID</span></b></h4>
                                <?php endif;?>
                          </td>
                          <td style="text-align: center;">
                                <?php if($data->status != "Paid" ):?>
                                  
                                  <a class="btn btn-success btn-sm" href="/ProductLoan/show/<?php echo seal($data->id)?>"> Make Payment</a>
                                <?php endif;?>
                          </td>
                    </tr>
                  <?php $counter++;?>
                  <?php endforeach;?>
          </tbody>
      </table>

            <br>
      <h2><b>Cash Advance</b></h2>
      <table class="table">
            <thead>
                <th>#</th>
                <th>Loan Number</th>
                <th>Date & Time</th>   
                <th>Amount</th>
                <th>Payment</th>
                <th>Balance</th>
                <th>Status</th>
            </thead>

             <tbody>
                   <?php $counter = 1;?>
                   <?php foreach ($cash_loan as $key => $value):?>
                      <tr>
                            <td><?php echo $counter ?></td>
                            <td>#<?php echo $value->code; ?></td>
                            <td>
                            <?php
                                $date=date_create($value->created_on);
                                echo date_format($date,"M d, Y");
                                $time=date_create($value->created_on);
                                echo date_format($time," h:i A");
                              ?>
                            </td>   
                            <td><?php echo $value->amount; ?></td>
                            <td><?php echo $value->payment; ?></td>
                            <td><?php echo ($value->amount) - $value->payment; ?></td>

                            <td>
                                  <?php if($value->status != "Paid" ):?>
                                     <!--<h4><b><span class="label label-info">NOT PAID</span></b></h4>-->
                                     <a class="btn btn-success btn-sm" href="/FNCashAdvancePayment/make_payment/?userid=<?php echo seal($value->userid)?>&loan_id=<?php echo $value->id ?>">&nbsp;Make Payment&nbsp;</a>
                                  <?php else:?>
                                     <h4><b><span class="label label-success">PAID</span></b></h4>
                                  <?php endif;?>
                            </td>
                      </tr>
                    <?php $counter++;?>
                    <?php endforeach;?>
            </tbody>
        </table>
    <br>
      

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
    });
  </script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
