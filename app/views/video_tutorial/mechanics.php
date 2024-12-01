<!DOCTYPE html>
<html lang="en">
<head>
    <meta property="og:image" content="<?php echo URL.DS?>uploads/money_money.png"/>
    <meta property="og:type" content="image/jpeg"/>
    <meta property="og:width" content="300"/>
    <meta property="og:height" content="300"/>
  <title>Mechanics</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
  <link rel="icon" type="image/png" href="<?php echo URL.DS.'old/uploads/main_icon.png'?>"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'old/form/bootstrap/css/bootstrap.min.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'fonts/font-awesome-4.7.0/css/font-awesome.min.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'fonts/Linearicons-Free-v1.0.0/icon-font.min.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'old/form/animate/animate.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'old/form/css-hamburgers/hamburgers.min.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'old/form/select2/select2.min.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/form/util.css'?>">
  <link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/form/main.css'?>">
<!--===============================================================================================-->
<script type="text/javascript" src="<?php echo URL.DS.'js/core/conf.js'?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BVLNM3B8NX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BVLNM3B8NX');
</script>
<!--===============================================================================================-->
<style>
video {
  max-width: 100%;
  max-height:40%;
}
</style>


</head>
<body>

  <div class="limiter">
    <div class="container-login100">


        <center> 
        <video id="vid" controls>
          <source src="<?php echo URL.DS.'uploads/video/video_2021-01-11_16-18-27.mp4'?>" type="video/mp4">
          <source src="movie.ogg" type="video/ogg">
        </video>
         <br>
          <div class="container-login100-form-btn p-t-25">
            <a class="login100-form-btn"  href="https://breakthrough-e.com/users/login" target="_blank">
              Login Now
            </a>
          </div>
      </center>
     

       
    </div>
    </div>
  </div>

  <script src="<?php echo URL.DS.'old/form/jquery/jquery-3.2.1.min.js'?>"></script>
<!--===============================================================================================-->
  <script src="<?php echo URL.DS.'old/form/bootstrap/js/popper.js'?>"></script>
  <script src="<?php echo URL.DS.'old/form/bootstrap/js/bootstrap.min.js'?>"></script>
<!--===============================================================================================-->
  <script src="<?php echo URL.DS.'old/form/select2/select2.min.js'?>"></script>
<!--===============================================================================================-->
  <script src="<?php echo URL.DS.'old/form/tilt/tilt.jquery.min.js'?>"></script>
 
 <script  type="text/javascript" defer>

    $( document ).ready( function() {

       var elVideoControl= $("#vid");
             //when user leaves the tab or back to the tab
        $(window).focus(function() {
            elVideoControl.trigger('play');
            //do something
        });

    });
</script>
</body>
</html>
