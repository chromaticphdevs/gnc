<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
    <h1 class="ui header">ID Picture</h1>
    <h3 class="ui message info">ID Picture (<?php echo $position ?>)</h3>
    <?php Flash::show();?>

    <section id="userInfo">
      <div class="ui segment">
        <p>Name :<?php echo $userData['fullname']?> </p>
      </div>
    </section>
    <section id="photobooth">
      <img src="" id="image">
      <input type="hidden" name="send_image" id="send_image">
      <canvas style="display: none"></canvas>
      <video id="video" autoplay muted></video>
    </section>

    <section>
      <form method="post" id="photobooth_control">
        <input type="hidden" id="position" value="<?php echo $position?>">
        <input type="hidden" id="userid" name="userid" value="<?php echo $userData['id']?>">
         <input type="hidden" id="branch_id" name="branch_id" value="<?php echo $userData['branch_id']?>">
        <input type="hidden" id="classid" name="classid" value="<?php echo $userData['classid']?>">
        <button class="ui button positive login">Capture</button>
      </form>
    </section>
  </main>
<script type="text/javascript" defer>
  $( document ).ready(function(){

   
      const video = document.querySelector('video');

      const btnLogin = document.querySelector("#btnTimeIn");


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
    var branch_id=$("#branch_id").val();


    $.ajax({
      method: "POST",
      url: get_url('/LDUser/save_id_image'),
      data:{userid: $("#userid").val() , 
      branch_id: branch_id,
      image:$("#send_image").val() , 
      position:$("#position").val()},

      success:function(response)
      {
        console.log(branch_id);
            console.log(response);
        let returnData = JSON.parse(response);
  
        if(returnData.status == 'success')
        {
          if(returnData.msg == 'front')
          {
             window.location = get_url('LDUser/id_capture/?position=back');

          }else{
             window.location = get_url('LDUser/profile');
          }
        }else{
          alert("Oppps something went wronging");
        }
      }
    });
    // login($("#to_send_image").val());
  }
  </script>
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
