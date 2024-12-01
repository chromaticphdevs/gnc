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
                 <br> <br>
                <h3>For Deliveries</h3>
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
                        <th></th>
                        <th>Total Direct Ref</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </thead>

                     <tbody>
                           <?php $counter = 1;?>
                           <?php foreach($result as $row) :?>
                           <?php $isForShipment = mTocForShipment($row->userid)?>

                           <?php if($isForShipment) continue; ?>
                              <tr>
                                    <td><?php echo $counter ?></td>
                                    <td><?php echo $row->fullname; ?></td>
                                    <td>
                                      <a href="/Account/doSearch?username=<?php echo $row->username; ?>&searchOption=username" target="_blank"><span class="label label-info"><?php echo $row->username; ?></span></a>
                                    </td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td><?php echo sim_network_identification($row->mobile)?></td>
                                    <td><?php echo date_long($row->created_at)?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td>
                                      <?php
                                        $address = $row->address_cop->address ?? 'Update';
                                        echo "<a href='javascript:void(null)' class='update' 
                                          data-userid='{$row->userid}'> $address </a>";
                                      ?>
                                    </td>

                                    
                                    <td> <a class="btn btn-info btn-sm" 
                                                  href="/UserIdVerification/staff_preview_id/<?php echo seal($row->userid); ?>" 
                                                   target="_blank" >Preview ID</a>
                                            </td>
                                    <td><a class="btn btn-primary btn-sm" href="<?php echo $row->valid_link; ?>" target="_blank">Preview</a></td>

                                    <td>
                                      <a href="/FNUserSteps/send/<?php echo $row->mobile?>" class="btn btn-sm btn-success">Send Mechanics</a>
                                    </td>

                                    <td><?php echo $row->total_direct_ref; ?></td>
                                    <td><?php   echo " <b>".$productAutoloan->amount_original."</b><br>";
                                          ?></td>

                                    <td><?php  
                                          echo  " <b>".$productAutoloan->box_eq."</b><br>"; ?></td>
                                    <td>
                                      <a href="/TocController/moveToShipment/<?php echo seal($row->userid)?>" class="btn btn-sm btn-primary">Move to Shipment</a>
                                    </td>

                                    <!--<td>
                                      <a href="/TocController/move_to_standby/<?php echo seal($row->userid)?>" class="btn btn-sm btn-danger">Move To stand by</a>
                                    </td>-->
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
          "pageLength": 10
        } );


    } );
</script>
<?php endbuild()?>

<?php 
    function copAddress( $userId )
    {
      Form::textarea('address' , '' , [
        'class' => 'form-control addressInput' ,
        'rows'   => '5',
        'data-userid' => $userId
      ]);
    }
?>

<?php build('scripts')?>
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $( document ).ready( function() 
    {
      var url = get_url('API_UserAddresses/updateCOPAddress');

      $(".addressInput").keyup( function(response) 
      {
        let address = $(this).val();
        let userId = $(this).data('userid');

        updateAddress(userId , address);  
      });

      $(".update").click( function(response) {

        let userId = $(this).data('userid');

        let currentAddress = $(this).html();

        $(".addressInput").data('userid' , userId);

        let address = prompt("Add COP Address", currentAddress.trim() );

        if (address != null && address.trim() != '') {
          updateAddress(userId , address);
          $(this).html( address );
        }

      });


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
