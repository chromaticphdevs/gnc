<?php

    use Classes\Loan\LoanService;
    use Services\QualifierService;
    load(['QualifierService'], APPROOT.DS.'services');
    load(['LoanService'], CLASSES.DS.'Loan');
    ?>
<?php build('content')?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Qualifiers</h4>
            <a href="/FNCashAdvance/index/">Loans</a> | 
            <a href="/FNCashAdvance/index/?page=qualifiers">Qualifiers</a> | 
            <a href="/FNCashAdvance/index/?page=qualifiers_approved">Approved Qualifiers</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>User</th>
                        <th>Upline</th>
                        <th>Direct</th>

                        <th>2 Valid Ids</th>
                        <th>2 Referrals</th>
                        <th>4 Logins</th>
                        <th>Is Qualified</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach($qualifiers as $key => $row) :?>
                            <?php
                                $referral =  QualifierService::requirementsCheck('two_referrals', $row->directs);
                                $validIds =  QualifierService::requirementsCheck('two_valid_id', $row->uploadIds);
                                $qrLogins =  QualifierService::requirementsCheck('qr_login', $row->logs);
                            ?>
                            <tr>
                                <td><?php echo $row->firstname . ' ' .$row->lastname?></td>
                                <td><?php echo $row->upline_name?></td>
                                <td><?php echo $row->direct_name?></td>
                                <td>
                                    <span title="<?php echo $validIds['msgTxt']?>"><?php echo $validIds['responseHTML']?></span>
                                    <div></div>
                                    <?php echo $validIds['html']?>
                                </td>
                                <td>
                                    <span title="<?php echo $referral['msgTxt']?>"><?php echo $referral['responseHTML']?></span>
                                    <div></div>
                                    <?php echo $referral['html']?>
                                </td>
                                <td>
                                    <span title="<?php echo $qrLogins['msgTxt']?>"><?php echo $qrLogins['responseHTML']?></span>
                                    <div></div>
                                    <?php echo $qrLogins['html']?>
                                </td>
                                <td>
                                    <?php if(($validIds['response'] && $referral['response']) && $qrLogins['response']) :?>
                                            <span class="badge" style="background-color:green">QUALIFIED</span>
                                        <?php else:?>
                                            <span class="badge" style="background-color:red">UNQUALIFIED</span>
                                    <?php endif?>
                                </td>
                                <td>
                                    <?php
                                        Form::open([
                                            'method' => 'post',
                                            'action' => '/FNCashAdvance/approveQualifier'
                                        ]);

                                        Form::hidden('user_id', $row->id);
                                        Form::hidden('loan_type', LoanService::CASH_ADVANCE);
                                        Form::hidden('approval_date', today());
                                        Form::hidden('requirements', seal([
                                            'validIds' => $validIds['msgTxt'],
                                            'qrLogins' => $qrLogins['msgTxt'],
                                            'referrals' => $referral['msgTxt'],
                                        ]));
                                        Form::hidden('approved_by', whoIs()['id']);
                                        Form::hidden('user_id', $row->id);
                                            Form::submit('', 'Approve');
                                        Form::close();
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?>
    <style>
        .list-hidden{
            display: none;
        }
    </style>
<?php endbuild()?>
<?php occupy()?>