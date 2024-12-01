<header>
     <!--/ Nav Star /-->
  <nav class="navbar navbar-b navbar-trans navbar-expand-md fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll" href="/Pages/" style="color:#800080"><?php echo SITE_NAME?></a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
        aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="navbar-collapse collapse justify-content-end" id="navbarDefault">
        <ul class="navbar-nav">
            <?php if(is_logged_in()): ?>

              <?php 
                if(Session::get('USERSESSION')['type'] === '1') {

                  ?>
                    <li class="nav-item">
                     <a style="color:#800080" class="nav-link js-scroll active" href="/<?php echo 'admin'?>">Profile</a>
                    </li> 
                     <li class="nav-item">
                     <a style="color:#800080" class="nav-link js-scroll" href="#products">Products</a>
                     </li>
                  <?php

                }else{
                  ?>
                    <li class="nav-item">
                      <a style="color:#800080" class="nav-link js-scroll" href="/<?php echo 'users'?>">Profile</a> 
                    </li> 
                      <li class="nav-item">
                     <a style="color:#800080" class="nav-link js-scroll" href="#products">Products</a>
                     </li>
                   <?php
                }
              ?>
            <?php else: ?>
               <li class="nav-item">
                 <a style="color:#800080" class="nav-link js-scroll active" href="/Pages/">Home</a>
               </li>
            <?php endif;?>
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Nav End /-->



</header>