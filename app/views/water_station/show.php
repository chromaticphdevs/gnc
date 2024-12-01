<?php build('content')?>
<div class="">
  <div class="col-md-10 mx-auto">
    <h3 class="text-center"><?php echo $data->name?></h3>
    <img src="<?php echo GET_PATH_UPLOAD.DS.'water_station'.DS.$data->filename?>" style="width:100%">
  </div>
</div>
<?php endbuild()?>

<?php occupy('templates/layout')?>
