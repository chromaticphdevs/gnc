<?php build('content') ?>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Timekeeper</h4>
            <?php if(isset($log)) :?>
                <?php if($isLoggedIn) :?>
                    <h1>LOGIN TIME : <span id="loginTime"><?php echo $log->clock_in_time?></span></h1>
                    <h1>CURRENT TIME : <span id="currentTime"></span></h1>
                    <h1>DURATION : <span id="loginTimeDuration"></span></h1>
                    <a href="/TimekeepingController/clockOut" class="btn btn-primary">Logout</a>
                <?php else :?>
                    <a href="/TimekeepingController/clockIn" class="btn btn-primary">Login</a>
                <?php endif?>
            <?php endif?>
        </div>

        <div class="card-body">
            <?php $total = 0?>
            <div class="table-responsive">
                <table class="table-bordered table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Clock In Time</th>
                        <th>Clock Out Time</th>
                        <th>Duration</th>
                        <th>Rate per hour</th>
                        <th>Amount</th>
                    </thead>

                    <tbody>
                        <?php foreach($timesheets as $key => $row) :?>
                            <?php $total += $row->total_amount?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->full_name?></td>
                                <td><?php echo $row->clock_in_time?></td>
                                <td><?php echo $row->clock_out_time?></td>
                                <td><?php echo minutesToHours($row->duration_in_minutes)?></td>
                                <td><?php echo $row->rate_per_hour?></td>
                                <td><?php echo $row->total_amount?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
                <h1>Total : <?php echo $total?></h1>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
    <script>
        let clockinDateTime = new Date($("#loginTime").html());
        setInterval(function(){
            let currentDataTime = new Date();

            let differenceInMinutes = dateDifferenceInMinutes(clockinDateTime,currentDataTime);
            let minutesTohoursText = minutesToHours(differenceInMinutes);
            $("#currentTime").html(currentDataTime.getHours() + ':' +currentDataTime.getUTCMinutes() + ':' + currentDataTime.getSeconds());
            $("#loginTimeDuration").html(minutesTohoursText);
        },1000);
    </script>
<?php endbuild()?>
<?php occupy('templates/layout')?>

<!-- dateDifferenceInMinutes -->
<!-- minutesToHours -->
