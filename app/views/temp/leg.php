<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/"><img src="/images/admin-isocialplanet.png"></a>
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
         
        <a href="/admin/users/profile"><img src="/images/user.png" alt="..." class="img-circle profile_img"></a>
            </div>
    <div class="profile_info">
        <span>Welcome</span>
        <h2>testcoder testcoder</h2>
        <p>&nbsp;</p>
    </div>
</div>
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
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"><div class=" flash_message" id="message" style="display: none;"></div>   <script>
                    setTimeout(function() {
                        $('#message').fadeOut('slow');
                    }, 3000);
                </script>
                </div>                  
            </div>
            
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 

            <!--OPTIONAL -->


                <!-- 
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        </div>
                    </div>
                 -->

            <!-- // OPTIONAL -->
            <?php 
            $left_points  = empty($b_tree_income['left']) ? 0:$b_tree_income['left']->points;

            $right_points = empty($b_tree_income['right']) ? 0:$b_tree_income['right']->points;

            $binary_income = generate_binary_income($left_points , 200);

            ?>
            <div class="col-md-12 col-sm-12 col-xs-12"> 
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-line-chart"></i> <strong>Leg Details</strong></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                            <!-- start project list -->                     
                      <table class="table table-striped projects" id="responsive">
                          <thead>
                            <tr>
                                <th style="width: 4%">#</th>
                                <th>Username</th>
                                <th>Left Point</th>
                                <th>Right Point</th>
                                <th>Left Carry</th>
                                <th>Right Carry</th>
                                <th>Total Pair</th>
                                <th>Amount</th>
                            </tr>
                          </thead>
                          <tbody>             
                           <tr>
                            <td></td>
                            <td><?php echo get_user_username()?></td>
                              <td>
                                <?php   
                                  if(!empty($b_tree_income['left']))
                                  {
                                    echo $b_tree_income['left']->points;
                                  }
                                ?>
                              </td>
                              <td>
                                200
                              </td>
                              <td>
                                <?php echo $binary_income['left'] ?>
                              </td>
                              <td>
                                <?php echo $binary_income['right'] ?>
                              </td>
                              <td>
                                <?php echo $binary_income['pair'] ?>
                              </td>
                              <td>
                                <?php echo $binary_income['amount'] ?>
                              </td>
                            </tr>
                              
                          </tbody>
                      </table>     
                            <!-- end project list -->
                  </div>
                </div>
            </div>
        </div>
        </div>

        <?php 

          #switch this function

      function generate_binary_income($left , $right)
      { 
        $greater;
        $lower;

        $amount = 0;
        $pair = 0;
        if($right > $left){
          $greater = $right;
          $lower = $left;
        }else{
          $greater = $left;
          $lower   = $right;
        }

        do{

            if(!isset($amount) && !isset($pair))
            {
              $amount = 0 ; $pair = 0;
            }
            if($lower >= 100)
            {
              $right   -= 100;
              $left    -= 100;
              $lower   -= 100;

              $amount  += 100;
              $pair    ++;
            }

        }while($lower >= 100);

        return array(
          'right'   => $right,
          'left'    => $left ,
          'pair'    => $pair,
          'amount'  => $amount
        );
      }
        ?>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>