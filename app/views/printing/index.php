<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
  .userinfo-ajax{
    border: 1px solid #000;
    cursor: pointer;
  }

  .userinfo-ajax:hover{
    background: green;
    color: #000;
  }
</style>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->
          
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">

            <?php Flash::show()?>
            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_content">
                  <a href="/PrintingExpense/show_all" class="btn btn-primary" role="button" aria-pressed="true">Show All Record</a>

                   <a href="/PrintingExpense/computation" class="btn btn-primary" role="button" aria-pressed="true">Compute</a>
                 <br><br>
                   
                       <h3><b>Printing Expenses</b></h3>
                       <hr>
                      <form action="/PrintingExpense/index" method="post" enctype="multipart/form-data">
                            
                         <div class="form-group">
                            <h4><b>Select Machine Type</b></h4>
                            <select name="machine_type" id="machine_type" class="form-control">
                              <option value="1 colors Huider" data-multiplier="1">1 colors Hidel </option>
                              <option value="2 colors Huider" data-multiplier="2">2 colors Hidel </option>
                              <option value="3 colors Huider" data-multiplier="3">3 colors Hidel </option>
                              <option value="4 colors Huider" data-multiplier="4">4 colors Hidel </option>
                              <option value="Gluing Machine 1" data-multiplier="1">Gluing Machine 1</option>
                              <option value="Gluing Machine 2" data-multiplier="1">Gluing Machine 2</option>
                              <option value="Die Cut 1" data-multiplier="1">Die Cut 1</option>
                              <option value="Die Cut 2" data-multiplier="1">Die Cut 2</option>
                              <option value="UV Lamination 1" data-multiplier="1">UV Lamination 1</option>
                              <option value="UV Lamination 2" data-multiplier="1">UV Lamination 2</option>
                            </select>
                            <input type="hidden" id="multiplier_input" name="multiplier"  readonly>
                         </div>


                         <div class="form-group">
                            <h4><b>Job Order Number</b></h4>
                            <input type="text" class="form-control" name="job_order" id="job_order" required>
                        </div>

                         <div class="form-group">
                            <h4><b>Client</b></h4>
                            <input type="text" class="form-control" name="client" required>
                        </div>

                        <div class="form-group">
                            <h4><b>Agent</b></h4>
                            <input type="text" class="form-control" name="agent" required>
                        </div>

                         <div class="form-group">
                            <h4><b>Agent Contact #</b></h4>
                            <input type="text" class="form-control" name="agent_number" required>
                        </div>


                        <div class="form-group">
                            <h4><b>Operator Name</b></h4>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                         <div class="form-group">
                             <h4><b>Previous Running (Meter Reading)</b></h4>
                            <input type="number" class="form-control" id="previous_meter_readings" name="previous_meter_readings" step="any" readonly>

                             <input type="hidden" id="previous_meter_readings_id" name="previous_meter_readings_id"  readonly>

                            <h4><b>Current Meter Reading</b></h4>
                            <input type="number" class="form-control" id="meter_readings" name="meter_readings" step="any" required>
                            <br>

                            <h3>Total Running:<b><p id="answer">0</p></b></h3>
                            <input type="hidden" id="difference" name="total_running"  readonly>
                            <br>
                            <h4>Minimum:<b><p id="minimum">0</p></b>Succeeding:<b><p id="succeeding">0</p></b></h4>
                    
                            <h3>Amount:<b><p id="amount">0</p></b></h3><br>
                            <input type="hidden" id="amount_total_running" name="amount_total_running"  readonly>

                            <h4><b>Dicount:</b></h4>
                            <input type="number" min="0" class="form-control" id="discount" name="discount" step="any" value="0" >
                        </div>
                        <div class="form-group">
                            <h4><b>Note:</b></h4>
                            <input type="text" class="form-control" name="note" >
                        </div>
                        <br>
                        <div class="form-group">
                            <h4><b>Image</b></h4>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                        <br>
                        <input type="submit" value="Save Information"
                        class="btn btn-success">
                    </form>
             
                </div>
              </div>
            </div>
         </div>


<script>
  $( document ).ready(function() {

    var machine_type = document.getElementById("machine_type").value
  
    $.ajax({
      method : 'post' ,
      url    : get_url('PrintingExpense/get_last_job_order'),
      data   : { machine_type : machine_type} ,
      success: function(response)
      {
        data = JSON.parse(response);
        console.log(response);

       
        if(data == false) {
           document.getElementById("previous_meter_readings").value = 0;
            document.getElementById("answer").innerHTML = "0";
        }else{

          var readings = data[0].reading;
          var readings_id = data[0].id;

          document.getElementById("previous_meter_readings").value = readings;
          document.getElementById("previous_meter_readings_id").value = readings_id;
        }

      }
    });

    $("#machine_type").change(function()
    {   
      var machine_type = document.getElementById("machine_type").value
  
          $.ajax({
            method : 'post' ,
            url    : get_url('PrintingExpense/get_last_job_order'),
            data   : { machine_type : machine_type} ,
            success: function(response)
            {
              data = JSON.parse(response);
              console.log(response);

             
              if(data == false) {
                 document.getElementById("previous_meter_readings").value = 0;
                  document.getElementById("answer").innerHTML = "0";
              }else{

                var readings = data[0].reading;
                var readings_id = data[0].id;

                document.getElementById("previous_meter_readings").value = readings;
                document.getElementById("previous_meter_readings_id").value = readings_id;
              }

            }
          });


    });

   
    $("#meter_readings").keyup(function()
    {   

      var previous_meter_readings = document.getElementById("previous_meter_readings").value

 
      if(previous_meter_readings > 0 ){
        
        var current_reading = document.getElementById("meter_readings").value
        
        var difference = current_reading - previous_meter_readings;

        var amount = 0;

        var multiplier = $("#machine_type").find(':selected').data("multiplier");
        document.getElementById("multiplier_input").value = multiplier;

        var basic_running = 1000;

        var basic_price = 700 * multiplier;

        var succeeding_price = 300;


        /*compute amount*/
        var x = difference - basic_running;

        if(x <= 0)
        {
           amount = basic_price;
           document.getElementById("minimum").innerHTML = amount;
        }else
        {

           x = x / basic_running;

           x = Math.ceil(x);

           amount = basic_price + (x * succeeding_price);

           document.getElementById("minimum").innerHTML = basic_price;
           document.getElementById("succeeding").innerHTML = (x * succeeding_price);
        }

        if(difference >= 0)
        {
             document.getElementById("answer").innerHTML = difference;
             document.getElementById("difference").value = difference;
             document.getElementById("amount").innerHTML = amount;
             document.getElementById("amount_total_running").value = amount;
             document.getElementById("discount").readOnly = false;
        }
        
      }


        if(previous_meter_readings == 0)
        {
          document.getElementById("discount").readOnly = true;
        }
    });

    $("#discount").change(function()
    {   
        var total_amount = document.getElementById("amount_total_running").value;
        var discount = document.getElementById("discount").value;

        var amount = total_amount - discount;

        document.getElementById("amount").innerHTML = amount;
  
    });



  });
</script>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
