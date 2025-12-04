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
            //setup file path
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

        <!--prevent page resubmission from causing another duplicate post deletion-->
        <script src="js/preventResubmission.js"></script>

        <!--Optional Item 2: Style Navbar using Flexbox and @media-->
        <link rel="stylesheet" type="text/css" href="css/my_style.css">

        <!--adds the stylesheet for trash icon (classes: 'fas', 'fa-trash')-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!--Google Font: https://fonts.google.com/specimen/Smooch+Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet">
        <!--CSS Stylesheet applies font: "Smooch Sans" to all elements in Hero, Main, Aside sections-->
        <link rel="stylesheet"  type="text/css" href="css/blog_style.css">

        <!-- Optional Item 1b) Using Tailwind Play CDN for CSS Styling: https://tailwindcss.com/docs/installation/play-cdn -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <!--Setup background to color gradient that changes from purple to fuschsia to pink, ref: https://tailwindcss.com/docs/background-image#setting-gradient-color-stops-->
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
                        hover:bg-red-400 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    </input>
                </form>
                <!--A login button that will display a login form when clicked-->
                <!--Copied code from: https://www.w3schools.com/howto/howto_css_login_form.asp -->
                <button id="login_button" onclick="document.getElementById('form_container').classList.remove('hidden')" class="
                        bg-green-600 rounded-2xl 
                        hover:bg-green-400 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    Login
                </button>
                <!--add_post button, only visible to logged in user, redirects to new page-->
                <form id="add_post" action="add_post.php?page=blog.php" method="post" class="hidden">
                    <input type="submit" id="add_post_btn" value="Add Post" class="
                        bg-blue-600 rounded-2xl 
                        hover:bg-blue-400 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    </input>
                </form>
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
                                hover:bg-green-400 hover:outline-2 hover:outline-black hover:text-white">
                            Login
                        </button>
                        <!--Hides login form when you click Cancel btn-->
                        <button type="button"
                            onclick="document.getElementById('form_container').classList.add('hidden')" class="
                                w-1/3
                                p-4
                                bg-red-600 rounded-2xl 
                                hover:bg-red-400 hover:outline-2 hover:outline-black hover:text-white">
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
                        text-6xl font-extrabold 
                        p-5 mb-10">
                    Book Review Blog
                </h1>
                <!--Hero Section Text-->
                <!--If (screen takes up minimum of 1024px) {width = 4/5 of the container} else {width = 100%}-->
                <p id="hero_text" class="
                        bg-fuchsia-400 rounded-2xl
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
        <div class="body_wrapper">
            <!--Row1 Section: Contains the "Aside" and "Main" sections-->
            <!--Uses flex, flex wrap, direction=(row-reverse), justify evenly for even gaps around all children-->
            <div id="row1" class="
                    flex flex-wrap flex-row-reverse justify-evenly
                    bg-gradient-to-b from-fuchsia-800 to-pink-500 rounded-2xl
                    m-2">
                <!--Aside Section Container: display in column, centered in middle along y-axis-->
                <!--If (screen takes up minimum of 1024px) {width = 1/4 of the container} else {width = 100%}-->
                <div id="aside_container" class="
                        p-4
                        w-full lg:w-1/4
                        flex-col items-center">
                    <!--Aside Section: flex col-->
                    <!--If (screen takes up minimum of 1024px) {margin right = 10, margin left = none} else {margin left and right = 10}-->
                    <aside id="aside" class="
                            text-2xl text-center
                            p-4
                            flex flex-col gap-4
                            bg-indigo-500 rounded-2xl">
                        <!--Aside Title: dashed line text decoration-->
                        <h1 id="aside_title" class="
                                underline decoration-dashed
                                text-6xl font-extrabold">
                            Table of Contents
                        </h1>
                        <!--Generate links to all blog posts-->
                        <?php
                            //extract JSON as an associative array
                            $posts=json_decode(file_get_contents('blog_posts.json'), true);

                            //Optional Part9 a), sort by date or title if specified in $_GET['sortingOrder']
                            //copied code from: https://www.php.net/manual/en/function.asort.php#105797
                            if(isset($_GET['sortingOrder'])){
                                if($_GET['sortingOrder']==='byDate'){ //sorting dates in form Y-M-D
                                    // Define the custom sort function
                                    function custom_sort($a,$b) {
                                        return $a['post_date']>$b['post_date'];
                                    }
                                    // Sort the multidimensional array
                                    usort($posts, "custom_sort");
                                }
                                if($_GET['sortingOrder']==='byTitle'){ //sorting by title in alphabetical order
                                    // Define the custom sort function
                                    function custom_sort($a,$b) {
                                        return $a['title']>$b['title'];
                                    }
                                    // Sort the multidimensional array
                                    usort($posts, "custom_sort");
                                }
                            }
                            
                            //loop through each post in $posts and print out a link for each
                            foreach ($posts as $key => $value) {
                                $output = <<<END
                                <div class="bg-white rounded-2xl hover:outline-2 hover:outline-black">
                                    <a id="{$key}_link" href="#{$key}">
                                        {$value['title']}
                                    </a>
                                </div>
                                END;
                                echo $output.PHP_EOL;
                            }
                        ?>
                        <!--Part 9 a) :add a sort by date or by title feature-->
                        <!--When a button is pressed, a GET request is sent to blog.php with $_GET[sortingOrder] set to "byDate" or "byTitle"-->
                        <form action="blog.php" method="get" class="
                                text-2xl text-center
                                p-4
                                flex flex-col gap-4">
                            <legend class="text-6xl font-extrabold underline decoration-dashed">
                                Sort Posts:
                            </legend>
                            <!--hidden input will contain the order of the posts-->
                            <input id="sortingOrder" name="sortingOrder" type="hidden"></input>
                            <input id="page" name="page" type="hidden" value="blog.php"></input>
                            <input type="submit" onclick="sortPostsByDate()" value="Sort Posts by Date" class="
                                    bg-white rounded-2xl hover:outline-2 hover:outline-black">
                            </input>
                            <input type="submit" onclick="sortPostsByTitle()" value="Sort Posts by Title" class="
                                    bg-white rounded-2xl hover:outline-2 hover:outline-black">
                            </input>
                        </form>
                        <script src="js/sortPosts.js"></script>
                    </aside>
                </div>
                <!--Main Section: flex col-->
                <!--If (screen takes up minimum of 1024px) {width = 3/4 of the container} else {width = 100%}-->
                <section id="main" class="
                        p-4
                        flex flex-col gap-5
                        w-full lg:w-3/4">
                    <!--php code for printing out blog posts-->
                    <?php
                        if(file_exists('blog_posts.json')){
                            //Loop through each post, using variable $posts declared previously in aside section code
                            foreach ($posts as $key => $value) {
                                //Optional Part 3 b): Make content collapsible
                                //The title is a button, when clicked will show the post's content that is in a "hidden" <div>
                                $output = <<<END
                                <article id="{$key}" class="
                                        p-4
                                        flex flex-col gap-4
                                        bg-fuchsia-400 rounded-3xl
                                        font-bold">
                                    <button class="
                                            collapsible
                                            flex flex-wrap justify-center items-center gap-4
                                            bg-indigo-500 rounded-3xl
                                            hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white ">
                                        <h2 class="underline decoration-solid text-4xl">
                                            {$value['title']}
                                        </h2>
                                        <h3 class="text-3xl">
                                            Posted: {$value['post_date']}
                                        </h3>
                                    </button>
                                    <div class="hidden flex flex-col gap-4">
                                        <h3 class="text-3xl text-center">
                                            {$value['author']}
                                        </h3>
                                END;
                                //Loop through paragraphs stored in array (give each a margin of 4)
                                for ($i = 0; $i < count($value['paragraphs']); $i++) {
                                    $output .= <<<END
                                        <p class="text-2xl">
                                            {$value['paragraphs'][$i]}
                                        </p>
                                    END;
                                }
                                $output .= PHP_EOL.'</div></article>'.PHP_EOL;
                                //print out html for this iteration's blog post (each post in its own <article>)
                                echo $output;
                            }
                            //Optional Part 3 b)
                            echo '<script src="js/collapsible_content.js"></script>';
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

        <!--Optional Part 7: comment Section-->
        <div class="body_wrapper">
            <!--Row2 Section: Contains the "post_comment" and "comment" sections-->
            <!--Uses same layout as "row1" section above but mirrored-->
            <div id="row2" class="
                    flex flex-wrap justify-evenly
                    bg-gradient-to-b from-fuchsia-800 to-pink-500 rounded-2xl
                    m-2">
                <!--post_comment Section Container-->
                <div id="post_comment_container" class="
                        p-4
                        w-full lg:w-1/4
                        flex-col items-center">
                        <!--post_comment Section, will send POST Request containing comment to post-->
                        <form id="post_comment" action="blog.php?page=blog.php" method="post" class="
                                text-2xl
                                p-4
                                flex flex-col gap-4 content-start
                                bg-fuchsia-400 rounded-2xl">
                            <!--post_comment Section Title-->
                            <legend class="
                                    text-center
                                    underline decoration-dashed
                                    text-4xl font-extrabold">
                                Post Your Comment:
                            </legend>
                            <label for="name" class="
                                    text-2xl font-bold underline decoration-solid">
                                Enter your Name
                            </label>
                            <!--name input is optional, if not entered then value set to "anonymous"-->
                            <input id="name" name="name" type="text" default="anonymous" placeholder="(optional)" class="
                                rounded-3xl outline-2 
                                hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white 
                                p-2">
                            </input>
                            <label for="comment_text" class="
                                    text-2xl font-bold underline decoration-solid">
                                Write Your Comment:
                            </label>
                            <textarea id="comment_text" name="comment_text" rows="10" required class="rounded-3xl outline-2 hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white p-2"></textarea>
                            <input type="submit" id="post_comment_btn" name="post_comment_btn" value="Post Comment" class="
                                bg-blue-600 rounded-2xl 
                                hover:bg-blue-400 hover:outline-2 hover:outline-black hover:text-white
                                text-2xl font-bold
                                w-min
                                p-4">
                            </input>
                        </form>
                    </aside>
                </div>
                <!--Comment Section-->
                <section id="comment" class="
                        p-4
                        flex flex-col gap-5
                        w-full lg:w-3/4">
                    <!--php code for printing out all comments-->
                    
                </section>
            </div>
        </div>

        <!--Footer Section-->
        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>