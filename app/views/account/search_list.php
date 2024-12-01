
<?php include_once VIEWS.DS.'templates/users/header.php';?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
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
        <div class="container">
            <section class="x_panel">
                <section class="x_container">
                    <h1>Search Results</h1>
                    <?php Flash::show(); ?>
                    <table class="table">
                        <thead>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Lastname</th>
                            <th>Number</th>
                            <th>Email</th>
                        </thead>

                        <tbody>
                            <?php foreach($userDetail as $user) :?>
                                <tr>
                                    <td><a href="/Account/doSearch?username=<?php echo $user->username?>&searchOption=username"><?php echo $user->username?></a></td>
                                    <td><?php echo $user->firstname?></td>
                                    <td><?php echo $user->middlename?></td>
                                    <td><?php echo $user->lastname?></td>
                                    <td><?php echo $user->mobile?></td>
                                    <td><?php echo $user->email?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </section>
            </section>
        </div>

        <!-- page content -->


<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>