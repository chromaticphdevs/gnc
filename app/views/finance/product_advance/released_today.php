<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1.5px solid #ddd;
}

th, td {
  text-align: left;
  padding: 4px;
}

tr:nth-child(even){background-color: #f2f2f2}
#users {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#users td, #users th {
  border: 1px solid #ddd;
  padding: 8px;
}

#users tr:nth-child(even){background-color: #f2f2f2;}

#users tr:hover {background-color: #ddd;}

#users th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
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
                       <h3><b>Product Loan</b></h3>
                        <table id="users">
                         <thead>
                                <th>#</th>
                                <th>Username</th> 
                                <th>Full Name</th> 
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Branch</th>
                                <th>Time</th>
                                       
                         </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($product_loan as $data) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $data->username; ?></td>
                                            <td><?php echo $data->firstname." ".$data->lastname; ?></td>
                                            <td><?php echo $data->amount; ?></td>
                                            <td><?php echo $data->quantity; ?></td>  
                                            <td><?php echo $data->branch_name; ?></td>
                                            <td> 
                                                <?php $time=date_create($data->date_time);
                                                 echo date_format($time," h:i A"); ?>
                                            </td>   
                                       </tr>
                                    <?php $counter++;?>  
                                    <?php endforeach;?>
                            </tbody>
                        </table>
                        <br>
                        <h3><b>Advance Payment</b></h3>
                        <table id="users">
                         <thead>
                                <th>#</th>
                                <th>Username</th> 
                                <th>Full Name</th> 
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Branch</th>
                                <th>Time</th>
                                       
                         </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($advance_payment as $data) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $data->username; ?></td>
                                            <td><?php echo $data->firstname." ".$data->lastname; ?></td>
                                            <td><?php echo $data->amount; ?></td>
                                            <td><?php echo $data->quantity; ?></td>  
                                            <td><?php echo $data->branch_name; ?></td>
                                            <td> 
                                                <?php $time=date_create($data->date_time);
                                                 echo date_format($time," h:i A"); ?>
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