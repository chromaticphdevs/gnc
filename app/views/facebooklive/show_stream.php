<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
    iframe{
        width: 100%;
        min-height: 90vh;
    }
    .comment {
        padding: 1.5px;
        margin-bottom: 5px;
    }
    .comment label {
        font-weight: bold;
    }
    .comment .small{
        display: block;
        font-weight: normal;
    }
    .comment p {
        margin-top: 5px;
        font-kerning: 10;
        color: #000;
        font-weight: bold;
    }
</style>

</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
            <?php Flash::show()?>
            <div class="x_panel">
                <div class="row">
                    <div class="col-md-9">
                        <div class="x_content">
                            <h3><?php echo $stream->title?>
                            <input type="hidden" id="streamid" value="<?php echo $stream->id?>">
                                <?php if($stream->userid == Session::get('USERSESSION')['id']) :?>
                                    <a href="/FacebookStream/edit?streamid=<?php echo $stream->id?>">Edit</a>
                                <?php endif?>
                            </h3>
                            <small>Posted by : <?php echo $account->fullname ?? 'no-user'?> on <?php echo $stream->created_at?></small>

                            <section class="stream-screen">
                                <?php echo $iframe?>
                            </section>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="x_content">
                            <h3>Stream Comments</h3>

                            <section id="comments">
                                <?php foreach($comments as $key => $row) :?>
                                    <div class="comment">
                                        <label for="#"><?php echo $row->fullname?></label> <small><?php echo $row->created_at?></small>
                                        <p><?php echo $row->comment?></p>
                                    </div>
                                <?php endforeach?>
                            </section>
                            <small>Write Comment</small>
                            <form action="" method="post" id="commentForm">
                                <input type="hidden" id="streamid" name="streamid" value="<?php echo $stream->id?>">
                                <div class="form-group">
                                    <textarea id="comment" name="comment" class="form-control" cols="3"></textarea>
                                </div>

                                <input type="submit" class="btn btn-primary btn-sm"  id="post_comment" value="Post Comment">
                            </form>
                        </div>
                    </div>
                      
                </div>
            </div>
        </div>
        <!-- page content --> 

<script defer>
    $(document).ready(function() {
        /**GET FRESH COMMENTS */
        setInterval(getComment,1000);

        $("#commentForm").on('submit' , function(evt){

            $.ajax({
                url: get_url('StreamComment/storeAjax'),
                method:'post',
                data: $(this).serialize()
            }).done(function(response) {
                getComment()
            })

            evt.preventDefault();
        });
    });

    function getComment()
    {   
        let streamid = $("#streamid").val();

        $.ajax({
            url: get_url('StreamComment/allAjax'),
            method:'post',
            data: {streamid: streamid}

        }).done(function(response)
        {
            response = JSON.parse(response);

            let html = '';

            for(let i in response) {
                html += ` 
                <div class='comment'>
                    <div>
                        <label for="#">${response[i].fullname}</label>
                        <small>${response[i].created_at}</small>
                        <p>${response[i].comment}</p>
                    </div>
                </div>`;
            }

            $("#comments").html(html);
        })
    }
</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
