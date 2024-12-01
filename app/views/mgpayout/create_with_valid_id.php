<?php $starttime = microtime(true);?> 
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

            <section class="x_panel">
                <section class="x_content">
                    <h3>Payout</h3>
                    <?php Flash::show()?>
                    <hr>
                    <?php if(!empty($forPayout['details'])) :?>
                        <div>
                            <div><strong>Previous</strong></div>
                            From : <strong><?php echo $forPayout['details']->datestart?></strong>
                            To: <strong><?php echo $forPayout['details']->dateend?></strong>
                        </div>

                        <div>
                            <div><strong>Current</strong></div>
                            From : <strong><?php echo $forPayout['details']->dateend?></strong>
                            To: <strong><?php echo date('Y-m-d h:i:s A')?></strong>
                        </div>
                        <?php else:?>
                        <div>
                            From the start until today.
                        </div>
                    <?php endif;?>
                    <section>

                        <h3>Total Payout : <?php echo to_number($forPayout['total']);?></h3>
                        <?php if(isset($payoutPercentage)) :?>
                            <h3>Payout Percentage : <?php echo $payoutPercentage?></h3>
                        <?php endif;?>
                        <form action="/MGPayout/create_payout_valid_id" method="post">
                            <div class="form-group">
                                <input type="hidden" name="amount" value="<?php echo $_GET['amount']; ?>">
                                <input type="submit"  value="&nbsp;&nbsp;Make cheque&nbsp;&nbsp;" class="btn btn-primary btn-sm verifiy-action" >
                            </div>
                        </form>
                        <br><br>
                        <!--export to excel-->
                        <form action="/MGPayout/export" method="post">
                            <input type="hidden" name="users" 
                                value="<?php echo base64_encode(serialize($forPayout['list']))?>">

                            <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
                         </form>

                    </section>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Amount Payout</th>
                                </thead>

                                <tbody>
                                    <?php $totalAmount = 0 ?>
                           
                                   
                                    <?php foreach($forPayout['list'] as $key => $payout) :?>
                                       
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $payout->username?></td>
                                                <td><?php echo $payout->fullname?></td>
                                                <td><?php echo to_number($payout->amount)?></td>
                                            </tr>

                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <?php if(isset($payins) &&!empty($payins)) :?>
                                <h3>Total Payin : <?php echo to_number($payins['total'])?></h3>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Origin</th>
                                        <th>Date and time</th>
                                    </thead>

                                    <tbody>
                                        <?php foreach($payins['list'] as $key => $row) :?>
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $row->amount?></td>
                                                <td><?php echo $row->type?></td>
                                                <td><?php echo $row->origin?></td>
                                                <td><?php echo $row->dateandtime?></td>
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                            <?php endif;?>
                        </div>
                    </div>
                </section>
            </section>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

<?php $endtime = microtime(true);?>

<?php printf("Page loaded in %f seconds", $endtime - $starttime );?>