

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
          
          <section class="x_panel">
            <section class="x_content">

            		<div id="chart_line" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>
           <section class="x_panel">
            <section class="x_content">

            		<div id="chart_bar" style="height: 370px; width: 100%;"></div>
        
            </section>
          </section>
        </div>
        <!-- page content -->



	
<script>
window.onload = function () {

	 $.ajax({
		      method: "POST",
		      url: '/Charts/cash_collection_graph_data',
		      data:{data: $("#refer_name").val()},
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("chart_line", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Daily Cash Collection"
					},
					axisY: {
						title: "Amount",
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
		      url: '/Charts/cash_collection_by_time_bar_graph',
		      data:{data: $("#refer_name").val()},
		      success:function(response)
		      {

		      	reponse = JSON.parse(response);

		      	var chart = new CanvasJS.Chart("chart_bar", {
					animationEnabled: true,
					theme: "light2",
					title:{
						text: "Cash Collection By Time"
					},
					axisY: {
						title: "Amount",
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