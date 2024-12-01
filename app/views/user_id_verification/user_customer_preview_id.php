
<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style type="text/css">
  #container {
    width: 100%;
    height: 100%;
    overflow: hidden;
  }
  #container.rotate90,
  #container.rotate270 {
    width: 100%;
    height: 100%
  }
  #image {
    transform-origin: top left;
    /* IE 10+, Firefox, etc. */
    -webkit-transform-origin: top left;
    /* Chrome */
    -ms-transform-origin: top left;
    /* IE 9 */
  }
  #container.rotate90 #image {
    transform: rotate(90deg) translateY(-100%);
    -webkit-transform: rotate(90deg) translateY(-100%);
    -ms-transform: rotate(90deg) translateY(-100%);
  }
  #container.rotate180 #image {
    transform: rotate(180deg) translate(-100%, -100%);
    -webkit-transform: rotate(180deg) translate(-100%, -100%);
    -ms-transform: rotate(180deg) translateX(-100%, -100%);
  }
  #container.rotate270 #image {
    transform: rotate(270deg) translateX(-100%);
    -webkit-transform: rotate(270deg) translateX(-100%);
    -ms-transform: rotate(270deg) translateX(-100%);
}


</style>

</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">
            
            <?php Flash::show()?>

          <section class="x_panel">
            <section class="x_content">
              <div style="overflow-x:auto;">
                <?php foreach ($result as $key => $value): ?>
                  <h2>Fullname: <b> <?php echo $value->fullname; ?> </b></h2>
                  <br>  
                  <h2>Address: <b> <?php echo $value->address; ?> </b></h2>
                  <br>
                  <h2>ID Type: <b> <?php echo $value->type; ?> </b></h2>
                  <br>
                  <br>
                  <h3><b>Front ID</b></h3>
                    <div  id="container">
                        <img  style="max-height:100%; max-width:100%" src="<?php echo URL.DS.'assets/user_id_uploads/'.$value->id_card; ?>" id="image">
                       <br>
                       <button type="button" class="btn btn-primary" id="button">Rotate Image</button>
                      	<h3><b>Back ID</b></h3>   
                  	    <img style="max-height:100%; max-width:100%" src="<?php echo URL.DS.'assets/user_id_uploads/'.$value->id_card_back; ?>"   id="image">
                    </div> 
                    <br>
                <?php endforeach;?>
              </div>
            </section>
          </section>
        
        </div>
        <!-- page content -->

<script type="text/javascript">
 
      var angle = 0,
       img = document.getElementById('container');
      document.getElementById('button').onclick = function() 
      {

        angle = (angle + 90) % 360;
        img.className = "rotate" + angle;
      }

   

    $(document).ready(function()
    { 
        var angle = 0,
        img = document.getElementById('container');

        document.onkeypress = function (e) {
          
          var x = e.which || e.keyCode;

          if(x==114)
          {
               rotate();
          }
         
        };
        function rotate()
        {
             angle = (angle + 90) % 360;
            img.className = "rotate" + angle;
        }


      $("#send").on('click' , function(e)
      {
         if (confirm("Send this Note?"))
         {
            return true;
         }else
         {
           return false;
         }
      });

    });


</script>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>