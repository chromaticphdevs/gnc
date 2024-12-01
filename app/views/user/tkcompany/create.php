<?php include_once VIEWS.DS.'templates/market/header.php'?>

<style type="text/css">
  #col1 , #col2
  {
    width: 500px;
    margin-top: 30px;
  }

  #col1 > section , #col2 > section
  {
    background: #fff;
    padding: 30px;
  }
  #content{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
</style>
</head>
<body>
    <div class="container">
      <form method="post" action="">
         <h3>Create Company</h3>
         <?php Flash::show();?>
         <section id="content">

          <div id="col1">
            <section>
               <h3>General</h3>
                <div class="form-group">
                  <label>Company Name</label>
                  <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control">
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" name="address" class="form-control">
                </div>
             </section>

             <!--  GEOLOCATION -->
             <section>
               <h3>Geolocation</h3>
               <strong class="text-danger">Must Read Instructions</strong>
              <div id="instruction">
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
                    1. Open Terminal for ubuntu / Mac typed in <strong>MAC ' ifconfig |grep inet '</strong> 
                    on <strong>' LINUX ip addr show '</strong> <br>
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
                <input type="hidden" name="default_geolocation" value="<?php echo base64_encode($geolocation);?>">
                <textarea class="form-control pre" name="custom_geolocation" rows="10">Default Location is Set</textarea>
              </div>
              <div class="form-group">
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
             </section>
             <!-- // GEOLOCATION -->
          </div>
          <div id="col2">
              <section style="display: none">
               <h3>TK admin</h3>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="11111">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" value="11111">
                </div>
             </section>

             <section>
              <div class="form-group">
                <strong><label>Set single device login</label></strong>
                <input type="hidden" name="userAgent" value="<?php echo base64_encode(serialize($device))?>">

                <div>
                  <label>
                    <input type="radio" name="devicekey" value="false" checked>
                    False
                  </label>

                  <label>
                    <input type="radio" name="devicekey" value="true">
                    True
                  </label>
                </div>
              </div> 

              <div id="deviceInfo">
                <h3>Device</h3>
                 <ul>
                   <li>Device: <strong><?php echo $device['OS']?></strong></li>
                   <li>Device Type : <strong><?php echo $device['device']?></strong></li>
                   <li>
                     <small>This Device will store a cookie that will set this device unique identity.</small>
                   </li>
                 </ul>
              </div>
              </section>

              <section>
                <input type="submit" name="" class="btn btn-success" value="Create Company">
              </section>
          </div>
         </section>
      </form>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>