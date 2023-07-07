<?php
    function isAuth() {
        if (isset($_COOKIE[SITE_COOKIE_USER])) {
            return TRUE;
        }

        return FALSE;
    }
?>