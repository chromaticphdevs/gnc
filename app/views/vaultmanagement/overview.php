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
            <!-- profile quick info -->
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
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

        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
            <?php Flash::show()?>
            <h3><?php echo $title?></h3>

            <div class="row">
              <div class="col-md-5 mx-auto">
                <h3>Total Amount : <?php echo $vault['main']['total_amount']?></h3>
                <div class=""><strong>Main-Vault</strong></div>
              </div>
            </div>
            <hr>
            <div class="row">
              <section class="col-md-4">
                <h3>Brach Vault Withdraw</h3>

                <form class="" action="/Vault/withdraw" method="post">
                  <div class="form-group">
                    <label for="#">Select Branch</label>
                    <select class="form-control" name="branchid">
                      <?php foreach($branchList as $key => $row) :?>
                        <option value="<?php echo $row->id?>">
                          <?php echo $row->branch_name?>
                        </option>
                      <?php endforeach?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Amount</label>
                    <input type="text" class="form-control" name="amount" value="">
                  </div>

                  <div class="form-group">
                    <input type="submit" name="" value="Submit Withdraw" class="btn btn-primary btn-sm">
                  </div>
                </form>
              </section>


              <section class="col-md-4">
                <h3>Branch Deposit</h3>
                <form class="" action="/BranchVaultDeposit/make_deposit" method="post">
                  <div class="form-group">
                    <label for="#">Select Branch</label>
                    <select class="form-control" name="branchid">
                      <?php foreach($branchList as $key => $row) :?>
                        <option value="<?php echo $row->id?>">
                          <?php echo $row->branch_name?>
                        </option>
                      <?php endforeach?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Amount</label>
                    <input type="text" class="form-control" name="amount" value="">
                  </div>

                  <div class="form-group">
                    <label for="">Description</label>
                    <input type="text" class="form-control" name="description" value="">
                  </div>

                  <div class="form-group">
                    <input type="submit" name="" value="Deposit" class="btn btn-primary btn-sm">
                  </div>
                </form>
              </section>
            </div>

            <hr>
            <section>
              <h3>Branch Vaults</h3>
              <table class="table">
                <thead>
                  <th>#</th>
                  <th>Branch Name</th>
                  <th>Vault Amount</th>
                  <th>Deposit(On-Queue)</th>
                  <th>Logs</th>
                </thead>

                <tbody>
                  <?php foreach($vault['branches'] as $key => $row) :?>
                    <tr>
                      <td><?php echo ++$key?></td>
                      <td><?php echo $row->branch_name?></td>
                      <td><?php echo $row->vault_amount?></td>
                      <td><?php echo $row->deposit_amount?></td>
                      <td><a href="/branchVault/get_logs/?branchid=<?php echo $row->id?>" target="_blank">View Logs</a></td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </section>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
