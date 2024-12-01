<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">

        <li title="Send Cash to main branch">
        	<a href="/FNDeposit/make_deposit">
        		<i class="fa fa-paper-plane" aria-hidden="true"></i> Remit
        	</a>
    	</li>

         <?php
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
        ?>

         <!--?php if($branchid == 8): ?>-->
         <li><a href="/Timekeeping" target="_blank"><i class="fa fa-clock-o"></i> Timekeeping </a></li>
        <li>
            <a><i class="fa fa-dropbox" aria-hidden="true"></i>
                Product Released<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
               <li><a href="/FNProductBorrower/get_product_borrower"> Qualified Product Borrower</a></li>
               <li><a href="/FNProductBorrower/search_user"> Search Client</a></li>
               <li><a href="/FNProductBorrower/get_released_product_users/Approved"> Released Product (Client List)</a></li>
               <li><a href="/FNProductBorrower/get_payment_list_pending"> Payment Approval  </a></li>

            </ul>
        </li>




        <li >
           <a href="/FNCashier/get_cash_inventory_all"> 
                <i class="fa fa-money" aria-hidden="true"></i> Cashier's Cash Inventory
            </a>
        </li>

         <!--?php endif; ?>-->


        <li>
        	<a><i class="fa fa-info-circle" aria-hidden="true"></i>
        		Transactions<span class="fa fa-chevron-down"></span>
        	</a>
            <ul class="nav child_menu">
               <li><a href="/FNCashInventory/get_transactions"> Cash</a></li>
        	   <li><a href="/FNItemInventory/get_transactions"> Inventory  </a></li>
            </ul>
        </li>

        <li><a><i class="fa fa-key" aria-hidden="true"></i> Activation Codes  <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
               <li><a href="/FNCodeInventory/purchase_code">Purchase </a></li>
        	   <li><a href="/FNCodePurchase/claim_purchase">Release</a></li>
            </ul>
        </li>

        <li>
        	<a href="/FNSinglebox/claim_assistance_search">
        		<i class="fa fa-shopping-bag" aria-hidden="true"></i>
        		Product Advance-Claim-Pay
        	</a>
    	</li>

        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>

    </ul>
    </div>
</div>
