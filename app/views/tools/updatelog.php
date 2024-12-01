<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">

            <div class="col-md-5">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>Logger</h3>
                        <a href="/SystemUpdateController" class="btn btn-primary btn-sm"> UPDATES  </a>
                        <?php Flash::show()?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="#">Update By</label>
                                <select name="developer" id="" class="form-control" require>
                                    <option value="">Developer</option>
                                    <option value="Patick">Patick</option>
                                    <option value="Mark">Mark</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="#">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $_POST['title'] ?? ''?>">
                            </div>

                            <div class="form-group">
                                <label for="#">Description</label>
                                <textarea name="description" id="" class="form-control" rows="3"><?php echo $_POST['description'] ?? ''?></textarea>
                            </div>

                            <input type="submit" class="btn btn-primary btn-sm" value="Submit Update">
                        </form>  
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->


 <script type="text/javascript" defer>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
