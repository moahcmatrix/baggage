<?php
    session_start();

    define('isAuth', 'isAuth');

    function isAuth() {
        return isset($_SESSION[isAuth]) && $_SESSION[isAuth] != NULL;
    }

    function auth() {
        if (!isAuth()) {
            exit();
        }
    }

    function unauth() {
        if (isAuth()) {
            exit();
        }
    }

    function setAuth($user) {
        $_SESSION[isAuth] = $user;
    }

    function getUser() {
        return $_SESSION[isAuth];
    }
?>