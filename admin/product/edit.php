<?php
     require_once(dirname(__FILE__) . "/../../helper.php");
     require_once(getPath("/database.php"));
     require_once(getPath("/admin/auth.php"));
     require_once(getPath("/admin/validator.php"));

     auth();

     $eId = validate('id', 'request', 'required', $id);

     if (!hasErrors($eId)) {
        try {
            connect();
            $product = query("SELECT * FROM products WHERE id=:id", array(
                ":id" => $id
            ));

            if (count($product) > 0) {
                $product = $product[0];
            }
            else {
                redirect("404.html");    
            }

        $eId  = $eName = $ePrice = $eDiscount = $eDescription = $eState = $eImage = [];
        $state = [];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $eId = validate('id', 'request', 'required', $id);
                # validator name
                $eName = validate('name', 'post', 'required', $name);
                $exProduct = query('SELECT * FROM products WHERE name=:name AND NOT id=:id', array(
                    ":name" => $name,
                    ":id" => $id
                ));

                if (count($exProduct) > 0) {
                    $eName[count($eName)] = 'Name Of Product Is Exist';
                }

                $ePrice = validate('price', 'post', 'required', $price);
                $eDiscount = validate('discount', 'post', 'required', $discount);
                $eDescription = validate('description', 'post', 'required', $description);
                $eState = validate('active', 'post', 'required', $state);
                // Validator Image
                $eImage = (!empty($_FILES['image']) && getimagesize($_FILES['image']['tmp_name'])) ? array() : array('Please Select Image');
                if (!hasErrors($eImage)) {
                    $imageName = basename($_FILES['image']['name']);
                    $imageUrl = 'images/' . $imageName;
                    $imagePath = '/images/' . $imageName;
                    $imageFullPath = getPath($imagePath);
                    $imageFileType  = strtolower(pathinfo($imageFullPath, PATHINFO_EXTENSION));

                    if (file_exists($imageFullPath)) {
                        $eImage[count($eImage)] = "Please Select Image Exist";
                    }

                    if ($_FILES['image']['size'] > 50000000) {
                        $eImage[count($eImage)] = "Please Select Image Small";
                    }

                    if (!($imageFileType != "jpg" || $imageFileType != "png" 
                        || $imageFileType != "jpeg" || $imageFileType != "gif")) {
                        $eImage[count($eImage)] = "Please Select Image Correct Extension";
                    }
                }

                if (!(hasErrors($eId) || hasErrors($eName) || 
                    hasErrors($ePrice) || hasErrors($eDiscount) ||
                    hasErrors($eDescription) || hasErrors($eState)) || hasErrors($eImage)) {    
                        query('UPDATE products SET name=:name, price=:price, discount=:discount, description=:description, active=:active, image=:image Where id=:id', array(
                            ':name' => $name,
                            ':price' => $price,
                            ':discount' => $discount,
                            ':description' => $description,
                            ':active' => $state,
                            ':image' => $imageUrl,
                            ':id' => $id
                        ));
                        move_uploaded_file($_FILES['image']['tmp_name'], $imageFullPath);
                    }        
                }
                else {
                    $id  = $product['id'];
                    $name = $product['name'];
                    $price = $product['price'];
                    $discount = $product['discount'];
                    $description = $product['description'];
                    $state = $product['active'];
                }
        }
        catch (PDOException $ex) {

        }
     }
     else {
        redirect("404.html");
     }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <?php include '../layouts/sidebar.php'; ?>


        <!-- Content Start -->
        <div class="content">
           


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Edit Product</h6>
                            <form method="post" action="<?php echo purging($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?php echo $id; ?>"/>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input name="name" type="text" class="form-control" value="<?php echo $name;?>">
                                    </div>
                                    <?php showErrors($eName); ?>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-10">
                                        <input name="price" type="number" class="form-control" id="inputPassword3" value="<?php echo $price;?>">
                                    </div>
                                    <?php showErrors($ePrice); ?>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Discount</label>
                                    <div class="col-sm-10">
                                        <input name="discount" type="number" class="form-control" id="inputPassword3" value="<?php echo $discount;?>">
                                    </div>
                                    <?php showErrors($eDiscount); ?>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" class="form-control" id="inputPassword3"><?php echo $description;?></textarea>
                                    </div>
                                    <?php showErrors($eDescription); ?>
                                </div>
                                <div class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">State</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input name="active" class="form-check-input" type="checkbox" id="gridCheck1" <?php echo isset($state) ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                    <?php showErrors($eState); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Image</label>
                                    <input name="image" class="form-control bg-dark" type="file" id="formFile">
                                    <?php showErrors($eImage); ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>