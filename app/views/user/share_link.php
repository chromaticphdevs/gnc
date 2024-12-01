<?php build('content') ?>

<div class="well">
    <h3>Link Share</h3>
    <form method="get" action="/users/get_qualification_info">
        <div class="form-group">
          
            <?php $link = "" ?>

            <?php if(SESSION::get("USERSESSION")['status'] == "starter" ||  SESSION::get("USERSESSION")['status'] == "silver" || SESSION::get("USERSESSION")['status'] == "gold"): ?>

                <label>Left</label>
                <input type="text" id="left_link" value="<?php echo getUserLink(null, null ,"LEFT")?>" class="form-control" readonly>

                <div class="form-group">
                    <input type="button" onclick="copy_left()"  class="btn btn-primary" value="Copy Link">
                </div>

                <br>
                <label>Right</label>
                <input type="text" id="right_link" value="<?php echo getUserLink(null, null ,"RIGHT")?>" class="form-control" readonly>
                <div class="form-group">
                    <input type="button" onclick="copy_right()" class="btn btn-primary" value="Copy Link">

                </div>

            <?php else:?>
                  <input type="text" id="single_link" value="<?php echo getUserLink()?>" class="form-control" readonly>
                  <div class="form-group">
                    <input type="button"  onclick="copy_single()" class="btn btn-primary" value="Copy Link">

                  </div>
            <?php endif;?>

        
        </div>

       
    </form> 
</div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
  
    function copy_left() {
      var copyText = document.getElementById("left_link");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
      alert("Successfully Copied LEFT Link");
      //alert("Copied the text: " + copyText.value);
    }


    function copy_right() {
      var copyText = document.getElementById("right_link");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
     alert("Successfully Copied RIGHT Link");
     // alert("Copied the text: " + copyText.value);
    }


    function copy_single() {
      var copyText = document.getElementById("single_link");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
        alert("Successfully Copied Link");
      //alert("Copied the text: " + copyText.value);
    }
    </script>
<?php endbuild()?>

<?php occupy('templates/layout')?>
