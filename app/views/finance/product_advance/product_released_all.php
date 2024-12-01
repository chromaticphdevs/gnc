<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
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
<?php
    $user_type = Auth::user_position();
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }
?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>

 <?php $whirlpool="831a50be987979d6ee3658eb80f2d1ca8cd21023e90cbd6a98c6c8c0801d9b263d2da6a134a128f886d4cbd22bfbd455adce86b289876df4f7b9d6945c6bbbf4"; ?>

        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->

        <div class="right_col" role="main" style="min-height: 524px;">

            <center><h1><b><?php echo $title; ?></b></h1></center>
            <?php Flash::show()?>
  
            <form action="/FNProductBorrower/get_released_product_all" method="post">

                  <select name="days">
                    <option value="0|Today">Today</option>
                    <option value="7|1 Week">1 Week</option>
                    <option value="30|1 Month">1 Month</option>
                    <option value="90|3 Months">3 Months</option>
                    <option value="180|6 Months">6 Months</option>
                    <option value="360|12 Months">12 Months</option>
                  </select>

                  <input type="submit" class="btn btn-success btn-sm" value="Show">
            </form>
           <center><br><h4><b><?php echo $selected; ?></b></h4></center>

          <!--get total amount of  paid also  count the paid products-->
          <br><h3><b><div style="color:green;">( PAID )</div> Total: &#8369; <?php echo to_number($total_paid); ?></b></h3>
          <table class="table">
              <thead>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Level</th>
                  <th></th>
              </thead>

              <tbody>
                  <?php foreach($paid_amount_count as $key => $row) :?>
                      <tr>
                          <td><?php echo ++$key?></td>
                          <td><?php echo $row->amount?></td>
                          <td><?php
                                  if($row->amount == 1500){
                                      echo "Starter";
                                  }elseif ($row->amount == 16000) {
                                      echo "Silver";
                                  }elseif ($row->amount == 46500) {
                                      echo "Gold";
                                  }else{
                                      echo "";
                                  }

                              ?>        
                          </td>
                          <td><?php echo $row->count?></td>
                      </tr>
                  <?php endforeach?>
              </tbody>
          </table>

          <!--get total amount of not paid also  count the unpaid products-->
          <br><h3><b><div style="color:red;">( NOT PAID )</div> Total: &#8369; <?php echo to_number($total_not_paid); ?></b></h3>
          <table class="table">
              <thead>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Level</th>
                  <th></th>
              </thead>

              <tbody>
                  <?php foreach($unpaid_amount_count as $key => $row) :?>
                      <tr>
                          <td><?php echo ++$key?></td>
                          <td><?php echo $row->amount?></td>
                          <td><?php
                                  if($row->amount == 1500){
                                      echo "Starter";
                                  }elseif ($row->amount == 16000) {
                                      echo "Silver";
                                  }elseif ($row->amount == 46500) {
                                      echo "Gold";
                                  }else{
                                      echo "";
                                  }

                              ?>        
                          </td>
                          <td><?php echo $row->count?></td>
                      </tr>
                  <?php endforeach?>
              </tbody>
          </table>


         <br><h3><b>Grand Total: &#8369; <?php echo to_number($total_not_paid + $total_paid); ?></b></h3>
            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">

                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Loan Number</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </thead>

                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($result as $data) :?>

                                      <?php if($data->status=="Approved"):?>
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
                                                <td><?php echo $data->username; ?></td>
                                                <td><?php echo $data->mobile; ?></td>
                                                <td><?php echo $data->amount; ?></td>
                                                <td style="text-align: center;">
                                                      <?php if($data->status != "Paid" ):?>
                                                          <h4><b><span class="label label-info">Not Paid</span></b></h4>
                                                      <?php else:?>
                                                         <h4><b><span class="label label-success">Paid</span></b></h4>

                                                      <?php endif;?>
                                                </td>
                                          </tr>
                                          <?php $counter++;?>
                                        <?php endif;?>                   
                                    <?php endforeach;?>
                            </tbody>
                        </table>

                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Loan Number</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </thead>

                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($result as $data) :?>
                                        <?php if($data->status=="Paid"):?>
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
                                                  <td><?php echo $data->username; ?></td>
                                                  <td><?php echo $data->mobile; ?></td>
                                                  <td><?php echo $data->amount; ?></td>
                                                  <td style="text-align: center;">
                                                        <?php if($data->status != "Paid" ):?>
                                                            <h4><b><span class="label label-info">Not Paid</span></b></h4>
                                                        <?php else:?>
                                                           <h4><b><span class="label label-success">Paid</span></b></h4>

                                                        <?php endif;?>
                                                  </td>
                                            </tr>
                                           <?php $counter++;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

