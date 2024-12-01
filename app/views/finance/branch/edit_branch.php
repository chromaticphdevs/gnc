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

            <h3>Branch Management</h3>
            <?php Flash::show()?>

            <div class="row">
              <section class="col-md-4">
                <div class="x_panel">
                  <div class="x_content">
                    <h3>Edit Branch</h3>
                    <form class="form" method="post">
                      <input type="hidden" name="branchid"  value="<?php echo $branch->id?>">
                      <div class="form-group">
                        <label for="#">Branch name</label>
                        <input type="text" name="name" 
                          value="<?php echo $branch->name?>" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="#">Address</label>
                        <input type="text" name="address" 
                          value="<?php echo $branch->address?>" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="#">Notes</label>
                        <textarea name="notes" class="form-control" rows="8" class="form-control"><?php echo $branch->notes?></textarea>
                      </div>

                      <input type="submit" name="" value="Update Branch" class="btn btn-primary btn-sm">
                      <a href="/FNBranch/make_branch" class="btn btn-primary btn-sm">Create</a>
                    </form>
                  </div>
                </div>
              </section>

              <section class="col-md-7">
                <div class="x_panel">
                  <div class="x_content">
                    <h3>Branch List</h3>
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Addres</th>
                        <th>Notes</th>
                        <th>Action</th>
                      </thead>

                      <tbody>
                        <?php foreach($branches as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->name?></td>
                            <td><?php echo $row->address?></td>
                            <td>
                              <p style="max-width: 300px;"><?php echo $row->notes?></p>
                            </td>
                            <td>
                              <a href="/FNBranch/edit_branch/<?php echo $row->id?>">Edit</a>
                            </td>
                          </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>