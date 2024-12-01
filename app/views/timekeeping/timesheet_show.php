<?php build('content') ?>
    <?php $classTarget = get_token_random_char(12)?>
    <div class="card">
        <div class="card-header">
            <h4><strong><?php echo $account->firstname . ' ' .$account->lastname?>'s</strong> Time sheet </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Duration</th>
                        <th>Rate</th>
                        <th>Allowance</th>
                        <th>Status</th>
                    </thead>

                    <tbody>
                        <tr>
                            <td><?php echo date_long($timesheet->time_in, 'M d,Y h:i:s A')?></td>
                            <td><?php echo date_long($timesheet->time_out, 'M d,Y h:i:s A')?></td>
                            <td><?php echo $timesheet->duration?>mins</td>
                            <td><?php echo $timesheet->meta->rate?></td>
                            <td><?php echo $timesheet->amount?></td>
                            <td><span class="<?php echo $classTarget?>"><?php echo $timesheet->status?></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h5>Logs</h5>
            <?php foreach($logs as $key =>$row) :?>
                <p><?php echo $row->punch_time .'' . "($row->type)"?></p>
            <?php endforeach?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Task Photos</h4>
        </div>

        <div class="card-body">
            <?php foreach($taskPhotos as $key => $photo) :?>
                <div style="display:inline-block; margin:15px">
                    <img src="<?php echo $photo->file_path.DS.$photo->file_name?>" style="width:300px;">
                    <div>Uploaded On : <?php echo $photo->created_at?></div>
                </div>
            <?php endforeach?>
        </div>

        <?php if(!isEqual($timesheet->status , 'approved')) :?>
        <a href="#" class="btn btn-primary btn-lg btn-approve" data-sheetid="<?php echo $timesheet->id?>" 
            data-target=".<?php echo $classTarget?>"> Approve </a>
        <?php endif?>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
    <script type="text/javascript">
        
        $( document ).ready( function() 
        {
            let endpoint = 'https://app.breakthrough-e.com/api/timesheet/approve';
            // let endpoint = 'http://dev.bktktool/api/timesheet/approve';
            
            $('.btn-approve').click( function(evt) {

                let sheetId = $(this).data('sheetid');

                var target  = $(this).data('target');

                $.post(endpoint , {
                    id : sheetId
                }, function(response)
                {
                    if(response.data)
                        window.location = get_url(`timekeeping/timesheetShow/${response.data.id}`);
                });
            });
        });
    </script>
<?php endbuild()?>

<?php occupy('templates/layout')?>