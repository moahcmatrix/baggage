<?php
    include_once 'config.php';

    $connection = NULL;

    function connect() {
        global $connection;

        try {
            $connection = new PDO('mysql:host=' . DATABASE_SERVER . ';dbname=' . DATABASE_NAME, 
                DATABASE_USERNAME, DATABASE_PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        }
        catch(PDOException $ex) {
            return NULL;
        }
    }


    function disconnect($connection) {
        global $connection;

        $connection = NULL;
    }

    function query($sql, $params = NULL) {
        global $connection;

        try {
            $stmt = $connection->prepare($sql);

            if ($params != NULL) {
                foreach ($params as $name => $value) {
                    $stmt->bindValue($name, $value);
                }
            }

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            return $stmt->fetchAll();
        }
        catch(PDOException $ex) {
            return NULL;
        }
    }