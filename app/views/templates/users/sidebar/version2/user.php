<?php

    $user_type = Auth::user_position();
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }

    $isGoldAndUp = isEqual(whoIs()['status'], [
        'pre-activated','reseller',
        'starter','bronze','silver'
    ]);

    $isGoldAndUp = !$isGoldAndUp;
?>

<?php

    $account_type = "";

    if(Session::check('BRANCH_MANAGERS'))
    {
        $account_type = "manager";

    }else if(Session::check('USERSESSION'))
    {
        $account_type = "user";
    }
?>
<input type="hidden" id="account_type" value="<?php echo  $account_type; ?>" disabled>

<?php $account_status = SESSION::get("USERSESSION")['status']; ?>

<?php $userID = SESSION::get("USERSESSION")['id']; ?>
<?php $user_contacts = check_user_contacts($userID); ?>
<?php $user_social_media = check_user_social_media($userID); ?>
<?php $user_uploaded_id = check_user_id($userID); ?>

<?php build('sidebar') ?>

<ul class="nav side-menu">
    <?php if($account_status == "pre-activated"): ?>
        <li>
            <a href="/users/">
            <i class="fa fa-dashboard"></i>
            Control Panel </a>
        </li>
        <?php if($isGoldAndUp):?>
            <li><a href="/PettyCashController"><i class="fa fa-money" aria-hidden="true"></i>Petty Cash</a></li>
        <?php endif?>
        <li>
            <a href="/UserOwnedQRController/index"><i class="fa fa-link" aria-hidden="true"></i>QR CODES</a>
        </li>
        <li>
            <a href="/UserIdVerification/upload_id_html"><i class="fa fa-link" aria-hidden="true"></i>Upload Pictures</a>
        </li>
        <li>
            <a href="/LoanController/requirements"><i class="fa fa-money" aria-hidden="true"></i> 
            Cash Advance </a>
        </li>
        <!-- <li>
            <a href="/#/#"><i class="fa fa-money" aria-hidden="true"></i> 
            Product Advance </a>
        </li> -->
        <li>
            <a href="/FinancialStatementController/index"><i class="fa fa-money" aria-hidden="true"></i> 
            Financial Statements </a>
        </li>
        <?php if($user_contacts > 0): ?>
            <li>
                <a href="/UserSocialMedia/add_link"><i class="fa fa-link" aria-hidden="true"></i>Add Social Media Link</a>
            </li>
            <?php if($user_social_media > 0): ?>
                 <li>
                    <a href="/UserIdVerification/upload_id_html"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Upload ID</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
        <li class="">
            <a>
                <i class="fa fa-sitemap" aria-hidden="true"></i>Organizations<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="display: none;">
                <!-- <li class="current-page"><a href="<?php _urlCall('geneology-binary')?>">Team</a></li> -->
                <li><a href="<?php _urlCall('customers')?>"><?php echo WordLib::get('referrals')?></a></li>
                <li><a href="/UserCustomerFollowUps/index">Follow Ups</a></li>
                <li><a href="<?php _urlCall('geneology-unilevel')?> ">All Customers</a></li>
            </ul>
        </li>
    <?php else:?>
        <li>
            <a href="/users/">
            <i class="fa fa-dashboard"></i>
            Control Panel </a>
        </li>
        <li><a href="/WalletController/index"><i class="fa fa-money" aria-hidden="true"></i>Wallet</a></li>
        <?php if($isGoldAndUp):?>
            <li><a href="/PettyCashController"><i class="fa fa-money" aria-hidden="true"></i>Petty Cash</a></li>
        <?php endif?>
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
        <input type="hidden" id="account_status" value="<?php echo $account_status; ?>">
        <li>
            <a href="/commissions/" id="myHref4"><i class="fa fa-money" aria-hidden="true"></i>Commissions</a>
        </li>
       <li class="">
            <a>
                <i class="fa fa-sitemap" aria-hidden="true"></i>Organizations<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="display: none;">
                <!-- <li class="current-page"><a href="<?php _urlCall('geneology-binary')?>">Team</a></li> -->
                <li><a href="<?php _urlCall('customers')?>"><?php echo WordLib::get('referrals')?></a></li>
                <li><a href="/UserCustomerFollowUps/index">Follow Ups</a></li>
                <li><a href="<?php _urlCall('geneology-unilevel')?> ">All Customers</a></li>
            </ul>
        </li>
        <li><a href="/LoanController/requirements"><i class="fa fa-money" aria-hidden="true"></i> 
        Cash Advance </a></li>
        <li>
            <a href="/FinancialStatementController/index"><i class="fa fa-money" aria-hidden="true"></i> 
            Financial Statements </a>
        </li>
        <?php if($isGoldAndUp):?>
            <li><a href="/TimekeepingController"><i class="fa fa-clock-o" aria-hidden="true"></i> 
            Timekeeping </a></li>
        <?php endif?>
    <?php endif;?>

     <?php if(Session::check('ADMIN_CONTROL')): ?>
        <li>
            <a href="/users/change_account_session/1"><i class="fa fa-arrow-right" aria-hidden="true"></i>
             Back to Admin</a>
        </li>
     <?php endif;?>
     <li><a href="/Users/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a></li>
</ul>

<script type="text/javascript">
            
       
$( document ).ready(function() {

    var status = document.getElementById("account_status").value;

     $("#myHref1,#myHref2,#myHref3,#myHref4,#myHref5,#myHref6,#myHref7,#myHref8,#csr").on('click', function(event) {

         if(status != "pre-activated" && status != "approved_loan"){
            
            }else
            {
              event.preventDefault();
             alert("This Feature is for Activated Account Only");  
            }


        });


     $("#company_followup").on('click', function(event) {


    if(status != "pre-activated" && status != "approved_loan"){
            
            }else
            {
             event.preventDefault();
             alert("This Feature is Not Available"); 

              }
        });
});

</script>
<?php endbuild()?>

<?php occupy('templates.users.sidebar.version2.template')?>
