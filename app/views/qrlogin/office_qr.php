<?php build('content')?>
    <div style="text-align:center">
        <img src="#" alt="qr-login-token" id="image" style="display: block; margin:0px auto;">
        <small id="token"></small>
    </div>
    <script src="<?php echo URL?>/js/core/conf.js"></script>
	<script src="<?php echo URL?>/js/core/jquery.js"></script>
    <script>
        const min = 10000;
        const max = 99999;

        let images = [
            'https://i.pinimg.com/564x/68/12/46/681246b04458bbb03a7120b68c0bad01.jpg',
            'https://keepthetech.com/wp-content/uploads/2020/12/picture-30.jpg',
            'https://www.eventstodayz.com/wp-content/uploads/2017/09/profile-images.jpg',
            'https://preview.redd.it/vgxt73hiiwn41.png?auto=webp&s=b2e90a814c6772169597ebf42722a94a36b849d4',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrYaGfdyEyn-TPKIf5i-mf-9xbwj4HQ4FQjw&usqp=CAU',
        ];
        setInterval(function(){
            $.ajax({
                url : get_url('QRTokenLogin/getLastest'),
                success : function(response) {
                    console.log(response);
                    $("#image").attr('src', response.src_url);
                    $("#token").html(window.btoa(response.token));
                }
            })
        }, 2000);
    </script>
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>