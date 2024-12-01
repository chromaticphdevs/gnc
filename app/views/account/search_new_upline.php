<?php build('content') ?>
<?php Flash::show()?>

<?php if(!isset($new_upline) && empty($new_upline)):?>
    <div class="well">
        <h4>Current Team Adviser:</h4><h3><b style="color:green;"><?php echo unseal($_GET['TA']) ?></b></h3><br>
        <h3>Change Customer's Team Adviser?</h3>
        <form method="post" action="/users/search_upline">
            <div class="form-group">
                <label>Enter Username to Search</label>
                <input type="text" name="new_upline" class="form-control">
                <input type="hidden" name="old_upline" class="form-control" value="<?php echo $_GET['uplineId'] ?>">
                <input type="hidden" name="userID" class="form-control" value="<?php echo $_GET['userID'] ?>">
            </div>

            <div class="form-group">
                <input type="submit" name="" class="btn btn-primary" value="search">
            </div>
        </form> 
    </div>
<?php else:?>    
     <div class="well">
        <h4>Current Team Adviser:</h4><h3><b style="color:green;"><?php echo $old_upline->firstname.' '.$old_upline->lastname ?></b></h3><br>
        <h4>Transfer to :</h4><h3><b style="color:green;"><?php echo $new_upline[0]->firstname.' '.$new_upline[0]->lastname ?></b></h3><br>
        <form method="post" action="/users/change_upline">
            <div class="form-group">
              
                <input type="hidden" name="old_upline_id" class="form-control" 
                       value="<?php echo seal($old_upline->id) ?>">

                <input type="hidden" name="new_upline_id" class="form-control" 
                       value="<?php echo seal($new_upline[0]->id) ?>">

                <input type="hidden" name="user_id" class="form-control"
                       value="<?php echo seal($user_id) ?>">
            </div>

            <div class="form-group">
                <input type="submit" name="" class="btn btn-primary" value="Change Team Adviser">
            </div>
        </form> 
    </div>
<?php endif;?>  

<?php endbuild()?>

<?php occupy('templates/layout')?>
