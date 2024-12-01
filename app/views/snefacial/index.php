<!DOCTYPE html>
<html>
<head>
	<title>Face Capture</title>
	<script src="<?php echo URL?>/js/core/jquery.js"></script>
  	<script src="<?php echo URL?>/js/core/conf.js"></script>

  	<style>
  		.main-content
  		{
  			width: 500px;
  			margin: 0px auto;
  		}
  	</style>
</head>
<body>

  <div class="container">
    <h1>
          <?php Flash::show()?>
    </h1>
    <div class="row">
      <section class="col-md-5">
        <ul>

          <li>Fullname : <?php echo $user->fullname?></li>
          <li>Username : <?php echo $user->username?></li>

          <li><a href="#">Social Netowork Portal</a></li>
        </ul>
      </section>

      <section class="col-md-7">
        <div style="width: 600px; height: 500px;">
          <div style="width: 100%; border: 5px solid #000">
            <img src="<?php echo URL.DS.'public/assets/'.$face->face_image?>" 
            style="width: 100%; margin: 0px auto">
          </div>

          <h3>Face Auth</h3>
          <p>
            <strong>Face Taken</strong> <br/>

            <?php echo $face->user_agent?><br>

            <strong>Taken On</strong>
            <?php echo $face->created_at?>
          </p>
        </div>
        <a href="/SNEFacialRecognition/logout">Logout</a>
      </section>
    </div>
  </div>
</body>
</html>