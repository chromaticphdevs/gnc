<?php build('content') ?>
    <div style="overflow-x:auto;">
    <h4><?php echo $user->fullname?></h4>

    <a href="/ProductLoanFollowUps/index?level=<?php echo $userLevel?>">Back to follow up</a> | 
    <a href="/ProductLoanFollowUps/index?level=1">Follow up 1</a>
    <?php Flash::show()?>

    <table class="table">
        <tbody>
            <tr>
                <td> <h4><b>Screen Time:<h4><b></td>
                <td><h4><b style="color: green;"><span id="screenTime"></span><h4><b>
                 <input type="button" name="note" class="btn btn-success btn-sm" id="call" value = "Call">
                 <input type="button" name="note" class="btn btn-danger btn-sm" id="end_call" value = "End Call"></td>
            </tr> 

            <tr>
                <td>First Name</td>
                <td><?php echo $user->firstname?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo $user->lastname?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td> <span class="badge badge-info"><?php echo $user->username?></span> </td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><?php echo $user->mobile?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $user->email?></td>
            </tr>
             <tr>
                <td>Loan Number</td>
                <td><?php echo $loaninfo->code?></td>
            </tr>
            <tr>
                <td>Amount</td>
                <td>&#8369; <?php echo $loaninfo->amount+$loaninfo->delivery_fee?></td>
            </tr>
            <tr>
                <td>Payment</td>
                <td>&#8369; <?php echo $loaninfo->payment?></td>
            </tr>
            <tr>
                <td>Balance</td>
                <td>&#8369; <?php echo ($loaninfo->amount + $loaninfo->delivery_fee ?? 0) - $loaninfo->payment?></td>
            </tr>

            <tr>
                <td>Follow Up #</td>
                <td><?php echo $user->follow_up_level?></td>
            </tr>

            <tr>
                <td>Tag</td>
                <td><?php echo $user->tagged_as?></td>
            </tr>

            <?php
                Form::open([
                    'method' => 'post',
                    'action' => '/ProductLoanFollowUps/update'
                ]);

                Form::hidden('user_id' , $userIdSealed);
                Form::hidden('loan_id' , $loanIdSealed);
            ?>
            <tr>
                <td><center><h4><b style="color: green; ">Profiling</b></h4></center></td>
                <td>
                      
                </td>
            </tr>
            <tr>
                <td>Source Of Income</td>
                <td>
                    <input type="text" name="source_income" class="form-control" required>           
                </td>
            </tr>
            <tr>
                <td>Income</td>
                <td>
                    <input type="text" name="income" class="form-control" required>           
                </td>
            </tr>
            <tr>
                <td>Monthly House Rental Fee</td>
                <td>
                    <input type="text" name="house_rental" class="form-control" required>           
                </td>
            </tr>
            <tr>
                <td>Dependents</td>
                <td>
                    <input type="text" name="dependents" class="form-control" required>           
                </td>
            </tr>
            <tr>
                <td>Rice Consumption</td>
                <td>
                    <input type="text" name="rice_consumption" class="form-control" required>           
                </td>
            </tr>

            <tr>
                <td>Make Note</td>
                <td>
                    <input type="text" name="note" class="form-control" required>           
                </td>
            </tr>

            <tr>
                <td>Action</td>
                <td>
                   
                    <div class="form-group">
                        <?php
                            Form::submit('move_next_level' , 'Done' , [
                                'class' => 'btn btn-primary btn-sm'
                            ]);

                            if( !isEqual($user->tagged_as , 'dont-follow-up'))
                                Form::submit('do_not_follow_up' , 'Do not Follow Up' , [
                                    'class' => 'btn btn-danger btn-sm'
                                ]);
                        ?>
                    </div>
                   
                </td>
            </tr>
            <!--<tr>
                <td>Latest Note:</td>
                <td><?php echo 'fs'; ?></td>
            </tr>-->
            <?php Form::close()?>
        </tbody>
    </table>
    <br>
    <h2>Notes History</h2>
     <table class="table">
            <thead>
                <th>#</th>
                <th>Notes</th>
                <th></th>
            </thead>

             <tbody>
                   <?php $counter = 1;?>
                   <?php foreach($userNotes as $data) :?>
                      <tr>
                            <td><?php echo $counter ?></td>
                            <td><b><h4><?php echo $data->note; ?></h4></b></td>
                            <td><b><h5><?php
                                  $date=date_create($data->created_at);
                                  echo date_format($date,"M d, Y");
                                  $time=date_create($data->created_at);
                                  echo date_format($time," h:i A");
                                ?>
                            </h5></b></td>  
                      </tr>
                    <?php $counter++;?>
                    <?php endforeach;?>
            </tbody>
        </table>

        <br>
        <h2>Client Info</h2>
         <table class="table">
            <thead>
                <th>#</th>
                <th>Source Income</th>
                <th>Income</th>
                <th>House Rental</th>
                <th>Dependents</th>
                <th>Rice Consumption</th>
                <th></th>
            </thead>

             <tbody>
                   <?php $counter = 1;?>
                   <?php foreach($user_profiling_info as $data) :?>
                      <tr>
                            <td><?php echo $counter ?></td>
                            <td><b><h4><?php echo $data->source_income; ?></h4></b></td>
                            <td><b><h4><?php echo $data->income; ?></h4></b></td>
                            <td><b><h4><?php echo $data->house_rental; ?></h4></b></td>
                            <td><b><h4><?php echo $data->dependents; ?></h4></b></td>
                            <td><b><h4><?php echo $data->rice_consumption; ?></h4></b></td>
                            <td><b><h5><?php
                                  $date=date_create($data->created_at);
                                  echo date_format($date,"M d, Y");
                                  $time=date_create($data->created_at);
                                  echo date_format($time," h:i A");
                                ?>
                            </h5></b></td>  
                      </tr>
                    <?php $counter++;?>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script type="text/javascript">
         $("#end_call").hide();
         $( document ).ready( function() 
         {   

                var screenTimeInMinutes = 0;
                var screenTimeInSeconds = 0;
                var screenTime;
                var  seconds = 0;

                var timer;

                $( "#call" ).click(function() {
                    timer = setInterval( function () 
                    {   
                        if(seconds == 59) {
                            screenTimeInMinutes += 1;
                            seconds = -1;
                        }
                       
                        seconds++;
                        screenTimeInSeconds = seconds;

                        screenTime = screenTimeInMinutes+" mins and "+screenTimeInSeconds+" sec";
                        $("#screenTime").html(screenTime);

                    }, 1000);

                    $("#call").hide();
                    $("#end_call").show();
                });

                $( "#end_call" ).click(function() {

                    clearInterval(timer);
                    $("#end_call").hide();

                });
         });

    </script>   
<?php endbuild()?>


<?php occupy('templates/layout')?>