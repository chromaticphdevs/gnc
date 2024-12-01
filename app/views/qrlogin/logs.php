<?php
    use Classes\Loan\LoanService;
    use Services\QualifierService;
    load(['QualifierService'], APPROOT.DS.'services');
    load(['LoanService'], CLASSES.DS.'Loan');
?>
<?php build('content')?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Logged Today</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Group</th>
                                <th>DateTime</th>
                            </thead>

                            <tbody>
                                <?php foreach($logs['today'] as $key => $row) :?>
                                    <tr>
                                        <td><?php echo $row->firstname . ' '.$row->lastname?></td>
                                        <td><?php echo $row->address?></td>
                                        <td><?php echo $qrLoginService->getGroups($row->group_id ?? 'xxx')?></td>
                                        <td><?php echo $row->date_time?></td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>
                <div class="card-body">
                    <h4>Overall</h4>
                    <h1>Upnext...</h1>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Logins</h4>
                    <div class="mt-2">
                        <form action="">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <?php
                                        Form::label('Start Date');
                                        Form::date('start_date', '2022-01-01', [
                                            'class' => 'form-control',
                                            'required' => true
                                        ])
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                        Form::label('End Date');
                                        Form::date('end_date', get_date(today()) , [
                                            'class' => 'form-control',
                                            'required' => true
                                        ])
                                    ?>
                                </div>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <input type="submit" name="log_filter" value="Apply Filter" class="btn btn-sm btn-primary">
                                <?php if(isset($_GET['log_filter'])) :?>
                                    <a href="?" class="btn btn-warning btn-sm">Remove Filter</a>
                                <?php endif?>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Valid Ids</th>
                                <th>Referrals</th>
                                <th>Logins</th>
                                <th>Recent</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php foreach($qualifiers as $key => $row) :?>
                                    <?php
                                        if($row->firstname[0] == '*')
                                            continue;
                                    ?>
                                    <?php
                                        $referral =  QualifierService::requirementsCheck('two_referrals', $row->directs);
                                        $validIds =  QualifierService::requirementsCheck('two_valid_id', $row->uploadIds);
                                        $qrLogins =  QualifierService::requirementsCheck('qr_login', $row->logs);
                                    ?>
                                    <tr>
                                        <td><?php echo $row->firstname . ' ' .$row->lastname?></td>
                                        <td>
                                            <?php if($validIds['msgTxt'] > 0) :?>
                                                <div>
                                                    <a href="/UserIdVerification/customerPublicView/<?php echo seal($row->id)?>"><?php echo $validIds['msgTxt']?></a>
                                                </div>
                                            <?php else:?>
                                                <div><?php echo $validIds['msgTxt']?></div>
                                            <?php endif?>
                                        </td>
                                        <td>
                                            <div><?php echo $referral['msgTxt']?></div>
                                        </td>
                                        <td>
                                            <div><?php echo $qrLogins['msgTxt']?></div>
                                        </td>
                                        <td><?php echo $row->last_log?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">Release</button>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div> 

                    
                    <!-- <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Logins</th>
                                <th>Referrals</th>
                                <th>Id's</th>
                            </thead>

                            <tbody>
                                <?php foreach($logs['groupedByUsers'] as $key => $userLogs) :?>
                                    <?php $username = $userLogs['username']?>
                                    <?php $recent = end($userLogs['logins'])?>
                                    <tr>
                                        <td><?php echo $username?></td>
                                        <td><?php echo count($userLogs['logins'])?></td>
                                        <td>
                                            <?php echo $recent->date_time?>
                                            <div></div>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>