<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 400px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 250px;
}

div.desc {
  padding: 5px;
  text-align: center;
}
</style>
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
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
         

        <?php Flash::show()?>
        <h3><b>Pera Padala</b></h3>
  

          <div class="row">
            <div style="overflow-x:auto;">


                    <div class="gallery">
                      
                      <img src="<?php echo URL.DS.'uploads/pera_padala/palawan.jpg'; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <!--<div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>

                      </div>-->
                    </div>

                    <div class="gallery">
                      
                      <img src="<?php echo URL.DS.'uploads/pera_padala/mlhuillier.jpg'; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <!--<div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>

                      </div>-->
                    </div>

                    <div class="gallery">
                      
                      <img src="<?php echo URL.DS.'uploads/pera_padala/cebuana.jpg'; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <!--<div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>

                      </div>-->
                    </div>

                    <div class="gallery">
                      
                      <img src="<?php echo URL.DS.'uploads/pera_padala/gcash.jpg'; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <!--<div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>

                      </div>-->
                    </div>

                     <div class="gallery">
                      
                      <img src="<?php echo URL.DS.'uploads/pera_padala/lbc.jpg'; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <!--<div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>

                      </div>-->
                    </div>

                     <div class="gallery">
                      
                      <img src="<?php echo URL.DS.'uploads/pera_padala/smart_padala.png'; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <!--<div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>

                      </div>-->
                    </div>
  
            </div>
          </div>


<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

