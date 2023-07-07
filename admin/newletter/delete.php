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

            $newletter = query('SELECT * From newletters WHERE id=:id', array(
                ':id' => $id
            ));

            if (count($newletter) > 0) {
                query('DELETE FROM newletters WHERE id=:id', array(
                    ':id' => $id
                ));

                redirect('../newletter.php');
                exit();
            }
        }

        redirect('404.php');
    }
    catch (PDOException $ex) {

    }

?>