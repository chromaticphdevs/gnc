<?php build('content')?>
<h3><?php echo $title?></h3>
<small>Welcome to Stream Community!</small>
    <?php if(Session::get('USERSESSION')['type'] == '1'): ?>
            <a href="/FacebookStream/make_stream" class="btn btn-primary">Start My Stream</a>
    <?php endif; ?> 

<hr>

<div class="well">
    <p>Number of live: <?php echo count($streams)?></p>
    <div class="row">
        <?php foreach($streams as $key => $row) :?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3>
                        <a href="/FacebookStream/show_live/?streamid=<?php echo $row->stream_code?>"><?php echo $row->title?></a>
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Stream clip-->
                    <?php echo FacebookStream::default_iframe($row->facebook_link)?>
                </div>

                <div class="card-footer">
                    <p>Posted By: <?php echo $row->fullname?> at <?php echo $row->created_at?></p>
                    <p><small><?php echo crop_string($row->description , 20)?></small></p>
                </div>
            </div>
        </div>
        <?php endforeach?>
    </div>
</div>
<?php endbuild()?>
<?php occupy('templates.layout')?>