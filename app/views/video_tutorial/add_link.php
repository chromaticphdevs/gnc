<?php build('content')?>


    <?php Flash::show()?>

            <div class="row">
                    <!--add link-->
                    <div class="x_panel">
                        <div class="x_content">
                        <h3>Add YouTube/Facebook Video Tutorials</h3>
                        <br>
                        <form action="/VideoTutorial/add_video" method="post">

                            <h4><b>Title:</b></h4>
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="form-group">
                                <h4><b>Select Type:</b></h4>
                                <select name="link_type"  class="form-control" required>

                                    <option value="Youtube">Youtube</option>
                                    <option value="Facebook">Facebook</option>

                                </select>
                            </div>

                            <div class="form-group">
                                 <h4><b>Link:</b></h4>
                                <textarea name="link" rows="3"
                                    class="form-control" required></textarea>
                            </div>

                            <input type="submit" class="btn btn-primary" value="&nbsp;Add Link&nbsp;">
                        </form>
                        </div>
                    </div>

                    <div class="x_panel">
                      <h3>Video Tutorials (Drag to switch position)</h3>
                      <br>
                      <ul id="current-files">
                        <?php foreach($videos as $key => $row) :?>
                          <li data-position="<?php echo $row->position?>" id="<?php echo 'items-'.$row->id?>">
                            <div class="row">
                              <div class="col-md-3">
                                <label for=""><?php echo $row->title?></label>
                              </div>
                              <div class="col-md-3">
                                <iframe width="350" height="200" src="<?php echo $linkConverter::convert($row->type , $row->link)?>"
                                frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                              </div>

                              <div class="col-md-6 text-right">
                                <a class="btn btn-info" href="/VideoTutorial/edit_video_info/?id=<?php echo $row->id?>">Edit</a>
                                <a class="btn btn-danger" href="/VideoTutorial/delete_video/<?php echo $row->id?>">Delete</a>
                              </div>
                            </div>
                          </li>
                        <?php endforeach?>
                      </ul>
                    </div>
            </div>


<?php endbuild()?>

<?php build('scripts')?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

  $(document).ready(function(evt) {

    $("#current-files").sortable(
      {
      axis: 'y',
      update: function (event, ui)
      {
          var data = $(this).sortable('serialize');

          $.ajax({
              data: data,
              type: 'POST',
              url: get_url('API_VideoTutorial/reorderItems'),

              success:function(response) {
                console.log(response);
              }
          });
      }
    }
  );
  });
</script>
<?php endbuild()?>

<?php build('headers')?>
  <style media="screen">
    #current-files li{
      cursor: pointer;
    }
  </style>
<?php endbuild()?>
<?php occupy('templates/layout')?>
