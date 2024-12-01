<?php build('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Groups</h4>
                </div>

                <div class="card-body">
                    <a href="javascript:void(0)" type="button" data-toggle="modal" data-target="#exampleModal">Create Group</a>
                    <hr>
                    <?php foreach($groups as $key => $row) :?>
                        <div class="card">
                            <div class="card-footer">
                                <a href="?groupId=<?php echo $row->id?>" style="text-decoration:underline;"><?php echo $row->title?></a>
                            </div>
                        </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
        <?php if(!empty($req['groupId'])) :?>
        <div class="col-md-6 mt-2 mb-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Chats <strong><?php echo $group->title?></strong></h4>
                </div>

                <div class="card-body">
                    <section id="conversations">
                        <?php if(!empty($messages)) :?>
                            <?php foreach($messages as $key => $row) :?>
                                <?php
                                    $chatBoxPos = ($row->sender_id == whoIs('id')) ? 'pull-right' : 'pull-left';
                                    $selfie = empty($row->selfie) ? 'https://img.freepik.com/premium-vector/man-avatar-profile-picture-vector-illustration_268834-538.jpg?size=338&ext=jpg&ga=GA1.1.735520172.1710460800&semt=ais':
                                        GET_PATH_UPLOAD.DS.'profile'.DS.$row->selfie;
                                ?>
                                <div class="<?php echo $chatBoxPos?> convo-item" title="<?php echo $row->member?>">
                                    <div class="row">
                                        <?php if($chatBoxPos == 'pull-left') :?>
                                            <div class="col-md-2" style="text-align: left;">
                                                <img 
                                                    src="<?php echo $selfie?>" 
                                                        alt="" style="width: 45px;" class="user-image" data-target="<?php echo $row->sender_id?>">
                                            </div>
                                        <?php endif?>
                                        <div class="col-md-9"
                                            <?php if($chatBoxPos == 'pull-right') {
                                                echo 'style="text-align: right"';
                                            } else{
                                                echo 'style="text-align: left"';
                                            }?>>
                                            <div><strong><?php echo $row->sender_fullname?></strong></div>
                                            <div><?php echo $row->chat?></div>
                                            <?php if(!empty($row->link)) :?>
                                                <img src="<?php echo PATH_PUBLIC.DS.'assets/chat_assets/' . $row->link?>" alt="">
                                            <?php endif?>

                                            <label for="#" style="font-size: .80em;"><?php echo time_since($row->created_at)?></label>
                                        </div>
                                        <?php if($chatBoxPos == 'pull-right') :?>
                                            <div class="col-md-2" style="text-align: right;">
                                                <img 
                                                    src="<?php echo $selfie?>" 
                                                        alt="" style="width: 45px;" class="user-image" data-target="<?php echo $row->sender_id?>">
                                            </div>
                                        <?php endif?>
                                    </div>
                                </div>
                            <?php endforeach?>
                        <?php endif ?>
                    </section>
                </div>

                <div class="card-footer">
                    <?php Form::open(['method' => 'post']) ?>
                    <?php
                        Form::hidden('gc_id', $req['groupId']);
                        Form::hidden('user_id', whoIs('id'));
                    ?>
                    <div class="row">
                        <div class="col-md-9">
                            <?php Form::text('chat', '', [
                                'class' => 'form-control',
                                'placeholder' => 'Send Message'
                            ])?>
                        </div>

                        <div class="col-md-3">
                            <label for="actual-btn" class="file-button" type="button" id="chooseFile" 
                                data-toggle="modal" data-target="#addAttachmentForm">Choose File</label>
                            <?php Form::submit('', 'Send', ['class' => 'btn btn-primary'])?>
                        </div>
                    </div>
                    <?php Form::close() ?>
                </div>
            </div>
        </div>
        <?php endif?>

        <?php if(!empty($req['groupId'])) :?>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Members</h4>
                        <a href="javascript:void(0)" type="button" data-toggle="modal" data-target="#addMemberForm">Add Member</a>
                    </div>

                    <div class="card-body">
                        <?php if(!empty($members)) :?>
                            <div>Total Members : <?php echo count($members)?> </div>
                            <div>Admin : <?php echo $group->admin_fullname?> </div>
                            <hr>
                            <?php foreach($members as $key => $row) :?>
                                <div>
                                    <?php echo $row->fullname?> (<?php echo $row->username?>) &nbsp; 
                                        <?php if($group->admin_id == whoIs('id') && $group->admin_id != $row->mem_id) :?>
                                            <a href="/ChatGroupController/removeMember/<?php echo $row->id?>" 
                                            style="text-decoration: underline;">X</a>
                                        <?php endif?>
                                </div>
                            <?php endforeach?>
                        <?php endif?>
                    </div>
                </div>
            </div>
        <?php endif?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
            Form::open([
                'method' => 'post',
                'action' => '/ChatGroupController/create'
            ]);
        ?>
            <div class="form-group">
                <?php
                    Form::label('Group Title');
                    Form::text('group_title', '', [
                        'class' => 'form-control',
                        'required' => true
                    ])
                ?>
            </div>

            <div class="form-group">
                <?php
                    Form::label('Add User');
                    Form::textarea('users_username', '', [
                        'class' => 'form-control',
                        'required' => true,
                        'placeholder' => 'Enter username eg. userA,userB'
                    ])
                ?>
            </div>

            <div class="form-group">
                <?php Form::submit('', 'Create Group', [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>
        <?php Form::close()?>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addMemberForm" tabindex="-1" role="dialog" aria-labelledby="addMemberForm" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMemberFormLabel">Add Member </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
            Form::open([
                'method' => 'post',
                'action' => '/ChatGroupController/addGroupMember'
            ]);

            Form::hidden('gc_id', $req['groupId']);
        ?>
            <div class="form-group">
                <?php
                    Form::label('Add User');
                    Form::textarea('users_username', '', [
                        'class' => 'form-control',
                        'required' => true,
                        'placeholder' => 'Enter username eg. userA,userB'
                    ])
                ?>
            </div>
            <!-- roel0423,mdcpangilinan,kristine -->
            <div class="form-group">
                <?php Form::submit('', 'Add Member', [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>
        <?php Form::close()?>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addAttachmentForm" tabindex="-1" role="dialog" aria-labelledby="addMemberForm" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAttachmentFormLabel">Attachment Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
            Form::open([
                'method' => 'post',
                'action' => '/ChatGroupController/addGroupMember'
            ]);
            Form::hidden('gc_id', $req['groupId'], ['id' => 'gcId']);
            Form::hidden('user_id', whoIs('id'), ['id' => 'userId']);
        ?>

        <div class="form-group">
            <input type="file" id="fileupload">
        </div>

        <section id="uploadImage" style="display: none;">
            <p>image images</p>
            <div id="imageDemo" style="width: 350px; margin-top:30px"></div>
            <button id="cropAndSave" type="button">Crop and Save</button>
            <button id="cropCancel" type="button">Cancel</button>
        </section>

        <div class="form-group mt-1 mb-1">
            <?php
                Form::label('Chat');
                Form::text('attachment_chat', '', [
                    'id' => 'attachmentChat',
                    'class' => 'form-control'
                ]);
            ?>
        </div>

        <?php Form::close()?>
      </div>
    </div>
  </div>
</div>

<?php endbuild()?>

<?php build('headers')?>
<link rel="stylesheet" href="/public/js/croppie/croppie.css" />
<?php endbuild()?>
<?php build('styles') ?>
    <style>
        #conversations{
            height: 50vh;
            overflow: scroll;
        }

        .file-button {
            background-color: indigo;
            color: white;
            padding: 0.5rem;
            font-family: sans-serif;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
        }

        .convo-item {
            width: 50%;
            padding: 5px;
            margin-bottom: 10px;
            display: block;
        }

        .pull-right{
            float: right;
            margin-right: 8px;
            clear: both;
        }

        .pull-left{
            float: left;
            margin-left: 8px;
            clear: both;
        }
    </style>
<?php endbuild()?>

<?php build('scripts') ?>
<script>
    $(document).ready(function(){
        var objDiv = document.getElementById("conversations");
        objDiv.scrollTop = objDiv.scrollHeight;
    });
</script>

<script src="/public/js/croppie/croppie.js"></script>
<script>
    $(document).ready(function() {
        let viewPortType = 'box';
        let viewPort = {
            type : 'box',
            width: 300,
            height: 500,
        };

        let sourceFor = $('#sourceFor');
        let postData = {
            userId : $('#userId').val(),
            gcId : $('#gcId').val()
        };

        $imageCrop = $('#imageDemo').croppie({
            enableExif : true,
            viewport: viewPort,
            boundary : {
                width: 400,
                height: 500
            }
        });

        $('#fileupload').on('change', function(){
            var reader = new FileReader();
            reader.onload = function(event) {
                $imageCrop.croppie('bind', {
                    url : event.target.result
                })
            }
            reader.readAsDataURL(this.files[0]);
            $("#uploadImage").show();
        });

        $('#cropAndSave').click(function(event){
            $imageCrop.croppie('result',{
                type: 'canvas',
                size: 'viewport'
            }).then(function(response){
                //append post data
                postData['image'] = response;
                postData['attachmentChat'] = $('#attachmentChat').val();
                
                $.ajax({
                    type: 'POST',
                    url : get_url('API_ImageUploaderController/addGroupChatImage'),
                    data : postData,
                    success : function(response) {
                        let responseData = JSON.parse(response);
                        window.location.reload();
                    }
                });
            });
        });

        $("#cropCancel").click(function(event){
            $("#uploadImage").hide();
        });

        $('#chooseFile').click(function(){
            $('#attachmentChat').val($('input[name="chat"]').val());
        })
       
    });

</script>
<?php endbuild()?>

<?php occupy()?>