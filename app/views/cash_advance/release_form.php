<?php build('content') ?>
    <div class="container-fluid">
        <?php echo wControlButtonLeft('', [
            $navigationHelper->setNav('', 'Back', '/FNCashAdvance/index')
        ])?>
        <div class="col-md-5 mx-auto">
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Cash Advance Release')) ?>
                <div class="card-body">
                    <?php Flash::show() ?>
                    <div class="text-center">
                        <h1><?php echo ui_html_amount($loan->ca_amount)?></h1>
                        <h5>Loan Amount</h5>
                    </div>
                    <hr>
                    <?php
                        Form::open(['method' => 'post', 'enctype' => 'multipart/form-data']);
                        Form::hidden('loan_id', seal($loan->ca_id));
                    ?>
                    <div>
                        <div class="form-group">
                            <?php 
                                Form::label('Reference');
                                Form::text('', $loan->ca_reference, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Loan Amount');
                                Form::text('loan_amount', $loan->ca_amount, [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id'  => 'loanAmount',
                                    'data-amount' => $loan->ca_amount
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Service Fee' . ' (' . LOAN_CHARGES['SERVICE_FEE_RATE']. '%' . ')');
                                Form::text('service_fee', '', [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id' => 'serviceFee'
                                ]);
                            ?>
                            <p>Automatically calculated as <?php echo LOAN_CHARGES['SERVICE_FEE_RATE']?>% of loan amount, put 0 if loan has no service fee</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Attornees Fee' . ' (' . LOAN_CHARGES['ATTORNEES_FEE_RATE']. '%' . ')');
                                Form::text('attornees_fee', '', [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'id' => 'attorneesFee'
                                ]);
                            ?>
                            <p>Automatically calculated as <?php echo LOAN_CHARGES['ATTORNEES_FEE_RATE']?>% of loan amount, put 0 if loan has no attornees fee</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Loan Interest ' . ' (' . LOAN_CHARGES['LOAN_INTEREST_FEE_RATE']. '%' . ')');
                            ?>
                            <div class="row">
                                <div class="col-md-9">
                                    <?php
                                        Form::label('Computed Interest');
                                        Form::text('interest_rate_amount', '', [
                                            'class' => 'form-control',
                                            'required' => true,
                                            'id' => 'loanInterestFeeRate'
                                        ]);
                                    ?>
                                </div>
                                <div class="col-md-3">
                                <?php
                                        Form::label('Loan Interest');
                                        Form::select('interest_rate_interest_setting', [
                                            '5%'  => '5% Interest',
                                            '10%' => '10% Interest',
                                        ], '', [
                                            'class' => 'form-control',
                                            'required' => true,
                                            'id' => 'loanInterestFeeRateSetting',
                                        ]);
                                    ?>
                                </div>
                            </div>
                            
                            <p>Automatically calculated as <?php echo LOAN_CHARGES['LOAN_INTEREST_FEE_RATE']?>% of loan amount, put 0 if loan has no attornees fee</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Days before due date');
                                Form::number('due_date_no_of_days', $DUE_DATE_NO_OF_DAYS_DEFAULT, [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                            <p>Estimated Due Date : <?php echo date('M/d/Y', strtotime("+60 days " . today()))?> </p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Total Balance');
                                Form::text('', '', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'id' => 'totalBalance'
                                ]);
                            ?>
                            <p>The Total amount of the customer will pay</p>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('Borrower Name');
                                Form::text('', $loan->fullname, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label(WordLib::get('directSponsor'));
                                Form::text('', $loan->direct_sponsor_name, [
                                    'class' => 'form-control',
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('GoTyme Account Number');
                                Form::text('', $gotymeBank->account_number ?? '', [
                                    'class' => 'form-control click-to-copy',
                                    'data-text' => trim($gotymeBank->account_number ?? ''),
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('GoTyme Account Name');
                                Form::text('', $gotymeBank->account_name ?? '', [
                                    'class' => 'form-control click-to-copy',
                                    'data-text' => trim($gotymeBank->account_name ?? ''),
                                    'readonly' => true
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php 
                                Form::label('GoTyme Reference');
                                Form::text('external_reference', '', [
                                    'class' => 'form-control',
                                    'required' => true
                                ]);
                            ?>
                        </div>
                        <?php if(!$loan->ca_is_released) :?>
                            <div class="form-group">
                                <?php Form::submit('', 'Release', [
                                    'class' => 'btn btn-primary btn-sm'
                                ]) ?>
                            </div>
                        <?php endif?>
                        <?php echo wDivider(50) ?>
                        <a href="/FNCashAdvance/findForRelease/?previous=<?php echo seal($loan->ca_id)?>" class="btn btn-warning btn-lg">Process Next</a>
                    </div>
                    <?php Form::close() ?>
                </div>
            </div>
            
            <?php echo wDivider()?>
            <div class="card">
                <?php echo wCardHeader(wCardTitle('Documents to verify')) ?>
                <div class="card-body">
                    <section id="borrowerDetails" class="mb-3">
                        <div class="card">
                            <?php echo wCardHeaderSmall(wCardTitle('Borrower Details')) ?>
                            <div class="card-body">
                                <h5><?php echo $directSponsor->firstname . ' '.$directSponsor->lastname?></h5>
                                <?php if($borrowerSelfie) :?>
                                    <div>
                                        <h4>Borrower Details</h4>
                                        <h5><?php echo listOfValidIds()[17]?></h5>
                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$borrowerSelfie->id_card?>" 
                                            alt="" width="100%" class="mt-3">
                                    </div>
                                <?php else :?>
                                    <p>No selfie</p>
                                <?php endif?>

                                <?php if($resources['borrowerResources']['ids']) :?>
                                    <div style="display: flex; flex-direction:row; margin-top:10px">
                                        <?php foreach($resources['borrowerResources']['ids'] as $key => $row) :?>
                                            <?php if(empty($row)) :?>
                                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                    <p>No Other Pictures</p>
                                                </div>
                                            <?php else:?>
                                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                    <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card?>" 
                                                    alt="" width="100%" class="mt-3">
                                                    <div><label for="#"><?php echo $row->type?></label></div>
                                                </div>
                                            <?php endif?>
                                        <?php endforeach?>
                                    </div>
                                <?php endif?>
                                <?php if($resources['borrowerResources']['video']) :?>
                                    <div style="width: 100%;">
                                        <video width="100%" height="240" controls>
                                            <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$resources['borrowerResources']['video']->video_file?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                <?php else :?>
                                    <p>Borrower has no video.</p>
                                <?php endif?>
                            </div>
                        </div>
                    </section>

                    <section id="coborrowerDetails" class="mb-3">
                        <div class="card">
                            <?php echo wCardHeaderSmall(wCardTitle('Co-Borrower Details')) ?>
                            <div class="card-body">
                                <?php if(!empty($coBorrowers)) :?>
                                    <?php foreach($coBorrowers as $key => $row):?>
                                        <div style="border: 1px solid #000; padding:12px;border-radius:5px">
                                            Co- Borrower 
                                            <div>
                                                <span>Name: <?php echo $row->firstname . ' ' .$row->lastname?></span>
                                                <div>
                                                    <img src="<?php echo URL.DS.'public/assets/signatures/'.$row->esig?>" alt=""
                                                        style="width: 150px; margin-left:30px; display:inline-block">
                                                    <?php if(isset($coBorrowerids[$row->co_borrower_id])) :?>
                                                        <?php
                                                            $idFront =    $coBorrowerids[$row->co_borrower_id]->id_card ?? ''; 
                                                        ?>
                                                        <?php if($idFront) :?>
                                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$idFront?>" alt="" width="100%" class="mt-3">
                                                        <?php else:?>
                                                            <label for="#">No Selfie</label>
                                                        <?php endif?>
                                                    <?php endif?>
                                                </div>
                                            </div>

                                            <div style="display: flex; flex-direction:row; margin-top:10px">
                                                <?php foreach($resources['cobborrowerResources'][$row->co_borrower_id]['ids'] as $key => $coborrower) :?>
                                                    <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$coborrower->id_card?>" 
                                                        alt="" width="100%" class="mt-3">
                                                        <div><label for="#"><?php echo $coborrower->type?></label></div>
                                                    </div>
                                                <?php endforeach?>
                                            </div>

                                            <?php if($resources['cobborrowerResources'][$row->co_borrower_id]['video']) :?>
                                                <div style="width: 100%;">
                                                    <video width="320" height="240" controls>
                                                        <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$resources['cobborrowerResources'][$row->co_borrower_id]['video']->video_file?>" type="video/mp4">
                                                        <source src="movie.ogg" type="video/ogg">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            <?php else :?>
                                                <p>No Video</p>
                                            <?php endif?>
                                        </div>
                                    <?php endforeach?>
                                <?php else :?>
                                    <p>User has no co-borrowers</p>
                                <?php endif?>
                            </div>
                        </div>
                    </section>

                    <section id="financialAdvisorDetails" class="mb-3">
                        <div class="card">
                            <?php echo wCardHeaderSmall(wCardTitle(WordLib::get('directSponsor') . ' Details ')) ?>
                            <div class="card-body">
                                <h5><?php echo $directSponsor->firstname . ' '.$directSponsor->lastname?></h5>
                                <?php if($directSponsorSelfie) :?>
                                    <div>
                                        <h5><?php echo listOfValidIds()[17]?></h5>
                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$directSponsorSelfie->id_card?>" 
                                            alt="" width="100%" class="mt-3">
                                    </div>
                                <?php else :?>
                                    <p>No selfie</p>
                                <?php endif?>

                                <?php if($resources['financialAdvisorResources']['ids']) :?>
                                    <div style="display: flex; flex-direction:row; margin-top:10px">
                                        <?php foreach($resources['financialAdvisorResources']['ids'] as $key => $row) :?>
                                            <?php if(empty($row)) :?>
                                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                    <p>No Other Pictures</p>
                                                </div>
                                            <?php else:?>
                                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                    <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card?>" 
                                                    alt="" width="100%" class="mt-3">
                                                    <div><label for="#"><?php echo $row->type?></label></div>
                                                </div>
                                            <?php endif?>
                                        <?php endforeach?>
                                    </div>
                                <?php endif?>

                                <?php if($resources['financialAdvisorResources']['video']) :?>
                                    <div style="width: 100%;">
                                        <video width="100%" height="240" controls>
                                            <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$resources['financialAdvisorResources']['video']->video_file?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                <?php else :?>
                                    <p><?php echo WordLib::get('directSponsor')?> has no video.</p>
                                <?php endif?>
                            </div>
                        </div>
                    </section>
                    
                    <section id="loanProcessor" class="mb-3">
                        <div class="card">
                            <?php echo wCardHeaderSmall(wCardTitle(WordLib::get('loanProcessor') . ' Details ')) ?>
                            <?php if($loanProcessor) :?>
                            <div class="card-body">
                                <h5><?php echo $loanProcessor->firstname . ' '.$loanProcessor->lastname?></h5>
                                <?php if($loanProcessorSelfie) :?>
                                    <div>
                                        <h5><?php echo listOfValidIds()[17]?></h5>
                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$loanProcessorSelfie->id_card?>" 
                                            alt="" width="100%" class="mt-3">
                                    </div>
                                <?php else :?>
                                    <p>No selfie</p>
                                <?php endif?>

                                <?php if($resources['loanProcessorResources']['ids']) :?>
                                    <div style="display: flex; flex-direction:row; margin-top:10px">
                                        <?php foreach($resources['loanProcessorResources']['ids'] as $key => $row) :?>
                                            <?php if(empty($row)) :?>
                                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                    <p>No Other Pictures</p>
                                                </div>
                                            <?php else:?>
                                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                                    <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card?>" 
                                                    alt="" width="100%" class="mt-3">
                                                    <div><label for="#"><?php echo $row->type?></label></div>
                                                </div>
                                            <?php endif?>
                                        <?php endforeach?>
                                    </div>
                                <?php endif?>

                                <?php if($resources['loanProcessorResources']['video']) :?>
                                    <div style="width: 100%;">
                                        <video width="100%" height="240" controls>
                                            <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$resources['loanProcessorResources']['video']->video_file?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                <?php else :?>
                                    <p><?php echo WordLib::get('directSponsor')?> has no video.</p>
                                <?php endif?>
                            </div>
                            <?php else:?>
                                <p>No <?php echo WordLib::get('loanProcessor')?> Found.</p>
                            <?php endif?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<?php endbuild() ?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function() {
            let loanAmount = $('#loanAmount');
            let serviceFee = $('#serviceFee');
            let attorneesFee = $('#attorneesFee');
            let loanInterestFeeRate = $('#loanInterestFeeRate');
            let totalBalance = $('#totalBalance');
            let loanInterestFeeRateSetting = $('#loanInterestFeeRateSetting');

            let feesRate = {
                serviceFeeRate : 0.05,
                attorneesFeeRate: 0.10,
                loanInterestFeeRate: 0.05,

                serviceFeeAmount : 0.0,
                attorneesFeeAmount : 0.0,
                loanInterestFeeAmount : 0.0,
            };


            $('.click-to-copy').click(function(){
                alert('copied to clipboard');
                copyStringToClipBoard($(this).data('text'));
            });

            $(loanAmount).on('keyup',function(e){
                console.log('test');
                calcAll();
            });

            $(serviceFee).add(attorneesFee).on('keyup',function(e){
                console.log('fressh');
                calcTotalBalance();
            });

            $(loanInterestFeeRateSetting).change(function(){
                calcInterestRateFoomSetting();
                calcServieFee();
                calcAtorneesFee();
                calcInterestRate();
                calcTotalBalance();
            });

            calcAll();

            function calcAll() {
                calcServieFee();
                calcAtorneesFee();
                calcInterestRate();
                calcTotalBalance();
            }

            function calcServieFee() {
                let loanAmountValue = parseFloat(getLoanAmount());
                feesRate['serviceFeeAmount'] = loanAmountValue * feesRate['serviceFeeRate'];
                serviceFee.val(feesRate['serviceFeeAmount']);
            }
            
            function calcAtorneesFee() {
                let loanAmountValue = parseFloat(getLoanAmount());
                feesRate['attorneesFeeAmount'] = loanAmountValue * feesRate['attorneesFeeRate'];
                attorneesFee.val(feesRate['attorneesFeeAmount']);
            }

            function calcInterestRate() {
                let loanAmountValue = parseFloat(getLoanAmount());
                feesRate['loanInterestFeeAmount'] = loanAmountValue * feesRate['loanInterestFeeRate'];
                console.log(loanAmountValue * feesRate['loanInterestFeeRate']);
                loanInterestFeeRate.val(feesRate['loanInterestFeeAmount']);
            }

            function calcTotalBalance() {
                let loanAmountValue = parseFloat(getLoanAmount());
                let attorneesFeeValue = parseFloat(attorneesFee.val());
                let serviceFeeValue = parseFloat(serviceFee.val());
                let loanInterestFeeAmount = parseFloat(loanInterestFeeRate.val());

                totalBalance.val((loanAmountValue + serviceFeeValue + attorneesFeeValue + loanInterestFeeAmount));
            }

            function getLoanAmount() {
                let loanAmountVal = loanAmount.val();
                return Number(loanAmountVal.replace(/[^0-9.-]+/g,""));
            }

            function calcInterestRateFoomSetting() {
                let computeInterestRate = loanInterestFeeRateSetting.val();
                switch(computeInterestRate){
                    case '5%':
                        feesRate['loanInterestFeeRate'] = .05 ;
                        break;
                    case '10%': 
                        feesRate['loanInterestFeeRate'] = .10;
                        break;
                }
            }
        });
    </script>
<?php endbuild()?>

<?php build('headers') ?>
<style>
    .content-separator{
        border: 1px solid #eee;
        padding: 10px;
        border-radius: 5px;
    }
</style>
<?php endbuild()?>
<?php occupy() ?>