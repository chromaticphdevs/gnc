<?php build('content') ?>
    <div class="container-fluid">
        <div class="card mb-5">
            <?php echo wCardHeader(wCardTitle(''))?>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                      <div class="icon green"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                      <div class="count" id="otp">0</div>
                      <h3>
                        Login OTP:
                        <?php if($device_state->otp_sms == 'on'): ?>
                            <span class="label label-success"><?php echo $device_state->otp_sms; ?></span>
                            <br><br>
                              <form method="post" action="/GsmArduino/test_sms"  autocomplete="off">
                                <input  type="hidden" name="category" value="OTP">
                                <input  type="number" name="cp_number"  placeholder="Enter Phone Number" required>
                                <input type="submit" class="btn btn-success" value="Send">
                              </form> 
                        <?php else:?>   
                            <span class="label label-danger"><?php echo $device_state->otp_sms; ?></span>
                            <br><br>
                            <div style="color:red; ">WARNING!!! OTP login is OFF!</div>
                        <?php endif;?> 
                      </h3>
                      <br>
                      <h3>
                            <a class="btn btn-success btn-sm" href="/Device/change_state/?category=otp_sms&status=on">&nbsp;ON&nbsp;</a>
                            <a class="btn btn-danger btn-sm" id="otp_off" href="/Device/change_state/?category=otp_sms&status=off">OFF</a>
                      </h3>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="tile-stats">
                    <div class="icon green"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <div class="count" id="registration">0</div>
                    <h3>
                      Registration OTP: 
                      <?php if($device_state->registration_sms == 'on'): ?>
                          <span class="label label-success"><?php echo $device_state->registration_sms; ?></span>
                            <br><br>
                            <form method="post" action="/GsmArduino/test_sms"  autocomplete="off">
                              <input  type="hidden" name="category" value="registration">
                              <input  type="number" name="cp_number"  placeholder="Enter Phone Number" required>
                              <input type="submit" class="btn btn-success" value="Send">
                            </form> 
                      <?php else:?>   
                          <span class="label label-danger"><?php echo $device_state->registration_sms; ?></span>
                          <br><br>
                          <div style="color:red; ">WARNING!!! Mobile Verification on Registration  is OFF!!</div>
                      <?php endif;?> 
                    </h3>
                    <br>
                    <h3>
                      <a class="btn btn-success btn-sm" href="/Device/change_state/?category=registration_sms&status=on">&nbsp;ON&nbsp;</a>
                      <a class="btn btn-danger btn-sm" id="registration_off" href="/Device/change_state/?category=registration_sms&status=off">OFF</a>
                    </h3>
                  </div>
                </div>

              </div>
            </div>
        </div>

        <div class="card mb-5">
          <div class="card-body">
            <?php 
                $account['total'] = $today['account']['total'];
                $account['list']  = $today['account']['list'];
                
            ?> 
            <h1>Activated Users Today!</h1>
            <h3>Total : <?php echo $account['total']?> </h3>
            <h3><?php Flash::show();?></h3>
            <div class="col-md-3">
                <form class="ui form" method="post" action="/Admin/index">
                    <input type="number" 
                        class="form-control" 
                        name="number_of_days" value="1">
                </form>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <?php if(!empty($account['total'])) :?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Username</th>
                        <th>Fullname</th>
                        <th>From Activation</th>
                        <th>Account Level</th>
                        <th>Date & Time</th>
                    </thead>
                    <tbody>
                        <?php foreach($account['list'] as $key => $newuser ) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $newuser->username?></td>
                                <td><?php echo $newuser->fullname?></td>
                                <td>
                                    <?php if(empty($newuser->dbbi_id)) :?>
                                        <label>No</label>
                                    <?php else:?>
                                        <label>Yes</label>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?php echo $newuser->status?>
                                </td>     
                                <td>
                                    <?php
                                        echo date_long($newuser->created_at);
                                        echo "&nbsp;";
                                        echo time_long($newuser->created_at);
                                    ?>      
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <?php else:?>
                <p>No User that has been activated today.</p>
            <?php endif;?>
          </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<script type="text/javascript" defer>
  var itexmo;
  var gsm;
  $(document).ready(function(){
      $("#registration_off").on('click' , function(e)
      {
         if (confirm("Warning!! This Will Turn off the Mobile Verification on Registration, Are You Sure?"))
         {
            return true;
         }else
         {
           return false;
         }
      });

        $("#otp_off").on('click' , function(e)
      {
         if (confirm("Warning!! This Will Turn off the OTP Login, Are You Sure?"))
         {
            return true;
         }else
         {
           return false;
         }
      });

       gsm = setInterval(get_gsm_info ,2000);     

    });
      function get_gsm_info()
      { 
        $.ajax({
          method: "POST",
          url: get_url('/GsmArduino/get_total_sms_sent'),
          success:function(response)
          {
              var result =  JSON.parse(response);
              document.getElementById("otp").innerHTML = result.otp;
              document.getElementById("registration").innerHTML = result.registration;
              return false;     
          }
        });
       
      }
</script> 
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>