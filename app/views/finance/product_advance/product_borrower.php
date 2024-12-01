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
                        <table class="table">
                         <thead>
                                <th>#</th>
                                <th>Username</th> 
                                <th>Full Name</th> 
                                <th>Email</th> 
                                <th>phone</th>
                                <th>Address</th>
                                <th>Remarks</th>  
                                <th># Verified ID</th>
                                <th></th>
                                <th>Date & Time</th>
                                <th>Valid Social Media</th>
                                <th></th>
                                <th></th> 
                                <th></th>               
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
                                            <td><?php echo $data->address; ?></td>
                                            <td>
                                              <?php echo $data->reason?>
                                            </td>
                                            <td><h4 style="color:green;"><?php echo $data->total_valid_id; ?></h4></td>
                                            <td> <a class="btn btn-info btn-sm" 
                                                  href="/UserIdVerification/staff_preview_id/<?php echo seal($data->userid); ?>" 
                                                   target="_blank" >Preview ID</a>
                                            </td>
                                            <td><?php echo $data->date_time; ?></td>
                                            <td><h4 style="color:green;"><?php echo $data->total_valid_link; ?></h4></td>
                                            <td><a class="btn btn-primary btn-sm" href="<?php echo $data->valid_link; ?>" target="_blank">Preview</a></td>
                                            <td>
                                              <!-- <a class="btn btn-success btn-sm" href="/FNProductBorrower/release_product/<?php echo $data->userid; ?>">&nbsp;Release Product&nbsp;</a>-->
                                                  <form action="/FNProductBorrower/release_product" method="post" enctype="multipart/form-data"> 

                                                        <input type="hidden"  name="userid" value="<?php echo $data->userid; ?>" required>
                                                        <input type="hidden"  name="quantity" value="4" required>
                                               
                                                   
                                                        <input type="submit" class="btn btn-success btn-sm validate-action" value="Release Product">
                                               
                                                  </form>
                                            </td> 
                                            <td>
                                                <form action="/UserIdVerification/cancel_qualification" method="post" enctype="multipart/form-data"> 

                                                        <input type="hidden"  name="id" value="<?php echo $data->uploaded_id_id; ?>" required>
                                                        <input type="hidden"  name="comment" value="cancelation of qualification">
                                                                                           
                                                        <input type="submit" class="btn btn-danger btn-sm validate-action" value="Cancel">
                                                                                                 
                                                  </form>
                                                <!--<a class="btn btn-danger btn-sm" onclick="cancel_btn()" href="/FNProductBorrower/cancel_qualification_product/<?php echo $data->userid; ?>">Cancel</a>-->
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