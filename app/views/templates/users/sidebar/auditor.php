<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">
        <?php
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
        ?>
        <li>
            <a><i class="fa fa-list-ul" aria-hidden="true"></i>
                Expense Requests<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
               <li><a href="/Expense/get_request">Proccess Requests</a></li>
               <li><a href="/Expense/get_approved_history">Approved List</a></li>
               <li><a href="#">Allowance Approval</a></li>
            </ul>
        </li>

        <?php if(isEqual($user->type , 'auditor')) :?>
        <li>
            <a><i class="fa fa-list-ul" aria-hidden="true"></i>
                Timekeeping<span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
               <li><a href="/timekeeping/timesheets">Timesheets</a></li>
               <li><a href="/TKPayout">Payouts</a></li>
               <li><a href="/timekeeping/getUsers">Users</a></li>
               <li><a href="/TimesheetTrash">Trashed Timesheets</a></li>
            </ul>
        </li>
        <?php else:?>

        <li><a href="/timekeeping/timesheets"><i class="fa fa-list"></i> Timesheets </a></li>

        <?php endif;?>
        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>
    </ul>
    </div>
</div>
