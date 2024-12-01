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
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
			<form method="post" action="/LDActivation/activate_code_pre_register" 
			onSubmit="return confirm('This activation is final and irreversible Pls make sure your referral info and placement info is correct. or contact your referral to assist your activation.')">

					<center><h3><?php Flash::show();?></h3></center>
					<span class="login100-form-title p-b-55">
						
					</span>
 				
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="activation_code" placeholder="Enter  Activation Code">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-layers"></span>
						</span>
					</div>

					  	<div class="wrap-input100 validate-input m-b-16" >
								-- Select Position --
	                        	<select  class="input100" id="position"  name="position" >	                            	
			               			<option value="LEFT">LEFT</option> 
			               			<option value="RIGHT">RIGHT</option> 
	                        	</select>
								
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<span class="lnr lnr-layers"></span>
								</span>
					</div>
	
					<div class="container-login100-form-btn p-t-25">
						<!--<a class="login100-form-btn" href="/LDUser/pre_register_full">Login	</a>-->
						<button   class="login100-form-btn">
							Verify
						</button>
				
					</div>

					<div class="text-center w-full p-t-42 p-b-22">
						<div class="login100-pic js-tilt" data-tilt>
								<img src="<?php echo URL.DS.'assets/images/logo.jpg'?>" width="250px" height="250px" alt="IMG">
						</div><br>
							<!--<a class="txt2" href="/LDUser/pre_register">
								Register
								<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
							</a>-->
						</div>

		
				</form>
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
  				  $('#sample').select2();
		});
	</script>
</body>
</html>