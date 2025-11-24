<?php
    include_once("php/nav.php");
    require_once("php/config.php");

    session_start();

    //verify logout request
    verify_logout();

    //check if user is already logged in (log in status is determnined by bool variable: $_SESSION['is_logged_in'])
    already_logged_in();

    //check pswd input for login
    verify_pswd();

    //when you click delete btn: delete blog post specified in $_POST['posts'] from blog_posts.json
    delete_post();

    function verify_logout(){
        if(isset($_POST['logout'])){
            //will reset $_SESSION['is_logged_in'] to null
            session_destroy();
            session_start();
            //setup successful log out msg
            set_msg('You have been successfully logged out!', 0);
        }
    }

    function already_logged_in(){
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in']){
                //setup already logged in msg
                set_msg("You're already logged in!", 0);
            }
        }
    }

    function verify_pswd(){
        //setup pswd hash
        $pswd_hash = '13c74a37961a2f6c0833e5cbc32781a6c136d686604f13aeb056dcd44fb8329b';

        //verify if the $_POST variable contains a password, then if password is correct you are logged in
        if(isset($_POST['pswd'])){
            if(hash('haval256,5', $_POST['pswd'])===$pswd_hash){
                //set login status to TRUE
                $_SESSION['is_logged_in'] = true;

                //setup login msg
                set_msg('You have successfully logged in!', 0);
            }else{
                //setup wrong pswd error msg
                set_msg('Error: Wrong Password Entered!', 1);
            }
        }
    }

    function delete_post(){
        if(isset($_POST['posts'])){
            //get filepath to json file storing blog posts
            $file = 'blog_posts.json';

            //Extract JSON object from file as a string: https://www.php.net/manual/en/function.file-get-contents.php
            $current = file_get_contents($file);

            //turn string into PHP associative array: https://www.w3schools.com/php/php_json.asp
            $current = json_decode($current, true);

            //remove blog post from this associative array where key = $_POST['posts']: https://stackoverflow.com/questions/3053517/how-can-i-remove-a-key-and-its-value-from-an-associative-array
            unset($current[$_POST['posts']]);

            //encode associative array back to json format
            $current = json_encode($current);

            //Write the contents back to the file: https://www.php.net/manual/en/function.file-put-contents.php
            file_put_contents($file, $current);

            //setup successful post deletion msg
            set_msg('Post has been deleted!', 0);
        }
    }
?>
<!DOCTYPE html>
<!--Scroll smooth effect for blog links: https://tailwindcss.com/docs/scroll-behavior#using-smooth-scrolling -->
<html lang="en-US" class="scroll-smooth">
    <head>
        <title>Korey's Blog</title>
        <meta charset="UTF-8">
        <meta name="description" content="Blog">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP, Blog">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/my_style.css">

        <!--adds the stylesheet for trash icon (classes: 'fas', 'fa-trash')-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!--Google Font: https://fonts.google.com/specimen/Smooch+Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet">
        <!--CSS Stylesheet applies font: "Smooch Sans" to all elements in Hero, Main, Aside sections-->
        <link rel="stylesheet"  type="text/css" href="css/blog_style.css">

        <!-- Option 1b) Using Tailwind Play CDN for CSS Styling: https://tailwindcss.com/docs/installation/play-cdn -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <!--Documentation for using Tailwind
            text decoration: https://v3.tailwindcss.com/docs/text-decoration-style#hover-focus-and-other-states
            font size: https://tailwindcss.com/docs/font-size
            font weight: https://tailwindcss.com/docs/font-weight

            default spacing size: https://v3.tailwindcss.com/docs/customizing-spacing#default-spacing-scale
            
            padding: https://tailwindcss.com/docs/padding
            margin: https://tailwindcss.com/docs/margin
            add vertical margin: https://tailwindcss.com/docs/margin#adding-vertical-margin
            set width of element: https://tailwindcss.com/docs/width

            align text center: https://tailwindcss.com/docs/text-align#centering-text

            flex: https://tailwindcss.com/docs/flex
            flex wrap: https://tailwindcss.com/docs/flex-wrap
            align children in a col: https://tailwindcss.com/docs/flex-direction#column
            center items along cross axis: https://tailwindcss.com/docs/align-items#center
            justify items along center of main axis: https://v3.tailwindcss.com/docs/justify-content#center
            justify content evenly: https://tailwindcss.com/docs/justify-content#space-evenly

            float: https://tailwindcss.com/docs/float

            colors: https://tailwindcss.com/docs/colors
            setup background color gradient: https://tailwindcss.com/docs/background-image#setting-gradient-color-stops

            add border radius: https://tailwindcss.com/docs/border-radius

            create an outline on hover: https://tailwindcss.com/docs/outline-width
            mouse hover effects: https://tailwindcss.com/docs/hover-focus-and-other-states

            apply different styles according to screen size: https://v3.tailwindcss.com/docs/responsive-design

            position element to fill parent: https://v3.tailwindcss.com/docs/top-right-bottom-left#placing-a-positioned-element
        -->
    </head>
    <!--Setup background to color gradient that changes from purple to fuschsia to pink-->
    <body class="bg-gradient-to-b from-purple-800 via-fuchsia-500 to-pink-500">
        <div class="body_wrapper">
            <!--Nav Section-->
            <?php
                $webpage->setNav();
            ?>
        </div>
        <div class="body_wrapper">
            <!--Use flex, direction=(row-reverse), a gap of 4 btwn all items inside, and a padding of 4 around this div-->
            <!--all elements inside have minimum width = (minimum-content)-->
            <div id="login_button_container" class="
                p-4 
                flex flex-wrap flex-row-reverse gap-4">
                <!--logout button: has its own form-->
                <form id="logout_form" action="blog.php?page=blog.php" method="post">
                    <input type="hidden" id="logout" name="logout" value="true"></input>
                    <input type="submit" id="logout_btn" value="Log Out" class="
                        bg-red-600 rounded-2xl 
                        hover:bg-red-500 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    </input>
                </form>
                <!--A login button that will display a login form when clicked-->
                <!--Copied code from: https://www.w3schools.com/howto/howto_css_login_form.asp -->
                <button id="login_button" onclick="document.getElementById('form_container').classList.remove('hidden')" class="
                        bg-green-600 rounded-2xl 
                        hover:bg-green-500 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    Login
                </button>
                <!--section where all login/logout msgs are printed out-->
                <div>
                    <?php
                        //Print out msg if it is setup
                        if(isset($_POST['msg'])){
                            echo $_POST['msg'];
                        }

                        //sets up msg
                        function set_msg($string, $flag){
                            if($flag){ //setup red error msg if $flag=1
                                $_POST['msg'] = '<h3 class="text-red-600 text-2xl font-bold p-4 bg-white rounded-2xl">'.$string.'</h3>';
                            }else{ //setup blue msg if $flag=0
                                $_POST['msg'] = '<h3 class="text-blue-600 text-2xl font-bold p-4 bg-white rounded-2xl">'.$string.'</h3>';
                            }
                        }
                    ?>
                </div>
            </div>
            <!--Hidden login form container, appears when login button pressed-->
            <!--Fixed postion in middle of screen-->
            <div id="form_container" class="
                    hidden
                    fixed
                    inset-0
                    flex items-center justify-center">
                <!--login form will send password back to this page using HTTP POST request-->
                <form action="blog.php?page=blog.php" method="post" class="
                        bg-white rounded-2xl
                        p-10">
                    <!--Password input-->
                    <div class="mb-4">
                        <label for="pswd" class="font-bold">Password</label>
                        <input type="password" id="pswd" name="pswd" placeholder="Enter Password" required class="
                            w-full
                            border outline-black rounded-2xl
                            p-2">
                        </input>
                    </div>                    
                    <!--Buttons-->
                    <div class="flex gap-4">
                        <button type="submit" class="
                                w-1/3
                                p-4
                                bg-green-600 rounded-2xl 
                                hover:bg-green-500 hover:outline-2 hover:outline-black hover:text-white">
                            Login
                        </button>
                        <!--Hides login form when you click Cancel btn-->
                        <button type="button"
                            onclick="document.getElementById('form_container').classList.add('hidden')" class="
                                w-1/3
                                p-4
                                bg-red-600 rounded-2xl 
                                hover:bg-red-500 hover:outline-2 hover:outline-black hover:text-white">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
            <script>
                //Hide login form when you click outside its window
                let form = document.getElementById('form_container');
                window.onclick = function(event) {
                    if (event.target == form) {
                        form.classList.add('hidden');
                    }
                }
            </script>
        </div>

        <div class="body_wrapper">
            <!--Hero Section-->
            <!--Display child elements in column and centered, set top and bottom margin to 56(14rem,224px)-->
            <div id="hero" class="
                    text-center
                    flex flex-col items-center justify-center
                    my-56">
                <!--Hero Section Title: big bold text-->
                <!--padding to 5 and bottom margin to 10-->
                <h1 id="hero_title" class="
                        bg-fuchsia-400 rounded-2xl 
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white 
                        text-6xl font-extrabold 
                        p-5 mb-10">
                    Book Review Blog
                </h1>
                <!--Hero Section Text-->
                <!--If (screen takes up minimum of 1024px) {width = 4/5 of the container} else {width = 100%}-->
                <p id="hero_text" class="
                        bg-fuchsia-400 rounded-2xl 
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white
                        text-4xl font-bold
                        w-full lg:w-4/5">
                    Hi! This is my book review blog spot.
                    Here I will write down my thoughts on some books I have read.
                    To be honest I have not been reading much lately...
                    So some of these entries will be comics and some will be books I read a couple of years ago.
                    Be sure to check out any of these authors if anything interests you.
                </p>
            </div>
        </div>

        <!--Blog layout reference: https://www.w3schools.com/howto/howto_css_blog_layout.asp -->
        <!--Using Float left to have 2 columns, Main Section will take up 3/4 of width, Aside will take 1/4-->
        <div class="body_wrapper">
            <!--Row Section: Contains the "Aside" and "Main" sections-->
            <!--Has a gradient background from fuchsia to pink, rounded edges-->
            <div id="row" class="
                    bg-gradient-to-b from-fuchsia-800 to-pink-500 rounded-2xl
                    text-3xl text-center
                    m-4">
                <!--Aside Section: top margin of 10(2.5 rem, 40px)-->
                <!--If (screen takes up minimum of 1024px) {width = 1/4 of the container} else {width = 100%}-->
                <aside id="aside" class="
                        float-right 
                        w-full lg:w-1/4
                        mt-10">
                    <!--Aside List Section-->
                    <!--If (screen takes up minimum of 1024px) {margin right = 10, margin left = none} else {margin left and right = 10}-->
                    <div id="aside_list" class="
                            bg-indigo-500 rounded-2xl
                            hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white 
                            mx-10 lg:ml-0 lg:mr-10
                            pb-2">
                        <!--Aside Title: dashed line text decoration-->
                        <h1 id="aside_title" class="
                                underline decoration-dashed
                                text-6xl font-extrabold mb-5">
                            Table of Contents
                        </h1>
                        <!--Link containers: have a bottom margin of 5(1.25rem, 20px)-->
                        <div id="link1_container" class="mb-5">
                            <a href="#post1" class="hover:outline-2 hover:outline-black">
                                Link to Post1
                            </a>
                        </div>
                        <div id="link2_container" class="mb-5">
                            <a href="#post2" class="hover:outline-2 hover:outline-black">
                                Link to Post2
                            </a>
                        </div>
                        <div id="link3_container" class="mb-5">
                            <a href="#post3" class="hover:outline-2 hover:outline-black">
                                Link to Post3
                            </a>
                        </div>
                        <div id="link4_container" class="mb-5">
                            <a href="#post4" class="hover:outline-2 hover:outline-black">
                                Link to Post4
                            </a>
                        </div>
                    </div>
                </aside>
                <!--Main Section: float right-->
                <!--If (screen takes up minimum of 1024px) {width = 3/4 of the container} else {width = 100%}-->
                <section id="main" class="
                        float-right
                        w-full lg:w-3/4
                        text-3xl">
                    <!--php code for printing out blog posts-->
                    <?php
                        if(file_exists('blog_posts.json')){
                            //extract json file storing posts
                            $posts=json_decode(file_get_contents('blog_posts.json'), true);
                            //Loop through each post
                            foreach ($posts as $key => $value) {
                                //Give all Blog Posts a margin of 10
                                $output = <<<END
                                <article id="{$key}" class="
                                        bg-indigo-500 rounded-2xl
                                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white 
                                        text-2xl font-bold 
                                        m-10">
                                    <h2 class="text-4xl font-bold underline decoration-solid">
                                        {$value['title']}
                                    </h2>
                                    <h3 class="text-3xl">
                                        {$value['author']}
                                    </h3>
                                END;
                                //Loop through paragraphs stored in array (give each a margin of 4)
                                for ($i = 0; $i < count($value['paragraphs']); $i++) {
                                    $output .= <<<END
                                        <p class="m-4">
                                            {$value['paragraphs'][$i]}
                                        </p>
                                    END;
                                }
                                $output .= PHP_EOL.'</article>'.PHP_EOL;
                                //print out html for this iteration's blog post (each post in its own <article>)
                                echo $output;
                            }
                        }
                        //Activates JS file if your are logged in (determined by $_SESSION['is_logged_in']
                        //Will change web page appearance
                        if(isset($_SESSION['is_logged_in'])){
                            echo '<script src="js/logged_in_blog.js"></script>';
                        }
                    ?>
                </section>
            </div>
        </div>

        <!--Footer Section-->
        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>