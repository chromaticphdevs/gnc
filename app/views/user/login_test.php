<?php include_once VIEWS.DS.'templates/base/header.php'?>
</head>
<body id="page-top">
     <?php include_once VIEWS.DS.'templates/base/navigation.php'?>

  <!--/ Section login-Footer Star /-->
  <section class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(<?php echo URL.DS.'New_design/img/banner/home-banner.jpg' ?>)">
   
   
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="home" class="box-shadow-full">
              <div class="row">
          
                          <div class="col-md-6">
             
                   <div class="title-box-2">
                    <h5 class="title-left">
                    Champion Innovation
                    </h5><br>
                    <div class="col-md-12  mb-3">
                          <!--<a href="#"  onclick="focus_text()" >RFID</a>-->
                          
                          <div id="notif">
                                <h2><span class="badge badge-info">Please Scan your ID</span></h2>
                          </div>
                    </div>
                  </div>
                       <?php Flash::show();?>
                    <form method="post" id="member_login" action="/users/login_test">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>Username</label>
                            <input type="text" name="username" class="form-control" id="name" placeholder="Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required />
                            <div class="validation"></div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>Password</label>
                            <input type="password" class="form-control" name="password" id="email" placeholder="Password" data-rule="email" data-msg="Please enter a valid email" required />
                            <div class="validation"></div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                           &nbsp;  <a href="/recover/initiate">Forget Password</a>
                        </div>
                        <br>
                        <div class="col-md-12">
                          <button type="submit" class="button button-a button-big button-rouded">LOGIN</button>
                        
                        </div>
                        <br>
                       
                      </div>
                    </form>
                  </div>

                <div class="col-md-6">
                   <br> <br> <br>
                  <div class="more-info"> 
                     <a href="/">
                   <img width="300" height="300" src="<?php echo URL.DS.'uploads/breakthrough.jpg'?>" style="width: 100%;">
                     </a>
   
                  </div>
          
                </div>

            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="copyright-box">
              <p class="copyright">&copy; Copyright <strong>Breakthrough</strong>. All Rights Reserved</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </section>


    <!--onsubmit="return UIDcode();"-->
     <!--RFID login-->
  <form method="post" action="/RFID_Login/login" >

        <input type="text" name="UID" id="UID_code" autocomplete="off" style="color: #fff; border: 0px; outline: 0px; position: absolute; z-index: -1000; top: -10000000px;">

  </form>

   

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  <!--/ Section login-footer End /-->
    <script type="text/javascript">

      
       
          document.getElementById("notif").style.display = "none";
            //autologout

            //track user inactivity

            function inactivityTracker()
            {
                var secondsSinceLastActive = 0;

                var maxInactivity = (60);

                setInterval(function()
                {
                    //increment secondsSinceLastActive if no activity tracked
                    secondsSinceLastActive++;

                    console.log(`last active ${secondsSinceLastActive}`);

                    if(secondsSinceLastActive > maxInactivity)
                    {
                        // alert('Nigga you have been logged out for inactivity');
                    }
                },1000);

                //doWhenActive

                function fireWhenActive()
                {
                    secondsSinceLastActive = 0;
                }

                var activityEvents = [
                    'touchstart' , 'mousedown' , 'mousemove' , 'keydown' , 'scroll'
                ];

                activityEvents.forEach(function(eventName){
                    document.addEventListener(eventName , fireWhenActive , true);
                });
            }
            

            inactivityTracker();
            


            /*function UIDcode(){

              var UID = $("#UID_code").val();
              alert(UID);
              return true;
            }*/

     

            function focus_text(){

             document.getElementById("UID_code").focus();

              document.getElementById("notif").style.display = "block";
                /*var UID = prompt("Please Scan your ID");

                if (UID != null) {
                
                    $.ajax({
                        method: "POST",
                        url: '/RFID_Login/login',
                        data:{ UID : UID },
                        success:function(response)
                        {
                          console.log(response);
                          if(response.length >= 10){
                            window.location = get_url('users/take_pic');

                          }else{

                            alert("Invalid RFID");

                          }
                    
                        }
                    }); 
                      
                }else{

                  alert("Please Scan your ID!");

                }*/
            }

            $(document).ready(function() {
           
                document.getElementById("UID_code").focus();
             });

    </script>

   <?php include_once VIEWS.DS.'templates/base/footer.php'?>