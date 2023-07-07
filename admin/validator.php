<?php
    function validate($name, $method, $state, &$value) {
        $state = explode(',', $state);
        $value = NULL;
        $errors = [];

        switch ($method) {
            case 'post':
                if (isset($_POST[$name])) {
                    $value = $_POST[$name];
                }
                break;
            case 'get':
                if (isset($_GET[$name])) {
                    $value = $_GET[$name];
                }
                break;
            default:
                if (isset($_REQUEST[$name])) {
                    $value = $_REQUEST[$name];
                }
                break;
        }

        for ($size = count($state), $i = 0, $j = 0; $i < $size; $i++) {
            switch ($state[$i]) {
                case 'required': 
                    if ($value == NULL) {
                        $errors[$j++] = 'Please Enter The Value';
                    }
                    break;
                default:
                    break;
            }
        }

        return $errors;
    }

    function hasErrors($errors) {
        return count($errors) > 0;
    }

    function showErrors($errors) {
        for ($i = 0, $size = count($errors); $i < $size; $i++) {
            echo "<div class='text-danger'>$errors[$i]</div>";
        }
    }
?>