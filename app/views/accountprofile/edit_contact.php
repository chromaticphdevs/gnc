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
                    <h3>Update Contact Information</h3>
                    <?php Flash::show()?>
                    <div class="x_content">
                        <p>No information are allowed to be edited</p>
                        <form action="" method="post">
                            <input type="hidden" name="userid" 
                            value="<?php echo $account->id?>">

                            <div class="form-group">
                                <label for="#">Email</label>
                                <input type="text" name="email" class="form-control" 
                                value="<?php echo $account->email ?? ''?>">
                            </div>

                            <div class="form-group">
                                <label for="#">Phone</label>
                                <input type="text" name="mobile" class="form-control" 
                                value="<?php echo $account->mobile ?? ''?>">
                            </div>

                            <div class="form-group">
                                <label for="#">Address</label>
                                <input type="text" name="address" class="form-control" 
                                value="<?php echo $account->address ?? ''?>">
                            </div>

                            <!-- <input type="submit" value="Save Information"
                            class="btn btn-primary btn-sm"> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
