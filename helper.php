<?php 
    function redirect($page = 'index.php') {
        header("Location: $page");
    }

    function error($value) {

    }   
    

    function purging($value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);

        return $value;
    }

    function getPath($path) {
        return dirname(__FILE__) . $path;
    }
