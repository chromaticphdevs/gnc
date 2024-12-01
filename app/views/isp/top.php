
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
        
        <div class="container">
            <?php Flash::show(); ?>
        	<h1>ISP TOP <?php echo $level;?></h1>
            
            <table class="table" id="dataTable">
                <thead>
                    <th></th>
                    <th>Userid</th>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Binary</th>
                    <th>Referral</th>
                    <th>Unilevel</th>
                    <th>Total</th>
                </thead>

                <tbody>
                    <?php $counter = 0;?>

                    <?php $totalAmount = 0?>
                    <?php foreach($isp_list as $list) :?>
                        <?php if($counter < $level): ?>
                        <?php $counter++;?>
                        <tr>
                            <td><?php echo $counter;?></td>
                            <td><?php echo $list->user_id?></td>
                            <td><?php echo $list->username?></td>
                            <td><?php echo $list->fullname?></td>
                            <?php foreach($list->commission as $com):?>
                                <?php $totalAmount += $com->amount?>
                                <?php if($com->transaction == 'referral') :?>
                                    <td>
                                        <strong><?php echo $com->amount?></strong>
                                    </td>     
                                <?php endif;?>
                                <?php if($com->transaction == 'binary') :?>
                                    <td>
                                        <strong><?php echo $com->amount?></strong>
                                    </td>     
                                <?php endif;?>
                                <?php if($com->transaction == 'unilevel') :?>
                                    <td>
                                        <strong><?php echo $com->amount?></strong>
                                    </td>     
                                <?php endif;?>

                            <?php endforeach;?>
                            <td><?php echo to_number($list->total_amount)?></td>
                        </tr>
                        <?php else:?>
                        <?php break;?>
                    <?php endif;?>
                    <?php endforeach;?>
                </tbody>
            </table>

            <div>
                <h3>Total Amount : <?php echo to_number($totalAmount)?></h3>
            </div>
        </div>

        <!-- page content -->


<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>