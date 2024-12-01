<?php build('content')?>
    <h1> TEST ACCOUNT </h1>

    <button id="btn">
        Request Ajax
    </button>
<?php endbuild()?>


<?php build('scripts') ?>
<script defer>
    $( document ).ready(function(evt) {

        $("#btn").click(function(evt) {

            let myURL = get_url('test/store');


            /**
             * AJAX POST CALL 
             */
            

            // $.post(myURL , {
            //     passData:'passdata'
            // }, function(response) {

            //     console.log(response)
            // })

            /** */
            

            /**
             * AJAX CUSTOM AJAX CALL
             */
            $.ajax({
                method : 'POST',
                url : myURL,
                data   : {passData:'passdata'},

                success: function(response) {
                    console.log(response);
                } 
            })
            /** */
        });
        
    });
</script>
<?php endbuild()?>

<?php occupy('templates.layout')?>
