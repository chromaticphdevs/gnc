<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>
    .module-container
    {

    }

    .module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px;
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

        <?php 

            $user = Session::get('BRANCH_MANAGERS');
            $user_type =  $user->type;

        ?>



        <div class="right_col" role="main" style="min-height: 524px;">

       
            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                       <h3>Product Advance Claim</h3>
                        <?php Flash::show()?>
                        <form  method="post" action="/FNSinglebox/claim_assistance_search">     
                            <div class="form-group">
                                <label for="#">Enter Code to Search</label>
                                <input type="text" name="code" class="form-control" placeholder="Code" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-sm" value="Search">
                            </div>
                        </form>   

                    </div>
                </div>
            </div>

       
            <br>  <br>
           

            <div class="x_panel">
              <div class="x_content">
                <div class="col-md-5">
                <h3>Code Purchase Claim</h3>
                <form action="/FNCodePurchase/claim_purchase" method="get">
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

                      <?php if($codePurchased->status != 'claimed') :?>       
                          <form action="" method="post">
                            <input type="hidden" name="purchaseid" value="<?php echo $codePurchased->id?>">
                            <input type="submit" class="btn btn-primary btn-sm" value="Claim Items">
                          </form>
                      <?php endif;?>

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