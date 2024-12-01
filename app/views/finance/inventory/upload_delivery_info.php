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

                <form action="/FNItemInventory/search_user" id="user_name" method="post">

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
                          <td><h4><strong><?php echo $userInfo->fullname; ?></strong></h4></td>
                        </tr>

                        <tr>
                          <td>Email:</td>
                          <td><h4><strong><?php echo $userInfo->email; ?></strong></h4></td>
                        </tr>
                        <tr>
                          <td>Mobile Number:</td>
                          <td><h4><strong><?php echo $userInfo->mobile; ?></strong></h4></td>
                        </tr>
                      </table>

                       <h3><b>Delivery Information</b></h3>
                       <hr>
                      <form action="/FNItemInventory/upload_delivery_info" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" class="form-control" name="userid" value="<?php echo $userInfo->id; ?>">

                        <div class="form-group">
                            <h4><b>Control Number</b></h4>
                            <input type="text" class="form-control" name="control_number" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <h4><b>Back side of ID</b></h4>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                        <br>
                        <input type="submit" value="&nbsp;Save&nbsp;"
                        class="btn btn-success">
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

    /*$("#release_product").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });*/

  });


</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
