
<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
  
   

    <section id="userInfo">
       <?php Flash::show();?>
     <h1 class="ui header">Upload Collateral Image</h1>
    </section>
    <section id="photobooth">
      <img src="" id="image">
      <input type="hidden" name="send_image" id="send_image">
      <input type="hidden" name="loanID" id="loanID" value="<?php echo $_GET['loanID'];?>">

      <canvas style="display: none"></canvas>
      <video id="video" autoplay muted></video>
    </section>


    <input type="hidden" id="camera_mode" value="
    <?php
    if(isset($_GET['cam_mode'])){
      echo $_GET['cam_mode'];
    }else{
     echo "1";
    }

    ?>">



    <section>
      <form method="post" id="photobooth_control">
       <input type="hidden" id="userType" name="userType" value="<?php echo Session::get('user')['type']?>">
        <button class="ui button positive login">Capture</button>
        <button class="ui button negative cancel">Cancel</button>
      </form>
    </section>
  </main>
<script type="text/javascript" defer>
  $( document ).ready(function(){

    
      const video = document.querySelector('video');

      const btnLogin = document.querySelector("#btnTimeIn");

      var check_cam_mode=$("#camera_mode").val();
      console.log(check_cam_mode);

   

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
            var loanID =$("#loanID").val();
 
                window.location = get_url('LDProductAdvance/preview_collateral/'+loanID);
           
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


    var loanID=$("#loanID").val();
    var userType=$("#userType").val();
    $.ajax({
      method: "POST",
      url: get_url('/LDProductAdvance/upload_collateral'),
      data:{loanID: loanID , image:$("#send_image").val()},

      success:function(response)
      {

        // let returnData = JSON.parse(response);
          console.log(response);
        if(response == "")
        { 
            if(userType=="customer"){

              window.location = get_url('LDProductAdvance/preview_collateral/'+loanID);
          
            }else{

               window.location = get_url('LDUser/profile/');
           
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
