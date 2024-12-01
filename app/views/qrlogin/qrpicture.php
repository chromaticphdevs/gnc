<?php build('content')?>    

    <div style="text-align:center">
        <?php Flash::show()?>
        <img src="#" alt="qr-login-token" id="image" style="display: block; margin:0px auto;">
        <small id="token"></small>
    </div>
    <script src="<?php echo URL?>/js/core/conf.js"></script>
	<script src="<?php echo URL?>/js/core/jquery.js"></script>
<?php endbuild()?>


<?php build('scripts')?>
    <script>
        $(document).ready(function(){
            var urlCreateNewQR = "<?php echo URL?>" + '/QRLogin/createNewQR';
            //init
            getLatest();

            setInterval(function(){
                getLatest();
            }, 5000);

            function getLatest() {
                $.ajax({
                    url : get_url('QRLogin/getLatest'),
                    success : function(response) {
                        console.log(response);
                        let reponseData = JSON.parse(response);
                        $("#image").attr("src",reponseData.src_url);
                        $("#token").html(window.btoa(reponseData.token));
                    }
                });
            }
        })
    </script>
<?php endbuild()?>


<?php occupy('templates/tmp/landing')?>