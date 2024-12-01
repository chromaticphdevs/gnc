<?php build('content') ?>

<button id="submit">
    Do Ajax
</button>

<?php endbuild()?>



<?php build('scripts')?>
<script defer>

    $( document ).ready(function(evt) {

        $("#submit").click(function(evt) {
            $.ajax({
                method:'post',
                action : get_url('SampAjax/store'),
                data : {id : '123'} ,

                success : function(response) {

                    console.log(response);
                }
            });
        })
        
    });

</script>
<?php endbuild()?>


<?php occupy('templates.layout');