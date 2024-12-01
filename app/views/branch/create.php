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
            <h3>Branch Create and List</h3>
            <?php Flash::show()?>
            <div class="row">
              <section class="col-md-4">
                <form class="form" action="/branch/create" method="post">
                  <div class="form-group">
                    <label for="#">Branch name</label>
                    <input type="text" name="branch_name" value="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="#">Address</label>
                    <input type="text" name="branch_address" value="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="#">Notes</label>
                    <textarea name="branch_address"
                    class="form-control" rows="8" class="form-control"></textarea>
                  </div>

                  <input type="submit" name="" value="Create Branch" class="btn btn-primary btn-sm">
                </form>
              </section>

              <section class="col-md-7">
                <table class="table">
                  <thead>
                    <th>#</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Notes</th>
                  </thead>

                  <tbody>
                    <?php foreach($branches as $key => $row) :?>
                      <tr>
                        <td><?php echo $row->branch_name?></td>
                        <td><?php echo $row->address?></td>
                        <td><?php echo $row->note?></td>
                      </tr>
                    <?php endforeach;?>
                  </tbody>
                </table>
              </section>
            </div>
        </div>
        <!-- page content -->

<script defer>
  $( document ).ready(function()
{
  $("#branches").change(function()
{
    let branchid = $(this).val();

    window.location = get_url(`Branch/branch_dashboard/?branchid=${branchid}`)
});
});
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
