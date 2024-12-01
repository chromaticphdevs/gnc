<?php build('content')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>

<style>
    .module-container{
    }.module-container .module
    {
        border: 1px solid #000;
        width: 300px;
        padding: 10px; }

table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;

  border: 1px solid #ddd;}

    th, td {
      text-align: left;
      padding: 8px;}
    tr:nth-child(even){background-color: #f2f2f2}
</style>
            <div style="overflow-x:auto;">

                <table class="table" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Profiling</th>
                        <th>Durationr</th>
                        <th>Amount</th>
                        <th>Date & Time</th>

                    </thead>

                     <tbody>
                       <?php $counter=1; ?>
                        <?php $total=0; ?>
                      <?php foreach($list as $key => $data) :?>
                      
                        <tr>
                            <td><?php echo $counter++ ?></td>
                            <td><?php echo $data->customer_name?></td>
                            <td><?php echo $data->profile?></td>
                            <td><?php echo $data->duration; ?></td>
                            <td><?php echo $data->amount; ?></td>
                            <td><?php echo $data->created_at; ?></td>
                            <?php $total += $data->amount; ?>
                           
                        </tr>
                      <?php endforeach?>
                    </tbody>
                </table><br>
            </div>

            <h2>Total: P<?php echo $total; ?></h2><br><br>

            <table class="table">
                <thead>
                 
                  <th>1 minute below</th>
                  <th>2 minute below</th>
                  <th>3 minute below</th>
                  <th>4 minute below</th>
                  <th>5 minute below</th>

                </thead>

                <tbody>
                  
                      <tr>           
                          <td><b><?php echo $sorted_call_duration['search1'] ?></b></td>
                          <td><b><?php echo $sorted_call_duration['search2'] ?></b></td>
                          <td><b><?php echo $sorted_call_duration['search3'] ?></b></td>  
                          <td><b><?php echo $sorted_call_duration['search4'] ?></b></td>    
                          <td><b><?php echo $sorted_call_duration['search5'] ?></b></td>                          
                      </tr>
          
                </tbody>
            </table>


            <!--hide user id for chart report data-->
            <input type="hidden" id="user_id" value="<?php echo $user_id;?>">

            <br>
            <section class="x_panel">
              <section class="x_content">

                  <div id="product_released_chart_line" style="height: 370px; width: 100%;"></div>
          
              </section>
            </section>  
    
 <!-- page content -->
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
          "pageLength": 10
        } );


    } );
</script>

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
<?php endbuild()?>
<?php occupy('templates/layout')?>
