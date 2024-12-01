<?php build('content')?>
<?php Flash::show()?>
<h3>Processed Request</h3>

<div class="card">

  <div class="card-body">
 
    <table class="table">
      <thead>
        <th>#</th>
        <th>Requester</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Date and Time</th>
        <th>Status</th>
        <th>Approved By</th>
        <th>Branch</th>
      </thead>

      <tbody>
        <?php $totalCash = 0?>
        <?php foreach($List as $key => $row) :?>
           <?php $totalCash += $row->amount?>
          <tr>
            <td><?php echo ++$key?></td>
            <td><?php echo $row->fullname?></td>
            <td><?php echo $row->amount?></td>
            <td><?php echo $row->note?></td>
            <td> <?php
                  $date=date_create($row->created_at);
                  echo date_format($date,"M d, Y");
                  $time=date_create($row->created_at);
                  echo date_format($time," h:i A");
                ?>
            </td>
            <td><?php echo $row->status?></td>
            <td><?php echo $row->processed_by_name?></td>
            <td><?php echo $row->branch_name?></td>

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
