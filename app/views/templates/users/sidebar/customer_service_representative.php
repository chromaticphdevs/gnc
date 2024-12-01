<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">


        <?php
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
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

        <li><a href="/DashboardCSR"><i class="fa fa-clock-o"></i> Dashboard </a></li>
        <!--<li><a href="/Timekeeping" target="_blank"><i class="fa fa-clock-o"></i> Timekeeping </a></li>-->
        <li>    
            <a href="/API_CSR_LOG/get_call_history">
                <i class="fa fa-check-square-o"  aria-hidden="true"></i>
                CSR TimeSheets
            </a>
        </li>

        <li>
            <a><i class="fa fa-list-alt" aria-hidden="true"></i>
                 User List New  <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
                <li><a href="/NewUserFollowUps/getByAddress_sorted">Search By Address Sorted</a></li>
                 <li><a href="/NewUserFollowUps/getByAddress_sorted_globe">Search By Address Sorted (Globe)</a></li>
                <li><a href="/NewUserFollowUps/index">Search By Days</a></li>
                <li><a href="/NewUserFollowUps/getByAddress">Search By Address</a></li>
                <li><a href="/API_CSR_LOG/get_call_history">CSR TimeSheets</a></li>

            </ul>
            <!--<a href="/FNUserSteps/get_position1"><i class="fa fa-money" aria-hidden="true"></i>TOC Passer</a>-->
        </li>
        
        <li><a href="/ProductLoanFollowUps/"><i class="fa fa-list"></i> Released Product ( Client List ) </a></li>
        <li>
            <a><i class="fa fa-check-square-o" aria-hidden="true"></i>
                TOC <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
               <li><a href="/FNUserSteps/get_position1">Step 1</a></li>
               <?php $url = URL.'/test-of-character-passers'?>
               <?php for($i = 2 ; $i <= 19; $i++) :?>
                    <li><a href="<?php echo $url.'/'.intval($i)?>?standby=true">Step <?php echo $i?></a></li>
               <?php endfor?>   
               <li><a href="/TocController/get_standby">Standby List</a></li>
            </ul>
            <!--<a href="/FNUserSteps/get_position1"><i class="fa fa-money" aria-hidden="true"></i>TOC Passer</a>-->
        </li>

        <li>
            <a href="/UserIdVerification/verify_id_list"><i class="fa fa-check-square-o" aria-hidden="true"></i>User's ID Verification</a>
        </li>
         <li>
            <a href="/UserSocialMedia/verify_link_list"><i class="fa fa-link" aria-hidden="true"></i>Social Media Verification</a>
        </li>

        <li><a href="/APKDownload/download"><i class="fa fa-download"></i> Call Center App </a></li>
       
        

        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>
        
    </ul>
    </div>
</div>
