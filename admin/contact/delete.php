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

            $contact = query('SELECT * From contacts WHERE id=:id', array(
                ':id' => $id
            ));

            if (count($contact) > 0) {
                query('DELETE FROM contacts WHERE id=:id', array(
                    ':id' => $id
                ));

                redirect('../contact.php');
                exit();
            }
        }

        redirect('404.php');
    }
    catch (PDOException $ex) {

    }

?>