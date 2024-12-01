<?php build('content') ?>
    <div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Account Management'))?>
        <div class="card-body">
            <?php Flash::show()?>
            <div class="row">
                <section class="col-md-5">
                    <div class="x_panel">
                        <div class="x_content">
                            <h3>Create Account</h3>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="fullname" placeholder="Full name" 
                                    class="form-control">
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="name">Username</label>
                                        <input type="text" name="username" placeholder="Username" 
                                        class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name">Password</label>
                                        <input type="text" name="password" placeholder="Password" 
                                        class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="name">Branch</label>
                                        <select name="branchid" id="" class="form-control">
                                            <?php foreach($branches as $key => $row) :?>
                                                <option value="<?php echo $row->id?>">
                                                    <?php echo $row->name?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name">Account Type</label>
                                        <select name="type" id="" class="form-control">
                                            <?php foreach($accountTypes as $key => $row) :?>
                                                <option value="<?php echo $row?>">
                                                    <?php echo $row?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-primary btn-sm" value="Create Account">
                            </form>  
                        </div> 
                    </div>
                </section>
          
                <section class="col-md-7">
                    <div class="x_panel">
                      <div style="overflow-x:auto;"> 
                        <div class="x_content">
                            <h3>Account List</h3>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Branch</th>
                                    <th>Username</th>
                                    <th>Type</th>
                                    <th>Fullname</th>
                                    <th>Action</th>
                                </thead>

                                <tbody>
                                    <?php foreach($accounts as $key => $row) :?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><?php echo $row->branch_name?></td>
                                            <td><?php echo $row->username?></td>
                                            <td><?php echo $row->type?></td>
                                             <td><?php echo $row->name?></td>
                                            <td><a href="/FNAccount/edit_account/<?php echo $row->id?>">Edit</a></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>   
                        </div>
                      </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </div>
<?php endbuild()?>

<?php occupy()?>