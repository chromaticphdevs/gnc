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

              <?php if(empty($result)):?>
                     <br>
                     <h1 style="color:red;">NO Pictures</h1>
              <?php else:?>
                <?php foreach($result as $key => $row) :?>

                    <div class="gallery">
                      <a target="_blank" href="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card; ?>">
                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card; ?>" alt="Cinque Terre" width="300" height="200">
                      </a>
                       <a target="_blank" href="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card_back; ?>">
                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card_back; ?>" alt="Cinque Terre" width="300" height="200">
                      </a>
                      <div class="desc">
                       Type:<h2><b style="color:green;"><?php echo $row->type; ?></b></h2><br>
                       status:<h2><?php echo $row->status; ?></h2>
                        <br>

                      </div>
                    </div>
                <?php endforeach; ?>
            <?php endif;?>

            </div>
          </div>


<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

