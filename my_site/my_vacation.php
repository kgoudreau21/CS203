<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Korey's Vacation</title>
        <meta charset="UTF-8">
        <meta name="description" content="Vacation Webpage">
        <meta name="keywords" content="HTML, CSS, Vacation">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="css/my_style.css">
        
        <?php
            include_once("php/nav.php");
        ?>
    </head>

    <body style="background-image:url('images/vacationBackground.jpg'); background-repeat:no-repeat; background-attachment:fixed; background-size:100%;">
        
        <div class="body_wrapper">
            <?php
                $webpage->setNav();
            ?>
        </div>

        <div class="body_wrapper" style="text-align:center;">
            <h1 style="color:white;">
                Welcome to Hawaii!!!
            </h1>
            <div class="center">
                <img src="images/coconutDrink.jpg" alt="A coconut drink with a little umbrella in it." title="So Refreshing!" style="width:40%; border:0.5em solid blue; border-radius:1em;">
            </div>
            
        </div>

        <div class="body_wrapper" style="text-align:center;">
            <h1 style="color:black;">Board a Plane Back Home:
                <a href="index.php">
                    <img src="images/airplane.jpg" alt="Boarding Airplane to go back Home" title="Time to go back home..." style="width:10%; border-radius:0.5em;">
                </a>
            </h1>
            <a class=”center” href="index.php">Link to Homepage</a>
            <br>
        </div>

        <?php
            $webpage->setFooter();
        ?>

    </body>
</html>