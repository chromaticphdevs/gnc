<!DOCTYPE html>
<html>
<head>
    <meta property="og:image" content="<?php echo URL.DS?>uploads/money_money.png"/>
    <meta property="og:type" content="image/jpeg"/>
    <meta property="og:width" content="300"/>
    <meta property="og:height" content="300"/>
    <title><?php echo SITE_NAME?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="<?php echo URL.DS.'uploads/main_icon.png'?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/global.css">

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D7Y8CNYV1Z"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-D7Y8CNYV1Z');
    </script>
    <!--- PANEL THEME -->

    <?php

        if(Session::check('USERSESSION'))
        {
            $user = Session::get('USERSESSION');
            if($user['status'] != 'pre-activated'){

                switch (strtolower($user['status'])) {
                    case 'starter':
                        $theme = 'starter';
                        break;
                    case 'bronze':
                        $theme = 'bronze';
                        break;
                    case 'silver':
                        $theme = 'silver';
                        break;
                    case 'gold':
                        $theme = 'gold';
                        break;
                    case 'platinum':
                        $theme = 'platinum';
                        break;
                    case 'diamond':
                        $theme = 'diamond';
                        break;
                    case 'approved_loan':
                        $theme = 'approved_loan';
                        break;
                    case 'reseller':
                        $theme = 'reseller';
                        break;
                }
                ?>
                <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/themes/<?php echo $theme.'.css'?>">
                <?php
            }
        }

    ?>
    <!-- -->
    <script src="<?php echo URL?>/js/core/conf.js"></script>
	<script src="<?php echo URL?>/js/core/jquery.js"></script>

    <?php produce('headers')?>
