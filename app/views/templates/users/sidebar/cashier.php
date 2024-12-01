<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">


        <?php
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
        ?>
        <!--?php if($branchid == 8): ?>-->

            <li><a href="/Timekeeping" target="_blank"><i class="fa fa-clock-o"></i> Timekeeping </a></li>
            <li>
                <a><i class="fa fa-search" aria-hidden="true"></i>
                   Search Client<span class="fa fa-chevron-down"></span>
                </a>
                
                <ul class="nav child_menu">
                   <li><a href="/ProductPurchase/"> Advance / Payment</a></li>
                   <li><a href="/FNProductAdvance/"> Product Advance</a></li>
                   <li><a href="/OrderingSystem/">Ordering System</a></li>
                   
                   <!--<li><a href="/ProductPurchase/repeat_purchase_search"> Repeat Purchase Payment</a></li>
                   <li><a href="/ClientPaymentSearch/"> Released Product </a></li>-->
                </ul>
            </li>

            <li>
                <a href="/ShipmentSearch/index">
                    <i class="fa fa-search" aria-hidden="true"></i>  Search Shipment
                </a>
            </li>


            <!--<li>
                <a href="/FNProductBorrower/get_released_product_users/Approved">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>  Released Product ( Client List )
                </a>
            </li>-->

            <li>
                <a href="/FNProductBorrower/get_released_rice/Approved">
                    <i class="fa fa-list-ul" aria-hidden="true"></i> Rice Loan ( Client List )
                </a>
            </li>

           <li>
            <a href="/FNCashAdvance/cash_advance_list">
                <i class="fa fa-list" aria-hidden="true"></i>Cash Advance List
            </a>
          </li>

         <!--?php endif; ?>-->

        <!--<li>
            <a href="/FNCodeInventory/purchase_code">
                <i class="fa fa-key"></i> Code Purchase
            </a>
        </li>

        <li>
            <a href="/FNSinglebox/status_list_by_branch">
                <i class="fa fa-key"></i> Product Advance list( Single box )
            </a>
        </li>

        <li>
            <a href="/FNSinglebox/claim_assistance_search">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i> Pay Product Advance
            </a>
        </li>
  
        <li>
            <a><i class="fa fa-list-ul" aria-hidden="true"></i>
                Expense Requests<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
               <li><a href="/Expense/make_request"> Delivery Fee Request</a></li>
               <li><a href="/Expense/get_approved"> Release</a></li>
               <li><a href="/Expense/get_released"> Released List</a></li>

               
            </ul>
        </li>-->
        <li>
            <a href="/FNCashInventory/get_transactions">
                <i class="fa fa-info-circle" aria-hidden="true"></i> Cash Transactions
            </a>
        </li>

         <li>
            <a href="/FNItemInventory/get_branch_inventory_all/<?php echo seal($branchid)?>">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>  Branch Stocks
            </a>
        </li>

        <li>
            <a href="/FNDeposit/make_deposit">
                <i class="fa fa-paper-plane" aria-hidden="true"></i> Remit
            </a>
        </li>

        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>
    </ul>
    </div>
</div>
