<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">

  <main class="ui container">
   <div class="ui inverted menu">
      <a class="item" href="/LDUser/logout">
        LOGOUT
      </a>
      &nbsp;
       <a class="item">
     <?php echo Session::get('user')['firstname']." ".Session::get('user')['lastname'];?>
      </a>
        <?php if(Session::get('user')['type']== "super admin"):?>
           <a class="item" href="/LDProductAdvance/create_activation_code">
            Create Activation Code
          </a>
      <?php endif; ?>
    </div>


    <div class="ui grid">
      <?php require_once VIEWS.DS.'lending/template/sidebar.php'?>

  <main class="ui main text container">

     <?php Flash::show();?>

  	<h1 class="ui header">Create User Account</h1>

    <form class="ui form" method="post" action="/LDUser/create_account">
      <div class="field">

        <label>First Name</label>
        <input type="text" name="firstname" placeholder="First Name" required>
      
      </div>
         <div class="field">
        <label>Middle Name</label>
        <input type="text" name="middlename" placeholder="Last Name" required>
      </div>
      <div class="field">
        <label>Last Name</label>
        <input type="text" name="lastname" placeholder="Last Name" required>
      </div>
      <div class="field">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" required>
      </div>

      <div class="field">
        <label>Phone</label>
        <input type="number" name="phone" placeholder="Phone" required>
      </div>

      <div class="field">
        <label>Branch</label>
        <select name="branch" class="selectpicker" data-live-search="true">
               <?php foreach($branchList as $branch) : ?>
                   <option value="<?php  echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option> 
               <?php endforeach;?>
          </select>
      </div>

      <div class="field">
        <label>User Type</label>
        <select name="user_type">  
                  <option value="admin">Admin</option> 
                  <option value="cashier">Cashier</option> 
                  <option value="Encoder">Encoder</option> 
          </select>
      </div>

      <button class="ui button primary" type="submit">Create</button>
    </form>
 
  </main>

 <script type="text/javascript" >


      $( document ).ready(function(){


   

      });

        
 </script>


<?php require_once VIEWS.DS.'lending/template/footer.php'?>
