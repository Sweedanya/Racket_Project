<?php

class userException extends Exception {
    public $e_type;
    public $e_type_code;
    public $e_msg;

    public function __construct(string $error_type, int $type_code, $optional = null)
    {
        $this->e_type = $error_type;
        $this->e_type_code = (INT)$type_code;
        $this->set_error_msg($optional);
    }

/*      
        Error messages are dependant on error type and code properties.
        For each e_type there is a type_code 1,2,3,4,5...
        If there is more than 1 error message for a perticular error type then the type_code values are used
*/
    private function set_error_msg($optional = null){
        if($this->e_type === "form_incomplete"){
            $this->e_msg = sprintf('Please enter your %s', $optional);
        }

        else if($this->e_type === "invalid_input_name"){
            if ($this->e_type_code === 1){
                $this->e_msg = "field first name contains invalid characters";
            }
 
            else if ($this->e_type_code === 2){
                $this->e_msg = "field last name contains invalid characters";
            }
        }

        else if ($this->e_type === "invalid_input_email"){
            $this->e_msg = 'email contains forbidden characters';
        }

        else if ($this->e_type === "invalid_input_date"){
            if ($this->e_type_code === 1){
                $this->e_msg = "non numeric input in date field";
            }
            else if ($this->e_type_code === 2) {
                $this->e_msg = "Please enter the date in the format D/M/Y";
            }
            else if ($this->e_type_code === 3) {
                $this->e_msg = "Sorry you must be $optional to join.";
            }
        }

        else if ($this->e_type === "invalid_input_pwd"){
            
            if ($this->e_type_code === 1){
                $this->e_msg = "Invalid characters in the password field";
            }
            else if ($this->e_type_code === 2){
                $this->e_msg = "Invalid characters in the password check field";
            }

            else if ($this->e_type_code === 3){
                $this->e_msg = "invalid password format. Password fields must contain 6 or more characters, One uppercase and lower case letter and one number.";
            }

            else if ($this->e_type_code === 4){
                $this->e_msg = "Both password fields must match";
            }
            
        }
    }


}