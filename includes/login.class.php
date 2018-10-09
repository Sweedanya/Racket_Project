<?php
class Login extends PDO_DB {
    public $user;
    
    public function __construct() {
        global $db;
        session_start();   
        $this->db = $db;
        global $status_update;

    }
    
    // We are checking that the value in the session is legit
    public function verify_session() {
        $id_email = $_SESSION['email'];
        $user = $this->db->get("SELECT * FROM users WHERE user_email = :email", [$id_email]);
       
        if (false === $user) {
            throw new loginException("session_verification_errror", 1);
        }

        $this->user = $user;
        return true;

    }
    
    // Does the login attempt match a DB reccord
    public function verify_login($post) {
        if (! isset($post['email']) || ! isset($post['pwd'])) {
            throw new loginException("missing_login_credentials", 1);
        }
        
        // Check if user exists. Return false or user records as array
        $query = "SELECT * FROM users WHERE user_email = :email";
        $user = $this->db->get($query, [$post['email']]);
        
        if($user === false){
            throw new loginException("invalid_login_credentials", 1);
        }

        if (!password_verify($post['pwd'], $user["user_pwd"])){
            throw new loginException("invalid_login_credentials", 2);
        }
        
        if ($user["validated"] === "N"){
            throw new loginException("account_activation_status");

        }

        $_SESSION['email'] = $user["user_email"];
        $_SESSION['first_name'] = $user["user_first"];
        $_SESSION['last_name'] = $user["user_last"];
        return true;
    }


    function lost_password($post)
    {
        // Verify email submitted
        if (empty($post['email'])) {
            throw new loginException("missing_login_credentials", 2);
        }
        
        // Verify email exists and retrieve user details
        $query = "SELECT * FROM users WHERE user_email = :email";
        if (!$user = $this->db->get($query, $post['email'])) {
            throw new loginException("missing_login_credentials", 2);
        }
        
        // Create token and build reset URL
        $reset_token = random_bytes(32);
        $url = sprintf('%sreset.php?%s', ABS_URL, http_build_query([
            'reset_token' => bin2hex($reset_token)
        ]));

        // Token expiration
        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT01H')); // 1 hour
        
        // Delete any existing tokens for this user
        $this->db->get("UPDATE auth_tokens SET reset_token = NULL, reset_expires = NULL WHERE user_email = :email",[$user["email"]]);
        
        // Insert reset token into database
        $token_status = $this->db->get("UPDATE auth_tokens (reset_token, reset_expires) VALUES (:reset_token, :reset_expires) WHERE user_email = :email",
        [
                'email' => $user->email,
                'reset_token' => hash('sha256', $reset_token),
                'reset_expires' => $expires->format('U')
        ]);
        
        
        // Send the email

        if (!$token_status) {
            throw new loginException("db_password_reset_error");
        }

        $to = $user["user_email"];
        $subject = 'Your password reset link';
        $body = "<p> We recieved a password reset request. The link to reset your password is below.
        If you did not make this request, you can ignore this email</p>
        <p>Here is your password reset link:</br>" . sprintf('<a href=\"%s\">%s</a></p>', $url, $url) .
            "<p>Thanks!</p>";

        $mail = new Mail();
        $mail->setFrom(SITEEMAIL);
        $mail->addAddress($to);
        $mail->subject($subject);
        $mail->body($body);
        $status = $mail->send();

        if(!$status){
            // This needs more handling. DELETE CREATED TOKENS. The user can't use them if they don't have the email.
            throw new loginException("mail_process_error", 1);
        }

        session_destroy();
        return status_update(1, 'Check your email for the password reset link', "success");
    }

    public function reset_password($post)
    {
        // Required fields
        $required = array('reset_token', 'password');

        foreach ($required as $key) {
            if (empty($post[$key])) {
                throw new loginException("password_reset", 1);
            }
        }

        extract($post);
        
        // Get tokens
        $auth_data = $this->db->get(
            "SELECT * FROM auth_tokens WHERE reset_token = :reset_token AND reset_expires>= :time",
            ['reset_token' => $reset_token, 'time' => time()]);

        if ($auth_data === false || empty($auth_data)) {
            throw new loginException("password_reset", 2);
        }
    
        $hex_hash = hash('sha256', hex2bin($reset_token));
        
        // Validate tokens
        if (!hash_equals($hex_hash, $auth_data["reset_token"])){
            throw new loginException("auth_error_pwd_hash");
        }
        
        if(!$user = $this->get("SELECT * FROM users WHERE email = :email",[$auth_data["user_email"]])){
            throw new loginException("password_reset", 3);
        }
            
        // Update password
        if(!$update = $this->db->get("UPDATE user_pwd FROM users WHERE email = :email",
         ['user_pwd' => password_hash($password, PASSWORD_DEFAULT)]))
        {
            throw new loginException("password_reset", 4);
        }
                
        // Delete any existing tokens for this user
        $this->db->get("DELETE columns reset_token, reset_expires FROM reset_tokens WHERE email = :email ;",
                ['email' => $user["user_email"]]);

        // Log user out to prevent conflict.
        session_destroy();
        return status_update(1, 'Password updated successfully. <a href="index.php">Login here</a>', "success");

    }

    public function validate_account($u_email, $u_code)
    {

        try {

            $query = "SELECT users.user_email, users.validated, auth_tokens.verification_code FROM users JOIN auth_tokens WHERE users.user_email = auth_tokens.email && users.user_email = :user_email && auth_tokens.verification_code = :verification_code";

            $results_table = $this->db->get($query, ["user_email" => $u_email, "verification_code" => $u_code]);

            if ($results_table !== false) {

                if ($results_table["validated"] === "Y") {
                    return status_update(0, "Your account has already been activated", "error");
                } else {

                    $query = "UPDATE users SET validated = 'Y' WHERE user_email = :email && validated = 'N'";
                    $this->db->get($query, [$u_email]);
                    return status_update(1, "Your account has been activated", "success");
                }
            }
        } catch (Exception $e) {
            return status_update(0, $e, "error");
        }
    }
}

$login = new Login;