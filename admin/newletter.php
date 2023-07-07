<?php
    // include_once '../app.php';
    require_once(dirname(__FILE__) . "/../helper.php");
    require_once(getPath("/database.php"));
    require_once(getPath("/admin/auth.php"));
    require_once(getPath("/admin/validator.php"));
    require_once(getPath("/admin/pagination.php"));

    auth();

    try {
        connect();
        $pagSize = 10;
        $eSearch = validate('search', 'get', '', $search);

        if ($search != NULL) {
            $items = query("SELECT * FROM newletters WHERE email LIKE :email", array(
                ':email' => $search
            ));
        }
        else {
            $items = query('SELECT * FROM newletters');
        }

        $newletters = getPag();
    }
    catch(PDOException $ex) {

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
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .pro-img {
            width: 100px;
        }
    </style>
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

        <?php include_once 'layouts/sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Newletter</h6>
                            <form class="d-block mr" method="get" action="<?php purging($_SERVER['PHP_SELF']); ?>">
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <input name="search" type="text" class="form-control" value="<?php echo $search; ?>">
                                    </div>
                                    <input type="submit" class="btn btn-primary col-sm-2 col-form-label" value="Search">
                                </div>
                            </form>
                            <form method="post" action="newletter/sendemail.php">
                                <div class="table-responsive">
                                    <input type="submit" class="btn btn-danger m-2" value="Send Selected Email">
                                    <form method="post" action="newletter/sendemail.php">
                                        <input type="hidden" name="newletters" />
                                        <input type="submit" class="btn btn-danger m-2" value="Send Email All">
                                    </form>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0, $size = count($newletters); $i < $size; $i++) { ?>
                                            <tr>
                                                <th scope="row"><input name="emails[]" type="checkbox" value="<?php echo $newletters[$i]['email']; ?>"></th>
                                                <td><?php echo $newletters[$i]['email']; ?></td>
                                                <td>
                                                    <form method="post" action="newletter/sendemail.php">
                                                        <input name="emails[]" type="hidden" value="<?php echo $newletters[$i]['email']; ?>" >
                                                        <input type="submit" class="btn btn-primary" value="Send Email">
                                                        <a href="newletter/delete.php?id=<?php echo $newletters[$i]['id']; ?>" class="btn btn-danger m-2">Delete</a>    
                                                    </form>
                                                    
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div>
                                        <?php for ($i = 0, $pagSize= getPagSize(); $i < $pagSize; $i++) { ?>
                                            <a class="btn btn-primary" href="newletter.php?page=<?php echo $i; ?><?php echo $search != NULL ? "&search=$search" : ""; ?>"><?php echo $i; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->

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
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>