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
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section active">
        <ul class="nav side-menu" style="">
        <li class="current-page"><a href="/<?php echo $user_type?>/"><i class="fa fa-dashboard"></i>
        Dashboard </a></li>           
        <li><a href="/market/index"><i class="fa fa-shopping-bag"></i> Market Place </a></li>    
        <li><a><i class="fa fa-desktop"></i> Store  <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="/storeProduct/list">Products</a></li>       
               <!--  <li><a href="http://acme.merhcants.shop.com/stores/my_store">My Store</a></li>          
                <li><a href="#">Orders</a></li> -->
            </ul>
        </li>
        <li><a href="/affiliates/index"><i class="fa fa-thumbs-o-up"></i> Referral Link</a></li>
         <li class=""><a><i class="fa fa-group"></i> Commissions <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none;">                  
                <li class="current-page"><a href="/commissions/binaryCommissions">Binary</a></li>
                <li class="current-page"><a href="/commissions/directsponsors">Sponsor</a></li>
                <li class="current-page"><a href="/commissions/getAll">All</a></li>
             <!--    <li class="current-page"><a href="/commissions/all">All</a></li> -->
                <!-- <li><a href="/admin/reports/volume">Volume Details</a></li>      -->
            </ul>
        </li>
        <?php if( $user_type == 'admin' ) : ?>
        <li><a><i class="fa fa-thumbs-o-up"></i> Payouts  <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none;">                
                <li class="current-page"><a href="/payouts/index">Generate</a></li>
                <li class="current-page"><a href="/payouts/list">List</a></li>
             <!--    <li class="current-page"><a href="/commissions/all">All</a></li> -->
                <!-- <li><a href="/admin/reports/volume">Volume Details</a></li>      -->
            </ul>
        </li> 
        
        <?php endif;?>

        <?php if( $user_type == 'users') : ?>
        <li><a href="/users/old_isp"><i class="fa fa-thumbs-o-up"></i> ISP</a></li>
        <li><a href="/userspayout"><i class="fa fa-shopping-bag"></i> Payouts </a></li>
        <?php endif;?>
        <li class=""><a><i class="fa fa-group"></i> Geneology <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none;">                  
                <li class="current-page"><a href="/geneology/binary">Binary</a></li>
                <li><a href="#">Unilvl</a></li>
                <!-- <li><a href="/admin/reports/volume">Volume Details</a></li>      -->
            </ul>
        </li>
        <li class=""><a><i class="fa fa-group"></i> Binary Details <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none;">                  
                <li class="current-page"><a href="/users/binaryPoints">Leg Details</a></li>
                <!-- <li><a href="/binary/downlines">Downlines</a></li> -->
                <!-- <li><a href="/admin/reports/volume">Volume Details</a></li>      -->
            </ul>
        </li>

        <li class=""><a><i class="fa fa-dropbox"></i> Orders <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none;">                  
                <li class="current-page"><a href="/orders/list">View All</a></li>
                <!-- <li><a href="/admin/reports/volume">History</a></li>      -->
            </ul>
        </li>

        <?php if( $user_type == 'admin' ) : ?>
        <li><a><i class="fa fa-thumbs-o-up"></i> ISP  <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="/ISP/index"><i class="fa fa-thumbs-o-up"></i> ISP</a></li>
                <li><a href="/ISP/top"><i class="fa fa-thumbs-o-up"></i> TOP 100</a></li>    
                <li><a href="/ISP/top/1000"><i class="fa fa-thumbs-o-up"></i> TOP 1000</a></li>    
               <!--  <li><a href="http://acme.merhcants.shop.com/stores/my_store">My Store</a></li>          
                <li><a href="#">Orders</a></li> -->
            </ul>
        </li>
        <?php endif;?>
        <li><a href="/users/logout"><i class="fa fa-sign-out"></i> Logout </a></li>
    </ul>
    </div>
</div>