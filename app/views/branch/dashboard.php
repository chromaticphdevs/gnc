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
            <h3>Branch</h3>
            <div class="col-md-5">
              <?php $branchid = $_GET['branchid'] ?? '' ?>
              <select class="" name="" id = "branches">
                <?php $selected = $_GET['branchid'] ?? '' ?>
                <?php foreach ($branchList as $key => $row)  :?>
                  <?php $selected = $branchid == $row->id ? 'selected' : ''?>
                  <option value="<?php echo $row->id?>" <?php echo $selected?>><?php echo $row->branch_name?></option>
                <?php endforeach;?>
              </select>
            </div>
            <?php if(isset($branch)):?>
            <div class="branch-info">
              <ul>
                <li>Branch Name</li>
                <li>Current Vault:</li>
              </ul>
            </div>
            <?php endif;?>

            <?php if(isset($branchid) && !empty($branchid)):?>
            <section>
              <h1>Vault Transactions</h1>
              <?php $totalVaultAmount = 0?>
              <table class="table">
                <thead>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Description</th>
                  <th>Date and Time</th>
                </thead>
                <tbody>
                  <?php foreach($logs as $key => $row) :?>
                    <?php $totalVaultAmount += $row->amount;?>
                    <tr>
                      <td><?php echo ++$key?></td>
                      <td><?php echo $row->amount?></td>
                      <td><?php echo $row->description?></td>
                      <td><?php echo $row->created_at?></td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
              <h3>Total Vault Amount : <?php echo to_number($totalVaultAmount)?></h3>
            </section>
            <hr>
            <section>
              <h1>Vault Deposits</h1>
              <table class="table">
                <thead>
                  <th>#</th>
                  <th>Branch Name</th>
                  <th>Amount</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Date and Time</th>
                </thead>

                <tbody>
                  <?php foreach($deposits as $key => $row) :?>
                    <tr>
                      <td><?php echo ++$key?></td>
                      <td><?php echo $row->branch_name?></td>
                      <td><?php echo $row->amount?></td>
                      <td><?php echo $row->description?></td>
                      <td><?php echo $row->status?></td>
                      <td><?php echo $row->created_at?></td>
                      <td>
                        <?php if($row->status === 'on-queue') :?>
                          <form class="" action="/BranchVaultDeposit/do_action" method="post">
                            <input type="hidden" name="depositid" value="<?php echo $row->id?>">
                            <input type="hidden" name="branchid" value="<?php echo $row->branchid?>">
                            <input type="submit" name="confirm" value="Confirm" class="btn btn-primary btn-sm">
                            <input type="submit" name="decline" value="Decline" class="btn btn-danger btn-sm">
                          </form>
                        <?php else:?>
                          <h3><?php echo $row->status?></h3>
                        <?php endif;?>
                      </td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>

            </section>
            <?php endif;?>
        </div>
        <!-- page content -->

<script defer>
  $( document ).ready(function()
{
  $("#branches").change(function()
{
    let branchid = $(this).val();

    window.location = get_url(`Branch/branch_dashboard/?branchid=${branchid}`)
});
});
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
