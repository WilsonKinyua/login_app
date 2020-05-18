<?php


/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**
 * 
 * author:wilson kinyua
 * email: wilsonkinyuam@gmail.com
 * year created : May 2020
 * 
 * 
 */


function query($sql) {

    global $connection;

    return mysqli_query($connection,$sql);
    
}




function redirect($location) {

    return header("Location: $location");
}




function fetch_array($result) {

    global $connection;
  return  mysqli_fetch_array($result);
}




function last_id_insert() {

    global $connection;
    return mysqli_insert_id($connection);
}



function set_message($msg) {

    if(!empty($msg)) {

        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }

}



function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }
}




function confirm($result){

    global $connection;
    
    if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}



function escape($string){
    global $connection;

    return mysqli_real_escape_string($connection,$string);
}


function count_rows($result) {

    return mysqli_num_rows($result);
}


function clean($string) {
    
    return htmlentities($string);
}


function token_generator() {

 return $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));

}


function validation_form_errors($error_message) {


    $error_message = <<<DELIMETER

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Warning!</strong> $error_message
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>


DELIMETER;

return $error_message;
}
/**=================================================MAIL FUNCTION ======================================= */

function send_mail($email, $subject, $message, $headers) {

  return  mail($email, $subject, $message, $headers);

}

/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */


/**=================================================CHECK IF EMAIL EXIST ================================ */

function email_exists($email) {

    $query = query("SELECT id FROM users WHERE email = '$email' ");
    confirm($query);

    if(count_rows($query) == 1) {

        return true;

    } else {
        return false;
    }

}

/**=================================================CHECK IF USERNAME EXIST ================================ */

function username_exists($username) {

    $query = query("SELECT id FROM users WHERE username = '$username' ");
    confirm($query);

    if(count_rows($query) == 1) {

        return true;

    } else {
        return false;
    }

}

/**=================================================VALIDATION FUNCTIONS ================================ */

function validate_user_registration() {


    $errors  = [];
    $min    = 3;
    $max    = 30;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
      $first_name       =  clean($_POST['first_name']);
      $last_name        =  clean($_POST['last_name']);
      $username         =  clean($_POST['username']);
      $email            =  clean($_POST['email']);
      $password         =  clean($_POST['password']);
      $confirm_password =  clean($_POST['confirm_password']);

      /*******************first name validation************************************** */
      if(strlen($first_name) < $min) {

        $errors[] = "<div class ='alert alert-danger'>Your firstname cannot be less than {$min} characters<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
     
      }
      if(strlen($first_name) > $max) {

        $errors[] = "<div class ='alert alert-danger'>Your firstname cannot be more than {$max} characters<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }
      
      if(empty($first_name)) {

        $errors[] = "<div class ='alert alert-danger'>Your firstname cannot be empty<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }

      /************************last name validation*********************************** */
      if(strlen($last_name) < $min) {

        $errors[] = "<div class ='alert alert-danger'>Your lastname cannot be less than {$min} characters<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }
      if(strlen($last_name) > $max) {

        $errors[] = "<div class ='alert alert-danger'>Your lastname cannot be more than {$max} characters<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }

      if(empty($last_name)) {

        $errors[] = "<div class ='alert alert-danger'>Your lastname cannot be empty<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }

      /*******************username validation******************************************** */
      if(strlen($username) < $min) {

        $errors[] = "<div class ='alert alert-danger'>Your username cannot be less than {$min} characters<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }
      if(strlen($username) > $max) {

        $errors[] = "<div class ='alert alert-danger'>Are you sure you will remember all that username!!!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }

      if(empty($username)) {

        $errors[] = "<div class ='alert alert-danger'>Your username cannot be empty<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }
      if(username_exists($username)) {

        $errors[] = "<div class ='alert alert-danger'>Username Exists please try another one!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
          
      }
      /***********************Email validation******************************************** */

      if(email_exists($email)) {

        $errors[] = "<div class ='alert alert-danger'>Email already exists please proceed to login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
          
      }

      if(empty($email)) {

        $errors[] = "<div class ='alert alert-danger'>Email cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }

      /***********************Password validation******************************************** */

      if($password !== $confirm_password) {

        $errors[] = "<div class ='alert alert-danger'>Your password inputs does not match to each other!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
      }

      /***********************Displaying the errors**************************************** */

      if(!empty($errors)) {
          foreach ($errors as $error) {
              
            // echo validation_form_errors($error);

            echo $error;
          }

      } else {

        if(register_user($username, $first_name, $last_name, $email, $password)) {

            // set_message("<div class ='alert alert-success>User registered successfully. Please check your email or spam folder to verify your email!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            // redirect("index.php");
            echo "<div class ='alert alert-success text-center'>User registered successfully. <br> Please check your email or spam folder to verify your email!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";

        } else {

            echo "<div class ='alert alert-danger text-center'>Failed to register!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
      }


    }
}

/**=================================================FUNCTIONS TO REGISTER USER ================================ */

function register_user($username, $first_name, $last_name, $email, $password) {

   $first_name      = escape($first_name);
   $last_name       = escape($last_name);
   $email           = escape($email);
   $password        = escape($password);
   $username        = escape($username);

    if(username_exists($username)) {

        return false;

    } elseif(email_exists($email)) {

        return false;

    } else {

        // $password             = password_hash($password,PASSWORD_BCRYPT,array("cost" => 9));
        $password             = md5($password);
        // $validation_code      = md5($username + microtime());
        $validation_code      = md5(uniqid(rand(), true));

        $sql    = "INSERT INTO users (first_name, last_name, username, email, password, validation_code, active)";
        $sql   .= " VALUES('$first_name', '$last_name', '$username', '$email', '$password', '$validation_code', 0)";
        $result = query($sql);
        confirm($result);

        $subject = "ACTIVATION OF ACCOUNT";
        $message = " Please click the link below to activate your account
                         http://localhost/login/activate.php?email=$email&code=$validation_code
                    ";
        $headers  = "From: noreply@mywebsite.com";
        send_mail($email, $subject, $message, $headers);
        return true;
    }

}

// http://localhost/login/activate.php?email=firstname@gmail.com&code=2b2b26e06c4df0b833a5d40786498372

/**=================================================FUNCTIONS TO ACTIVATE USER ================================ */

function activate_user() {

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        if(isset($_GET['email'])) {

          $activate_email       =  clean($_GET['email']);
          $verification_code    =  clean($_GET['code']);
          

          $sql      = "SELECT id FROM users WHERE email = '". escape($_GET['email']) ."' AND validation_code = '". escape($_GET['code']) ."' ";
          $result   = query($sql);
          confirm($result);

          if(count_rows($result) == 1) {

          $sql2          = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '". escape($activate_email) ."' AND validation_code = '". escape($verification_code) . "' ";
          $result2       = query($sql2);
          confirm($result2);

          set_message("<div class ='alert alert-success text-center'>User verified successfully. Please Login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
          redirect("login.php");
         
            } else {
                set_message("<div class ='alert alert-danger text-center'>Sorry your account could not be verified!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect("login.php");
    
            }

        } 
    }
}

/**=================================================USER LOGIN VALIDATION FUNCTIONS ============================== */

function validate_user_login() {


    $errors  = [];
    $min    = 3;
    $max    = 30;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
     $email            =  clean($_POST['email']);
     $password         =  clean($_POST['password']);
     $remember_me      =  isset($_POST['remember']);

      /***********************email validation******************************************** */

      if(empty($email)) {

        $errors[] = "<div class ='alert alert-danger'>The email field cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
     
    }

      /***********************password validation******************************************** */

      if(empty($password)) {

        $errors[] = "<div class ='alert alert-danger'>The password field cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
     
    }

      /***********************Displaying the errors**************************************** */

      if(!empty($errors)) {

        foreach ($errors as $error) {
            
          // echo validation_form_errors($error);

          echo $error;
        }

        

    } else {

        if(login_user($email, $password, $remember_me)) {

            redirect("admin.php");

        } else {

            set_message("<div class ='alert alert-danger'>Error occurred while trying to login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect("login.php");
        }
    }
     
    }
}


/**=================================================LOGIN USER FUNCTIONS ======================================== */


function login_user($email, $password, $remember_me) {

    $sql = query("SELECT password, id FROM users WHERE email = '". escape($email) ."' AND active = 1 ");
    $result = $sql;
    confirm($result);

    if(count_rows($result) == 1) {

        $row = fetch_array($result);

        $db_password = $row['password'];

        /********************pulling out the password and changing it to its original************************************** */
        if(md5($password) === $db_password) {

          /**============setting and checking the cookie******************************************************************** */

          if($remember_me == "on") {

            setcookie("email", $email, time() + 86400);

          }
          /**============setting session for the email to be available in the whole site************************************* */
            $_SESSION['email'] = $email;

            return true;

        } else {

            return false;
        }

        return true;

    } else {

        return false;

    }

}


/**=================================================LOGGED IN FUNCTION ======================================== */


function logged_in_user() {

    if(isset($_SESSION['email']) || isset($_COOKIE['email'])) {

        return true;

    } else {
        
        return false;
    }

}

/**=================================================RECOVER PASSWORD FUNCTION ==================================== */

function recover_password() {

  if($_SERVER['REQUEST_METHOD'] == "POST"){

      if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

        $email = escape($_POST['email']);

        if(email_exists($email)) {

          // $reset_code = md5("email",$email,microtime());

          $reset_code      = md5(uniqid(rand(), true));

          setcookie("temp_reset_code",$reset_code, time() + 60 );

          $sql = query("UPDATE users SET validation_code = '". escape($reset_code) ."' WHERE email = '". escape($email) ."' ");
          confirm($sql);

          $subject = "RESET CODE";
          $message = "Here is the password reset code {$reset_code} <br>

                   Click here to reset your password http://localhost/login/code.php?email=$email&code=$reset_code

                      ";
          $headers  = "From: noreply@codetheguy.com";

          if(send_mail($email, $subject, $message, $headers)) {

            echo "<div class ='alert alert-success'>Check your email for the reset code!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";

          } else {

            echo "<div class ='alert alert-danger'>Reset code was not sent. Please try again later!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";

          }

        } else {

          echo "<div class ='alert alert-danger'>Email does not exist!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

      } else {

        redirect("login.php");

      }
    
  }
}