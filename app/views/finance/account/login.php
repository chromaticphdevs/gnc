<!DOCTYPE html>
<html>
<head>
    <title><?php echo SITE_NAME?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/user/socialplanet.css">

    <script src="<?php echo URL?>/js/conf.js"></script>
    <script src="<?php echo URL?>/js/jquery.js"></script>
</head>
<body>
    <div class="login background">
        <div class="form-wrapper">   
            <form method="post" id="member_login" action="">
                <fieldset>
                    <legend><h3>Managers Login</h3></legend>
                    <?php Flash::show() ?> 
                        <!-- <img src="/images/isocialplanet.png">  -->
                    <div><input type="text" name="username" placeholder="Username"></div>
                    <div><input type="password" name="password" placeholder="Password"></div>
                    <div id="flash_message"></div>
                    <div><button type="submit" class="submit_login">LOG IN</button></div>
                </fieldset>
            </form>
            <!--<p class="registration">Not Registered? <a href="/register.html">Create Account!</a></p>-->
            <div class="separator"> <br>
        </div>
    </div>

    <!-- Custom Theme Scripts -->

    </div>
</body>
</html>