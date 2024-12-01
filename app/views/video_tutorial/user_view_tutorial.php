<?php build('content')?>
<?php Flash::show()?>


            <div class="row">


                    <div class="x_panel">
                        <div class="x_content">
                            <h3><b>YouTube</b> Videos</h3>
                            <div style="overflow-x:auto;">
                            <table class="table">

                                <tbody>

                                    <?php $count2=0; ?>
                                    <?php foreach($videos as $key => $row) :?>

                                        <?php $count = ++$key; ?>
                                        <?php $count2++; ?>

                                        <?php if($count2==1):?>
                                           <thead>
                                        <?php endif;?>

                                                <th>
                                                    <h4><b style="color:red;"><?php echo $row->title?></b></h4>
                                                    <br>
                                                    <!-- <iframe width="350" height="200" src="<?php echo $linkConverter::convert($row->type , $row->link)?>"
                                                    frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe> -->

                                                    <iframe width="300" height="250" src="<?php echo $linkConverter::convert($row->type , $row->link)?>" frameborder="0"
                                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                                 </th>

                                        <?php if(($count%3) == 0):?>

                                           </thead>
                                           <?php $count2=0; ?>

                                        <?php endif;?>

                                    <?php endforeach;?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
            </div>
 <?php endbuild()?>

<?php occupy('templates/layout')?>
