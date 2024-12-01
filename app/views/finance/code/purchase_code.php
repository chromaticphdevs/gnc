<?php build('content') ?>
<h3>Code Purchase</h3>
<?php Flash::show()?>
<?php Flash::show('code-release-error')?>
<div class="row">
  <div class="col-md-3">
    <div class="well">
      <h3>Get Code</h3>
        <form action="" method="post">
          <input type="hidden" name="branchid" value="<?php echo $branchid?>">
          <div class="form-group">
            <label for="#">Select Level</label>
            <select name="level" id="" class="form-control">
              <?php foreach($activationLevels as $row) :?>
                <option value="<?php echo $row?>">
                  <?php echo $row?>
                </option>
              <?php endforeach;?>
            </select>
          </div>

          <div class="form-group">
            <br>
            <label for="#">Quantity</label>
            <input type="number" class="form-control" autocomplete="off" name="quantity" value = "1" required><br>
            <input type="submit" class="btn btn-primary btn-sm" value="Search Code">
          </div>
        </form>
    </div>
  </div>

  <div class="col-md-3"></div>


  <div class="col-md-6">
    <div class="well">
      <h3>Code Storage</h3>
        <ul>
          <li>Starter:&nbsp;<b style="color:green"><?php echo $inventory_summary['starter']?></b></li>
          <li>Bronze:&nbsp;<b style="color:green"><?php echo $inventory_summary['bronze']?></b></li>
          <li>Silver:&nbsp;<b style="color:green"><?php echo $inventory_summary['silver']?></b></li>
          <li>Gold:&nbsp;<b style="color:green"><?php echo $inventory_summary['gold']?></b></li>
          <li>Platinum:&nbsp;<b style="color:green"><?php echo $inventory_summary['platinum']?></b></li>
          <li>Diamond:&nbsp;<b style="color:green"><?php echo $inventory_summary['diamond']?></b></li>
        </ul>
    </div>
  </div>
</div>

<div class="col-md-12">
  <div class="well">
    <h3>Logs</h3>
      <table class="table">
        <thead>
          <th>#</th>
          <th>Level</th>
          <th>Box EQ</th>
          <th>Account</th>
          <th>Status</th>
          <th>Reference</th>
          <th>Action</th>
        </thead>

        <tbody>
          <?php foreach($purchases as $key => $row) :?>
            <tr>
              <td><?php echo ++$key?></td>
              <td><?php echo $row->level?></td>
              <td><?php echo $row->box_eq?></td>
              <td><?php echo $row->fullname?></td>
              <td><?php echo $row->status?></td>
              <td><?php echo $row->reference?></td>
              <td><a href="/FNCodePurchase/preview/<?php echo seal($row->id)?>" target="_blank">Preview</a></td>
            </tr>
          <?php endforeach?>
        </tbody>
      </table>
  </div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>