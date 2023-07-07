<?php 
    require_once('helper.php');
    require_once(getPath('/database.php'));
    require_once(getPath('/config.php'));
    require_once(getPath('/admin/validator.php'));

    try {
        connect();

        $eId = validate('id', 'request', 'required', $id);

        if (hasErrors($eId)) {
            error(404);
            exit();
        }

        $product = query('SELECT * FROM products WHERE id=:id', array(
            ':id' => $id
        ));
        
        if (count($product) > 0) {
            $product = $product[0];
            $page = 'Product ' . $product['name'];
        }
        else {
            redirect('coming.php');
        }
    

        $email = $errEmail = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['email'])) {
                $email = purging($_POST['email']);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errEmail = 'Please Enter Correct Email';
                }
                else {
                    query('INSERT INTO orders(id, product, email) VALUES (NULL, :product, :email)', array(
                        ':product' => $product['id'],
                        ':email' => $email
                    ));
                }
            } else {
                $errEmail = 'Please Enter Your Email';
            }
        }
    }
    catch(PDOException $ex) {
        echo $ex->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title><?php echo SITE_TITLE . ' | ' . $page; ?></title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Baggage Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta tag Keywords -->
    <!-- Custom-Files -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Style-CSS -->
    <!-- font-awesome-icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome-icons -->
    <!-- /Fonts -->
    <link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
    <!-- //Fonts -->

</head>

<body>
    <div class="main-sec inner-page">
       <?php include 'layouts\header.php'; ?>
    </div>
    <!-- //banner-->
    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container py-md-5">
            <!-- product right -->
            <div class="left-ads-display wthree">
                <div class="row">
                    <div class="desc1-left col-md-6">
                        <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="">
                    </div>
                    <div class="desc1-right col-md-6 pl-lg-3">
                        <h3><?php echo $product['name']; ?></h3>
                        <h5>
                            Rs. <?php echo $product['price']; ?> 
                            <?php if ($product['discount'] > 0) { ?>
                                <span><?php echo $product['discount']; ?></span>
                            <?php } ?>  
                            <a href="#">Click for offer</a>
                        </h5>
                        <div class="available mt-3">
                            <form action="<?php echo purging($_SERVER['PHP_SELF'])?>" method="post" class="w3pvt-newsletter subscribe-sec">
                                <input name="id" type="hidden" value="<?php echo $id; ?>">
                                <input name="email" type="email" name="Email" placeholder="Enter your email..." required="">
                                <button class="btn submit">Check</button>
                            </form>
                            <span><a href="#">login to save in wishlist </a></span>
                            <p><?php echo substr($product['description'], 0, 95); ?></p>
                        </div>
                        <div class="share-desc mt-5">
                            <div class="share text-left">
                                <h4>Share Product :</h4>
                                <div class="social-ficons mt-4">
                                    <ul>
                                        <li><a href="#"><span class="fa fa-facebook"></span> Facebook</a></li>
                                        <li><a href="#"><span class="fa fa-twitter"></span> Twitter</a></li>
                                        <li><a href="#"><span class="fa fa-google"></span>Google</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>


                </div>
                <div class="row sub-para-w3pvt my-5">

                    <h3 class="shop-sing">Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elPellentesque vehicula augue eget nisl ullamcorper, molestie blandit ipsum auctor. Mauris volutpat augue dolor.Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut lab ore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. labore et dolore magna aliqua.</p>
                    <p class="mt-3 italic-blue">Consectetur adipisicing elPellentesque vehicula augue eget nisl ullamcorper, molestie blandit ipsum auctor. Mauris volutpat augue dolor.Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut lab ore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. labore et dolore magna aliqua.</p>
                    <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elPellentesque vehicula augue eget nisl ullamcorper, molestie blandit ipsum auctor. Mauris volutpat augue dolor.Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut lab ore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. labore et dolore magna aliqua.</p>
                </div>


                <!--/row-->
                <h3 class="title-wthree-single my-lg-5 my-4 text-left">Featured Bags</h3>
                <div class="row shop-wthree-info text-center">
                    
                    <?php
                        $stmt = $connection->prepare('SELECT * FROM products');
                        $stmt->execute();
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $allProducts = $stmt->fetchAll();
                        $allProductsSize = count($allProducts) - 1;

                        for ($i = 0; $i < 4; $i++) {
                            $positionsProducts[$i] = rand(0, $allProductsSize);
                        }

                        for($i = 0; $i < count($positionsProducts); $i++) {
                            $products[$i] = $allProducts[$positionsProducts[$i]];
                        }

                        for ($i = 0; $i < count($products); $i++) {
                    ?>
                        <div class="col-md-3 shop-info-grid text-center mt-4">
                            <div class="product-shoe-info shoe">
                                <div class="men-thumb-item">
                                    <img src="<?php echo $products[$i]['image']; ?>" class="img-fluid" alt="">

                                </div>
                                <div class="item-info-product">
                                    <h4>
                                        <a href="single.php?id=<?php echo $products[$i]['id']; ?>"><?php echo $products[$i]['name']; ?></a>
                                    </h4>

                                    <div class="product_price">
                                        <div class="grid-price">
                                            <span class="money"><span class="line">$<?php echo $products[$i]['price']; ?></span>$<?php echo $products[$i]['discount']; ?></span>
                                        </div>
                                    </div>
                                    <ul class="stars">
                                        <li><a href="#"><span class="fa fa-star" aria-hidden="true"></span></a></li>
                                        <li><a href="#"><span class="fa fa-star" aria-hidden="true"></span></a></li>
                                        <li><a href="#"><span class="fa fa-star-half-o" aria-hidden="true"></span></a></li>
                                        <li><a href="#"><span class="fa fa-star-half-o" aria-hidden="true"></span></a></li>
                                        <li><a href="#"><span class="fa fa-star-o" aria-hidden="true"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!--//row-->

            </div>
        </div>
    </section>
    <!-- /banner-bottom -->
    <?php 
        include 'partials/newletters.php';
        include 'layouts/footer.php'; 
    ?>