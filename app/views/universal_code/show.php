<?php build('content') ?>
    <div class="col-md-5 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Your QR Code</h4>
            </div>
            <div class="card-body">
                <?php if(isset($imageSRC)) :?>
                    <img src="<?php echo $imageSRC?>" alt="">
                <?php else:?>
                    <img src="<?php echo $qr->image_url?>" alt="">
                <?php endif?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>