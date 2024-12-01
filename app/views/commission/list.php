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

              <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Commission Type
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="/commissions/get_list/?type=binary">Binary</a></li>
                            <li><a href="/commissions/get_list/?type=drc">DRC</a></li>
                            <li><a href="/commissions/get_list/?type=unilevel">Unilevel</a></li>
                            <li><a href="/commissions/get_list/?type=mentor">Mentor</a></li>
                            <li><a href="/commissions/getAll">All</a></li>
                        </ul>
                   </div>

            <section class="x_panel">
                <section class="x_content">
                    <h3>Commissions : <?php echo $type?></h3>
                    <table class="table">
                        <thead>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Company</th>
                        </thead>
                        <tbody>
                            <?php $total_amount = 0 ;?>
                            <?php foreach($commissionList as $com) : ?>
                                <?php $total_amount += $com->amount?>
                                <tr>
                                    <td><?php echo $com->date?></td>
                                    <td><?php echo $com->username?></td>
                                    <td><?php echo to_number($com->amount)?></td>
                                    <td><?php echo strtoupper($com->type) ?></td>
                                    <td><?php echo strtoupper($com->origin) ?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                    <div class="col-md-3">
                        <h3>Total Amount : </h3> 
                        <div style="background: green;color:#fff; padding: 15px;"><?php echo number_format($total_amount,2);?></div>
                    </div>
                </section>
            </section>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>