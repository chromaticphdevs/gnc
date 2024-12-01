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
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
          </div>
        </div>
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">
            <div class="col-md-5">
                <div class="x_panel">
                    <h3>Update Profile</h3>
                    <?php Flash::show()?>
                    <div class="x_content">

                        <div style="width: 300px;">
                            <img src="<?php echo GET_PATH_UPLOAD.DS.'profile'.DS.$account->selfie?>" 
                            style="width:100%;" alt="Click to Edit Profile" title="Edit Profile">
                        </div>

                        <hr>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="userid" 
                            value="<?php echo $account->id?>">
                            
                            <div class="form-group">
                                <label for="#">Profile</label>
                                <input type="file" class="form-control" name="profile">
                            </div>

                            <input type="submit" value="Save Information"
                            class="btn btn-primary btn-sm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
