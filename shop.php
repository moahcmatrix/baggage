<?php
    include 'app.php';
    include 'config.php';
    include 'database.php';

    $page = 'Shop';

    try {
        $connection = connect();

        if (!empty($_GET['search'])) {
            $page .= ' ' . $_GET['search'];

            $stmt = $connection->prepare('SELECT * FROM products WHERE name=:name');
            $stmt->bindParam(':name', $_GET['search']);
        }
        else {
            $stmt = $connection->prepare('SELECT * FROM products');
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $products = $stmt->fetchAll();

        $pageOffset = 0;
        $pageSize = 4;
        $pagesSize = count($products) / $pageSize;

        if (!empty($_GET['page'])) {
            $pageOffset = $_GET['page'];  
        }
        else {
            $pageOffset = 0;   
        }

        $products = array_slice($products, $pageOffset * $pageSize, $pageSize);
    }    
    catch (PDOException $ex) {
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
        <?php include 'layouts/header.php'; ?>
    </div>
    <!-- //banner-->
    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container py-5">
            <h3 class="title-wthree mb-lg-5 mb-4 text-center">Shop Now</h3>
            <?php 
                // $row = $product / 4;    
                // for ($irow = 0; $irow < $row; $irow++) { 
             ?>
            <!--/row-->
            <div class="row shop-wthree-info text-center">
                <?php for ($i = 0; $i < count($products); $i++) { ?>
                    <div class="col-lg-3 shop-info-grid text-center mt-4">
                        <div class="product-shoe-info shoe">
                            <div class="men-thumb-item">
                                <img src="<?php echo $products[$i]['image'] ?>" class="img-fluid" alt="">
                            </div>
                            <div class="item-info-product">
                                <h4>
                                    <a href="single.php?id=<?php echo $products[$i]['id']; ?>">Messenger Bag </a>
                                </h4>

                                <div class="product_price">
                                    <div class="grid-price">
                                        <span class="money"><span class="line">
                                        <?php
                                            echo '$' . $products[$i]['price'];

                                            if ($products[$i]['discount'] > 0) {
                                                $discount = $products[$i]['discount'];
                                                echo "</span> $discount$</span>";
                                            }
                                        ?>
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
            <?php 
            // } 
        ?>
            <!--//row-->
            <?php if (count($products) > 0) { ?>
                <nav aria-label="Page navigation example mt-5">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="<?php echo injectPageID((isset($_GET['page'])) ? $_GET['page'] + 1 : 0); ?>">Previous</a>
                    </li>
                    <?php 
                        function injectPageID($i) {
                            $baseurl = $_SERVER['PHP_SELF'];

                            if (!str_contains($baseurl, '?')) {
                                $baseurl .= '?';
                            }

                            if (!empty($_GET['page'])) {
                                $baseurl = str_replace("page=" . $_GET['page'], "page=" . $i, $baseurl);
                            }
                            else {
                                $baseurl .= "page=" . $i;
                            }

                            return $baseurl;
                        }

                        for ($i = 0; $i < $pagesSize; $i++) { 
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo injectPageID($i); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo injectPageID((isset($_GET['page'])) ? $_GET['page'] + 1 : 0); ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php } ?>
        </div>
    </section>
    <!-- /banner-bottom -->
    <?php 
        include 'partials/newletters.php';
        include 'layouts/footer.php'; 
    ?>
