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
        <div class="right_col" role="main" style="min-height: 524px;">  
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon green"><i class="fa fa-money"></i></div>
                            <div class="count">
                                <?php echo $starterTotal?>
                            </div>
                            <h3>STARTER</h3>  
                        </div>
                    </div>         
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon green"><i class="fa fa-money"></i></div>
                            <div class="count">
                                <?php echo $bronzeTotal?>
                            </div>
                            <h3>BRONZE</h3>  
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon green"><i class="fa fa-user"></i> </div>
                            <div class="count">
                                <?php echo $silverTotal?>
                            </div>
                            <h3>SILVER</h3>
                        </div>
                    </div> 

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon green"><i class="fa fa-money"></i></div>
                            <div class="count">
                                <?php echo $goldTotal?>
                            </div>
                            <h3>GOLD</h3>   
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <div class="count">
                                <?php echo $diamondTotal?>
                            </div>
                            <h3>DIAMOND</h3>
                        </div>
                    </div> 
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <div class="count">
                                <?php echo $platinumTotal?>
                            </div>
                            <h3>PLATINUM</h3>
                        </div>
                    </div>
                </div>
                <!-- //DASHBOWED / small widgets -->

        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>