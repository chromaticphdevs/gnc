<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
    <h1 class="ui header">Face Log</h1>
    <?php Flash::show();?>

    <section id="userInfo">
      <div class="ui segment">
        <p>Name :<?php echo $userData['fullname']?>  &nbsp; &nbsp; &nbsp;<a id="cam_mode_text" href="/LDUser/face_module2?cam_mode=1">| Back Camera |</a>  &nbsp; &nbsp; &nbsp;<a id="cam_mode_text" href="/LDUser/face_module2?cam_mode=0">| Front Camera |</a></p>
      </div>
    </section>
    <section id="photobooth">
      <img src="" id="image">
      <input type="hidden" name="send_image" id="send_image">
      <canvas style="display: none"></canvas>
      <video id="video" autoplay muted></video>
    </section>


    <input type="hidden" id="camera_mode" value="
    <?php
    if(isset($_GET['cam_mode'])){
      echo $_GET['cam_mode'];
    }else{
     echo "0";
    }

    ?>">



    <section>
      <form method="post" id="photobooth_control">
        <input type="hidden" id="userid" name="userid" value="<?php echo $userData['id']?>">
        <input type="hidden" id="classid" name="classid" value="<?php echo $userData['classid']?>">
        <button class="ui button positive login">Login</button>
        <button class="ui button negative cancel">Cancel</button>
      </form>
    </section>
  </main>
<script type="text/javascript" defer>
  $( document ).ready(function(){

      console.log(get_url('LDUser/cancel_login'));
      const video = document.querySelector('video');

      const btnLogin = document.querySelector("#btnTimeIn");

      var check_cam_mode=$("#camera_mode").val();
      console.log(check_cam_mode);
      if(check_cam_mode==1){

        
 

          const videoConstraints = {};
             videoConstraints.facingMode = 'environment';
          const constraints = {
            video: videoConstraints,
            audio: false
            };

           navigator.mediaDevices
            .getUserMedia(constraints)
            .then(stream => {
              currentStream = stream;
              video.srcObject = stream;
              return navigator.mediaDevices.enumerateDevices();
            })

      }else{




        const constraint = {

          video : true
      };

      
      navigator.mediaDevices.getUserMedia(constraint).then((stream) => {video.srcObject = stream});

      }

     



      $("#btnTimeIn").click(function(evt)
      {
        timeIn();

        evt.preventDefault();
      });

      $("#btnTimeOut").click(function(evt)
      {
        timeOut();

        evt.preventDefault();
      });

      $("#photobooth_control > button").click(function(evt){

          if($(this).hasClass('login')){
              timeIn();
          }

          if($(this).hasClass('cancel')){

            $.ajax({
              'url' : get_url('/LDUser/cancel_login') ,
              'method' : 'POST',
              success:function(result){

                if(result == 'true'){
                  window.location = get_url('LDUser/login');
                }else{
                  console.log(result);
                }
                
              }
            });
          }

          evt.preventDefault();
      });
  });

  function timeIn()
  {
    const canvas = document.querySelector('canvas');
    const image = document.querySelector('#image');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    image.src = canvas.toDataURL('image/png');

    $("#send_image").val(canvas.toDataURL('image/png'));

    var userid=$("#userid").val();

    $.ajax({
      method: "POST",
      url: get_url('/LDUser/push_login'),
      data:{userid: $("#userid").val() , classid : $("#classid").val() , image:$("#send_image").val()},

      success:function(response)
      {

        // let returnData = JSON.parse(response);
      
        if(response != "")
        {
          window.location = get_url('LDUser/register_face?image_name='+response);
        }else{
          console.log(response);
          // alert("ERROR");
        }
      }
    });
    // login($("#to_send_image").val());
  }
  </script>
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
