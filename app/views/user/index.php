<?php build('content')?>
<?php $sessionUser = whoIs()?>
<?php Flash::show()?>
<div class="col-ms-3 col-xs-12">
 
    <div class="tile-stats">  
      <center> <div class="count"><strong><?php echo Session::get('USERSESSION')['firstname']?>&nbsp;&nbsp;<?php echo Session::get('USERSESSION')['lastname']?></strong></div></center>
    </div>

    <div class="tile-stats">
        
        <center><div class="count">
            <?php echo Session::get('USERSESSION')['status'];?>
        </div>
        <h3>Account Status</h3>
        <p>
          <span></span>
        </p></center>
    </div>
</div>

<div class="col-md-12">
      <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                <div class="count">
                    <?php echo $totalEarning;?>
                </div>
                <h3>Total Incentive</h3>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="tile-stats">
                  <div class="icon green"><i class="fa fa-money"></i></div>
                  <div class="count">
                      <?php echo $totalAvailableEarning;?>
                  </div>
                  <h3>
                    <a href="/commissions/getAll">Available Earnings</a>
                  </h3>

              </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="tile-stats">
                  <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                   <div class="count">
                      <?php echo $upline->firstname . ' ' .$upline->lastname;?>
                  </div>
                  <h3><?php echo WordLib::get('upline')?></h3>
              </div>
          </div>
 
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="tile-stats">
                  <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                   <div class="count">
                    <?php if(!$directSponsor) :?>
                        <?php echo "Direct Sponsor not found."?>
                    <?php else:?>
                        <?php echo $directSponsor->firstname . ' ' .$directSponsor->lastname;?>
                    <?php endif?>
                  </div>
                  <h3><?php echo WordLib::get('directSponsor')?></h3>
              </div>
          </div>

          <?php if(!isEqual($sessionUser['status'], 'pre-activated')) :?>
            <?php if(!is_null($binaryPoints)) :?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                        <div class="count">
                            <?php echo $binaryPoints->left_carry ?? 0;?>
                        </div>
                        <h3>POINT(LEFT)</h3>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                        <div class="count">
                        <?php echo $binaryPoints->right_carry ?? 0;?>
                        </div>
                        <h3>POINT(RIGHT)</h3>
                    </div>
                </div>
            <?php endif?>
            <?php endif?>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon green"><i class="fa fa-credit-card"></i> </div>
                    <div class="count">
                            <?php echo $personalPoint?>
                    </div>
                    <h3>PERSONAL POINTS</h3>
                </div>
            </div>
      </div>
      </div>
</div>
<?php endbuild()?>

<?php occupy('templates/layout')?>
