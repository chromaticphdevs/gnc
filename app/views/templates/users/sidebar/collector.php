<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">


        <?php
             $user = Session::get('BRANCH_MANAGERS');
             $branchid = $user->branchid;
        ?>
      
        <li><a href="/Timekeeping" target="_blank"><i class="fa fa-clock-o"></i> Timekeeping </a></li>
        <li><a href="/FNProductBorrower/get_collector_task"><i class="fa fa-list"></i> Released Product ( Client List ) </a></li>
        <li><a href="/FNProductBorrower/get_collector_notes"><i class="fa fa-sticky-note"></i> Created Notes </a></li>
        <li><a href="/FNManager/logout"><i class="fa fa-power-off"></i> Logout </a></li>
    </ul>
    </div>
</div>
