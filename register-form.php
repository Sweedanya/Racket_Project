<?php

    require __DIR__ . "/layout/header.php";

    if (isset($_POST['register'])) {
        require __dir__ . "/includes/register.process.php";
        
        try{
        register();

        } catch (userException $e){
            $status = status_update(0, $e->e_msg, "error");
            echo status_display($status);
        }
    }

?>      

        <div class="container signin-wrapper">     
            <form action="index.php" method="post" class="form-horizontal form-register" role="form">
                
            <h2 class="col-sm-offset-1">Registration Form </h2>
                <div class="form-group" >    
                <label class="control-label col-sm-1 col-sm-push-1" for="title">Title:</label>
                        <div class="col-sm-1 col-sm-push-1">
                            <select class="form-control" name="title" id="title">
                                <option value=""></option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Miss">Miss</option>
                            </select>
                        </div>

                    <label class="control-label col-sm-1 col-sm-push-1" for="gender">Gender:</label>
                    <div class="col-sm-1 col-sm-push-1">
                        <select name="gender" id="gender" class="form-control">
                            <option value=""></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
            
        

            <div class="form-group">
                <label for="first_name" class="control-label col-sm-2" >First name:</label>
                <div class="col-sm-4">
                    <input class="form-control"  id="first_name" name="first_name" placeholder="First" type="text">
                </div>
            </div>
            <div class="form-group">
                
                    <label class="control-label col-sm-2" for="last_name">Last name:</label>
                <div class="col-sm-4">
                    <input class="form-control" id="last_name" name="last_name" placeholder="Last"  type="text">
                </div>
            </div>
        
        

        <div class="form-group" >
            <div class="">

                
                    <div>
                        <label for="birth-day" class="control-label col-sm-2">Birthday:</label>
                    </div>
                <div class="col-sm-6">
                    <div class="col-sm-2"><input type="text" id="birth-day" class="form-control" name="birth_day" placeholder="28" maxlength="2"></div>
                    <div class="col-sm-2"><input type="text" id="birth-day" class="form-control" name="birth_month" placeholder="06" maxlength="2"></div>
                    <div class="col-sm-4"><input type="text" id="birth-day" class="form-control" name="birth_year" placeholder="1995" maxlength="4"></div>
                </div>
                </div>
            
        </div>
    
    
        
        
        <div class="form-group">
            <label for="user_pwd" class="control-label col-sm-2" >Password: </label>
            <div class="col-sm-4">
                <input id="user_pwd" class="form-control" type="password" name="pwd" placeholder="******">
            </div>
        </div>

        <div class="form-group text-left">
            <label for="user_pwd_check" class="control-label col-sm-2">Confirm Password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" id="user_pwd_check" name="pwd_check" placeholder="******">
            </div>
        </div>
    
        <div class="form-group">
            
                <label for="user_email" class="control-label col-sm-2">Email:</label>
                <div class="col-sm-4"> <input type="email" class="form-control" name="email" id="user_email">
                </div>
            
        </div>
        <div class="form-group">
            
            <button type="submit" name="register" value="true" class="btn btn-primary col-sm-offset-5">Register</button>
            
        </div>
    </div>
        </form>