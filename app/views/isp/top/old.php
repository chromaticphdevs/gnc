
<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/"><img src="/images/admin-isocialplanet.png"></a>
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
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"><div class=" flash_message" id="message" style="display: none;"></div>   <script>
                    setTimeout(function() {
                        $('#message').fadeOut('slow');
                    }, 3000);
                </script>
                </div>                  
            </div>
            
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 

            <!--OPTIONAL -->


                <!-- 
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        </div>
                    </div>
                 -->

            <!-- // OPTIONAL -->
        
        <div class="container">
            <?php Flash::show(); ?>
        	<h1>ISP TOP 100</h1>
            
            <table class="table">
                <thead>
                    <th>Userid</th>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Commissions</th>
                    <th>Total</th>
                </thead>

                <tbody>
                    <?php $counter = 0;?>
                    <?php foreach($isp_list as $list) :?>
                        <?php if($counter < 100): ?>
                        <?php $counter++;?>
                        <tr>
                            <td><?php echo $list->id?></td>
                            <td><?php echo $list->username?></td>
                            <td><?php echo $list->fullname?></td>
                            <td>
                                <?php foreach($list->transaction_list as $trans) : ?>
                                    <div>
                                        <strong>Name : <?php echo $trans['transaction']?></strong>
                                    </div>
                                    <div>
                                        <strong>Instance : <?php echo $trans['instance']?></strong> <br>
                                        <strong>Amount : <?php echo to_number($trans['amount'])?></strong>
                                    </div>
                                    <hr>
                                <?php endforeach;?>
                            </td>
                            <td><?php echo to_number($list->total_amount)?></td>
                        </tr>
                        <?php else:?>
                        <?php break;?>
                    <?php endif;?>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>