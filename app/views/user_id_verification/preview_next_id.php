
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
          
          <section class="x_panel">
            <section class="x_content">

            <h3>Name: <b><?php echo $result->fullname; ?> </b></h3>
            <br>
            <h3>Address: <b><?php echo $result->address; ?> </b></h3>
            <br>
            <h2>ID Type: <b> <?php echo $result->type; ?> </b></h2>
            <br>
            <table>
              <tr>
                <th><a class="btn btn-success" href="/UserIdVerification/verify_id/<?php echo $result->uploaded_id;?>">Verify</a></th>
                <th></th>
                <th>
                     <form action="/UserIdVerification/deny_id"  method="post">  
                        <input type="submit" class="btn btn-danger  validate-action" value="&nbsp;Deny&nbsp;" id="deny_btn">
                </th>
              </tr>

              <tr>
                <td></td>
                <td style="width: 100px"></td>
                <td> 
                    <div class="form-group">
                          <input type="hidden" name="id" value="<?php echo $result->uploaded_id;?>">
                          <select class="form-control" name="comment" required>
                            <option value="Image is Unclear">Image is Unclear</option>
                            <option value="Invalid ID">Invalid ID</option>
                            <option value="Unmatch">Unmatch</option>
                          </select>
                    </div>
                </form>   
                </td>
              </tr>
            </table>
            <br>
            <br>

            <h3><b>Front ID</b></h3>

           
              <div  id="container">

                  <img  style="height:35%; width:35%" src="<?php echo URL.DS.'assets/user_id_uploads/'.$result->id_card; ?>" id="image">
                 <br>
                 <button type="button" class="btn btn-primary" id="button">Rotate Image</button>
                  <h3><b>Back ID</b></h3>   
     
                  <img style="height:35%; width:35%" src="<?php echo URL.DS.'assets/user_id_uploads/'.$result->id_card_back; ?>"   id="image">

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
    });

</script>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

<?php build('content') ?>

<?php endbuild()?>

<?php occupy() ?>