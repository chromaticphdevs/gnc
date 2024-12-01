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
          <h3>Balance: P <b><?php echo $balance?></b></h3>
            <?php Flash::show()?>

            <div class="row">
               <section class="col-md-5">
                <div class="x_panel">
                  <div class="x_content">
                    <h3><b>Unused Codes</b></h3>
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>code</th>
                        <th>amount</th>
                        <th>status</th>
                      </thead>

                      <tbody >
                        <?php foreach($codes_unused as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><h4><b><?php echo $row->code?></b></h4></td>
                            <td><?php echo $row->amount?></td>
                            <td> <span class="label label-success"><?php echo $row->status; ?></span> </td>
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
                    <h3><b>Used Codes</b></h3>
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>code</th>
                        <th>amount</th>
                        <th>Date & Time</th>
                        <th>status</th>
                      </thead>

                      <tbody>
                        <?php foreach($codes_used as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><h4><b><?php echo $row->code?></b></h4></td>
                            <td><?php echo $row->amount?></td>
                            <td>
                              <?php 
                                    $date=date_create($row->date);
                                    echo date_format($date,"M d, Y");
                                    $time=date_create($row->time);
                                    echo date_format($time," h:i A");
                              ?>  
                            </td>
                            <td> <span class="label label-info"><?php echo $row->status; ?></span> </td>
                           
                           
                            
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