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

            <h3>Code Inventory</h3>
            <?php Flash::show()?>

            <div class="container">
              <div class="row">
              <section class="col-md-5">
                <div class="x_panel">
                  <div class="x_content">
                    <h3>Make Code Library</h3>
                    <form class="form" method="post">

                      <div class="row form-group">
                        <div class="col-md-4">
                          <label for="#">Name</label>
                          <input type="text" name="name" value="" class="form-control">
                        </div>
                        <div class="col-md-4">
                          <label for="#">Box EQ</label>
                          <input type="text" name="box_eq" value="" class="form-control">
                          <small>Box Equivalent.</small>
                        </div>

                        <div class="col-md-4">
                          <label for="#">Amount</label>
                          <input type="text" name="amount" value="" class="form-control">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-md-4">
                          <label for="#">DRC Amount</label>
                          <input type="text" name="drc_amount" value="" class="form-control">
                        </div>


                     

                        <div class="col-md-4">
                          <label for="#">BINARY points</label>
                          <input type="text" name="binary_point" value="" class="form-control">
                        </div>

                        <div class="col-md-4">
                          <label for="#">Max Pair</label>
                          <input type="text" name="max_pair" value="" class="form-control">
                        </div>
                      </div>


                      <div class="row form-group">
                        <div class="col-md-4">
                          <label for="#">Activation Level</label>
                          <select name="level" class="form-control" required>
                            <option value="">--Select</option>
                            <?php foreach($activationLevels as $row) :?>
                              <option value="<?php echo $row?>">
                                <?php echo $row?>
                              </option>
                            <?php endforeach;?>
                          </select>
                        </div>

                        <div class="col-md-4">
                          <label for="#">Distribution</label>
                          <input type="text" name="distribution" value="" class="form-control"> 
                        </div>

                    

                        <div class="col-md-4">
                          <label for="#">UNILEVEL Amount</label>
                          <input type="text" name="unilevel_amount" value="" class="form-control">
                        </div>


                      </div>
                      <input type="submit" name="" value="Make Code Library" class="btn btn-primary btn-sm">
                    </form>
                  </div>
                </div>
              </section>

              <section class="col-md-6">
                <div class="x_panel">
                  <div class="x_content">
                    <h3>Code Libraries</h3>
                    <form action="/FNCodeInventory/generate_codes" method="post">
                      <div class="row form-group">
                        <div class="col-md-6">
                          <label for="#">Select Activation Code</label>
                            <select name="codeid" id="" class="form-control" required>
                              <option value="">--Select Activation Code</option>
                              <?php foreach($codeStorages as $key => $row) :?> 
                                <option value="<?php echo $row->id?>">
                                  <?php echo $row->name?>
                                </option>
                              <?php endforeach?>
                            </select>
                        </div>

                        <div class="col-md-6">
                          <label for="#">Branches</label>
                            <select name="branchid" class="form-control">
                              <option value="">--Select Branch</option>
                              <?php foreach($branches as $key => $row) :?>
                                <option value="<?php echo $row->id?>">
                                  <?php echo $row->name?>
                                </option>
                              <?php endforeach;?>
                            </select>
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-md-6">
                          <label for="#">Company</label>
                            <select name="company" class="form-control">
                              <option value="">--Select Company</option>
                              <?php foreach($companies as $key => $row) :?>
                                <option value="<?php echo $row?>">
                                  <?php echo $row?>
                                </option>
                              <?php endforeach;?>
                            </select>
                        </div>

                        <div class="col-md-6">
                          <label for="#">Quantity</label>
                          <input type="number" name="quantity" class="form-control">
                          <small>Quantity of codes that will be generated.</small>
                        </div>
                      </div>

                      <input type="submit" class="btn btn-primary btn-sm" value="Generate Codes">
                    </form>
                  </div>
                </div>
              </section>
              </div>

              <section class="col-md-12">
                  <div class="x_panel">
                    <div class="x_content">
                      <h3>Codes</h3>
                      <a href="?codes=activation_codes" class="btn btn-info btn-sm">Code Information</a>
                      <a href="?codes=code_libraries" class="btn btn-info btn-sm">Generated Codes</a>

                      <?php if(isset($_GET['codes'])) :?>
                        <?php
                          $codeView = $_GET['codes'];

                          if($codeView == 'activation_codes'){
                            include_once VIEWS.DS.'finance/code/tmp/activation_codes.php';
                          }

                          if($codeView == 'code_libraries'){
                            include_once VIEWS.DS.'finance/code/tmp/library_codes.php';
                          }
                        ?>
                        <?php else:?>
                        <?php include_once VIEWS.DS.'finance/code/tmp/activation_codes.php';?>
                      <?php endif;?>
                    </div>
                  </div>
              </section>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>