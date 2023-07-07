<?php
    include_once 'app.php';
    include_once 'config.php';
    include_once 'database.php';
    include_once 'helper.php';

    $page = 'Home';

    $name = $email = $phone = $message = '';
    $errName = $errEmail = $errPhone = $errMessage = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['name'])) {
            $errName = 'Please Enter Name';
        }
        else {
            $name = purging($_POST['name']);
        }

        if (empty($_POST['email'])) {
            $errEmail = 'Please Enter Your Email';
        }
        else {
            $email = purging($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errEmail = 'Please Enter Correct Email';
            }
        }

        if (empty($_POST['phone'])) {
            $errPhone = 'Please Enter Your Phone';
        }
        else {
            $phone = purging($_POST['phone']);
        }

        if (empty($_POST['message'])) {
            $errMessage = 'Please Enter Your Message';
        }
        else {
            $message = purging($_POST['message']);
        }


        if ($errName == '' && $errEmail == '' &
            $errPhone == '' && $errMessage == '') {
            try {
                connect();
                $status = query("INSERT INTO `contacts` (`id`, `email`, `phone`, `message`) VALUES (NULL, :email, :phone, :message);", array(
                    ':email' => $email,
                    ':phone' => $phone,
                    ':message' => $message
                ));

                $status = 'Success To Contact';
            }
            catch(PDOException $ex) {
                echo $ex->getMessage();

                $status = 'Failed To Contact';
            }
        }
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
        <!-- //header -->
        <?php include 'layouts/header.php'; ?>
        <!-- //header -->
    </div>

    <!-- //banner-->

    <!--/contact -->
    <section class="banner-bottom py-5">
        <div class="container py-md-5">
            <h3 class="title-wthree mb-lg-5 mb-4 text-center">Contact Us </h3>
            <div class="row contact_information">
                <div class="col-md-6">
                    <div class="contact_right p-lg-5 p-4">
                        <form action="<?php echo purging($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="field-group">
                                <div class="content-input-field">
                                    <input name="name" id="text1" type="text" value="<?php echo $name; ?>" placeholder="User Name" required="">
                                    <?php if ($errName != "") { ?>
                                        <span><?php echo $errName; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="field-group">

                                <div class="content-input-field">
                                    <input name="email" id="text1" type="email" value="<?php echo $email; ?>" placeholder="User Email" required="">
                                </div>
                                <?php if ($errEmail != "") { ?>
                                    <span><?php echo $errEmail; ?></span>
                                <?php } ?>
                            </div>
                            <div class="field-group">
                                <div class="content-input-field">
                                    <input name="phone" id="text3" type="text" value="<?php echo $phone; ?>" placeholder="User Phone" required="">
                                </div>
                                <?php if ($errPhone != "") { ?>
                                    <span><?php echo $errPhone; ?></span>
                                <?php } ?>
                            </div>
                            <div class="field-group">
                                <div class="content-input-field">
                                    <textarea name="message" placeholder="Your Message Here..." required=""><?php echo $message; ?></textarea>
                                </div>
                                <?php if ($errMessage != "") { ?>
                                    <span><?php echo $errMessage; ?></span>
                                <?php } ?>
                            </div>
                            <div class="content-input-field">
                                <button type="submit" class="btn">Submit</button>
                            </div>
                            <?php 
                                if (isset($status)) { 
                                    echo $status;
                                }
                            ?>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 contact_left p-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6350041.310790406!2d30.68773492426509!3d39.0014851732576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b0155c964f2671%3A0x40d9dbd42a625f2a!2sTurkey!5e0!3m2!1sen!2sin!4v1522753415269"></iframe>
                </div>

                <div class="col-lg-4 col-md-6 mt-lg-4 contact-inn-w3pvt">
                    <div class="mt-5 information-wthree">
                        <h4 class="text-uppercase mb-4"><span class="fa fa-comments"></span> Communication</h4>
                        <p class="cont-wthree-para mb-3 text-capitalize">for general queries, including property Sales and constructions, please email us at <a href="mailto:info@example.com">info@example.com</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-lg-4 contact-inn-w3pvt">
                    <div class="mt-5 information-wthree">
                        <h4 class="text-uppercase mb-4"><span class="fa fa-life-ring"></span> Technical Support</h4>
                        <p class="cont-wthree-para mb-3 text-capitalize">we are ready to help! if you have any queries or issues, contact us for support <label>+12 388 455 6789</label>.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-lg-4 contact-inn-w3pvt">
                    <div class="mt-5 information-wthree">
                        <h4 class="text-uppercase mb-4"><span class="fa fa-map"></span> Others</h4>
                        <p class="cont-wthree-para mb-3 text-capitalize">we are ready to help! if you have any queries or issues, contact us for support <label>+12 388 455 6789</label>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//contact -->



    <?php 
        include 'partials/newletters.php';
        include 'layouts/footer.php'; 
    ?>
