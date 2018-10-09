<?php

require __DIR__ . "/loader.php";
require __DIR__ . "/layout/header.php";

//collect values from the url
if(isset($_GET['x']) && $_GET['y']){
    $user_email = trim($_GET['x']);
    $user_code = trim($_GET['y']);
} else {
    echo status_display(status_update(0, "Verification string not found", "error"));
}

//if id is number and the active token is not empty carry on
if(!empty($user_email) && !empty($user_code)){
    $status = $login->validate_account($user_email, $user_code);
    echo status_display($status);
    
} else{
    echo status_display(status_update(0, "something has gone wrong with your activation link", "error"));
}

require __DIR__ . "/layout/footer.php";