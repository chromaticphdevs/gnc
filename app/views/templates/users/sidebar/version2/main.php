<?php
    $authUser = whoIs();
    $account_status = $authUser['status'];
    $userID = $authUser['id'];
?>


<input type="hidden" id="account_type" value="<?php echo  $authUser['type']; ?>" disabled>
<?php build('sidebar') ?>
<ul class="nav side-menu">
    <?php if(!$authUser['is_user_verified']) :?>
        <li>
            <a href='/UserIdVerification/upload_id_html'>
                <i class='fa fa-link' aria-hidden='true'></i>Upload Pictures</a>
        </li>
    <?php endif?>

    <?php if($authUser['is_user_verified'] && !$authUser['is_total_referral_passed']) :?>
        <li>
            <a href='/UserIdVerification/upload_id_html'>
                <i class='fa fa-link' aria-hidden='true'></i>Upload Pictures</a>
        </li>
        <li>
        <a href='<?php _urlCall('customers')?>'>
            <i class='fa fa-users' aria-hidden='true'></i>
            <?php echo WordLib::get('referrals')?></a>
        </li>
    <?php endif?>

    <?php if($authUser['is_user_verified'] && $authUser['is_total_referral_passed']) :?>
        <li>
            <a href="/UserIdVerification/upload_id_html/">
                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                Upload id 
            </a>
        </li>

        <li>
            <a href="/UserSocialMedia/verify_link_list/">
                <i class="fa fa-link" aria-hidden="true"></i>
                Social Media 
            </a>
        </li>

        <li>
            <a href="<?php _urlCall('customers')?>">
                <i class="fa fa-users" aria-hidden="true"></i>
                <?php echo WordLib::get('referrals')?>
            </a>
        </li>

        <li><a href="/LoanController/requirements"><i class="fa fa-money" aria-hidden="true"></i> 
        Cash Advance </a></li>
        <input type="hidden" id="account_status" value="<?php echo $account_status; ?>">
        
        <!-- <li><a href="/WalletController/index"><i class="fa fa-money" aria-hidden="true"></i>Wallet</a></li>
        <li>
            <a href="/UserOwnedQRController/index"><i class="fa fa-link" aria-hidden="true"></i>QR CODES</a>
        </li>
         <li>
            <a href="/UserIdVerification/upload_id_html"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Upload ID</a>
        </li>
        <li>
            <a href="/UserSocialMedia/verify_link_list"><i class="fa fa-link" aria-hidden="true"></i>Social Media Verification</a>
        </li>
        <li>
            <a href="/Legalities/create"><i class="fa fa-star" aria-hidden="true"></i>Legalities</a>
        </li>
        
        <li>
            <a href="/commissions/" id="myHref4"><i class="fa fa-money" aria-hidden="true"></i>Commissions</a>
        </li>
        <li class="">
            <a>
                <i class="fa fa-sitemap" aria-hidden="true"></i>Organizations<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="display: none;">
            </ul>
        </li>
        <li><a href="/LoanController/requirements"><i class="fa fa-money" aria-hidden="true"></i> 
        Cash Advance </a></li>
        <li>
            <a href="/FinancialStatementController/index"><i class="fa fa-money" aria-hidden="true"></i> 
            Financial Statements </a>
        </li> -->
    <?php endif?>

    <?php if(Session::check('ADMIN_CONTROL')): ?>
        <li>
            <a href="/users/change_account_session/1"><i class="fa fa-arrow-right" aria-hidden="true"></i>
             Back to Admin</a>
        </li>
     <?php endif;?>
     <li><a href="/Users/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a></li>
</ul>
<?php endbuild()?>

<?php occupy('templates.users.sidebar.version2.template')?>