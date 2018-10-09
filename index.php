<?php

require_once __dir__ . "/loader.php";
require __DIR__ . "/layout/header.php";
/* PHP before HTML */
// Verify session and route to members pages

if (isset($_SESSION["email"])) {
    
    if ($login->verify_session()) {
        //If verified allow into members pages
        if (isset($_POST["logout"])) {
            require 'logout-form';

        } else {
            require "home.php";
        }
        
    } else{
        session_destroy();
        header("./index.php?verification_error");

    }
// Account creation and non-members pages
} else {
    // user login pages
    if (isset($_POST['login'])) {
        
        try{
            $login->verify_login($_POST);
            require 'login-form.php';
        } catch (loginException  $e){
            echo status_display(status_update(0, $e->e_msg, $e->e_type));
        }
    }

    else if (isset($_POST['forgot_pwd-form'])) {
        require __DIR__ . '/forgot-password-form.php';
    }

    else if (isset($_POST['register-form']) || isset($_POST['register'])) {
        require __DIR__ . '/register-form.php';

    } else {
        require 'login-form.php';
    }
}

//Testing
if (isset($_SESSION["email"])) {
    if ($login->verify_session()) {
        echo "session login verified correctly <br>";
        echo "The value of _session is: ";
        pre_r($_SESSION);
    }
}





?>

        
<?php require_once __DIR__ . "/layout/footer.php"; ?>