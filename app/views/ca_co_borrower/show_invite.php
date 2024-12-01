<?php build('content') ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Loan CoBorrower Invitation Approval</h4>
        </div>
        <div class="card-body">
            <?php
                Form::open([
                    'method' => 'post'
                ]);

                Form::hidden('id', $id);
            ?>
                <div class="form-group">
                    <?php
                        Form::label('Loan#');
                        Form::text('', $requestInvite->code, [
                            'class' => 'form-control',
                            'readonly' => true
                        ]);
                    ?>
                    <a href="/CashAdvance/loan/<?php echo seal($requestInvite->fn_ca_id)?>" target="_blank">Show Loan</a>
                </div>
                <div class="form-group">
                    <?php
                        Form::label('Invite Response');
                        Form::select('co_borrower_approval', [
                            'accept' => 'Accept',
                            'decline' => 'Decline'
                        ], $requestInvite->co_borrower_approval ?? 'accep', [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Invite Notes');
                        Form::textarea('co_borrower_remarks', $requestInvite->co_borrower_remarks ?? '', [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::submit('', 'Submit', [
                            'class' => 'btn btn-primary'
                        ])
                    ?>
                </div>
            <?php Form::close()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy()?>