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
            <h1>Advance Payment</h1>
            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_content">
                
                <form action="/FNProductBorrower/search_user_advance_payment" id="user_name" method="post">

                    <div class="form-group">
                      <label for="#">Username / Fullname</label>
                      <input type="text" id="search_user" class="form-control" autocomplete="off">
                      <div id="search_user_warning"></div>
                    </div>
                    <input type="hidden" name="userid" id="userid" required>

                    <div id="userList">
                    </div>

                    <input type="submit" class="btn btn-primary btn-sm validate-action" value="Search">

                 </form>
                 <br><br>
            
             
                    <?php if(isset($userInfo)):?>
                      
                      <table class="table">
                        <tr>
                          <td>Fullname:</td>
                          <td><strong><?php echo $userInfo->fullname; ?></strong></td>
                        </tr>

                        <tr>
                          <td>Email:</td>
                          <td><strong><?php echo $userInfo->email; ?></strong></td>
                        </tr>
                        <tr>
                          <td>Mobile Number:</td>
                          <td><strong><?php echo $userInfo->mobile; ?></strong></td>
                        </tr>

                      <form action="/FNProductBorrower/make_advance_payment" id="payment" method="post" enctype="multipart/form-data">  

                        <tr>
                          <td>Upload Image</td>
                          <td><input type="file" name="payment_picture" required></td>
                        </tr>

                        <tr>
                          <td>Select Amount:</td>
                          <td>
                             <div class="form-group">
                                

                              <?php if($userInfo->status == "pre-activated" || $userInfo->status == "approved_loan"): ?>
                                 
                                  <select class="form-control" name="amount" required>
                                    <option value="1500|4|activation|starter">&#8369;1,500 for 4 Boxs</option>
                                    <option value="16000|60|activation|">&#8369;16,000 for 60 Boxs</option>
                                    <?php for($i=1; $i <= 5; $i++ ){ ?>
                                      <?php $price = 300 * $i; ?>

                                      <option value="<?php echo $price; ?>|<?php echo $i; ?>|nonactivation|Rejuve Set">&#8369;<?php echo to_number($price); ?> for <?php echo $i; ?> Rejuve Set</option>

                                    <?php } ?> 
                                      <option value="3000|10|nonactivation|Rejuve Set">&#8369;3,000 for 10 Rejuve Set</option>
                                  </select>

                              <?php else: ?>
                                  <select class="form-control" name="amount" required>
                                    <option value="1500|4|activation|starter">&#8369;1,500 for 4 Boxs</option>
                                    <option value="2100|10|nonactivation|Product Loan">&#8369;2,100 for 10 Boxs</option>
                                    <option value="16000|60|activation|silver">&#8369;16,000 for 60 Boxs</option>

                                    <?php for($i=1; $i <= 5; $i++ ){ ?>
                                      <?php $price = 250 * $i; ?>

                                      <option value="<?php echo $price; ?>|<?php echo $i; ?>|nonactivation|Rejuve Set for Activated">&#8369;<?php echo to_number($price); ?> for <?php echo $i; ?> Rejuve Set</option>

                                    <?php } ?> 
                                      <option value="2500|10|nonactivation|Rejuve Set for Activated">&#8369;2,500 for 10 Rejuve Set</option>
                                    <?php for($i=1; $i <= 10; $i++ ){ ?>
                                      <?php $price = 160 * $i; ?>

                                      <option value="<?php echo $price; ?>|<?php echo $i; ?>|nonactivation|Product Repeat purchase">&#8369;<?php echo to_number($price); ?> for <?php echo $i; ?> box of Coffee </option>

                                    <?php } ?> 
                                     
                                  </select>


                              <?php endif; ?>

                            </div>


                          </td>

                            <input type="hidden"  name="userId" value="<?php echo $userInfo->id; ?>" required>
                            </td>
                        </tr>  

                        <tr>
                          <td>Delivery Fee:</td>
                          <td><input type="number" name="delivery_fee" required></td>
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

    $("#user_name").on('submit' , function(e) {

        if($("#userid").val().length < 1) {

          $("#search_user_warning").html('You must select a user');
          $("#search_user_warning").attr("class" , 'alert alert-danger');
          console.log('ID MUST BE SET');
        }else{
          $(this).submit();
        }
        e.preventDefault();
    });

    $("#userList").on('click' , function(e)
    {
      if(e.target.classList.contains('userinfo-ajax')) {
          let userid = e.target.dataset.id;
          let fullname = e.target.dataset.fullname;

          $("#userid").val(userid);
          $("#search_user").val(fullname.trim());
          $("#userList").html('');
          e.target.remove();
      }
    });

    $("#search_user").keyup(function()
    {
        let userKey = $(this).val();

        /*if 3 characters*/
        if(userKey.length > 2) {

          $.ajax({
            method : 'post' , 
            url    : get_url('UserAjax/search_user'),
            data   : { key : userKey} , 
            success: function(response) 
            {
              response = JSON.parse(response);

               let html = ``;

              if(response == false) {
                $("#userid").val('');
                $("#userList").html('');

                 html += `<div class='userinfo-ajax'> 
                    <strong> Not Found</strong>
                 
                  </div>`;

              }else{
               

                for(let i in response) {

                  html += `<div class='userinfo-ajax' data-id='${response[i].id}' 
                  data-fullname = '${response[i].firstname} ${response[i].lastname}'> 
                    <strong> Fullname : ${response[i].firstname} ${response[i].lastname} </strong> <br/>
                    <strong> Username : ${response[i].username} </strong>
                  </div>`;
                }

                $("#userList").html(html);
              }
            }
          });
        }else{
          $("#userid").val('');
          $("#userList").html('');
        }
    });

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
</script>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>