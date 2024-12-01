<?php build('content')?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <?php Flash::show() ?>
            <section class="header-profile">
                <div class="row">
                    <div class="col-md-3" >
                        <div class="picture mb-3">
                            <?php if($isUserLogged) :?>
                                <a href="/ImageUploaderController/imageCropper?q=<?php
                                    echo seal([
                                            'userId' => $personal->id,
                                            'sourceFor' => 'profilePicture',
                                            'returnURL' => '/AccountProfile',
                                        ])
                                    ?>">
                                    <img src="<?php echo GET_PATH_UPLOAD.DS.'profile'.DS.$personal->selfie?>" 
                                    style="width:100px; border-radius: 10px; border:2px solid #000" 
                                    alt="click-to-edit">
                                </a>
                            <?php else:?>
                                <img src="<?php echo GET_PATH_UPLOAD.DS.'profile'.DS.$personal->selfie?>" 
                                    style="width:100px; border-radius: 10px; border:2px solid #000" 
                                    alt="User Profile Picture">
                            <?php endif;?>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <h3><?php echo ucwords($personal->fullname)?> <?php echo userVerfiedText($user)?></h3>
                        <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) :?>
                            <a href="/accountProfile/openAccount/<?php echo seal($personal->id)?>" class="btn btn-primary btn-sm">Open Account</a>
                        <?php endif?>
                        <hr>
                        <p><?php echo strtoupper($personal->status)?></p>
                        <p><a href="/AccountProfile/directs/<?php echo $user->id?>"> <?php echo WordLib::get('referrals')?> : <?php echo count($directs)?></a></p>
                    </div>
                </div>
            </section>
            
            <section class="contact-profile">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) :?>
                        <tr>
                            <td>Edit</td>
                            <td><a href="/UserController/edit/<?php echo seal($personal->id)?>">Edit User</a></td>
                        </tr>
                        <?php endif?>
                        <tr>
                            <td style="width: 30%;"><span class="badge badge-info">CREDIT LINE</span></td>
                            <td>
                                <p><?php echo ui_html_amount($userCreditLine->current_credit_line)?></p>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 30%;">First Name</td>
                            <td><?php echo ucwords($personal->firstname)?></td>
                        </tr>

                        <tr>
                            <td style="width: 30%;">Middle Name</td>
                            <td><?php echo ucwords($personal->middlename)?></td>
                        </tr>

                        <tr>
                            <td style="width: 30%;">Last Name</td>
                            <td><?php echo ucwords($personal->lastname)?></td>
                        </tr>

                        <tr>
                            <td style="width: 30%;">Mobile</td>
                            <td><?php echo ucwords($personal->mobile)?></td>
                        </tr>

                        <tr>
                            <td style="width: 30%;">Email</td>
                            <td><?php echo ucwords($personal->email)?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">Address</td>
                            <td><?php echo ucwords($personal->address)?></td>
                        </tr>
                        <tr>
                            <td>Bank(<?php echo $userBank->org_name ?? 'No Bank'?>)
                            <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN']) || isEqual(whoIs('id'), $personal->id) ) :?>
                                <?php if($userBank) :?>
                                    <a href="/UserBankController/edit/<?php echo $userBank->id?>">Edit</a>
                                <?php else: ?>
                                    <a href="/UserBankController/create">Add GoTyme</a>
                                <?php endif?>
                            <?php endif?>
                            </td>
                            <td>
                                <?php echo ucwords($userBank->account_number ?? '')?>
                            </td>
                        </tr>
                            
                        <tr>
                            <td style="width: 30%;">
                                E-sig
                                <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN']) || isEqual(whoIs('id'), $personal->id) ) :?>
                                <div><a href="/UserController/editEsig/">Edit</a></div>
                                <?php endif?>
                            </td>
                            <td>
                                <img src="<?php echo URL.DS.'public/assets/signatures/'.$personal->esig?>" alt="" 
                                style="width: 150px; margin-left:30px; display:inline-block">
                                
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 30%;"><?php echo WordLib::get('directSponsor')?>
                            <a href="/UserController/changeSponsor/<?php echo $personal->id?>">Edit</a></td>
                            <td>
                                <?php if($sponsor) :?>
                                <label for=""><strong><?php echo $sponsor->fullname ?? 'Not Available'?></strong></label>
                                (<?php echo $sponsor->username?>)
                                <?php else:?>
                                    NO <?php echo WordLib::get('directSponsor')?>
                                <?php endif?>
                                <a href="#"></a>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 30%;"><?php echo WordLib::get('upline')?></td>
                            <td>
                                <?php if($upline) :?>
                                <div>
                                    <label for=""><strong><?php echo $upline->fullname ?? 'Not Available'?></strong></label>
                                </div>
                                (<?php echo $upline->username?>)
                                <?php else:?>
                                    NO <?php echo WordLib::get('upline')?>
                                <?php endif?>
                            </td>
                        </tr>
                        <?php if($loanProcessor) :?>
                        <tr>
                            <td style="width: 30%;"><?php echo WordLib::get('loanProcessor')?></td>
                            <td>
                                <?php if($loanProcessor) :?>
                                <div>
                                    <label for=""><strong><?php echo $loanProcessor->fullname ?? 'Not Available'?></strong></label>
                                </div>
                                (<?php echo $loanProcessor->username?>)
                                <?php else:?>
                                    NO <?php echo WordLib::get('loanProcessor')?>
                                <?php endif?>
                            </td>
                        </tr>
                        <?php endif?>

                        <tr>
                            <td style="width: 30%;">
                                <div>Loan</div>
                                <a href="/CashAdvanceReleaseController/index?username=<?php echo $personal->username?>&btn_filter=true">
                                    Show All Loan</a>
                            </td>
                            <td>
                                <?php if($loan) :?>
                                    <?php echo $loan->ca_reference?> (<?php echo $loan->ca_status?>)
                                <?php else :?>
                                    <p>User currently has no loan</p>
                                <?php endif?>
                            </td>
                        </tr>

                        <tr>
                            <td>Video</td>
                            <td>
                                <?php if($personal->video_file) :?>
                                    <div>
                                        <video width="320" height="240" controls>
                                            <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$personal->video_file?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>    
                                <?php endif?>
                                <?php if($isUserLogged) :?>
                                    <a href="/UserController/editVideo/">Upload Video</a> | 
                                    <a href="/UserController/removeVideo/<?php echo $personal->id?>">Remove Video</a>
                                <?php endif?>
                            </td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?php echo $personal->username?></td>
                        </tr>

                        <?php if($isUserLogged) :?>
                        <tr>
                            <td>Password</td>
                            <td>
                                <a href="/AccountProfile/edit_password"><strong>Change Password</strong></a>
                            </td>
                        </tr>
                        <?php endif;?>
                        <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN']) || isEqual(whoIs('id'), $personal->id) ) :?>
                        <tr>
                            <td></td>
                            <td><a href="/MasterFileController/show" class="btn btn-danger btn-sm">Master List</a></td>
                        </tr>
                        <?php endif?>
                    </table>  
                </div>
                <ul class="list-group">
                    <li class="list-group-item" style="text-align: center;"><b>Heir List</b></li>
                    <?php if($isUserLogged) :?>
                        <li class="list-group-item" style="text-align: center;">
                        <a class="btn btn-success btn-sm" target="_blank" href="/AccountProfile/add_heir/?user=<?php echo $personal->id?>">ADD HEIR</a>  
                        </li>
                    <?php endif;?>
                    <?php foreach($heir_list as $key => $row) :?>
                        <li class="list-group-item"><?php echo $row->firstname.' '.$row->middlename.' '.$row->lastname?>    
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-danger btn-sm" href="/AccountProfile/delete_heir/<?php echo $row->id?>">DELETE</a> 
                            <a class="btn btn-success btn-sm" href="/AccountProfile/edit_heir/?userid=<?php echo $personal->id?>&id=<?php echo $row->id?>&firstname=<?php echo $row->firstname?>&middlename=<?php echo $row->middlename?>&lastname=<?php echo $row->lastname?> ">EDIT</a> 
                        </li>
                    <?php endforeach?>

                    <?php if($userMeta) :?>
                        <?php
                            $uMetaExpensesTotal = 0;
                            $uMetaIncomeTotal = 0;
                        ?>
                        <?php foreach($userMeta as $uMeta => $uMetaRow) :?>
                            <?php 
                                $isExpenses = false;
                                if(isEqual($uMetaRow->meta_key, $userService::expensesKeys())){
                                    $isExpenses = true;
                                    $uMetaExpensesTotal += $uMetaRow->meta_value;
                                } elseif(isEqual($uMetaRow->meta_key, $userService::incomeKeys())) {
                                    $uMetaIncomeTotal += $uMetaRow->meta_value;
                                }
                            ?>
                            <li class="list-group-item"> <span  style="color:<?php echo $isExpenses ? 'red': ''?>"><?php echo $uMetaRow->meta_key?> :</span> <label for="#">
                                <?php echo $uMetaRow->meta_value?></label> 
                                <div><a href="/Usermeta/edit/<?php echo $uMetaRow->id?>">Edit</a></div>
                            </li>
                        <?php endforeach?>
                        <li class="list-group-item">
                            <h4>Income : <?php echo to_number($uMetaIncomeTotal) ?></h4>
                            <h4>Expenses : <?php echo to_number($uMetaExpensesTotal) ?></h4>
                            <h4>Total : <?php echo to_number($uMetaIncomeTotal - $uMetaExpensesTotal) ?></h4>
                        </li>
                    <?php endif?>
                    <?php if(isEqual(whoIs('type'), USER_TYPES['ADMIN']) || isEqual(whoIs('id'), $personal->id) ) :?>
                        <li class="list-group-item text-center"><a href="/Usermeta/create" class="btn btn-primary btn-sm mt-3 mb-3">Add Details</a></li>     
                    <?php endif?>   
                </ul>
            </section>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php build('headers')?>
<style>
    .idformimage > img{
        width: 300px;
        max-height: 100px;
    }

    .idform{
        border: 1px solid #000;
        margin-bottom: 5px;
        height: 220px;
    }
</style>
<?php endbuild()?>

<?php build('scripts')?>
<script defer>
  $( document ).ready(function() {

    $("#remove").on('click' , function(e)
    {
       if (confirm("Remove this Address?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

    $("#main").on('click' , function(e)
    {
       if (confirm("Make this Address as Main Address?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

    $("#edit_email").on('click' , function(e)
    {   

        var input_email= prompt("Please enter your Email:", "");
       

        var email_check = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        

       if(email_check.test(input_email) == false)
       {

            alert("Invalid Email Format"); 
            return false;
       }

       var userid = $("#userid").val();

       if (confirm("Update Email?"))
       {
            
            $.ajax({
              method: "POST",
              url: '/AccountProfile/update_email',
              data:{

                email: input_email,
                userid: userid
                },
              success:function(response)
              {
                   
                var response_result = JSON.parse(response);
                if(response_result.status == "ok")
                {
                    alert("Email Updated"); 

                    window.location = get_url('/AccountProfile/index');
                }
             
              }
            }); 

       }else
       {
         return false;
       }
    });


  });


</script>
<?php endbuild()?>

<?php occupy('templates/layout')?>
