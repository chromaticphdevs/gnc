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
              <h3><?php echo $title; ?></h3>
                <?php Flash::show()?>
                <?php Flash::show('purchase_message')?>
                <table class="table" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Loan Number</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>phone</th>
                        <th>FB Link</th>
                        <th>Product Type</th>
                        <th>Amount</th>
                        <th>Delivery Fee</th>
                        <th>Payment</th>
                        <th>Balance</th>
                        <th></th>
                    </thead>

                     <tbody>
                           <?php $counter = 1;?>
                           <?php foreach($result as $data) :?>
                              <?php if(floatval($data->payment) < 1500) continue ?>
                              <tr>
                                    <td><?php echo $counter ?></td>
                                    <td>
                                      <?php
                                          $date=date_create($data->date_time);
                                          echo date_format($date,"M d, Y");
                                          $time=date_create($data->date_time);
                                          echo date_format($time," h:i A");
                                        ?>
                                    </td>
                                    <td>#<?php echo $data->code; ?></td>
                                    <td><?php echo $data->fullname; ?></td>
                                    <td>
                                      <a href="/Account/doSearch?username=<?php echo $data->username; ?>&searchOption=username" target="_blank"><span class="label label-info"><?php echo $data->username; ?></span></a>
                                    </td>
                                    <td><?php echo $data->mobile; ?></td>
                                    <td>
                                      <?php if($data->valid_link != "no_link"): ?>
                                            <a class="btn btn-primary btn-sm" href="<?php echo $data->valid_link; ?>" target="_blank">Preview</a>
                                      <?php else:?>
                                            <span class="label label-danger">No Valid FB Link</span>
                                      <?php endif;?>
                                    </td>
                                    <td><?php echo $data->product_name; ?></td>
                                    <td><?php echo $data->amount ?? 0; ?></td>
                                    <td><?php echo $data->delivery_fee ?? 0; ?></td>
                                    <td><?php echo $data->payment; ?></td>
                                    <td><?php echo ($data->amount + $data->delivery_fee ?? 0) - $data->payment; ?></td>
                                    <td style="text-align: center;">

                                          <?php if($data->status != "Paid" ):?>
                                              <?php if($user_type =="cashier" OR $user_type =="branch-manager" ):?>
                                                <a class="btn btn-success btn-sm" href="/ProductLoan/show/<?php echo seal($data->id)?>"> Make Payment</a>
                                              <?php endif;?>
                                          <?php else:?>
                                             <h4><b><span class="label label-success">PAID</span></b></h4>
                                          <?php endif;?>
                                    </td>
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
