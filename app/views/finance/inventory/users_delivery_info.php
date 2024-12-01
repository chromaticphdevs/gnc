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
        <h3><b>Delivery Information and Reciept</b></h3>
  

          <div class="row">
            <div style="overflow-x:auto;">

              <?php if(empty($delivery_info)):?>
                     <br>
                     <h1 style="color:red;">NO Delivery Info</h1>
              <?php else:?>
                <?php foreach($delivery_info as $key => $row) :?>

                    <div class="gallery">
                      <a target="_blank" href="<?php echo URL.DS.'assets/delivery_image/'.$row->image; ?>">
                        <img src="<?php echo URL.DS.'assets/delivery_image/'.$row->image; ?>" alt="Cinque Terre" width="600" height="400">
                      </a>
                      <div class="desc">
                        Control Number:<h2><b style="color:green;"><?php echo $row->control_number; ?></b></h2>
                        <br>
                        Date & Time:<h2><b> 

                            <?php
                                  $date=date_create($row->date_time);
                                  echo date_format($date,"M d, Y");
                                  $time=date_create($row->date_time);
                                  echo date_format($time," h:i A");
                            ?>
                              
                            </b></h2>
                      </div>
                    </div>
                <?php endforeach; ?>
            <?php endif;?>

            </div>
          </div>


<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

