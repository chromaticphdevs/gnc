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

            <?php Flash::show()?>
             <h1>Expense Request</h1>

              <div class="x_panel">
                <div class="x_content">
                  <div class="col-md-4">
                    <br>
                    <form action="/Expense/make_request" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                          <label for="#">Amount</label>
                          <input type="number"  name="amount" class="form-control" required>
                          <br>
                          <label for="#">Description</label>
                          <textarea name="note" class="form-control" rows="5" required></textarea>
                          <br>
                          <label for="#">Select Image</label>
                          <input type="file" name="file" class="form-control" required>
                        </div>

                        <input type="submit" class="btn btn-primary btn-sm validate-action" value="Make Request" id="request">

                     </form>
                  </div>

                  <div class="col-md-8">
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Auditor Note</th>
                        <th>Action</th>
                      </thead>

                      <tbody>
                        <?php foreach($requestList as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->amount?></td>
                            <td><?php echo $row->note; ?></td>
                            <td>
                                <?php if($row->status == 'pending'): ?>
                                  <span class="label label-primary"><?php echo $row->status?></span>
                                <?php elseif($row->status == 'canceled'): ?>
                                  <span class="label label-danger"><?php echo $row->status?></span>
                                <?php elseif($row->status == 'approved'): ?>
                                  <span class="label label-success"><?php echo $row->status?></span>
                                <?php else: ?>
                                  <span class="label label-default"><?php echo $row->status?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row->status_note; ?></td>
                            <td>
                                <?php if($row->status == 'pending'): ?>
                                  <form action="/Expense/change_status" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row->id?>">
                                    <input type="hidden" name="status" value="canceled">
                                    <input type="hidden" name="note" value="user cancel">
                                    <input type="submit"  value="Cancel" class="btn btn-danger btn-sm">
                                  </form>
                                <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>


<script defer>
  $( document ).ready(function() {

    $("#request").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

  });


</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

