<?php build('content') ?>
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <?php foreach($notifications as $key => $row) :?>
                <a href="<?php echo $row->link?>" class="notif">
                    <div class="">
                        <?php echo $row->message?>
                    </div>
                </a>
            <?php endforeach?>
        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?>
<style>
    .notif{
        display: block;
        height: 30px;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #eee;
    }
</style>
<?php endbuild()?>
<?php occupy()?>