<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<?php require_once VIEWS.DS.'lending/template/header.php'?>
 
  <script defer src="<?php echo URL.DS.'js/face-api.min.js'?>"></script>
  <script defer src="<?php echo URL.DS.'js/face_script.js'?>"></script>
  <input type="hidden" id="full_name" value="<?php echo $_GET['name'];?>">
  <input type="hidden" id="pic_temp" value="<?php echo $_GET['image_name'];?>">
  <input type="hidden" id="path" value="<?php echo URL.DS.'js/models'?>">
  <title>Face Recognition</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column
    }

    canvas {
      position: absolute;
      top: 0;
      left: 0;
    }
  </style>
</head>

<body>
<h2 id="status">Loading Image...</h2>

</body>
</html>