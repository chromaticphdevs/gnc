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
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->
          
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">

            <?php Flash::show()?>
            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_content">
                  
                      <?php 
                          $basic_running = 1000;
                          $basic_price = 700 * $pre_view['multiplier'];
                          $succeeding_price = 300;
                      ?>

                       <h4><b> 
                           <?php
                                $date_time = today();
                                $date=date_create( $date_time);
                                echo date_format($date,"M d, Y");
                                $time=date_create( $date_time);
                                echo date_format($time," h:i A");
                            ?>  
                       </b></h4>
                       <hr>
                         <div class="form-group">
                            <h4>Machine Type: <b><?php echo $pre_view['machine_type']?></b></h4>

                            <h4>Job Order Number: <b><?php echo $pre_view['job_order']?></b></h4>
                          
                            <h4>Client: <b><?php echo $pre_view['client']?></b></h4>
                           
                            <h4>Agent: <b><?php echo $pre_view['agent']?></b></h4>
                            
                            <h4>Agent Contact# : <b><?php echo $pre_view['agent_number']?></b></h4>
                      
                            <h4>Operator Name: <b><?php echo $pre_view['name']?></b></h4>
                          <br>
                         <div class="form-group">
                             <h4><b>Previous Running (Meter Reading)</b></h4>
                            <input type="number" class="form-control"  value="<?php echo $pre_view['previous_meter_readings']?>"readonly>

                         
                            <h4><b>Current Meter Reading</b></h4>
                            <input type="number" class="form-control" value="<?php echo $pre_view['meter_readings']?>"  readonly>

                            <br>
                            <h3>Total Running: <b style="color:green;"><?php echo $pre_view['total_running']?></b></h3>
                           
                            <h4>Minimum:<b>&#8369; <?php echo $basic_price ?></b>  Succeeding:<b> &#8369; <?php echo $pre_view['amount_total_running']-$basic_price?></b></h4>

                            <h4>Amount:<b>&#8369; <?php echo $pre_view['amount_total_running']?></b>  Discount:<b> &#8369; <?php echo $pre_view['discount']?></b></h4>
                            
                           <h3>Payment:<b style="color:green;"> &#8369; <?php echo $pre_view['amount_total_running'] - $pre_view['discount']?></b></h3><br>
                          
                        </div>
                        <div class="form-group">
                              <h4>Note : <b><?php echo $pre_view['note']?></b></h4>
                        </div>
                       <br><br><br><br><br><br>
                      <a href="/PrintingExpense" class="btn btn-primary" role="button" aria-pressed="true">Done</a>
              
             
                </div>
              </div>
            </div>
         </div>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
