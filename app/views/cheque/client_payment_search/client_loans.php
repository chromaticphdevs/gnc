<?php build('content')?>
<div style="overflow-x:auto;">
<h4>Product Loan</h4>

<table class="table">
  <tr>
    <td>Fullname:</td>
    <td><strong><?php echo $userInfo->fullname; ?></strong></td>
  </tr>
   <tr>
    <td>UserName</td>
    <td><strong><?php echo $userInfo->username; ?></strong></td>
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

</table>

  <h2><b>Product Advance</b></h2>
    <table class="table">
          <thead>
              <th>#</th>
              <th>Loan Number</th>
              <th>Date & Time</th>   
              <th>Amount</th>
              <th>Delivery Fee</th>
              <th>Payment</th>
              <th>Balance</th>
              <th>Package</th>
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
                          <td><?php echo $data->amount; ?></td>
                          <td><?php echo $data->delivery_fee; ?></td>
                          <td><?php echo $data->payment; ?></td>
                          <td><?php echo ($data->amount + $data->delivery_fee ?? 0) - $data->payment; ?></td>
                          <td><?php echo $data->package; ?></td>
                          <td style="text-align: center;">
                                <a class="btn btn-success btn-sm" href="/ProductLoan/show/<?php echo seal($data->id)?>"> Make Payment</a>
                          </td>
                    </tr>
                  <?php $counter++;?>
                  <?php endforeach;?>
          </tbody>
      </table>
      

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
