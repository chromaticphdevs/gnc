<?php build('content') ?>
    
<?php endbuild()?>

<?php build('scripts') ?>
<script type="text/javascript" src="<?php echo URL.'/datatables/jquery_main.js'?>"></script>
<script type="text/javascript" src="<?php echo URL.'/datatables/main.js'?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {


        $('#dataTable').DataTable({
          "pageLength": 5,
          "bLengthChange": false,
          "bInfo": false,
          "bFilter": true,
           "bPaginate": false,
           "ordering": false
        } );

         

      $(document).on('click', '#readings', function()
      { 
         var meter_value=$(this).data("meter_value");
            
         var before = document.getElementById("before").value
         var after = document.getElementById("after").value

            if(before == "" || before == 0 )
            {
               document.getElementById("before").value = meter_value;

            }else if((before != "" && after == "" ) || (before != 0 && after == 0)){

               document.getElementById("after").value = meter_value;

               var difference = before - meter_value;

               document.getElementById("answer").innerHTML = difference.toFixed(2);
            }

      });

      //reset computation
      $(document).on('click', '#reset', function()
      { 
           document.getElementById("before").value = "0";
           document.getElementById("after").value = "0";
           document.getElementById("answer").innerHTML = "0";
      });


    });
</script>



<?php endbuild()?>

<?php build('headers')?>
<link rel="stylesheet" type="text/css" href="<?php echo URL.'/'?>datatables/datatables.min.css">
<?php endbuild()?>
<?php occupy('templates/layout')?>