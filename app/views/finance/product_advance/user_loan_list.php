<?php build('content')?>
<div style="overflow-x:auto;">
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
            <th>Number of box</th>
            <th>Status</th>
        </thead>

         <tbody>
               <?php $counter = 1;?>
               <?php foreach($result as $data) :?>
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
                        <td><?php echo $data->quantity; ?></td>
                        <td style="text-align: center;">
                              <?php if($data->status != "Paid" ):?>
                                 <h4><b><span class="label label-info">NOT PAID</span></b></h4>
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
<?php endbuild()?>

<?php occupy('templates/layout')?>
