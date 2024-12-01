<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>
    .module-container
    {

    }

    .module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px;
    }

 table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}
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
            <h3><?php echo $title; ?></h3>
            <?php Flash::show()?>

            <div class="container">
                <div class="x_panel">
                    <div class="x_content">
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <?php if($user_type == 'admin'): ?>
                                    <th>Username</th>
                                <?php endif; ?>
                                <th>Full Name</th>
                                <th>Branch</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                             <tbody>

                                   <?php foreach($unapproved_request_list as $list_unapproved) :?>
                                      <tr>
                                         <?php if($user_type == 'admin'): ?>
                                          <td><?php echo $list_unapproved->username; ?></td>
                                         <?php endif; ?>
                                            <td><?php echo $list_unapproved->fullname ?></td>
                                            <td><?php echo $list_unapproved->branch; ?></td>
                                            <td><?php echo $list_unapproved->amount; ?></td>

                                            <td>
                                                <h4><span class="label label-warning">Pending</span></h4>
                                            </td>

                                             <td>
                                                 <a class="btn btn-success btn-sm" href="/FNCashAdvance/update_status_approve_request/<?php echo $list_unapproved->loanId;; ?>">&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</a>
                                             </td>
                                      </tr>
                                    <?php endforeach;?>

                            </tbody>

                        </table>
                    </div> <br>
                     <h3>Approved List</h3>
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <?php if($user_type == 'admin'): ?>
                                    <th>Username</th>
                                <?php endif; ?>
                                <th>Full Name</th>
                                <th>Amount</th>
                                <th>Branch</th>
                                <th>Approved BY</th>
                                <th>Date & Time</th>
                                <th>Status</th>

                            </thead>

                           <tbody>

                                   <?php foreach($approved_request_list as $list_approved) :?>
                                      <tr>
                                         <?php if($user_type == 'admin'): ?>
                                          <td><?php echo $list_approved->username; ?></td>
                                         <?php endif; ?>
                                            <td><?php echo $list_approved->firstname.' '.$list_approved->lastname; ?></td>
                                            <td><?php echo $list_approved->amount; ?></td>
                                            <td><?php echo $list_approved->branch; ?></td>
                                            <td><?php echo $list_approved->approved_name; ?></td>
                                            <td>
                                                <?php
                                                    $date=date_create($list_approved->date);
                                                    echo date_format($date,"M d, Y");
                                                    $time=date_create($list_approved->time);
                                                    echo date_format($time," h:i A");
                                                  ?>
                                            </td>
                                            <td>

                                              <h4><span class="label label-success"><?php echo $list_approved->status; ?></span></h4>

                                            </td>
                                      </tr>
                                    <?php endforeach;?>

                            </tbody>
                        </table>
                    </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
