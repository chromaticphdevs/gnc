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
            <div class="x_panel">
                <p>
                    <strong>Read This.</strong>

                    Make your stream to public. otherwise it wont be available on our website.
                    <a href="https://www.facebook.com/live/create">Start Live!</a>
                </p>
                <div class="x_content">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="#">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Your Stream Title">
                        </div>

                        <div class="form-group">
                            <label for="#">Facebook Stream Link</label>
                            <input type="text" name="facebook_link" class="form-control" required>
                            <small><a href="#">How to start facebook live tuts.</a></small>
                        </div>

                        <div class="form-group">
                            <label for="#">Description</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                        </div>

                        <input type="submit" class="btn btn-primary btn-sm" value="Post Stream">
                    </form>
                </div>
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
