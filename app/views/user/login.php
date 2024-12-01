<?php build('content') ?>
<div class="col-md-5 mx-auto" style="margin-top:50px; margin-bottom: 50px;">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Login To <span style="font-weight:bold"><?php echo SITE_NAME?></span> Platform</h4>
    </div>
    <div class="card-body">
      <?php Flash::show();?>
        <form method="post" id="member_login" action="/users/login">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-group">
                 <label>Username</label>
                <input type="text" name="username" class="form-control" id="name" placeholder="Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required />
                <div class="validation"></div>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-group">
                 <label>Password</label>
                <input type="password" class="form-control" name="password" id="email" placeholder="Password" data-rule="email" data-msg="Please enter a valid email" required />
                <div class="validation"></div>
              </div>
            </div>
            <div class="col-md-12 mb-3">
               &nbsp;  <a href="/recover/initiate">Forget Password</a>
            </div>
            <br>
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">LOGIN</button>
            
            </div>
            <br>
           
          </div>
        </form>
    </div>
  </div>
</div>
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>