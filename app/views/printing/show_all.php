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

            <br>
          </div>
        </div>
        <!-- top navigation -->
      
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
         

        <?php Flash::show()?>
        <a href="/PrintingExpense" class="btn btn-primary" role="button" aria-pressed="true">Back</a>
        <br>
        <h3><b>Uploaded Expense Image</b></h3>
  
          <div class="row">
            <div style="overflow-x:auto;">

              <?php if(empty($expenses)):?>
                     <br>
                     <h1 style="color:red;">NO Uploaded Expense Report</h1>
              <?php else:?>
                <?php $counter = 1;?>
                <?php foreach($expenses as $key => $row) :?>
                   <?php if($counter <= 15):?>
                        <div class="gallery">
                          <a target="_blank" href="<?php echo URL.DS.'assets/PrintingImage/'.$row->image; ?>">
                            <img src="<?php echo URL.DS.'assets/PrintingImage/'.$row->image; ?>" alt="Cinque Terre" width="350" height="200">
                          </a>
                          <div class="desc">
                            Note:<h2><b style="color:green;"><?php echo $row->note; ?></b></h2>
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
                     <?php endif;?>
                  <?php $counter++;?>
                <?php endforeach; ?>
            <?php endif;?>

            </div>
          </div>


<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

