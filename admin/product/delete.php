<?php
    require_once(dirname(__FILE__) . "/../../helper.php");
    require_once(getPath("/database.php"));
    require_once(getPath("/admin/auth.php"));
    require_once(getPath("/admin/validator.php"));
    
    auth();

    try {
        $eId = validate('id', 'get', 'required', $id);

        if (!hasErrors($eId)) {
            connect();

            $product = query('SELECT * From products WHERE id=:id', array(
                ':id' => $id
            ));

            if (count($product) > 0) {
                query('DELETE FROM products WHERE id=:id', array(
                    ':id' => $id
                ));

                redirect('../product.php');
                exit();
            }
        }

        redirect('404.php');
    }
    catch (PDOException $ex) {

    }

?>