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
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>      
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
                    <h3>Binary Leg Details</h3>
                    <table class="table">
                        <thead>
                            <th>Order Date</th>
                            <th>Commission</th>
                            <th>Position</th>
                            <th>Pointsss</th>
                            <th>Purchaser</th>
                        </thead>

                        <tbody>
                            <?php foreach($bCommissions as $com) :?>
                                <tr>
                                    <td><?php echo $com->dt?> <a href="/orders/view_order/<?php echo $com->order_id?>">View</a></td>
                                    <td><?php echo $com->c_type?></td>
                                    <td><?php echo $com->c_position?></td>
                                    <td><?php echo $com->c_points?></td>
                                    <td><?php echo $com->u_username?> (<?php echo $com->c_fullname?>)
                                        <a href="/users/view_user/<?php echo $com->c_purchaser?>">View</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </section>
            </section>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>