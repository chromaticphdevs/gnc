<?php
  /*
  *All functions that will be created on
  *this file must have a prefix of UI
  */

  function UI_binary_branch($user , $tree_position = null ,$position = null , $upline = null)
	{
		$img = URL.DS.'uploads/binary_icon_2.png';
    if(!empty($upline->username))
    {
      if(!empty($user->username)){
        ?>

        <a href="/geneology/binary">
          <div class="circle user-<?php echo $user->status;?>">
              <img src="<?php echo $img;?>">
          </div>
          <span>
              <strong><?php echo $user->status?></strong>
              <div><?php echo $user->username?> <?php echo $user->id?></div>
              <div>left : <?php echo $user->binary['left']?></div>
              <div>right : <?php echo $user->binary['right']?></div>
              <div> <?php echo $tree_position?></div>
          </span>
          <div class="position"><?php echo $user->L_R?></div>
        </a>
        <?php
      }else{
        $img = URL.DS.'uploads/womenaddusericon.png';
        ?>
          <a href="/geneology/create_account?uplineid=<?php echo $upline->id?>&position=<?php echo $position?>">
            <div class="circle user-pre-activated">
                <img src="<?php echo $img;?>">
            </div>
            <span>
                <strong>NA <?php echo $tree_position?></strong>
            </span>
            <div class="position">
              &nbsp;Add Account&nbsp;
            </div>
          </a><br>

           <a href="/LDUser/pre_register_geneology?uplineid=<?php echo $upline->id?>&position=<?php echo $position?>&direct=<?php echo SESSION::get("USERSESSION")['id']; ?>" target="_blank">

             <div class="position">
              <b style="color: green;">&nbsp;Spill Over&nbsp;</b>
             </div>
          </a>
        <?php
      }
    }else{
      $img = URL.DS.'uploads/goalicon2.png';
      ?>
       <a href="#">
          <div class="circle">
              <img src="<?php echo $img;?>">
          </div>
          <span>
              <strong>EMPTY</strong>
          </span>
          <div class="position">
            <?php echo $tree_position?>
          </div>
        </a>
      <?php
    }
	}




  /*********************************************************************************************
  RETURN HTML RENDERS
  *********************************************************************************************/


  function ui_html_amount($amount)
  {
    
    if($amount < 0) {
      $amount = abs($amount);
      $amountTxt  = number_format($amount,2);
      $amountTxt = "({$amountTxt})";
    } else {
      $amountTxt = number_format($amount,2);
    }
    return $amountTxt;
  }