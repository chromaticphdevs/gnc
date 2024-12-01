<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <?php echo wCardHeader(wCardTitle('Signature')) ?>
            <div class="card-body">
                <?php Form::hidden('userid', whoIs('id'))?>
                <canvas id="esig"></canvas>
                <a href="#" id="sigClear">Clear Signature</a>

                <div class="mt-5"><button id="sigSave" class="btn btn-primary btn-sm">Save Sig</button></div>
            </div>
        </div>
    </div>
<?php endbuild() ?>

<?php build('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    $(document).ready(function(){
        const canvas = document.getElementById("esig");
        const signaturePad = new SignaturePad(canvas, {
            minWidth: 1,
            maxWidth: 3,
            penColor: "rgb(0,0,0)"
        });

        signaturePad.addEventListener("beginStroke", () => {
            console.log("Signature started");
        }, { once: true });

        $('#sigSave').click(function(){
            let signatureImageEncoded = signaturePad.toDataURL();

            if(signaturePad.isEmpty()) {
                alert('Signature cannot be empty');
                return;
            }

            $.ajax({
                url : get_url('API_ImageUploaderController/uploadImage'),
                type : 'POST',
                data : {
                    sourceFor : 'esig',
                    userId : $("input[name='userid']").val(),
                    image : signatureImageEncoded,
                },
                success : function(response) {
                    alert('Signature Update');
                    window.location.href = '/AccountProfile/index';
                }
            });
        });

        $("#sigClear").click(function(){
            signaturePad.clear();
        });
    })
</script>
<?php endbuild()?>

<?php build('headers')?>
<style>
    #esig{
        border: 1px solid #000;
        width: 100%;
        max-width: 350px;
    }
</style>
<link rel="stylesheet" href="<?php echo URL.'/public/js/esig/esig.css'?>">
<?php endbuild()?>
<?php occupy() ?>