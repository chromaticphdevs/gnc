<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 400px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 250px;
}

div.desc {
  padding: 5px;
  text-align: center;
}
</style>
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

            <br>
          </div>
        </div>
        <!-- top navigation -->
      
                  <div class="right_col" role="main" style="min-height: 524px;">
         
       <a href="/PrintingExpense" class="btn btn-primary" role="button" aria-pressed="true">Back</a>
       <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                <div style="overflow-x:auto;">
                         <div class="col-md-4">
                            <div class="form-group">
                                <h4><b>Before:</b></h4>
                                     <input type="number" id="before" class="form-control" name="before" step="any">
                                </div>
                                <div class="form-group">
                                  <h4><b>After:</b></h4>
                                  <input type="number" id="after" class="form-control" name="after" step="any">
                               </div>
                               <h3>Difference:<b><p id="answer">0</p></b></h3><br><br>
                              <input type="button" id="reset" value="Reset" class="btn btn-success">
                             <br><br><br><br>
                          </div>

                   
                  <table class="table" id="dataTable">
                      <thead>
                        <th>Date & Time</th>
                        <th>Job Order #</th>
                        <th>Client</th>
                        <th>Meter Reading</th>
                        <th>Uploader Name</th>
                        <th>Notes</th>
                      </thead>

                      <tbody>
                          <?php foreach($expenses as $key => $row) :?>
                              <tr>
                                  <td>  

                                     <?php
                                        $date=date_create($row->date_time);
                                        echo date_format($date,"M d, Y");
                                        $time=date_create($row->date_time);
                                        echo date_format($time," h:i A");
                                     ?>
                                  
                                  </td>
                                  <td><?php echo $row->job_order_number?></td>
                                  <td><?php echo $row->client?></td>   
                                  <td><input type="button"  id="readings" data-meter_value="<?php echo $row->reading?>" value="<?php echo $row->reading?>"></td>
                                  <td><?php echo $row->uploader_name?></td>
                                  <td><?php echo $row->note?></td>                     
                              </tr>
                          <?php endforeach?>
                      </tbody>
                  </table>
              </div>
                </div>
          </div>

    
      </div>
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {


        $('#dataTable').DataTable({
          "pageLength": 5,
          "bLengthChange": false,
          "bInfo": false,
          "bFilter": true,
           "bPaginate": false,
           "ordering": false
        } );

         

      $(document).on('click', '#readings', function()
      { 
         var meter_value=$(this).data("meter_value");
            
         var before = document.getElementById("before").value
         var after = document.getElementById("after").value

            if(before == "" || before == 0 )
            {
               document.getElementById("before").value = meter_value;

            }else if((before != "" && after == "" ) || (before != 0 && after == 0)){

               document.getElementById("after").value = meter_value;

               var difference = before - meter_value;

               document.getElementById("answer").innerHTML = difference.toFixed(2);
            }

      });

      //reset computation
      $(document).on('click', '#reset', function()
      { 
           document.getElementById("before").value = "0";
           document.getElementById("after").value = "0";
           document.getElementById("answer").innerHTML = "0";
      });


    });
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

