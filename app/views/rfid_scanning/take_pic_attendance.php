
<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
  
   

    <section id="photobooth">
      <img src="" id="image">
      <input type="hidden" name="send_image" id="send_image">
      <canvas style="display: none"></canvas>
      <video id="video" autoplay muted></video>
    </section>



    <section>
     
       <input type="hidden" id="UID_code" name="UID_code" value="<?php echo $_GET['UID']; ?>">

    </section>


  </main>
<script type="text/javascript" defer>

   var takePic ;
  $( document ).ready(function(){

      
      
      const video = document.querySelector('video');


  
         const constraint = {

          video : true
      };

      

      navigator.mediaDevices.getUserMedia(constraint).then((stream) => {video.srcObject = stream});
     
       takePic = setInterval(timeIn ,1100);
    

      
    });


      function timeIn()
      {
     
      
        const canvas = document.querySelector('canvas');
        const image = document.querySelector('#image');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);

        //image.src = canvas.toDataURL('image/png');

        $("#send_image").val(canvas.toDataURL('image/png'));


        var UID_code=$("#UID_code").val();

        $.ajax({
          method: "POST",
          url: get_url('/RFID_Attendance/take_pic'),
          data:{ UID_code:UID_code, faceimage :$("#send_image").val() },

          success:function(response)
          {

          
             console.log(response);
             clearInterval(takePic);
             window.location = get_url('RFID_Attendance');
          }
        });
       
      }

 
 

  </script>
<?php require_once VIEWS.DS.'lending/template/footer.php'?>
