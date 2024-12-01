<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<?php produce('headers')?>
</head>
<body class="nav-md">
    <div class="container body">
      <?php authPanelCookie() ?>
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php combine('templates.users.profile_bar')?>
            <?php combine('templates.users.side_bar')?>
          </div>
        </div>
        <?php combine('templates.users.top_nav')?>
        <div class="right_col" role="main" style="min-height: 524px !important;">
          <div class="container-fluid"><?php produce('content')?></div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
