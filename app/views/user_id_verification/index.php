<?php build('content') ?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Uploaded Ids</h4>
    </div>
    <div class="card-body">
        <?php Flash::show()?>
        <?php foreach($result as $key => $row): ?>
            <div class="card-footer">
                <ul class="list-unstyled">
                    <li><h3>ID Type : <?php echo $row->type?></h3></li>
                    <li>Fullname : <?php echo $row->fullname?></li>
                    <li>Address : <?php echo $row->fullname?></li>
                    <li>Status : <?php echo $row->id_status?></li>
                </ul>

                <div class="row">
                    <div class="col-md-6">
                        <img  style="max-height:100%; max-width:100%" 
                            src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card; ?>" 
                            id="image">
                    </div>
                    <div class="col-md-6">
                        <img style="max-height:100%; max-width:100%" 
                            src="<?php echo URL.DS.'assets/user_id_uploads/'.$row->id_card_back; ?>"
                            id="image">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <?php $returnTo = seal('UserIdVerification/customerPublicView/'.seal($row->user_id))?>
                <a href="/UserIdVerification/deny_id/<?php echo $row->uploaded_id?>" class="btn btn-danger"> Cancel </a>
            </div>
        <?php endforeach?>
    </div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>