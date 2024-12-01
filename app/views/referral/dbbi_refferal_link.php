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
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
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
         
           
          <div class="x_panel well">
              <h3 class="green">
                 <b>Left Position</b><br>
              <span id="r1">
                <?php echo $referral['url_left']?>
              </span>     
                &nbsp;&nbsp;&nbsp; <br>
              <button onclick="copyToClipboard('#r1')" class="btn btn-success btn-sm">Click to Copy URL</button>
                &nbsp;&nbsp;&nbsp; <br>
               <a  class="btn btn-success btn-sm" role="button" href="<?php echo $referral['url_left']?>" target="_blank">Click to Open URL</a>
                &nbsp;&nbsp;&nbsp; <br><br><br>
                
               <b>Right Position</b><br>
              <span id="r2">
                <?php echo $referral['url_right']?>
              </span> 
                &nbsp;&nbsp;&nbsp; <br>
                  <button onclick="copyToClipboard('#r2')" class="btn btn-success btn-sm">Click to Copy URL</button>

                  &nbsp;&nbsp;&nbsp; <br>
                  <a  class="btn btn-success btn-sm" role="button" href="<?php echo $referral['url_right']?>" target="_blank">Click to Open URL</a>
                  <script>
                      function copyToClipboard(element) {
                          var $temp = $("<input>");
                          $("body").append($temp);
                          $temp.val($(element).text()).select();
                          document.execCommand("copy");
                          $temp.remove();
                      }
                  </script>
              </h3>
          </div>

          <section class="x_panel">
            <section class="x_content">
              <h3>Referrals</h3>
              <table id="customers">
                <th>Username</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Email</th>
  

              <tbody>
                <?php foreach($pre_register_dbbi as $list) :?>
                  <tr>
                   <td><?php echo $list->username; ?></td>
                    <td><?php echo $list->firstname.' '.$list->middlename.' '.$list->lastname; ?></td>
                    <td><?php echo $list->phone; ?></td>
                    <td><?php echo $list->address; ?></td>
                    <td><?php echo $list->email; ?></td>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
            </section>
          </section>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>