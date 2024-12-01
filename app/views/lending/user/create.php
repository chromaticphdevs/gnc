<?php require_once VIEWS.DS.'lending/template/header.php'?>
</head>
<body style="">

  <main class="ui container">
    <div class="ui inverted menu">
      <a class="active item">
        Home
      </a>
      <a class="item">
        Messages
      </a>
      <a class="item">
        Friends
      </a>
    </div>


    <div class="ui grid">
      <?php require_once VIEWS.DS.'lending/template/sidebar.php'?>

      <section class="ui segment">
         <?php Flash::show();?>
        <h3>Create Lender</h3>
     
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
        <input type="text" name="email" placeholder="Email" required>
      </div>

      <div class="field">
        <label>Phone</label>
        <input type="text" name="phone" placeholder="Phone" required>
      </div>

      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <div class="field">
        <label>
           <input type="checkbox" name=""  class="ui checkbox" required>
          Agree to terms and condition
        </label>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>

      <button class="ui button primary" type="submit">Submit</button>
  
    </form>
      </section>
     
  </main>
    </div>
    
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

