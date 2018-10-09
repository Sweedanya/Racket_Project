<?php 

if (isset($_POST["login"])) {
    $status = $login->verify_login($_POST);

    if ($status === true){
        header("Refresh:0");
        exit();
    }
}

if (isset($status) && $status !== true){
    echo status_display($status);
}

?>

  <div class="signin-wrapper">
    <div class="form-signin">

        <form class="" method="post" action="">       
        <h2 class="form-signin-heading">Please login</h2>
        <input type="text" class="form-control" name="email" placeholder="Email Address" required="" autofocus="" />
        <input type="password" class="form-control" name="pwd" placeholder="Password" required=""/>      
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
        <!-- <p><a href="./register-form.php">Register here</a></p>
        <p><a href="./forgot-password-form.php">Reset Password</a></p>    -->
        </form>

        <form action="./index.php" method="post">
            <button class="btn btn-link btn-block" type="submit" name="register-form">Register here</button>
            <button class="btn btn-link btn-block" type="submit" name="forgot_pwd-form">Reset Password</button>
        </form>

    </div>
    
  </div>

