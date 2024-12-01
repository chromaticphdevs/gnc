

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

        <form action="/RandomUserPicker/export" method="post">
            <input type="hidden" name="users" 
                value="<?php echo base64_encode(serialize($users))?>">

            <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
        </form>
            <a href="/RandomUserPicker/winners_list"><input type="button" class="btn btn-primary btn-sm" value="View Winners"></a>
            <br>
            <h2>Total users : <b style="color: green;"><?php echo $fetchedCount?></b></h2>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <h2>Random Pick User</h2> <h1><div style="color: #00802b;" id="user_info"></div></h1>

              <div style="overflow-x:auto;">
              <table id="users">
                 <thead>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>System ID</th>
                </thead>

                <tbody>
                    <?php $start = 2601;?>
                    <?php foreach($users as $key => $row) :?>
                    <tr>
                        <td><?php echo $start++?></td>
                        <td><?php echo $row->firstname?></td>
                        <td><?php echo $row->lastname?></td>
                        <td><?php echo $row->username?></td>
                        <td><?php echo $row->systemid?></td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
             </div>
            </section>
          </section>
        </div>
        <!-- page content -->



 <script type="text/javascript" defer>

   var pick_user;
  $( document ).ready(function(){

       pick_user = setInterval(get_random_user ,30000);   

    });


      function get_random_user()
      { 
        $.ajax({
          method: "POST",
          url: get_url('/RandomUserPicker/get_random_admin'),
          success:function(response)
          {
 
              console.log(response);
              reponse = JSON.parse(response);


              document.getElementById("user_info").innerHTML = reponse.info;
              
              return false;     

          }
        });
       
      }

 
 

  </script>       
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>