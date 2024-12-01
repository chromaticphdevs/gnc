<?php build('content') ?>
<div class="container-fluid">
    <?php
        $navigationButtons = [
            $navigationHelper->setnav('', 'Unverified','/UserSocialMedia/?status=unverified', [
                'icon' => 'fa fa-list'
            ]),
            $navigationHelper->setnav('', 'Approved', '/UserSocialMedia/?status=verified', [
                'icon' => 'fa fa-list'
            ]),
            $navigationHelper->setnav('', 'Denied','/UserSocialMedia/?status=deny', [
                'icon' => 'fa fa-list'
            ])
        ];
        echo wControlButtonRight('', $navigationButtons);
    ?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle(' Social Medias ')) ?>
        <div class="card-body">
            <?php Flash::show()?>
            <h1><?php echo strtoupper( $req['status'] ?? 'Unverified' )?></h1>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Member Name</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Link</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($userSocials as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo userVerfiedText($row->is_user_verified) ?><?php echo $row->fullname?></td>
                                <td><?php echo $row->user_username?></td>
                                <td><?php echo $row->type?></td>
                                <td><a href="<?php echo $row->link?>" target="_blank" class="btn btn-primary btn-sm">Visit</a></td>
                                <td>
                                    <a href="/UserSocialMedia/approve/<?php echo seal($row->id)?>" class="btn btn-primary">Approve</a>
                                    &nbsp;&nbsp;
                                    <a href="/UserSocialMedia/deny/<?php echo seal($row->id)?>" class="btn btn-danger">Deny</a>
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
<?php occupy()?>