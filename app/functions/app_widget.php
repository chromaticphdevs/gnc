<?php

function wControlButtonRight($moduleName, $links = []) {
  $linkString = '';

  foreach($links as $key => $row) {
      $icon = $row['attributes']['icon'] ?? 'fas fa-plus-circle';
      $linkAttributes = '';
      $defaultClass = "btn btn-primary btn-sm bg-gradient-primary rounded-0 btn-icon-split mb-0";

      if(!empty($row['attributes']['link-attributes'])) {
        foreach($row['attributes']['link-attributes'] as $linkKey => $linkRow) {
          if($linkKey == 'class') {
            $defaultClass .= ' ' . $linkRow;
          } else {
            $linkAttributes .= keypair_to_str([
              "{$linkKey}" => $linkRow
            ]);
          }
        }
      }

      $defaultClass = " class = '{$defaultClass}' ";
      
      $linkString .= <<<EOF
          <a href="{$row['url']}" {$defaultClass} {$linkAttributes}>
              <span class="icon text-white-600">
                  <i class="{$icon}"></i>
              </span>
              <span class="text">{$row['label']}</span>
          </a>
      EOF;
  }
  
  return <<<EOF
      <div class="d-flex w-100 align-items-center">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <h1 class="h3 mb-0 text-gray-800">{$moduleName}</h1>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
              {$linkString}
          </div>
      </div>
      <hr/>
  EOF;
}

function wControlButtonLeft($moduleName, $links = []) {
  $linkString = '';
  foreach($links as $key => $row) {

    $icon = $row['attributes']['icon'] ?? 'fas fa-chevron-left';
    $linkAttributes = '';
    $defaultClass = "btn btn-light bg-gradient-light border rounded-0 btn-icon-split mb-4";

    if(!empty($row['attributes']['link-attributes'])) {
      foreach($row['attributes']['link-attributes'] as $linkKey => $linkRow) {
        if($linkKey == 'class') {
          $defaultClass .= ' ' .$linkRow;
        } else {
          $linkAttributes .= keypair_to_str([
            "{$linkKey}" => $linkRow
          ]);
        }
      }
    }

    $defaultClass = " class = '{$defaultClass}'";

    $linkString .= <<<EOF
        <a href="{$row['url']}" {$defaultClass} {$linkAttributes}>
            <span class="icon text-white">
                <i class="{$icon}"></i>
            </span>
            <span class="text">{$row['label']}</span>
        </a>
    EOF;
  }
  return <<<EOF
      <div class="d-flex w-100 align-items-center">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <h1 class="h3 mb-0 text-gray-800">{$moduleName}</h1>
              {$linkString}
          </div>
      </div>
  EOF;
}

function wDivider($height = 30)
{
    return <<<EOF
        <div style="margin-top:{$height}px"> </div>
    EOF;
}

function wCardTitle($title) {
  return <<<EOF
      <h6 class='m-0 font-weight-bold card-title'>{$title}</h6>
  EOF;
}

function wCardHeader($content) {
  return <<<EOF
      <div class="card-header py-3" style="background-color:#243954;
          color:#fff">
          {$content}
      </div>
  EOF;
}

function wCardHeaderSmall($content) {
  return <<<EOF
      <div class="card-header py-2" style="background-color:#243954;
          color:#fff;">
          {$content}
      </div>
  EOF;
}


function userVerfiedText($user = null) {
  $user = is_object($user) ? (array) $user: $user;
  $reVal = "<span title='verified account'><i class='fa fa-check-circle' style='color:#189beb'></i></span>";

  if(is_bool($user) && $user == TRUE) {

  } else if(!is_null($user)) {
    $userVerified = $user['is_user_verified'] ?? '';
    if(!$userVerified) {
      $reVal = "";
    } 
  }
  
  return $reVal;
}

/**
 * if trueOrfalse == true then return 
 * textResult 0 position
 */
function wTruOrFalseText($trueOrfalse = false, $textResult = [], $background = ['green', 'red']) {
  $textResponse = $trueOrfalse ? $textResult[0] : $textResult[1];
  $style = $trueOrfalse ? "background:{$background[0]}" : "background:{$background[1]}";
  return "<span class = 'badge' style = '$style; color:#fff;'>{$textResponse}</span>";
}

/**
     * UI
     */
    function wPaginator($numberOfItems, $itemPerPage, $routeName, $queryParam = []) {
      $linkHTML = '';
      $paginateMax = 10;
      $linkCount = ceil($numberOfItems / $itemPerPage);
      for($i = 1; $i <= $linkCount; $i++) {
          $queryParam['page'] = $i;
          $href = _route($routeName, $queryParam);
          if($i < $paginateMax) {
            $linkHTML .= "
                <li class='page-item'>
                    <a href='{$href}' class ='page-link'>{$i}</a>
                </li>
            ";
          } else {
            $linkHTML .= "
                <li class='page-item'>
                    <a href='' class ='page-link disabled'>...</a>
                </li>
            ";
            break;
          }
      }

      $lastRoute = $queryParam;
      $lastRoute['page'] = $linkCount;
      $lastRoute = _route($routeName, $lastRoute);

      $firstRoute = $queryParam;
      $firstRoute['page'] = 1;
      $firstRoute = _route($routeName, $firstRoute);

      return "
          <ul class='pagination' style='margin:0px auto;'>
              <li class='page-item'>
                  <a href='{$firstRoute}' class ='page-link'>First</a>
              </li>
              {$linkHTML}
              <li class='page-item'>
                  <a href='{$lastRoute}' class ='page-link'>Last</a>
              </li>
          </ul>
      ";
  }



function html_task_todos_table()

{

  ?>



    <table class="table">

      <thead>

        <th>Category</th>

        <th>Link</th>

        <th>Points</th>

        <th>Action</th>

      </thead>



      <tbody>

        <?php $totalpoints = 0;?>

        <?php foreach($taskList as $task) : ?>

          <?php $totalpoints += $task->points ?>

          <tr>

            <td><?php echo $task->category?></td>

            <td><?php echo $task->link?></td>

            <td><?php echo $task->points?></td>

            <td><a href="<?php echo URL.DS.'task/'.$task->category.DS.$task->id?>">Do Task</a></td>

          </tr>

        <?php endforeach;?>

      </tbody>

    </table>



  <?php

}





function html_binary_widget($user ,$tree_position = null ,$position , $upline = null)

{

  $img = URL.DS.'uploads/binary_icon_2.png';





  if(strtolower($upline->username) != 'n/a')

  {

    if(strtolower($user->username) != 'n/a'){



      $fifthlevel = isset($_GET['level']) ? 'level=5': '';



      ?>



      <a href="/geneology/binary/<?php echo $user->id?>?<?php echo $fifthlevel?>" class="binary-user">

        <div class="circle user-<?php echo $user->status;?>">
            
        </div>

        <span>
            <div><?php echo $user->username;?></div>
            <strong><?php echo $user->status?></strong>

            <div>left : <?php echo $user->left?></div>

            <div>right : <?php echo $user->right?></div>

        </span>

        <div class="position"><?php echo $position?></div>

      </a>

      <?php

    }else{

      $img = URL.DS.'uploads/womenaddusericon.png';
      $q = seal(['position' => $position, 'upline' => $upline->id]);
      ?>

        <a href="/RaffleRegistrationController/registerNetwork?q=<?php echo $q?>" class="binary-user">

          <div class="circle user-pre-activated">

          </div>

          <span>
              <strong>NA <?php echo $tree_position?></strong>
          </span>
        </a><br>
        <a href="<?php echo getUserLink($upline->id, null ,$position)?>" target="_blank">

          <div class="position">

          </div>

        </a>



      <?php

    }

  }else{

    $img = URL.DS.'uploads/goalicon2.png';

    ?>

     <a href="#" class="binary-user">

        <div class="circle">

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





function html_binary_branch($userData)

{

  $img = URL.DS.'uploads/binary_icon_2.png';

  $class = $userData['status'] == null ? 'no-user' : $userData['status'];

  ?>

      <a href="?userid=<?php echo $userData['id'] ?? '#'?>" title="<?php echo $userData['username']?>" class="branch <?php echo strtolower($class)?> binary-user">

          <div class="circle user-<?php echo $userData['status'];?>">

          </div>

          <div>

              <div><?php echo crop_string( $userData['username']  , 5) ?? 'no user'?></div>

              <div><?php echo 'L: '.$userData['left'] . ' <br/>

              </br/> '.'R: '.$userData['right'] ?></div>

          </div>

      </a>

  <?php

}







function wProductLoanMakePaymentBtn($id , $text = null)
{
$sealedId = seal($id);

if(is_null($text))
  $text = 'Make Payment';
return <<<EOF
  <a class="btn btn-success btn-sm" href="/ProductLoan/show/{$sealedId}"> {$text} </a>
EOF;
}


function wReferralLinkButton($link) {
  $link = str_link_fix(htmlspecialchars($link));
  return <<<EOF
    <button class='btn btn-primary btn-sm' class='referral-link-button' 
      data-link='{$link}' data-message='Link copied, share to your friends'
        onclick='copyStringToClipBoard("{$link}", "alert", "Link copied, share to your friends")'><i class='fas fa-link'></i> Referral</button>
  EOF;
}

function wReferralLink($link) {
  $link = str_link_fix(htmlspecialchars($link));
  return <<<EOF
    <div> 
      My <span class='badge badge-primary' onclick='copyStringToClipBoard("{$link}", "alert", "Link copied, share to your friends")'><i class='fas fa-link'></i> Referral<span>
    <div>
  EOF;
}