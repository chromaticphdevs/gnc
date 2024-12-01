<?php build('content')?>
<?php Flash::show()?>
<h3>Cash Released for Expense Request</h3>

<div class="card">

  <div class="card-body">
 
    <table class="table">
      <thead>
        <th>#</th>
        <th>Requester</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Date and Time</th>
      </thead>

      <tbody>
        <?php $totalCash = 0?>
        <?php foreach($List as $key => $row) :?>
           <?php $totalCash += $row->amount?>
          <tr>
            <td><?php echo ++$key?></td>
            <td><?php echo $row->fullname?></td>
            <td><?php echo $row->amount?></td>
            <td><?php echo $row->description?></td>
            <td> <?php
                  $date=date_create($row->created_at);
                  echo date_format($date,"M d, Y");
                  $time=date_create($row->created_at);
                  echo date_format($time," h:i A");
                ?>
            </td>
          </tr>
        <?php endforeach?>
      </tbody>
    </table>
  </div>
</div>
<?php endbuild()?>


<?php build('scripts')?>
<script defer>
  $( document ).ready(function(){

      $("#branches").change(function(e) {

        let branchid = $(this).val();

        window.location = get_url(`FNCashInventory/get_list/?branchid=${branchid}`);
      });
  });
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
