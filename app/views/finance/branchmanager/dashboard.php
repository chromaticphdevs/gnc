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
            <h3><?php echo $title?></h3>
            <?php Flash::show()?>

            <?php if(Session::check('USERSESSIOM')):?>
            <form action="">
              <select name="" id="branches">
                <option value="">-Select Branch</option>
                <option value="all">All</option>
                <?php foreach($branches as $key => $row) :?>
                  <option value="<?php echo $row->id?>">
                    <?php echo $row->name?>
                  </option>
                <?php endforeach?>
              </select>
            </form>
            <?php endif?>
            <div class="x_panel">
              <div class="x_content">
                <table class="table">
                  <thead>
                    <th>#</th>
                    <th>Branch</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date and Time</th>
                  </thead>

                  <tbody>
                    <?php $totalCash = 0?>
                    <?php foreach($cashInventories as $key => $row) :?>
                       <?php $totalCash += $row->amount?>
                      <tr>
                        <td><?php echo ++$key?></td>
                        <td><?php echo $row->branch_name?></td>
                        <td><?php echo $row->amount?></td>
                        <td><?php echo $row->description?></td>
                        <td><?php echo $row->created_at?></td>
                      </tr>
                    <?php endforeach?>
                  </tbody>
                </table>
                <h3>Total Amount : <?php echo to_number($totalCash)?></h3>
              </div>
            </div>
        </div>
        <!-- page content -->

<script defer>
  $( document ).ready(function(){

      $("#branches").change(function(e) {

        let branchid = $(this).val();

        window.location = get_url(`FNCashInventory/get_list/?branchid=${branchid}`);
      });
  });
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>