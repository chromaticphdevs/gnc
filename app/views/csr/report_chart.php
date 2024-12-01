<?php build('content') ?>
    <h4><?php echo isset($level) ? "Follow Up Levels : {$level}"  : 'Archives' ?> </h4>
    <div class="row">
        <div class="col-md-12">
            <h3>CSR LIST</h3>
            <br>
            <a class="btn btn-success" href="/CSR_Reports">&nbsp;List All&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-success" href="/CSR_Reports/get_todays_report">&nbsp;List Today&nbsp;</a>
            <br><br>  
            <div class="table-responsive">

                <table class="table" id="dataTable">
                    <thead>
                      <th>#</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Total Called</th>
                      <th>Total Duration</th>
                      <th>Total Allowance</th>
                      <th>CSR Wallet</th>
                    </thead>

                    <tbody>
                        <?php $counter = 1?>
                        <?php foreach($get_call_history as $key => $row) :?>
                            <tr>
                                <td><?php echo $counter++?></td>
                                <td><a href="/CSR_Reports/?user_id=<?php echo seal($row->user_id); ?>&account_type=<?php echo $row->account_type; ?>">
                                  <?php
                                        if($row->account_type == "manager")
                                        {
                                          echo $row->csr_manager;

                                        }else if($row->account_type = "user")
                                        {
                                          echo $row->csr_user;
                                        }
                                  ?></a>
                                </td>
                                <td><?php echo $row->account_type?></td>
                                <td><?php echo $row->total_call_today?></td>
                                <td><?php echo $row->total_duration?></td>
                                <td>&#8369; <?php echo $row->allowance?></td>   
                                <td>&#8369; <?php echo $row->wallet?></td>                                         
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table><br>


                <?php if(isset($_GET['user_id']) and isset($_GET['account_type'])): ?>
                  <table class="table" id="dataTable">
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
                </table><br>
              <?php endif; ?>

            </div>
        </div>

        <!--hide user id for chart report data-->
      <input type="hidden" id="user_id" value="<?php echo seal($condition);?>">

         <section class="x_panel">
          <section class="x_content">

              <div id="product_released_chart_line" style="height: 370px; width: 100%;"></div>
      
          </section>
        </section>

    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
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
            text: "Daily CSR Calls"
          },
          axisY: {
            title: "Number of CSR Calls",
            includeZero: false
          },
          data: [{        
            type: "line",
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

<?php build('headers')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<?php endbuild()?>
<?php occupy('templates/layout')?>