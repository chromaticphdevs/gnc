
<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
    .module-container{
    }.module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px; }

table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;}

    th, td {
      text-align: left;
      padding: 8px;}
    tr:nth-child(even){background-color: #f2f2f2}
</style>
<?php
    $user_type = Auth::user_position();
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }
?>
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

 <?php $whirlpool="831a50be987979d6ee3658eb80f2d1ca8cd21023e90cbd6a98c6c8c0801d9b263d2da6a134a128f886d4cbd22bfbd455adce86b289876df4f7b9d6945c6bbbf4"; ?>

        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">

            <h3><?php echo $title; ?></h3>
            <?php Flash::show()?>

            <a class="btn btn-info btn-sm" href="/FNProductBorrower/get_payment_list_pending">Pending Payments List</a>

            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">

                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Loan Number</th> 
                                <th>Full Name</th> 
                                <th>phone</th>
                                <th>Amount</th>
                                <th>Image</th>
                                <th>Date & Time</th>                                           
                            </thead>

                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($result as $data) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <td>#<?php echo $data->code; ?></td>
                                            <td><?php echo $data->fullname; ?></td>
                                            <td><?php echo $data->mobile; ?></td> 
                                            <td><?php echo $data->amount; ?></td>
                                            <td>                      

                                                   <a class="btn btn-success btn-sm" 
                                                      href="/FNProductBorrower/preview_image/?code=<?php echo  $whirlpool.''.$whirlpool; ?>&loan_id=<?php echo $data->loanId; ?>&loan_number=<?php echo $data->code; ?>&payment_id=<?php echo $data->id; ?>&fullname=<?php echo $data->fullname; ?>&amount=<?php echo $data->amount; ?>&filename=<?php echo $data->image; ?>&userId=<?php echo $data->userId; ?>&code2=<?php echo  $whirlpool.''.$whirlpool; ?>&status=Approved" 
                                                      id="release_product">Preview Image</a>
                                                  

                                            </td> 

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
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>