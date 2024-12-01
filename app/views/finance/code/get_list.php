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
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">
            <div class="container">
              <section class="col-md-12">
                  <div class="x_panel">
                    <div class="x_content">
                      <a href="/FNCodeInventory/make_code" class="btn btn-primary">Create Codes</a>

                      <form action="" method="get">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="#">Group by Branch</label>
                            <select name="branchid" id="branchid">
                              <option value="">-All</option>
                              <?php foreach($branches as $key => $row) :?>
                                <?php $selected = $_GET['branchid'] ?? '' == $row->id ? 'selected' : ''?>
                                <option value="<?php echo $row->id?>" 
                                  <?php echo $selected?>><?php echo $row->name?></option>
                              <?php endforeach?>
                            </select>
                            <?php unset($row)?>
                          </div>
                        </div>
                      </form>
                      <?php include_once VIEWS.DS.'finance/code/tmp/activation_codes.php';?>
                    </div>
                  </div>
              </section>
            </div>
        </div>
        <!-- page content -->

<script defer>
  $( document ).ready(function(){

    $("#branchid").change(function(e){

      window.location = get_url(`activation/create_code/?branchid=${$(this).val()}`);
    });
  });
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>