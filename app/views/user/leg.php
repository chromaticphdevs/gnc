<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style type="text/css">
  .left-detail
  {
    border-bottom: 1px solid #000;
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
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
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

          <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Commission Type
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="/commissions/binaryCommissions">Binary</a></li>
                            <li><a href="/commissions/get_list/?type=drc">DRC</a></li>
                            <li><a href="/commissions/get_list/?type=unilevel">Unilevel</a></li>
                            <li><a href="/commissions/get_list/?type=mentor">Mentor</a></li>
                            <li><a href="/commissions/getAll">All</a></li>
                        </ul>
                   </div>
 
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
            <div class="col-md-12  col-sm-12 col-xs-12">
              <div class="x_panel x_well"><h3>Binary Commissions</h3></div>
              <div class="row">
                  <section class="col-md-7">
                    <section class="x_panel">
                        <section class="x_content">
                            <h3>Pair Tracker</h3>
                            <table class="table">
                                <thead>
                                    <th>Left_vol</th>
                                    <th>Right_vol</th>
                                    <th>Left_carry</th>
                                    <th>Right_carry</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </thead>

                                <tbody>
                                <?php foreach($pairTracker as $pair) : ?>
                                <tr>
                                    <td><?php echo $pair->left_volume;?></td>
                                    <td><?php echo $pair->right_volume;?></td>
                                    <td><?php echo $pair->left_carry;?></td>
                                    <td><?php echo $pair->right_carry;?></td>
                                    <td><?php echo $pair->amount?></td>
                                    <td><?php echo $pair->dt?></td>
                                </tr>
                                <?php endforeach?>
                                </tbody>
                                <tbody>

                                </tbody>
                            </table>
                        </section>
                    </section>
                  </section>

                  <section class="col-md-5">
                    <section class="x_panel">
                        <section class="x_content">
                            <h3>Leg Details</h3>
                            <div class="left-detail">- Left Point  : <strong><?php echo $legDetails->left_volume()?></strong></div>
                            <div class="left-detail">- Right Point : <strong><?php echo $legDetails->right_volume()?></strong></div>
                            <div class="left-detail">- Left Carry  : <strong><?php echo $legDetails->getLeftCarry()?></strong></div>
                            <div class="left-detail">- Right Carry : <strong><?php echo $legDetails->getRightCarry()?></strong></div>
                            <div class="left-detail">- Total Pair  : <strong><?php echo $legDetails->total_pair()?></strong></div>
                            <div class="left-detail">- Amount      : <strong><?php echo $legDetails->getTotalAmount()?></strong></div>
                        </section>
                    </section>
                  </section>
              </div>
            </div>
        </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>