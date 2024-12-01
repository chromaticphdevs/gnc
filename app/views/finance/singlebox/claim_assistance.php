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
            <h3>Product Assistance Claim</h3>
            <?php Flash::show()?>

            <div class="container">
                <div class="x_panel">
                    <div class="x_content">

                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Code</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($codes as $key => $row) :?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $row->branch_name?></td>
                                        <td><?php echo $row->code?></td>
                                        <td><?php echo $row->customer?></td>
                                        <td><?php echo $row->amount?></td>
                                        <td><?php echo $row->status?></td>
                                        <td>
                                            <a href="/FNSinglebox/preview/<?php echo $row->id?>">Preview</a>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>