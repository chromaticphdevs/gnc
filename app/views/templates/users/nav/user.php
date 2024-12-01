<?php build('nav') ?>

<?php
    $selfie = null;
    if(Session::check('USERSESSION')) {
        $selfie = Session::get('USERSESSION')['selfie'];
    }
    
    //check if selfie is empty

    if(is_null($selfie)) {
        $img = URL.DS.'uploads/main_user_icon.png';
    }else{
        $img = GET_PATH_UPLOAD.DS.'profile'.DS.$selfie;
    }
?>
<ul class="nav navbar-nav navbar-right">  
    <li class="">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" 
        aria-expanded="false"><img src="<?php echo $img?>" alt="" style="float:left">
        <?php echo get_user_username();?>  <?php echo userVerfiedText(whoIs())?>
        <span class=" fa fa-angle-down"></span>

        </a>
        <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="/AccountProfile"><i class="fa fa-user"></i>  Profile</a></li>
            <li><a href="/users/changepassword"><i class="fa fa-cog"></i> Change Password</a></li>                                <li><a href="/users/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
        </ul>
    </li>      
</ul>

<?php endbuild()?>
<?php occupy('templates.users.nav.template')?>