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
        <span class="label label-success"><?php  echo Session::get('user')['type'];?></span>
      </a>

        <?php if(Session::get('user')['type']== "super admin"):?>
           <a class="item" href="/LDProductAdvance/create_activation_code">
            Create Activation Code
          </a>
          <a class="item" href="/LDActivation/history_activation_code">
            Activation Code History
          </a>
          <a class="item" href="/LDDeviceToken/">
              Device Token (Beta)
          </a>
          <a class="item" href="/LDTransferAccount/">
              Transfer Account (Beta)
          </a>
      <?php endif; ?>
      
      <?php if(Session::get('user')['type']== "admin" OR Session::get('user')['type']== "cashier"):?>
           <a class="item" data-toggle="modal" data-target="#myModal">
            Purchase Package
          </a>
      <?php endif; ?>

      <?php if(Session::get('user')['type']== "customer"):?>
           <a class="item" href="/LDPayment/make_payment/<?php echo Session::get('user')['id']; ?>">
            Post Payment
          </a>
      <?php endif; ?>
      <a class="item" href="/LDGeneology/binary">
          Binary(Beta)
      </a>
    </div>  

    <div class="ui segment">
      <?php Flash::show();?><br>
      <h2>Transfer Account</h2><br>

      <div class="ui grid">
        <div class="eight wide column">
          <h3>DBBI INFORMATION</h3>

          <ul>
            <li>Firstname : <?php echo $dbbiAccount->firstname?></li>
            <li>Lastname : <?php echo $dbbiAccount->lastname?></li>
            <li>Email : <?php echo $dbbiAccount->email?></li>
            <li>Phone : <?php echo $dbbiAccount->phone?></li>
          </ul>
        </div>

        <div class="eight wide column">
          <h3>Social Network Information</h3>

          <ul>
            <li>Username : <?php echo $sneAccount->username?></li>
            <li>Fullname : <?php echo $sneAccount->fullname?></li>
            <li>Email : <?php echo $sneAccount->email?></li>
            <li>Phone : <?php echo $sneAccount->mobile?></li>
          </ul>
        </div>
      </div>

      
    </div>

        