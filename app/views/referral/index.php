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
<div class="profile clearfix">
    <div class="profile_pic">
         
        <a href="/admin/users/profile"><img src="/images/user.png" alt="..." class="img-circle profile_img"></a>
            </div>
    <div class="profile_info">
        <span>Welcome</span>
        <h2><?php echo Session::get('USERSESSION')['firstname'];?></h2>
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
        <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 
            <h3>Referral Link</h3>
            <div class="x_panel">                
                <div class="x_content">  
                    <h2>MY REFERRAL LINKS POSITION</h2>
                    <div class="clearfix"></div>
                    <small>Send Referral Link below to set sponsor, upline and position.</small>
                    <p>&nbsp;</p>
                    <div class="x_panel well">
                        <h3 class="green">
                        <span id="r1">
                            <?php echo $referral_links['left'];?>
                        </span>     
                            &nbsp;&nbsp;&nbsp; 
                            <button onclick="copyToClipboard('#r1')" class="btn btn-success btn-sm">Click to Copy URL</button>
                            <script>
                                function copyToClipboard(element) {
                                    var $temp = $("<input>");
                                    $("body").append($temp);
                                    $temp.val($(element).text()).select();
                                    document.execCommand("copy");
                                    $temp.remove();
                                }
                            </script>
                        </h3>
                    </div>
                    <div class="x_panel well">
                        <h3>Best Position : <?php echo $bestposition?></h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>