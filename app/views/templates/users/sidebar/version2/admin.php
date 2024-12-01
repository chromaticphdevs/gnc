<?php
    Auth::get_instance();
    $user_type = Auth::user_position();
?>

<?php build('sidebar') ?>
<ul class="nav side-menu">
    <?php if($user_type == '1') :?>
        <!-- LEVEL 1 -->
        <li>
            <a href="/admin/">
            <i class="fa fa-dashboard"></i>
            Dashboard </a>
        </li>
        <li><a href="/PettyCashController"><i class="fa fa-money" aria-hidden="true"></i>Petty Cash</a></li>

        <li>
            <a href="/InventoryController">
                <i class="fa fa-circle-o"></i> Inventory
            </a>
        </li>

        <li>
            <a href="/CodeBatchController">
                <i class="fa fa-circle-o"></i> Universal Codes
            </a>
        </li>
        <li>
            <a href="/LoanController">
                <i class="fa fa-money"></i>Loan
            </a>
        </li>
        <li>
            <a href="/LoanUniversalController/index">
                <i class="fa fa-money"></i>Universal Loan
            </a>
        </li>
        <li><a><i class="fa fa-users" aria-hidden="true"></i> Accounts  <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="/account/searchUser">Search</a></li>
                <li><a href="/UserTools/user_search_tool">Search Address</a></li>
                <li><a href="/FNAccount/make_account">Create Staff</a></li> 
                <li><a href="/FNAccount/approved_staff">Staff Requests</a></li>
                <li><a href="/users/searchUser_qualification">Client Qualification</a></li>
            </ul>
        </li>
        <li>
            <a href="/UserIdVerification/verify_id_list"><i class="fa fa-check-square-o" aria-hidden="true"></i>User's ID Verification</a>
        </li>
        <li class="">
            <a>
                <i class="fa fa-sitemap" aria-hidden="true"></i>Organizations<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="display: none;">
                <li class="current-page"><a href="<?php _urlCall('geneology-binary')?>">Team</a></li>
                <li class="current-page"><a href="<?php _urlCall('geneology-binary' , ['level' => 5])?>">5th</a></li>
                <li class="current-page"><a href="/binaryGeneology/index">7th</a></li>
                <li><a href="<?php _urlCall('customers')?>">Customers</a></li>
                <li><a href="<?php _urlCall('geneology-unilevel')?> ">Regular Customers</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php _urlCall('transactions')?>"><i class="fa fa-line-chart" aria-hidden="true"></i>
            Team Transactions</a>
        </li>
        <li>
            <a href="/commissions/getAll"><i class="fa fa-money" aria-hidden="true"></i>Commissions</a>
        </li>
        <li>
            <a href="/FinancialStatementController/index"><i class="fa fa-money" aria-hidden="true"></i> 
            Financial Statements </a>
        </li>
        <li><a href="/FNCashAdvance/index"><i class="fa fa-money" aria-hidden="true"></i> 
        Cash Advance </a></li>
        
        <li><a><i class="fa fa-balance-scale" aria-hidden="true"></i> Payout No Cutoff<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none;">
                <li class="current-page"><a href="/MGPayout2/create_payout">Generate</a></li>
                <li class="current-page"><a href="/MGPayout2/create_payout_valid_id/?amount=0">Generate W/ Valid ID</a></li>
                <li class="current-page"><a href="/MGPayout2/create_payout_valid_id/?amount=1000">Generate W/ Valid ID Min 1000</a></li>
                <li class="current-page"><a href="/MGPayout2/create_payout_valid_id/?amount=1500">Generate W/ Valid ID Min 1500</a></li>
                <li class="current-page"><a href="/MGPayout_Request/create_payout">Requested Payout</a></li>
                <li class="current-page"><a href="/PayoutRequest">Payout Requests</a></li>
                <li class="current-page"><a href="/MGPayout2/list">Payout History</a></li>

            </ul>
        </li>
        <li><a href="/MGPayout2/get_payins_with_option"><i class="fa fa-money"></i> All Payins</a></li>
        <li><a href="/TimekeepingController"><i class="fa fa-money"></i> Timekeeping </a></li>
    <?php endif?>
    <?php if($user_type == 3) :?>
    <li>
        <a href="/LoanController">
            <i class="fa fa-money"></i>Loan
        </a>
    </li>
    <li>
        <a href="/UserIdVerification/verify_id_list"><i class="fa fa-check-square-o" aria-hidden="true"></i>User's ID Verification</a>
    </li>
    <?php endif?>
    <li><a href="/Users/logout"><i class="fa fa-money"></i> Logout </a></li>
</ul>
<?php endbuild()?>

<?php occupy('templates.users.sidebar.version2.template')?>
