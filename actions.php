<?php

if (!empty($_POST['data']['allData'])) parse_str($_POST['data']['allData'], $data);
if (!empty($_POST)) {
    $post = $_POST;

    if ($post['data']['formId']) {
        require 'Model/UserClass.php';
    
        switch ($post['data']['formId']) {
            case 'frmNewUser':
                $result = UserClass::registerUser($data['data']);
                echo $result;
            break;
            case 'frmLogin':
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";

                $result = UserClass::login($data);
                echo $result;
            break;

            default:
            break;
        }

    }
}
?>