<?php build('content')?>
<?php $milestone = count($cashAdvances) + 1?>
<?php foreach($cashAdvances as $key => $row) :?>
<?php if($row->is_shown) :?>
<div class="col-xs-12">
    <div class="tile-stats">
        <div class="icon green"><i class="fa fa-credit-card"></i> </div>
        <div class=" text-center">
          <h5>&nbsp;&nbsp;&nbsp;#<?php echo --$milestone?> - Cash Advance</h5>
          <div class="count">
            <?php echo to_number($row->amount)?>
          </div>
          <div class="">
            <h3><?php echo $row->status?></h3>
            <small>Current Status</small>
          </div>
          <hr>
          <?php if(strtolower($row->status) != 'pending') :?>
          <!--<form action="/FNCashAdvance/requestCashAdvance" method="post">
            <input type="hidden" name="user_id" value="<?php echo $userid?>">
            <input type="hidden" name="amount" value="<?php echo $row->amount?>">
            <input type="submit" name="" value="Apply Now"
            class="btn btn-primary btn-sm">
          </form>-->
        <?php else:?>
        <?php endif;?>

        <?php if($row->amount == '5000' AND strtolower($row->status) == 'pending' ) :?>
    
            <a class="btn btn-success btn-sm" href="/UserIdVerification/upload_id">Apply Now</a>
              
        <?php endif; ?>

        </div>
    </div>
</div>
<?php endif?>
<?php endforeach?>
<?php endbuild()?>

<?php occupy('templates/layout')?>
