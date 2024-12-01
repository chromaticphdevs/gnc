<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle(WordLib::get('directSponsor')))?>
            <div class="card-body">
                <?php Form::open([
                    'method' => 'post'
                ])?>
                    <div class="form-group">
                        <?php
                            Form::label(WordLib::get('directSponsor') . ' ' . 'username');
                            Form::text('username','', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter Username of new '.WordLib::get('directSponsor')
                            ])
                        ?>
                    </div>

                    <div class="form-group">
                        <?php Form::submit('change_sponsor_search', 'Save Changes', [
                            'class' => 'btn btn-primary'
                        ])?>
                    </div>
                <?php Form::close() ?>
            </div>

            <?php if(!empty($newSponsor)) :?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Profile</td>
                                <td><img src="<?php echo GET_PATH_UPLOAD.DS.'profile'.DS.$newSponsor->selfie?>" 
                                        style="width:100px; border-radius: 10px;" 
                                        alt="click-to-edit"></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?php echo $newSponsor->firstname . ' ' .$newSponsor->lastname?></td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td><?php echo $newSponsor->mobile?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="text-center">
                        <?php
                            Form::open([
                                'method' => 'post'
                            ]);

                            Form::hidden('new_sponsor', $newSponsor->id);
                            Form::hidden('userid', $id);
                        ?>
                            <div class="form-group">
                                <?php Form::submit('change_sponsor_apply','Save Change', [
                                    'class' => 'form-confirm btn btn-primary',
                                    'data-message' => 'Are you sure you want to apply'
                                ])?>
                            </div>
                        <?php Form::close()?>
                    </div>
                </div>
            <?php endif?>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>