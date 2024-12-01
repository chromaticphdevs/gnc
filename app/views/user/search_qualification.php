<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Search Username'))?>
            <div class="card-body">
                <?php Flash::show()?>
                <form method="get" action="/users/get_qualification_info">
                    <div class="form-group">
                        <label>Enter Username</label>
                        <input type="text" name="username" class="form-control">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="" class="btn btn-primary" value="search">
                    </div>
                </form> 
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>