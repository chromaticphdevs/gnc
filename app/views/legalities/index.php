<?php build('content')?>
<h3>Legalities</h3>

<div class="row">
  <?php foreach($legals as $key => $row) :?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4><?php echo $row->name?></h4>
      </div>

      <div class="card-body">
        <?php
          $isImage = explode('.' , $row->filename);

          $isImage = end($isImage);
        ?>
        <?php if(in_array(strtolower($isImage) , ['jpg' , 'jpeg' , 'png'])) :?>
          <a href="/legalities/show/<?php echo $row->id?>" target="_blank">
            <img src="<?php echo GET_PATH_UPLOAD.DS.'legals'.DS.$row->filename?>" alt="" style="width:100%">
          </a>
        <?php else:?>
          <a href="#">Dowload to view Legal</a>
        <?php endif;?>
      </div>
    </div>
  </div>
  <?php endforeach?>
</div>
<?php endbuild()?>


<?php occupy('templates/layout')?>