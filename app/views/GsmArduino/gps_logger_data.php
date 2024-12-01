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
      
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>      
        <!-- top navigation -->
        
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">
            <h3><?php echo $title; ?></h3>
            <?php Flash::show()?>
            <div class="container">
                <div class="x_panel">


                    <form action="/GsmArduino/export" method="post">
                        <input type="hidden" name="data" 
                            value="<?php echo base64_encode(serialize($result))?>">

                        <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
                    </form>

                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <a class="btn btn-danger btn-sm" href="/GsmArduino/gps_logger_clear_data">Clear</a>  

                    <div class="x_content">
                    <div style="overflow-x:auto;">
                        <table class="table">
                         <thead>
                                <th>#</th>
                                <th>Latitude</th> 
                                <th>Longitude</th> 
      
                         </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                                   <?php foreach($result as $data) :?>
                                      <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $data->Latitude; ?></td>
                                            <td><?php echo $data->Longitude; ?></td>
                                        
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