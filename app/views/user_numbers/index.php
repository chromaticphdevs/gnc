<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
<style>
  .userinfo-ajax{
    border: 1px solid #000;
    cursor: pointer;
  }

  .userinfo-ajax:hover{
    background: green;
    color: #000;
  }
</style>
</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 524px;">

            <?php Flash::show()?>
             <h1>Mobile Numbers</h1>

              <div class="x_panel">
                <div class="x_content">
                  <div class="col-md-4">
                    <br>
                   
                        <li class="list-group-item"><h2><b>Primary Mobile Number:</h2><h1 style="color: green;">  <?php echo $user_info->mobile?></h1></b></li>
                       

                        <!--<li class="list-group-item" style="text-align: center;">
                        <a class="btn btn-success btn-sm" href="/UserNumber/update_number/?user=<?php echo $user_info->id?>&number=<?php echo $user_info->mobile; ?>" >EDIT</a>  
                        </li>-->

                  </div>

                  <div class="col-md-8">
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Number</th>
                        <th>Network</th>
                        <th>Action</th>
                      </thead>
                      <b>
                      <tbody>
                        <?php foreach($numbers as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><h4><?php echo $row->number?></h4></td>
                            <td><?php echo sim_network_identification($row->number); ?></h4></td>
                            <td>
                              <?php if(!$row->verified): ?>

                                    <a class="btn btn-warning btn-sm" href="/UserNumber/send_code/?number=<?php echo $row->number?>&id=<?php echo seal($row->id)?>"  >Verify</a>
                                 
                              <?php else: ?>
                                 
                                     <a class="btn btn-info btn-sm" href="/UserNumber/update_main_number/?id=<?php echo seal($row->id) ?>&userid=<?php echo seal($user_info->id)?>"  id="main">Select</a>   
                                  
                              <?php endif; ?>

                                 <a class="btn btn-danger btn-sm" href="/UserNumber/remove_number/<?php echo seal($row->id); ?>"  id="remove">Remove</a>
                               
                            </td> 
                          </tr>
                        <?php endforeach?>
                      </tbody>
                      </b>
                    </table>
                    <?php if(count($numbers) < 4): ?>
                                <li class="list-group-item" style="text-align: center;">
                                <a  class="btn btn-success btn-sm" href="/UserNumber/add_number/?user=<?php echo seal($user_info->id); ?>" >Add Mobile Number</a>  
                                </li>   
                      <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>


<script defer>
  $( document ).ready(function() {

     $("#remove").on('click' , function(e)
    {
       if (confirm("Remove this Number?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

    $("#main").on('click' , function(e)
    {
       if (confirm("Make this Number as Primary Number?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

  });


</script>
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>

