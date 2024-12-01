<?php build('content')?>
<h3>Water Station</h3>
<div class="col-md-6">
  <div class="well">
    <form class="" action="/WaterStation/update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $data->id?>">
      <div class="form-group">
        <label for="#">Name</label>
        <input type="text" name="name" value="<?php echo $data->name?>" class="form-control">
      </div>

      <div class="form-group">
        <label for="#">File</label>
        <input type="file" name="file" value="" class="form-control">
        <small class="text-danger">If you do not wish to change the file do not select here</small>
      </div>

      <input type="submit" name="" value="Save Changes"
      class="btn btn-primary">
    </form>
  </div>
    <img src="<?php echo GET_PATH_UPLOAD.DS.'water_station'.DS.$data->filename?>" alt="">

</div>


<?php endbuild()?>


<?php occupy('templates/layout')?>
