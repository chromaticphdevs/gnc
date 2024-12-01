<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body >

  <main class="ui container">
    <div class="ui inverted menu">
      <a class="item" href="/LDUser/logout">
        LOGOUT
      </a>
      &nbsp;
      <a class="item">
        <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
      </a>
      <a class="item">
      &nbsp; &nbsp;<?php echo Session::get('user')['type'];?>
      </a>
      <a class="item" data-toggle="modal" data-target="#myModal">
        Purchase Package
      </a>
    </div>  

    <div class="ui segment">
      <h2>Transfer Account</h2>
      <?php Flash::show();?>
      <div class="ui grid">
        <div class="six wide column">
          <form method="post" action="">
           <div class="field">
            <label for="#">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter Username">
           </div>
           <br>
           <input type="submit" value="Search Account" >
          </form>
          </div>
        <div class="six wide column">
          <?php 
            if(isset($data['result']))
            {
              if(empty($data['result'])) 
              {
                ?> 
                <p>No User <?php echo $_POST['username'] . ' found '?></p>
                <?php
              }else{

                die(var_dump(Session::get('transferToken') , $token));
                ?> 
                  <div>
                    <ul class="list-unstyled">
                      <li><strong>Username  : </strong><?php echo $result->username?></li>
                      <li><strong>Firstname : </strong><?php echo $result->firstname . ' ' .$result->lastname?></li>
                      <li><strong>Lastname : </strong><?php echo $result->email?></li>
                      <li><?php echo $result->mobile?></li>
                    </ul>

                    <a href="/LDTransferAccount/">Select</a>
                  </div>
                <?php
              }
            }
          ?>
        </div>
      </div>

      
    </div>

        