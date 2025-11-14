<?php
include_once("php/nav.php");
require_once("php/config.php");
session_start();

//error message flag (if password input is wrong)
$error_flag = false;
$error_msg = '<h2 style="color:red">Error: Input Password is Incorrect!</h2>';

//setup pswd hash
$pswd_hash = '13c74a37961a2f6c0833e5cbc32781a6c136d686604f13aeb056dcd44fb8329b';

//check log in status
//will redirect user if they are already logged in
if(isset($_SESSION['is_logged_in'])){
    if($_SESSION['is_logged_in']){
        redirect();
    }else{
        $error_flag = true;
        $error_msg .= '<h2 style="color:red">Error: variable "is_logged_in" in _SESSION set to false!</h2>';
    }
}

//check to see if username input entered, if yes then set variable $username to it
$username = check_username();

verify_pswd($username, $pswd_hash);


function verify_pswd($username, $pswd_hash){
    //verify if the $_POST variable contains a password, then if password is correct you can access the to-do list
    if(isset($_POST['pswd'])){
        if(hash('haval256,5', $_POST['pswd'])===$pswd_hash){

            //create cookie for username (cookie expires after 1 minute)
            check_username();
            setcookie('username', $username, time()+60);

            //set login status to TRUE
            $_SESSION['is_logged_in'] = true;

            redirect();
        }else{
            //set error message flag to true
            $wrong_pswd=true;
        }
        return;
    }
}

function check_username(){
    //check username, if not set then return null;
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        // Strip whitespace from the beginning and end of $name
        $username = trim($username);
        //Security against code injection in username
        $username = htmlspecialchars($username);
        //check username to see if its an empty string
        if(strlen($username) > 0){
            return $username;
        }else{
            //error msg: input username not set
            die('Error: Username input missing!');
        }
    }else{
        return null;
    }
}

function redirect(){
    //setting up base URL
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        $BASE_URL= $_SERVER['HTTP_HOST'] . '/CS203/my_site/'; //website file location for XAMPP
    } else if ($_SERVER['SERVER_NAME'] === 'osiris.ubishops.ca'){
        $BASE_URL= $_SERVER['HTTP_HOST'] . '/home/kgoudreau/'; //website file location for Osiris
    } else {
        $BASE_URL= $_SERVER['HTTP_HOST'];
    }
    header('Location: http://' . $BASE_URL .  'to-do.php');
    die('Error: page for "To Do List" not found!');
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="description" content="Login Page for To Do List">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP, Login, To Do List, To Do">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/my_style.css">
        <link rel="stylesheet" type="text/css" href="css/to-do_style.css">
   
        <!--Import font: font-awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    </head>
    <body>
        <div class="body_wrapper">
            <?php
                $webpage = new menu('login.php');
                $webpage->setNav();
            ?>
        </div>

        <div class="body_wrapper background">
            <form action="login.php" method="post">
                <label for="username"><strong>Your Username:</strong></label><br>
                <?php
                    if(isset($_COOKIE['username'])){
                        echo '<input type="text" id="username" name="username" value="'.$_COOKIE['username'].'"><br>';
                    } else{
                        echo '<input type="text" id="username" name="username"><br>';
                    }
                ?>
                <label for="pswd"><strong>Password:</strong></label><br>
                <input type="password" id="pswd" name="pswd"><br>
                <input type="submit" value="Submit">
            </form>
            <?php
                //debugging
                print_r($_COOKIE);
                print_r($_SESSION);

                if($error_flag){
                    echo $error_msg;
                }
            ?>
        </div>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>