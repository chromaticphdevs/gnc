<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">

            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>System Updates</h3>
                        <a href="/SystemUpdateController/store" class="btn btn-primary btn-sm"> CREATE  </a>
                        <?php Flash::show()?>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Developer</th>
                                <th>Title</th>
                                <th>Time</th>
                                <th>Description</th>
                            </thead>

                            <tbody>
                                <?php foreach($updates as $key => $row) :?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $row->developer?></td>
                                        <td><?php echo $row->title?></td>
                                        <td><?php echo date('M d, Y h:i:s A' , strtotime($row->created_at));?></td>
                                        <td>
                                            <pre><?php echo $row->description?></pre>
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


 <script type="text/javascript" defer>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
