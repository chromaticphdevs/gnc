<?php build('content') ?>
    <h4><?php echo isset($level) ? "Follow Up Levels : {$level}"  : 'Archives' ?> </h4>
    <div class="row">
        <div class="col-md-12">
            <h3>Users</h3>
            <div class="table-responsive">

                <table class="table" id="dataTable">
                    <thead>
                      <th>#</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Mobile</th>
                      <th>Network</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>ID</th>
                      <th>Facebook</th>
                      <th>Action</th>
                    </thead>

                    <tbody>

  
                        <?php $counter = 1?>
                        <?php foreach($clients as $key => $row) :?>
                            <tr>
                                <td><?php echo $counter++?></td>
                                <td><?php echo $row->fullname?></td>
                                <td><?php echo $row->username?></td>
                                <td><?php echo $row->mobile?></td>
                                <td><?php echo sim_network_identification($row->mobile); ?></td>
                                <td><?php echo $row->email?></td>
                                <td><?php echo $row->status; ?></td> 
                                <td>
                                <?php echo get_date($row->created_at , 'M d , Y h:i:s A'); ?>
                                </td>
                                <td> 
                                  <?php if($row->total_valid_id != 0): ?>
                                    <a class="btn btn-info btn-sm" 
                                        href="/UserIdVerification/user_customer_preview_id/<?php echo seal($row->id); ?>" 
                                         target="_blank" >Preview ID</a>
                                  <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(empty($row->fb_link)) :?>
                                      <label for="#">No FB Link</label>
                                    <?php else:?>
                                      <a href="<?php echo $row->fb_link->link?>" target="_blank">View Media</a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <a href="<?php echo $linksAndButtons['previewLink'].'/'.seal($row->UserId)?>" class="btn btn-primary btn-sm"> Show </a>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3>Archives</h3>
                    <ul>
                        <li> <a href="/<?php echo $endpoint?>/archives" class="btn btn-danger btn-sm">Don't Follow Up</a> </li>
                    </ul>
                    <h3>Levels</h3>
                    <ul class="list-group">

                        <li class="list-group-item"><a class="btn btn-info btn-sm" href="/<?php echo $endpoint?>/index?level=1"> Follow Up : 1</a></li>

                        <?php foreach($activeLevels as $key => $row) :?> 

                            <li class="list-group-item"><a class="btn btn-info btn-sm" href="/<?php echo $endpoint?>/index?level=<?php echo $row->level?>"> Follow Up : <?php echo $row->level?></a></li>

                        <?php endforeach?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
          "pageLength": 30
        } );
    } );
</script>
<?php endbuild()?>

<?php build('headers')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<?php endbuild()?>
<?php occupy('templates/layout')?>