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

            <?php if(!empty($lists)): ?>
                <table class="table">
                    <thead>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>View</th>
                    </thead>
                    <tbody>
                        <?php foreach($lists as $payout) : ?>
                            <tr>
                                <td><?php echo $payout->date_from?></td>
                                <td><?php echo $payout->date_to?></td>
                                <td><?php echo $payout->pc_amount?></td>
                                <td><?php echo $payout->pc_status?></td>
                                <td>
                                    <a href="/userspayout/preview/<?php echo $payout->pc_id?>">Preview</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>