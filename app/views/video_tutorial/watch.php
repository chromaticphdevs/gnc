<?php build('content') ?>
<h3><?php echo $activeVideo->title?></h3>
<div class="row">
  <div class="col-md-8">
    <div class="well">
      <h4></h4>
      <div class="active-video">
        <!--<iframe src="<?php echo $linkConverter::convert($activeVideo->type ,$activeVideo->link)?>" frameborder="0"
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
      </div>

      <?php if(!in_array($activeVideo->id , $watchedVideoIds)) :?>
      <div class="text-center" id="updateToWatch">
        <?php
          Form::open(['method' => 'post' , 'action' => '/VideoTutorialWatch/update']);
            Form::hidden('user_id' , $user_id);
            Form::hidden('link_id' , $activeVideo->id);

            Form::submit('submit' , 'Watch next video' , ['class' => 'btn btn btn-primary']);
          Form::close();
        ?>
      </div>
      <?php endif;?>
    </div>
  </div>

  <div class="col-md-4">
    <div class="well">
      <h4>Tutorials</h4>
      <!--<ul class="tutorial_links">
        <?php foreach($videoTutorialsWithWatchedVideos as $key => $row) :?>
          <li>

            <?php if(isset($row->isWatched)) :?>
              <a href="/VideoTutorialWatch?video_id=<?php echo seal($row->id)?>"><?php echo $row->title?></a>
            <?php else:?>
              <?php
                if($row->id == $nextVideo->id) {
                  ?> <a href="/VideoTutorialWatch?video_id=<?php echo seal($row->id)?>"><?php echo $row->title?></a> <?php
                }else{
                  ?> <label for="#"><?php echo $row->title?></label> <?php
                }
              ?>
            <?php endif;?>
          </li>
        <?php endforeach?>
      </ul>-->
    </div>
  </div>
</div>

<?php endbuild()?>

<?php build('headers')?>
<style media="screen">
  .active-video{
      height: 500px;
  }

  .active-video iframe{
    width: 100%;
    height: 100%;
  }
  .tutorial_links li a{
    display: block;
  }
  .tutorial_links li {
    margin-bottom: 5px;
    background: #fff;
    padding: 10px;
  }
</style>
<?php endbuild()?>

<?php build('scripts')?>
<script type="text/javascript">
  $("#updateToWatch").css('display' , 'none');

  let timer = 1;

  setInterval(function() {

    if(timer > 60) {
      $("#updateToWatch").show();
    }
    timer++;
  }, 1000);
</script>
<?php endbuild()?>
<?php occupy('templates.layout')?>
