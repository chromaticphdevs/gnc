<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
  .userinfo-ajax{
    border: 1px solid #000;
    cursor: pointer;
  }

  .userinfo-ajax:hover{
    background: green;
    color: #000;
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
            <h3>Code Purchase Release</h3>

            <div class="x_content">
                  <h3>Code Information</h3>
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table">
                        <tr>
                          <td>Code</td>
                          <td><strong><?php echo $code->get_code_secret()?></strong></td>
                        </tr>
                        <tr>
                          <td>Branch</td>
                          <td><strong><?php echo $code->company?></strong></td>
                        </tr>
                        <tr>
                          <td>Company</td>
                          <td><strong><?php echo $code->company?></strong></td>
                        </tr>
                        <tr>
                          <td>DRC</td>
                          <td><strong><?php echo $code->get_drc_amount()?></strong></td>
                        </tr>
                        <tr>
                          <td>UNILEVEL</td>
                          <td><strong><?php echo $code->get_unilevel_amount()?></strong></td>
                        </tr>
                        <tr>
                          <td>BINARY</td>
                          <td><strong><?php echo $code->binary_point?></strong></td>
                        </tr>

                        <tr>
                          <td>Level</td>
                          <td><strong><?php echo $code->level?></strong></td>
                        </tr>

                        <tr>
                          <td>Max Pair</td>
                          <td><strong><?php echo $code->max_pair?></strong></td>
                        </tr>
                      </table>
                    </div>

                    <div class="col-md-3">
                      <div class="text-center" style="background: green; border: 1px solid #000; padding: 10px;">

                        <div style="background: #fff; padding: 10px;">
                          <h3>Claiming Code</h3>
                          <div>
                            <h4><?php echo $codepurchase->reference?></h4>
                            <p>Code Owner: <?php echo $userinfo->fullname?></p>
                          </div>
                          <p>Use this reference to claim your.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>