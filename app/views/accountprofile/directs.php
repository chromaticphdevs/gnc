<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo WordLib::get('referrals')?></h4>
                <a href="/AccountProfile/">Back to Profile Page</a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                        </thead>

                        <tbody>
                            <?php foreach($directs as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->firstname . ' ' .$row->lastname?></td>
                                    <td><?php echo $row->email?></td>
                                    <td><?php echo $row->mobile?></td>
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