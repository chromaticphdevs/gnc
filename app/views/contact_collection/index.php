<?php build('content')?>

<div style="overflow-x:auto;">
   <h1><b style="color:green;">You're Cash Advance is on Proccess</b></h1>
  <h2><b>Please Refer A Person that we can call and verify your profile</b></h2>
    <table>
          <thead>

            <tr>
              <td>Fullname:</td>
               <td><?php Form::text('name1' , '' ,$input['required'])?></td>
            </tr> 

            <tr>
              <td>CellPhone Number:</td>
              <td><?php Form::text('number1' , '' ,[
                  'class' => 'form-control',
                  'form'  => $input['form'],
                  'id'    => 'num1',
                  'required' => ''
                  ])?></td>
            </tr>
          </thead>
      </table><br>
        <table>
          <thead>

            <tr>
              <td>Fullname:</td>
               <td><?php Form::text('name2' , '' ,$input['required'])?></td>
            </tr> 

            <tr>
              <td>CellPhone Number:</td>
              <td><?php Form::text('number2' , '' ,[
                  'class' => 'form-control',
                  'form'  => $input['form'],
                  'id'    => 'num2',
                  'required' => ''
                  ])?></td>
            </tr>

          
          </thead>
      </table><br>

      <?php
        Form::submit('submit' , 'Submit' , [
          'class' => 'btn btn-success btn-sm form-confirm',
          'form'  => $input['form'],
          'id' => 'save'
        ])
      ?>
       
<?php
  Form::open([
    'method' => 'post',
    'action' => '/ClientContacts/save_contacts',
    'id'     => $input['form'],
    'enctype' => 'multipart/form-data'
  ]);

  Form::hidden('user_id' , $userInfo['id']);
  Form::close();
?>
</div>


<?php endbuild()?>


<?php build('scripts')?>
<script defer>
  $( document ).ready(function() {

   
      $("#save").click(function(e){
        let cp_number1 = $("#num1").val();
        let cp_number2 = $("#num2").val();

        if(cp_number1 == cp_number2)
        {
          alert("Please Enter 2 Different Number");
          document.getElementById("num2").focus();
          e.preventDefault();
          return;
        }


        let special_char = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        let regExpr = /[^a-zA-Z0-9 ]/g;

        //validate cp_number
        if(/^[0-9]+$/i.test(cp_number1) == true)
        {
            if(cp_number1.length<=10 || cp_number1.length>=12)
            {
                alert("Invalid Number. Please Enter 11 digit number");
                document.getElementById("num1").focus();
                e.preventDefault();
                return;
            }

            if(cp_number1.substring(0, 2)!="09")
            {
              alert("Invalid Number format eg. 09*********");
              document.getElementById("num1").focus();
              e.preventDefault();
              return;
            }
        }else{
          alert("Please Enter Number Only for Contact Number");
          document.getElementById("num1").focus();
          e.preventDefault();
          return;
        }

         //validate cp_number
        if(/^[0-9]+$/i.test(cp_number2) == true)
        {
            if(cp_number2.length<=10 || cp_number2.length>=12)
            {
                alert("Invalid Number. Please Enter 11 digit number");
                document.getElementById("num2").focus();
                e.preventDefault();
                return;
            }

            if(cp_number2.substring(0, 2)!="09")
            {
              alert("Invalid Number format eg. 09*********");
              document.getElementById("num2").focus();
              e.preventDefault();
              return;
            }
        }else{
          alert("Please Enter Number Only for Contact Number");
          document.getElementById("num2").focus();
          e.preventDefault();
          return;
        }
      });
  });

</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
