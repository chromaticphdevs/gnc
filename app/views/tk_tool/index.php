<?php build('content')?>
    <div class="container">
        <?php Flash::show()?>
        <h1>Timekeeping</h1>

        <img src="<?php echo GET_PATH_UPLOAD.DS.$tkData->qrcode?>" alt="">
        <div class="row">
            <div class="col-md-4">
                <p><?php echo $userData['secret_key']?></p>
                <h4>TK SECRET KEY</h4>
                <h4>Timekeeping</h4>
                <div class="form">
                    <?php
                        Form::open([
                            'method' => 'post',
                            'action' => '/API_Timekeeping/register'
                        ]);

                        Form::hidden('userData' , $userEncoded);
                    ?>

                    <div class="form-group">
                        <?php
                            Form::label('Clock');
                            Form::submit('' , ' Register ' , [ 'class' => 'btn btn-primary btn-sm']);
                        ?>
                    </div>
                    <?php Form::close()?>
                </div>

                <div class="form">
                    <?php
                        Form::open([
                            'method' => 'post',
                            'action' => '/API_Timekeeping/clockIn'
                        ]);

                        Form::hidden('secret_key' , $userData['secret_key']);
                        Form::hidden('domain_id' , $userData['domain_id']);
                    ?>

                    <div class="form-group">
                        <?php
                            Form::label('Clock In');
                            Form::submit('' , 'Clock In');
                        ?>
                    </div>
                    <?php Form::close()?>
                </div>

                <div class="form">
                    <?php
                        Form::open([
                            'method' => 'post',
                            'action' => '/API_Timekeeping/cloutOut'
                        ]);

                        Form::hidden('secret_key' , $userData['secret_key']);
                        Form::hidden('domain_id' , $userData['domain_id']);
                    ?>

                    <div class="form-group">
                        <?php
                            Form::label('Clock Out');
                            Form::submit('' , 'Clock Out');
                        ?>
                    </div>
                    <?php Form::close()?>
                </div>
            </div>
            
            <div class="col-md-8">

                <?php if(!empty($results)):?>
                    <h4>Time Sheets</h4>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Time in</th>
                            <th>Time out</th>
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </thead>

                        <tbody>
                            <?php foreach($results->timesheets as $key => $sheet) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $sheet->time_in?></td>
                                <td><?php echo $sheet->time_out?></td>
                                <td><?php echo $sheet->duration?></td>
                                <td><?php echo $sheet->amount?></td>
                                <td><?php echo $sheet->status?></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>

                    <h4>Logs</h4>

                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Punch Time</th>
                            <th>Type</th>
                        </thead>

                        <tbody>
                            <?php foreach($results->logs as $key => $log) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $log->punch_time?></td>
                                    <td><?php echo $log->type?></td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/layout')?>