<?php include_once VIEWS.DS.'templates/market/header.php'?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">

              <h3>Employee List</h3>
              <ul>
                <li><a href="/timeKeeper/admin/?page=create_employee">Add Emp</a></li>
                <li><a href="/timeKeepingRecords/list">View Records</a></li>
                <li><a href="/timeKeeper/admin/?page=panel">Panel</a></li>
              </ul>

              <table class="table">
                <thead>
                  <th>ID</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Password</th>
                  <th>Job</th>
                  <th>Hourly Rate</th>
                  <th>Company</th>
                </thead>

                <tbody>
                  <?php foreach($emp_list as $emp):?>
                    <tr>
                      <td><?php echo $emp->password?></td>
                      <td><?php echo $emp->firstname?></td>
                      <td><?php echo $emp->lastname?></td>
                      <td><?php echo $emp->password?></td>
                      <td><?php echo $emp->job_name?></td>
                      <td><?php echo $emp->hourly_rate?></td>
                      <td><?php echo $emp->compname?></td>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>