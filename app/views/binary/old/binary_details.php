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
        <h2><?php get_user_username()?></h2>
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
            <?php $downlines = $data['downlines'] ; ?>

            <div>
                <h3>As of now You have : <?php echo $totalDownlines?> Downlines</h3>
            </div>
            <table class="table">
                <thead>
                    <th>User Id</th>
                </thead>

                <tbody>
                    <?php foreach($downlines as $downline) :?>
                        <tr>
                            <td><?php echo $downline?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>