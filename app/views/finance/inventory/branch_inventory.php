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
            <h3>Branch Inventory</h3>
            <?php Flash::show()?>


            <div class="row">  
                    <div id="logs_by_branch">
                        <div class="x_panel">
                            <div class="x_content">
                                <h3>Stock Logs</h3>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Branch</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                 
                                    </thead>

                                    <tbody>
                                        <?php foreach($items as $key => $row) :?>
                                            <?php if(!empty($row->product_name)):?>
                                                <tr>
                                                    <td><?php echo ++$key?></td>
                                                    <td><?php echo $row->branch_name; ?></td>
                                                    <td>
                                                        <?php echo $row->product_name; ?>
                                                    </td>
                                                    <td><?php echo $row->quantity; ?></td>
                                                   
                                                </tr>
                                              <?php endif;?>  
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                     </div>
          
            </div>
        </div>
        <!-- page content -->



<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>