<?php
    include_once("php/nav.php");
    require_once("php/config.php");

    session_start();

    verify_login();

    //Will redirect user if they are not logged in
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
        header('Location: http://' . $BASE_URL .  'blog.php');
    }
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Post Editor</title>
        <meta charset="UTF-8">
        <meta name="description" content="Blog">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP, Blog">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/my_style.css">

        <!--Google Font: https://fonts.google.com/specimen/Smooch+Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet">
        <!--CSS Stylesheet applies font: "Smooch Sans" to all elements in Hero, Main, Aside sections-->
        <link rel="stylesheet"  type="text/css" href="css/blog_style.css">

        <!-- Option 1b) Using Tailwind Play CDN for CSS Styling: https://tailwindcss.com/docs/installation/play-cdn -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!--Link to javascript code for Form Validation-->
        <script src="js/postValidation.js"></script>
    </head>
    <body class="bg-gradient-to-b from-purple-800 via-fuchsia-500 to-pink-500">
        <div class="body_wrapper">
            <?php
                $webpage->setNav();
            ?>
        </div>

        <div class="body_wrapper">
            <!--Form to Add a New Post-->
            <form id="create_post" action="" method="post" class="
                    flex flex-col items-center justify-center gap-4
                    m-4">
                <legend class="
                        bg-fuchsia-400 rounded-3xl 
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white 
                        p-5 mb-10">
                    <h2 class="text-3xl font-extrabold">
                        Please Enter The Information for the Book Review You will be Posting:
                    </h2>
                </legend>

                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white">
                    <label for="title" class="text-2xl font-bold underline decoration-solid">
                        Your Post's Title:
                    </label>
                    <input type="text" id="title" name="title" placeholder="Name of Your Book">
                </div>

                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white">
                    <label for="subtitle" class="text-2xl font-bold underline decoration-solid">
                        Your Post's Subtitle:
                    </label>
                    <input type="text" id="subtitle" name="subtitle" placeholder="Your Book's Author">
                </div>

                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white">
                    <label for="year" class="text-2xl font-bold underline decoration-solid">
                        Your Book's Publication Date:
                    </label>
                    <input type="number" id="year" name="year" placeholder="Book's Publication Year">
                </div>

                <!--reff: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/textarea -->
                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white">
                    <label for="review" class="text-2xl font-bold underline decoration-solid">
                        Your Review:
                    </label>
                    <textarea id="review" name="review" placeholder="Write Your Review Here" rows="10" cols="75" maxlength="1000"></textarea>
                </div>
                <div>
                    <input type="submit" id="create_post_btn" value="Create New Post" class="
                        bg-green-600 rounded-2xl 
                        hover:bg-green-500 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    </input>
                </div>
            </form>
        </div>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>