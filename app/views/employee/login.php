<?php include_once VIEWS.DS.'templates/market/header.php'?>

<script defer type="text/javascript" src="<?php echo URL.DS.'public/js/emp_login.js'?>"></script>
<style type="text/css">
  
  video
  {
    width: 720;
    height: 500;
  }
  table img
  {
    width: 75px;
    height: 75px;
  }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
              <div>
                <?php Flash::show();?>

                <form method="post" action="/timeKeeper/getSecret">
                  <h3>Login</h3>

                  <div class="form-group">
                    <label>ID Number </label>
                    <input type="text" name="secret" class="form-control">
                  </div>

                  <input type="submit" name="" class="btn btn-primary" value="login">
                </form>
              </div>
            </div>
        </div>

        <hr>
        <div class="row">
          <div class="col-md-10 mx-auto">
              <h3>New Log</h3>
                <table class="table">
                  <thead>
                    <th>Name</th>
                    <th>Picture</th>
                    <th>Date Time</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $lastLog->fullname?></td>
                      <td><img src="<?php echo URL.DS.'public/assets/'.$lastLog->image?>"></td>
                      <td><?php echo $lastLog->fullname?></td>
                    </tr>
                  </tbody>
                </table>

                <h3>Today Records</h3>
                <table class="table" id="dataTable">
                <thead>
                  <th>Name</th>
                  <th>In</th>
                  <th>Image</th>
                  <th>Out</th>
                  <th>Total Time</th>
                  <th>Hourly Rate</th>
                  <th>Preview</th>
                </thead>

                <tbody>
                    <?php foreach($log_list as $log) :?>
                      <tr>
                        <td><?php echo $log->fullname?></td>
                        <td><?php echo $log->logArranged->timein ?: '0'?></td>
                        <td><img src="<?php echo URL.DS?>assets/<?php echo $log->logImage?>"></td>
                        <td><?php echo $log->logArranged->timeout ?: '0'?></td>
                        <td>
                          <?php echo $log->time_spent ?: '0'?>
                        </td>
                        <td>
                          <?php
                            
                            $timeSpent = $log->time_spent ?: 0;
                            $explodeTime = explode(':' , $timeSpent);

                            if(count($explodeTime) > 1)
                            {
                              $hourToMin   = $explodeTime[0] <= 0 ? 0: $explodeTime[0] * 60;
                              $min         = isset($explodeTime[1]) ? $explodeTime[1] : 0;
                              $ratePerMinute = $log->hourly_rate / 60;

                              $rate = ($hourToMin + $min) * $ratePerMinute;
                              echo "hrly rate :" .$log->hourly_rate . "(".to_number($rate).")";
                            }else{
                              echo "N/A";
                            }
                          ?>

                        </td>
                        <td><?php if($log->logid) :?>
                          <a href="/timeKeepingRecords/preview/<?php echo $log->logid;?>">View</a>
                          <?php else:?>
                          No Time in
                        <?php endif;?>
                      </tr>
                    <?php endforeach;?>
                </tbody>
              </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
      <script type="text/javascript">
      $(document).ready(function() {
          $('#dataTable').DataTable();
      } );
      </script>
      
<?php include_once VIEWS.DS.'templates/market/footer.php'?>