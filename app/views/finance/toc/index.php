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
            <div style="overflow-x:auto;">
              <h3>Test of character <?php echo $position?></h3>
                <?php Flash::show()?>
                <?php Flash::show('purchase_message')?>
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
                      <?php foreach($tocPassers as $key => $passer) :?>
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
                              <?php echo $borrow->cop_address ?? ''?>
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
                            <td><?php   echo " <b>".($productAutoloan->amount_original* $qty)."</b><br>";
                                   ?></td>
                            <td><?php   
                                  echo  "<b>".($productAutoloan->box_eq * $qty)."</b>"; ?></td>
                            <?php if(!$isCsr):?>
                            <td>
                               <?php
                                Form::open([
                                  'method' => 'post',
                                  'action' => '/TocProductLoan/loan'
                                ]);
                                  Form::text('shipping_track_number');
                                  echo "<br>";
                                  Form::hidden('delivery_fee' , 95);
                                  Form::hidden('code_id' , $productAutoloan->id);
                                  Form::hidden('amount' , ($productAutoloan->amount_original* $qty));
                                  Form::hidden('quantity' ,($productAutoloan->box_eq * $qty));
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

                             <!-- <td>
                                <a href="/TocController/move_to_standby/<?php echo seal($borrow->userid)?>" class="btn btn-sm btn-danger">Move To stand by</a>
                              </td>-->

                              
                              <td>
                                <a href="<?php echo $linksAndButtons['previewLink'].'/'.seal($borrow->userid)?>" class="btn btn-primary btn-sm"> Show </a>
                              </td>
                            <?php endif?>

                            <!--<td style="text-align: center;">

                              <?php if(isEqual($borrow->status,"Paid" )):?>
                               <a class="btn btn-success btn-sm" href="/TOC_Purchase/repeat_purchase?user_id=<?php echo seal($borrow->userid)?>">Release</a>
                             <?php endif; ?>

                            </td>

                           <?php if(!$passer->is_standby):?>
                                <td style="text-align: center;">                                  
                                   <a class="btn btn-danger btn-sm" href="/TocController/move_to_standby/<?php echo seal($borrow->userid)?>">Move to Standby</a>

                                </td>
                            <?php else:?>
                                <td style="text-align: center;">                                  
                                   <a class="btn btn-success btn-sm" href="/TocController/remove_to_standby/<?php echo seal($borrow->userid)?>">Remove to Standby</a>

                                </td>
                            <?php endif;?>-->
                        </tr>
                      <?php endforeach?>
                    </tbody>
                </table>
            </div>
    
        <!-- page content -->
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
          "pageLength": 10000
        } );


    } );
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
