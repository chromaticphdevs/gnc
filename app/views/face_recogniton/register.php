<!DOCTYPE html>
<html>
<head>
  <script src="<?php echo URL?>/js/core/jquery.js"></script>
  <script src="<?php echo URL?>/js/core/conf.js"></script>
  <title></title>
</head>
<body>
  
  <form action="" class="form-control">
        <div class="form-group">
          <label for="#">Fullname</label>
          <input type="text" name="fullname" id="fullname" value="Mark">
        </div>

        <div class="form-group">
          <label for="#">Age</label>
          <input type="text" name="age" id="age" value="12">
        </div>

        <div class="form-group">
          <label for="#">Gender</label>
          <select name="gender" id="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
      </form>

      <section id="photobooth">
        <img src="" id="image">
        <input type="hidden" name="send_image" id="send_image">
        <canvas style="display: none"></canvas>
        <video id="video" autoplay muted></video>
      </section>

      <section>
        <form method="post" id="photobooth_control">
          <button id="btnSendImage">Submit Image</button>
        </form>
      </section>
  
      <h3>
        <a href="/FaceRecognition/login_user">Login</a>
      </h3>
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

              url:get_url('FaceRecognition/register_user'),

              data:{
                image:$("#send_image").val() , 
                fullname:$("#fullname").val(),
                age:$("#age").val(),
                gender:$("#gender").val()
              },

              success:function(response) 
              {
                if(response == 'Face Added Successfuly') {
                  
                  window.location = get_url('FaceRecognition/login_user');
                  
                }else{
                  alert("Something went wrong");
                }
                // if(response == 'ok')
                // {
                //   window.location = get_url('FaceRecognition/login_user');
                // }else{
                //   alert("ERROR CHECK CONSOLE");
                //   console.log(response);
                // }
              }
          });
      }
    </script>
</body>
</html>