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



            <div class="row">

             <?php $whirlpool="831a50be987979d6ee3658eb80f2d1ca8cd21023e90cbd6a98c6c8c0801d9b263d2da6a134a128f886d4cbd22bfbd455adce86b289876df4f7b9d6945c6bbbf4"; ?>



                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">



                <h3><b>Please Upload ID as much as Possible the Clearest Image</b></h3>
                <br>
                <?php if(!empty($comment->comment)):?> 
                    <h4><b style="color:red;">You're <?php echo $comment->type; ?> has been Denied! <?php echo $comment->comment; ?></b></h4>
                <?php endif;?>    

                <div class="row">

                    <br>





                       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                            <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Philippine passport" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Philippine passport" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>



                            <br>

                            <h3>Philippine passport</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Philippine passport&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                     <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=0&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>







                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Drivers license" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Drivers license" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Driver’s license</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Drivers license&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=1&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "SSS UMID Card" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "SSS UMID Card" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>SSS UMID Card</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=SSS UMID Card&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=2&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "PhilHealth ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "PhilHealth ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>PhilHealth ID</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=PhilHealth ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=3&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "TIN Card" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "TIN Card" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>TIN Card</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=TIN Card&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=4&position=front">Take Picture</a>

                                <?php endif; ?>

                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>





                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Postal ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Postal ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Postal ID</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Postal ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=5&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Voters ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Voters ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Voter’s ID</h3>

                            <div class="count">





                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Voters ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=6&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Professional Regulation Commission ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Professional Regulation Commission ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Professional Regulation Commission ID</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Professional Regulation Commission ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=7&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Senior Citizen ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Senior Citizen ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Senior Citizen ID</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Senior Citizen ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=8&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "OFW ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "OFW ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>OFW ID</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=OFW ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=9&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Company ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Company ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Company ID</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Company ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=10&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "NBI Clearance" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "NBI Clearance" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>NBI Clearance</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=NBI Clearance&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=11&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>

                            <h3></h3>

                            <p></p>

                        </div>

                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <div class="tile-stats">



                            <?php $counter = 0?>

                             <?php $filename; ?>

                            <?php $filename2; ?>

                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>



                                <?php if($row->type == "Police Clearance" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Police Clearance" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>



                            <?php endforeach?>



                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>

                            <br>



                            <h3>Police Clearance</h3>

                            <div class="count">



                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Police Clearance&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=12&position=front">Take Picture</a>

                                <?php endif; ?>



                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $filename; ?>
                            <?php $filename2; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "School ID" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "School ID" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>

                            <?php endforeach?>

                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>
                            <br>
                            <h3>School ID</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=School ID&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=13&position=front">Take Picture</a>

                                <?php endif; ?>

                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                            <?php $counter = 0?>
                            <?php $filename; ?>
                            <?php $filename2; ?>
                            <?php $id; ?>

                            <?php foreach($result as $key => $row) :?>

                                <?php if($row->type == "Barangay Clearance" AND $row->status == "verified"): ?>

                                    <?php $counter = 1?>

                                <?php elseif($row->type == "Barangay Clearance" AND $row->status == "unverified"): ?>

                                    <?php $counter = 2?>

                                    <?php $filename = $row->id_card?>

                                    <?php $filename2 = $row->id_card_back?>

                                    <?php $id = $row->id?>

                                <?php endif; ?>

                            <?php endforeach?>

                            <?php if($counter == 1): ?>

                                 <div class="icon green"><i class="fa fa-check-square-o"></i> </div>

                            <?php else: ?>

                                 <div class="icon green"><i class="fa fa-credit-card"></i> </div>

                            <?php endif; ?>
                            <br>
                            <h3>Barangay Clearance</h3>
                            <div class="count">

                                <?php if($counter == 1): ?>

                                     <a class="btn btn-success btn-sm disabled" >Verified</a>

                                 <?php elseif($counter == 2): ?>

                                     <a class="btn btn-success btn-sm" href="/UserIdVerification/user_preview_id_image/?code=<?php echo $whirlpool; ?>&filename=<?php echo $filename; ?>&filename2=<?php echo $filename2; ?>&type=Barangay Clearance&id=<?php echo $id?>">Preview Uploaded ID</a>

                                <?php else: ?>

                                    <a class="btn btn-success btn-sm" href="https://www.breakthrough-e.com/UserIdVerification/take_pic/?code=<?php echo $whirlpool; ?>&type=14&position=front">Take Picture</a>

                                <?php endif; ?>

                            </div>
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

  

                </div>
                <!-- //DASHBOWED / small widgets -->
        </div>
        <!-- page content -->

<script type="text/javascript" defer>
    $( document ).ready(function()
    {
        if(isFacebookApp() == true)
        {
            alert("Upload your ID using google chrome or firefox to avoid ERROR");
            window.location = get_url('users/');
        }
    });

    function isFacebookApp()
    {
        var ua = navigator.userAgent || navigator.vendor || window.opera;
        return (ua.indexOf("FBAN") > -1) || (ua.indexOf("FBAV") > -1);
    }

</script>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
