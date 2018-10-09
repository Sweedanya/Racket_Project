<?php

if (isset($_POST["reset_pwd"])) {
    $status = $login->lost_password($_POST);
}

if (isset($status)){
    echo display_status($status);
}

?>

  <div class="signin-wrapper">
    <div class="form-signin">
        <form class="form" method="post" action="">       
        <h2 class="form-signin-heading">Lost Password</h2>
        <input type="text" class="form-control" name="email" placeholder="Email Address" required="" autofocus="" />    
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset_pwd">Submit</button>

        </form>
        <form action="./index.php" method="post">
            <button class="btn btn-link center-left" type="submit" name="register-form">Register here</button>
        </form>
    </div>
  </div>
