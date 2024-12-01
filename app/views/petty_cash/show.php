<?php build('content')?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Petty Cash Data</h4>
                <a href="/PettyCashController/index">Back to list</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width:30%">Title</td>
                                    <td><?php echo $pettyCash->title?></td>
                                </tr>
                                <tr>
                                    <td>Amount</td>
                                    <td><?php echo ui_html_amount($pettyCash->amount)?></td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td><?php echo $pettyCash->entry_date?></td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td><?php echo $pettyCash->description?></td>
                                </tr>
                                <tr>
                                    <td>Date Recorded</td>
                                    <td><?php echo $pettyCash->updated_at?></td>
                                </tr>
                                <tr>
                                    <td>Running balance</td>
                                    <td><?php echo ui_html_amount($pettyCash->running_balance)?></td>
                                </tr>
                                <tr>
                                    <td>User</td>
                                    <td><?php echo $pettyCash->fullname?></td>
                                </tr>

                                <tr>
                                    <td>Created By</td>
                                    <td><?php echo $pettyCash->uploadername?></td>
                                </tr>
                                <tr>
                                    <td>Action</td>
                                    <td>
                                        <a href="/PettyCashController/edit/<?php echo $pettyCash->id?>">Edit</a> | 
                                        <a href="/PettyCashController/delete/<?php echo $pettyCash->id?>?token=<?php echo $csrf?>">Delete</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border-box">
                            <?php if($file) :?>
                                <img src="<?php echo $file->file_url_full?>" 
                                    alt="" style="width:350px">
                            <?php endif?>
                            <div>
                                <?php
                                    Form::open([
                                        'enctype' => 'multipart/form-data',
                                        'method' => 'post',
                                        'action' => '/PettyCashController/edit/'.$pettyCash->id
                                    ]);

                                    Form::hidden('id', $pettyCash->id)
                                ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php Form::file('file'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php Form::submit('change_image', 'Change Image', [
                                                    'class' => 'btn btn-primary btn-sm'
                                                ]); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php Form::close()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>