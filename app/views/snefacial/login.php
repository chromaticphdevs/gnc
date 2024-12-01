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


<div class="main-content">
	<h3>Take a picture of your face</h3>

  <h1>
    <?php Flash::show()?>
  </h1>
  <div class="photobooth">
    <section id="photobooth">
      <img src="" id="image">

      <input type="hidden" name="send_image" id="send_image">

      <canvas style="display: none"></canvas>

      <video id="video" autoplay muted></video>
    </section>

    <section>
      <form method="post" id="photobooth_control">
        <button id="btnSendImage" style="padding: 10px; background: green; color: #fff">Activate Face Auth</button>
      </form>

      <div>
        <div><a href="/SNEFacialRecognition/face_auth_activation_login">I have not yet activated my Face Auth.</a></div>

        <div><a href="/users/login">Take me back to manual Login</a></div>
        <h1>Idont Have social Network Account</h1>
        <p>
          You need to have a referral link to have an account on Social Network
        </p>
      </div>
    </section>
  </div>
<script>
$( document ).ready(function()
{
    const constraint = {

          video : true
      };

    navigator.mediaDevices.getUserMedia(constraint).then((stream) => {video.srcObject = stream});

    $("#btnSendImage").click(function(evt) {
        sendImage();

        evt.preventDefault();
    });
})



function sendImage()
{
  const canvas = document.querySelector('canvas');
  const image  = document.querySelector('#image');


  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);


  image.src = canvas.toDataURL('image/png');

  $("#send_image").val(canvas.toDataURL('image/png'));


  $.ajax({

          method:'POST' ,

          url:get_url('SNEFacialRecognition/face_auth_login'),

          data:{
            image:$("#send_image").val()
          },

          success:function(response) 
          {
          	if(response == 'ok') 
            {
          		window.location = get_url('users/');

          	}else{
          		alert("SOMETHING WENT WRONG PLEASE TRY AGAIN");
              location.reload();
          	}
          }
      });
  }
</script>
</body>
</html>