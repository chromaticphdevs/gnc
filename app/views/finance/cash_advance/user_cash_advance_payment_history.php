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
            <h3><?php echo "Amount: &#8369; ".$amount; ?></h3>
            <h3><?php echo "balance: &#8369;".$balance; ?></h3>
            <h3><?php
                 $date=date_create($date_time);
                  echo "Date Aprroved: ".date_format($date,"M d, Y");
                 ?>
            </h3>
            <?php Flash::show()?>

            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <th>#</th> 
                                <th>Amount</th>
                                <th>Image</th>  
                                <th>Date and time</th>                    
                               
                            </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($payments as $data) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $data->amount ?></td>
                                            <td><a href="<?php echo PUBLIC_ROOT.DS.'assets/payment_image/'.$data->image; ?>" target="_blank" >Preview Image</a></td>
                                            <td>
                                                <?php
                                                    $date=date_create($data->date_time);
                                                    echo date_format($date,"M d, Y");
                                                    $time=date_create($data->date_time);
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