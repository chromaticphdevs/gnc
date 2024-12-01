<?php build('content') ?>
    <h4><?php echo isset($level) ? "Follow Up Levels : {$level}"  : 'Archives' ?> </h4>
    <div class="row">
        <div class="col-md-12">
            <h3>Users</h3>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Follow#</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>ID</th> 
                        <th>Social Media</th> 
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php $counter = 1?>
                        <?php foreach($clients as $key => $row) :?>
                            <tr>
                                <td><?php echo $counter++?></td>
                                <td><?php echo $row->fullname?></td>
                                <td><?php echo $row->username?></td>
                                <td><?php echo $row->follow_up_level ?? 1?></td>
                                <td><?php echo $row->mobile?></td>
                                <td><?php echo $row->email?></td>
                                <td><?php echo $row->address?></td>
                                <td> 
                                  <?php if($row->uploaded_id != 'no_id'): ?>
                                    <a class="btn btn-info btn-sm" 
                                        href="/UserIdVerification/staff_preview_id/<?php echo seal($row->id); ?>" 
                                         target="_blank" >Preview ID</a>
                                  <?php endif; ?>
                                </td>
                                 <td>
                                <?php if($row->link != 'no_link'): ?>
                                  <a class="btn btn-primary btn-sm" href="<?php echo $row->link; ?>" target="_blank">Preview</a>
                                <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/users-for-follow-up/show/<?php echo seal($row->id)?>" class="btn btn-primary btn-sm"> Show </a>
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
                        <li> <a href="/FollowUps/archives">Don't Follow Up</a> </li>
                    </ul>
                    <h3>Levels</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="/users-for-follow-up/index?level=1"> Follow Up : 1</a></li>
                        <?php foreach($activeLevels as $key => $row) :?> 
                            <li class="list-group-item"><a href="/users-for-follow-up/index?level=<?php echo $row->level?>"> Follow Up : <?php echo $row->level?></a></li>
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
          "pageLength": 20
        } );
    } );
</script>
<?php endbuild()?>

<?php build('headers')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<?php endbuild()?>
<?php occupy('templates/layout')?>