<?php build('content') ?>
  <div class="container-fluid">
    <div class="card">
      <?php echo wCardHeader(wCardTitle('Staff Requests'))?>
      <div class="card-body">
        <?php Flash::show()?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Name</th>
              <th>Username</th>
              <th>Status</th>
              <th>Action</th>
            </thead>

            <tbody>
              <?php foreach($list as $key => $row) :?>
                <tr>
                  <td><?php echo ++$key?></td>
                  <td><?php echo $row->name?></td>
                  <td><?php echo $row->fn_username; ?></td>
                  <td>
                      <?php if($row->fn_status == 'pending'): ?>
                        <span class="label label-primary"><?php echo $row->fn_status?></span>
                      <?php elseif($row->fn_status == 'canceled'): ?>
                        <span class="label label-danger"><?php echo $row->fn_status?></span>
                      <?php elseif($row->fn_status == 'approved'): ?>
                        <span class="label label-success"><?php echo $row->fn_status?></span>
                      <?php endif; ?>
                  </td>
                  <td>
                      <?php if($row->fn_status == 'pending'): ?>
                        <form action="/FNAccount/change_request_status" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?php echo $row->fn_id?>">
                          <input type="hidden" name="status" value="cancel">
                          <input type="submit" id="cancel" value="    Cancel     " class="btn btn-danger btn-sm">
                        </form>

                        <form action="/FNAccount/change_request_status" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?php echo $row->fn_id?>">
                          <input type="hidden" name="status" value="approved">
                          <input type="submit" id="approved" value="Approved" class="btn btn-success btn-sm">
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
<?php endbuild()?>

<?php build('scripts') ?>
<script defer>
  $( document ).ready(function() {

    $("#approved").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

     $("#cancel").on('click' , function(e)
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
<?php endbuild()?>

<?php occupy()?>
