<?php
    include_once("php/nav.php");
    require_once("php/config.php");

    //debugging
    //$ok = session_start(); // will return false if it couldn’t write a file
    //echo "successful session start?";
    //var_dump($ok); //using var_dump to make sure we see ‘false’ results.

    session_start();

    //setup pswd hash
    $pswd_hash = '13c74a37961a2f6c0833e5cbc32781a6c136d686604f13aeb056dcd44fb8329b';

    //verify loggout request
    verify_logout();

    //redirect if user is already logged in
    already_logged_in();

    //check username and pswd input
    //NOTE: Username input is REQUIRED
    verify_inputs($pswd_hash, $username);

    function verify_logout(){
        if(isset($_POST['logout'])){
            session_destroy();
            session_start();
            $_POST['logged_out_msg'] = 'You have been successfully logged out.';
        }
    }

    function already_logged_in(){
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in']){
                redirect();
            }
        }
    }

    function verify_inputs($pswd_hash, &$username){
        //check to see if username input entered
        if(isset($_POST['username'])){
            //verify username input
            verify_username($pswd_hash, $username);
        }
    }

    function verify_username($pswd_hash, &$username){
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
            $attempts =& verify_login_attempts($file, $username);

            //verify if user is locked out
            verify_locked_out($file, $attempts, $pswd_hash, $username);

            save_to_file($file, $attempts);
        }else{
            //error msg: input username not set
            add_error('Error: Username input missing.');
        }
    }

    function &verify_login_attempts($file, $username){ //info for returning by ref: https://www.php.net/manual/en/functions.returning-values.php
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

    function verify_locked_out($file, &$attempts, $pswd_hash, $username){
        //if user is NOT locked out
        if($attempts[$username]['locked_until']<=time()){
            //verify pswd 
            verify_pswd($file, $attempts, $pswd_hash, $username);
        }else{
            //you have been locked out error msg
            add_error('You have been locked out. Remaining time until next login attempt: '.$attempts[$username]['locked_until']-time().' seconds.');
        }
    }
            
            

    function verify_pswd($file, &$attempts, $pswd_hash, $username){
        //verify if the $_POST variable contains a password, then if password is correct you can access the to-do list
        if(strlen($_POST['pswd'])>0){
            if(hash('haval256,5', $_POST['pswd'])===$pswd_hash){
                //create cookie for username (cookie expires after 1 minute)
                setcookie('username', $username, time()+60);

                //set login status to TRUE
                $_SESSION['is_logged_in'] = true;

                save_to_file($file, $attempts);
                redirect();
            }else{
                //add 1 to login attempts counter
                $attempts[$username]['attempts'] += 1;

                //if counter is 3 or higher lock them out for 30 secs
                if($attempts[$username]['attempts']>=3){
                    $attempts[$username]['locked_until'] = time() + (30);
                    $attempts[$username]['attempts'] = 0;

                    //print an explanation
                    add_error('3 Failed Login Attempts Detected: You have been locked out for 30 seconds.');
                }else{
                    //set error message flag to true
                    switch($attempts[$username]['attempts']){
                        case 1:
                            add_error('Incorrect Password: This is your 1st attempt.');
                            break;
                        case 2:
                            add_error('Incorrect Password: This is your 2nd attempt.');
                            break;
                    }
                }
            }
        } else{
            add_error('Error: No Password Entered.');
        }
    }

    function redirect(){
        //setting up base URL = 'website URL' + 'path to directory containing login.php'
        //ref: https://www.sololearn.com/en/Discuss/433812/what-is-the-difference-between-_serverscript_filename-and-_serverscript_name
        //ref: https://www.php.net/manual/en/function.dirname.php
        $BASE_URL= $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/'; 
        header('Location: http://' . $BASE_URL .  'to-do.php');

        //error msg if to do list page not found
        add_error('Error: To-Do List page not found.');
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
            //VIEW part of php code
                function add_error($string){ //adds string to error messages (function called in MODEL part of php code)
                    $_POST['error_msgs'][] = $string;
                }

                if(isset($_POST['error_msgs'])){
                    foreach($_POST['error_msgs'] as $error_msg){
                        echo '<h2 class="red">'.$error_msg.'</h2>';
                    }
                }

                if(isset($_POST['logged_out_msg'])){
                    echo '<h2 class="blue">'.$_POST['logged_out_msg'].'</h2>';
                }
            ?>
        </div>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>