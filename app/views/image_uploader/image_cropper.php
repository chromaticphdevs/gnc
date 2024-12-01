<?php build('content') ?>
<div class="container-fluid">
    <div class="col-md-5 mx-auto">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo $returnURL?>">Back to last page</a>
                <h4 class="card-title">Fit your image</h4>
            </div>

            <div class="card-body">
                <?php
                    Form::open([
                        'method' => ''
                    ]);

                    Form::hidden('', $userId, [
                        'id' => 'userId'
                    ]);

                    Form::hidden('', $sourceFor, [
                        'id' => 'sourceFor'
                    ]);

                    Form::hidden('', $returnURL, [
                        'id' => 'returnURL'
                    ]);

                    Form::hidden('', $sourceId, [
                        'id' => 'sourceId'
                    ])
                ?>
                    <div class="form-group">
                        <input type="file" id="fileupload">
                    </div>
                <?php Form::close()?>

                <section id="uploadImage" style="display: none;">
                    <p>image images</p>
                    <div id="imageDemo" style="width: 350px; margin-top:30px"></div>
                    <button id="cropAndSave">Crop and Save</button>
                    <button id="cropCancel">Cancel</button>
                </section>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>

<?php build('headers') ?>
<link rel="stylesheet" href="/public/js/croppie/croppie.css" />
<?php endbuild()?>
<?php build('scripts') ?>
<script src="/public/js/croppie/croppie.js"></script>
<script>
    $(document).ready(function() {
        let viewPortType = 'box';
        let viewPort = {
            type : 'box',
            width: 350,
            height: 200,
        };

        let sourceFor = $('#sourceFor');
        let postData = {
            sourceFor : sourceFor.val(),
            userId : $('#userId').val(),
            returnURL : $('#returnURL').val(),
            sourceId : $('#sourceId').val(),    
        };

        if(sourceFor.val() == 'profilePicture') {
            viewPort['type'] = 'circle';
            viewPort['width'] = 200;
            viewPort['height'] = 200;
        } else if(sourceFor.val() == 'cash_advance_payment_proof') {
            viewPort['width'] = 300;
            viewPort['height'] = 500;
        }

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
                            }
                        }
                    }
                });
            });
        });

        $("#cropCancel").click(function(event){
            $("#uploadImage").hide();
        });
    });

</script>
<?php endbuild()?>
<?php occupy()?>