<?php
    // Entry Point
    if (count($_COOKIE) == 0) {
        setcookie('test', 'test', time() + (86400 * 30), '/');
        echo 'Please Enable The Cookie';
        exit();
    }

?>