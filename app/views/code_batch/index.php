<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Batches</h4>
            <?php Flash::show()?>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Batch</th>
                    <th>Codes</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach( $batches as $key => $row) : ?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->batch_code?></td>
                            <td><?php echo $row->code_length?></td>
                            <td><?php echo $row->branch_id?></td>
                            <td><?php echo $row->status?></td>
                            <td>
                                <a href="/codeBatchController/show/<?php echo $row->batch_code?>">Show</a>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>