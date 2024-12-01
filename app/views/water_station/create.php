<?php build('content')?>
<h3>Water Station</h3>
<div class="col-md-6">
  <div class="well">
    <form class="" action="/WaterStation/store" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="#">Name</label>
        <input type="text" name="name" value="" class="form-control">
      </div>

      <div class="form-group">
        <label for="#">File</label>
        <input type="file" name="file" value="">
      </div>

      <input type="submit" name="" value="Save"
      class="btn btn-primary">
    </form>
  </div>
</div>

<div class="col-md-6">
  <table class="table">
    <thead>
      <th>#</th>
      <th>Name</th>
      <th>File Type</th>
      <th>Action</th>
    </thead>

    <tbody>
      <?php foreach($water_station_data as $key => $row) :?>
        <tr>
          <td><?php echo ++$key?></td>
          <td><?php echo $row->name?></td>
          <td>
            <?php
              $fileType = explode('.' , $row->filename);
              $fileType = end($fileType);

              echo $fileType
            ?>
          </td>

          <td>
            <a href="/WaterStation/edit/<?php echo $row->id?>">View</a>
          </td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>
</div>
<?php endbuild()?>


<?php occupy('templates/layout')?>
