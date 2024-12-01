<?php build('nav')?>
<div class="row">
    <div class="container-fluid col-md-7" style="background-color: #eee;">
        <div class="row">
            <div class="col-md-3">
                <div class="nav-widget">
                    <label for="#">Finance</label>
                    <div class="links">
                        <a href="/account/list"> <small>Accounts</small> </a>
                        <a href="/FNBranch/make_branch"> <small>Branch</small> </a>
                        <a href="/FNCodeInventory/make_code"> <small>Codes</small> </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="nav-widget">
                    <label for="#">Logs</label>
                    <div class="links">
                        <a href="/FNCashAdvance/register_just_now" title="register today"> <small>Today</small> </a>
                        <a href="/ActiveAccounts/"> <small>Active</small> </a>
                        <a href="/UserLogger/get_user_login"> <small>All</small> </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="nav-widget">
                    <label for="#">Utilities</label>
                    <div class="links">
                        <a href="/FacebookStream"> <small>Live</small> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <ul class="nav navbar-nav navbar-right">  
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" 
                aria-expanded="false"><img src="/images/user.png" alt="" style="float:left">
                <?php echo get_user_username();?> 
                <span class=" fa fa-angle-down"></span>

                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="/AccountProfile"><i class="fa fa-user"></i>  Profile</a></li>
                    <li><a href="/users/changepassword"><i class="fa fa-cog"></i> Change Password</a></li>                                <li><a href="/users/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                </ul>
            </li>      
        </ul>
    </div>
</div>

<?php endbuild() ?>


<?php occupy('templates.users.nav.template')?>