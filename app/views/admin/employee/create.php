<?php include_once VIEWS.DS.'templates/market/header.php'?>
</head>
<body>
    <div class="container">

      <ul>
        <li><a href="/employee/create">Add Emp</a></li>
        <li><a href="/employee/list">List</a></li>
        <li><a href="/employee/login">login</a></li>
        <li><a href="/timeKeepingRecords/list">View Records </a></li>
      </ul>
        <div class="row">
            <div class="col-md-10 mx-auto">

              <div id="col1">
                <section>
                  <h3>Personal</h3>
                    <div class="form-group">
                      <label>Firstname</label>
                      <input type="text" name="firstname" class="form-control">
                    </div>

                    <div class="form-group">
                      <label>Lastname</label>
                      <input type="text" name="lastname" class="form-control">
                    </div>

                    <div class="form-group">
                      <label>Gender</label>
                      <div>
                        <label>
                          <input type="rado" name="gender" value="Male">
                          Male
                        </label>
                        <label>
                          <input type="rado" name="gender" value="Male">
                          Female
                        </label>
                      </div>
                      <input type="text" name="lastname" class="form-control">
                    </div>
                </section>
              </div>

              <div id="col2"></div>
              <h3>Creating Employee</h3>
              <form method="post" action="/employee/create">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="firstname" class="form-control">
                </div>
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" name="lastname" class="form-control">
                </div>
                <div class="form-group">
                  <label>Job Name</label>
                  <input type="text" name="job_name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Hourly Rate</label>
                  <input type="number" name="hourly_rate" class="form-control" value="<?php echo $basicRate?>">
                  <small>Default Hourly Rate :<?php echo to_number($basicRate);?></small>
                </div>
                <input type="submit" name="" class="btn btn-success" value="Create Employee">
              </form>
            </div>
        </div>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>