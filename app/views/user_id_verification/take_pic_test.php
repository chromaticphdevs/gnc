

<?php require_once VIEWS.DS.'lending/template/header.php'?>

</head>

<body style="">

  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>

  

  <main class="ui main text container">

  

   



    <section id="userInfo">

     

     <h1 class="ui header">Upload ID Image</h1>

    </section>

    <div style="overflow-x:auto;">

      <section id="photobooth">

        <img src="" id="image">

        <input type="hidden" name="send_image" id="send_image">

        <canvas style="display: none"></canvas>

        <video id="video" autoplay muted></video>

      </section>

    </div>



    <section>

      <form method="post" id="photobooth_control">



                <input type="hidden" name="type" id="type" 

                value="<?php



                  if(isset($_GET['type']))

                  {

                     echo $_GET['type'];

                  }



                   ?>">

                <input type="hidden" name="id_card_front" id="id_card_front" 

                value="<?php



                  if(isset($_GET['id_card_front']))

                  {

                     echo $_GET['id_card_front'];

                  }else{

                     echo 'x';

                  }



                   ?>">



                <input type="hidden" name="position" id="position" 

                value="<?php



                  if(isset($_GET['position']))

                  {

                     echo $_GET['position'];

                  }



                   ?>">

        <h5 style=" text-align: center; " id="p1"></h5>

        <button class="ui button positive login" id="capture_image" >Capture</button>



        <?php if($_GET['position'] == "front"): ?>

          <button class="ui button negative cancel" id="cancel_image" >Cancel</button>

        <?php endif; ?>

        

      </form>

    </section>

  </main>

<script type="text/javascript" defer>

  $( document ).ready(function(){



      alert("Please Upload ID as much as Possible the Clearest Image");



      var type = document.getElementById("type").value;



      if(type == ""){



        alert("Invalid ID type!");

        window.location = get_url('UserIdVerification/upload_id');



      }

    

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



          if($(this).hasClass('cancel')){

            var loanID =$("#loanID").val();

 

                window.location = get_url('UserIdVerification/upload_id');

           

            }



          evt.preventDefault();

      });

  });



  function timeIn()

  {

    

    document.getElementById("capture_image").style.visibility = "hidden";



    if($("#position").val() == "front"){

     document.getElementById("cancel_image").style.visibility = "hidden";

    }





    document.getElementById("p1").innerHTML = "Please Wait....";    

      

    const canvas = document.querySelector('canvas');

    const image = document.querySelector('#image');



    canvas.width = video.videoWidth;

    canvas.height = video.videoHeight;

    canvas.getContext('2d').drawImage(video, 0, 0);



    image.src = canvas.toDataURL('image/png');



    $("#send_image").val(canvas.toDataURL('image/png'));





    $.ajax({

      method: "POST",

      url: get_url('UserIdVerification/take_pic_test'),

      data:{

            ID_type:$("#type").val(),

            image:$("#send_image").val(),

            position:$("#position").val(),

            id_card_front:$("#id_card_front").val()

           },



      success:function(response)

      {



        console.log(response);

        let returnData = JSON.parse(response);  



        if(returnData.status == 'success')

        {

         

          if(returnData.msg == 'front')

          { 

             alert('Take a Picture of Back side of your ID')

             window.location = get_url('UserIdVerification/take_pic_test/?position=back&id_card_front='+returnData.id_card_front+'&type='+returnData.type);  



          }else{

             window.location = get_url('UserIdVerification/upload_id_test');  

          }



        }else{

          alert("Something went Wrong! Please Try Again");
          window.location = get_url('UserIdVerification/upload_id_test');  

        }



      }

    });

 

  }

  </script>

<?php require_once VIEWS.DS.'lending/template/footer.php'?>

