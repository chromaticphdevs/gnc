<?php build('content')?>
    <div class="card">
        <div class="card-header">
            <a href="?page=1" class="btn btn-primary btn-sm"> Page 1 </a>
            <a href="?page=2" class="btn btn-primary btn-sm"> Page 2 </a>
        </div>
        <div class="card-body">
            <iframe src="/DocumentController/loanAgreement?id=<?php echo $loanId?>&q=<?php echo seal($req)?>" frameborder="0" width="100%" height="800vh"></iframe>
        </div>
    </div>
<?php endbuild()?>
<?php occupy()?>