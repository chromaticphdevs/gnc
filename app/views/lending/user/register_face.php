<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
    <h1 class="ui header">Face Log</h1>
    <?php Flash::show();?>
    <input type="hidden" id="path" value="<?php echo $_GET['name'];?>">
    <section id="userInfo">
      <div class="ui segment">
       <h2 >Take <strong style="color:green;" id="count_status">1</strong> Pictures</h2> 
        &nbsp; &nbsp; &nbsp;<a id="cam_mode_text" href="<?php echo $_SERVER['REQUEST_URI'].''.$_SERVER['QUERY_STRING']?>&cam_mode=1">| Back Camera |</a>
         &nbsp; &nbsp; &nbsp;<a id="cam_mode_text" href="<?php echo $_SERVER['REQUEST_URI'].''.$_SERVER['QUERY_STRING']?>&cam_mode=0">| Front Camera |</a>
      </div>

    </section>


      <input type="hidden" id="camera_mode" value="
      <?php
      if(isset($_GET['cam_mode'])){
        echo $_GET['cam_mode'];
      }else{
       echo "0";
      }

      ?>">

    <section id="photobooth">
      <img src="" id="image">
      <input type="hidden" name="send_image" id="send_image">
      <canvas style="display: none"></canvas>
      <video id="video" autoplay muted></video>
    </section>

    <section>
        <button id="btn_capture" class="ui button positive login">Capture</button>
       
    
    </section>
  </main>
<script type="text/javascript" defer>
   var count_pic=1;
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


      $(document).on('click', '#btn_capture', function()
       {
        capture_face();
       });
     
     });

  function capture_face()
  {
    const canvas = document.querySelector('canvas');
    const image = document.querySelector('#image');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    $("#send_image").val(canvas.toDataURL('image/jpg'));
  
    var userid=$("#userid").val();
   
    $.ajax({
      method: "POST",
      url: get_url('/LDUser/register_face'),
      data:{
       file_name: count_pic,
       file_path: $("#path").val(), 
       image:$("#send_image").val()
     },

      success:function(response)
      {

        // let returnData = JSON.parse(response);
        console.log(response);
        if(response != "")
        { 
           count_pic=count_pic-1;
          document.getElementById("count_status").innerHTML = count_pic;
         
            if(count_pic==0)
              {
                window.location = get_url('LDUser/id_capture');
              }

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
