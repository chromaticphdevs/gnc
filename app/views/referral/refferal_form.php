<?php include_once VIEWS.DS.'templates/market/header.php'?>

</head>
<body>

 <section class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(<?php echo URL.'/assets/'; ?>/overlay-bg.jpg)">
   
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="home" class="box-shadow-full">
              <div class="row">
          
                          <div class="col-md-6">
             
                   <div class="title-box-2">
                    <h5 class="title-left">
                  Referral Registration
                    </h5>
                      
                  </div>
                       <?php Flash::show();?>
                    <form method="post" id="register" action="/affiliates/create_account">

                        <input type="hidden" name="binary_position" value="<?php echo $referral['position']?>">
                        <input type="hidden" name="upline" value="<?php echo $referral['upline']?>">
                        <input type="hidden" name="sponsor" value="<?php echo $referral['sponsor']?>">

                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /> 
                            <div class="validation"></div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" data-msg="Please enter a valid email" />
                            <div class="validation"></div>
                          </div>
                        </div>
                           <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" data-msg="Please enter a valid email" />
                            <div class="validation"></div>
                          </div>
                        </div>
                      
                      </div>
                  </div>

                <div class="col-md-6">


                   <div class="title-box-2">
                    <h5 class="title-left">
                        Login information
                    </h5>
                      
                  </div>
                   <div class="row">
                       <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>Username</label>
                            <input type="text" name="username" class="form-control" id="name" placeholder="Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /> 
                            <div class="validation"></div>
                          </div>
                         </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                             <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password"  data-msg="Please enter a valid email" />
                            <div class="validation"></div>
                          </div>

                          <div class="form-group">
                             <label>Branch</label>
                             <select name="branch" id="" class="form-control">
                               <option value="">-Select your branch</option>
                              <?php foreach($branchList as $key => $row) :?>
                                <option value="<?php echo $row->id?>">
                                  <?php echo $row->branch_name?>
                                </option>
                              <?php endforeach;?>
                             </select>
                            <div class="validation"></div>
                          </div>


                           &nbsp; Already member? <a href="/login.html"><u>Login in here</u></a>
                        </div>
                        
                        <br>
                             <div class="col-md-12">
                          <button type="submit" class="button button-a button-big button-rouded">REGISTER</button>
                        
                        </div>
                 
   
                  </div>
            </form> 
                </div>

            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="copyright-box">
              <p class="copyright">&copy; Copyright <strong>SocialNetwork</strong>. All Rights Reserved</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </section>



   <?php include_once VIEWS.DS.'templates/market/footer.php'?>