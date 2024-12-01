<?php include_once VIEWS.DS.'templates/users/header.php' ;?>

<style>
table {

  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1.5px solid #ddd;

  height: 500px;
  overflow-y: scroll;

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
                <a href="/">
                    <?php echo logo()?>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- profile quick info -->
<?php include_once VIEWS.DS.'templates/users/profile_bar.php' ;?>
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

        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 524px;">
            <?php Flash::show()?>

          <div class="ui grid">
 
      <div class="twelve wide column">
        <h3>Create Activation Code</h3>
        <div class="ui segment">
          <!-- activation_form_container -->
          <section class="ui segment" id="activation_form_container">
            <form class="ui form" method="post" action="/Activation/create_code">

          
                <label>Products</label>
                <select name="productID"  class="form-control">
                    <option value="66">
                      DBBI(Starter)&nbsp;P1000.00
                      </option>
                        <option value="33">
                        DBBI&nbsp;P1600.00 
                      </option>
                      <?php foreach($productList as $productList) :?>
                        <option value="<?php echo $productList->id;?>">
                          <?php echo $productList->name;?>&nbsp;&nbsp;&nbsp;P<?php echo $productList->price;?>
                        </option>
                    <?php endforeach;?>
               </select>
            

           
                <input type="hidden" name="userType" class="form-control" 
                value="<?php echo $user_session['type']; ?>" readonly>

                <input type="number" class="form-control" name="numbers_of_code" value="1" required>
         
              <!--<div class="field">
                <label>Enter Expiration Date</label>
                    <input type="date" class="form-control" name="exp_date" required>
              </div>-->
 
                <br>
                  <label for="#">Branch</label>
                  <select name="branch"  class="form-control" >
                           <?php foreach($branchList as $branch) : ?>
                               <option value="<?php  echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option> 
                           <?php endforeach;?>
                    </select><br>
           

                <div class="field">
                  <label for="#">Company</label>
                  <select name="company" id=""   class="form-control" required>
                    <option value="">--Select Company</option>
                    <option value="sne">Social Network</option>
                    <option value="dbbi">DBBI</option>
                  </select>
                </div><br>
          

              <button class="btn btn-primary btn-sm" type="submit">Generate Code</button> 
              </form>
          </section>
          <!--// activation_form_container -->
          
          <section class="ui segment">
            <h3>Generated Code</h3>
           <div style="overflow-x:auto;">
              <table id="customers">
              <thead>
                <th>#</th>
                <th>Code</th>
                <th>Company</th>
                <th>Binary</th>
                <th>Drc</th>
                          <th>Unilvl</th>
                          <th>Price</th>
                          <th>Distribution</th>
                          <th>Max Pair</th>
                          <th>branch</th>
                          <th>Status</th>
              </thead>

              <tbody>
                <?php foreach($activation_code_list_unused as $key => $row) :?>
                  <tr>
                    <td><?php echo ++$key?> </td>
                    <td><?php echo $row->activation_code?></td>
                    <td><?php echo strtoupper($row->company ?? 'un-tag')?></td>
                    <td><?php echo $row->binary_pb_amount?></td>
                    <td><?php echo $row->drc_amount?></td>
                    <td><?php echo $row->unilvl_amount?></td>
                    <td><?php echo $row->price?></td>
                    <td><?php echo $row->com_distribution?></td>
                    <td><?php echo $row->max_pair?></td>
                    <td><?php echo $row->branch_id?></td>
                    <?php if($row->status=="Unused"): ?>
                                  <td><span class="label label-warning"><?php echo $row->status ?></span></td>
                        <?php else:?>
                        <td><span class="label label-success"><?php echo $row->status ?></span></td>  
                        <?php endif;?>
                  </tr>
                <?php endforeach?>
              </tbody>
            </table>
          </div>
          </section>

          <!-- used codes
          <section class="ui segment">

            <table id="table-data7" class="ui celled table">
              <thead>
                <th>#</th>
                <th>Code</th>
                <th>Company</th>
                <th>Binary</th>
                <th>Drc</th>
                          <th>Unilvl</th>
                          <th>Price</th>
                          <th>Distribution</th>
                          <th>Max Pair</th>
                          <th>Status</th>
              </thead>

              <tbody>
                <?php foreach($activation_code_list_used as $key => $row) :?>
                  <tr>
                    <td><?php echo ++$key?> </td>
                    <td><?php echo $row->activation_code?></td>
                    <td><?php echo  strtoupper($row->company ?? 'un-tag') ?></td>
                    <td><?php echo $row->binary_pb_amount?></td>
                    <td><?php echo $row->drc_amount?></td>
                    <td><?php echo $row->unilvl_amount?></td>
                    <td><?php echo $row->price?></td>
                    <td><?php echo $row->com_distribution?></td>
                    <td><?php echo $row->max_pair?></td>
                      <?php if($row->status=="Unused"): ?>
                                  <td><span class="label label-warning"><?php echo $row->status ?></span></td>
                        <?php else:?>
                        <td><span class="label label-success"><?php echo $row->status ?></span></td>  
                        <?php endif;?>
                  </tr>
                <?php endforeach?>
              </tbody>
            </table>
          </section>-->
        </div>
      </div>
    </div>
        </div>
        <!-- page content -->
<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>
