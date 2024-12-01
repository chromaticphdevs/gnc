<?php build('content')?>
<?php Flash::show()?>
<h3><?php echo $title?></h3>

<div class="card">
  <div class="card-header">
    <h3>Total Amount : <?php echo to_number($cashTotal)?></h3>
  </div>

  <div class="card-body">
    <?php if(Session::check('USERSESSION')):?>
      <form action="">
        <select name="" id="branches">
          <option value="">-Select Branch</option>
          <option value="all">All</option>
          <?php foreach($branches as $key => $row) :?>
            <option value="<?php echo $row->id?>">
              <?php echo $row->name?>
            </option>
          <?php endforeach?>
        </select>
      </form>
    <?php endif?>
    <table class="table">
      <thead>
        <th>#</th>
        <th>Branch</th>
        <th>Amount</th>
        <th>Purchaser/Payer</th>
        <th>Description</th>
        <th>Notes</th>
        <th>Date and Time</th>
      </thead>

      <tbody>
        <?php $totalCash = 0?>
        <?php foreach($cashInventories as $key => $row) :?>
           <?php $totalCash += $row->amount?>
          <tr>
            <td><?php echo ++$key?></td>
            <td><?php echo $row->branch_name?></td>
            <td><?php echo $row->amount?></td>
            <td><?php echo $row->fullname?></td>
            <td><?php echo $row->description?></td>
            <td><?php echo $row->notes?></td>
            <td><?php echo $row->created_at?></td>
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
