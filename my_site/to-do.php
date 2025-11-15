<?php
    include_once("php/nav.php");
    $webpage = new menu('login.php');

    require_once("php/config.php");
    session_start();

    verify_login();

    function verify_login(){
        //will redirect user if they are not logged in
        if(!$_SESSION['is_logged_in']){
            redirect();
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
        header('Location: http://' . $BASE_URL .  'login.php');
    }
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Korey's Website</title>
        <meta charset="UTF-8">
        <meta name="description" content="Korey's To Do List">
        <meta name="keywords" content="HTML, CSS, Javascript, To Do List, To Do">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/my_style.css">
        <link rel="stylesheet" type="text/css" href="css/to-do_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <style>
            #logout_form{
                postion:relative;
                top:0px;
            }

            #logout_btn{
                position:absolute;
                right:30%;
            }
        </style>
    </head>
    <body>
        <div class="body_wrapper">
            <?php
                $webpage->setNav();
            ?>
        </div>

        <div class="body_wrapper background">
            <form id="logout_form" action="login.php" method="post">
                <input type="hidden" id="logout" name="logout" value="true"></input>
                <input type="submit" id="logout_btn" value="Click to Log Out"></input>
            </form>
            <form>
                <label for="input"><strong>Enter your task:</strong></label><br>
                <input type="text" id="input" name="input"><br>
                <input type="button" onclick="addItem()" value="Add to your To Do List:">
            </form>
        </div>

        <br>

        <div class="body_wrapper background">
            <?php
                if(isset($_COOKIE['username'])){
                    echo '<h1 style="font-family:nitroEagle">'.$_COOKIE['username']."'s To Do List:</h1>";
                } else{
                    echo '<h1 style="font-family:nitroEagle">My To Do List:</h1>';
                }
            ?>
            
            <ul id="list"></ul>
        </div>

        <!--JS file for to do list, needs to be below element with id="list" otherwise JS cannot access it-->
        <script src="js/to-do.js"></script>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>