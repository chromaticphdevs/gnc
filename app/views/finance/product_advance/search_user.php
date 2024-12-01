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
             <h1>Product Advance</h1>

            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_content">

                <form action="/FNProductBorrower/search_user" id="user_name" method="post">

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
                        <tr>
                          <td>Total Direct Referral:</td>
                          <td><h4 style="text-align: center;"><b><?php echo $userInfo->total_direct_ref; ?></b></h4></td>
                        </tr>
                        <tr>
                        <td>Number of valid ID's:</td>
                        <td><h4 style="text-align: center;"><b>

                              <?php if($userInfo->valid_id < 1 ):?>
                                 <span class="label label-warning">No Valid ID</span>
                              <?php else:?>
                                 <span class="label label-success"><?php echo $userInfo->valid_id; ?></span>
                              <?php endif;?>

                          </b></h4>
                        </td>
                        </tr>
                        <tr>
                          <td>Product Release Status:</td>
                          <td><h4 style="text-align: center;"><b>

                              <?php if($userInfo->product_release < 4 ):?>
                                 <span class="label label-info">Not Yet</span>
                              <?php else:?>
                                 <span class="label label-success">Released</span><br>
                                 <p><?php echo $userInfo->product_release." boxes"; ?><p>
                              <?php endif;?>

                            </b></h4>
                          </td>
                        </tr>
                      </table>

                          <form action="/FNProductBorrower/release_product" method="post">

                            <input type="hidden" name="userid" value="<?php echo $userInfo->id; ?>">

                            <div class="form-group">
                                 <label for="sel1">Select Box Quantity:</label>

                              <?php if($userInfo->status == "pre-activated" || $userInfo->status == "approved_loan"): ?>

                                  <select class="form-control" name="quantity" required>
                                     <option value="4">Starter 4 Boxs</option>
                                    <option value="60">Silver 60 Boxs</option>
                                    <option value="124">Gold 124 Boxs</option>
                                  </select>

                              <?php else: ?>
                                  <select class="form-control" name="quantity" required>
                                    <option value="4">Starter 4 Boxs</option>
                                    <option value="60">Silver 60 Boxs</option>
                                    <option value="124">Gold 124 Boxs</option>
                                    <option value="10">10 Boxs</option>
                                  </select>


                              <?php endif; ?>


                            </div>

                            <input type="submit" class="btn btn-success btn-sm validate-action" value="Release Product" id="release_product">

                         </form>
                  <?php endif;?>
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

    $("#release_product").on('click' , function(e)
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
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
