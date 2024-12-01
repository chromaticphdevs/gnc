<?php build('content') ?>
<div class="container-fluid">
    <?php echo wControlButtonLeft('ID Upload', [
        $navigationHelper->setNav('', 'Back', '/UserIdVerification/upload_id_html')
    ])?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Please Upload ID as much as Possible the Clearest Image'))?>
        <div class="card-body">
            <h1><?php echo $idType?></h1>
            <?php if($uploadedId && !isEqual($uploadedId->status, 'deny')) :?>
                <a class="btn btn-danger mb-5" href="/UserIdVerification/cancel_id/<?php echo $uploadedId->id; ?>">Cancel This ID</a>
            <?php endif?>
            <?php Flash::show()?>
            <form enctype="multipart/form-data">
                <input type="hidden" name="ID_type" 
                    value="<?php echo $_GET['type']; ?>" id="idType">

                <input type="hidden" name="userId" 
                    value="<?php echo whoIs()['id']; ?>" id="userId">
                
                <div class="form-group">
                    <h4><b>Front side of ID</b></h4>
                    <input type="file" class="form-control fileImage" name="front_id" data-facing = "FRONT">
                    <?php if(!empty($uploadedId->id_card ?? '') && !isEqual($uploadedId->status, 'deny')) :?>
                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$uploadedId->id_card?>" alt="" width="100%" class="mt-3">
                    <?php endif?>
                </div>
                <br>
                    <section id="uploadImage" style="display: none;">
                        <div class="alert alert-info"><p>Rotate Your Screen, for better image resize</p></div>
                        <div id="imageDemo" style="width: 350px; margin-top:30px"></div>
                        <div id="cropControls">
                            <button id="cropAndSave">Crop and Save</button>
                            <button id="cropCancel">Cancel</button>
                        </div>
                    </section>
                <br>
                <div class="form-group">
                    <h4><b>Back side of ID</b></h4>
                    <input type="file" class="form-control fileImage" name="back_id" data-facing = "BACK">
                    <?php if(!empty($uploadedId->id_card_back ?? '') && !isEqual($uploadedId->status, 'deny')) :?>
                        <img src="<?php echo URL.DS.'assets/user_id_uploads/'.$uploadedId->id_card_back?>" alt="" width="100%" class="mt-3">
                    <?php endif?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php build('headers') ?>
<link rel="stylesheet" href="/public/js/croppie/croppie.css" />
<style>
    #uploadImage {
        background-color: #eee;
        padding: 10px;
        color: #000;
        font-weight: bold;
    }
</style>
<?php endbuild()?>
<?php build('scripts') ?>
<script src="/public/js/croppie/croppie.js"></script>
<script>
    $(document).ready(function() {
        let viewPortType = 'circle';
        let viewPort = {
            type : 'box',
            width: 450,
            height: 300,
        };

        let postData = {
            sourceFor : 'validId',
            userId : $('#userId').val(),
            returnURL : $('#returnURL').val(),
            idType : $("#idType").val()
        };


        $imageCrop = $('#imageDemo').croppie({
            enableExit : true,
            viewport: viewPort,
            enableResize: true,
            enableOrientation: true,
            boundary : {
                width: 450,
                height: 300
            }
        });

        $('.fileImage').on('change', function(){
            postData['facing'] = $(this).data('facing');

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
            event.preventDefault();

            $('#cropControls').html('uploading image please wait ....');

            $imageCrop.croppie('result',{
                type: 'canvas',
                size: 'viewport'
            }).then(function(response){
                //append post data
                postData['image'] = response;
                console.log(postData);

                $.ajax({
                    type: 'POST',
                    url : get_url('API_ImageUploaderController/uploadImage'),
                    data : postData,
                    success : function(response) {
                        let responseData = JSON.parse(response);
                        console.log(responseData);
                        if(responseData['status']) {
                            if(postData['returnURL']) {
                                window.location.href = postData['returnURL'];
                            } else {
                                //refresh page
                                location.reload();
                            }
                        }
                    }
                });
            });
        });

        $("#cropCancel").click(function(event){
        event.preventDefault();
            $("#uploadImage").hide();
        });
    });

</script>
<?php endbuild()?>
<?php occupy()?>