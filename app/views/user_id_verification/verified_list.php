<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Id List'))?>
            <div class="card-body">
              <div class="table-responsive">
                <table id="users" class="table table-bordered">
                  <thead>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>ID Type</th>
                    <th>Date & time</th>
                    <th>Verifier Name</th>
                    <th>Action</th>                   
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
                        <td><?php echo $row->verifier_name; ?> </td>
                        <td><a href="/UserIdVerification/preview_id_image/<?php echo $row->uploaded_id?>" class="btn btn-primary btn-sm">Preview Image</a></td>
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
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>