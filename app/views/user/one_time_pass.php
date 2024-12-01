<?php include_once VIEWS.DS.'templates/base/header.php'?>
</head>
<body id="page-top">
     <?php include_once VIEWS.DS.'templates/base/navigation.php'?>

  <!--/ Section login-Footer Star /-->
  <section class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(<?php echo URL.DS.'New_design/img/banner/home-banner.jpg' ?>)">
   
   
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="home" class="box-shadow-full">
              <div class="row">
          
                          <div class="col-md-6">
             
                  <div class="title-box-2">
                    <h5 class="title-left">
                    Please Enter OTP to Login
                    </h5>           
                  </div>
                       <?php Flash::show();?>
                    <form method="post" action="/users/one_time_pass">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="text" class="form-control" name="user_input_otp" placeholder="" data-rule="email" required />
                            <div class="validation"></div>
                          </div>
                        </div>
                      
                        <div class="col-md-12">
                          <button type="submit" class="button button-a button-big button-rouded">Submit</button>
                        </div>
                        <br>
                       
                      </div>
                    </form>
                  </div>

                <div class="col-md-6">
                   <br> <br> <br>
                  <div class="more-info"> 
                     <a href="/">
                   <img width="300" height="300" src="<?php echo URL.DS.'uploads/breakthrough.jpg'?>" style="width: 100%;">
                     </a>
   
                  </div>
          
                </div>

            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="copyright-box">
              <p class="copyright">&copy; Copyright <strong>Breakthrough</strong>. All Rights Reserved</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </section>


  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  

   <?php include_once VIEWS.DS.'templates/base/footer.php'?>