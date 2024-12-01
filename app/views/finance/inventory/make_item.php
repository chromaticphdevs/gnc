<?php include_once VIEWS.DS.'templates/users/header.php' ;?>
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
            <h3>Branch Item Inventory</h3>
            <?php Flash::show()?>

            <div class="row">
              
                    <div class="x_panel">   
                        <div class="x_content">
                        <h3>Add / Deduct Inventory</h3>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="#">Select Branch</label>
                                <select name="branchid" id="" class="form-control" required>
                                    <option value="">--Select Branch</option>
                                    <?php foreach($branches as $key => $row) :?>
                                        <option value="<?php echo $row->id?>">
                                            <?php echo $row->name?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="#">Products</label>
                                <?php
                                    Form::select('product_id' , 
                                    arr_layout_keypair($products , 'id' , 'name') , '' , [
                                        'class' => 'form-control'
                                    ]);
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="#">Quantity</label>
                                <input type="text" name="quantity" class="form-control" placeholder="Quantity">
                                <small>Must be a number</small>
                            </div>

                            <div class="form-group">
                                <label for="#">Description</label>
                                <textarea name="description" id="" rows="3" 
                                    class="form-control"></textarea>
                            </div>

                            <input type="submit" class="btn btn-primary btn-sm" value="Make Item">
                        </form>           
                        </div>
                    </div>

                      <div class="x_panel">
                        <div class="x_content">
                            <h3>Total Stocks</h3>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Branch</th>
                                    <th>Quantity</th>
                                </thead>

                                <tbody>
                                    <?php foreach($total_items as $key => $row) :?>
                                        <tr>
                                            <td><?php echo ++$key?></td>
                                            <td><a href="/FNItemInventory/get_branch_inventory_all/<?php echo $row->branch_id?>"><?php echo $row->branch_name?> </a></td>
                                            <td><?php echo $row->total_qty?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
           

      

                             <label for="#">Select Branch</label>
                                <select name="branchid" id="branchid"class="form-control" onchange="get_logs_by_branch()" required>
                                    <option value="all_logs" >All Logs</option>
                                    <?php foreach($branches as $key => $row) :?>
                                        <option value="<?php echo $row->id?>">
                                            <?php echo $row->name?>
                                        </option>
                                    <?php endforeach;?>
                                </select>


                    <div id="logs_by_branch">
                        <div class="x_panel">
                            <div class="x_content">
                                <h3>Stock Logs</h3>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Branch</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Name</th>
                                        <th>Date & Time</th>
                                        <th>Description</th>
                                    </thead>

                                    <tbody>
                                        <?php foreach($items as $key => $row) :?>
                                            <tr>
                                                <td><?php echo ++$key?></td>
                                                <td><?php echo $row->branch_name?></td>
                                                <td>
                                                    <?php echo $row->p_name ?? 'Not Available on previous Version'?>
                                                </td>
                                                <td><?php echo $row->quantity?></td>
                                                <td style="width: 200px;"><?php echo $row->fullname?></td>
                                                <td style="width: 200px;"><?php   

                                                $date=date_create($row->created_at);
                                                echo date_format($date,"m/d/Y");

                                                $time=date_create($row->created_at);
                                                echo date_format($time," h:i A");

                                                ?></td>
                                                <td style="width: 400px;"><?php echo $row->description?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                     </div>
          
            </div>
        </div>
        <!-- page content -->


    <script type="text/javascript">
            
            function get_logs_by_branch()
            {
                var e2 = document.getElementById("branchid");
                var branchId = e2.options[e2.selectedIndex].value;

                $.ajax({
                  method: "POST",
                  url: '/FNItemInventory/get_logs_by_branch',
                  data:{branchId: branchId},
                  success:function(response)
                  {

                    reponse = JSON.parse(response);

                    let table_data = ``;

                    let table_header =  `<div class="x_panel">
                            <div class="x_content">
                                <h3>Stock Logs</h3>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Branch</th>
                                        <th>Quantity</th>
                                        <th>Name</th>
                                        <th>Date & Time</th>
                                        <th>Description</th>
                                    </thead>

                                    <tbody>`; 


                    let table_footer =  `</tbody>
                                        </table>
                                         </div>
                                        </div>`;  


                    $.each(reponse , function(index , value) {

                        table_data += ` <tr>
                                            <td>${++index}</td>
                                            <td>${value.branch_name}</td>
                                            <td>${value.quantity}</td>
                                            <td style="width: 200px;">${value.fullname}</td>
                                            <td style="width: 200px;">${value.created_at}</td>
                                            <td style="width: 400px;">${value.description}</td>
                                    
                                        </tr>`;
    
                    }); 

                    let html = table_header.concat(table_data, table_footer ); 

                    $('#logs_by_branch').html(html);

                     
                  }
                }); 

            }


    </script>

<?php include_once VIEWS.DS.'templates/users/footer.php' ;?>