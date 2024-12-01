<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Loan Requirements</h4>
        </div>
    </div>

    <div class="card" style="margin-bottom: 50px;">
        <div class="card-body">
            <section>
                <h3>(1) Make Your Account Verified</h3>
                <div> 
                    You need to have atleast (2)two valid id pictures verified. 
                    <a href="/UserIdVerification/upload_id_html" target="_blank">Upload Pictures Here.</a>
                </div>
                <?php
                    $uploadIdsKeys = array_keys($arrangeUploadIds);
                ?>
                <?php foreach($listOfValidIds as $key => $row) :?>
                    <?php if(in_array($row, $uploadIdsKeys)) :?>
                        <?php $uploadedId = $arrangeUploadIds[$row]; ?>
                        <div class="uploaded-picture" style="margin-top: 10px;">
                            <div>
                                <?php echo $uploadedId->type?> | 
                                <?php echo wTruOrFalseText(isEqual($uploadedId->status, 'verified'), ['Approved', $uploadedId->status])?>| 
                                <?php echo $uploadedId->date_time?>
                            </div>

                            <a href="/UserIdVerification/preview_id_image/<?php echo $uploadedId->id?>">View Picture</a>
                        </div>
                    <?php endif?>
                <?php endforeach?>

                <p style="margin-top:20px; ">
                    You will have a check on your profile '<?php echo userVerfiedText()?>' 
                    once your account is verified.
                </p>
            </section>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <section>
                <h3>(2) Alteast 2 Referrals must have verified account</h3>
                <div class="mb-3 mt-2"><?php echo wReferralLinkButton(createReferralLink())?></div>

                <div>
                    Advice your referrals to upload valid id pictures and get verified.
                    <a href="/customers" target="_blank">Check your Referrals Here</a>
                </div>

                <p style="margin-top: 10px; margin-bottom:10px; font-weight:bold; border:1px solid #000; padding:5px">You Have <?php echo count($referrals)?> 
                Referrals 
                    <?php if(count($referrals) > 0) :?>
                        out of <?php echo count($approvedRefferals)?> are verified
                    <?php endif?>
                </p>
                
                <?php if($approvedRefferals) :?>
                    <table class="table table-bordered">
                        <thead>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Verified</th>
                        </thead>

                        <tbody>
                            <?php foreach($referrals as $key => $row) :?>
                                <?php if($row->is_user_verified) :?>
                                <tr>
                                    <td><?php echo $row->firstname . ' ' .$row->lastname?></td>
                                    <td><?php echo $row->mobile?></td>
                                    <td><?php echo userVerfiedText($row)?></td>
                                </tr>
                                <?php endif?>
                            <?php endforeach?>
                        </tbody>
                    </table>
                <?php else:?>
                    <p>You currently don't have verified account referrals.</p>
                <?php endif?>
            </section>
        </div>
    </div>

    <?php if($totalVerifiedIds >= 2 && count($approvedRefferals) >= 2) :?>
        <div class="card" style="margin-top:30px">
            <div class="card-body">
                <a href="/FnCashAdvance/apply_now?view=new" class="btn btn-primary">Apply For Loan</a>
            </div>
        </div>
    <?php endif?>
<?php endbuild()?>

<?php build('headers')?>
    <style>
        .uploaded-picture {
            border: 1px solid #000;
            padding: 10px;
        }
    </style>
<?php endbuild()?>
<?php occupy()?>