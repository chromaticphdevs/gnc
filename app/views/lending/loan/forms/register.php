<!DOCTYPE html>
<html lang="en">
<head>
	<title>DBBI Pre-Registration</title>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
<!--===============================================================================================-->

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">

				<?php if(isset($_GET['username'])): ?>
								
						
						
						<h5 style=" text-align: center; ">Please use this reference code for all your transactions in DBBI</h5>
						<br>
						<br>
					
						<h1  style="color: red; text-transform: uppercase; text-align: center;  border: 5px solid black;"><?php echo $_GET['username']; ?></h1>
					
						<br>
						<br>
						<h4 style="text-transform: uppercase; text-align: center; ">Thank You</h4>
						<div class="container-login100-form-btn p-t-25">
							
							<a class="login100-form-btn" href="/LDUser/pre_register/?refferal_ID=<?php echo $_GET['refferal_ID']; ?>">
								OK
							</a>

						</div>
						<div class="text-center w-full p-t-42 p-b-22">
							
							<div class="login100-pic js-tilt" data-tilt>
								<img src="<?php echo URL.DS.'assets/images/logo.jpg'?>" width="250px" height="250px" alt="IMG">
							</div>

						</div>	
				<?php else: ?>

							<form method="post" action="/LDUser/pre_register">
								<h3><?php Flash::show();?></h3>
								<span class="login100-form-title p-b-55">
									Pre-Registration
								</span>
								<div class="wrap-input100 validate-input m-b-16" data-validate = "First name is required">
									<input class="input100" type="text" name="first_name" placeholder="First name" > 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>
								<div class="wrap-input100 validate-input m-b-16" data-validate = "Middle name is required">
									<input class="input100" type="text" name="middle_name" placeholder="Middle name" > 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>
								<div class="wrap-input100 validate-input m-b-16" data-validate = "Last name is required">
									<input class="input100" type="text" name="last_name" placeholder="Last name" > 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Cell Phone Number is required">
									<input class="input100" type="number" name="cp_number" placeholder="Cell Phone Number" >
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-phone-handset"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Address is required">
									<input class="input100" type="text" name="address" placeholder="Address" > 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>	

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text" name="email" placeholder="Email">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-envelope"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text" name="username" placeholder="Username">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>

								<!--<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid password is required: ex@abc.xyz">
									<input class="input100" type="password" name="password" placeholder="password">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-lock"></span>
									</span>
								</div>-->



								<!--<div class="wrap-input100 validate-input m-b-16" >
											-- Select Branch --
				                        	<select  class="input100" id="branch"  name="branch" >	                            	
				                        		
				                        		<?php foreach($branchList as $branch) : ?>
							               			    <option value="<?php  echo $branch->id; ?>"><?php echo $branch->branch_name.' '.$branch->address; ?></option> 
							             		 <?php endforeach;?>
				                        	</select>
											
											<span class="focus-input100"></span>
											<span class="symbol-input100">
												<span class="lnr lnr-layers"></span>
											</span>
								</div>-->


								<input type="hidden" name="refferal_ID" 
								value="<?php

									if(isset($_GET['refferal_ID']))
									{
										 echo $_GET['refferal_ID'];
									}

								  ?>">



								<div class="container-login100-form-btn p-t-25">
									<button class="login100-form-btn">
										Submit
									</button>
								</div>

								<div class="text-center w-full p-t-42 p-b-22">
									<div class="login100-pic js-tilt" data-tilt>
											<img src="<?php echo URL.DS.'assets/images/logo.jpg'?>" width="250px" height="250px" alt="IMG">
									</div><br>
										<a class="txt2" href="/LDUser/pre_register_login">
											Sign In
											<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
										</a>
									</div>

					
							</form>

					<?php endif; ?>				
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
		$(document).ready(function() {
  				  $('input100').select2();

		});
	</script>
</body>
</html>