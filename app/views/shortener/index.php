<?php build('content') ?>
    <div class="card">
        <div class="text-center">
            <?php echo wCardHeader(wCardTitle('Validating your link')) ?>
        </div>
        <div class="card-body">
            <div class="text-center">
                <h3>If your link is valid you will be redirected to registration page.</b></h3>
                <div style="margin-top: 50px;"><div class="loader" style="margin: 10px auto;"></div></div>
                <h1 id="countdown" class="mt-5" data-link="<?php echo $short->redirect_link?>">Validating your link</h1>
            </div>
        </div>
    </div>
<?php endbuild() ?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            let countdownElement = $('#countdown');
            let countdownMax = 2;
            let link = countdownElement.data('link');

            var interval = setInterval(function(){
                countdownMax--;
                countdownElement.html(countdownMax + ' ' + '..');
                if(countdownMax < 1) {
                    clearInterval(interval);
                    countdownElement.html('Redirecting to registration page...');
                    if(link != '') {
                        setTimeout(function() {
                            window.location.href = link;
                        }, 1000);
                    } else {
                        confirm('invalid link');
                    }
                }
            }, 1000);
        });
    </script>
<?php endbuild()?>

<?php build('headers') ?>
    <style>
        .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
    </style>
<?php endbuild()?>

<?php occupy('templates/baselayout') ?>