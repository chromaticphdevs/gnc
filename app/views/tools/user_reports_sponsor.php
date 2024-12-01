<?php build('content')?>
<h4>Search User</h4>
<?php Flash::show()?>
<?php Flash::show('purchase_message')?>
<?php
  Form::open([
    'method' => 'POST' ,
    'action' => '/UserTools/add_to_report',
    'id'     => 'user_search'
  ]);
?>

<div class="form-group">
  <label for="#">Username / Fullname</label>
  <input type="text" id="search_user" class="form-control" autocomplete="off" required>
  <div id="search_user_warning"></div>

  <input type="hidden" name="user_id" id="userid" required>

  <div id="userList">
  </div>
</div>


<input type="submit" class="btn btn-primary btn-sm validate-action" value="Search">
<?php Form::close()?>

<br><br><br><br>
  <div class="x_content">
  <div style="overflow-x:auto;">
    <a class="btn btn-warning" href="/UserTools/reset_report ?>">Reset</a>
      <table class="table">
       <thead>
              <th>#</th>
              <th>Username</th> 
              <th>Full Name</th> 
              <th>30 Days</th> 
              <th>1 Week</th>
              <th>Yesterday</th> 
              <th>Today</th> 
              <th></th> 

       </thead>
           <tbody>
                 <?php if(isset($result)): ?>

                 <?php $counter = 1;?>
                 <?php for($row = 0; $row < count($result); $row++) :?>

                 
                    <tr>
                          <td><?php echo $counter; ?></td>
                          <td><h2><?php echo $result[$row]->username ?></h2></td>
                          <td><h2><?php echo $result[$row]->fullname ?></h2></td>
                          <td><h4 style="color:green;"><?php echo $result[$row]->month; ?></h4></td>
                          <td><h4 style="color:green;"><?php echo $result[$row]->week; ?></h4></td>  
                          <td><h4 style="color:green;"><?php echo $result[$row]->yesterday; ?></h4></td>
                          <td><h4 style="color:green;"><?php echo $result[$row]->today; ?></h4></td>
                          <td><a class="btn btn-danger btn-sm" href="/UserTools/remove_to_report/<?php echo $result[$row]->userid; ?>">Delete</a></td>
                    </tr>
                    <?php $counter++;?> 
                  
                  
                  <?php endfor;?>
                  <?php endif;?>
          </tbody>
      </table>
  </div>
  </div>
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
