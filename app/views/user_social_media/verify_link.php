<?php build('content') ?>
<div class="container-fluid">
  <?php echo wControlButtonRight('Social Media')?>
  <div class="card">
    <?php echo wCardHeader(wCardTitle('Social Medias'))?>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered dataTable">
          <thead>
              <th>#</th>
              <th>Username</th>
              <th>Full Name</th>
              <th>Type</th>
              <th>Date & time</th>
              <th>Social Media Profile</th>
              <th>Action</th>
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
                    <a class="btn btn-success btn-sm" href="<?php echo $row->link?>" target="_blank">Preview Link</a>

                  </td>
                  <td>
                    <a class="btn btn-success btn-sm" href="/UserSocialMedia/change_status/?status=verified&id=<?php echo $row->link_id?>">Verify</a>
                  </td>

                  <td>

                    <form action="/UserSocialMedia/deny_link"  method="post">
                      <div class="form-group">

                            <input type="hidden" name="id" value="<?php echo $row->link_id?>">

                            <select class="form-control" name="comment" required>
                              <option value="Social account not valid">Social account not valid</option>
                              <option value="No facebook public share">No facebook public share</option>
                              <option value="No Breakthrough profile frame">No Breakthrough profile frame</option>
                              <option value="Does not match">Does not match</option>
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
</div>
<?php endbuild()?>

<?php occupy()?>