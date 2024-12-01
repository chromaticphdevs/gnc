

<?php build('sidebar') ?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
       <ul class="nav side-menu" style="">

        <?php 
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
        ?>
        <li><a href="/Timekeeping" target="_blank"><i class="fa fa-clock-o"></i> Timekeeping </a></li>
        <li>
            <a href="/FNItemInventory/get_branch_inventory_all/<?php echo seal($branchid) ?>">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>  Branch Stocks
            </a>
        </li>

        <li>
            <a href="/FNUserSteps/all_toc_position?forDeliveries">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>For Deliveries</a>
        </li>
        <li>
            <a href="/FNUserSteps/all_toc_position">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>All TOC</a>
        </li>    
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
            <a href="/ShipmentSearch/index">
                <i class="fa fa-search" aria-hidden="true"></i>  Search Shipment
            </a>
        </li>

       <!-- <li>
            <a href="/FNItemInventory/search_user">
                <i class="fa fa-truck" aria-hidden="true"></i>  Add Delivery Info
            </a>
        </li>
         <li>
            <a href="/FNSinglebox/claim_assistance_search">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>  Products Claim
            </a>
        </li>
       ?php if($branchid == 8): ?>
        <li>
            <a href="/FNProductBorrower/get_product_borrower">
                <i class="fa fa-list-ul" aria-hidden="true"></i> Qualified Product Borrower
            </a>
        </li>
         <li>
                <a><i class="fa fa-search" aria-hidden="true"></i>
                   Search Client<span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                   <li><a href="/FNProductAdvance/"> Product Advance</a></li>
                   <li><a href="/ProductPurchase/"> Advance Payment</a></li>
                </ul>
            </li>
        <li>
            <a href="/FNProductBorrower/get_released_product_users/Approved">
                <i class="fa fa-list-ul" aria-hidden="true"></i>  Released Product ( Client List )
            </a>
        </li>-->

         <li>
            <a href="/charts/stock_chart"><i class="fa fa-bar-chart" aria-hidden="true"></i>Charts</a>
        </li>

            
         <!--?php endif; ?>-->       
        <li>
            <a href="/FNItemInventory/get_branch_inventory_with_name">
                <i class="fa fa-info-circle" aria-hidden="true"></i> Inventory Transactions
            </a>
        </li>
        
        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>
    </ul>
    </div>
</div>
<?php endbuild()?>
<?php occupy('templates.users.sidebar.version2.template')?>
