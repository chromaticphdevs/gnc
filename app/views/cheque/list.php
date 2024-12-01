<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style type="text/css">
    table img{
        width: 75px;
    }
</style>
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
            
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 

            <!--OPTIONAL -->
            <div>
                <h3>Payout List</h3>

                <?php if(!empty($chequeList)) :?>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Img</th>
                            <th>Amount</th>
                            <th>Preview</th>
                        </thead>

                        <tbody>
                            <?php foreach($chequeList as $key => $payout): ?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $payout->date_to .' - '. $payout->date_from?></td>
                                    <td><?php echo $payout->status?></td>
                                    <td>
                                        <img src="<?php echo URL.DS.'public/assets/'.$payout->cheque_img?>" class="sm-prod">
                                    </td>
                                    <td><?php echo $payout->amount?></td>
                                    <td>
                                        <a href="/payouts/view_my_payout/<?php echo $payout->id?>">View</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif;?>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>