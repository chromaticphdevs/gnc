<?php build('content')?>
    

    <?php Flash::show()?>
         
            <div class="row">
                    <!--add link-->
                    <div class="x_panel">   
                        <div class="x_content">
                        <h3>Edit YouTube/Facebook Video Tutorials</h3>
                        <br>
                        <form action="/VideoTutorial/edit_video_info" method="post">

                            <input type="hidden" name="id" value="<?php echo $link_info->id ?>">

                            <h4><b>Title:</b></h4>
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" value="<?php echo $link_info->title ?>" required>
                            </div>

                            <div class="form-group">
                                <h4><b>Type:</b></h4>
                                <select name="link_type"  class="form-control">
                                    <option value="<?php echo $link_info->type ?>"><?php echo $link_info->type ?></option>
                                </select>
                            </div>

                            <?php $link ?>
                                 <?php if($link_info->type=="Facebook"): ?>
                                     <?php $link=$link_info->link ?>
                                 <?php else: ?>
                                     <?php $link="https://www.youtube.com/embed/".$link_info->link ?>
                                 <?php endif; ?>


                            <div class="form-group">
                                 <h4><b>Link:</b></h4>
                                <textarea name="link" rows="3" 
                                    class="form-control"  required><?php echo $link; ?></textarea>
                            </div>

                            <input type="submit" class="btn btn-primary" value="&nbsp;Edit&nbsp;">
                        </form>    
                        <br>
                            <center>
                                <?php if($link_info->type=="Facebook"): ?>
                                    <iframe src="https://www.facebook.com/plugins/video.php?href=<?php echo $link_info->link ?>" width="350" height="200" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                                <?php else: ?>   
                                    <iframe width="350" height="200" src="https://www.youtube.com/embed/<?php echo $link_info->link ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php endif; ?>
                            </center>
                           <br> 
                           <a class="btn btn-primary" href="/VideoTutorial/add_video/">Back</a>
                        </div>
                    </div>
                
                   
            </div>


<?php endbuild()?>

<?php occupy('templates/layout')?>