<?php build('content')?>
  <div class="col-sm-12 col-md-12">
    <div class="well">
      <h4>Search Customer</h4>
      <form class="" action="/FNCashAdvanceAdmin/show" method="get">
        <div class="form-group">
          <label for="#">Customer Username</label>
          <?php Form::text('username' , '' , ['class' => 'form-control' , 'id' => 'customer_name'])?>
        </div>

        <div class="form-group">
          <label for="#"></label>
          <select class="form-control" style="display:none" name="userid" id="userlist" required>

          </select>
        </div>

        <div class="form-group">
          <?php Form::submit('' , 'Select User' , [
            'class' => 'btn btn-primary btn-sm'
            ])?>
          <a href="?" class="btn btn-danger btn-sm">Cancel</a>
        </div>
      </form>
    </div>
  </div>
<?php endbuild()?>

<?php build('scripts')?>
<script type="text/javascript">
  $(document).ready(function(evt) {

    $("#customer_name").keyup(function(evt)
    {
      let customerName = $(this).val();

      if( customerName.length > 2 )
      {
        //empty select option
        $("#userlist").empty();

        $.get(get_url("API_User/getByKeyword") ,{key_word: customerName , limit:10} )
        .done(function( response )
        {
          response = JSON.parse(response);

          for(let i in response) {
            var option = new Option(response[i].username , response[i].id);
            $("#userlist").append(option);
          }

          $("#userlist").css('display' , 'block');
        });
      }
    });
  });
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
