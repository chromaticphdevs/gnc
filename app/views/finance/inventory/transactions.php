<?php build('content')?>

<?php $totalStocks = 0?>
<?php foreach($items as $key => $row) :?>
  <?php $totalStocks += $row->quantity?>           
<?php endforeach;?>
<h3>Stocks : <?php echo $totalStocks ?></h3>


<div>
    <?php
        Form::open([
            'method' => 'get'
        ]);
        
        Form::select('filter_quantity' , $quantities , ''  , [
            'class' => 'form-control',
            'id'    => 'quantity'
        ]);

        Form::submit('apply filter');
        Form::close();
    ?>
</div>
<h3>Stock Logs</h3>
<table class="table">
    <thead>
        <th>#</th>
        <th>Branch</th>
        <th>Quantity</th>
        <th>User Fullname</th>
        <th>Date & Time</th>
        <th>Description</th>
    </thead>

    <tbody>
        
        <?php foreach($items as $key => $row) :?>
            <?php $totalStocks += $row->quantity?>
            <tr>
                <td><?php echo ++$key?></td>
                <td><?php echo $row->branch_name?></td>
                <td><?php echo $row->quantity?></td>
                <td><?php echo $row->fullname?></td>
                <td>
                  <?php
                      $date=date_create($row->created_at);
                      echo date_format($date,"M d, Y");
                      $time=date_create($row->created_at);
                      echo date_format($time," h:i A");
                    ?>
                </td>
                <td><?php echo $row->description?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php endbuild()?>
<?php occupy('templates/layout')?>