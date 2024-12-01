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
	<h3>Capture your supermodel face.</h3>

	<div class="flex-row">
		
		<div class="basic-info">
			<ul>
				<li>Name: <?php echo $user->fullname?></li>
				<li>Username: <?php echo $user->username?></li>
			</ul>
		</div>

		<div class="photobooth">
			<section id="photobooth">
				<img src="" id="image">

				<input type="hidden" name="send_image" id="send_image">

				<canvas style="display: none"></canvas>

				<video id="video" autoplay muted></video>
			</section>

			<section>
				<form method="post" id="photobooth_control">
				  <button id="btnSendImage">Activate Face Auth</button>
				</form>
			</section>
		</div>
	</div>
	
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

          url:get_url('SNEFacialRecognition/face_auth_activation'),

          data:{
            image:$("#send_image").val()
          },

          success:function(response) 
          {


          	if(response == 'ok') 
            {
          		window.location = get_url('SNEFacialRecognition/face_auth_login');
          	}else{
          		alert("SOMETHING WENT WRONG CHECK CONSOLE F12");

          		console.log(response);
          	}
          }
      });
  }
</script>
</body>
</html>