<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo SITE_NAME?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo URL.DS.'vendors/landing/assets/img/favicon.png'?>" rel="icon">
  <link href="<?php echo URL.DS.'vendors/landing/assets/img/apple-touch-icon.png'?>" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="<?php echo URL.DS.'vendors/landing/assets/vendor/aos/aos.css'?>" rel="stylesheet">
  <link href="<?php echo URL.DS.'vendors/landing/assets/vendor/bootstrap/css/bootstrap.min.css'?>" rel="stylesheet">
  <link href="<?php echo URL.DS.'vendors/landing/assets/vendor/bootstrap-icons/bootstrap-icons.css'?>" rel="stylesheet">
  <link href="<?php echo URL.DS.'vendors/landing/assets/vendor/boxicons/css/boxicons.min.css'?>" rel="stylesheet">
  <link href="<?php echo URL.DS.'vendors/landing/assets/vendor/glightbox/css/glightbox.min.css'?>" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="<?php echo URL.DS.'vendors/landing/assets/css/style.css'?>" rel="stylesheet">
  <script src="<?php echo URL?>/js/core/jquery.js"></script>
  <script src="<?php echo URL.DS?>js/core/core.js"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="<?php echo URL?>"><?php echo SITE_NAME?><span>.</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
         <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a> -->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="/pages">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About Us</a></li>
          <!-- <li><a class="nav-link scrollto" href="#portfolio">Portfolio</a></li> -->
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="getstarted scrollto" href="/users/login">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <?php produce('section')?>

  <main id="main" style="min-height: 50vh;">
    <?php produce('content')?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row  justify-content-center">
          <div class="col-lg-6">
            <h3><?php echo SITE_NAME?></h3>
          </div>
        </div>
        <div class="row footer-newsletter justify-content-center">
          <div class="col-lg-6">
            <form action="" method="post">
              <input type="email" name="email" placeholder="Enter your Email"><input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span><?php echo SITE_NAME?></span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo URL.DS.'vendors/landing/assets/vendor/aos/aos.js'?>"></script>
  <script src="<?php echo URL.DS.'vendors/landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
  <script src="<?php echo URL.DS.'vendors/landing/assets/vendor/glightbox/js/glightbox.min.js'?>"></script>
  <script src="<?php echo URL.DS.'vendors/landing/assets/vendor/isotope-layout/isotope.pkgd.min.js'?>"></script>
  <script src="<?php echo URL.DS.'vendors/landing/assets/vendor/swiper/swiper-bundle.min.js'?>"></script>
  <script src="<?php echo URL.DS.'vendors/landing/assets/vendor/php-email-form/validate.js'?>"></script>
  <!-- Template Main JS File -->
  <script src="<?php echo URL.DS.'vendors/landing/assets/js/main.js'?>"></script>
  <script src="<?php echo URL.DS?>js/core/global.js"></script>
  <?php produce('scripts')?>
</body>
</html>