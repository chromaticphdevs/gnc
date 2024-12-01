
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
            <section class="x_panel x_well">
            	<h1>Breakthrough Top Earners <?php echo $top;?></h1>
                <?php Flash::show(); ?>
                <form method="get" action="/Sne/get_toppers" class="form-inline">
                    <div class="form-group">
                        <label for="#">Set Top</label>
                        <select name="top" id="" class="form-control">
                            <?php for($i = 10 ; $i <= 100; $i += 10) :?>
                                <?php $selected = $i == $top ? 'selected' : '' ?>
                                <option value="<?php echo $i?>" <?php echo $selected?>>
                                   Select top <?php echo $i?>
                                </option>
                            <?php endfor?>
                            <option value="1000">
                                Select top 1000
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Number of days</label>
                        <input type="number" name="no_of_days" class="form-control" 
                            value="<?php echo $_GET['no_of_days'] ?? 1?>" >
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-sm" value="Set Top">
                    </div>
                </form>
            </section>
            <hr>


            <section>
                <h3>Top Earners.</h3>
                <div class="row">
                    <section class="col-md-4">
                        <section class="x_panel x_well">
                            <h4>DRC</h4>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Amount</th>
                                </thead>

                                <tbody>

                                    <?php $drcTotal = 0?>
                                    <?php foreach($commissions['directSponsors'] as $key => $row) :?>

                                        <?php $drcTotal += $row->total?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->username?></td>
                                            <td><?php echo $row->fullname?></td>
                                            <td><?php echo $row->total?></td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </section>
                    </section>

                    <section class="col-md-4">
                        <section class="x_panel x_well">
                            <h4>UNILEVEL</h4>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Amount</th>
                                </thead>

                                <tbody>
                                    <?php $unilvlTotal = 0?>
                                    <?php foreach($commissions['unilevels'] as $key => $row) :?>
                                        <?php $unilvlTotal += $row->total?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->username?></td>
                                            <td><?php echo $row->fullname?></td>
                                            <td><?php echo $row->total?></td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </section>
                    </section>


                    <section class="col-md-4">
                        <section class="x_panel x_well">
                            <h4>MENTOR</h4>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Amount</th>
                                </thead>

                                <tbody>
                                    <?php $mentorTotal = 0?>
                                    <?php foreach($commissions['mentors'] as $key => $row) :?>
                                        <?php $mentorTotal += $row->total?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->username?></td>
                                            <td><?php echo $row->fullname?></td>
                                            <td><?php echo $row->total?></td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </section>
                    </section>
                </div>
                <hr>
                <section class="col-md-4">
                    <section class="x_panel x_well">
                        <h4>BINARY</h4>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Amount</th>
                            </thead>

                            <tbody>
                                <?php $binaryTotal = 0?>
                                <?php foreach($commissions['binary'] as $key => $row) :?>
                                    <?php $binaryTotal += $row->total?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $row->username?></td>
                                        <td><?php echo $row->fullname?></td>
                                        <td><?php echo $row->total?></td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </section>
                </section>
    

                <section class="col-md-4">
                    <section class="x_panel x_well">
                        <h4>Overall</h4>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Amount</th>
                            </thead>

                            <tbody>
                                <?php $binaryTotal = 0?>
                                <?php foreach($commissions['overAll'] as $key => $row) :?>
                                    <?php $binaryTotal += $row->total?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $row->username?></td>
                                        <td><?php echo $row->fullname?></td>
                                        <td><?php echo $row->total?></td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </section>
                </section>

                <section class="col-md-4">
                    <section class="x_panel x_well">
                        <h4>Over All</h4>
                        <ul>
                            <li>Drc : <?php echo to_number($drcTotal)?></li>
                            <li>Unilevel : <?php echo to_number($unilvlTotal)?></li>
                            <li>Mentor : <?php echo to_number($mentorTotal)?></li>
                            <li>Binary : <?php echo to_number($binaryTotal)?></li>
                        </ul>

                        <h4>Total : <?php echo to_number(($drcTotal + $unilvlTotal + $mentorTotal + $binaryTotal))?></h4>
                    </section>

                </section>
                   <section class="col-md-4">
                    <section class="x_panel x_well">
                        <h4>Over All  User Activated</h4>
                        <ul>

                            <li>starter : <?php echo $user_activated_count[0][0]?></li>
                            <li>bronze : <?php echo $user_activated_count[1][0]?></li>
                            <li>silver : <?php echo $user_activated_count[2][0]?></li>
                            <li>gold : <?php echo $user_activated_count[3][0]?></li>
                            <li>platinum : <?php echo $user_activated_count[4][0]?></li>
                            <li>diamond : <?php echo $user_activated_count[5][0]?></li>
                        </ul>

                        <h4>Total : <?php echo $user_activated_count[6][0]?></h4>
                    </section>
                    
                </section>
                   <section class="col-md-4">
                    <section class="x_panel x_well">
                        <h4>Total Amount per package</h4>
                        <ul>
                            <li>starter : <?php echo to_number(($amount_code_used_byLevel[0][0])); ?></li>
                            <li>bronze : <?php echo to_number(($amount_code_used_byLevel[1][0])); ?></li>
                            <li>silver : <?php echo to_number(($amount_code_used_byLevel[2][0])); ?></li>
                            <li>gold : <?php echo to_number(($amount_code_used_byLevel[3][0])); ?></li>
                            <li>platinum : <?php echo to_number(($amount_code_used_byLevel[4][0])); ?></li>
                            <li>diamond : <?php echo to_number(($amount_code_used_byLevel[5][0])); ?></li>
                        </ul>

                         <h4>Total : <?php echo to_number(($amount_code_used_byLevel[6][0])); ?></h4>
                    </section>
                    
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