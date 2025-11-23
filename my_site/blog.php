<?php
    include_once("php/nav.php");
    require_once("php/config.php");

    session_start();

    //setup pswd hash
    $pswd_hash = '13c74a37961a2f6c0833e5cbc32781a6c136d686604f13aeb056dcd44fb8329b';

    //verify logout request
    verify_logout();

    //check if user is already logged in
    already_logged_in();

    //check pswd input for login
    verify_pswd($pswd_hash);

    function verify_logout(){
        if(isset($_POST['logout'])){
            session_destroy();
            session_start();
            //setup successful log out msg
            $_POST['msg']='<h3 class="text-blue-600 text-2xl font-bold p-4 bg-white rounded-2xl">You have been successfully logged out!</h3>';
        }
    }

    function already_logged_in(){
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in']){
                //setup already logged in msg
                $_POST['msg']='<p class="text-blue-600 text-2xl font-bold p-4 bg-white rounded-2xl">'."You're already logged in!</p>";

                //setup page for logged in user
                setup_page_logged_in();
            }
        }
    }
            
    function verify_pswd($pswd_hash){
        //verify if the $_POST variable contains a password, then if password is correct you are logged in
        if(isset($_POST['pswd'])){
            if(hash('haval256,5', $_POST['pswd'])===$pswd_hash){
                //set login status to TRUE
                $_SESSION['is_logged_in'] = true;

                //setup login msg
                $_POST['msg']='<p class="text-blue-600 text-2xl font-bold p-4 bg-white rounded-2xl">You have successfully logged in!</p>';

                //setup page for logged in user
                setup_page_logged_in();
            }else{
                //setup wrong pswd msg
                $_POST['msg']='<p class="text-red-600 text-2xl font-bold p-4 bg-white rounded-2xl">Error: Wrong Password Entered!</p>';
            }
        }
    }

    function setup_page_logged_in(){
        //sets up page for logged in user
    }
?>
<!DOCTYPE html>
<!--Scroll smooth effect for blog links: https://tailwindcss.com/docs/scroll-behavior#using-smooth-scrolling-->
<html lang="en-US" class="scroll-smooth">
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
        <!--Documentation for using Tailwind
            text decoration: https://v3.tailwindcss.com/docs/text-decoration-style#hover-focus-and-other-states
            font size: https://tailwindcss.com/docs/font-size
            font weight: https://tailwindcss.com/docs/font-weight

            default spacing size: https://v3.tailwindcss.com/docs/customizing-spacing#default-spacing-scale
            padding: https://tailwindcss.com/docs/padding
            margin: https://tailwindcss.com/docs/margin
            add vertical margin: https://tailwindcss.com/docs/margin#adding-vertical-margin
            width of element: https://tailwindcss.com/docs/width

            align text center: https://tailwindcss.com/docs/text-align#centering-text

            flex: https://tailwindcss.com/docs/flex
            align children in a col: https://tailwindcss.com/docs/flex-direction#column
            center items along cross axis in flex: https://tailwindcss.com/docs/align-items#center
            justify items along center of main axis: https://v3.tailwindcss.com/docs/justify-content#center 

            float left: https://tailwindcss.com/docs/float#floating-elements-to-the-left

            colors: https://tailwindcss.com/docs/colors
            setup background color gradient: https://tailwindcss.com/docs/background-image#setting-gradient-color-stops

            add border radius: https://tailwindcss.com/docs/border-radius

            create an outline on hover: https://tailwindcss.com/docs/outline-width

            mouse hover effects: https://tailwindcss.com/docs/hover-focus-and-other-states

            CSS @media equivalent: https://v3.tailwindcss.com/docs/responsive-design
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
            <!--make all elements in this container float right so that they appear at top right of page (below nav bar)-->
            <div id="login_button_container" class="pt-4 pr-4">
                <!--logout button: has its own form-->
                <form id="logout_form" action="blog.php?page=blog.php" method="post" class="block float-right pl-4">
                    <input type="hidden" id="logout" name="logout" value="true"></input>
                    <input type="submit" id="logout_btn" value="Log Out" class="
                        bg-red-600 rounded-2xl 
                        hover:bg-red-500 hover:outline hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        p-4"></input>
                </form>
                <!--A login button that will display a login form when clicked-->
                <!--Copied code from: https://www.w3schools.com/howto/howto_css_login_form.asp -->
                <button id="login_button" onclick="document.getElementById('form_container').classList.remove('hidden')" class="
                        bg-green-600 rounded-2xl 
                        hover:bg-green-500 hover:outline hover:outline-2 hover:outline-black hover:text-white
                        block float-right
                        text-2xl font-bold
                        p-4">
                    Login
                </button>
                <!--section where all login/logout msgs are printout out for user to see-->
                <div class="block float-right pr-4">
                    <?php
                        //Print out login msg if it is setup
                        if(isset($_POST['msg'])){
                            echo $_POST['msg'];
                        }
                    ?>
                </div>
            </div>
            <!--Hidden login form, appears when login button pressed-->
            <div id="form_container" class="
                    hidden
                    fixed 
                    inset-0
                    flex items-center justify-center">
                <!--login form will pass pswd input back to this same page using POST method-->
                <form action="blog.php?page=blog.php" method="post" class="
                        bg-white rounded-2xl
                        p-10">
                    <!--Password input-->
                    <div class="mb-4">
                        <label for="pswd" class="font-bold">Password</label>
                        <input type="password" id="pswd" name="pswd" placeholder="Enter Password" required class="
                            w-full 
                            border outline-black rounded-2xl
                            p-2">/input>
                    </div>
                    <!--Buttons-->
                    <div class="flex justify-center">
                        <button type="submit" class="
                                w-1/2
                                bg-green-600 rounded-2xl 
                                hover:bg-green-500 hover:outline hover:outline-2 hover:outline-black hover:text-white">
                            Login
                        </button>
                        <!--Hides login form when you click Cancel btn-->
                        <button type="button"
                            onclick="document.getElementById('form_container').classList.add('hidden')" class="
                                w-1/2
                                bg-red-600 rounded-2xl 
                                hover:bg-red-500 hover:outline hover:outline-2 hover:outline-black hover:text-white">
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
            <!--Using display flex in column direction, and center/justify items along y axis, center text, top and bottom margin of 56(14 rem or 224px using default spacing)-->
            <div id="hero" class="
                    text-center
                    flex flex-col items-center justify-center
                    my-56">
                <!--Hero Section Title: text weight and font size extrabold-->
                <!--fuchsia color background with rounded edges, outline/bg color/text color changes on hover, padding of 5 and bottom margin of 10-->
                <h1 id="hero_title" class="
                        bg-fuchsia-400 rounded-2xl 
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                        text-6xl font-extrabold 
                        p-5 mb-10">
                    Book Review Blog
                </h1>
                <!--Hero Section Text-->
                <!--If (screen takes up minimum of 1024px) {width = 4/5 of the container} else {width = 100%}-->
                <p id="hero_text" class="
                        bg-fuchsia-400 rounded-2xl 
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white
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
                    display-block
                    text-3xl text-center justify-center
                    m-4">
                <!--Main Section: float left-->
                <!--If (screen takes up minimum of 1024px) {width = 3/4 of the container} else {width = 100%}-->
                <section id="main" class="
                        float-left
                        w-full lg:w-3/4
                        text-3xl">
                    <!--Posts: all have margin of 10-->
                    <!--php code for printing out blog posts-->
                    <?php
                        if(file_exists('blog_posts.json')){
                            //extract json file storing posts
                            $posts=json_decode(file_get_contents('blog_posts.json'), true);
                            //Loop through each post stored in json file dynamically
                            foreach ($posts as $key => $value) {
                                //add the post content to $output using heredoc: https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
                                $output = <<<END
                                <article id="{$key}" class="
                                        bg-indigo-500 rounded-2xl
                                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                                        text-2xl font-bold 
                                        m-10">
                                    <h2 class="text-4xl font-bold underline decoration-solid">
                                        {$value['title']}
                                    </h2>
                                    <h3 class="text-3xl">
                                        {$value['author']}
                                    </h3>
                                END;
                                // Loop through paragraphs of the current iteration $key
                                for ($i = 0; $i < count($value['paragraphs']); $i++) {
                                    $output .= <<<END
                                        <p class="m-4">
                                            {$value['paragraphs'][$i]}
                                        </p>
                                    END;
                                }
                                $output .= PHP_EOL.'</article>'.PHP_EOL;
                                
                                echo $output;
                            }
                        }
                    ?>
                </section>
                <!--Aside Section-->
                <!--If (screen takes up minimum of 1024px) {width = 1/4 of the container} else {width = 100%}-->
                <!--float left, top margin of 10(2.5 rem, 40px)-->
                <aside id="aside" class="
                        float-left 
                        w-full lg:w-1/4
                        mt-10">
                    <!--Aside List Section-->
                    <!--If (screen takes up minimum of 1024px) {margin right = 10, margin left = none} else {margin left and right = 10}-->
                    <div id="aside_list" class="
                            bg-indigo-500 rounded-2xl
                            hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                            mx-10 lg:ml-0 lg:mr-10
                            pb-2">
                        <!--Aside Title: dashed line text decoration-->
                        <h1 id="aside_title" class="
                                underline decoration-dashed
                                text-6xl font-extrabold mb-5">
                            Table of Contents
                        </h1>
                        <!--Link containers: have a bottom margin of 5(1.25rem, 20px)-->
                        <!--Have fuchsia background with rounded edges, background color/text color/outline changes when you hover mouse-->
                        <div id="link1_container" class="mb-5">
                            <a href="#post1" class="hover:outline hover:outline-2 hover:outline-black">
                                Link to Post1
                            </a>
                        </div>
                        <div id="link2_container" class="mb-5">
                            <a href="#post2" class="hover:outline hover:outline-2 hover:outline-black">
                                Link to Post2
                            </a>
                        </div>
                        <div id="link3_container" class="mb-5">
                            <a href="#post3" class="hover:outline hover:outline-2 hover:outline-black">
                                Link to Post3
                            </a>
                        </div>
                        <div id="link4_container" class="mb-5">
                            <a href="#post4" class="hover:outline hover:outline-2 hover:outline-black">
                                Link to Post4
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!--Footer Section-->
        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>