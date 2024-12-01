<?php build('content') ?>
    <div class="container-fluid">
        <?php
            echo wControlButtonLeft('', [
                $navigationHelper->setnav('', 'Back', '/UserDirectsponsor/index')
            ]);
        ?>
        <div class="col-md-6 mx-auto">
            <div class="card">
                <?php echo wCardHeader(wCardTitle(WordLib::get('referrals') . ' Approval Video')) ?>
                <div class="card-body">
                    <?php Flash::show() ?>
                    <video width="100%" height="240" controls>
                        <source src="<?php echo PATH_PUBLIC.DS.'assets/user_videos/'.$video->video_file?>" type="video/mp4">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="card-footer">
                    <a href="/UserDirectsponsor/deleteVideo/<?php echo seal($video->id)?>" class="btn btn-danger btn-lg">Delete Video</a>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>