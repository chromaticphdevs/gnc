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
            <h1>Referral List (Unactivated)</h1>

            <table class="table">
                <thead>
                    <th>Username</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Level</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach($referral['unactivatedList'] as $key => $user) :?>
                        <tr>
                            <td><?php echo $user->username?></td>
                            <td><?php echo $user->fullname?></td>
                            <td><?php echo $user->email?></td>
                            <td><?php echo $user->mobile?></td>
                            <td><?php echo $user->status?></td>
                            <td>
                                <form method="post" action="/geneology/add_user">
                                    <input type="hidden" name="position" value="<?php echo $position?>">
                                    <input type="hidden" name="upline" value="<?php echo $upline?>">
                                    <input type="hidden" name="userid" value="<?php echo $user->id?>">
                                    <input type="submit" name="" value="Add to Geneology">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>