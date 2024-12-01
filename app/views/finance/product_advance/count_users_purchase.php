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
            <h3><?php echo $title; ?></h3>
            <?php Flash::show()?>
            <div class="container">
                <div class="x_panel">


                    <form action="/FNProductBorrower/export" method="post">
                        <input type="hidden" name="users" 
                            value="<?php echo base64_encode(serialize($result))?>">

                        <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
                    </form> 
        
                    <div class="x_content">
                    <div style="overflow-x:auto;">

                              <!--<?php $total_p = 0;?>
                                   <?php foreach($result as $data) :?>
                                      <tr>
                                          <?php if($data->user_all_item > 1 AND $data->user_paid_item< $data->user_all_item ):?>
                                  
                                            <?php $total_p = $total_p +$data->user_all_item;?>
                                          <?php endif;?>
                                      </tr>
                           
                                    <?php endforeach;?>

                                 <h3><b>Total: &#8369; <?php echo $total_p; ?></b></h3>-->
                        <table class="table">
                         <thead>
                                <th>#</th>
                                <th>Username</th> 
                                <th>Full Name</th> 
                                <th>Total Purchase</th> 
                                 <th></th> 
          
                         </thead>
                             <tbody>
                                   <?php $counter = 1;?>
                        
                                   <?php foreach($result as $data) :?>
                                      <tr>
                                          <?php if($data->user_paid_item > 1 AND $data->user_paid_item< $data->user_all_item ):?>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $data->username; ?></td>
                                            <td><?php echo $data->name; ?></td>
                                            <td><?php echo $data->user_all_item; ?></td>
                                            <td><a class="btn btn-primary btn-sm" href="/FNProductBorrower/get_user_loans2/<?php echo $data->userid; ?>" target="_blank">Preview</a></td>
                                       
                                          <?php endif;?>
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

        <script defer>
          $( document ).ready(function() {

    
              function cancel_btn()
             {

                 if (confirm("Are You Sure?")) 
                 {
                    return true;
                 }else
                 {
                   var a_href = $(this).attr('href');
                   e.preventDefault();
                 }

             }

          });
      </script>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>