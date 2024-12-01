
<?php include_once VIEWS.DS.'templates/users/header.php';?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
<style type="text/css">
    span.indicator
    {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: block;
        content: '123';
    }

    span.indicator-grey
    {
        background: grey;
    }

    span.indicator-green
    {
        background: green;
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


        <div class="container">
            <section class="x_panel">
                <section class="x_container">
                <?php Flash::show(); ?>
                   
                    <?php if(isset($userList)):?>
                      <h2>User List for Deactivation</h2>
                        <table class="table" id="dataTable">
                            <thead>
                                <th>USERID</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Direct Sponsor</th>
                                <th>Upline</th>
                                <th>Position</th>
                                
                               
                            </thead>

                            <tbody>
                                <?php foreach($userList as $user) :?>
                                    <tr>
                                        <td><?php echo $user->id?></td>
                                        <td><?php echo $user->username?></td>
                                        <td><?php echo $user->firstname?></td>
                                        <td><?php echo $user->lastname?></td>
                                        <td><?php echo $user->direct_sponsor?></td> 
                                        <td><?php echo $user->upline?></td> 
                                        <td><?php echo $user->L_R?></td>                   
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <br>

                          <form action="/Account/deactivate_account"  method="post">    
                             <input type="submit" class="btn btn-warning" value="Deactivate Accounts" id="deactivate">
                          </form>
                    <?php endif;?>  
                </section>
            </section>
        </div>

        <!-- page content -->


<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();

           $("#deactivate").on('click' , function(e)
            {
               if (confirm("Are You Sure ?"))
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