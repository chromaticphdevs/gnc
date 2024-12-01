<?php build('content') ?>
    <div class="container-fluid">
      <?php echo wControlButtonLeft('', [
        $navigationHelper->setNav('', 'List', '/CSR_Reports')
      ])?>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <?php echo wCardHeader(wCardTitle('CSR List'))?>
              <div class="card-body">
                <h2>
                  <b>
                    <?php
                        $date=date_create($date_search );
                          echo date_format($date,"M d, Y");
                    ?>
                  </b>
                </h2>
                <?php
                  Form::open([
                        'method' => 'post',
                        'action' => '/CSR_Reports/get_todays_report'
                  ]);
                ?> 
                <input type="date"  name="picked_date" required>
                  <?php
                      Form::submit('search' , 'Search' , [
                          'class' => 'btn btn-primary btn-sm'
                      ]);
                  ?>
                <?php Form::close()?>
                <div class="table-responsive">
                  <table class="table table-responsive" id="dataTable">
                      <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Total Called</th>
                        <th>Total Duration</th>
                        <th>Total Allowance</th>
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
                              </tr>
                          <?php endforeach?>
                      </tbody>
                  </table>
                </div>

                <div class="tale-responsive">
                  <table class="table table-responsive" id="dataTable">
                    <thead>
                      <th>#</th>
                      <th>name</th>
                      <th>1 minute below</th>
                      <th>2 minute below</th>
                      <th>3 minute below</th>
                      <th>4 minute below</th>
                      <th>5 minute below</th>
                      <th>6 minute below</th>

                    </thead>
                    <tbody>
                          <?php $total_cost_1min = 0?>
                          <?php $total_count_1min = 0?>

                          <?php $total_cost_2min = 0?>
                          <?php $total_count_2min = 0?>

                          <?php $total_cost_3min = 0?>
                          <?php $total_count_3min = 0?>

                          <?php $total_cost_4min = 0?>
                          <?php $total_count_4min = 0?>

                          <?php $total_cost_5min = 0?>
                          <?php $total_count_5min = 0?>

                        <?php $total_cost_6min = 0?>
                          <?php $total_count_6min = 0?>

                          <?php $counter = 1?>
                          <?php foreach($sorted_call_duration as $key => $value) :?>
                          <tr> 
                              <td><?php echo $counter++?></td>
                              <td><b><?php echo $value->name ?></b></td>          
                              <td><b><?php echo $value->report->search1 ?></b></td>
                              <td><b><?php echo $value->report->search2 ?></b></td>
                              <td><b><?php echo $value->report->search3 ?></b></td>  
                              <td><b><?php echo $value->report->search4 ?></b></td>    
                              <td><b><?php echo $value->report->search5 ?></b></td>  
                              <td><b><?php echo $value->report->search6 ?></b></td>                             
                          </tr>

                          <?php $total_count_1min += $value->report->search1?>
                          <?php $total_count_2min += $value->report->search2?>
                          <?php $total_count_3min += $value->report->search3?>
                          <?php $total_count_4min += $value->report->search4?>
                          <?php $total_count_5min += $value->report->search5?>
                            <?php $total_count_6min += $value->report->search6?>
                          <?php endforeach?>

                            <tr> 
                              <td></td>
                              <td></td>          
                              <td><b><?php echo $total_cost_1min = $total_count_1min * 1.388?></b></td>
                              <td><b><?php echo $total_cost_2min = $total_count_2min * (1.388 * 2)?></b></td>
                              <td><b><?php echo $total_cost_3min = $total_count_3min * (1.388 * 3)?></b></td>  
                              <td><b><?php echo $total_cost_4min = $total_count_4min * (1.388 * 4)?></b></td>    
                              <td><b><?php echo $total_cost_5min = $total_count_5min * (1.388 * 5)?></b></td>      
                              <td><b><?php echo $total_cost_6min = $total_count_6min * (1.388 * 6)?></b></td>                      
                          </tr>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div id="product_released_chart_line" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
        </div>
      </div>
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

            console.log(reponse);

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

<?php build('headers') ?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<?php endbuild()?>

<?php occupy('templates/layout')?>