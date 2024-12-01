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

          <h3><?php echo $title?></h3>
          <br>
            <?php Flash::show()?>

            <div class="row">
               <section class="col-md-5">
                <div class="x_panel">
                  <div class="x_content">
                    <h3><b>Unclaim</b></h3>
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Status</th>
                      </thead>

                      <tbody >
                        <?php foreach($list as $key => $row) :?>
                          <tr>
                            <?php if($row->status == "pending"): ?>

                              <td><?php echo ++$key?></td>
                              <td><b><?php echo $row->customer?></b></td>
                               <td><?php echo $row->branch_name?></td>
                              <td><?php echo substr($row->code,0,5)."**-***"  ?></td>
                              <td><?php echo $row->amount?></td>
                              <td> <span class="label label-warning"><?php echo $row->status; ?></span> </td>

                            <?php endif; ?>
                          </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>

              <section class="col-md-5">
                <div class="x_panel">
                  <div class="x_content">
                    <h3><b>Unpaid</b></h3>
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Status</th>
                      </thead>

                      <tbody>
                        <?php foreach($list as $key => $row) :?>
                          <tr>

                           <?php if($row->status == "claimed"): ?>

                              <td><?php echo ++$key?></td>
                              <td><b><?php echo $row->customer?></b></td>
                              <td><?php echo $row->branch_name?></td>
                              <td><?php echo substr($row->code,0,5)."**-***"  ?></td>
                              <td><?php echo $row->amount?></td>
                          
                              <td> <span class="label label-info"><?php echo $row->status; ?></span> </td>

                          <?php endif; ?>   

                          </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>