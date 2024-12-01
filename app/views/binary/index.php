<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style type="text/css">
    .main-branch
    {
        width: 300px;
        height: 200px;
        display: inline-block;
        margin: 30px;
    }

    .main-branch .root
    {
        text-align: center;

        line-height: 100px;
        display: block;
        margin: 0px auto;
        width: 100px;
        height: 100px;
        background: yellow;
        border-radius: 50%;
    }

    .main-branch .branch
    {
        display: inline-block;
        text-align: center;
        background: blue;
        color: #fff;
        width: 100px;
        height: 100px;
        line-height: 100px;
        border-radius: 50%;
    }
    .main-branch .branch:last-child{
        float: right;
    }

    .main-branch
    {
        clear: both;
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
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"><div class=" flash_message" id="message" style="display: none;"></div>   <script>
                    setTimeout(function() {
                        $('#message').fadeOut('slow');
                    }, 3000);
                </script>
                </div>                  
            </div>
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?> 

            <!--OPTIONAL -->


                <!-- 
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        </div>
                    </div>
                 -->

            <!-- // OPTIONAL -->
            <table class="table">
                <thead>
                    <td>User</td>
                    <td>Upline</td>
                    <td>Your Position</td>
                    <td>Date</td>
                </thead>

                <tbody>
                    <?php foreach($tree as $branch) :?>
                        <tr>
                            <td><?php echo $branch->username?></td>
                            <td><?php echo $branch->upline?></td>
                            <td><?php echo $branch->L_R?></td>
                            <td><?php echo $branch->created_at?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <div>
                <h1>Branch Example</h1>

                <?php for($i = 0 ; $i < 10 ; $i++) : ?>
                <div class="main-branch">
                    <div class="root">
                        Eg-root
                    </div>
                    <div class="branch left">
                        EG-left
                    </div>
                    <div class="branch right">
                        EG-right
                    </div>
                </div>
                <?php endfor;?>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>