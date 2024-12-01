<?php build('content')?>
	<h3>Dashboard</h3>
	<p>Work Summary</p>
	<hr>
	<div class="box-content">


	  <section class="x_panel">
          <section class="x_content">

              <div id="product_released_chart_line" style="height: 370px; width: 100%;"></div>
      
          </section>
        </section>	


		<?php if(empty($check_access_gsm)): ?>
			<h4>Select Device to Call</h4>
			<form method="post" action="/CallCenter/select_device">

				<select name="device_selected" class="form-control">
					<?php foreach ($gsm_device as $key => $value): ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
					<?php endforeach; ?>
				</select>
				<br>
				<input type="submit" class="btn btn-primary btn-sm" value="Select">
			</form>
			<br><br>
	    <?php endif; ?>

		<h4>Followed Up Customers</h4>
		<table class="table">
			<thead>
				<th>Category</th>
				<th>Total</th>
			</thead>

			<tbody>
				<tr>
					<td>Today</td>
					<td><b><h2><?php echo $followUpSummary['daily']?></h2></b></td>
				</tr>

				<tr>
					<td>This week</td>
					<td><b><h2><?php echo $followUpSummary['weekly']?></h2></b></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="box-content">
		<h4>New Customers Followed Up</h4>

		<table class="table">
			<thead>
				<th>Category</th>
				<th>Total</th>
			</thead>

			<tbody>
				<tr>
					<td>Today</td>
					<td><b><h2><?php echo $NewUserFollowUp['daily']?></h2></b></td>
				</tr>

				<tr>
					<td>This week</td>
					<td><b><h2><?php echo $NewUserFollowUp['weekly']?></h2></b></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="box-content">
		<h4>Test of characters</h4>

		<table class="table">
			<thead>
				<th>Category</th>
				<th>Total</th>
			</thead>

			<tbody>
				<tr>
					<td>Today</td>
					<td><b><h2><?php echo $tocSummary['daily']?></td></h2></b>
				</tr>

				<tr>
					<td>This week</td>
					<td><b><h2><?php echo $tocSummary['weekly']?></td></h2></b>
				</tr>
			</tbody>
		</table>
	</div>

	   <!--hide user id for chart report data-->
      <input type="hidden" id="user_id" value="<?php echo $user_id;?>">

<?php endbuild()?>

<script>
window.onload = function () {

    var user_id =  $("#user_id" ).val();
 
    $.ajax({
        method: "POST",
        url: '/CSR_Reports/get_chart',
        data: {user_id:user_id},
        success:function(response)
        {

          reponse = JSON.parse(response);

          var chart = new CanvasJS.Chart("product_released_chart_line", {
          animationEnabled: true,
          theme: "light2",
          title:{
            text: "Daily Calls"
          },
          axisY: {
            title: "Number of Calls",
            includeZero: false
          },
          data: [{        
            type: "column",
                indexLabelFontSize: 22,
                color: "#009933",
            dataPoints: [
      
              { label: reponse.date29,y: parseInt(reponse.count29) },
              { label: reponse.date28,y: parseInt(reponse.count28) },
              { label: reponse.date27,y: parseInt(reponse.count27) },
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


}

$( "#target" ).click(function() {
  alert( "Handler for .click() called." );
});


</script>  
<?php occupy('templates/layout')?>