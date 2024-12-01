<?php build('content')?>

<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  font-size: 20px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

<div style="overflow-x:auto;">
   <h1><b style="color:green;">Contacts</b></h1><br>
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


      <?php
        Form::submit('submit' , 'Save Contact' , [
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

    <br><br>
    <table id="customers">
      <thead>
          <th>#</th>
          <th>Contact Name</th>
          <th>Number</th>
          <th></th>
      </thead>

       <tbody>
             <?php $counter = 1;?>
             <?php if(!empty($contact_list)):?>
               <?php foreach($contact_list as $key => $value) :?>
                  <tr>
                        <td><?php echo $counter ?></td>
                        <td><?php echo $value->contact_name; ?></td>
                        <td><?php echo $value->number; ?></td>

                        <td> <a href="/ClientContacts/send_link/<?php echo $value->number; ?>" class="btn btn-success btn-sm">Send Link</a></td>
                  </tr>
                <?php $counter++;?>
                <?php endforeach;?>
            <?php endif;?>
      </tbody>
  </table>

</div>


<?php endbuild()?>


<?php build('scripts')?>
<script defer>
  $( document ).ready(function() {

   
      $("#save").click(function(e){
        let cp_number1 = $("#num1").val();


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

      });
  });

</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
