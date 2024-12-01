<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
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

            <section class="x_panel">
                <section class="x_content">
                    <form class="ui form" method="post" action="/commissions/getToday">
                        <div class="col-md-3">
                            <h3>Enter number of Days</h3>
                            <br>
                            <input type="number" name="number_of_days" value="<?php echo $number_of_days?>"
                             class="form-control">
                        </div>
                    </form>

                    <?php
                     $total_amount = 0 ;
                     $total_drc = 0 ;
                     $total_binary = 0 ;
                     $total_unilvl = 0 ;
                     $total_mentor = 0 ;
                    ?>
          
                    <?php foreach($commissions as $com) : ?>
                        <?php $total_amount += $com->c_amount ?>

                        <?php 

                            if($com->c_type=="binary commission")
                            {
                                $total_binary += $com->c_amount ;
                                
                            }else if($com->c_type=="UNILVL")
                            {
                                $total_unilvl += $com->c_amount ;

                            }else if($com->c_type=="DRC")
                            {
                                $total_drc += $com->c_amount ;

                            }else if($com->c_type=="MENTOR")
                            {
                                $total_mentor += $com->c_amount ;

                            }


                        ?>
                      
                        <?php endforeach;?>
                        <table class="table">
                                <th></th>
                                <th></th>

                                <tr>
                                    <td>   
                                     
                                        <h3>Total  Binary Commission Amount: </h3> 
                                         <div style="background: green;color:#fff; padding: 15px;"><?php echo number_format($total_binary,2);?>
                                         </div>
                                       
                                    </td>
                                    <td>    
                                   
                                        <h3>Total UNILVL Amount : </h3> 
                                        <div style="background: green;color:#fff; padding: 15px;"><?php echo number_format($total_unilvl,2);?>
                                        </div>
                                
                                    </td>
                                </tr>


                                <tr>
                                    <td>   
                                     
                                        <h3>Total DRC Amount : </h3> 
                                        <div style="background: green;color:#fff; padding: 15px;"><?php echo number_format($total_drc,2);?>  
                                        </div>
                                   
                                    </td>
                                    <td>    
                                    
                                        <h3>Total Mentor Amount : </h3> 
                                        <div style="background: green;color:#fff; padding: 15px;"><?php echo number_format($total_mentor,2);?>
                                        </div>
                                  
                                    </td>
                                </tr>

                                <tr>
                                    <td>   
                                     
                                        <h3>Total Amount : </h3> 
                                        <div style="background: green;color:#fff; padding: 15px;"><?php echo number_format($total_amount,2);?>  
                                        </div>
                                     
                                    </td>
                                    <td>    
                                     
                                    </td>
                                </tr>
                        </table>
                </section>
            </section>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>