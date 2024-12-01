<?php build('content')?>
<center><h1><b>Product Release Cash Collected</b></h1></center>

  
  <form action="/FNCashier/get_cash_inventory_limit_by_days" method="post">

        <select name="days">
          <option value="0|Today">Today</option>
          <option value="7|1 Week">1 Week</option>
          <option value="30|1 Month">1 Month</option>
          <option value="90|3 Months">3 Months</option>
          <option value="180|6 Months">6 Months</option>
        </select>

        <input type="submit" class="btn btn-success btn-sm" value="Show">
  </form>

  <center><br><h4><b><?php echo $selected; ?></b></h4></center>
    <div style="overflow-x:auto;">
      <table class="table">
          <thead>
              <th>#</th>
              <th>Full Name</th>
              <th>Branch</th>
              <th>Type</th>
              <th>Total Cash</th>

          </thead>

           <tbody>
                 <?php $counter = 1;?>
                 <?php foreach($result as $data) :?>
                    <tr>
                          <td><?php echo $counter ?></td>
                          <td><b><?php echo $data->name; ?></b></td>
                          <td><?php echo $data->branch_name; ?></td>
                          <td><?php echo $data->type; ?></td>
                          <td><h4><b>&#8369; <?php echo to_number($data->total); ?></b></h4></td>
                    </tr>
                  <?php $counter++;?>
                  <?php endforeach;?>
          </tbody>
      </table>
  </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>
