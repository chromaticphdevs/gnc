<?php build('content')?>
<div style="overflow-x:auto;">
  <h3>Advance payments</h3>
  <a href="?">Return</a>
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
            <th>Quantity</th>
            <th>Action</th>

            <?php if($isCsr) :?>
            <th>For Shipment</th>
            <th>Stand By</th>
            <th></th>
            <?php endif?>
        </thead>

         <tbody>
               <?php $counter = 1;?>
               <?php foreach($result as $data) :?>
               <?php $userInfo = $data->user ?>
                  <tr>
                        <td><?php echo $counter ?></td>
                        <td><?php echo $userInfo->fullname; ?></td>
                        <td>
                          <a href="/Account/doSearch?username=<?php echo $userInfo->username; ?>&searchOption=username" target="_blank"><span class="label label-info"><?php echo $userInfo->username; ?></span></a>
                        </td>
                        <td><?php echo $userInfo->mobile; ?></td>
                        <td><?php echo sim_network_identification($userInfo->mobile)?></td>
                        <td><?php echo date_long($userInfo->created_at)?></td>
                        <td><?php echo $userInfo->email; ?></td>
                        <td><?php echo $data->cop->address ?? copAddress( $userInfo->id )?></td>
                        <td> 
                          <a class="btn btn-info btn-sm" 
                              href="/UserIdVerification/staff_preview_id/<?php echo seal($userInfo->id); ?>" 
                               target="_blank" >Preview ID</a>
                        </td>

                        <td><?php  
                              echo  " <b>".$data->quantity."</b><br>"; ?>
                        </td>
                        <td>
                         <?php
                          Form::open([
                            'method' => 'post',
                            'action' => '/TocProductLoan/addToDelivery'
                          ]);
                          Form::hidden('user_id' , $userInfo->id);
                          Form::hidden('loan_id', $data->id);

                          Form::text('shipping_track_number');
                          Form::submit('' , 'Product Sent' , [
                            'class' => 'btn btn-primary btn-sm'
                          ]);
                          Form::close();
                        ?>
                      </td>
                  </tr>

                <?php $counter++;?>
                <?php endforeach;?>
        </tbody>
    </table>
</div>


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
<?php endbuild()?>

<?php build('header')?>
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
<?php endbuild()?>

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
      });

    });
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>


userid
address