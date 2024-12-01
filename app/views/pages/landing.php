<?php build('section')?>
<!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="container">
      <div class="row d-flex align-items-center"">
      <div class=" col-lg-6 py-5 py-lg-0 order-2 order-lg-1" data-aos="fade-right">
        <h1>General Network Corporation</h1>
        <h2>We are inspired to help your dreams come<span style="font-weight: bold;">through</span> </h2>
        <a href="/users/login" class="btn-get-started scrollto">Login</a>
        <a href="/toolController/downloadApp" class="btn-get-started scrollto">Download Apps</a>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
        <img src="<?php echo URL.DS.'vendors/landing/assets/img/hero-img.png'?>" class="img-fluid" alt="">
      </div>
    </div>
    </div>
  </section><!-- End Hero -->
<?php endbuild()?>

<?php build('content')?>
<!-- ======= Features Section ======= -->
    <!-- <section id="features" class="features section-bg">
      <div class="container">

        <div class="section-title">
          <h2 data-aos="fade-in">Benefits</h2>
          <p data-aos="fade-in">We provide our members to leverange amazing incentives from the company</p>
        </div>

        <div class="row content">
          <div class="col-md-5" data-aos="fade-right">
            <img src="<?php echo URL.DS.'vendors/landing/assets/img/features-4.svg'?>" class="img-fluid" alt="">
          </div>
          <div class="col-md-7 pt-4" data-aos="fade-left">
            <h3>Income Generation</h3>
            <p class="fst-italic">
              list of ways to earn money through our platform. 
            </p>
            <ul>
              <li><i class="bi bi-check"></i> Direct Referral Commission.</li>
              <li><i class="bi bi-check"></i> Binary Commission.</li>
              <li><i class="bi bi-check"></i> Gift Cheques.</li>
              <li><i class="bi bi-check"></i> Personal Points.</li>
            </ul>
          </div>
        </div>
      </div>
    </section> -->
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>