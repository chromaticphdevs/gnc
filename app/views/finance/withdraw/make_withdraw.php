<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
       <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div> 
        <div class="right_col" role="main" style="min-height: 524px;">
          <?php Flash::show()?>

            <div class="row">
              <section class="col-md-6">
                <h3>Branch Withdraw</h3>

              <div class="x_panel">
                <div class="x_content"> 
                <form class="" action="" method="post">
                  <div class="form-group">
                    <label for="">Select Branch</label>
                    <select name="cashier_id" id="" class="form-control">
                      <?php foreach($cashier_wallet as $key => $row) :?>
                        <option value="<?php echo $row->id?>|<?php echo $row->branchid?>">
                          <?php echo $row->name?> | <?php echo $row->amount?>
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
                    <input type="submit" name="" value="Withdraw" class="btn btn-primary btn-sm">
                  </div>
                </form>
               </div>
              </div>
                  <div class="x_panel">
                        <div class="x_content">
                            <h3>Cashier Wallet Info</h3>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Total Cash</th>
                                </thead>

                                <tbody>
                                    <?php foreach($cashier_wallet as $key => $row) :?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->name?></td>
                                            <td><?php echo $row->branch_name?></td>
                                            <td>P &nbsp;<?php echo $row->amount?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

              </section>
              <br> <br>
              <section class="col-md-6">

                           <label for="#">Select Branch</label>
                              <select name="branchid" id="branchid"class="form-control" onchange="get_logs_by_branch()" required>
                                  <option value="all_logs" >All Logs</option>
                                  <?php foreach($branches as $key => $row) :?>
                                      <option value="<?php echo $row->id?>">
                                          <?php echo $row->name?>
                                      </option>
                                  <?php endforeach;?>
                              </select>


                  <div id="logs_by_branch">
                      <div class="x_panel">
                          <div class="x_content">
                              <h3>Cash Logs</h3>
                              <table class="table">
                                  <thead>
                                      <th>#</th>
                                      <th>Branch</th>
                                      <th>Amount</th>
                                      <th>Description</th>
                                      <th>Date & Time</th>
                                  </thead>

                                  <tbody>
                                      <?php foreach($branch_logs as $key => $row) :?>
                                          <tr>
                                              <td><?php echo ++$key?></td>
                                              <td><?php echo $row->branch_name?></td>
                                              <td><?php echo $row->amount?></td>
                                              <td><?php echo $row->description?></td>
                                              <td><?php   

                                              $date=date_create($row->created_at);
                                              echo date_format($date,"M d, Y");

                                              $time=date_create($row->created_at);
                                              echo date_format($time," h:i A");

                                              ?></td>
                                              
                                          </tr>
                                      <?php endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                   </div>
              </section>
              
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>