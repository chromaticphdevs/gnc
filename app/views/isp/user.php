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
        	<h1>ISP</h1>
            <?php Flash::show(); ?>
            <h3>OMG COMMISSIONS</h3>

            <table class="table">
            	<thead>
            		<th>Transaction</th>
            		<th>Instance</th>
            		<th>Amount</th>
            	</thead>
            	<tbody>
                    <?php $total = 0;?>
            		<?php foreach($commission_list as $commission) :?>
                        <?php $total += $commission->total_amount; ?>
            			<tr>
            				<td><?php echo $commission->transaction?></td>
            				<td><?php echo $commission->instance?></td>
            				<td><?php echo to_number($commission->total_amount , 2)?></td>
            			</tr>
            		<?php endforeach;?>
            	</tbody>
            </table>
            <div>
                <h3>Total Amount : <?php echo to_number($total , 2) ;?></h3>
            </div>

            <h3>OMG ISP VOLUMES BINARY</h3>
            <?php extract($binary) ;?>
            <table class="table">
                <thead>
                    <th>Left Point</th>
                    <th>Right Point</th>
                    <th>Left Carry</th>
                    <th>Right Carry</th>
                    <th>Total Pair</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $left->point?></td>
                        <td><?php echo $right->point?></td>
                        <td><?php echo $left->carry?></td>
                        <td><?php echo $right->carry?></td>
                        <td><?php echo $pair?></td>
                        <td><?php echo to_number($amount , 2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>