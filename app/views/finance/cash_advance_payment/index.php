<?php build('content')?>
<h3>Payments</h3>
<table class="table">
  <thead>
    <th>#</th>
    <th>Code</th>
    <th>Name</th>
    <th>Username</th>
    <th>Amount</th>
    <th>Image</th>
  </thead>

  <tbody>
    <?php foreach ($payments as $key => $row) :?>
      <tr>
        <td><?php echo ++$key?></td>
        <td><?php echo $row->code?></td>
        <td><?php echo $row->fullname?></td>
        <td><?php echo $row->username?></td>
        <td><?php echo $row->amount?></td>
        <td>
          <img src="<?php echo path_upload_get($row->path.DS.$row->image)?>"
          style="width:150px; height:150px;">
        </td>
      </tr>
    <?php endforeach?>
  </tbody>
</table>
<?php endbuild()?>


<?php occupy('templates/layout')?>
