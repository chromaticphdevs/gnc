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
            <!-- profile quick info -->
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
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

        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
            <h3>Create Sub Account</h3>
            <?php Flash::show()?>

            <div class="row"> 
              <div class="col-md-6">
                <form action="/geneology/create_account" method="post" onsubmit="return check_input()">
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label for="#">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder ="Username" value="" required>
                  </div>

                  <div class="col-sm-6">

                    <input type="hidden" class="form-control" name="password"  value="123456">
                    <input type="hidden" class="form-control" name="uplineid"  value="<?php echo @$_GET['uplineid']; ?>">
                    <input type="hidden" class="form-control" name="position"  value="<?php echo @$_GET['position']; ?>">
                  </div>
                </div>

                <input type="submit" class="btn btn-primary btn-sm" value="Create Account">
              </form>
              </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>


<script type="text/javascript">
  
      function check_input()
      {
        
        var special_char = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        var regExpr = /[^a-zA-Z0-9]/g;
        var username = $("#username").val();
        
        if(special_char.test(username) == true)
        {

            alert("Invalid Username. Dont use Special Characters"); 
            document.getElementById("username").value =username.replace(regExpr, "");
            document.getElementById("username").focus();
            return false;
        }


        if(username.length > 12)
        { 
          alert("Invalid! Username must have 12 letters or characters only");
          document.getElementById("username").focus();
          return false;
        }

     }

   


</script>

