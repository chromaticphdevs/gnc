<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
  .userinfo-ajax{
    border: 1px solid #000;
    cursor: pointer;
  }

  .userinfo-ajax:hover{
    background: green;
    color: #000;
  }
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
            
            <?php Flash::show()?>

            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_content">
                 <br>
             
                    <?php if(isset($_GET['userId'])):?>
                      
                      <table class="table">
                        <tr>
                          <td>Fullname:</td>
                          <td><strong><?php echo $_GET['fullname']; ?></strong></td>
                        </tr>

                        <tr>
                          <td>Email:</td>
                          <td><strong><?php echo $_GET['email']; ?></strong></td>
                        </tr>
                        <tr>
                          <td>Mobile Number:</td>
                          <td><strong><?php echo $_GET['phone']; ?></strong></td>
                        </tr>

                      <form action="/FNCashAdvancePayment/make_payment" id="payment" method="post" enctype="multipart/form-data">  

                        <tr>
                          <td>Upload Image</td>
                          <td><input type="file" name="payment_picture" required></td>
                        </tr>

                        <tr>
                          <td>Payment Amount</td>
                          <td> <input type="number"  name="amount" class="form-control" autocomplete="off" required></td>

                            <input type="hidden"  name="loan_id" value="<?php echo $_GET['loan_id'] ?>"  required>
                            <input type="hidden"  name="userId" value="<?php echo $_GET['userId'] ?>" required>
                            </td>
                        </tr>            
                        <tr>
                          <td>Balance:</td>
                          <td><h4 style="text-align: center;"><b>
                                 <p>&#8369;<?php echo to_number($_GET['balance']); ?><p>
                            </b></h4>
                          </td>
                        </tr>
                        <tr>
                              
                              <div style="overflow-x:auto;">

                                  <table class="table">
                                      <thead>
                                          <th>Username</th>
                                          <th>Available Earnings</th>
                                
                                      </thead>

                                       <tbody>
                                            
                                             <?php for($row = 0; $row < count($earning_info); $row++) :?>

                                                   <tr>

                                                    <td><?php echo $earning_info[$row][1] ?></td>
                                                    <td>&#8369;<?php echo to_number($earning_info[$row][2]); ?></td>
                                                   
                                                  </tr>

                                            <?php endfor; ?>
                                      </tbody>                          
                                  </table>
                              </div>
                
                        </tr>

                      </table>
                       
                      <input type="submit" class="btn btn-primary btn-sm validate-action" value="Submit Payment">
                   
                  </form>


                   <?endif;?>

                </div>
              </div>
            </div>
         </div>

<script defer>
  $( document ).ready(function() {

    $("#payment").on('submit' , function(e)
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