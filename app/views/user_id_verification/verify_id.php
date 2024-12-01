<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Id Verification'))?>
            <div class="card-body">
            <a class="btn btn-primary btn-sm" href="/UserIdVerification/verified_list/verified">Approved ID List</a>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a class="btn btn-primary btn-sm" href="/UserIdVerification/verified_list/deny">Denied ID List</a>
              <div style="overflow-x:auto;">
              <table class="table table-bordered" id="users">
                <thead>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>ID Type</th>
                    <th>Date & time</th>
                    <th>Uploaded ID</th>
                    <th></th>
                    <th></th>
                   
                </thead>

                <tbody>
                    <?php $start = 1;?>
                    <?php foreach($result as $key => $row) :?>
                    <tr>
                        <td><?php echo $start++?></td>
                        <td><?php echo $row->username?></td>
                        <td><?php echo $row->fullname?></td>
                     
                        <td><?php echo $row->type?></td>
                        <td>
                          <?php
                              $date=date_create($row->date_time);
                              echo date_format($date,"M d, Y");
                              $time=date_create($row->date_time);
                              echo date_format($time," h:i A");
                            ?>
                        </td>
                        <td>
                          <a style="display: none;" class="btn btn-success btn-sm" href="/UserIdVerification/preview_id_image/?filename=<?php echo $row->id_card; ?>&filename2=<?php echo $row->id_card_back; ?>&fullname=<?php echo $row->fullname?>&type=<?php echo $row->type?>&id=<?php echo $row->uploaded_id?>&address=<?php echo str_replace('#', '', $row->address); ?>" 
                          >Preview Image</a>

                          <a href="/UserIdVerification/preview_id_image/<?php echo $row->uploaded_id?>" class="btn btn-primary btn-sm">Preview Image</a>
                        </td>
                        <td>
                          <?php if(isEqual(whoIs('type'), 1)): ?>
                               <a class="btn btn-success btn-sm" href="/UserIdVerification/verify_id/<?php echo $row->uploaded_id?>">Verify</a>
                          <?php endif; ?>
                        </td>

                         <td>
                            <form action="/UserIdVerification/deny_id"  method="post">
                                <div class="form-group">

                                      <input type="hidden" name="id" value="<?php echo $row->uploaded_id?>">
                                      <select class="form-control" name="comment" required>
                                        <option value="Image is Unclear">Image is Unclear</option>
                                        <option value="Invalid ID">Invalid ID</option>
                                        <option value="Unmatch">Unmatch</option>
                                      </select>

                                   <input type="submit" class="btn btn-danger btn-sm validate-action" value="Deny" id="deny_btn">
                                </div>

                            </form>
                        </td>
                        
                    </tr>
                    <?php endforeach?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<script defer>
  $(document).ready(function() {
    $("#deny_btn").on('click' , function(e)
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

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>