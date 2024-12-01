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
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>33 8
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
            
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 

            <!--OPTIONAL -->

            <div>
                <h3>Payout Details</h3>
                <div>
                    <ul>
                        <li>From : <?php echo $payout->date_from?></li>
                        <li>To : <?php echo $payout->date_to?></li>
                        <li>Amount : <?php echo $payout->pc_amount?></li>
                        <li>Status : <?php echo $payout->pc_status?></li>
                    </ul>
                </div>
                
                <h3>Uni-levels</h3>
                <table class="table">
                    <thead>
                        <th>Order</th>
                        <th>Purchaser</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        <?php foreach($sponsor['unilvl'] as $unilvl) : ?>
                            <tr>
                                <td>
                                    <a href="/orders/view_order/<?php echo $unilvl->order_id?>"><?php echo $unilvl->trackno?></a>
                                </td>
                                <td><?php echo $unilvl->username?></td>
                                <td><?php echo $unilvl->amount?></td>
                                <td><?php echo $unilvl->dt?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>