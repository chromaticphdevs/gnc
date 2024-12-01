<?php include_once VIEWS.DS.'templates/market/header.php'?>
</head>
<body id="page-top">
    <div class="overlay-mf"></div>
    <div class="container">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="home" class="box-shadow-full">
              <h1>Facial Recognition Activaton <span class="alert-danger">BETA</span></h1>

              <form action="/SNEFacialRecognition/face_auth_activation_login" method="post">
                <p>Improving the quality of our service by giving you the latest techonogies in the market.</p>

                <div class="alert alert-warning">
                  <p class="alert-msg">
                    <p class="text-danger">Loggin your account for face auth activation</p>
                  </p>
                </div>
                <?php Flash::show()?>
                <div class="form-group">
                  <label for="">Username</label>
                  <input type="text" name="username" class="form-control">
                  <small>Social Network username</small>
                </div> 

                <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" name="password" class="form-control">
                   <small>Social Network password</small>
                </div> 

                <input type="submit" class="btn btn-primary" value="Login">
                <hr>
                <div> <a href="/SNEFacialRecognition/face_auth_login">I already activated my face authentication</a> </div>

                <div><a href="/users/login">Take me back to manual Login</a></div>

              </form>
            </div>
          </div>
        </div>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>