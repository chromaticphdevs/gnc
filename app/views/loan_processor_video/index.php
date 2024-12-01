<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Processed Loans')) ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Date</th>
                        <th>Facebook</th>
                        <th>Sponsor Approval Video</th>
                        </thead>

                        <tbody>
                        <?php foreach($processedLoans as $key => $row) :?>
                            <tr data-userid="<?php echo seal($row->id)?>">
                            <td><?php echo ++$key?></td>
                            <td><?php echo userVerfiedText($row)?> <?php echo $row->fullname?></td>
                            <td><?php echo $row->mobile?></td>
                            <td>
                                <?php echo get_date($row->created_at , 'M d , Y h:i:s A')?>
                            </td>
                            <td>
                                <?php if($row->fb_link == '') :?>
                                <label for="#">No FB Link</label>
                                <?php else:?>
                                <a href="<?php echo $row->fb_link?>" target="_blank">View Media</a>
                                <?php endif;?>
                            </td>
                            <td>
                                <?php if($row->video_file) :?>
                                <a href="/LoanProcessorVideoController/show/<?php echo seal($row->lp_id)?>">Show</a>
                                <?php else :?>
                                <a href="/LoanProcessorVideoController/create/<?php echo seal($row->id)?>">Add Video</a>
                                <?php endif?>
                            </td>
                            </tr>
                        <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php occupy() ?>