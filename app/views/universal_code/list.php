<?php build('content')?>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Universal Codes</h4>
            <a href="/UniversalCodeController/create" class="btn btn-primary">Create</a>
        </div>
        <div class="card-body">
            <div class="table">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($codes as $key => $code) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><img src="<?php echo $code->image_url?>" alt=""></td>
                                <td><?php echo $code->description?></td>
                                <td><?php echo $code->created_at?></td>
                                <td>
                                    <a href="/RaffleRegistrationController/register/?code=<?php echo seal($code->code)?>" class="btn btn-primary btn-sm">Show</a>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php occupy('templates/baselayout')?>