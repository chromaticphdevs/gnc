<?php 
    $user_type = Auth::user_position();
    
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }

    if(Session::get('USERSESSION')['type'] == '2') 
    {
        combine('templates.users.sidebar.version2.main');
    }else{
        combine('templates.users.sidebar.version2.admin');
    }
?>