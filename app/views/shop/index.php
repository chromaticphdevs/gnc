<?php include_once VIEWS.DS.'shop/templates/header.php' ;?>
<body>
    <!-- Start Main Top -->
    <div class="main-top">

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
           
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active"><a class="nav-link" href="/users/">Back</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="side-menu">
							<a href="#">
								<i class="fa fa-shopping-bag"></i>
								<span class="badge" style="color: red;">     
                                    <?php echo $total_item; ?>
                                </span>
								<p>My Cart</p>
							</a>
						</li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <?php $total = 0; ?>
                    <?php if(!empty($myCart)):?>
                        <ul class="cart-list">

                            <?php foreach($myCart as $key => $value) :?>
                                <li>
                                    <a href="#" class="photo"><img src="<?php echo URL.DS.'shop_design/images/'.$value->image ?>" class="cart-thumb" alt="" /></a>
                                    <h6><a href="#"><?php echo $value->product_name ?></a></h6>
                                    <p><?php echo $value->quantity ?> x <span class="price">&#8369;<?php echo $value->amount ?></span></p>
                                </li>
                                <?php $total += $value->quantity * $value->amount; ?>
                            <?php endforeach;?>

                            <li class="total">
                                <a href="/Shop/show_cart" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                                <span class="float-right"><strong>Total</strong>: &#8369;  <?php echo to_number($total); ?></span>
                            </li>
                        </ul>
                     <?php else:?>
                        <h2><b style="color:red;">Empty Cart</b></h2>
                     <?php endif;?>   
                </li>
            </div>
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

   

    <!-- Start Products  -->
    <div class="products-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1> <?php Flash::show()?></h1>
                        <h1>Beauty & Health Care </h1>
                    
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="special-menu text-center">
                        <div class="button-group filter-button-group">
                            <button  data-filter="*">All</button>
                            <!--<button class="active" data-filter=".top-featured">Top featured</button>
                            <button data-filter=".best-seller">Best seller</button>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row special-list">

                <?php foreach($codes as $key => $value) :?>
                    <?php if(!empty($value->image) && $value->show_product == 'yes') :?>
                       
                        <div class="col-lg-3 col-md-6 special-grid">
                            <div class="products-single fix">
                                <div class="box-img-hover">
                                    <img src="<?php echo URL.DS.'shop_design/images/'.$value->image ?>" class="img-fluid" alt="Image">
                                    <div class="mask-icon">
                                        <ul>
                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                        </ul>

                                        <?php if(!empty($myCart)): ?>

                                            <?php $check = 0; ?>
                                            <?php foreach($myCart as $myCart_key => $myCart_value) :?>

                                                 <?php if($myCart_value->code_id == $value->id ): ?>
                                                    <?php $check = 1; ?>
                                                 <?php endif; ?> 

                                            <?php endforeach;?>

                                            <?php if($check == 1 AND $value->many === 'yes'): ?>
                                                 <a class="cart" href="/Shop/add_cart/<?php echo seal($value->id) ?>">Add to Cart</a>
                                            <?php elseif($check == 0): ?>
                                                 <a class="cart" href="/Shop/add_cart/<?php echo seal($value->id) ?>">Add to Cart</a>
                                            <?php endif; ?> 

                                        <?php else: ?>
                                             <a class="cart" href="/Shop/add_cart/<?php echo seal($value->id) ?>">Add to Cart</a>
                                        <?php endif; ?>
                    
                                    </div>
                                </div>
                                <div class="why-text">
                                    <h4><?php echo  $value->name ?></h4>
                                    <h5>&#8369;<?php echo to_number($value->amount_original) ?></h5>
                                </div>
                            </div>
                        </div>
                     <?php endif;?>
                <?php endforeach;?>
            
            </div>
        </div>
    </div>
    <!-- End Products  -->

<?php include_once VIEWS.DS.'shop/templates/footer.php' ;?>
