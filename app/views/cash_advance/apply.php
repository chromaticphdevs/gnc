<?php

use Classes\Loan\LoanService;
use Mpdf\Shaper\Sea;

 build('content') ?>
<?php
    $isOkayRequirements = 0;
?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Apply For <strong><?php echo to_number($amount)?></strong> Cash Advance</h4>
        </div>

        <div class="card-body">
            <h4>Requirements</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td style="width: 30%;">2 Approved Id's</td>
                        <td>
                            <?php $totalVerified = 0?>
                            <?php foreach($requirements['uploadedIds'] as $key => $row) :?>
                                <?php  if(isEqual($row->status, 'verified')) $totalVerified ++;?>
                                <ul>
                                    <li><?php echo $row->type?> | <span class="badge badge-info"><?php echo $row->status?></span></li>
                                </ul>
                            <?php endforeach?>
                        </td>
                        <td style="width: 5%">
                            <?php tmpSpanBuilder(($totalVerified > 1), $isOkayRequirements)?>
                        </td>
                    </tr>

                    <tr>
                        <td>2 Referral</td>
                        <td>
                            <ul>
                                <?php foreach($requirements['referrals'] as $key => $row) :?>
                                    <?php if($key > 3) :?>
                                        <li>....</li>
                                    <?php break?>
                                    <?php endif?>
                                    <li><?php echo $row->firstname. ' '. $row->lastname?></li>
                                <?php endforeach?>
                            </ul>
                        </td>
                        <td style="width: 5%">
                            <?php tmpSpanBuilder((count($requirements['referrals']) > 1), $isOkayRequirements)?>
                        </td>
                    </tr>

                    <tr>
                        <td>4 Logins</td>
                        <td>
                            <ul>
                                <?php foreach($requirements['qrLogins'] as $key => $row) :?>
                                    <li><?php echo $row->date_time?></li>
                                <?php endforeach?>
                            </ul>
                        </td>
                        <td style="width: 5%">
                            <?php tmpSpanBuilder((count($requirements['qrLogins']) > 0), $isOkayRequirements)?>
                        </td>
                    </tr>
                </table>
            </div>
            <h4 style="background-color: blue; padding:10px; color:#fff">Remarks : <?php echo $isOkayRequirements >= 2 ? 'Passed' : 'Failed'?></h4>
            <div class="row">
                <?php if($isOkayRequirements >= 2) :?>

                    <div style="text-align: center;">
                        <a href="/CashAdvance/agreement?amount=<?php echo seal($amount)?>&userId=<?php echo seal($userId)?>" class="btn btn-primary">Apply Loan</a>
                    </div>

                    <div class="col-md-5" style="display: none;">
                        <h4>Apply Loan</h4>
                        <?php
                            Form::open([
                                'method' => 'post'
                            ])
                        ?>
                        <div class="form-group">
                            <?php
                                Form::label('Amount');
                                Form::text('amount_to_borrow', $amount , [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'readonly' => true
                                ])
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                                Form::label('Notes to Management');
                                Form::textarea('reason', '' , [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'rows' => 3
                                ])
                            ?>
                        </div>
                        
                        <?php $allowLoan = true?>

                        <?php
                            foreach($loans as $key => $row) {
                                if(isEqual($row->status, 'pending') && isEqual($row->entry_origin, LoanService::CASH_ADVANCE)) {
                                    $allowLoan = false;
                                    break;
                                }
                            }
                        ?> 

                        <?php if($allowLoan) :?>
                            <div class="form-group">
                                <?php Form::submit('', 'Submit Loan')?>
                            </div>
                        <?php else:?>
                            <h5 class="text-warning">Wait until your loan has been approved.</h5>
                        <?php endif?>
                        <?php Form::close()?>
                    </div>
                <?php endif?>

                <?php if($loans) :?>
                    <div class="col-md-6">
                        <h4>Loans</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </thead>

                                <tbody>
                                    <?php foreach($loans as $key => $row) :?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->status?></td>
                                            <td><?php echo $row->amount?></td>
                                            <td><?php echo $row->entry_date?></td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php
    function tmpSpanBuilder($isOk, &$isOkayRequirements) {
        if ($isOk) {
            $isOkayRequirements ++;
            print <<<EOF
                <span class="badge" style="background:green">PASSED</span>
            EOF;
        } else {
            print <<<EOF
                <span class="badge" style="background:red">FAILED</span>
            EOF;
        }
    }
?>
<?php occupy('templates/layout')?>