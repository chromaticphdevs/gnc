<!DOCTYPE html>
<html lang="en">
<head>
	<title>DBBI Activation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo URL.DS.'assets/images/icons/icon.png'?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/bootstrap/css/bootstrap.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'fonts/font-awesome-4.7.0/css/font-awesome.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'fonts/Linearicons-Free-v1.0.0/icon-font.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/animate/animate.css'?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/css-hamburgers/hamburgers.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'vendors/form/select2/select2.min.css'?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/form/util.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo URL.DS.'css/form/main.css'?>">
<!--===============================================================================================-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 
<!--===============================================================================================-->
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  height: 100px;
  border: 1.5px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
				
				<h3><?php Flash::show();?></h3>

					<?php if(isset($_GET['activation_code'])):?>
							<span class="login100-form-title p-b-55">
							   Registration
							</span>

						<form method="post" action="/LDActivation/form_activation" onSubmit="return confirm_action()">

							<input class="input100"  type="hidden" name="activation_code" value="<?php echo $_GET['activation_code'];?>">	
							<div class="wrap-input100 validate-input m-b-16" data-validate = "First name is required">
								<input class="input100" type="text" name="first_name"  id="first_name" placeholder="First name" required> 
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-user"></span>
								</span>
							</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Last name is required">
								<input class="input100" type="text" name="last_name"  id="last_name" placeholder="Last name" required> 
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-user"></span>
								</span>
							</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Cell Phone Number is required">
								<input class="input100" type="number" name="cp_number" placeholder="Cell Phone Number" required>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-phone-handset"></span>
								</span>
							</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
								<input class="input100" type="text" name="email" placeholder="Email" required>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-envelope"></span>
								</span>
							</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
								<input class="input100" type="text" name="username"  id="username" placeholder="Username" required>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-user"></span>
								</span>
							</div>

							<br>
					      <div class="field">
					        <label>Branch</label>
					        <select class="input100" name="branch" id="myselect1" >
					               <?php foreach($banchList as $branch) : ?>
					                   <option value="<?php  echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option> 
					               <?php endforeach;?>
					          </select>
					      </div>
						<br>
					      <div class="field">
					      <label>Referral Name</label>
					       

					          	
					      		<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="refer_name" id="refer_name" onkeyup="search_data()" placeholder="Search Referral Name or Email" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>
								<div id="search_data2">
			                       				

			                     </div>
			                     <datalist id="refer_name">
			                     		 <option value="small"/>
										    <option value="medium"/>
										    <option value="large"/>

			                     </datalist>

					          <!--<select class="input100" name="refer" id="myselect2">
					               <?php foreach($userList as $users) : ?>

					                   <option value="<?php  echo $users->id; ?>"><?php echo $users->firstname." ". $users->lastname; ?>&nbsp;->&nbsp;&nbsp;<?php echo $users->username; ?></option> 

					               <?php endforeach;?>
					          </select>-->

					      </div> 
					      	<br>

					      	<div class="wrap-input100 validate-input m-b-16" >
								-- Select Position --
	                        	<select  class="input100" id="branch"  name="position" >	                            	
	                        	
	                        	
				               			    <option value="LEFT">LEFT</option> 
				               			    <option value="RIGHT">RIGHT</option> 
				             	
	                        	</select>
								
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-layers"></span>
								</span>
					</div>


							<div class="container-login100-form-btn p-t-25">
								<button class="login100-form-btn">
									Submit
								</button>
							</div>
						</form>
					<?php else: ?>	

							<span class="login100-form-title p-b-55">
							  Activation Code
							</span>

						<form method="post" action="/LDActivation/verify_code">	

							<div class="wrap-input100 validate-input m-b-16" data-validate = "First name is required">
								<input class="input100" type="text" name="activation_code" placeholder="Enter  Activation Code" > 
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-layers"></span>
								</span>
							</div>
								<div class="container-login100-form-btn p-t-25">
								<button class="login100-form-btn">
									Verify
								</button>
							</div>
						</form>	
					<?php endif;?>			

					<div class="text-center w-full p-t-42 p-b-22">
						<div class="login100-pic js-tilt" data-tilt>
								<img src="<?php echo URL.DS.'assets/images/logo.jpg'?>" width="250px" height="250px" alt="IMG">
						</div><br>
						
						</div>

		
				
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?php echo URL.DS.'vendors/form/jquery/jquery-3.2.1.min.js'?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo URL.DS.'vendors/form/bootstrap/js/popper.js'?>"></script>
	<script src="<?php echo URL.DS.'vendors/form/bootstrap/js/bootstrap.min.js'?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo URL.DS.'vendors/form/select2/select2.min.js'?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo URL.DS.'vendors/form/tilt/tilt.jquery.min.js'?>"></script>
	<script src="<?php echo URL.DS.'js/form/main.js'?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script> 

			  $("#myselect1").select2();  

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


			function confirm_action(){

 				if(confirm("You are about to encode this  account: "+ $("#first_name").val()+" "+ $("#last_name").val()+"\n Your username will be: "+ $("#username").val()+"\n Your referral is: "+$("#refer option:selected").text()+"\n\n\n Submit now?")){


	 				if(confirm("Are u sure?")){

	 					return true;

	 				}else{

	 					return false;

	 				}

 				}else{

 					return false;

 				}

 			}		
 				



	
	</script>
</body>
</html>