<?php build('nav') ?>
<ul class="nav navbar-nav navbar-right">  
    <li class="">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" 
        aria-expanded="false"><img src="/images/user.png" alt="" style="float:left">
        <?php echo get_user_username();?> 
        <span class=" fa fa-angle-down"></span>
        </a>
        <ul class="dropdown-menu dropdown-usermenu pull-right">                       
            <li><a href="/FNManager/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
        </ul>
    </li>      
</ul>
<?php endbuild()?>

<?php occupy('templates.users.nav.template')?>