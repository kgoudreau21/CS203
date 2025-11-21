<?php
    include_once("php/nav.php");
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Korey's Blog</title>
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
        <link rel="stylesheet"  type="text/css" href="css/blog_style.css">

        <!-- Option 1b) Using Tailwind Play CDN for CSS Styling: https://tailwindcss.com/docs/installation/play-cdn -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Documentation for using Tailwind
            align text: https://tailwindcss.com/docs/text-align
            font size: https://tailwindcss.com/docs/font-size
            font weight: https://tailwindcss.com/docs/font-weight

            padding: https://tailwindcss.com/docs/padding
            margin: https://tailwindcss.com/docs/margin
            width of element: https://tailwindcss.com/docs/width

            flex: https://tailwindcss.com/docs/flex
            align children in a col: https://tailwindcss.com/docs/flex-direction
            center items along cross axis in flex: https://tailwindcss.com/docs/align-items

            colors: https://tailwindcss.com/docs/colors
            Setup background to color gradient: https://tailwindcss.com/docs/background-image 
            Change bg/text color on hover: https://tailwindcss.com/docs/hover-focus-and-other-states

            add border radius: https://tailwindcss.com/docs/border-radius

            create an outline on hover: https://tailwindcss.com/docs/outline-width
        -->
    </head>
    <body class="bg-gradient-to-b from-red-800 via-orange-500 to-amber-500">
        <!--Nav Section-->
        <div>
            <?php
                $webpage->setNav();
            ?>
        </div>

        <!--Hero Section-->
        <div id="hero" class="
            text-center
            flex flex-col items-center
            m-40"> <!--display flex as col, and center items along col length-->
            <h1 class="
                    bg-yellow-300 hover:bg-red-700 rounded-2xl 
                    hover:outline hover:outline-2 hover:outline-black hover:text-white 
                    text-4xl font-bold 
                    size-fit p-5 mb-10">
                Book Review Blog
            </h1>
            <p class="
                bg-yellow-300 hover:bg-red-700 rounded-2xl 
                hover:outline hover:outline-2 hover:outline-black hover:text-white 
                text-2xl 
                size-fit w-9/10 ">
                Hi! This is my book review blog spot.
                Here I will write down my thoughts on some books I have read.
                To be honest I have not been reading much lately...
                So some of these entries will be comics and some will be books I read a couple of years ago.
            </p>
        </div>

        <!--Footer Section-->
        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>