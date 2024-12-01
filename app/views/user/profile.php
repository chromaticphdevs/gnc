<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
<!-- /menu profile quick info --> 
<?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>      
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->

        <!-- page content -->       
        <div class="right_col" role="main" style="min-height: 524px;">  
            <?php include_once VIEWS.DS.'templates/users/popups/top_notify.php' ;?>
            <?php Flash::show();?>
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">  
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="profile-photo">
                                <img src="<?php echo URL.DS.'assets/'.$userInfo->selfie;?>" id="photo-profile">
                                <input type="file" id="photo" name="photo" title="Load File" class="display-none">
                            </div>

                            <div>
                                <h1>
                                    Total Payout : <?php echo $payoutTotal;?>
                                </h1>

                                <h1>
                                    Max Pair: <?php echo $userInfo->max_pair;?>
                                </h1>
                                <form method="post" action="/users/updateProfile" enctype="multipart/form-data">
                                    <label>Select Profile.</label>
                                    <input type="file" name="fileUpload">
                                    <input type="submit" name="" class="btn btn-sm btn-primary">
                                </form>
                            </div>
                                <p>&nbsp;</p>
                                <div class="row text-center">
                                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                                        <strong>Username</strong>
                                        <p><?php echo $userInfo->username;?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-md-6 col-sm-6 col-xs-12">   
                                        <strong>First name</strong>
                                         <p><?php echo $userInfo->firstname;?></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">   
                                        <strong>Lasts name</strong>
                                        <p><?php echo $userInfo->lastname;?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                                        <strong>My Referrer</strong>
                                       <p><?php echo $userSponsor->username ?? 'N/A';?></p>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                
                        </div>
                    </div>  
                </div>
                
                
                <div class="col-md-9 col-sm-12 col-xs-12">                  
                    <div class="x_panel">           
                        <div class="x_content">
                            
                            <div class="col-md-6 col-sm-12 col-xs-12">  
                            
                            
                                <div class="col-md-12 col-sm-12 col-xs-12"> 
                                    <h3 class="montserrat-bold"> Personal Info</h3>  
                                </div>       
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
                                    <strong class="col-md-4 col-sm-4 col-xs-6 info_label">Mobile:</strong>
                                    <div class="col-md-8 col-sm-8 col-xs-6"><?php echo $userInfo->mobile?></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
                                    <strong class="col-md-4 col-sm-4 col-xs-6 info_label">Email:</strong>
                                    <div class="col-md-8 col-sm-8 ssscol-xs-6"><?php echo $userInfo->email?></div>
                                </div>


                                 <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
                                    <strong class="col-md-4 col-sm-4 col-xs-6 info_label">Mobile Number:</strong>
                                    <div class="col-md-8 col-sm-8 ssscol-xs-6"><?php echo $userInfo->mobile?>&nbsp;&nbsp;
                                        
                                    <input type="hidden" id="cp_number" name="cp_number" value="<?php echo $userInfo->mobile?>">
                                   
                                    <?php if($userInfo->mobile_verify == "unverified"):?>

                                             <span class="label label-info">Unverified</span>

                                    <?php else:?>
                                             <span class="label label-success">Verified</span>
                                    <?php endif;?>

                                    </div>
                                </div>

                                <?php if($userInfo->mobile_verify == "unverified"):?>
                                <div class="row">
                                    <div class="col-md-12 margin-bottom-20">
                                        <strong class="col-md-4 col-sm-12 col-xs-12 text-right"></strong>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                           <a onclick="get_code_verify()" class="btn btn-warning"><i class="fa fa-check-square-o"></i> Verify Now</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>

                                <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
                                    <strong class="col-md-4 col-sm-4 col-xs-6 info_label">Address:</strong>
                                    <div class="col-md-8 col-sm-8 col-xs-6"><?php echo $userInfo->address?></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
                                    <strong class="col-md-4 col-sm-4 col-xs-6 info_label">Days:</strong>
                                    <div class="col-md-8 col-sm-8 col-xs-6">
                                        <?php getPastDate($userInfo->dateonly)?>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                               
                                
                                <p>&nbsp;</p> 
                                <!--<div class="row">
                                    <div class="col-md-12 margin-bottom-20">
                                        <strong class="col-md-4 col-sm-12 col-xs-12 text-right"></strong>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                           <a href="/users/edit/" class="btn btn-success"><i class="fa fa-edit"></i> Edit Profile </a>
                                        </div>
                                    </div>
                                </div>-->
                                <p>&nbsp;</p>
                            </div>
                            
                            <div class="col-md-6 col-sm-12 col-xs-12">                              
                                <div class="col-md-10 col-sm-12 col-xs-12"> 
                                    <h3 class="montserrat-bold"> Identifications</h3>  
                                </div>       
                                <div class="col-md-12 margin-bottom-20">
                                    <div class="row">
                                        <strong class="col-md-12 col-sm-12 col-xs-12"> 
                                            <a class="modalButton" form_id="upload_id" style="cursor: pointer;"><i class="fa fa-upload"></i> Upload Government ID </a>
                                        </strong>                                   
                                    </div>
                                </div>
                                <div class="col-md-12 margin-bottom-20">
                                    <div class="row">
                                        <strong class="col-md-12 col-sm-12 col-xs-12">                          
                                        </strong>  
                                    </div>
                                </div>
                                <div class="col-md-12 margin-bottom-20">
                                    <div class="row">
                                        <strong class="col-md-12 col-sm-12 col-xs-12">
                                        
                                        </strong>  
                                    </div>
                                </div>
                                <div class="col-md-12 margin-bottom-20">
                                   <p>&nbsp;</p>
                                   <small class="orange">NOTE: If you are paying with <strong>OMG Credit</strong> please upload the above photos for faster approval.</small>
                                </div>
                            </div>                            
                        </div>  
                    </div>
                </div>
            </div>
            
   <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">×</span>
                    </div>
                    <div class="modal-body text-center">
                        <div class="heading"></div>
                        <p>&nbsp;</p>
                        <div class="row">
                        <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                        <input type="file" name="photo" style="margin:auto">                         
                        <div class="form-group modal-preloader">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-left"> 
                                <div><img src="/images/loader.gif" align="absmiddle"> <span>uploading .....</span> </div>
                            </div>
                        </div>  
                        </form></div>
                        <div class="form-group">
                                    <div class="row text-center">
                                        <br><button type="submit" class="btn btn-success "> Upload </button><br><br>
                                    </div>
                                </div>
                        <p>&nbsp;</p>
                             
                    </div>
                </div>
            </div>  
            <!--- NEW EXZPORT -->
        </div>


       
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>


    <script> 
        var verification_code ="";
        function get_code_verify()
        {

           

            $.ajax({
              method: "POST",
              url: '/Users/code_verification_mobile',
              data:{
                    cp_number: $("#cp_number").val(),
                },
              success:function(response)
              {
               
               
                    verification_code = response;
                    get_user_input();

                   
              }
            });

        }

        function get_user_input(){

            do{
                input = prompt("We have sent a code to your mobile number \n Please Enter code to confirm your registration");
            }while(input == null || input == "" );

            var user_input = input.toUpperCase();

             if(verification_code != user_input){

                alert("Invalid Verification Code");

                get_user_input();
 
            }else{

                $.ajax({
                  method: "POST",
                  url: '/Users/verify_mobile_number',
                  data:{
                        cp_number: $("#cp_number").val(),
                    },
                  success:function(response)
                  {
                    console.log(response);
                     window.location = get_url("/Users/profile");
                  }
                });
                        
            }
        }


       
     
    </script>