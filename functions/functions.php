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

  $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
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


/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */


/**=================================================CHECK IF EMAIL EXIST ================================ */

function email_exists($email) {

    $query = query("SELECT id FROM users WHERE email = '{$email}' ");
    confirm($query);

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

      /***********************Email validation******************************************** */
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
      }


    }
}
