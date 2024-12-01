<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        #goodthing{
            background-color: red;
            color: red !important;
            display: none;
        }
        
        #header{
            border-bottom: 1px solid #000;
        }

        #header h1{
            margin: 0px;;
        }

        #header p{
            margin: 0px;
        }

        li{
            margin-bottom: 10px;
        }

        .footer div {
            margin-bottom: 10px;
        }

        span{
            font-weight: bold;
            color: #db5b0d;
        }

        p{
            font-size: 8pt;
        }
        
    </style>
</head>
<body>
    <?php
        $renewalStartAmount = 0;
    ?>
    <div style="width: 500px; margin:0px auto" id="agreementDocument">
        <div id="header">
            <h1>Breakthrough-E</h1>
            <p><?php echo COMPANY_DETAILS['address']?></p>
        </div>

        <div style="text-align:center;margin-bottom:30px">
            <h3><?php echo WordLib::get('cashAdvance')?> Agreement (Page 1)</h3>
        </div>

        <h3>Parties</h3>

        <p>This Loan Agreement (hereinafter referred to as the “Agreement”) is entered into
            on <span id="date"><?php echo get_date($loan['main']->date, 'M d, Y')?></span> (the “Effective Date”), by and between BREAKTHROUGH - E , 
            represendted by it’s President Rommel Vasquez, with an address
            of 12 Matadero st. Matadero, Cabanatuan City Nueva Ecija.(here inafter referred to
            as the “Lender”). and</p>


        <p>
            Mr./Mrs. <span id="borrowerName"><?php echo $loan['main']->borrower_fullname?></span>, with address located at 
            <span id="borrowerAddress"><?php echo $loan['main']->borrower_address?></span> (hereinafter referred to as the “Borrower”),
            <?php if(!empty($loan['coborrowers'])) :?>
                and
                <?php foreach($loan['coborrowers'] as $key => $row):?>
                    <?php if($key > 0) echo ', '?>
                    <span><?php echo $row->firstname . ' '.$row->lastname?> with residence address located at <?php echo $row->address?></span>
                <?php endforeach?>
                (hereinafter referred to as the “Co-Borrower”)
            <?php endif?>(collectively referred to as the “Parties”).
        </p>

        <p>
            <ul style="list-style: none;">
                <li>– The Parties agree that the loan information set below is accurate.</li>
                <li>– Start Date of the First Payment: <span id="loanStartPaymentDate"><?php echo date('M d, Y', strtotime('+ 1 days'.$loan['main']->date))?></span></li>
                <li>– Loan Amount: <span id="loanAmount"><?php echo $loan['main']->amount?></span> </li>
                <li>– Service Fee: <span id="loanInterestRate"><?php echo $loan['main']->service_fee?> (<?php echo (int) number_only(LOAN_CHARGES['SERVICE_FEE_RATE'])?>%) </span> </li>
                <li>– Attornees Fee: <span id="loanInterestRate"><?php echo $loan['main']->attornees_fee?></span> (<?php echo (int) number_only(LOAN_CHARGES['ATTORNEES_FEE_RATE'])?>%) </li>
                <li>– Interest Rate: <span id="loanInterestRate"><?php echo $loan['main']->interest_rate?></span> (<?php echo (int) number_only(LOAN_CHARGES['LOAN_INTEREST_FEE_RATE'])?>%) </li>
                <li>– Initial Balance: <span id="loanInterestRate"><?php echo $loan['main']->net?></span> </li>
                <li>- Loan Terms <span id="loanTerms"><?php echo $loanTerms?></span></li>
            </ul>
        </p>

        <p id="goodthing">
            <ol>
                <li>Acknowledgement – Hereby, the Parties agree that the Lender will lend <span><?php echo $loan['main']->amount?></span> pesos to the Borrower as
                    per this Agreement.</li>

                <li>Payment – Hereby, the Parties agree that the date of the First Payment is <span><?php echo date('M d, Y', strtotime('+ 1 days'.$loan['main']->date))?></span> and
                    will continue until the date of the Last Payment which is 
                    <span id="loanLastPaymentDate"><?php echo date('M d, Y', strtotime('+ 1 months'.$loan['main']->date))?></span>. 
                    <b></b>
                    – The Payment is due on <span id="loanLastPaymentDate"><?php echo date('M d, Y', strtotime('+ 1 months'.$loan['main']->date))?></span> The method of payment will be 
                    <span id="loanPaymentMethod"><?php echo $loanPaymentMethod?></span>
                </li>

                <li>
                    Promise To Pay
                    – The Parties hereby agree that the Borrower promises to pay the Lender 
                    <span id="loanPaymentMethod"><?php echo $loan['main']->payment_method?></span> within <span id="loanTerms sr-only"> <?php echo $loanTerms?></span> (<?php echo $loanPaymentMethod?>)

                </li>

                <li>
                    Amendments
                    – The Parties agree that any amendments made to this Agreement must be in writing
                    where they must be signed by both Parties to this Agreement. <br>
                    
                    – As such, any amendments made by the Parties will be applied to this Agreement.
                </li>

                <li>
                    Assignment 
                    – The Parties hereby agree not to assign any of the responsibilities in this Agreement to a
                    third party unless consented to by both Parties in writing.
                </li>

                <li>
                    Assignment 
                    – The Parties hereby agree not to assign any of the responsibilities in this Agreement to a
                    third party unless consented to by both Parties in writing.
                </li>

                <li>
                    Entire Agreement 
                    – This Agreement contains the entire agreement and understanding among the Parties
                    hereto with respect to the subject matter hereof, and supersedes all prior agreements, 
                    understandings, inducements and conditions, express or implied, oral or written, of any
                    nature whatsoever with respect to the subject matter hereof. 
                    <br>
                    The express terms hereof
                    ACRO RESIDENCE, TABANG GUIGUINTO BULACAN
                    control and supersede any course of performance and/or usage of the trade inconsistent
                    with any of the terms hereof.
                </li>

                <li>
                    Ownership
                    – The Parties agree that this Agreement is not transferable unless a written consent is
                    provided by both Parties of this Agreement. <br> Co Maker Responsibility
                    A co-maker is a person who is legally required to pay for a loan and related fees if the borrower fails
                    to do so.This assures the lender that the loan will be paid no matter what happens. 
                    Signing this Agreement paper means that the co maker understood their responsibility once the
                    borrower fails to pay the loan.
                </li>

                <li>
                    RENEWAL
                    - The loan is automatically renewed unless the parties submits a written request to cancel the renewal
                    10 days before the end of the term.. 
                    
                    <table cellspacing="10" border="1px solid #000" style="border-collapse:collapse; width:100%">
                        <tbody>
                            <tr>
                                <td>First loan</td>
                                <td><span><?php echo $loan['main']->amount?></span></td>
                            </tr>
                            <?php for($i = 1; $i < 10; $i++) :?>
                                <?php $renewalStartAmount += 10000?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo ui_html_amount($renewalStartAmount)?></td>
                                </tr>
                            <?php endfor?>
                        </tbody>
                    </table>

                    Maximum Loan is Php 100,000.00
                </li>

                <li>
                    Signature And Date
                    – The Parties hereby agree to the terms and conditions set forth in this Agreement and
                    such is demonstrated throughout by their signatures below
                </li>

                <li class="footer">
                    <div>
                        Lender : BREAKTHROUGH-E
                        <div>Name: BREAKTHROUGH-E</div>
                    </div>

                    <div>
                        Borrower:
                        <div>Name: <span><?php echo $loan['main']->borrower_fullname?></span></div>
                        <div>Signature: <img src="<?php echo URL.DS.'public/assets/signatures/'.$loan['main']->esig?>" alt="" 
                        style="width: 150px; margin-left:30px; display:inline-block"> </div>

                        <?php if($borrowerSelfie) :?>
                            <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$borrowerSelfie->id_card?>" 
                                alt="" width="100%" class="mt-3">
                        <?php endif?>

                        <?php if($borrowerIds) :?>
                            <div style="display: flex; flex-direction:row; margin-top:10px">
                                <?php foreach($borrowerIds as $key => $row) :?>
                                    <div class="col-md-4" style="width: 200px; margin-right:5px">
                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card?>" 
                                        alt="" width="100%" class="mt-3">
                                        <div><label for="#"><?php echo $row->type?></label></div>
                                    </div>
                                <?php endforeach?>
                            </div>
                        <?php endif?>

                        <?php if($borrower->video_file) :?>
                            <div style="width: 100%;">
                                <video width="320" height="240" controls>
                                    <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$borrower->video_file?>" type="video/mp4">
                                    <source src="movie.ogg" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php else :?>
                            <p>Borrower has no video.</p>
                        <?php endif?>
                    </div>

                    <?php if(!empty($loan['coborrowers'])) :?>
                        <?php foreach($loan['coborrowers'] as $key => $row):?>
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
                        <?php endforeach?>
                    <?php endif?>

                    <?php if($directSponsor) :?>
                        <div style="border: 1px solid #000; padding:12px;border-radius:5px">
                            Co - Borrower (<?php echo WordLib::get('directSponsor')?>);
                            <div>
                                <span>Name: <?php echo $directSponsor->firstname . ' ' .$directSponsor->lastname?></span>
                                <div>
                                    <img src="<?php echo URL.DS.'public/assets/signatures/'.$directSponsor->esig?>" alt=""
                                            style="width: 150px; margin-left:30px; display:inline-block">
                                    <?php if(!empty($direectSponsorUploadId->id_card ?? '')) :?>
                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$direectSponsorUploadId->id_card?>" alt="" width="100%" class="mt-3">
                                    <?php else :?>
                                        <label for="#">No Selfie</label>
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction:row; margin-top:10px">
                            <?php foreach($resources['financialAdvisorResources']['ids'] as $key => $row) :?>
                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                    <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card?>" 
                                    alt="" width="100%" class="mt-3">
                                    <div><label for="#"><?php echo $row->type?></label></div>
                                </div>
                            <?php endforeach?>
                        </div>
                        <?php if($resources['financialAdvisorResources']['video']) :?>
                            <div>
                                <video width="320" height="240" controls>
                                    <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$resources['financialAdvisorResources']['video']->video_file?>" type="video/mp4">
                                    <source src="movie.ogg" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php endif?>
                    <?php endif?>

                    <?php if($loanProcessor) :?>
                        <div style="border: 1px solid #000; padding:12px;border-radius:5px">
                            Co - Borrower (<?php echo WordLib::get('loanProcessor')?>);
                            <div>
                                <span>Name: <?php echo $loanProcessor->firstname . ' ' .$loanProcessor->lastname?></span>
                                <div>
                                    <img src="<?php echo URL.DS.'public/assets/signatures/'.$loanProcessor->esig?>" alt=""
                                            style="width: 150px; margin-left:30px; display:inline-block">
                                    <?php if(!empty($loanProcessor->id_card ?? '')) :?>
                                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$loanProcessor->id_card?>" alt="" width="100%" class="mt-3">
                                    <?php else :?>
                                        <label for="#">No Selfie</label>
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction:row; margin-top:10px">
                            <?php foreach($resources['loanProcessorResources']['ids'] as $key => $row) :?>
                                <div class="col-md-4" style="width: 200px; margin-right:5px">
                                    <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card?>" 
                                    alt="" width="100%" class="mt-3">
                                    <div><label for="#"><?php echo $row->type?></label></div>
                                </div>
                            <?php endforeach?>
                        </div>
                        <?php if($resources['loanProcessorResources']['video']) :?>
                            <div>
                                <video width="320" height="240" controls>
                                    <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$resources['loanProcessorResources']['video']->video_file?>" type="video/mp4">
                                    <source src="movie.ogg" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php endif?>
                    <?php endif?>
                </li>
            </ol>
        </p>
    </div>

    <script>

    </script>
</body>
</html>