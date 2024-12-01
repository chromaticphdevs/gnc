
<?php build('content') ?>
  <div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
      <?php Flash::show()?>
    <h3>Name: <b><?php echo $_GET['fullname']; ?> </b></h3>
          <br>
          <h3>Address: <b><?php echo $_GET['address']; ?> </b></h3>
          <br>
          <h2>ID Type: <b> <?php echo $_GET['type']; ?> </b></h2>
          <br>
          <table>
            <tr>
              <th><a class="btn btn-success" href="/UserIdVerification/verify_id/<?php echo $_GET['id'];?>">Verify</a></th>
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
                              <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
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
            <img  style="height:35%; width:35%"  src="<?php echo URL.DS.'assets/user_id_uploads/'.$_GET['filename']; ?>" id="image">
          <br>
          <button type="button" class="btn btn-primary" id="button">Rotate Image</button>
            <h3><b>Back ID</b></h3>   

            <img style="height:35%; width:35%"  src="<?php echo URL.DS.'assets/user_id_uploads/'.$_GET['filename2']; ?>"   id="image">
        </div> 
    </div>
  </div>
<?php endbuild()?>
<?php build('headers') ?>
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
<?php endbuild()?>
<?php build('scripts')?>
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
<?php endbuild()?>
<?php occupy()?>