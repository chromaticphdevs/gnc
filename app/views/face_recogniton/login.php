<!DOCTYPE html>
<html>
<head>
  <script src="<?php echo URL?>/js/core/jquery.js"></script>
  <script src="<?php echo URL?>/js/core/conf.js"></script>
  <title></title>
</head>
<body>
  
  <form action="" class="form-control">
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
        <a href="/FaceRecognition/register_user">Register</a>
      </h3>

      <div id="responseText"></div>
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

              url:get_url('FaceRecognition/login_user'),

              data:{
                image:$("#send_image").val()
              },

              success:function(response) 
              {

                console.log(response);

                if(response == '') {

                  $("#responseText").html('<h1> FACE NOT FOUND </h1>');
                  
                }else if(response == 'user not found'){
                  $("#responseText").html('<h1> USER NOT FOUND </h1>');
                }else{
                  response = JSON.parse(response);

                  let makeHtml = `
                    <div> 
                      <img src='${response.imageWithPath}'> </img>
                      <h2> ${response.fullname} </h2>
                      <p> Age : ${response.age}  Gender : ${response.gender}</p>
                    </div>
                  `;
                  $("#responseText").html(makeHtml);
                }
                

              }
          });
      }
    </script>
</body>
</html>