<?php build('content') ?>

<div class="container-fluid">
<?php $whirlpool="831a50be987979d6ee3658eb80f2d1ca8cd21023e90cbd6a98c6c8c0801d9b263d2da6a134a128f886d4cbd22bfbd455adce86b289876df4f7b9d6945c6bbbf4"; ?>
    <?php if(!empty($comment->comment)):?> 
        <h4><b style="color:red;">You're <?php echo $comment->type; ?> has been Denied! <?php echo $comment->comment; ?></b></h4>
    <?php endif;?>    
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Please Upload ID as much as Possible the Clearest Image'))?>
        <div class="card-body" id="cardContainer">
            <a href="/UserIdVerification/index?userId=<?php echo seal(whoIs()['id'])?>">Show Uploaded Ids</a>

            <?php if($notifications) :?>
            <div id="notifications">
                <?php foreach($notifications as $key => $row) :?>
                    <p class="text-danger <?php echo $key > 0 ? 'text-hidden' : ''?>"><?php echo $row->message?></p>
                <?php endforeach?>
            </div>
            <div class="mt-3"> <a href="#" class="text-hidden-show-all">Show all Message </a></div>
            <?php endif?>
            <!-- PASSPORT AND SSS UMID -->
            <div class="row">
                <div class="col-md-6">
                    <!-- PASSPORT -->
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Selfie With ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Selfie With ID" AND $row->status == "unverified") {
                                        $counter = 2;;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Selfie With ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" 
                                        href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" 
                                        href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" 
                                    href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=17&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Drivers license" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Drivers license" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>
                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>

                            <h3>Drivers License</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                        <a class="btn btn-success btn-sm disabled" >Verified</a>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" 
                                        href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" 
                                        href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" 
                                    href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=1&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- SELFIE WITH ID -->
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Philippine passport" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } else if($row->type == "Philippine passport" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>

                            <h3>Philippine passport</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                <a class="btn btn-success btn-sm disabled" >Verified</a>
                                <a class="btn btn-primary btn-sm" style="color: #000;" 
                                    href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php elseif($counter == 2): ?>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" 
                                    href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" 
                                        href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=0&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "TIN Card" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "TIN Card" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>
                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>TIN Card</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=4&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "SSS UMID Card" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "SSS UMID Card" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>
                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>

                            <h3>SSS UMID Card</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                        <a class="btn btn-success btn-sm disabled" >Verified</a>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=2&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                        <?php
                            $counter = 0;
                            $filename;
                            $filename2;
                            $id;

                            foreach($result as $key => $row) {
                                if($row->type == "PhilHealth ID" AND $row->status == "verified") {
                                    $counter = 1;
                                    $id = $row->id;
                                } elseif($row->type == "PhilHealth ID" AND $row->status == "unverified") {
                                    $counter = 2;
                                    $filename = $row->id_card;
                                    $filename2 = $row->id_card_back;
                                    $id = $row->id;
                                }
                            }
                        ?>

                        <?php if($counter == 1): ?>
                            <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                        <?php else: ?>
                            <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                        <?php endif; ?>
                        <h3>PhilHealth ID</h3>
                        <div class="count">
                            <?php if($counter == 1): ?>
                                <a class="btn btn-success btn-sm disabled" >Verified</a>
                                <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                            <?php elseif($counter == 2): ?>
                                <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                            <?php else: ?>
                                <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=3&position=front">Take Picture</a>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TEMPLATE -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Professional Regulation Commission ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Professional Regulation Commission ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Professional Regulation Commission ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                        <a class="btn btn-success btn-sm disabled" >Verified</a>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=7&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Senior Citizen ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Senior Citizen ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Senior Citizen ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=8&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- TEMPATE -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename; 
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "OFW ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "OFW ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                } 
                            ?>
                            <?php if($counter == 1): ?>
                                    <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                    <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>OFW ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=9&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Company ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Company ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Company ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                        <a class="btn btn-success btn-sm disabled" >Verified</a>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=10&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>

            <!-- TEMPLATE -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2; 
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "NBI Clearance" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "NBI Clearance" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>

                            <h3>NBI Clearance</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=11&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Police Clearance" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Police Clearance" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Police Clearance</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=12&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- TEMPLATE -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "School ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "School ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>
                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>School ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=13&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Barangay Clearance" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Barangay Clearance" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>
                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Barangay Clearance</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                    <a class="btn btn-success btn-sm disabled" >Verified</a>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php elseif($counter == 2): ?>
                                    <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=14&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                        <?php
                            $counter = 0;
                            $filename;
                            $filename2;
                            $id;

                            foreach($result as $key => $row) {
                                if($row->type == "Postal ID" AND $row->status == "verified") {
                                    $counter = 1;
                                    $id = $row->id;
                                } elseif($row->type == "Postal ID" AND $row->status == "unverified") {
                                    $counter = 2;;
                                    $filename = $row->id_card;
                                    $filename2 = $row->id_card_back;
                                    $id = $row->id;
                                }
                            }
                        ?>

                        <?php if($counter == 1): ?>
                            <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                        <?php else: ?>
                            <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                        <?php endif; ?>
                        <h3>Postal ID</h3>
                        <div class="count">
                            <?php if($counter == 1): ?>
                                <a class="btn btn-success btn-sm disabled" >Verified</a>
                                <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php elseif($counter == 2): ?>
                                <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                            <?php else: ?>
                                <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=5&position=front">Take Picture</a>
                            <?php endif; ?>
                        </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                        <?php
                            $counter = 0;
                            $filename;
                            $filename2;
                            $id;

                            foreach($result as $key => $row) {
                                if($row->type == "Barangay ID" AND $row->status == "verified") {
                                    $counter = 1;
                                    $id = $row->id;
                                } elseif($row->type == "Barangay ID" AND $row->status == "unverified") {
                                    $counter = 2;;
                                    $filename = $row->id_card;
                                    $filename2 = $row->id_card_back;
                                    $id = $row->id;
                                }
                            }
                        ?>

                        <?php if($counter == 1): ?>
                            <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                        <?php else: ?>
                            <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                        <?php endif; ?>
                        <h3>Barangay ID</h3>
                        <div class="count">
                            <?php if($counter == 1): ?>
                                <a class="btn btn-success btn-sm disabled" >Verified</a>
                                <a class="btn btn-primary btn-sm" style="color: #000;" 
                                href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php elseif($counter == 2): ?>
                                <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" 
                                    href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>
                                    &type=15&position=front">Take Picture</a>
                                <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Voters ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Voters ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Voter’s ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                        <a class="btn btn-success btn-sm disabled" >Verified</a>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=6&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $counter = 0;
                                $filename;
                                $filename2;
                                $id;

                                foreach($result as $key => $row) {
                                    if($row->type == "Other ID" AND $row->status == "verified") {
                                        $counter = 1;
                                        $id = $row->id;
                                    } elseif($row->type == "Other ID" AND $row->status == "unverified") {
                                        $counter = 2;
                                        $filename = $row->id_card;
                                        $filename2 = $row->id_card_back;
                                        $id = $row->id;
                                    }
                                }
                            ?>

                            <?php if($counter == 1): ?>
                                <div class="icon green"><i class="fa fa-check-square-o"></i> </div>
                            <?php else: ?>
                                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                            <?php endif; ?>
                            <h3>Other's ID</h3>
                            <div class="count">
                                <?php if($counter == 1): ?>
                                        <a class="btn btn-success btn-sm disabled" >Verified</a>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                    <?php elseif($counter == 2): ?>
                                        <a class="btn btn-primary btn-sm" style="color: #000;" href="/UserIdVerification/preview_id_image/<?php echo $id?>">View</a>
                                <?php else: ?>
                                    <a class="btn btn-success btn-sm" href="/UserIdVerification/take_pic_html/?code=<?php echo $whirlpool; ?>&type=18&position=front">Take Picture</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3>Social Media Links</h3>
                            <div class="count">
                                <div class="input-group">
                                    <?php if($socials['facebook']) :?>
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">
                                                <?php echo tmpStatusHTML($socials['facebook']->status)?>
                                            </label>
                                        </div>
                                    <?php endif?>
                                    <input type="text" 
                                        class="form-control socials-field" 
                                        aria-label="Text input with dropdown button" 
                                        placeholder="Facebook Link" 
                                        id="facebooklink"
                                        data-secret = "<?php echo seal(whoIs('id'))?>"
                                        data-type = "<?php echo $socialMediaService::FACEBOOK?>"
                                        value="<?php echo $socials['facebook']->link ?? ''?>"
                                        disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary dropdown-toggle" 
                                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-list"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item input-text-action" href="javascript:void(0)" 
                                                data-action="edit" data-target="#facebooklink">Edit</a>
                                            <a class="dropdown-item input-text-action" href="javascript:void(0)" 
                                                data-action="save" data-target="#facebooklink">Save</a>
                                            <a class="dropdown-item input-text-action" href="javascript:void(0)" 
                                                data-action="copy" data-target="#facebooklink">Copy</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="input-group mt-3">
                                    <?php if($socials['messenger']) :?>
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">
                                                <?php echo tmpStatusHTML($socials['messenger']->status)?>
                                            </label>
                                        </div>
                                    <?php endif?>
                                    <input type="text" 
                                        class="form-control socials-field" 
                                        aria-label="Text input with dropdown button" 
                                        placeholder="Messenger Link" 
                                        id="messengerlink"
                                        data-secret = "<?php echo seal(whoIs('id'))?>"
                                        data-type = "<?php echo $socialMediaService::MESSENGER?>"
                                        value="<?php echo $socials['messenger']->link ?? ''?>"
                                        disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary dropdown-toggle" 
                                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-list"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- <a class="dropdown-item input-text-action" href="javascript:void(0)" 
                                                data-action="edit" data-target="#messengerlink">Edit</a>
                                            <a class="dropdown-item input-text-action" href="javascript:void(0)" 
                                                data-action="save" data-target="#messengerlink">Save</a> -->
                                                <a class="dropdown-item input-text-action" href="javascript:void(0)" 
                                                data-action="copy" data-target="#messengerlink">Copy</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    function tmpStatusHTML($status) {
        switch($status) {
            case 'unverified':
                $retVal = '<i class="fa fa-spinner text-primary"> </i>';
            break;

            case 'verified':
                $retVal = '<i class="fa fa-check-circle text-success"> </i>';
            break;

            case 'deny':
                $retVal = '<i class="fa fa-times text-success"> </i>';
            break;
        }

        return $retVal;
    }
?>
<?php endbuild()?>

<?php build('headers') ?>
    <style>
        #cardContainer > div.row {
            margin-bottom: 15px;
        }

        p.text-hidden {
            display: none;
        }
    </style>
<?php endbuild()?>
<?php build('scripts') ?>
<script>
    $( document ).ready(function()
    {   
        /*
         * social media upload actions
         */
        $('.input-text-action').click(function(){
            let actionElement = $(this);
            let actionType = actionElement.data('action');
            let target = $(actionElement.data('target'));
            let targetSecret = target.data('secret');
            let targetValue  = target.val();
            let targetType  = target.data('type');

            switch(actionType) {
                case 'edit':
                    $(target).removeAttr('disabled');
                break;

                case 'save':
                    $.ajax({
                        type : 'POST',
                        url : '/UserSocialMedia/api_add_link',
                        data: {
                            userId : targetSecret,
                            link : targetValue,
                            type : targetType,
                            status : 'unverified'
                        },
                        success : function(response) {
                            response = JSON.parse(response);
                            let responseData = response['data'];
                            
                            if(responseData['success'] === false) {
                                return alert(responseData['message']);
                            }
                            $(target).attr('disabled', true);
                            window.location.href = '/UserIdVerification/upload_id_html';
                        }
                    })
                break;

                case 'copy':
                    alert('Social Media Copied');
                    copyStringToClipBoard(targetValue);
                break;
            }
        });
    });


    // if(isFacebookApp() == true)
    // {
    //     alert("Upload your ID using google chrome or firefox to avoid ERROR");
    //     window.location = get_url('users/');
    // }

    // $('.text-hidden-show-all').click(function(){
    //     $('.text-hidden').toggle();
    // })
    // function isFacebookApp()
    // {
    //     var ua = navigator.userAgent || navigator.vendor || window.opera;
    //     return (ua.indexOf("FBAN") > -1) || (ua.indexOf("FBAV") > -1);
    // }
</script>
<?php endbuild()?>

<?php occupy()?>