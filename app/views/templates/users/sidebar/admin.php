<?php $user_type = 'admin';?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu">

            <!-- LEVEL 1 -->
            <li class="current-page">
                <a href="/<?php echo $user_type?>/">
                <i class="fa fa-dashboard"></i>
                Dashboard </a>
            </li>
            <li>
                <a href="/affiliates/dbbi_refferal_link"><i class="fa fa-magnet" aria-hidden="true"></i>Referral Link</a>
            </li>
            <li class="">
                <a>
                    <i class="fa fa-sitemap" aria-hidden="true"></i>Geneology <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu" style="display: none;">
                    <li class="current-page"><a href="/geneology/binary">Binary</a></li>
                    <li class="current-page"><a href="/geneology/binary?level=5">5th Level</a></li>
                    <li><a href="/geneology/unilevel">Unilvl</a></li>
                </ul>
            </li>
            <li>
                <a href="/userBinary/get_transactions"><i class="fa fa-line-chart" aria-hidden="true"></i>
                Binary Transactions</a>
            </li>
            <li>
                <a href="/commissions/getAll"><i class="fa fa-money" aria-hidden="true"></i>Commissions</a>
            </li>
            <li><a><i class="fa fa-balance-scale" aria-hidden="true"></i> Payout<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none;">
                    <li class="current-page"><a href="/MGPayout/create_payout">Generate</a></li>
                    <li class="current-page"><a href="/MGPayout/list">List</a></li>

                </ul>
            </li>
            <li>
                <a href="/Sne/get_toppers"><i class="fa fa-bolt"></i> Break-Through </a>
            </li>
            <li><a><i class="fa fa-users" aria-hidden="true"></i> Accounts  <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/account/list">List</a></li>
                    <li><a href="/AccountsDbbi/get_list">Breakthrough list</a></li>
                    <li><a href="/account/searchUser">Search</a></li>
                </ul>
            </li>
            <!-- // LEVEL 1 -->

            <!-- UTILITIES -->
            <li><a><i class="fa fa-user"></i> Utilities  <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li>
                        <a href="/Activation/create_code"><!-- <i class="fa fa-folder-open" aria-hidden="true"></i>-->Activation Codes</a>
                    </li>

                    <li class="current-page">
                        <a href="/FacebookStream/index"> <!-- <i class="fa fa-camera"></i> -->Live </a>
                    </li>
                    
                    <li>
                        <a href="/RFID_Register"><!-- <i class="fa fa-key" aria-hidden="true"></i> -->
                        RFID</a>
                    </li>
                    <li class=""><a><i class="fa fa-angle-double-down" aria-hidden="true"></i> Downline Levels
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                        
                            <li class="current-page" ><a href="/FNDownlineLevel/list_all_second_lvl">Second Level List</a></li>
                            <li class="current-page" ><a href="/FNDownlineLevel/list_all_third_lvl">Third Level List</a></li>
                            <li class="current-page" ><a href="/FNDownlineLevel/list_all_fourth_lvl">Fourth Level List</a></li>
                            <li class="current-page" ><a href="/FNDownlineLevel/list_all_fifth_lvl">Fifth Level List</a></li>
                        
                        </ul>
                    </li>

                    <li class=""><a><i class="fa fa-angle-double-down" aria-hidden="true"></i> Downline Levels All
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                        
                            <li class="current-page" ><a href="/FNDownlineLevelAll/list_all_second_lvl">Second Level List</a></li>
                            <li class="current-page" ><a href="/FNDownlineLevelAll/list_all_third_lvl">Third Level List</a></li>
                            <li class="current-page" ><a href="/FNDownlineLevelAll/list_all_fourth_lvl">Fourth Level List</a></li>
                            <li class="current-page" ><a href="/FNDownlineLevelAll/list_all_fifth_lvl">Fifth Level List</a></li>
                        
                        </ul>
                    </li>

                    <li class=""><a><i class="fa fa-angle-double-down" aria-hidden="true"></i> Logs
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <li class="current-page"><a href="/FNCashAdvance/register_just_now">Register Just Now</a></li>
                            <li class="current-page"><a href="/UserLogger/get_user_login"> Users logged</a></li>
                            <li class="current-page"><a href="/charts/registration_line_graph">Daily Enties Graph</a></li>
                        </ul>
                    </li>


                    <li class=""><a><i class="fa fa-angle-double-down" aria-hidden="true"></i> Tools
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <li class="current-page"><a href="/RandomUserPicker">Random User</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- // UTILITIES -->


            <!-- FINANCE -->

            <li class=""><a><i class="fa fa-university" aria-hidden="true"></i> Finance
                <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none;">      
                    <li class=""><a><i class="fa fa-angle-double-down" aria-hidden="true"></i> Cash Assistance
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <li><a href="/FNCashAdvance/request_list_all">Requests</a></li>
                            <li><a href="/FNCashAdvance/approval_list_all">Approvals</a></li>
                        </ul>
                    </li>
                    <li class=""><a><i class="fa fa-angle-double-down" aria-hidden="true"></i> Product Assistance
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <li><a href="/FNSinglebox/make_assistance">Request</a></li>
                            <li><a href="/FNCashAdvance/qualification_list_all">Qualificationst</a></li>
                        </ul>
                    </li>
                    <li class="current-page"><a href="/FNIndex/index">Portal</a></li>
                </ul>
            </li>

            <!-- // FINANCE -->
        </ul>
    </div>
</div>