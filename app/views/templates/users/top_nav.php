<?php 
    /** MAIN SYSTEM */
    if(Session::get('USERSESSION'))
    {
        $useSession = Session::get('USERSESSION');

        if($useSession['type'] == '2') {
            combine('templates.users.nav.user');
        }else{
            combine('templates.users.nav.admin');
        }
    }

    /** FINANCE SYSTEM */

    if(Session::get('BRANCH_MANAGERS'))
    {
        combine('templates.users.nav.finance');
    }
?>