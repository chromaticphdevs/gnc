<?php build('content')?>
<?php Flash::show()?>
<div class="row">
  <section class="col-md-4">
   <div class="well">
     <h3>Branch Deposit</h3>
     <form class="" action="" method="post">
        <div class="form-group">
          <label for="">Beneficiary</label>
          <select name="branchid" id="" class="form-control">
            <?php foreach($branches as $key => $row) :?>
              <option value="<?php echo $row->id?>">
                <?php echo $row->name?>
              </option>
            <?php endforeach?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Amount</label>
          <input type="number" class="form-control" name="amount" value="">
        </div>

        <div class="form-group">
          <label for="">Description</label>
          <input type="text" class="form-control" name="description" value="">
        </div>
        <div class="form-group">
          <input type="submit" name="" value="Deposit" class="btn btn-primary btn-sm">
        </div>
      </form>
   </div>
  </section>

  <section class="col-md-8">
    <div class="well">
     
      <div class="table-responsive">
        <h1>Withdraws</h1>
        <table class="table">
        <thead>
          <th>#</th>
          <th>Depositor</th>
          <th>Beneficiary</th>
          <th>Amount</th>
          <th>Description</th>
          <th>Status</th>
          <th>Date and Time</th>
        </thead>

        <tbody>
          <?php foreach($withdraw as $key => $row) :?>
            <tr>
              <td><?php echo ++$key?></td>
              <td><?php echo $row->depositor_name?></td>
              <td><?php echo $row->beneficiary_name?></td>
              <td><?php echo $row->amount?></td>
              <td><?php echo $row->description?></td>
              <td><?php echo $row->status?></td>
              <td><?php echo $row->created_at?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <br>
       <h1>Deposits</h1>
        <table class="table">
        <thead>
          <th>#</th>
          <th>Depositor</th>
          <th>Beneficiary</th>
          <th>Amount</th>
          <th>Description</th>
          <th>Status</th>
          <th>Date and Time</th>
        </thead>

        <tbody>
          <?php foreach($deposits as $key => $row) :?>
            <tr>
              <td><?php echo ++$key?></td>
              <td><?php echo $row->depositor_name?></td>
              <td><?php echo $row->beneficiary_name?></td>
              <td><?php echo $row->amount?></td>
              <td><?php echo $row->description?></td>
              <td><?php echo $row->status?></td>
              <td><?php echo $row->created_at?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      </div>
    </div>
  </section>
<?php endbuild()?>

<?php occupy('templates/layout')?>
