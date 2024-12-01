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
             <h1>Current Active Address:<b style="color:green;"> <?php echo $active_cop?></b></h1>
              <div class="x_panel">
                <div class="x_content">
                  <!--<div class="col-md-4">-->

                <h2>Nearest LBC Address</h2>
                  <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Address</th>
                        <th>Action</th>
                      </thead>
                      <b>
                      <tbody>
                        <?php foreach($addresses as $key => $row) :?>

                          <?php if($row->type == "COP"):?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><h4><?php echo $row->address?>
                                  <br><br><a class="btn btn-info" href="/AccountProfile/select_cop/?id=<?php echo seal($row->id)?>&type=cop&user=<?php echo seal($user_info->id); ?>"  id="select_add">Select this as my Primary Shipping Address</a>
                            </h4></td>
                            <td>  
                                  <a class="btn btn-danger btn-sm" href="/AccountProfile/remove_address/<?php echo $row->id?>"  id="remove">Remove</a>
                            </td>
                          </tr>
                        <?php endif; ?>
                        <?php endforeach?>

                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                                  <?php
                                    Form::open([
                                      'method' => 'post',
                                      'action' => '/AccountProfile/add_cop'
                                    ]);
                                      Form::textarea('cop_address','',[
                                        'required' => '',
                                        'placeholder' => 'Enter Nearest LBC Address',
                                        'rows' => 7
                                      ]);
                                      Form::hidden('userid' , $user_info->id);
                                      echo "&nbsp;";   
                                      echo "&nbsp;";                       
                                      Form::submit('' , 'Add COP Address' , [
                                        'class' => 'btn btn-sm btn-primary'
                                      ]);
                                    Form::close();
                                  ?>
                            </td>
                          </tr>

                      </tbody>
                      </b>
                    </table>

                    <br><br> <br> <br> <br>
                   
                        <li class="list-group-item"><b>Shipping Address :  <h4><?php echo $user_info->address?></h4></b>
                        <br>  <a class="btn btn-info" href="/AccountProfile/select_cop/?id=<?php echo seal($row->id); ?>&type=main&user=<?php echo seal($user_info->id); ?>"  id="select_add">Select this as my Primary Shipping Address</a>
                        </li>

                        <li class="list-group-item" style="text-align: center;">
                        <a class="btn btn-success btn-sm" href="/AccountProfile/update_address/?user=<?php echo $user_info->id?>&address=<?php echo str_replace('#', '', $user_info->address); ?>" >EDIT</a>  
                        </li>

                 <!-- </div>

                  <div class="col-md-8">-->
                   <!-- <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Address</th>
                        <th>Action</th>
                      </thead>
                      <b>
                      <tbody>
                        <?php foreach($addresses as $key => $row) :?>

                          <?php if($row->type != "COP"):?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><h4><?php echo $row->address?>|</h4></td>
                            <td>
                               <a class="btn btn-info btn-sm" href="/AccountProfile/update_main_address/?id=<?php echo $row->id?>&userid=<?php echo $user_info->id?>"  id="main">Select</a>
                                 <!--<a class="btn btn-success btn-sm" href="/AccountProfile/update_address/?user=<?php echo $row->id?>&address=<?php echo str_replace('#', '', $row->address); ?>" >Edit</a>-->
                                  <a class="btn btn-danger btn-sm" href="/AccountProfile/remove_address/<?php echo $row->id?>"  id="remove">Remove</a>
                            </td>
                          </tr>
                        <?php endif; ?>
                        <?php endforeach?>
                      </tbody>
                      </b>
                    </table>
                    <?php if(count($addresses) < 4): ?>
                                <li class="list-group-item" style="text-align: center;">
                                <a  class="btn btn-success btn-sm" href="/AccountProfile/add_address/?user=<?php echo $user_info->id?>" >Add Shipping Address</a>  
                                </li>   
                    <?php endif;?>
                    <br> <br><br>-->
         

                      
                  </div>
                </div>
              </div>
            </div>


<script defer>
  $( document ).ready(function() {

     $("#remove").on('click' , function(e)
    {
       if (confirm("Remove this Address?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

    $("#main").on('click' , function(e)
    {
       if (confirm("Make this Address as Shipping Address?"))
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

