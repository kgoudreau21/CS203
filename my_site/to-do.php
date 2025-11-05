<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Korey's Website</title>
        <meta charset="UTF-8">
        <meta name="description" content="Korey's To Do List">
        <meta name="keywords" content="HTML, CSS, Javascript, To Do List, To Do">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="my_style.css">

        <!--Import font: font-awesome, Part3 b) of lab7-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <?php
            include_once("nav.php");
        ?>

        <style>
            /*downloaded custom font, reference: https://stackoverflow.com/questions/24990554/how-to-include-a-font-ttf-using-css*/
            @font-face { /*This font is only Capital letters, therefore not used for text input*/
                font-family: nitroEagle;
                src: url('nitro-eagle-font/NitroEagle-KVP1W.ttf') format('truetype');
            }
            @font-face {
                font-family: nitroEagleItalic;
                src: url('nitro-eagle-font/NitroEagleItalicItalic-2v5nW.ttf') format('truetype');
            }

            body{
                /*horizontally align everything in the middle*/
                text-align:center;

                /*setup wallpaper in background*/
                background-image:url('images/cubeWallpaper.jpg');
                background-repeat: no-repeat;
                background-size: auto;
            }

            form{
                font-family: nitroEagle, 'Courier New', monospace;
            }

            form *{
                width:fit-content;
                margin-bottom:10px;
            }

            label, input[type="button"], input[type="text"]{
                background-color: yellow;
                box-shadow: blue 5px 5px;
            }

            input[type="text"]{
                font-family:'Courier New', monospace;
            }

            input[type="button"]{
                font-weight:900;
                font-family: nitroEagleItalic, 'Courier New', monospace;;
            }

            label{
                font-size: xx-large;
            }

            .background{
                /*background*/
                background-color: green;
                box-shadow: black 5px 5px;

                /*Reference: https://www.reddit.com/r/css/comments/ixi96o/how_to_set_width_to_fitcontent_addional_value/?rdt=42546 */
                /*make background envelope elements inside*/
                display: inline-block;

                /*Add some padding to the right to allow shadow of elements inside to stay within background*/
                padding: 0px 10px 0px 0;

                /*5px margin plus extra 5px to right and bottom to account for 5px shadow and allow 5px space*/
                margin: 5px 10px 10px 5px;
            }

            .background li, h1{
                background-color: yellow;
                box-shadow: blue 5px 5px;
                width:fit-content;
            }

            .background h1{
                margin-top:0;
            }

            .background li{
                font-family:'Courier New', monospace;
            }

            li > span:nth-child(1){ /*style only 1st <span> in a <li>: https://developer.mozilla.org/en-US/docs/Web/CSS/:nth-child and https://developer.mozilla.org/en-US/docs/Web/CSS/Child_combinator */
                padding-right:1em;
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
            <form>
                <label for="input"><strong>Enter your task:</strong></label><br>
                <input type="text" id="input" name="input"><br>
                <input type="button" onclick="addItem()" value="Add to your To Do List:">
            </form>
        </div>

        <br>

        <div class="body_wrapper background">
            <h1 style="font-family:nitroEagle">My To Do List:</h1>
            <ul id="list"></ul>
        </div>

        <!--JS file for to do list, needs to be below element with id="list" otherwise JS cannot access it-->
        <script src="to-do.js"></script>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>