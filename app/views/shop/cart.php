<?php include_once VIEWS.DS.'shop/templates/header.php' ;?>

<body>
    <!-- Start Main Top -->
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
            
            
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                    <a class="navbar-brand" href="index.html"><img src="images/logo.png" class="logo" alt=""></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                 <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active"><a class="nav-link" href="/Shop/">Shop</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                <!-- Start Atribute Navigation -->
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Cart</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/Shop/">Shop</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php Flash::show()?>

                    <?php
                        Form::open([
                          'method' => 'post',
                          'action' => '/Shop/update_cart'
                        ]);
                     
                    ?>

                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php $total = 0; ?>
                             <?php if(!empty($myCart)):?>

                                <?php foreach($myCart as $key => $value) :?>
                                    <tr>
                                        <td class="thumbnail-img">
                                            <a href="#">
            									<img class="img-fluid" src="<?php echo URL.DS.'shop_design/images/'.$value->image ?>" alt="" />
            								</a>
                                        </td>
                                        <td class="name-pr">
                                            <a href="#">
            									<?php echo $value->product_name ?>
            								</a>
                                        </td>
                                        <td class="price-pr">
                                            <p>&#8369;<?php echo $value->amount ?></p>
                                        </td>
                                        <td class="quantity-box">
                                            <?php if($value->many == "yes"  ): ?>
                                                <input type="number" size="4" name="quantity[<?php echo $key?>]" value="<?php echo $value->quantity ?>" min="0" step="1" class="c-input-text qty text">
                                            <?php else:?>
                                                 <input type="number" size="4" name="quantity[<?php echo $key?>]" value="<?php echo $value->quantity ?>" min="0" step="1" class="c-input-text qty text" readonly>
                                            <?php endif;?>
                                        </td>
                                        <td class="total-pr">
                                            <p>&#8369;<?php echo  to_number($value->amount * $value->quantity);  ?></p>
                                        </td>
                                        <td class="remove-pr">

                                            <a href="/Shop/remove_item/<?php echo $key; ?>">
            									<i class="fas fa-times"></i>
            								</a>
                                        </td>
                                    </tr>
                                    <?php $total += $value->amount * $value->quantity  ?>
                                <?php endforeach;?>

                                <tr>
                                    <td class="thumbnail-img">
                                    
                                    </td>
                                    <td class="name-pr">
                                      
                                    </td>
                                    <td class="price-pr">
                                       
                                    </td>
                                    <td class="quantity-box">
                                        <h2><b>Total</b></h2>
                                    </td>
                                    <td class="total-pr">
                                        <h2><b>&#8369; <?php echo to_number($total)  ?></b></h2>
                                    </td>
                                    <td class="remove-pr">
                                     
                                    </td>
                                </tr>
                             <?php else:?>
                                <h2><b style="color:red;">Empty Cart</b></h2>
                             <?php endif;?>  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row my-5">
               
                <div class="col-lg-6 col-sm-6">
                    <div class="update-box">

                        <input value="Update Cart" type="submit">

                    </div>
                </div>
         
             <?php Form::close()?>

                <div class="col-12 d-flex shopping-box"><a href="checkout.html" class="ml-auto btn hvr-hover">Checkout</a> </div>
            </div>

        </div>
    </div>
    <!-- End Cart -->

 <?php include_once VIEWS.DS.'shop/templates/footer.php' ;?>