<?php build('content')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>

<style>
    .module-container{
    }.module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px; }

table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;

  border: 1px solid #ddd;}

    th, td {
      text-align: left;
      padding: 8px;}
    tr:nth-child(even){background-color: #f2f2f2}
</style>
            <?php $step_number++; ?>
            <div style="overflow-x:auto;">
              <h3><?php echo $title; ?></h3>

              <a href="?advance_payment_list">Show Advance Payments</a><br>
              <a href="?temp_list">Show Product Advance</a>
                <?php Flash::show()?>
                <?php Flash::show('purchase_message')?>
                 <br> <br>
                <h3>Step 1</h3>
                <br>
                <table class="table" >
                    <thead>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Network</th>
                        <th>Created At</th>
                        <th>Email</th>
                        <th>COP</th>
                        <th>ID</th>
                        <th>FB Link</th>
                        <th>Total Direct Ref</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <?php if(!$isCsr):?>
                        <th>Action</th>
                        <?php endif?>

                        <?php if($isCsr) :?>
                        <th>For Shipment</th>
                        <th>Stand By</th>
                        <th></th>
                        <?php endif?>
                    </thead>

                     <tbody>
                           <?php $counter = 1;?>
                           <?php foreach($result as $data) :?>
                           <?php $isForShipment = mTocForShipment($data->userid)?>
                            <?php

                              if(!$isForShipment) continue;

                              if($data->total_direct_ref < 2) continue;
                            ?>
                              <tr>
                                    <td><?php echo $counter ?></td>
                                    <td><?php echo $data->fullname; ?></td>
                                    <td>
                                      <a href="/Account/doSearch?username=<?php echo $data->username; ?>&searchOption=username" target="_blank"><span class="label label-info"><?php echo $data->username; ?></span></a>
                                    </td>
                                    <td><?php echo $data->mobile; ?></td>
                                    <td><?php echo sim_network_identification($data->mobile)?></td>
                                    <td><?php echo date_long($data->created_at)?></td>
                                    <td><?php echo $data->email; ?></td>
                                    <td><?php
                                        $address = $data->address_cop->address ?? 'Update';
                                        echo "<a href='javascript:void(null)' class='update' 
                                          data-userid='{$data->userid}'> $address </a>";
                                      ?></td>
                                    <td> <a class="btn btn-info btn-sm" 
                                                  href="/UserIdVerification/staff_preview_id/<?php echo seal($data->userid); ?>" 
                                                   target="_blank" >Preview ID</a>
                                            </td>
                                    <td><a class="btn btn-primary btn-sm" href="<?php echo $data->valid_link; ?>" target="_blank">Preview</a></td>

                                    <td><?php echo $data->total_direct_ref; ?></td>
                                    <td><?php   echo " <b>".$productAutoloan->amount_original."</b><br>";
                                          ?></td>

                                    <td><?php  
                                          echo  " <b>".$productAutoloan->box_eq."</b><br>"; ?></td>
                                    <?php if(!$isCsr) :?>
                                    <td>
                                      <?php
                                        Form::open([
                                          'method' => 'post',
                                          'action' => '/TocProductLoan/loan'
                                        ]);
                                          echo "<label>Tracking Number</label>";
                                          Form::text('shipping_track_number');

                                          echo "<br><label>Delivery Fee</label>";
                                          Form::text('delivery_fee' , 95);

                                          echo "<br><label>Shipping Details</label>";
                                          Form::text('shipping_details' ,'');

                                          Form::hidden('code_id' , $productAutoloan->id);
                                          Form::hidden('amount' , $productAutoloan->amount_original);
                                          Form::hidden('quantity' , $productAutoloan->box_eq);
                                          Form::hidden('user_id' , $data->userid);
                                        
                                          Form::submit('' , 'Product Sent' , [
                                            'class' => 'btn btn-sm btn-primary'
                                          ]);
                                        Form::close();
                                      ?>
                                    </td>
                                    <?php endif?>

                                    <?php if($isCsr) :?>
                                    <td>
                                      <a href="/TocController/moveToShipment/<?php echo seal($data->userid)?>" class="btn btn-sm btn-primary">Move to Shipment</a>
                                    </td>

                                    <td>
                                      <a href="/TocController/move_to_standby/<?php echo seal($data->userid)?>" class="btn btn-sm btn-danger">Move To stand by</a>
                                    </td>

                                   
                                    <?php endif?>
                              </tr>

                            <?php $counter++;?>
                            <?php endforeach;?>
                    </tbody>
                </table>
                <br><br>
                <h3>Step 2 to 18</h3>
                <br>
                <table class="table" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Loan Number</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Registered At</th>
                        <th>phone</th>
                        <th>Address</th>
                        <th>COP</th>
                        <th>FB Link</th>
                        <th>Total Direct Ref</th>
                        <th>Product Type</th>
                        <th>Payment</th>
                        <th>Balance</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <?php if(!$isCsr):?>
                        <th>Action</th>
                        <?php endif?>

                        <?php if($isCsr):?>
                        <th>Stand By</th>
                        <th>For Shipment</th>
                        <th></th>
                        <?php endif?>
                        
                    </thead>

                     <tbody>
      
                      <?php $counter = 1?>
                      <?php foreach($tocAll['tocPassers'] as $key => $passer) :?>
                      <?php if($passer->balance > 0 || empty($passer->borrow)) continue?>
                      
                      <?php $borrow = $passer->borrow[0]?>
                      <?php $isForShipment = mTocForShipment($borrow->userid)?>
                      <?php
                          if($isCsr && $isForShipment) continue;

                          if($isStockManager && !$isForShipment) continue;
                        ?>
                      
                        <tr>
                            <td><?php echo $counter++ ?></td>
                            <td><?php echo $borrow->date_time?></td>
                            <td>#<?php echo $borrow->code; ?></td>
                            <td><?php echo $borrow->fullname; ?></td>
                            <td>
                              <a href="/Account/doSearch?username=<?php echo $borrow->username; ?>&searchOption=username" target="_blank"><span class="label label-info"><?php echo $borrow->username; ?></span></a>
                            </td>
                            <td><?php echo date_long($borrow->registered_at)?></td>
                            <td><?php echo $borrow->mobile; ?></td>
                            <td><?php echo $borrow->address; ?></td>
                            <td>
                              <?php
                                $address = $passer->cop->address ?? 'Update';
                                echo "<a href='javascript:void(null)' class='update' 
                                  data-userid='{$borrow->userid}'> $address </a>";
                              ?>
                            </td>
                            <td>
                              <?php if($borrow->valid_social_media != "no_link"): ?>
                                  <a class="btn btn-primary btn-sm" 
                                  href="<?php echo $borrow->valid_social_media; ?>" 
                                  target="_blank">Preview</a>
                              <?php else:?>
                                  <span class="label label-danger">No Valid FB Link</span>
                              <?php endif;?>
                            </td>
                            <td>
                                <?php echo $passer->total_direct_ref; ?>
                            </td>
                            <td>
                                <?php echo $borrow->product_name; ?>
                            </td>
                            <td><?php echo $passer->loanPayment; ?></td>
                            <td><?php echo $passer->balance; ?></td>
                            <td><?php   echo " <b>".($passer->productAutoloan2->amount_original * $passer->quantity)."</b><br>";
                                   ?></td>
                            <td><?php   
                                  echo  "<b>".($passer->productAutoloan2->box_eq * $passer->quantity)."</b>"; ?></td>
                            <?php if(!$isCsr):?>
                            <td>
                               <?php
                                Form::open([
                                  'method' => 'post',
                                  'action' => '/TocProductLoan/loan'
                                ]);
                                  echo "<label>Tracking Number</label>";
                                  Form::text('shipping_track_number');

                                  echo "<br><br><label>Delivery Fee</label>";
                                  Form::text('delivery_fee' , 95);

                                  echo "<br><br><label>Shipping Details</label>";
                                  Form::text('shipping_details' ,'');
                                  Form::hidden('code_id' , $passer->productAutoloan2->id);
                                  Form::hidden('amount' , ($passer->productAutoloan2->amount_original* $passer->quantity));
                                  Form::hidden('quantity' ,($passer->productAutoloan2->box_eq * $passer->quantity));
                                  Form::hidden('user_id' , $borrow->userid);

                                
                                  Form::submit('' , 'Product Sent' , [
                                    'class' => 'btn btn-primary btn-sm'
                                  ]);
                                Form::close();
                              ?>
                            </td>

                            <?php endif?>
                            <?php if($isCsr):?>
                              <td>
                                <a href="/TocController/moveToShipment/<?php echo seal($borrow->userid)?>" class="btn btn-sm btn-primary">Move To Ship</a>
                              </td>

                              <td>
                                <a href="/TocController/move_to_standby/<?php echo seal($borrow->userid)?>" class="btn btn-sm btn-danger">Move To stand by</a>
                              </td>

                           
                            <?php endif?>

                        </tr>
                      <?php endforeach?>
                    </tbody>
                </table>
            </div>
<?php endbuild()?>

<?php build('scripts')?>
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $( document ).ready( function() 
    {
      var url = get_url('API_UserAddresses/updateCOPAddress');


      if($(".addressInput"))
      {
        $(".addressInput").keyup( function(response) 
        {
          let address = $(this).val();
          let userId = $(this).data('userid');

          updateAddress(userId , address);  
        });
      }
      

      if($(".update"))
      {
        $(".update").click( function(response) 
        {

          let userId = $(this).data('userid');

          let currentAddress = $(this).html();

          $(".addressInput").data('userid' , userId);

          let address = prompt("Add COP Address", currentAddress.trim() );

          if (address != null && address.trim() != '') {
            updateAddress(userId , address);
            $(this).html( address );
          }

        });
      }
      


      function updateAddress(userId , address)
      {
        if( address.length > 5 ) 
        {
          $.ajax({
            url: url,
            data: {
              userid: userId,
              address: address
            },

            success: function(response) {
              console.log(response);
            }
          });
        }  
      }
    });
</script>
<?php endbuild()?>

<?php occupy('templates/layout')?>
