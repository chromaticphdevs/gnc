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
                                <th>#</th>
                                <?php if($user_type == 'admin'): ?>
                                    <th>Username</th>
                                <?php endif; ?> 
                                <th>Full Name</th>
                                <th>Branch</th>  
                                <th>Email</th> 
                                <th>phone</th>
                                <th>Date and time</th>                    
                               
                            </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($register_just_now as $list_just_now) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <?php if($user_type == 'admin'): ?>
                                               <td><?php echo $list_just_now->username; ?></td>
                                            <?php endif; ?>    
                                            <td><?php echo $list_just_now->fullname ?></td>
                                            <td><?php echo $list_just_now->branch; ?></td>
                                            <td><?php echo $list_just_now->email; ?></td>
                                            <td><?php echo $list_just_now->mobile; ?></td>   
                                            <td>
                                                <?php
                                                    $date=date_create($list_just_now->created_at);
                                                    echo date_format($date,"M d, Y");
                                                    $time=date_create($list_just_now->created_at);
                                                    echo date_format($time," h:i A");
                                                  ?>
                                            </td>
                                           
                                      </tr>
                                    <?php $counter++;?>  
                                    <?php endforeach;?>

                            </tbody>
                            
                        </table>
                    </div> <br>
              
                     </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>