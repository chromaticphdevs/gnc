

<?php include_once VIEWS.DS.'templates/users/header.php' ;?>


</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">
          
	
           <!--product_released-->

           <!--Product Loan-->
          <section class="x_panel">
            <section class="x_content">

            		<div id="product_released_chart_line_product_loan" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

          <!--Advance Payment-->
           <section class="x_panel">
            <section class="x_content">

            		<div id="product_released_chart_line_advance_payment" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

            <section class="x_panel">
            <section class="x_content">

            		<div id="product_released_chart_bar_by_day" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

          
           <section class="x_panel">
            <section class="x_content">

            		<div id="product_released_chart_bar" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>



          <section class="x_panel">
            <section class="x_content">

            		<div id="registration_chart_line" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

           
           <section class="x_panel">
            <section class="x_content">

            		<div id="registration_chart_bar_by_day" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

           <section class="x_panel">
            <section class="x_content">

            		<div id="registration_chart_bar" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

          <!--login logger-->
          <section class="x_panel">
            <section class="x_content">

            		<div id="login_chart_line" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

           <section class="x_panel">
            <section class="x_content">

            		<div id="login_chart_bar_by_day" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

           <section class="x_panel">
            <section class="x_content">

            		<div id="login_chart_bar" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>


           <!--activation-->
          <section class="x_panel">
            <section class="x_content">

            		<div id="activation_chart_line" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>
            <section class="x_panel">
            <section class="x_content">

            		<div id="activation_chart_bar_by_day" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>

          
           <section class="x_panel">
            <section class="x_content">

            		<div id="activation_chart_bar" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>




        </div>
        <!-- page content -->



	
<script>
window.onload = function () {


 	//registration -------------------------------------------------------------------------------------
	 $.ajax({
		      method: "POST",
		      url: '/Charts/data_registration_line_graph',
		      success:function(response)
		      {
		      	
		      	reponse = JSON.parse(response);
console.log(reponse);
		      	var chart = new CanvasJS.Chart("registration_chart_line", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Daily Registration Entries"
					},
					axisY: {
						title: "Number of Registration",
						includeZero: false
					},
					data: [{        
						type: "line",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [
			
							{ label: reponse.date29,y: parseInt(reponse.count29) },
							{ label: reponse.date28,y: parseInt(reponse.count28) },
							{ label: reponse.date27,y: parseInt( reponse.count27) },
							{ label: reponse.date26,y: parseInt(reponse.count26) },
							{ label: reponse.date25,y: parseInt(reponse.count25) },
							{ label: reponse.date24,y: parseInt(reponse.count24) },
							{ label: reponse.date23,y: parseInt(reponse.count23) },
							{ label: reponse.date22,y: parseInt(reponse.count22) },
							{ label: reponse.date21,y: parseInt(reponse.count21) },
							{ label: reponse.date20,y: parseInt(reponse.count20) },
							{ label: reponse.date19,y: parseInt(reponse.count19) },
							{ label: reponse.date18,y: parseInt(reponse.count18) },
							{ label: reponse.date17,y: parseInt(reponse.count17) },
							{ label: reponse.date16,y: parseInt(reponse.count16) },
							{ label: reponse.date15,y: parseInt(reponse.count15) },
							{ label: reponse.date14,y: parseInt(reponse.count14) },
							{ label: reponse.date13,y: parseInt(reponse.count13) },
							{ label: reponse.date12,y: parseInt(reponse.count12) },
							{ label: reponse.date11,y: parseInt(reponse.count11) },
							{ label: reponse.date10,y: parseInt(reponse.count10) },
							{ label: reponse.date9,y:  parseInt(reponse.count9) },
							{ label: reponse.date8,y:  parseInt(reponse.count8) },
							{ label: reponse.date7,y:  parseInt(reponse.count7) },
							{ label: reponse.date6,y:  parseInt(reponse.count6) },
							{ label: reponse.date5,y:  parseInt(reponse.count5) },
							{ label: reponse.date4,y:  parseInt(reponse.count4) },
							{ label: reponse.date3,y:  parseInt(reponse.count3) },
							{ label: reponse.date2,y:  parseInt(reponse.count2) },
							{ label: reponse.date1,y:  parseInt(reponse.count1) },
							{ label: reponse.date0,y:  parseInt(reponse.count0) }
						]
					}]
				});
				chart.render();
		      	
		      		
		      }
	});	


	 	 $.ajax({
		      method: "POST",
		      url: '/Charts/get_registration_count_by_week',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("registration_chart_bar_by_day", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Registration By Day"
					},
					axisY: {
						title: "Number of Logins",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.day0,y:  parseInt(reponse.count0) },
							{ label: reponse.day1,y:  parseInt(reponse.count1) },
							{ label: reponse.day2,y:  parseInt(reponse.count2) },
							{ label: reponse.day3,y:  parseInt(reponse.count3) },
							{ label: reponse.day4,y:  parseInt(reponse.count4) },
							{ label: reponse.day5,y:  parseInt(reponse.count5) },
							{ label: reponse.day6,y:  parseInt(reponse.count6) }
							
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	 });		 



	 	 $.ajax({
		      method: "POST",
		      url: '/Charts/data_registration_count_by_time_bar_graph',
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("registration_chart_bar", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Registration Entries By Time"
					},
					axisY: {
						title: "Number of Registration",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.time0,y:  parseInt(reponse.count0) },
							{ label: reponse.time1,y:  parseInt(reponse.count1) },
							{ label: reponse.time2,y:  parseInt(reponse.count2) },
							{ label: reponse.time3,y:  parseInt(reponse.count3) },
							{ label: reponse.time4,y:  parseInt(reponse.count4) },
							{ label: reponse.time5,y:  parseInt(reponse.count5) },
							{ label: reponse.time6,y:  parseInt(reponse.count6) },
							{ label: reponse.time7,y:  parseInt(reponse.count7) },
							{ label: reponse.time8,y:  parseInt(reponse.count8) },
							{ label: reponse.time9,y:  parseInt(reponse.count9) },
							{ label: reponse.time10,y: parseInt(reponse.count10) },
							{ label: reponse.time11,y: parseInt(reponse.count11) },
							{ label: reponse.time12,y: parseInt(reponse.count12) },
							{ label: reponse.time13,y: parseInt(reponse.count13) },
							{ label: reponse.time14,y: parseInt(reponse.count14) },
							{ label: reponse.time15,y: parseInt(reponse.count15) },
							{ label: reponse.time16,y: parseInt(reponse.count16) },
							{ label: reponse.time17,y: parseInt(reponse.count17) },
							{ label: reponse.time18,y: parseInt(reponse.count18) },
							{ label: reponse.time19,y: parseInt(reponse.count19) },
							{ label: reponse.time20,y: parseInt(reponse.count20) },
							{ label: reponse.time21,y: parseInt(reponse.count21) },
							{ label: reponse.time22,y: parseInt(reponse.count22) },
							{ label: reponse.time23,y: parseInt(reponse.count23) }
														
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	});	




 //login logger -------------------------------------------------------------------------------------

 	 	 $.ajax({
	      method: "POST",
	      url: '/Charts/login_graph_data',
	      success:function(response)
	      {

	      	reponse = JSON.parse(response);

	      	var chart = new CanvasJS.Chart("login_chart_line", {
				animationEnabled: true,
				theme: "light2",
				title:{
					text: "Daily Login"
				},
				axisY: {
					title: "Number of Logins",
					includeZero: false
				},
				data: [{        
					type: "line",
			      	indexLabelFontSize: 22,
			      	color: "#009933",
					dataPoints: [
		
						{ label: reponse.date29,y: parseInt(reponse.count29) },
						{ label: reponse.date28,y: parseInt(reponse.count28) },
						{ label: reponse.date27,y: parseInt( reponse.count27) },
						{ label: reponse.date26,y: parseInt(reponse.count26) },
						{ label: reponse.date25,y: parseInt(reponse.count25) },
						{ label: reponse.date24,y: parseInt(reponse.count24) },
						{ label: reponse.date23,y: parseInt(reponse.count23) },
						{ label: reponse.date22,y: parseInt(reponse.count22) },
						{ label: reponse.date21,y: parseInt(reponse.count21) },
						{ label: reponse.date20,y: parseInt(reponse.count20) },
						{ label: reponse.date19,y: parseInt(reponse.count19) },
						{ label: reponse.date18,y: parseInt(reponse.count18) },
						{ label: reponse.date17,y: parseInt(reponse.count17) },
						{ label: reponse.date16,y: parseInt(reponse.count16) },
						{ label: reponse.date15,y: parseInt(reponse.count15) },
						{ label: reponse.date14,y: parseInt(reponse.count14) },
						{ label: reponse.date13,y: parseInt(reponse.count13) },
						{ label: reponse.date12,y: parseInt(reponse.count12) },
						{ label: reponse.date11,y: parseInt(reponse.count11) },
						{ label: reponse.date10,y: parseInt(reponse.count10) },
						{ label: reponse.date9,y:  parseInt(reponse.count9) },
						{ label: reponse.date8,y:  parseInt(reponse.count8) },
						{ label: reponse.date7,y:  parseInt(reponse.count7) },
						{ label: reponse.date6,y:  parseInt(reponse.count6) },
						{ label: reponse.date5,y:  parseInt(reponse.count5) },
						{ label: reponse.date4,y:  parseInt(reponse.count4) },
						{ label: reponse.date3,y:  parseInt(reponse.count3) },
						{ label: reponse.date2,y:  parseInt(reponse.count2) },
						{ label: reponse.date1,y:  parseInt(reponse.count1) },
						{ label: reponse.date0,y:  parseInt(reponse.count0) }
					]
				}]
			});
			chart.render();
	      	
	      		
		      }
	});	

 	 $.ajax({
		      method: "POST",
		      url: '/Charts/data_login_count_by_week',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("login_chart_bar_by_day", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Login By Day"
					},
					axisY: {
						title: "Number of Logins",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.day0,y:  parseInt(reponse.count0) },
							{ label: reponse.day1,y:  parseInt(reponse.count1) },
							{ label: reponse.day2,y:  parseInt(reponse.count2) },
							{ label: reponse.day3,y:  parseInt(reponse.count3) },
							{ label: reponse.day4,y:  parseInt(reponse.count4) },
							{ label: reponse.day5,y:  parseInt(reponse.count5) },
							{ label: reponse.day6,y:  parseInt(reponse.count6) }
							
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	 });		 

	 $.ajax({
		      method: "POST",
		      url: '/Charts/data_login_count_by_time_bar_graph',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("login_chart_bar", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Login By Time"
					},
					axisY: {
						title: "Number of Logins",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.time0,y:  parseInt(reponse.count0) },
							{ label: reponse.time1,y:  parseInt(reponse.count1) },
							{ label: reponse.time2,y:  parseInt(reponse.count2) },
							{ label: reponse.time3,y:  parseInt(reponse.count3) },
							{ label: reponse.time4,y:  parseInt(reponse.count4) },
							{ label: reponse.time5,y:  parseInt(reponse.count5) },
							{ label: reponse.time6,y:  parseInt(reponse.count6) },
							{ label: reponse.time7,y:  parseInt(reponse.count7) },
							{ label: reponse.time8,y:  parseInt(reponse.count8) },
							{ label: reponse.time9,y:  parseInt(reponse.count9) },
							{ label: reponse.time10,y: parseInt(reponse.count10) },
							{ label: reponse.time11,y: parseInt(reponse.count11) },
							{ label: reponse.time12,y: parseInt(reponse.count12) },
							{ label: reponse.time13,y: parseInt(reponse.count13) },
							{ label: reponse.time14,y: parseInt(reponse.count14) },
							{ label: reponse.time15,y: parseInt(reponse.count15) },
							{ label: reponse.time16,y: parseInt(reponse.count16) },
							{ label: reponse.time17,y: parseInt(reponse.count17) },
							{ label: reponse.time18,y: parseInt(reponse.count18) },
							{ label: reponse.time19,y: parseInt(reponse.count19) },
							{ label: reponse.time20,y: parseInt(reponse.count20) },
							{ label: reponse.time21,y: parseInt(reponse.count21) },
							{ label: reponse.time22,y: parseInt(reponse.count22) },
							{ label: reponse.time23,y: parseInt(reponse.count23) }
														
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	});	




//activation -------------------------------------------------------------------------------------

	  $.ajax({
	      method: "POST",
	      url: '/Charts/activation_graph_data',
	      success:function(response)
	      {

	      	reponse = JSON.parse(response);

	      	var chart = new CanvasJS.Chart("activation_chart_line", {
				animationEnabled: true,
				theme: "light2",
				title:{
					text: "Daily Activation"
				},
				axisY: {
					title: "Number of Activation",
					includeZero: false
				},
				data: [{        
					type: "line",
			      	indexLabelFontSize: 22,
			      	color: "#009933",
					dataPoints: [
		
						{ label: reponse.date29,y: parseInt(reponse.count29) },
						{ label: reponse.date28,y: parseInt(reponse.count28) },
						{ label: reponse.date27,y: parseInt( reponse.count27) },
						{ label: reponse.date26,y: parseInt(reponse.count26) },
						{ label: reponse.date25,y: parseInt(reponse.count25) },
						{ label: reponse.date24,y: parseInt(reponse.count24) },
						{ label: reponse.date23,y: parseInt(reponse.count23) },
						{ label: reponse.date22,y: parseInt(reponse.count22) },
						{ label: reponse.date21,y: parseInt(reponse.count21) },
						{ label: reponse.date20,y: parseInt(reponse.count20) },
						{ label: reponse.date19,y: parseInt(reponse.count19) },
						{ label: reponse.date18,y: parseInt(reponse.count18) },
						{ label: reponse.date17,y: parseInt(reponse.count17) },
						{ label: reponse.date16,y: parseInt(reponse.count16) },
						{ label: reponse.date15,y: parseInt(reponse.count15) },
						{ label: reponse.date14,y: parseInt(reponse.count14) },
						{ label: reponse.date13,y: parseInt(reponse.count13) },
						{ label: reponse.date12,y: parseInt(reponse.count12) },
						{ label: reponse.date11,y: parseInt(reponse.count11) },
						{ label: reponse.date10,y: parseInt(reponse.count10) },
						{ label: reponse.date9,y:  parseInt(reponse.count9) },
						{ label: reponse.date8,y:  parseInt(reponse.count8) },
						{ label: reponse.date7,y:  parseInt(reponse.count7) },
						{ label: reponse.date6,y:  parseInt(reponse.count6) },
						{ label: reponse.date5,y:  parseInt(reponse.count5) },
						{ label: reponse.date4,y:  parseInt(reponse.count4) },
						{ label: reponse.date3,y:  parseInt(reponse.count3) },
						{ label: reponse.date2,y:  parseInt(reponse.count2) },
						{ label: reponse.date1,y:  parseInt(reponse.count1) },
						{ label: reponse.date0,y:  parseInt(reponse.count0) }
					]
				}]
			});
			chart.render();
	      	
	      		
		      }
	});	

	  $.ajax({
		      method: "POST",
		      url: '/Charts/get_activation_count_by_week',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("activation_chart_bar_by_day", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Activation By Day"
					},
					axisY: {
						title: "Number of Logins",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.day0,y:  parseInt(reponse.count0) },
							{ label: reponse.day1,y:  parseInt(reponse.count1) },
							{ label: reponse.day2,y:  parseInt(reponse.count2) },
							{ label: reponse.day3,y:  parseInt(reponse.count3) },
							{ label: reponse.day4,y:  parseInt(reponse.count4) },
							{ label: reponse.day5,y:  parseInt(reponse.count5) },
							{ label: reponse.day6,y:  parseInt(reponse.count6) }
							
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	 });		 


	 $.ajax({
		      method: "POST",
		      url: '/Charts/data_activation_count_by_time_bar_graph',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("activation_chart_bar", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Activation By Time"
					},
					axisY: {
						title: "Number of Activation",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.time0,y:  parseInt(reponse.count0) },
							{ label: reponse.time1,y:  parseInt(reponse.count1) },
							{ label: reponse.time2,y:  parseInt(reponse.count2) },
							{ label: reponse.time3,y:  parseInt(reponse.count3) },
							{ label: reponse.time4,y:  parseInt(reponse.count4) },
							{ label: reponse.time5,y:  parseInt(reponse.count5) },
							{ label: reponse.time6,y:  parseInt(reponse.count6) },
							{ label: reponse.time7,y:  parseInt(reponse.count7) },
							{ label: reponse.time8,y:  parseInt(reponse.count8) },
							{ label: reponse.time9,y:  parseInt(reponse.count9) },
							{ label: reponse.time10,y: parseInt(reponse.count10) },
							{ label: reponse.time11,y: parseInt(reponse.count11) },
							{ label: reponse.time12,y: parseInt(reponse.count12) },
							{ label: reponse.time13,y: parseInt(reponse.count13) },
							{ label: reponse.time14,y: parseInt(reponse.count14) },
							{ label: reponse.time15,y: parseInt(reponse.count15) },
							{ label: reponse.time16,y: parseInt(reponse.count16) },
							{ label: reponse.time17,y: parseInt(reponse.count17) },
							{ label: reponse.time18,y: parseInt(reponse.count18) },
							{ label: reponse.time19,y: parseInt(reponse.count19) },
							{ label: reponse.time20,y: parseInt(reponse.count20) },
							{ label: reponse.time21,y: parseInt(reponse.count21) },
							{ label: reponse.time22,y: parseInt(reponse.count22) },
							{ label: reponse.time23,y: parseInt(reponse.count23) }
														
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	});	




//released product -------------------------------------------------------------------------------------

	  $.ajax({
	      method: "POST",
	      url: '/Charts/product_released_graph_data',
	      data:{ category: "product-loan"},
	      success:function(response)
	      {

	      	reponse = JSON.parse(response);

	      	var chart = new CanvasJS.Chart("product_released_chart_line_product_loan", {
				animationEnabled: true,
				theme: "light2",
				title:{
					text: "Daily Product Released ( Product Loan )"
				},
				axisY: {
					title: "Number of Product Released",
					includeZero: false
				},
				data: [{        
					type: "line",
			      	indexLabelFontSize: 22,
			      	color: "#009933",
					dataPoints: [
		
						{ label: reponse.date29,y: parseInt(reponse.count29) },
						{ label: reponse.date28,y: parseInt(reponse.count28) },
						{ label: reponse.date27,y: parseInt( reponse.count27) },
						{ label: reponse.date26,y: parseInt(reponse.count26) },
						{ label: reponse.date25,y: parseInt(reponse.count25) },
						{ label: reponse.date24,y: parseInt(reponse.count24) },
						{ label: reponse.date23,y: parseInt(reponse.count23) },
						{ label: reponse.date22,y: parseInt(reponse.count22) },
						{ label: reponse.date21,y: parseInt(reponse.count21) },
						{ label: reponse.date20,y: parseInt(reponse.count20) },
						{ label: reponse.date19,y: parseInt(reponse.count19) },
						{ label: reponse.date18,y: parseInt(reponse.count18) },
						{ label: reponse.date17,y: parseInt(reponse.count17) },
						{ label: reponse.date16,y: parseInt(reponse.count16) },
						{ label: reponse.date15,y: parseInt(reponse.count15) },
						{ label: reponse.date14,y: parseInt(reponse.count14) },
						{ label: reponse.date13,y: parseInt(reponse.count13) },
						{ label: reponse.date12,y: parseInt(reponse.count12) },
						{ label: reponse.date11,y: parseInt(reponse.count11) },
						{ label: reponse.date10,y: parseInt(reponse.count10) },
						{ label: reponse.date9,y:  parseInt(reponse.count9) },
						{ label: reponse.date8,y:  parseInt(reponse.count8) },
						{ label: reponse.date7,y:  parseInt(reponse.count7) },
						{ label: reponse.date6,y:  parseInt(reponse.count6) },
						{ label: reponse.date5,y:  parseInt(reponse.count5) },
						{ label: reponse.date4,y:  parseInt(reponse.count4) },
						{ label: reponse.date3,y:  parseInt(reponse.count3) },
						{ label: reponse.date2,y:  parseInt(reponse.count2) },
						{ label: reponse.date1,y:  parseInt(reponse.count1) },
						{ label: reponse.date0,y:  parseInt(reponse.count0) }
					]
				}]
			});
			chart.render();
	      	
	      		
		      }
	});	

	    $.ajax({
	      method: "POST",
	      url: '/Charts/product_released_graph_data',
	      data:{ category: "advance-payment"},
	      success:function(response)
	      {

	      	reponse = JSON.parse(response);

	      	var chart = new CanvasJS.Chart("product_released_chart_line_advance_payment", {
				animationEnabled: true,
				theme: "light2",
				title:{
					text: "Daily Product Released ( Advance Payment )"
				},
				axisY: {
					title: "Number of Product Released",
					includeZero: false
				},
				data: [{        
					type: "line",
			      	indexLabelFontSize: 22,
			      	color: "#009933",
					dataPoints: [
		
						{ label: reponse.date29,y: parseInt(reponse.count29) },
						{ label: reponse.date28,y: parseInt(reponse.count28) },
						{ label: reponse.date27,y: parseInt( reponse.count27) },
						{ label: reponse.date26,y: parseInt(reponse.count26) },
						{ label: reponse.date25,y: parseInt(reponse.count25) },
						{ label: reponse.date24,y: parseInt(reponse.count24) },
						{ label: reponse.date23,y: parseInt(reponse.count23) },
						{ label: reponse.date22,y: parseInt(reponse.count22) },
						{ label: reponse.date21,y: parseInt(reponse.count21) },
						{ label: reponse.date20,y: parseInt(reponse.count20) },
						{ label: reponse.date19,y: parseInt(reponse.count19) },
						{ label: reponse.date18,y: parseInt(reponse.count18) },
						{ label: reponse.date17,y: parseInt(reponse.count17) },
						{ label: reponse.date16,y: parseInt(reponse.count16) },
						{ label: reponse.date15,y: parseInt(reponse.count15) },
						{ label: reponse.date14,y: parseInt(reponse.count14) },
						{ label: reponse.date13,y: parseInt(reponse.count13) },
						{ label: reponse.date12,y: parseInt(reponse.count12) },
						{ label: reponse.date11,y: parseInt(reponse.count11) },
						{ label: reponse.date10,y: parseInt(reponse.count10) },
						{ label: reponse.date9,y:  parseInt(reponse.count9) },
						{ label: reponse.date8,y:  parseInt(reponse.count8) },
						{ label: reponse.date7,y:  parseInt(reponse.count7) },
						{ label: reponse.date6,y:  parseInt(reponse.count6) },
						{ label: reponse.date5,y:  parseInt(reponse.count5) },
						{ label: reponse.date4,y:  parseInt(reponse.count4) },
						{ label: reponse.date3,y:  parseInt(reponse.count3) },
						{ label: reponse.date2,y:  parseInt(reponse.count2) },
						{ label: reponse.date1,y:  parseInt(reponse.count1) },
						{ label: reponse.date0,y:  parseInt(reponse.count0) }
					]
				}]
			});
			chart.render();
	      	
	      		
		      }
	});	

	  $.ajax({
		      method: "POST",
		      url: '/Charts/get_product_released_count_by_week',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("product_released_chart_bar_by_day", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Product Released By Day"
					},
					axisY: {
						title: "Number of Product Released",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.day0,y:  parseInt(reponse.count0) },
							{ label: reponse.day1,y:  parseInt(reponse.count1) },
							{ label: reponse.day2,y:  parseInt(reponse.count2) },
							{ label: reponse.day3,y:  parseInt(reponse.count3) },
							{ label: reponse.day4,y:  parseInt(reponse.count4) },
							{ label: reponse.day5,y:  parseInt(reponse.count5) },
							{ label: reponse.day6,y:  parseInt(reponse.count6) }
							
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	 });		 


	 $.ajax({
		      method: "POST",
		      url: '/Charts/data_product_released_count_by_time_bar_graph',   
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("product_released_chart_bar", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Product Released By Time"
					},
					axisY: {
						title: "Number of Product Released",
						includeZero: false
					},
					data: [{        
						type: "column",
				      	indexLabelFontSize: 22,
				      	color: "#009933",
						dataPoints: [

							{ label: reponse.time0,y:  parseInt(reponse.count0) },
							{ label: reponse.time1,y:  parseInt(reponse.count1) },
							{ label: reponse.time2,y:  parseInt(reponse.count2) },
							{ label: reponse.time3,y:  parseInt(reponse.count3) },
							{ label: reponse.time4,y:  parseInt(reponse.count4) },
							{ label: reponse.time5,y:  parseInt(reponse.count5) },
							{ label: reponse.time6,y:  parseInt(reponse.count6) },
							{ label: reponse.time7,y:  parseInt(reponse.count7) },
							{ label: reponse.time8,y:  parseInt(reponse.count8) },
							{ label: reponse.time9,y:  parseInt(reponse.count9) },
							{ label: reponse.time10,y: parseInt(reponse.count10) },
							{ label: reponse.time11,y: parseInt(reponse.count11) },
							{ label: reponse.time12,y: parseInt(reponse.count12) },
							{ label: reponse.time13,y: parseInt(reponse.count13) },
							{ label: reponse.time14,y: parseInt(reponse.count14) },
							{ label: reponse.time15,y: parseInt(reponse.count15) },
							{ label: reponse.time16,y: parseInt(reponse.count16) },
							{ label: reponse.time17,y: parseInt(reponse.count17) },
							{ label: reponse.time18,y: parseInt(reponse.count18) },
							{ label: reponse.time19,y: parseInt(reponse.count19) },
							{ label: reponse.time20,y: parseInt(reponse.count20) },
							{ label: reponse.time21,y: parseInt(reponse.count21) },
							{ label: reponse.time22,y: parseInt(reponse.count22) },
							{ label: reponse.time23,y: parseInt(reponse.count23) }
														
						]
					}]
				});
				chart.render();
		      	
		        return false;			
		      }
	});	

}
</script>     
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>