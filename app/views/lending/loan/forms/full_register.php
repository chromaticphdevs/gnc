<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Members Information Form</title>
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
	
    <!-- Icons font CSS-->
    <link href="<?php echo URL.DS.'vendors/form/mdi-font/css/material-design-iconic-font.min.css'?>" rel="stylesheet" media="all">
    <link href="<?php echo URL.DS.'vendors/form/font-awesome-4.7/css/font-awesome.min.css'?>" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style type="text/css">
    	p {
  			font-family: "Times New Roman", Times, serif;
  			font-size: 16px;

			}
    </style>
    <!-- Vendor CSS-->

    <!-- Main CSS-->

    <link href="<?php echo URL.DS.'css/form/main2.css'?>" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-img-1 container-login100 p-t-275 p-b-100">
        <div class="wrapper wrapper--w690">
            <div class="card card-1">
                <div class="card-heading">
                    <h2 class="title">Information Form</h2>
                </div>
                <div class="card-body">
                    <form class="wizard-container" method="POST" action="#" id="js-wizard-form">
                        <div class="progress" id="js-progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                <span class="progress-val">0%</span>
                            </div>
                        </div>
                        <ul class="nav nav-tab">
                        	<input type="hidden" id="total_tab" value="4">
                            <li class="active">
                                <a href="#tab1" data-toggle="tab">1</a>
                            </li>
                            <li>
                                <a href="#tab5" data-toggle="tab">1</a>
                            </li>
                            <li>
                                <a href="#tab3" data-toggle="tab">1</a>
                            </li>
                             <li>
                                <a href="#tab4" data-toggle="tab">1</a>
                            </li>
                        </ul>
                        <div class="tab-content">
<!-------------------------------------------------------------TAB 1------------------------------------------------------------------------->
                            <div class="tab-pane active" id="tab1">
                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="first_name" placeholder="First Name">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="middle_name" placeholder="Middle Name">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >

                               		
									<input class="input100" type="text" name="last_name" placeholder="Last Name">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br><br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
                               		<sup><p>Birthdate:</p></sup>
									<input class="input100" type="date" name="b_day" placeholder="Birthday">
									<span class="focus-input100"></span>
									
								</div>
								<br>
					
                               	<div class="wrap-input100 validate-input m-b-16" >
                            
									<input class="input100" type="number" name="age" placeholder="Age">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div><br>
									<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="number" name="cp_number" placeholder="Cell Phone Number">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								
								<br>
								<div class="wrap-input100 validate-input m-b-16" >
									
	                            	<select  class="input100" id="gender" name="gender" >	                            	
	                            		<option  disabled selected>Gender</option>
	                            		<option value="male">Male</option>
	                            		<option value="female">Female</option>
	                            	</select>
									
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>

								<div class="wrap-input100 validate-input m-b-16" >
									
	                            	<select  class="input100" id="civil_stat" name="civil_stat" >	                            	
	                            		
	                            		<option  disabled selected>Civil Status</option>
	                            		<option value="Single">Single</option>
	                            		<option value="Married">Married</option>
	                            		<option value="Divorced">Divorced</option>
	                            		<option value="Separated">Separated</option>
	                            		<option value="Widowed">Widowed</option>
	                           
	                            	</select>
									
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>

                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="religion" placeholder="Religion">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                          

                                <div class="btn-next-con">
                                    <a class="btn-next" href="#">Next</a>
                                </div>
                            </div>
<!-------------------------------------------------------------END TAB 1------------------------------------------------------------------------->

<!-------------------------------------------------------------TAB 2-------------------------------------------------------------------------> 
                           	 <div class="tab-pane" id="tab2">
                             	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="address" placeholder="Complete Address">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="number" name="years_staying" placeholder="No. of Years Staying-In">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                              	 <div class="wrap-input100 validate-input m-b-16" >
	                            	<select  class="input100" id="residency_stat" name="residency_stat" >	                            	
	                            		<option  disabled selected>Status of Residency</option>
	                            		<option value="owned">Owned</option>
	                            		<option value="rented">Rented</option>
	                            		<option value="living with parents or relative">Living with Parents or Relative</option>
	                            	</select>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								 </div>
								<br>

							
                             	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="other_address" placeholder="Other Address">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                             	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="provincial_address" placeholder="Provincial Address">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>		
                     
                                <div class="btn-next-con">
                                    <a class="btn-back" href="#">back</a>
                                    <a class="btn-next" href="#">Next</a>
                                </div>
                            </div>
<!-------------------------------------------------------------END TAB 2------------------------------------------------------------------------->                            
<!-------------------------------------------------------------TAB 3-------------------------------------------------------------------------> 
                            <div class="tab-pane" id="tab3">
                            
                             	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="educational_attain" placeholder="Highest Educational Attainment">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	 <div class="wrap-input100 validate-input m-b-16" >
	                            	<select  class="input100" id="income_source" name="income_source" >	                            	
	                            		<option  disabled selected>Source of Income</option>
	                            		<option value="employed">Employed</option>
	                            		<option value="self-employed">Self-Employed</option>
	                            		<option value="with business">With Business</option>
	                            	</select>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								 </div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="number" name="years_employed" placeholder="Years Employed/Operational">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="company_name" placeholder="Name of Company/Business">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="position" placeholder="Position">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="number" name="monthly_salary" placeholder="Net Monthly Salary/Income">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="other_income_source" placeholder="Other Source of Income">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>
					
								<br>
                                <div class="btn-next-con">
                                    <a class="btn-back" href="#">back</a>
                                    <a class="btn-next" href="#">Next</a>
                                </div>
                            </div>
<!-------------------------------------------------------------END TAB 3------------------------------------------------------------------------->                            
<!-------------------------------------------------------------TAB 4-------------------------------------------------------------------------------> 
                            <div class="tab-pane" id="tab4">
                            	<strong>Spouse Information</strong><br><br>
                             	 	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_first_name" placeholder="First Name">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_middle_name" placeholder="Middle Name">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >

                               		
									<input class="input100" type="text" name="s_ast_name" placeholder="Last Name">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br><br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
                               		<sup><p>Birthdate:</p></sup>
									<input class="input100" type="date" name="s_b_day" placeholder="Birthday">
									<span class="focus-input100"></span>
									
								</div>
								<br>
					
                               	<div class="wrap-input100 validate-input m-b-16" >
                            
									<input class="input100" type="number" name="s_age" placeholder="Age">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div><br>
									
								<div class="wrap-input100 validate-input m-b-16" >
									
	                            	<select  class="input100" id="s_gender" name="s_gender" >	                            	
	                            		<option  disabled selected>Gender</option>
	                            		<option value="male">Male</option>
	                            		<option value="female">Female</option>
	                            	</select>
									
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								 

                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_religion" placeholder="Religion">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_educational_attain" placeholder="Highest Educational Attainment">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>
								
                               	 <div class="wrap-input100 validate-input m-b-16" >
	                            	<select  class="input100" id="s_income_source" name="s_income_source" >	                            	
	                            		<option  disabled selected>Source of Income</option>
	                            		<option value="employed">Employed</option>
	                            		<option value="self-employed">Self-Employed</option>
	                            		<option value="with business">With Business</option>
	                            	</select>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								 </div>
								<br>
								
                               	<div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="number" name="s_years_employed" placeholder="Years Employed/Operational">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div>
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_company_name" placeholder="Name of Company/Business">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_position" placeholder="Position">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="number" name="s_monthly_salary" placeholder="Net Monthly Salary/Income">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>

                               <div class="wrap-input100 validate-input m-b-16" >
									<input class="input100" type="text" name="s_other_income_source" placeholder="Other Source of Income">
									<span class="focus-input100"></span> 
									<span class="symbol-input100">
										<span class="lnr lnr-layers"></span>
									</span>
								</div> 
								<br>
								
                    	      
					 		    <div class="btn-next-con">
                                    <a class="btn-back" href="#">back</a>

                                    <a class="btn-last" href="#">Submit</a>
                                </div>
                            </div>
<!-------------------------------------------------------------END TAB 4------------------------------------------------------------------------->                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

 
	


	 <script src="<?php echo URL.DS.'vendors/form/jquery/jquery.min.js'?>"></script>
    <!-- Vendor JS-->
    <script src="<?php echo URL.DS.'vendors/form/jquery-validate/jquery.validate.min.js'?>"></script>
    <script src="<?php echo URL.DS.'vendors/form/bootstrap-wizard/bootstrap.min.js'?>"></script>
    <script src="<?php echo URL.DS.'vendors/form/bootstrap-wizard/jquery.bootstrap.wizard.min.js'?>"></script>
     <script src="<?php echo URL.DS.'js/form/global.js'?>"></script>

</body>

</html>
<!-- end document-->