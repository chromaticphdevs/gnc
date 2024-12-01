<?php include_once VIEWS.DS.'templates/market/header.php'?>
</head>
<body>
    <div class="container">
      <form method="post" action="/tkCompany/update">
        <input type="hidden" name="companyid" value="<?php echo $comp->id?>">
         <h3>Create Company</h3>
         <?php Flash::show();?>
         <ul>   
            <li><a href="/timeKeeper/admin/?page=panel">Panel</a></li>
          </ul>
         <hr>
        <div class="form-group">
          <label>Company Name</label>
          <input type="text" name="name" class="form-control" value="<?php echo $comp->name?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="<?php echo $comp->email;?>">
        </div><div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control" value="<?php echo $comp->phone;?>">
        </div>

        <fieldset>
          <legend>Company Address</legend>

          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="<?php echo $comp->phone;?>">
          </div>

          <div id="instruction">
            <strong class="text-danger">Must Read Instructions</strong>
            <dl>
              <dt>Creating Company account on same Company location</dt>
              <dd>
                Instructions.
              </dd>
              <dd>Your geo location will be autmatically be filled bellow or you can either go to 
                <a href="https://www.geoplugin.com" target="_blank">geoplugin</a> our geolocation provider.
              </dd>

              <dt>Creating Company On diffrent Location</dt>
              <dd>
                Instructions.
              </dd>
              <dd>
                <div>WINDOWS / LINUX / MAC</div>
                1. Open Terminal for ubuntu / Mac typed in <strong>ip addr show</strong> <br>
                for Windows open cmd <i>(windows + r)</i> then type <strong>cmd</strong> type <strong>ipconfig</strong>
              </dd>
              <dd>
                2.On LINUX / MAC get inet : <strong>192.168.254.115/24</strong> <br>
                For windows get the IPv4 address
              </dd>
              <dd>
                3. Copy this link and change to 'Your IP' to your ip (http://www.geoplugin.net/php.gp?ip=<strong>Your IP</strong>)
              </dd>
              <dd>
                4. Copy all the characters on that page then paste in on gelocation field. and your  good to go
              </dd>
            </dl>
          </div>
          <div class="form-group">
            <label>Geolocation</label>
            <input type="hidden" name="default_geolocation" 
            value="<?php echo base64_encode($comp->geolocation);?>">
            <textarea class="form-control pre" name="custom_geolocation" rows="10">Default Location is Set</textarea>
          </div>
          <div>
            <strong class="text-danger">Location Type: </strong>
            <label>
              <input type="radio" name="loc_type" value="Default" checked>
              Default Location
            </label>
            <label>
              <input type="radio" name="loc_type" value="Custom">
              Custom Location
            </label>
          </div>

        </fieldset>

        <div class="form-group">
          <input type="submit" name="" class="btn btn-success" value="Create Company">
        </div>
      </form>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>