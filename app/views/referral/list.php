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
            <h3>Referral list</h3>
            <div class="x_panel">
                <div class="x_content">
                    <h3>For Activation Accounts</h3>
                    <table class="table">
                        <thead>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Level</th>
                        </thead>

                        <tbody>
                            <?php foreach($forActivationList as $key => $user) :?>
                                <tr>
                                    <td><?php echo $user->username?></td>
                                    <td><?php echo $user->fullname?></td>
                                    <td><?php echo $user->email?></td>
                                    <td><?php echo $user->mobile?></td>
                                    <td><?php echo $user->status?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

                <div class="x_content">
                    <h3>Activated Accounts</h3>
                    <table class="table">
                        <thead>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Upline</th>
                            <th>Position</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Level</th>
                        </thead>

                        <tbody>
                            <?php foreach($activatedList as $key => $user) :?>
                                <tr>
                                    <td><?php echo $user->username?></td>
                                    <td><?php echo $user->fullname?></td>
                                    <td><?php echo $user->upline. ' - '.$user->uplinename?></td>
                                    <td><?php echo $user->L_R?></td>
                                    <td><?php echo $user->email?></td>
                                    <td><?php echo $user->mobile?></td>
                                    <td><?php echo $user->status?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>


                 <div class="x_content">
                    <h3>Pre Activated Accounts</h3>
                    <p>Accounts that purchased nothing , contact your reffered user to activated and setup their account</p>
                    <table class="table">
                        <thead>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Level</th>
                        </thead>

                        <tbody>
                            <?php foreach($preActivatedList as $key => $user) :?>
                                <tr>
                                    <td><?php echo $user->username?></td>
                                    <td><?php echo $user->fullname?></td>
                                    <td><?php echo $user->email?></td>
                                    <td><?php echo $user->mobile?></td>
                                    <td><?php echo $user->status?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>           
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>