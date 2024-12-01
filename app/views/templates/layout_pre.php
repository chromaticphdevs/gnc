<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle(''))?>
            <div class="card-body"></div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts') ?>
<?php endbuild()?>

<?php build('headers') ?>
<?php endbuild()?>

<?php occupy('templates/layout')?>