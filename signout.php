<?php
    include_once 'helper.php';
    include_once 'auth.php';
    include_once 'config.php';

    if (isAuth()) {
        setcookie(SITE_COOKIE_USER, '', time() - (86400 * 30), "/");
        redirect();
    }
?>