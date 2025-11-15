<?php
    include_once("php/nav.php");
    require_once("php/config.php");
    session_start();

    //message flag (for error messages)
    $msg_flag = false;
    $msg = '';

    //setup pswd hash
    $pswd_hash = '13c74a37961a2f6c0833e5cbc32781a6c136d686604f13aeb056dcd44fb8329b';

    //verify loggout request
    verify_logout($msg_flag, $msg);

    //create a message if user is already logged in
    already_logged_in_msg($msg_flag, $msg);

    //check username and pswd input
    //NOTE: Username input is REQUIRED
    verify_inputs($pswd_hash, $username, $msg_flag, $msg);

    function already_logged_in_msg(&$msg_flag, &$msg){
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in']){
                $msg_flag = true;
                $msg .= '<h2 class="blue">You are already logged in.</h2>';
            }
        }
    }

    function verify_logout(&$msg_flag, &$msg){
        if(isset($_POST['logout'])){
            session_destroy();
            session_start();
            $msg_flag = true;
            $msg .= '<h2 class="blue">You have been successfully logged out.</h2>';
        }
    }

    function verify_inputs($pswd_hash, &$username, &$msg_flag, &$msg){
        //check to see if username input entered
        if(isset($_POST['username'])){
            //verify username input
            verify_username($pswd_hash, $username, $msg_flag, $msg);
        }
    }

    function verify_username($pswd_hash, &$username, &$msg_flag, &$msg){
        $username = $_POST['username'];
        // Strip whitespace from the beginning and end of $name
        $username = trim($username);
        //Security against code injection in username
        $username = htmlspecialchars($username);

        //check username to see if its an empty string
        if(strlen($username) > 0){
            //initialize filepath
            $file='login_attempts.json';
            //check user login attempts
            $attempts =& verify_login_attempts($file, $username, $msg_flag, $msg);

            //check log in status
            logged_in_bypass($file, $attempts, $username, $msg_flag, $msg);

            //verify if user is locked out
            verify_locked_out($file, $attempts, $pswd_hash, $username, $msg_flag, $msg);

            save_to_file($file, $attempts);
        }else{
            //error msg: input username not set
            $msg_flag = true;
            $msg .= '<h2 class="red">Error: Username input missing.</h2>';
        }
    }

    function &verify_login_attempts($file, $username, &$msg_flag, &$msg){ //info for returning by ref: https://www.php.net/manual/en/functions.returning-values.php
        //load existing attempts (if file exists)
        if(file_exists($file)){
            $attempts=json_decode(file_get_contents($file), true);

            //verify if user exists in file, then create it
            if(isset($attempts[$username])){
        }else{
            $attempts[$username]=[
                'attempts'=> 0,
                'locked_until' => ''
            ];
        }
    }
        return $attempts;
    }

    function logged_in_bypass($file, &$attempts, &$username, &$msg_flag, &$msg){

        //will redirect user if they are already logged in
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in']){
                //create cookie for username (cookie expires after 2 minute)
                setcookie('username', $username, time()+120);

                redirect($file, $attempts, $msg_flag, $msg);
            }
        }
    }

    function verify_locked_out($file, &$attempts, $pswd_hash, $username, &$msg_flag, &$msg){
        //if user is NOT locked out
        if($attempts[$username]['locked_until']<=time()){
            //verify pswd 
            verify_pswd($file, $attempts, $pswd_hash, $username, $msg_flag, $msg);
        }else{
            $msg_flag=true;
            $msg .= '<h2 class="red">You have been locked out. Remaining time until next login attempt: '.$attempts[$username]['locked_until']-time().' seconds.</h2>';
        }
        save_to_file($file, $attempts);
    }
            
            

    function verify_pswd($file, &$attempts, $pswd_hash, $username, &$msg_flag, &$msg){
        //verify if the $_POST variable contains a password, then if password is correct you can access the to-do list
        if(isset($_POST['pswd'])){
            if(hash('haval256,5', $_POST['pswd'])===$pswd_hash){
                //create cookie for username (cookie expires after 1 minute)
                setcookie('username', $username, time()+60);

                //set login status to TRUE
                $_SESSION['is_logged_in'] = true;

                redirect($file, $attempts, $msg_flag, $msg);
            }else{
                //add 1 to login attempts counter
                $attempts[$username]['attempts'] += 1;

                //if counter is 3 or higher lock them out for 30 secs
                if($attempts[$username]['attempts']>=3){
                    $attempts[$username]['locked_until'] = time() + (30);
                    $attempts[$username]['attempts'] = 0;

                    //print an explanation
                    $msg_flag=true;
                    $msg .= '<h2 class="red">3 Failed Login Attempts Detected: You have been locked out for 30 seconds.</h2>';
                }else{
                    //set error message flag to true
                    $msg_flag=true;
                    switch($attempts[$username]['attempts']){
                        case 1:
                            $msg .= '<h2 class="red">Incorrect Password: This is your 1st attempt.</h2>';
                            break;
                        case 2:
                            $msg .= '<h2 class="red">Incorrect Password: This is your 2nd attempt.</h2>';
                            break;
                        case 3:
                            $msg .= '<h2 class="red">Incorrect Password: This is your 1st attempt.</h2>';
                            break;
                    }
                }
            }
        }
        save_to_file($file, $attempts);
    }

    function redirect($file, &$attempts, &$msg_flag, &$msg){
        //setting up base URL
        if ($_SERVER['SERVER_NAME'] === 'localhost') {
            $BASE_URL= $_SERVER['HTTP_HOST'] . '/CS203/my_site/'; //website file location for XAMPP
        } else if ($_SERVER['SERVER_NAME'] === 'osiris.ubishops.ca'){
            $BASE_URL= $_SERVER['HTTP_HOST'] . '/home/kgoudreau/'; //website file location for Osiris
        } else {
            $BASE_URL= $_SERVER['HTTP_HOST'];
        }
        
        save_to_file($file, $attempts);

        header('Location: http://' . $BASE_URL .  'to-do.php');

        //error msg if to do list page not found
        $msg_flag = true;
        $msg .= '<h2 class="red">Error: To-Do List page not found.</h2>';
    }

    function save_to_file($file, &$attempts){
        //Before finishing the code, save back all values in the file
        file_put_contents($file, json_encode($attempts));
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

        <style>
            .red{
                font-family: nitroEagle, 'Courier New', monospace;
                text-shadow: 2px 2px red;
            }

            .blue{
                font-family: nitroEagle, 'Courier New', monospace;
                text-shadow: 2px 2px blue;
            }
        </style>
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
                    }else{
                        echo '<input type="text" id="username" name="username"><br>';
                    }
                ?>
                <label for="pswd"><strong>Password:</strong></label><br>
                <input type="password" id="pswd" name="pswd"><br>
                <input type="submit" value="Submit">
            </form>
            <?php

                if($msg_flag){
                    echo $msg;
                }
            ?>
        </div>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>