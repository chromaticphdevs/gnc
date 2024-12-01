<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style type="text/css" media="print">
            @page 
            {
                size: auto;   /* auto is the main current active printer page size */
                margin: 0mm;  /* this small affects the margin in the printer IMP settings */
            }

            @page :footer { 
                display: none
            } 

            @page :header { 
                display: none
            } 

            body 
            {
                background-color:#FFFFFF; 
                border: solid 1px black ;
                margin: 0px;  /* the margin style on the data content before printing */
        }
        </style>
</head>
<body>
    <table cellpadding="5px" style="border-collapse: collapse;" align="center">  
        <?php 
            $printTr = 'open';
            $tableTD = 0;
        ?>
        <?php foreach($codes as $key => $row) :?>
            <?php
                if( $tableTD == 0) 
                    echo '<tr>';
            ?>
            <td style=" border:2px solid #000" align="center">
                <div style="display: inline-block;font-family:Arial, Helvetica, sans-serif;font-size:6pt; margin-bottom:15px">
                    <label for="#">SCAN TO REGISTER</label>
                    <div style="margin: 0px;"><img src="<?php echo $row->image_url?>" alt="" 
                    style="display:block; width:60px;padding:0px;margin:0px"></div>
                    <label for="#" style="font-weight: bold;">RISE-HERBAL COFFEE</label>
                </div>
            </td>
            <?php
                $tableTD++;

                if( $tableTD == 8){
                    echo '</tr>';
                    $tableTD = 0;
                }
            ?>
        <?php endforeach?>
    </table>
    <script>
        window.print();
    </script>
</body>
</html>