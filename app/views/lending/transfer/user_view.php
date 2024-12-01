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
      <?php Flash::show();?><br>
      <h2>Transfer Account</h2><br>

      <div class="ui grid">
        <div class="eight wide column">
          <form method="post" action="">

            <input type="hidden" name="referral" value="<?php echo $user->direct_sponsor?>">
           <div class="field">
            <label for="#">First name</label>
            <input type="text" name="firstname" class="form-control" placeholder="Enter Firstname"
            value="<?php echo $user->firstname?>">
           </div>

           <div class="field">
            <label for="#">Last name</label>
            <input type="text" name="lastname" class="form-control" placeholder="Enter Lastname" 
            value="<?php echo $user->lastname?>">
           </div>

           <div class="field">
            <label for="#">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Enter Lastname" 
            value="<?php echo $user->email?>">
            <small>This is going to be their useraccount</small>
           </div>

           <div class="field">
            <label for="#">Phone/Mobile</label>
            <input type="text" name="mobile" class="form-control" placeholder="Enter Lastname" 
            value="<?php echo $user->mobile?>">
            <small>This is going to be their phone</small>
           </div>

           <div class="field">
            <label for="#">Branch</label>

            <select name="branch" id="" class="form-control">
              <?php foreach($branchList as $key => $row) :?>
                <option value="<?php echo $row->id?>"><?php echo $row->branch_name?></option>
              <?php endforeach;?>
            </select>
           </div>
           <br>
           <input type="submit" value="Transfer Account" >
          </form>
        </div>

        <div class="eight wide column">
          <h3>Social Network Information</h3>

          <ul>
            <li>Username : <?php echo $user->username?></li>
            <li>Fullname : <?php echo $user->fullname?></li>
            <li>Email : <?php echo $user->email?></li>
            <li>Phone : <?php echo $user->mobile?></li>
          </ul>
        </div>
      </div>

      
    </div>

        