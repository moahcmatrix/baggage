<?php 
    include 'app.php';
    include 'config.php';
    include 'database.php';
    include 'helper.php';

    $pageTitle = 'Sign In';
    
    if (isAuth()) {
        redirect();
    }
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $connection = connect();
            $stmt = $connection->prepare('SELECT * FROM users WHERE username=:username AND password=:password');
            $stmt->bindParam(':username', $_REQUEST['username']);
            $stmt->bindParam(':password', $_REQUEST['password']);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $users = $stmt->fetchAll();

            if (count($users) > 0) {
                setcookie(SITE_COOKIE_USER, $users[0]['username'], time() + (86400 * 30), '/');
                redirect();
            }

            disconnect($connection);
        }
        catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title><?php echo SITE_TITLE . '|' . $pageTitle; ?></title>
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
       <?php include 'layouts/header.php' ?>
    </div>

    <!-- //banner-->
    <!--/login -->
    <section class="banner-bottom py-5">
        <div class="container">
            <div class="content-grid">
                <div class="text-center icon">
                    <span class="fa fa-unlock-alt"></span>
                </div>
                <div class="content-bottom">
                    <form action="login.php" method="post">
                        <div class="field-group">

                            <div class="content-input-field">
                                <input name="username" id="text1" type="text" value="" placeholder="User Name" required="">
                            </div>
                        </div>
                        <div class="field-group">
                            <div class="content-input-field">
                                <input name="password" id="myInput" type="Password" placeholder="Password">
                            </div>
                        </div>
                        <div class="content-input-field">
                            <button type="submit" class="btn">Sign In</button>
                        </div>
                        <ul class="list-login">
                            <li class="switch-slide">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                    keep Logged in
                                </label>
                            </li>
                            <li>
                                <a href="#" class="text-right">Forgot password?</a>
                            </li>
                            <li class="clearfix"></li>
                        </ul>
                        <ul class="list-login-bottom">
                            <li class="">
                                <a href="register.php" class="">Don't have an Account?</a>
                            </li>
                            <li class="">
                                <a href="#" class="text-right">Need Help?</a>
                            </li>
                            <li class="clearfix"></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /login -->
<?php include 'layouts/footer.php'; ?>