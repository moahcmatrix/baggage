<?php
    include_once './config.php';
    include_once './helper.php';
    include_once './auth.php';
?>

<!-- //header -->
        <header class="py-sm-3 pt-3 pb-2" id="home">
            <div class="container">
                <!-- nav -->
                <div class="top-w3pvt d-flex">
                    <div id="logo">
                        <h1> <a href="index.php"><span class="log-w3pvt">B</span>aggage</a> <label class="sub-des">Online Store</label></h1>
                    </div>
                    <?php if (!isAuth()) { ?>
                        <div class="forms ml-auto">
                            <a href="login.php" class="btn"><span class="fa fa-user-circle-o"></span> Sign In</a>
                            <a href="register.php" class="btn"><span class="fa fa-pencil-square-o"></span> Sign Up</a>
                        </div>
                    <?php } else { ?>
                        <div class="forms ml-auto">
                            <a href="signout.php" class="btn"><span class="fa fa-user-circle-o"></span> Sign Out</a>
                        </div>
                    <?php } ?>
                </div>
                <div class="nav-top-wthree">
                    <nav>
                        <label for="drop" class="toggle"><span class="fa fa-bars"></span></label>
                        <input type="checkbox" id="drop" />
                        <ul class="menu">
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li>
                                <!-- First Tier Drop Down -->
                                <label for="drop-2" class="toggle">Dropdown <span class="fa fa-angle-down" aria-hidden="true"></span>
                                </label>
                                <a href="#">Dropdown <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                                <ul>
                                    <li><a href="coming.php" class="drop-text">Services</a></li>
                                    <li><a href="about.php" class="drop-text">Features</a></li>
                                </ul>
                            </li>

                            <li><a href="shop.php">Collections</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </nav>
                    <!-- //nav -->
                    <div class="search-form ml-auto">
                        <div class="form-w3layouts-grid">
                            <form action="shop.php" method="get" class="newsletter">
                                <input class="search" type="search" placeholder="Search here..." required="" name="search">
                                <button class="form-control btn" value=""><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </header>
        <!-- //header -->