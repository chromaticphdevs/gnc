<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
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
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">
          <?php Flash::show()?>
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                      <h3>Deposit Transactions</h3>
                      <table class="table">
                        <thead>
                          <th>#</th>
                          <th>Remitter</th>
                          <th>Benificiary</th>
                          <th>Amount</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Date And Time</th>
                          <th>Action</th>
                        </thead>

                        <tbody>
                          <?php foreach($deposits as $key => $row) :?>
                            <tr>
                              <td><?php echo ++$key?></td>
                              <td><?php echo $row->remitter?></td>
                              <td><?php echo $row->beneficiary?></td>
                              <td><?php echo $row->amount?></td>
                              <td><?php echo $row->description?></td>
                              <td><?php echo $row->status?></td>
                              <td><?php echo $row->created_at?></td>
                              <td>
                                <?php if($row->status == 'on-queue'):?>
                                <form action="/FNDeposit/do_action" method="post">
                                  <input type="hidden" value="<?php echo $row->id?>" name="depositid">
                                  <!--get cashier id-->
                                   <input type="hidden" value="<?php echo $row->cashier_id?>" name="cashier_id">

                                  <input type="submit" class="btn btn-primary btn-sm" 
                                  value="Confirm" name="confirm">

                                  <input type="submit" class="btn btn-primary btn-sm" 
                                  value="Decline" name="decline">
                                </form>
                                <?php else:?>

                                <p><?php echo $row->status?></p>

                                <?php endif;?>
                              </td>
                            </tr>
                          <?php endforeach?>
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>