<?php require_once VIEWS.DS.'lending/template/header.php'?>

</head>
<body style="">
  <?php //require_once VIEWS.DS.'pages/tmp/navigation.php'?>
  
  <main class="ui main text container">
     <?php Flash::show();?>
  	<h1 class="ui header">Registration Form</h1>

    <form class="ui form" method="post" action="/LDUser/add_user">
      <div class="field">

           <!--Location-->
          <input type="hidden" name="latitude"  id="latitude">
          <input type="hidden" name="longitude" id="longitude">
          <!--Location-->

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
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" required>
      </div>

      <div class="field">
        <label>Phone</label>
        <input type="number" name="phone" placeholder="Phone" required>
      </div>
      <div class="field">
        <label>Address</label>
        <input type="text" name="home" placeholder="Home Number and st." required>
        <input type="text" name="brgy" placeholder="Barangay" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="province" placeholder="Province" required>
      </div>


      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <div class="field">
        <label>Branch</label>
        <input type="text" name="branch" placeholder="Branch" required>
      </div>
      <div class="field">
      <label>Referral Name</label>
       
          <select name="refer" class="selectpicker" data-live-search="true">
               <?php foreach($userList as $users) : ?>

                   <option value="<?php  echo $users->id; ?>"><?php echo $users->firstname." ". $users->lastname; ?></option> 

               <?php endforeach;?>
          </select>

      </div> 
      <div class="field">
        <label>
           <input type="checkbox" name="" class="ui checkbox" required>
          Agree to terms and condition
        </label>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>

      <button class="ui button primary" type="submit">Submit</button>
    </form>
    <a href="/LDUser/login">LOGIN</a>
  </main>

  <script type="text/javascript" >
$( document ).ready(function(){


function getLocation() {

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);

  } else { 
   alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
   document.getElementById("latitude").value = position.coords.latitude; 
   document.getElementById("longitude").value = position.coords.longitude; 
}
getLocation();

});

  </script>


<?php require_once VIEWS.DS.'lending/template/footer.php'?>
