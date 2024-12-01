
<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
         





  			<?php Flash::show()?>
  			<h3 style="width: 100%;">Please Enter your Facebook profile <b> example: https://facebook.com/Juandelacruz456</b></h3>
            <div class="row">

                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">

                <div class="row">

                    <br>

                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>
                            <?php $comment; ?>
                            <?php $count_data = 0; ?>

                            <?php foreach($result as $key => $row) :?>
                               
                                <?php if($row->type == "Facebook" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Facebook" AND $row->status == "unverified"): ?>   

                                    <?php $counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?> 
                                    

                                <?php elseif($row->type == "Facebook" AND $row->status == "deny" AND  $count_data == 0): ?>

                                     <?php $comment = $row->comment; ?>  

                                <?php endif; ?>
                                <?php $count_data = 1; ?>
                            <?php endforeach?>
                         
                            <div class="icon blue"><i class="fa fa-facebook-square"></i> </div>
                            <br>
                            <h3>Facebook</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>  

                                <?php elseif($counter == 2): ?>    

                                     <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank">Preview Profile Link</a>
                                     <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Facebook">Remove Link</a>

                                <?php else: ?>

                                	<form action="/UserSocialMedia/add_link" method="post">  
	                                	<tr>
				                          <td><h5>Link:</h5></td>
				                          <td>
                                           <input type="text"  name="link" class="form-control" autocomplete="off" required>
                                          </td>
				                            
                                          <?php if(!empty($comment)): ?>
                                             <h5 style="color:red;">Denied <?php echo $comment; ?> </h5> 
                                          <?php endif; ?>
                                          
				                        </tr>   
				                         <input type="hidden"  name="type"  value="Facebook">
	                                     <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>

                                <?php endif; ?>

                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <?php $messenger_counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>
                            <?php $comment; ?>
                            <?php $count_data = 0; ?>

                            <?php foreach($result as $key => $row) :?>
                               
                                <?php if($row->type == "Messenger" AND $row->status == "verified"): ?>

                                    <?php $messenger_counter = 1?>

                                <?php elseif($row->type == "Messenger" AND $row->status == "unverified"): ?>   

                                    <?php $messenger_counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?> 
                                    

                                <?php elseif($row->type == "Messenger" AND $row->status == "deny" AND  $count_data == 0): ?>

                                     <?php $comment = $row->comment; ?>  

                                <?php endif; ?>
                                <?php $count_data = 1; ?>
                            <?php endforeach?>
                         
                            <div class="icon blue"><i class="fa fa-facebook-square"></i> </div>
                            <br>
                            <h3>Messenger</h3>
                            <div class="count">

                                <?php if($messenger_counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>  

                                <?php elseif($messenger_counter == 2): ?>    

                                     <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank">Preview Messenger Link</a>
                                     <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Messenger">Remove Link</a>

                                <?php else: ?>

                                    <!--  <form action="/UserSocialMedia/add_link" method="post">  
                                        <tr>
                                          <td><h5>Link:</h5></td>
                                          <td>
                                         <input type="text"  name="link" class="form-control" autocomplete="off" required>
                                          </td>
                                            
                                          <?php if(!empty($comment)): ?>
                                             <h5 style="color:red;">Denied <?php echo $comment; ?> </h5> 
                                          <?php endif; ?>
                                          
                                        </tr>   
                                         <input type="hidden"  name="type"  value="Messenger">
                                         <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>-->

                                <?php endif; ?>

                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

 <?php if($counter == 1 AND $messenger_counter == 1): ?>

                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">

                            <?php $counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "Instagram" AND $row->status == "verified"): ?>
                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Instagram" AND $row->status == "unverified"): ?>   

                                    <?php $counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?>                               

                                <?php endif; ?>
                            <?php endforeach?>

                     		<div class="icon red"><i class="fa fa-instagram"></i> </div>
                            <br>
                            <h3>Instagram</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>    

                                      <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank">Preview Profile Link</a>
                                      <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Instagram">Remove Link</a>
                                <?php else: ?>


                                	<form action="/UserSocialMedia/add_link" method="post">  
	                                	<tr>
				                          <td><h5>Link:</h5></td>
				                          <td> <input type="text"  name="link" class="form-control" autocomplete="off" required></td>
				                            </td>
				                        </tr>   
				                         <input type="hidden"  name="type"  value="Instagram">
	                                     <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>

                                <?php endif; ?>
                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "Twitter" AND $row->status == "verified"): ?>
                                    <?php $counter = 1?>
                                <?php elseif($row->type == "Twitter" AND $row->status == "unverified"): ?>   

                                    <?php $counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?>                               

                                <?php endif; ?>
                            <?php endforeach?>

                            <div class="icon blue"><i class="fa fa-twitter"></i> </div>
                            <br>
                            <h3>Twitter</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>    

                                      <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank"> Preview Profile Link</a>   
                                      <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Twitter">Remove Link</a>
                                <?php else: ?>

									<form action="/UserSocialMedia/add_link" method="post">  
	                                	<tr>
				                          <td><h5>Link:</h5></td>
				                          <td> <input type="text"  name="link" class="form-control" autocomplete="off" required></td>
				                            </td>
				                        </tr>   
				                         <input type="hidden"  name="type"  value="Twitter">
	                                     <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>

                                <?php endif; ?>
                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>




                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "Telegram" AND $row->status == "verified"): ?>
                                    <?php $counter = 1?>
                                <?php elseif($row->type == "Telegram" AND $row->status == "unverified"): ?>   

                                    <?php $counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?>                               

                                <?php endif; ?>
                            <?php endforeach?>

                            <div class="icon blue"><i class="fa fa-paper-plane"></i> </div>
                            <br>
                            <h3>Telegram</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>    
                                 
                                      <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank"> Preview Profile Link</a> 
                                      <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Telegram">Remove Link</a>

                                     
                                <?php else: ?>

									<form action="/UserSocialMedia/add_link" method="post">  
	                                	<tr>
				                          <td><h5>Link:</h5></td>
				                          <td> <input type="text"  name="link" class="form-control" autocomplete="off" required></td>
				                            </td>
				                        </tr>   
				                         <input type="hidden"  name="type"  value="Telegram">
	                                     <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>

                                <?php endif; ?>
                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>





                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "Whatsapp" AND $row->status == "verified"): ?>
                                    <?php $counter = 1?>
                                <?php elseif($row->type == "Whatsapp" AND $row->status == "unverified"): ?>   

                                    <?php $counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?>                               

                                <?php endif; ?>
                            <?php endforeach?>

                            <div class="icon blue"><i class="fa fa-whatsapp"></i> </div>
                            <br>
                            <h3>Whatsapp</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>    

                                      <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank"> Preview Profile Link</a>   
                                      <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Whatsapp">Remove Link</a>
                                <?php else: ?>

									<form action="/UserSocialMedia/add_link" method="post">  
	                                	<tr>
				                          <td><h5>Link:</h5></td>
				                          <td> <input type="text"  name="link" class="form-control" autocomplete="off" required></td>
				                            </td>
				                        </tr>   
				                         <input type="hidden"  name="type"  value="Whatsapp">
	                                     <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>

                                <?php endif; ?>
                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>





                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $link; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "Tiktok" AND $row->status == "verified"): ?>
                                    <?php $counter = 1?>
                                <?php elseif($row->type == "Tiktok" AND $row->status == "unverified"): ?>   

                                    <?php $counter = 2?>
                                    <?php $link = $row->link?>
                                    <?php $id = $row->id?>                               

                                <?php endif; ?>
                            <?php endforeach?>

                            <div class="icon blue"><i class="fa fa-link"></i> </div>
                            <br>
                            <h3>Tiktok</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>    

                                      <a class="btn btn-success btn-sm" href="<?php echo $link;?>" target="_blank"> Preview Profile Link</a>   
                                      <a class="btn btn-danger btn-sm" href="/UserSocialMedia/remove_link/?type=Tiktok">Remove Link</a>
                                <?php else: ?>

									<form action="/UserSocialMedia/add_link" method="post">  
	                                	<tr>
				                          <td><h5>Link:</h5></td>
				                          <td> <input type="text"  name="link" class="form-control" autocomplete="off" required></td>
				                            </td>
				                        </tr>   
				                         <input type="hidden"  name="type"  value="Tiktok">
	                                     <input type="submit" class="btn btn-success btn-sm validate-action" value="Submit">
                                    </form>

                                <?php endif; ?>
                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>





 <?php endif; ?>
              

            



                </div>

                <!-- //DASHBOWED / small widgets -->



        </div>

        <!-- page content -->

     
            <?php if($profile_frame=="YES"):?>
                   echo "<script type="text/javascript">
                       window.open('https://m.me/YourFinancialAssistanceSpecialistCLICKHERE?ref=Change_Profile_Pic'); 
                          </script>";
            <?php endif;?>
      


<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

