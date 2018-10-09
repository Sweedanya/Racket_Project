<?php 

class loginException extends Exception
{
    public $e_type;
    public $e_type_code;
    public $e_msg;

    public function __construct(string $error_type, int $type_code = 1, $optional = null)
    {
        $this->e_type = $error_type;
        $this->e_type_code = (INT)$type_code;
        $this->set_error_msg($optional);
    }

    private function set_error_msg($optional = null)
    { 
        if ($this->e_type === "session_verification_errror"){
            //COME BACK TO THIS
            $this->e_msg = "Can not verify login session please try again";
        }

        else if ($this->e_type === "missing_login_credentials") {
            if($this->e_type_code === 1){
                $this->e_msg = "Please enter your username and password";

            }

            else if($this->e_type_code === 2){
                $this->e_msg = "That email address does not exist in our records";
            }
        }

        else if ($this->e_type === "invalid_login_credentials") {
            
            if($this->e_type_code === 1){
                $this->e_msg = "Please enter your username and password";
            }
            else if ($this->e_type_code === 2) {
                $this->e_msg = "Username or password is incorrect.";
            }  
        }
        
        else if($this->e_type === "db_password_reset_error"){
            $this->e_msg = "Sorry your password reset request could not be processed at this time. Please try again later.";
        }
        
        else if ($this->e_type === "mail_process_error") {
            $this->e_msg = "Sorry your password reset request could not be processed at this time. Please try again later.";
        }
        
        else if ($this->e_type === "account_activation_status") {
            $this->e_msg = "Please follow check your emails for your activation email so we can activate your account"; 
        }

        else if($this->e_type === "password_reset"){

            if ($this->e_type_code === 1) {
                $this->e_msg = 'There was an error processing your request. Error 001';
            }

            else if ($this->e_type_code === 2) {
                $this->e_msg = 'There was an error processing your request. Error 002';
            }
            
            else if ($this->e_type_code === 3) {
                $this->e_msg = 'There was an error processing your request. Error 003';
            }
            
            else if ($this->e_type_code === 4) {
                $this->e_msg = 'There was an error processing your request. Error 004';
            }
        }


    }
}