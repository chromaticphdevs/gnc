<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">


        <?php
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
        ?>
      
        <li><a href="/Timekeeping" target="_blank"><i class="fa fa-clock-o"></i> Timekeeping </a></li>
        <li>
            <a><i class="fa fa-list-ul" aria-hidden="true"></i>
                Expense Requests<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
               <li><a href="/Expense/make_request">Make Request</a></li>
            </ul>
        </li>

        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>
    </ul>
    </div>
</div>
