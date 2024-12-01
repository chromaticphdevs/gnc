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

 table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}
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
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>      
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">
            <h3><?php echo $title; ?></h3>
            <?php Flash::show()?>

            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <th>Full Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                            </thead>

                            <tbody>

                                <?php for($row = 0; $row < count($user_list); $row++) :?>

                                    <tr>

                                        <td><?php echo $user_list[$row][0]." ".$user_list[$row][1]; ?></td>
                                        <td><?php echo $user_list[$row][2]; ?></td>
                                        <td><?php echo $user_list[$row][3]; ?></td>
                                        <td><?php echo $user_list[$row][4]; ?></td>
                                        <td>

                                            <?php if($user_list[$row][5] == "Qualified"): ?>
                                                     <span class="label label-success"><?php echo $user_list[$row][5]; ?></span>
                                            <?php else: ?>
                                                      <span class="label label-warning"><?php echo $user_list[$row][5]; ?></span>
                                            <?php endif; ?>  
                                            
                                        </td>
                                      
                                    </tr>

                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>