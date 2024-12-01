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
<div class="profile clearfix">
    <div class="profile_pic">
         
        <a href="/admin/users/profile"><img src="/images/user.png" alt="..." class="img-circle profile_img"></a>
            </div>
    <div class="profile_info">
        <span>Welcome</span>
        <h2><?php get_user_username()?></h2>
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
            <div class="x_panel">
                <div class="x_content">
                <h3><?php echo $title?></h3>
                <table class="table">
                    <thead>
                        <th>Order Date</th>
                        <th>Commission</th>
                        <th>Amount</th>
                        <th>Purchaser</th>
                    </thead>

                    <tbody>
                        <?php foreach($commissions as $row) :?>
                            <tr>
                                <td><?php echo $row->dt?> <a href="/orders/view_order/<?php echo $row->order_id?>">View</a></td>
                                <td><?php echo $row->c_type?></td>
                                <td><?php echo $row->c_amount?></td>
                                <td><?php echo $row->u_username?> (<?php echo $row->c_fullname?>)
                                    <a href="/users/view_user/<?php echo $row->c_purchaser?>">View</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                </div>
            </div> 
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>