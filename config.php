<?php
    define('SITE_TITLE', 'Baggage');
    define('DATABASE_SERVER', 'localhost');
    define('DATABASE_NAME', 'baggage');
    define('DATABASE_USERNAME', 'root');
    define('DATABASE_PASSWORD', '');
    define('SITE_CONFIG', 'config.cfg');
    define('SITE_COOKIE_USER', 'USER_STATE');
    define('SITE_KEYWORDS', '');

    function getAttribute($name) {
        $file = fopen(SITE_CONFIG, 'r') or die('unable to open file');
        $config = fread($file, filesize(SITE_CONFIG));
        $attribute = strpos($config, $name, 0);

        fclose($file);

        if ($attribute !== FALSE) {
            $vspos = strpos($config, '=', $attribute);
            $vepos = strpos($config, '\n', $vspos);
            $value = substr($config, $vspos, -1);

            return $value;
        }

        return NULL;
    }

