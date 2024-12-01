<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
  .userinfo-ajax{
    border: 1px solid #000;
    cursor: pointer;
  }

  .userinfo-ajax:hover{
    background: green;
    color: #000;
  }
</style>
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
            <h3>Code Purchase Release</h3>

            <div class="x_panel">
              <div class="x_content">
                <div class="col-md-5">
                <h3>Search Claim</h3>
                <form action="" method="get">
                  <div class="form-group">
                    <label for="#">Claim Reference</label>
                    <input type="text" name="reference" class="form-control" 
                    value="<?php echo $_GET['reference'] ?? ''?>">
                    <small>Claim Reference Only.</small>
                  </div>
                  <input type="submit" class="btn btn-primary btn-sm" value="Search">
                </form>
                </div>

                <?php if(isset($_GET['reference'])) : ?>
                <div class="col-md-5">
                  <?php if(!empty($codePurchased)) :?>
                    <div class="container" 
                      style="padding: 10px; border:  1px solid #000;">
                      <div class="text-center">
                        <h3><?php echo $codePurchased->reference?></h3>
                        <p>Claim Reference </p>
                      </div>
                      <ul>
                        <li><h4>Code : <?php echo $code->get_code_secret()?> </h4></li>
                        <li><h4>Level : <?php echo $code->level?> </h4></li>
                        <li><h4>Owner : <?php echo $userinfo->fullname?> </h4></li>
                        <li><h4>Status : <?php echo $codePurchased->status?> </h4></li>
                      </ul>
                      <h2 style="background: blue; color: #fff; padding: 10px;"><?php echo "Box Total : {$code->box_eq}"?></h2>
                      <hr>
                      <form action="" method="post">
                        <input type="hidden" name="purchaseid" value="<?php echo $codePurchased->id?>">
                        <input type="submit" class="btn btn-primary btn-sm" value="Claim Items.">
                      </form>
                    </div>
                    <?php else:?>
                      <h1>Not Found '<?php echo $_GET['reference']?>' </h1>
                  <?php endif;?>
                </div>
                <?php endif?>
              </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>