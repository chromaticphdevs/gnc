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
        <input type="text" name="email" placeholder="Email" required>
      </div>

      <div class="field">
        <label>Phone</label>
        <input type="number" name="phone" placeholder="Phone" required>
      </div>

     <!-- <div class="field">
        <label>Address</label>
        <input type="text" name="home" placeholder="Home Number and st." required>
        <input type="text" name="brgy" placeholder="Barangay" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="province" placeholder="Province" required>
      </div>-->

      <div class="field">
        <label>Branch</label>
        <select name="branch" class="selectpicker" data-live-search="true">
               <?php foreach($branchList as $branch) : ?>
                   <option value="<?php  echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option> 
               <?php endforeach;?>
          </select>
      </div>

      <div class="field">
      <label>Referral Name</label>

          <input class="input100" type="text" name="refer" id="refer_name" onkeyup="search_data()" placeholder="Search Referral Name or Email" required>
            <div id="search_data2">
                                    

                           </div>
         <!-- <select name="refer" class="selectpicker" data-live-search="true">
               <?php foreach($userList as $users) : ?>

                   <option value="<?php  echo $users->id; ?>" data-subtext="<?php echo $users->username; ?>">&nbsp;<?php echo $users->firstname." ". $users->lastname; ?></option> 

               <?php endforeach;?>
          </select>-->

      </div> 

      <div class="field">
        <div class="col-md-3">
        <label>Position</label>
        <select name="position" class="form-control">
          <option value="left">Left</option>
          <option value="right">Right</option>
        </select>
        </div>
        
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
     <a href="/LDCashier/index">Back</a>
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
function search_data(){
      
          $.ajax({
              method: "POST",
              url: '/LDActivation/live_search',
              data:{data: $("#refer_name").val()},
              success:function(response)
              {
                console.log(response);
                $('#search_data2').html(response);
                return false;     
              }
              }); 
          }
        
  </script>


<?php require_once VIEWS.DS.'lending/template/footer.php'?>
