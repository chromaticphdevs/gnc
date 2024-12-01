<?php build('content')?>
<h4>Search User</h4>
<?php Flash::show()?>
<?php Flash::show('purchase_message')?>
<?php
  Form::open([
    'method' => 'get' ,
    'action' => '/ProductPurchase/create',
    'id'     => 'user_search'
  ]);
?>

<div class="form-group">
  <label for="#">Username / Fullname</label>
  <input type="text" id="search_user" class="form-control" autocomplete="off">
  <div id="search_user_warning"></div>

  <input type="hidden" name="user_id" id="userid" required>

  <div id="userList">
  </div>
</div>


<input type="submit" class="btn btn-primary btn-sm validate-action" value="Search">
<?php Form::close()?>
<?php endbuild()?>

<?php build('scripts')?>
<script defer>
  $( document ).ready(function() {

    $("#user_name").on('submit' , function(e) {

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

               let html = ``;

              if(response == false) {
                $("#userid").val('');
                $("#userList").html('');

                 html += `<div class='userinfo-ajax'>
                    <strong> Not Found</strong>

                  </div>`;

              }else{


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

    $("#payment").on('submit' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
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
