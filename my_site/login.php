<?php
//error message flag (if password input is wrong)
$wrong_pswd = false;
$error_msg = '<h2 style="color:red">Error: Input Password is Incorrect!</h2>';

//setup pswd hash
$pswd_hash = '13c74a37961a2f6c0833e5cbc32781a6c136d686604f13aeb056dcd44fb8329b';

//verify if the $_POST variable contains a password
//if password is correct, then you can access the to-do list
if(isset($_POST['pswd'])){
    if(hash('haval256,5', $_POST['pswd'])===$pswd_hash){ //I am using hash alg.: "haval256,5"
        //setting up base URL
        if ($_SERVER['SERVER_NAME'] === 'localhost') {
            $BASE_URL= $_SERVER['HTTP_HOST'] . '/CS203/my_site/'; //website file location for XAMPP
        } else if ($_SERVER['SERVER_NAME'] === ' osiris.ubishops.ca'){
            $BASE_URL= $_SERVER['HTTP_HOST'] . '/home/kgoudreau/'; //website file location for Osiris
        } else {
            $BASE_URL= $_SERVER['HTTP_HOST'];
        }
        header('Location: http://' . $BASE_URL .  'to-do.php');
        die('Error: page for "To Do List" not found!');
    }else{
        //set error message flag to true
        $wrong_pswd=true;
    }
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

        <?php
            include_once("php/nav.php");
        ?>
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
                <label for="pswd"><strong>Enter your Login Password:</strong></label><br>
                <input type="password" id="pswd" name="pswd"><br>
                <input type="submit" value="Submit">
            </form>
            <?php
                if($wrong_pswd){
                    echo $error_msg;
                }
            ?>
        </div>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>