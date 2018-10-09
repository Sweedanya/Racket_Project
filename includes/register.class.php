<?php
class Registration
{

    public $title;
    public $first_name;
    public $last_name;
    public $gender;
    public $pwd;
    public $pwd_check;
    public $pwd_hash;
    public $email;
    public $birth_day;
    public $birth_month;
    public $birth_year;
    public $years_old;
    public $dob_db;
    public $code;

    public static $required_fields = ["title", "first_name", "last_name", "gender", "pwd", "pwd_check", "email", "birth_day", "birth_month", "birth_year"];

    public function __construct($user_data)
    {
        foreach ($user_data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }

        }
        $this->code = md5(rand());
    }

    public function form_complete($input, $required)
    {
        foreach ($required as $key) {
            if (empty($input[$key])) {
                throw new userException("form_incomplete", 1, $key);
            }
        }

    }

    public function name_validation()
    {
        $regEx = "/[^a-zA-Z0-9'-]/";

        if (preg_match($regEx, $this->first_name)) {
            throw new userException("invalid_input_name", 1);
        } elseif (preg_match($regEx, $this->last_name)) {
            throw new userException("invalid_input_name", 2);
        }
        return true;
    }

    public function is_email_valid()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strlen($this->email > 254)) {
            throw new userException("invalid_input_email", 1);
        }
        return true;
    }

    private function pwd_char_verify()
    {
        $blacklist = "/[^A-Za-z\d$@$!%*#?&-]/";

        if (preg_match($blacklist, $this->pwd)) {
            throw new userException("invalid_input_pwd", 1);
        }

        if (preg_match($blacklist, $this->pwd_check)) {
            throw new userException("invalid_input_pwd", 2);

        }
        return true;
    }

    private function pwd_format_verify()
    {
        $pwd_format = "/^(?=.*)[A-Za-z](?=.*\d)[A-Za-z\d$@$!%*#?&-]{5,}$/";
        if (!preg_match($pwd_format, $this->pwd) || !preg_match($pwd_format, $this->pwd_check)) {
            throw new userException("invalid_input_pwd", 3);
        }
        return true;
    }

    public function password_handler()
    {
        $this->pwd_char_verify();
        $this->pwd_format_verify();
        $this->format_dob();
        $this->pwd_hash = password_hash($this->pwd, PASSWORD_DEFAULT);
        return true;
    }

    private function format_age_db()
    {
        $this->dob_db = "{$this->birth_year}-{$this->birth_month}-{$this->birth_day}";
    }

    private function set_age()
    {
        $dob = date_create_from_format('Y-m-d', "$this->birth_year-$this->birth_month-$this->birth_day");
        $age_in_days = date_diff(date_create("now"), $dob);
        $this->years_old = $age_in_days->format("%Y");
    }

    private function check_age_threshold()
    {
        if ($this->years_old < age_to_join) {
            throw new userException("invalid_input_date", 3, age_to_join);
        }
    }

    public function age_handler(){
        
        if (!(is_numeric($this->birth_day) && is_numeric($this->birth_month) && is_numeric($this->birth_year))){
            throw new userException("invalid_input_date", 1);
        }
        if(!checkdate($month, $day, $this->birth_year)){
            throw new userException("invalid_input_date", 2);
        }

        set_age();
        format_age_db();
        check_age_threshold();
    }
}
