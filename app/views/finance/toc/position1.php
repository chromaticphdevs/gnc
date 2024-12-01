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
                <?php Flash::show()?>
                <?php Flash::show('purchase_message')?>
                <table class="table" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Network</th>
                        <th>Created At</th>
                        <th>Email</th>
                        <th>Address</th>
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
                              if($isCsr && $isForShipment) continue;

                              if($isStockManager && !$isForShipment) continue;

                              if($data->total_direct_ref < 2) continue;
                            ?>
                            <?php if(empty($data->address)) continue?>
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
                                    <td><?php echo $data->address; ?></td>
                                    <td><?php echo $data->address_cop->address ?? ''?></td>
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
                                          Form::text('shipping_track_number');
                                          Form::hidden('delivery_fee' , 95);
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

                                    <td>
                                      <a href="<?php echo $linksAndButtons['previewLink'].'/'.seal($data->userid)?>" class="btn btn-primary btn-sm"> Show </a>
                                    </td>
                                    <?php endif?>
                              </tr>

                            <?php $counter++;?>
                            <?php endforeach;?>
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
