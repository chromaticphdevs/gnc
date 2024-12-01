<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Make Account')) ?>
            <div class="card-body">
                <?php Flash::show()?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-5">
                            <?php echo wCardHeader(wCardTitle('Change Account Information'))?>
                            <div class="card-body">
                                <form action="" method="post">
                                    <input type="hidden" name="accountid" 
                                        value="<?php echo $accountid?>">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" name="name" placeholder="Full name" 
                                        class="form-control" value="<?php echo $account->name?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Username</label>
                                        <input type="text" name="username" placeholder="Username" 
                                        class="form-control" value="<?php echo $account->username?>">
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label for="name">Branch</label>
                                            <select name="branchid" id="" class="form-control">
                                                <?php foreach($branches as $key => $row) :?>
                                                    <?php $selected = $row->id == $account->branchid ? 'selected' : ''?>
                                                    <option value="<?php echo $row->id?>" 
                                                        <?php echo $selected?>>
                                                        <?php echo $row->name?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="name">Account Type</label>
                                            <select name="type" id="" class="form-control">
                                                <?php foreach($accountTypes as $key => $row) :?>
                                                    <?php $selected = $row == $account->type ? 'selected' : ''?>
                                                    <option value="<?php echo $row?>" 
                                                        <?php echo $selected?>>
                                                        <?php echo $row?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-sm" value="Update Account">
                                        
                                        <a href="/FNAccount/make_account" class="btn btn-primary btn-sm">
                                            Create Account
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <?php echo wCardHeader(wCardTitle('Change Password'))?>
                            <div class="card-body">
                                <form action="/FNAccount/update_password" method="post">
                                    <input type="hidden" name="accountid" value="<?php echo $account->id?>">
                                    <div class="form-group">
                                        <label for="#">Change Password</label>
                                        <input type="text" name="password" placeholder="Password" 
                                            class="form-control">
                                    </div>

                                    <input type="submit" class="btn btn-primary btn-sm" 
                                    value="Update Password">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <?php echo wCardHeader(wCardTitle('Account List'))?>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>#</th>
                                            <th>Branch</th>
                                            <th>Fullname</th>
                                            <th>Username</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </thead>

                                        <tbody>
                                            <?php foreach($accounts as $key => $row) :?>
                                                <tr>
                                                    <td><?php echo ++$key?></td>
                                                    <td><?php echo $row->branch_name?></td>
                                                    <td><?php echo $row->name?></td>
                                                    <td><?php echo $row->username?></td>
                                                    <td><?php echo $row->type?></td>
                                                    <td><a href="/FNAccount/edit_account/<?php echo $row->id?>">Edit</a></td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php occupy()?>