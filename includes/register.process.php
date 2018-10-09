<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

/* TO DO:
1. Escape outputs or use prepared statements DONE
2. Work on Login System DONE
2b. Prevent the use of duplicate emails and usernames DONE
3. Session update messages for form completion DONE
4. Add an age column to DB add age handling to form and processing files DONE
5. Change the default value for the validated column DONE

7. Work out why relative links wernt working the way I expected them to KINDA
8. Make the code DRY. Functionalise the code. Too many header statements preg matches and exit functions. DONE
9. Add email functionality for sending confirmation emails DONE
10. Add a profile page where people can update their profiles
11. Add password recovery IN PROGRESS
12. Add a nav bar where people can log in DONE
13 Investigate getting a server for EMAIL functions DONE
14. Add a passoword check field DONE
15. Add a gender field DONE
16. Add a title field DONE
17 Extend the Exception class
18. Add production friendly error handling
19. Add JS event handling for form submission so we can add messages to each field.
20.zzzzzzzzzzz
 */

if (isset($_POST['register'])) {

    function register()
    {
        $reg = new Registration($_POST);
        $status = true;
        global $db;

        $reg->form_complete($_POST, Registration::$required_fields);
        $reg->name_validation();
        $reg->age_handler();
        $reg->is_email_valid();
        $reg->password_handler();

        if ($db->is_present(
            "SELECT user_email FROM users WHERE user_email=:user_email",
            ["user_email" => $reg->email]
        )) {
            throw new userException("invalid_input_email", 2);
        }

        $db->conn->beginTransaction();

        // Try to register user and handle any DB connection errors
        try {

            $query = "INSERT INTO users (user_title, user_first, user_last, user_gender, user_dob, user_pwd, user_email)  VALUES  (:user_title, :user_first, :user_last, :user_gender, :user_dob, :user_pwd, :user_email);";

            $stmt = $db->conn->prepare($query);

            $stmt->execute([
                "user_title" => $reg->title, "user_first" => $reg->first_name,
                "user_last" => $reg->last_name, "user_gender" => $reg->gender,
                "user_dob" => $reg->dob_db, "user_pwd" => $reg->pwd_hash,
                "user_email" => $reg->email,
            ]);

            $query = "INSERT INTO auth_tokens (email, verification_code) VALUES (:email, :verification_code)";
            $stmt = $db->conn->prepare($query);
            $stmt->execute([
                "email" => $reg->email,
                "verification_code" => $reg->code,
            ]);

            $db->conn->commit();

        } catch (Exception $e) {
            /* echo $e->getMessage(); */
            $db->rollBack();
            return $status = $reg->status_update(0, "$e->getMessage()", "error");
        }

        $to = $reg->email;
        $subject = "Registration Confirmation";
        $body = "<p>Hi $reg->first_name, thank you for registering at Northumberland Racket Club.</p>
        <p>To activate your account, please click on this link:

        <a href='" . DIR . "activate-form.php?x=$reg->email&y=$reg->code]'>" . DIR . "activate.phx=$reg->email=$reg->code</a></p>

	    <p>Regards Site Admin</p>";
        $mail = new Mail();
        $mail->setFrom(SITEEMAIL);
        $mail->addAddress($to);
        $mail->subject($subject);
        $mail->body($body);
        $mail->send();

        return $status = $reg->status_update(1, 'Account created successfully', "success");

    }

} else {
    header("location: index.php?invalid=form_not_submitted");
}
