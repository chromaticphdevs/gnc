<?php include_once VIEWS.DS.'templates/market/header.php'?>

<script type="text/javascript" src="<?php echo URL.DS.'js/emp_login_beta.js'?>"></script>
<style type="text/css">
  
  video
  {
    width: 720;
    height: 500;
  }
</style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
              <div>
                <?php Flash::show();?>
                <section id="photobooth">
                  <img src="" id="image">
                  <input type="hidden" name="send_image" id="send_image">
                  <input type="hidden" name="userid" id="userid" value="<?php echo $empid;?>">
                  <canvas style="display: none"></canvas>
                  <video id="video" autoplay muted></video>
                </section>

                <button id="btnLogin" class="btn btn-success">Login</button>
              </div>
        </div>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>