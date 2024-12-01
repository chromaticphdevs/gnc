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
            <h3>Edit Profile</h3>
            <div class="col-md-5">
              <?php Flash::show()?>
              <form method="post" action="/users/update_personal">
                <input type="hidden" name="userid" value="<?php echo $userInfo->id?>">
                <fieldset>
                  <legend>Personal</legend>
                   <div class="form-group">
                      <label>Firstname</label>
                      <input type="text" name="firstname" class="form-control" 
                      value="<?php echo $userInfo->firstname?>">
                    </div>

                    <div class="form-group">
                      <label>Lastname</label>
                      <input type="text" name="lastname" class="form-control" 
                      value="<?php echo $userInfo->lastname?>">
                    </div>

                    <input type="submit" name="" value="Update" class="btn btn-success">
                </fieldset>
              </form>
              <hr>
              <form method="post" action="/users/updateInfo" enctype="multipart/form-data">
                <fieldset>
                  <legend>Contact</legend>
                    <input type="hidden" name="userid" value="<?php echo $userInfo->id?>">
                    <input type="hidden" name="prodid">
                    <div class="form-group">
                      <label>Mobile</label>
                      <input type="text" name="mobile" class="form-control" 
                      value="<?php echo $userInfo->mobile?>">
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="address" class="form-control" 
                      value="<?php echo $userInfo->address?>">
                    </div>
                    <div>
                      <input type="submit" name="" value="Update" class="btn btn-success">
                    </div>
                </fieldset>
              </form>
              <hr>
              <form method="post" action="/users/update_password">
                <input type="hidden" name="userid" value="<?php echo $userInfo->id?>">
                <fieldset>
                  <legend>Change Password</legend>
                   <div class="form-group">
                      <label>Password</label>
                      <input type="text" name="password" class="form-control" 
                      value="">
                    </div>
                    <input type="submit" name="" value="Update" class="btn btn-success">
                </fieldset>
              </form>
            </div>  
            
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>