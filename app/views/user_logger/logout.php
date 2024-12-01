

<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1.5px solid #ddd;
}

th, td {
  text-align: left;
  padding: 4px;
}

tr:nth-child(even){background-color: #f2f2f2}
#users {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#users td, #users th {
  border: 1px solid #ddd;
  padding: 8px;
}

#users tr:nth-child(even){background-color: #f2f2f2;}

#users tr:hover {background-color: #ddd;}

#users th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center">
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
            <?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
            <!-- /menu profile quick info --> 
            <?php include_once VIEWS.DS.'templates/users/side_bar.php' ;?>
            <br>
          </div>
        </div>      
        <?php include_once VIEWS.DS.'templates/users/top_nav.php' ;?>
        <div class="right_col" role="main" style="min-height: 524px;">
            <br>
          <section class="x_panel">
            <section class="x_content">

   
              <a href="/UserLogger/get_user_login"><input type="button" class="btn btn-primary btn-sm" value="View Login list"></a>
              <br>
    

              <div style="overflow-x:auto;">
              <table id="users">
                 <thead>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>System ID</th>
                    <th>Date & time</th>
                </thead>

                <tbody>
                    <?php $start = 1;?>
                    <?php foreach($userList as $key => $row) :?>
                    <tr>
                        <td><?php echo $start++?></td>
                        <td><?php echo $row->firstname?></td>
                        <td><?php echo $row->lastname?></td>
                        <td><?php echo $row->username?></td>
                        <td><?php echo $row->userid?></td>
                        <td>
                          <?php
                              $date=date_create($row->date_time);
                              echo date_format($date,"M d, Y");
                              $time=date_create($row->date_time);
                              echo date_format($time," h:i A");
                            ?>
                        </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
             </div>
            </section>
          </section>
        </div>
        <!-- page content -->

     
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>