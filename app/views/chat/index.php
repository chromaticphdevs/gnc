<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Breakthrough-Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo _path_public('themes/chat/main.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container app">
    <div class="row app-one">
        <div class="col-sm-4 side">
            <div class="side-one">
                <div class="row heading">
                    <div class="col-sm-3 col-xs-3 heading-avatar">
                        <div class="heading-avatar-icon">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                        </div>
                    </div>
                    <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
                        <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-2 col-xs-2 heading-compose  pull-right">
                        <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="row searchBox">
                    <div class="col-sm-12 searchBox-inner">
                        <div class="form-group has-feedback">
                            <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row sideBar">
                    <!--- chart sessions -->
                    <?php for($i = 0; $i < 5; $i++) :?>
                        <div class="row sideBar-body">
                            <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                <div class="avatar-icon">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar<?php echo $i + 1?>.png">
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-9 sideBar-main">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-8 sideBar-name">
                                        <span class="name-meta">John Doe
                                        </span>
                                    </div>
                                    <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                        <span class="time-meta pull-right">18:18
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor?>
                </div>
            </div>
            <div class="side-two">
                <div class="row newMessage-heading">
                    <div class="row newMessage-main">
                        <div class="col-sm-2 col-xs-2 newMessage-back">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </div>
                        <div class="col-sm-10 col-xs-10 newMessage-title">
                            New Chat
                        </div>
                    </div>
                </div>
                <div class="row composeBox">
                    <div class="col-sm-12 composeBox-inner">
                        <div class="form-group has-feedback">
                            <input id="searchPeople" type="text" class="form-control" name="searchText" placeholder="Search People">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row compose-sideBar" id="searchPeopleContainer">
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                                    <span class="name-meta">John Doe
                                    </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                    <span class="time-meta pull-right">18:18
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8 conversation">
            <div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta">John Doe
                    </a>
                    <span class="heading-online">Online</span>
                </div>
                <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                </div>
            </div>
            <!-- chart area -->
            <div class="row message" id="conversationSection">
                <div class="row message-previous">
                    <div class="col-sm-12 previous">
                        <a onclick="previous(this)" id="ankitjain28" name="20">
                        Show Previous Message!
                        </a>
                    </div>
                </div>
                <div class="row message-body">
                    <div class="col-sm-12 message-main-receiver">
                        <div class="receiver">
                            <div class="message-text">
                                Hi, what are you doing?!
                            </div>
                            <span class="message-time pull-right">
                                Sun
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row message-body">
                    <div class="col-sm-12 message-main-sender">
                        <div class="sender">
                            <div class="message-text">
                                I am doing nothing man!
                            </div>
                            <span class="message-time pull-right">
                                Sun
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row reply" id="replySection">
                <div class="col-sm-1 col-xs-1 reply-emojis">
                    <i class="fa fa-smile-o fa-2x"></i>
                </div>
                <div class="col-sm-9 col-xs-9 reply-main">
                    <textarea class="form-control" rows="1" id="textFieldChat" placeholder="Enter your chat here.."></textarea>
                </div>
                <div class="col-sm-1 col-xs-1 reply-recording">
                    <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
                </div>
                <div class="col-sm-1 col-xs-1 reply-send">
                    <i class="fa fa-send fa-2x" aria-hidden="true" id="buttonSendChat"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo _path_public('js/core/conf.js')?>"></script>
<script src="<?php echo _path_public('js/core/global.js')?>"></script>
<script src="<?php echo _path_public('themes/chat/main.js')?>"></script>
<script type="text/javascript">
	$(function(){
        $(".heading-compose").click(function() {
        $(".side-two").css({
            "left": "0"
        });
        });

        $(".newMessage-back").click(function() {
        $(".side-two").css({
            "left": "-100%"
        });
        });
    })
</script>
</body>
</html>