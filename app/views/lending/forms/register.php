<!DOCTYPE html>
<html lang="en">
<head>
	<meta property="og:image" content="<?php echo URL.DS?>uploads/money_money.png"/>
    <meta property="og:type" content="image/jpeg"/>
    <meta property="og:width" content="300"/>
    <meta property="og:height" content="300"/>
	<title>Breakthrough Pre-Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo URL.DS.'uploads/main_icon.png'?>"/>
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
<script type="text/javascript" src="<?php echo URL.DS.'js/core/conf.js'?>"></script>
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
								
						
						
						<h5 style=" text-align: center; ">Please Take a Screenshot and <br> Please use this reference code for all your <br> transactions in Breakthrough</h5>
						<br>
						<br>
					
						<h1  style="color: red; text-transform: uppercase; text-align: center;  border: 5px solid black;"><?php echo $_GET['username']; ?></h1>
					
						<br>
						<br>
						<h4 style="text-transform: uppercase; text-align: center; ">Thank You</h4>
						<div class="container-login100-form-btn p-t-25">
							
							<!--<a class="login100-form-btn" href="/LDUser/pre_register/?refferal_ID=<?php echo $_GET['refferal_ID']; ?>">
								OK
							</a>-->
							<a class="login100-form-btn" href="/users/change_account_session_registration/<?php echo $_GET['username']; ?>">
								LOGIN
							</a>

						</div>
						<div class="text-center w-full p-t-42 p-b-22">
							
							<div class="login100-pic js-tilt" data-tilt>
								<img src="<?php echo URL.DS.'uploads/breakthrough.jpg'?>" width="100%" height="230px" alt="IMG">
							</div>

						</div>	
				<?php else: ?>

							<form method="post"  action="#" onSubmit = "return input_submit()" >
								<h3><?php Flash::show();?></h3>
								<span class="login100-form-title p-b-55">
									Pre-Registration
								</span>
								<div class="wrap-input100 validate-input m-b-16" data-validate = "First name is required">
									<input class="input100" type="text"  name="first_name" id="first_name" placeholder="First name" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>
								<div class="wrap-input100 validate-input m-b-16" data-validate = "Middle name is required">
									<input class="input100" type="text"  name="middle_name" id="middle_name" placeholder="Middle name" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>
								<div class="wrap-input100 validate-input m-b-16" data-validate = "Last name is required">
									<input class="input100" type="text"  name="last_name" id="last_name" placeholder="Last name" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Cell Phone Number is required">
									<input class="input100" type="number"  name="cp_number" id="cp_number" placeholder="Cell Phone Number" required>

									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-phone-handset"></span>
									</span>
								</div>


								 <!----------------- Address Info end-------------------------->


								<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text"  name="email" id="email" placeholder="Email" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-envelope"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text"  name="username" id="username" placeholder="Username" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>

								<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text"  name="religion_text" id="religion_text"  placeholder=" Religion" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-user"></span>
									</span>
								</div>

								<div id="search_data2">
			                       				

			                    </div>

			                    <br>
								


								<!-- --------------------Address Info 
								<div class="wrap-input100 validate-input m-b-16" data-validate = "Address is required">
									<input class="input100" type="text"  name="house_st" id="house_st" placeholder="House Number and Street" required> 
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>


								<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text"  name="" id="brgy_text"  placeholder=" Barangay" required >
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>

								<div id="brgy_data"></div>

			                    <br>
			                    <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text"  name="" id="city_text"  placeholder=" City" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>

								<div id="city_data"></div>

			                    <br>
			                    <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text"  name="" id="province_text"  placeholder=" Province" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>

								<div id="province_data"></div>

			                    <br>
			                    <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text"  name="" id="region_text"  placeholder=" Region" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>--------------------------->

								<div id="region_data"></div>

			                    <br>
			                   
			                  

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
	
								<!--<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid password is required: ex@abc.xyz">
									<input class="input100" type="password" name="password" placeholder="password">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-lock"></span>
									</span>
								</div>-->


								<div class="wrap-input100 validate-input m-b-16" >
											-- Select Branch --
				                        	<select  class="input100" id="branch"  name="branch" >	                            	
				                        		
				                        		<?php foreach($branchList as $branch) : ?>
							               			    <option value="<?php  echo $branch->id; ?>"><?php echo $branch->name.' '.$branch->address; ?></option> 
							             		 <?php endforeach;?>
				                        	</select>
											
											<span class="focus-input100"></span>
											<span class="symbol-input100">
												<span class="lnr lnr-layers"></span>
											</span>
								</div>


								<input type="hidden" name="refferal_ID" id="refferal_ID" 
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
											<img src="<?php echo URL.DS.'uploads/breakthrough.jpg'?>" width="100%" height="230px" alt="IMG">
									</div><br>
										
									</div>

					
							</form>

					<?php endif; ?>				
			</div>
		</div>
	</div>
	
		
	<!--       ))))))))))))))))))))))))))))Confirmation modal(((((((((((((((( -->
<div class="modal fade" id="modalForm_text" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Confirmation</h4>
      
      </div>
      <div class="modal-body mx-3">


     	<center><h4>We have sent a code to your mobile number Please Enter code to confirm your registration</h4></center><br><br>
		<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
			<input size="20" maxlength="20" style="text-transform:uppercase" class="input100" type="text" autocomplete="off" name="confirm_code_text" id="confirm_code_text" placeholder="Code" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<span class="lnr lnr-checkmark-circle"></span>
			</span>
		</div>

		<input size="20" maxlength="20" style="text-transform:uppercase"  type="hidden" autocomplete="off" name="codecode_text" id="codecode_text" placeholder="Code" required>


      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="login100-form-btn" onclick="register_user()">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!--       ))))))))))))))))))))))))))))Confirmation modal(((((((((((((((( -->
<div class="modal fade" id="modalForm_email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Confirmation</h4>
      
      </div>
      <div class="modal-body mx-3">


     	<center><h4>We have sent a code to your Email  Please Enter code to confirm your registration</h4></center><br><br>
		<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
			<input size="20" maxlength="20" style="text-transform:uppercase" class="input100" type="text" autocomplete="off" name="confirm_code_email" id="confirm_code_email" placeholder="Code" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<span class="lnr lnr-checkmark-circle"></span>
			</span>
		</div>

		<input size="20" maxlength="20" style="text-transform:uppercase"  type="hidden" autocomplete="off" name="codecode" id="codecode_email" placeholder="Code" required>


      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="login100-form-btn" onclick="register_user()">Confirm</button>
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

		/*function search_data()
		{
			$.ajax({
		      method: "POST",
		      url: '/Religion/live_search',
		      data:{key_word: $("#religion_text").val()},
		      success:function(response)
		      {
		        console.log(response);
		        $('#search_data2').html(response);
		        return false;			
		      }
			});	
		}

		function brgy_f()
		{
			$.ajax({
		      method: "POST",
		      url: '/LiveSearch/brgy',
		      data:{key_word: $("#brgy_text").val()},
		      success:function(response)
		      {
		        console.log(response);
		        $('#brgy_data').html(response);
		        return false;			
		      }
			});	
		}

		function city_f()
		{
			$.ajax({
		      method: "POST",
		      url: '/LiveSearch/city',
		      data:{key_word: $("#city_text").val()},
		      success:function(response)
		      {
		        console.log(response);
		        $('#city_data').html(response);
		        return false;			
		      }
			});	
		}

		function province_f()
		{
			$.ajax({
		      method: "POST",
		      url: '/LiveSearch/province',
		      data:{key_word: $("#province_text").val()},
		      success:function(response)
		      {
		        console.log(response);
		        $('#province_data').html(response);
		        return false;			
		      }
			});	
		}

		function region_f()
		{
			$.ajax({
		      method: "POST",
		      url: '/LiveSearch/region',
		      data:{key_word: $("#region_text").val()},
		      success:function(response)
		      {
		        console.log(response);
		        $('#region_data').html(response);
		        return false;			
		      }
			});	
		}

		function brgy_click()
		{
			var e = document.getElementById("brgy_select");
			var result = e.options[e.selectedIndex].value;

			document.getElementById("brgy_text").value = result;	
		}

		function city_click()
		{
			var e = document.getElementById("city_select");
			var result = e.options[e.selectedIndex].value;

			document.getElementById("city_text").value = result;	
		}

		function province_click()
		{
			var e = document.getElementById("province_select");
			var result = e.options[e.selectedIndex].value;

			document.getElementById("province_text").value = result;	
		}

		function region_click()
		{
			var e = document.getElementById("region_select");
			var result = e.options[e.selectedIndex].value;

			document.getElementById("region_text").value = result;	
		}


		function religion_click()
		{
			var e = document.getElementById("religion_select");
			var result = e.options[e.selectedIndex].text;

			document.getElementById("religion_text").value = result;	
		}*/


		function input_submit()
		{	
			var email_check = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var email = $("#email").val();

			if(email_check.test(email) == false)
			{

				alert("Invalid Email Format"); 
			    document.getElementById("email").value = "";
			    document.getElementById("email").focus();
			    return false;
			}

			var special_char = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
			var regExpr = /[^a-zA-Z0-9]/g;
			var username = $("#username").val();
			
			if(special_char.test(username) == true)
			{

				alert("Invalid Username. Dont use Special Characters"); 
			    document.getElementById("username").value =username.replace(regExpr, "");
			    document.getElementById("username").focus();
			    return false;
			}
			if(username.length > 12)
			{	
				alert("Invalid! Username must have 12 letters or characters only");
				document.getElementById("username").focus();
			    return false;
			}

			var first_name_input = $("#first_name").val();
			var middle_name_input = $("#middle_name").val();
			var last_name_input = $("#last_name").val();
			//check String of names					
			if(special_char.test(first_name_input) == true)
			{

				alert("Invalid First Name. Dont use Special Characters"); 
			    document.getElementById("first_name").value =first_name_input.replace(regExpr, "");
			    document.getElementById("first_name").focus();
			    return false;
			}
			if(special_char.test(middle_name_input) == true)
			{

				alert("Invalid Middle Name. Dont use Special Characters"); 
			    document.getElementById("middle_name").value =middle_name_input.replace(regExpr, "");
			    document.getElementById("middle_name").focus();
			    return false;
			}
			if(special_char.test(last_name_input) == true)
			{

				alert("Invalid Last Name. Dont use Special Characters"); 
			    document.getElementById("last_name").value =last_name_input.replace(regExpr, "");
			    document.getElementById("last_name").focus();
			    return false;
			}//end					


			var cp_number =$("#cp_number").val();

			if(/^[0-9]+$/i.test(cp_number)==true)
			{
			  	if(cp_number.length<=10 || cp_number.length>=12)
			  	{
			      
			        alert("Invalid Number. Please Enter 11 digit number"); 
			        document.getElementById("cp_number").focus();
					return false;

				}else{

				    if(cp_number.substring(0, 2)!="09")
				    {
				         
					    alert("Invalid Number format eg. 09*********"); 
					    document.getElementById("cp_number").value = "";
					    document.getElementById("cp_number").focus();
						return false; 
				      
					}
				}
			}
			else
			{ 
				alert("Please Enter Number Only for Contact Number"); 
				document.getElementById("cp_number").value = "";
			    document.getElementById("cp_number").focus();
				return false; 
			}

			$.ajax({
		      method: "POST",
		      url: '/LDUser/check_send_text_code',
		      data:{

		      	first_name: $("#first_name").val(),
		      	last_name: $("#last_name").val(),
		      	email: email,
		      	cp_number: cp_number,
		      	username: username
		  		},
		      success:function(response)
		      {
		       
		      	if(response == 1)
		      	{
		      		
		      		alert("Username already exist");
		      		document.getElementById("username").value = "";
		      		document.getElementById("username").focus();

		      	}else if(response == 2)
		      	{
					
		      		alert("Email already exist");
		      		document.getElementById("email").value = "";
		      		document.getElementById("email").focus();
		      		
		      	}else if(response == 3)
		      	{
		      		
		      		alert("Mobile Number already exist");
		      		document.getElementById("cp_number").value = "";
		      		document.getElementById("cp_number").focus();
		   			
		      	}else if(response == 4)
		      	{
		      		
		      		alert("Phone Number is too long");
		      		document.getElementById("cp_number").focus();
		      		
		      	}else if(response == 5)
		      	{
		      		
		      		alert("Firstname and Lastname already exist");
		      		document.getElementById("first_name").value = "";
		      		document.getElementById("last_name").value = "";
		   			document.getElementById("first_name").focus();
		      		
		      	}else 
		      	{	
		      		document.getElementById("codecode_text").value = response;

		      		$('#modalForm_text').modal({
					    backdrop: 'static',
					    keyboard: false
					})
		      		

		      	}

		      }
			});	

			return false;
		}	

		function register_user()
		{	

			var code = $("#codecode_text").val();
			var user_input = $("#confirm_code_text").val();


			user_input = user_input.toUpperCase();

			if(code != user_input)
			{
					alert("Invalid Code");

			}else
			{

					var username = $("#username").val();
					var refferal_ID = $("#refferal_ID").val();

					/*var e1 = document.getElementById("brgy_select");
					var brgy = e1.options[e1.selectedIndex].value;

					var e2 = document.getElementById("city_select");
					var city = e2.options[e2.selectedIndex].value;

					var e3 = document.getElementById("province_select");
					var province = e3.options[e3.selectedIndex].value;		

					var e4 = document.getElementById("region_select");
					var region = e4.options[e4.selectedIndex].value;	

					var e5 = document.getElementById("religion_select");
					var religion = e5.options[e5.selectedIndex].value;*/

					var brgy = $("#brgy_text").val();
					var city =  $("#brgy_text").val();
					var province =  $("#province_text").val();
					var region =  $("#region_text").val();
					var religion =  $("#religion_text").val();

					var e6 = document.getElementById("branch");
					var branch2 = e6.options[e6.selectedIndex].value;	

					var e8 = document.getElementById("position");
					var position2 = e8.options[e8.selectedIndex].value;					


					$.ajax({
				      method: "POST",
				      url: '/LDUser/pre_register',
				      data:{

				      	first_name: $("#first_name").val(),
				      	last_name: $("#last_name").val(),
				      	middle_name: $("#middle_name").val(),
				      	email: $("#email").val(),
				      	cp_number: $("#cp_number").val(),
				      	position: position2,
				      	house_st: $("#house_st").val(),
				      	brgy : brgy,
				      	city : city,
				      	province : province,
				      	region: region,
				      	username: username,
				      	religion_id : religion,
				      	refferal_ID : refferal_ID ,
				      	branch : branch2

				  		},
				      success:function(response)
				      {
				       
				       console.log(response);
				       if(response == "OKOK")
				      	{
				      		window.location = get_url("/LDUser/pre_register/?refferal_ID="+refferal_ID+"&username="+username);
				      	}	

				      }
					});	

			}
		}	 

		

		$(document).ready(function() {
  			
  			$('input100').select2();


  			var refferalID = document.getElementById("refferal_ID").value;

  			if(refferalID == ""){

  				alert("Invalid Refferal!");
  				window.location = get_url("#");
  			}


		});
	</script>
</body>
</html>