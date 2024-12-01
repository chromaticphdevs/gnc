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
            <h3><b><?php echo $title; ?></b></h3>
            <?php Flash::show()?>
            <div class="container">
                <div class="x_panel">


                    <form action="/UserTools/export" method="post">
                        <input type="hidden" name="users" 
                            value="<?php echo base64_encode(serialize($result))?>">

                        <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
                    </form>
                    <br>

                    <form action="/UserTools/get_top_performer" method="post">

                      <?php if(isset($status)):?>

                          <?php if($status == "All"): ?>
                            <input type="radio"  name="status" value="All" checked>
                          <?php else: ?>
                            <input type="radio"  name="status" value="All" >
                          <?php endif; ?>    
                            <label for="male">All</label><br>

                          <?php if($status == "Activated"): ?>
                            <input type="radio"  name="status" value="Activated" checked>
                          <?php else: ?>
                            <input type="radio"  name="status" value="Activated" >
                          <?php endif; ?>      
                            <label for="female">Activated</label><br>

                      <?php else:?>  
                        <input type="radio"  name="status" value="All" checked>
                        <label for="male">All</label><br>
                        <input type="radio"  name="status" value="Activated">
                        <label for="female">Activated</label><br>
                      <?php endif; ?> 

                       

                          <select name="top">
                            <option value="today">Today</option>
                            <option value="days7">Week</option>
                            <option value="days30">Month</option>
                            <option value="days90">90 days</option>
                            <option value="days180">6 Month</option>
                            <option value="100">Top 100</option>
                            <option value="200">Top 200</option>
                            <option value="300">Top 300</option>
                            <option value="400">Top 400</option>
                            <option value="500">Top 500</option>
                          </select>

                          <input type="submit" class="btn btn-success btn-sm" value="Show">
                    </form>
                    <br>

                    <div class="x_content">
                    <div style="overflow-x:auto;">
                        <table class="table">
                         <thead>
                                <th>#</th>
                                <th>Username</th> 
                                <th>Full Name</th> 
                                <th>Email</th> 
                                <th>phone</th>
                                <th>Total Direct Referral</th> 
        
                         </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($result as $data) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $data->username; ?></td>
                                            <td><?php echo $data->fullname; ?></td>
                                            <td><?php echo $data->email; ?></td>
                                            <td><?php echo $data->mobile; ?></td>  
                                            <td><h4 style="color:green;"><?php echo $data->total_DS; ?></h4></td>
                                          
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