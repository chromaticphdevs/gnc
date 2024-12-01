<?php

    $user_type = Auth::user_position();
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }
?>

<?php build('sidebar') ?>
<ul class="nav side-menu">
    <!-- LEVEL 1 -->
    <li>
        <a href="/<?php echo $user_type?>/">
        <i class="fa fa-dashboard"></i>
        Control Panel </a>
    </li>
    
    <?php if(SESSION::get("USERSESSION")['account_tag'] == "main_account"): ?>
    <li class="active"><a><i class="fa fa-university" aria-hidden="true"></i> Finance
        <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="display: block;">

            <?php if( $user_type == 'admin' ) : ?>
                        <li class="current-page"><a href="/FNCashAdvance/approval_list_all">Cash Advance approval</a></li>
                        <li class="current-page"><a href="/FNCashAdvance/request_list_all">Cash Advance requests</a></li>
                        <li class="current-page"><a href="/FNCashAdvance/qualification_list_all">Qualification Status List</a></li>
            <?php else:?>
                        <li class="current-page"><a href="/FNCashAdvance/create">Cash Advance</a></li>
            <?php endif;?>

            <li class="current-page"><a href="/FNSinglebox/make_assistance">Product Assistance</a></li>
            <li class="current-page"><a href="/FNProductBorrower/get_user_loans">Product Loan</a></li>
            <li class="current-page"><a href="/WaterStation/">Water refilling station</a></li>
            <li class="current-page"><a href="#">Bigasan</a></li>
            <li class="current-page"><a href="/PeraPadala">Pera Padala</a></li>
            <?php if( $user_type == 'admin' ) : ?>
            <li class="current-page"><a href="/FNIndex/index">Finance Module</a></li>
            <?php endif;?>
            <!-- <li><a href="/admin/reports/volume">History</a></li>      -->
        </ul>
    </li>

    <?php endif;?>


    <?php if(SESSION::get("USERSESSION")['is_staff'] == "1"): ?>

        <!--<li>
            <a href="/Expense/make_request"><i class="fa fa-paper-plane" aria-hidden="true"></i>Expense Request</a>
        </li>-->
    <?php endif;?>
    <li>
        <a href="/UserSocialMedia/add_link"><i class="fa fa-link" aria-hidden="true"></i>Add Social Media Link</a>
    </li>
     <li>
        <a href="/UserIdVerification/upload_id_html"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Upload ID</a>
    </li>
    <!-- <li>
        <a href="https://m.me/YourFinancialAssistanceSpecialistCLICKHERE?ref=Change_Profile_Pic" target="_blank"><i class="fa fa-facebook"></i
        >Change FB Profile Frame</a>
    </li>-->
     <li>
        <a href="/FNItemInventory/get_delivery_info_for_user"><i class="fa fa-truck" aria-hidden="true"></i>Delivery Info</a>
    </li>
     <li>
        <a href="/AccountProfile/update_address/?user=<?php echo SESSION::get("USERSESSION")['id'] ?>&address=not set"><i class="fa fa-paper-plane" aria-hidden="true"></i>Shipping Address</a>
    </li>
   
    <!--<li class="current-page">
        <a href="/FacebookStream/index"><i class="fa fa-camera"></i>Live </a>
    </li>-->
    <li>
        <a href="/VideoTutorialWatch/"><i class="fa fa-video-camera" aria-hidden="true"></i>Video Tutorials</a>
    </li>
    <li>
        <a href="/Legalities/create"><i class="fa fa-star" aria-hidden="true"></i>Legalities</a>
    </li>

    <?php $account_status=SESSION::get("USERSESSION")['status']; ?>
    <input type="hidden" id="account_status" value="<?php echo $account_status; ?>">
        

        <li>
            <a href="/charts/user_charts" id="myHref1"><i class="fa fa-bar-chart" aria-hidden="true"></i>Charts</a>
        </li>
     
        <!-- <li>
            <a href="/UserSocialMedia/get_users_chat_bot_link" id="myHref2"><i class="fa fa-weixin"></i>Chat Bot Link </a>
        </li> -->


    <!--<li>
        <a href="/RandomUserPicker/pick_one"><i class="fa fa-cube" aria-hidden="true"></i> Random User </a>
    </li>-->
   

    <li><a href="/LDAccountActivation/activate_account">
            <i class="fa fa-plug" aria-hidden="true"></i>Activation</a></li>

             <!-- if not activated donot show-->
   

        <li><a id="myHref3"><i class="fa fa-user" ></i> My Accounts  <span class="fa fa-chevron-down"></span></a>
             <?php if($account_status != "pre-activated" AND $account_status!= "approved_loan"): ?>       
                <ul class="nav child_menu">
                    <!-- <li><a href="/userAccount/create/">Add Account</a></li> -->
                    <?php if(!empty(SESSION::get("MY_ACCOUNTS")["by_name"]) OR !empty(SESSION::get("MY_ACCOUNTS")["by_email"])) : ?>
                        <?php foreach (SESSION::get("MY_ACCOUNTS")["by_name"] as $list) :?>
                                <li><a href="/users/change_account_session/<?= $list->id ?>"><?= $list->username ?></a></li>
                        <?php endforeach; ?>
                    <?php else:?>
                    <li><a href="#">No Other Accounts</a></li>
                    <?php endif;?>
                </ul>
            <?php endif;?>      
        </li>


        <li>
            <a href="/commissions/" id="myHref4"><i class="fa fa-money" aria-hidden="true"></i>Commissions</a>
        </li>
 
   <!--<li><a href="/affiliates/dbbi_refferal_link"><i class="fa fa-magnet" aria-hidden="true"></i>Referral Link</a></li>-->

    <li class="">
        <a>
            <i class="fa fa-sitemap" aria-hidden="true"></i>Organizations<span class="fa fa-chevron-down"></span>
        </a>
        <ul class="nav child_menu" style="display: none;">
            <!-- <li><a href="/geneology/binary">Team</a></li> -->
            <li><a href="/geneology/binary?level=5" id="myHref5">5th</a></li>
            <li><a href="/binaryGeneology/index" id="myHref6">7th</a></li>
            <li><a href="/UserDirectsponsor/index" id="myHref7">Customers to Follow Up</a></li>
            <li><a href="/geneology/unilevel" id="myHref8">Regular Customers</a></li>
        </ul>
    </li>
    <li>
        <a href="/userBinary/get_transactions"><i class="fa fa-line-chart" aria-hidden="true"></i>
        Team Transactions</a>
    </li>
     <?php if(Session::check('ADMIN_CONTROL')): ?>
        <li>
            <a href="/users/change_account_session/1"><i class="fa fa-arrow-right" aria-hidden="true"></i>
             Back to Admin</a>
        </li>
     <?php endif;?>
   
</ul>

<script type="text/javascript">
            
       
$( document ).ready(function() {

     $("#myHref1,#myHref2,#myHref3,#myHref4,#myHref5,#myHref6,#myHref7,#myHref8").on('click', function(event) {

         var status = document.getElementById("account_status").value;

         if(status != "pre-activated" && status != "approved_loan"){
            
            }else
            {
              event.preventDefault();
             alert("This Feature is for Activated Account Only");  
            }


        });
});

</script>
<?php endbuild()?>

<?php occupy('templates.users.sidebar.version2.template')?>
