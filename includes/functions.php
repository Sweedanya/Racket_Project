<?php

/* echo "<br> I am the functions file inside includes"; */

function pre_r($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function status_update($code, $message, $class)
{
    return $status_array = ["code" => $code, "message" => $message, "class" => $class];
}

function status_display(array $status){
    $status_css = ($status["code"] === 1 ? 'bg-success' : 'bg-warning');

    $hereodoc = <<<EOD
    <div class="container  {$status_css}">
            <p>
                {$status["message"]}
            </p>
        </div> 
EOD;

return $hereodoc;
}


/* 
function error_index_redirect(string $error_message)
{
    $DIR = __DIR__;
    $URL = "{$DIR}/index.php?={$error_message}";
    header("Location: $URL");
    exit();
}
 */

/* 
function send_verification_email(string $user_first, string $user_email, string $user_code)
{
    $verify_url = __dir__ . "/verify.php?email=" . $user["email"] . '&hash=' . $user_code;
    $to = $user["email"];
    $subject = "Verify your Northumberland Racket Club account";
    $headers = "From: " . admin_email;
    $message_body = "
        Hello " . $user["first"] . ",

        Thank you for signing up to Northumberland Racket Club!

        Please click this link to activate your account:

        $verify_url";

    mail($to, $subject, $message_body);
}
 */