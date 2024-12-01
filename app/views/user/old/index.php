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
<div class="profile clearfix">
    <div class="profile_pic">
         
        <a href="/admin/users/profile"><img src="/images/user.png" alt="..." class="img-circle profile_img"></a>
            </div>
    <div class="profile_info">
        <span>Welcome</span>
        <h2>testcoder testcoder</h2>
        <p>&nbsp;</p>
    </div>
</div>
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


            <!-- DASHBOWED / small widgets -->
            <div class="row">

                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                    <?php $com = $commissions ;?>

                    <div class="row">         
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"><i class="fa fa-money"></i></div>
                                <div class="count"><?php echo $com['sponsor']->total?></div>
                                <h3>Earnings</h3>
                                 <p>
                                    <span>Overall Commissions</span>
                                </p>    
                            </div>
                        </div>
                        
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                                <div class="count">
                                    <?php if(!empty($com['binary_pv'])) :?>
                                        <?php echo $com['binary_pv'];?>
                                        <?php else:?>
                                            0.0
                                    <?php endif;?>
                                </div>
                                <h3>E-Wallet</h3>
                                <p><span>Released Payouts: <strong class="green"> 0.00</strong> | <span> Pending Payouts: <strong class="green"> 0.00</strong></span></span></p>
                            </div>
                        </div> 
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"><i class="fa fa-money"></i></div>
                                <div class="count">0.00</div>
                                <h3>SMP Earnings</h3>
                                <p><span>Watch: <strong class="green"> 0.00</strong> | <span> Share: <strong class="green"> 0.00</strong></span></span></p>
                            </div>
                        </div>   
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"> </div>
                                <div class="count">0</div>
                                <h3>ISP</h3>
                                <p><span>Total Direct Referral 1000</span></p>
                            </div>
                        </div>                    
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"> </div>
                                <div class="count">0</div>
                                <h3>Starter</h3>
                                <p><span>Total Direct Referral 2980</span></p>
                            </div>
                        </div>                        
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"> </div>
                                <div class="count">0</div>
                                <h3>Elite</h3>
                                <p><span>Total Direct Referral 15000</span></p>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"> </div>
                                <div class="count">0</div>
                                <h3>UnPromoted</h3>
                                <p><span>Total Managers UnPromoted</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"><i class="fa fa-desktop"></i></div>
                                <div class="count">100</div>
                                <h3>SMP</h3>
                                 <p>
                                    <span>Social Media Points</span>
                                </p>    
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon green"><i class="fa fa-users"></i></div>
                                <div class="count">0</div>
                                <h3>Manager Level</h3>
                                 <p>
                                    <span>Number of Promoted Manager</span>
                                </p>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //DASHBOWED / small widgets -->

        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>