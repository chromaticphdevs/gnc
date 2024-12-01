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
            <?php Flash::show()?>
            <div class="row">
            
                    <div class="x_panel">
                        <div class="x_content">
                             <div class="col-md-4">
                            <h3>Request Account</h3>
                            <form action="/FNAccount/request_staff" method="post">
                                 <div class="row form-group">
                                
                                    <label for="name">Full Name</label>
                                    <input type="text" name="fullname" placeholder="Full name" 
                                    class="form-control">
                               
                                    <br>
                              
                                        <label for="name">Username</label>
                                        <input type="text" name="username" placeholder="Username" 
                                        class="form-control">
                              
                                </div>
                                <input type="submit" class="btn btn-primary btn-sm" id="request" value="Send Request">
                            </form>  
                        </div> 


                        <div class="col-md-8">
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Action</th>
                      </thead>

                      <tbody>
                        <?php foreach($list as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->name?></td>
                            <td><?php echo $row->fn_username; ?></td>
                            <td>
                                <?php if($row->fn_status == 'pending'): ?>
                                  <span class="label label-primary"><?php echo $row->fn_status?></span>
                                <?php elseif($row->fn_status == 'canceled'): ?>
                                  <span class="label label-danger"><?php echo $row->fn_status?></span>
                                <?php elseif($row->fn_status == 'approved'): ?>
                                  <span class="label label-success"><?php echo $row->fn_status?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row->fn_status == 'pending'): ?>
                                  <form action="/FNAccount/change_request_status" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row->fn_id?>">
                                    <input type="hidden" name="status" value="cancel">
                                    <input type="submit" id="cancel" value="Cancel" class="btn btn-danger btn-sm">
                                  </form>
                                <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach?>
                      </tbody>
                    </table>
                  </div>
        </div> </div>
            </div>
        </div>
<script defer>
  $( document ).ready(function() {

    $("#request").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

     $("#cancel").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

  });
</script>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>