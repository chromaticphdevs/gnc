<?php build('content') ?>
<?php
    $user_type = Auth::user_position();
    if($user_type === '2')
    {
        $user_type = 'users';
    }
    else{
        $user_type = 'admin';
    }
?>
<h3><?php echo $title?></h3>
<?php Flash::show()?>
<form action="/UserList/get_registration_a_week" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="#">Number of Days</label>
    <input type="number"  name="days" value="<?php echo $number_days; ?>" class="form-control" required>
  </div>
  <input type="submit" class="btn btn-primary btn-sm validate-action" value="Search" id="request">
</form>

<table id="users">
 <thead>
    <th>#</th>
    <th>UserName</th> 
    <th>Full Name</th> 
    <th>Email</th> 
    <th>phone</th>
    <th>Address</th> 
    <th>Status</th> 
    <th>ID</th> 
    <th>Social Media</th> 
    <th>Date &Time</th>          
 </thead>
 <tbody>
  <?php $counter = 1;?>
  <?php foreach($result as $data) :?>
      <tr>
        <td><?php echo $counter ?></td>
        <td><?php echo $data->username; ?></td>
        <td><?php echo $data->firstname." ".$data->lastname; ?></td>
        <td><?php echo $data->email; ?></td>
        <td><?php echo $data->mobile; ?></td>  
        <td><?php echo $data->address; ?></td>  
        <td><?php echo $data->status; ?></td>  
        <td> 
          <?php if($data->uploaded_id != 'no_id'): ?>
            <a class="btn btn-info btn-sm" 
                href="/UserIdVerification/staff_preview_id/<?php echo seal($data->id); ?>" 
                 target="_blank" >Preview ID</a>
          <?php endif; ?>
        </td>
         <td>
        <?php if($data->link != 'no_link'): ?>
          <a class="btn btn-primary btn-sm" href="<?php echo $data->link; ?>" target="_blank">Preview</a>
        <?php endif; ?>
        </td>
        <td>
          <?php
              $date=date_create($data->created_at);
              echo date_format($date,"M d, Y");
              $time=date_create($data->created_at);
              echo date_format($time," h:i A");
            ?>
        </td>
      </tr>
  <?php $counter++;?>  
  <?php endforeach;?>
 </tbody>
</table>
<?php endbuild()?>


<?php build('headers')?>
<style>
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1.5px solid #ddd;
  }

  th, td {
    text-align: left;
    padding: 4px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
  #users {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #users td, #users th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #users tr:nth-child(even){background-color: #f2f2f2;}

  #users tr:hover {background-color: #ddd;}

  #users th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
  }
</style>
<?php endbuild()?>
<?php occupy('templates/layout')?>