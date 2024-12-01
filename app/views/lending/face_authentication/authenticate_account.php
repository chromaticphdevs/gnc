<?php require_once VIEWS.DS.'lending/template/header.php'?>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
     <br> <br>
    <h1 class="ui header">Authenticate Account</h1>
    <?php Flash::show();?>
    <form class="ui form" method="post" action="/LDUser/login">
      <div class="field">
        <label>Email</label>
        <input type="text" name="email" placeholder="Email" required>
      </div>

      <div class="field">
        <label>Phone Number</label>
        <input type="text" name="phone" placeholder="Phone" required>
      </div>

      <button class="ui button primary" type="submit">Submit</button>
    </form>
     <br> <br>
     

      <?php if(!Cookie::get(seal('dbbicookie'))) :?>
        <div>
          <a href="/LDDeviceActivation/activate_device">Register Device</a>
        </div>
      <?php endif;?>
      <br>
  </main>

              
<?php require_once VIEWS.DS.'lending/template/footer.php'?>

