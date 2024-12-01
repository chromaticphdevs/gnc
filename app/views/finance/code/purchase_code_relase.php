<?php build('content') ?>
<h3>Code Purchase Release</h3>
<?php Flash::show()?>
<div class="col-md-4">
  <div class="well">
    <form action="/FNCodePurchase/make_purchase" id="codeReleaseForm" method="post">
      <?php if($code != false) :?>
         <?php for($row = 0; $row < count($code); $row++) :?>
              <input type="hidden" name="codeid[]" value="<?php echo $code[$row][10] ?>">
           <?php endfor; ?>
      <?php endif;?>   
      <div class="form-group">
        <label for="#">Username / Fullname</label>
        <input type="text" id="search_user" class="form-control" autocomplete="off">
        <div id="search_user_warning"></div>
      </div>
      <input type="hidden" name="userid" id="userid" required>

      <div id="userList">
        
      </div>
      <input type="submit" class="btn btn-primary btn-sm validate-action" value="Purchased">
    </form>
  </div>
</div>

<div class="col-md-7">
  <div class="well">
    <h3>Code Information</h3>

        <?php if($code != false) :?>
          <?php for($row = 0; $row < count($code); $row++) :?>
            <div class="row">
              <div class="col-md-6">
                <table class="table">
                  <tr>
                    <td>Code</td>
                    <td><strong><?php echo $code[$row][0]?></td>
                  </tr>
                  <tr>
                    <td>Branch</td>
                    <td><strong><?php echo $code[$row][1]?></strong></td>
                  </tr>
                  <tr>
                    <td>Company</td>
                    <td><strong><?php echo $code[$row][2]?></strong></td>
                  </tr>
                  <tr>
                    <td>DRC</td>
                    <td><strong><?php echo $code[$row][3]?></strong></td>
                  </tr>
                  <tr>
                    <td>UNILEVEL</td>
                    <td><strong><?php echo $code[$row][4]?></strong></td>
                  </tr>
                  <tr>
                    <td>BINARY</td>
                    <td><strong><?php echo $code[$row][5]?></strong></td>
                  </tr>

                  <tr>
                    <td>Level</td>
                    <td><strong><?php echo $code[$row][6]?></strong></td>
                  </tr>

                  <tr>
                    <td>Max Pair</td>
                    <td><strong><?php echo $code[$row][7]?></strong></td>
                  </tr>
                </table>
              </div>

              <div class="col-md-6">
                <div class="text-center">
                  <h3><?php echo $code[$row][8]?></h3>
                  <p>To Pay</p>
                  <hr>
                  <h3><?php echo $code[$row][9]?></h3>
                  <p>Box Equivalent.</p>
                </div>
              </div>
               </div>
          <?php endfor; ?>
        <?php endif;?> 
  </div>
</div>
<?php endbuild()?>

<?php build('scripts') ?>
<script>
  $( document ).ready(function() {

    $("#codeReleaseForm").on('submit' , function(e) {

        if($("#userid").val().length < 1) {

          $("#search_user_warning").html('You must select a user');
          $("#search_user_warning").attr("class" , 'alert alert-danger');
          console.log('ID MUST BE SET');
        }else{
          $(this).submit();
        }
        e.preventDefault();
    });

    $("#userList").on('click' , function(e)
    {
      if(e.target.classList.contains('userinfo-ajax')) {
          let userid = e.target.dataset.id;
          let fullname = e.target.dataset.fullname;

          $("#userid").val(userid);
          $("#search_user").val(fullname.trim());
          $("#userList").html('');
          e.target.remove();
      }
    });

    $("#search_user").keyup(function()
    {
        let userKey = $(this).val();

        /*if 3 characters*/
        if(userKey.length > 2) {

          $.ajax({
            method : 'post' , 
            url    : get_url('UserAjax/search_user'),
            data   : { key : userKey} , 
            success: function(response) 
            {
              response = JSON.parse(response);

              if(response == false) {
                $("#userid").val('');
                $("#userList").html('');
              }else{
                let html = ``;

                for(let i in response) {

                  html += `<div class='userinfo-ajax' data-id='${response[i].id}' 
                  data-fullname = '${response[i].firstname} ${response[i].lastname}'> 
                    <strong> Fullname : ${response[i].firstname} ${response[i].lastname} </strong> <br/>
                    <strong> Username : ${response[i].username} </strong>
                  </div>`;
                }

                $("#userList").html(html);
              }
            }
          });
        }else{
          $("#userid").val('');
          $("#userList").html('');
        }
    });
  });
</script>
<?php endbuild()?>


<?php build('headers')?>
<style>
  .userinfo-ajax{
    border: 1px solid #000;
    cursor: pointer;
  }

  .userinfo-ajax:hover{
    background: green;
    color: #000;
  }
</style>
<?php endbuild()?>
<?php occupy('templates/layout')?>