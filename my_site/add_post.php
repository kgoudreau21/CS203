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
        header('Location: http://' . $BASE_URL .  'blog.php?page=blog.php');
    }

    //Code runs if Form was submitted through HTTP POST request
    if(isset($_POST['save_flag'])){
        //code adds new post to json file when $_POST['save_flag'] === '0' (string = '0' is default value)
        if($_POST['save_flag'] === '0'){
            //$output is where all the user's submitted input is stored
            $output = [
                //Get today's date, ref: https://www.w3schools.com/php/php_date.asp
                'post_date'=>date("Y/m/d"),
                //trim leading and trailing whitespace, ref: https://www.php.net/manual/en/function.trim.php
                //htmlentities() protects against code injection
                'title'=>trim(htmlentities($_POST['title'])),
                //author contains string of format: "Subtitle, Year"
                'author'=>trim(htmlentities($_POST['subtitle'].', '.$_POST['year'])),
                //paragraphs is an empty array (for now)
                'paragraphs'=>[]];

            //get <textarea> input as string from POST Request
            $text = $_POST['review'];

            //protect against code injection
            $text = htmlentities($text);

            //Need to split string into multiple smaller strings, 1 for each paragraph
            //copied code from: https://stackoverflow.com/questions/17673342/explode-text-into-array-as-per-paragraph
            //Returns an array containing substrings of subject split along boundaries matched by pattern, ref: https://www.php.net/preg-split
            //pattern that seperates paragraphs: at least 2 "\r\n" (windows newline) or "\n" (linux newline), ref: https://www.geeksforgeeks.org/php/whats-the-difference-between-n-and-rn-in-php/
            //{2,} means at least 2, ref: https://www.w3schools.com/php/php_regex.asp
            $text = preg_split('/(\r\n|\n){2,}/', $text);
            
            //add each string in $text into the array in $output['paragraphs']
            foreach($text as $paragraph){
                $output['paragraphs'][]=$paragraph;
            }

            //extract JSON as an associative array
            $posts=json_decode(file_get_contents('blog_posts.json'), true);

            //this array will contain all the # from each post saved in json file (each post is in an array with key = post#)
            $postNumbers = [];

            //trying to find what # our new post will have, 
            //copied cdoe from: https://stackoverflow.com/questions/4163164/find-missing-numbers-in-array
            $expected = 1;
            foreach($posts as $key => $value){
                //extract the number from "post#", ref: https://www.php.net/manual/en/function.preg-replace.php
                //convert string to int using typecasting: https://www.php.net/manual/en/language.types.type-juggling.php#language.types.typecasting
                $number = (int) preg_replace('/post/', '', $key);

                //add the current post's # to array
                $postNumbers[] = $number;

                if ($expected == $number){
                    $expected++;
                }
            }

            //add our new post to the associative array with key = post# (# found previously in $expected)
            foreach($output as $key => $value){
                $posts['post'.$expected][$key] = $value;
            }

            //encode associative array back to json format
            $posts = json_encode($posts);

            //Write the contents back to the json file
            file_put_contents('blog_posts.json', $posts);

            //set msg for user that post has been successfully submitted
            set_msg('Your Post has Been Successfully Submitted!');
        } else if($_POST['save_flag'] === '1'){ //If $_POST['save_flag'] set to 1 then the save_draft button was pressed
            //set msg for user that draft has been successfully saved
            set_msg('Your Draft has Been Successfully Saved!');
        }
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

        <!--prevent page resubmission from causing another duplicate post too be added-->
        <script src="js/preventResubmission.js"></script>

        <!--Google Font: https://fonts.google.com/specimen/Smooch+Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet">
        <!--CSS Stylesheet applies font: "Smooch Sans" to all elements in Hero, Main, Aside sections-->
        <link rel="stylesheet"  type="text/css" href="css/blog_style.css">

        <!-- Option 1b) Using Tailwind Play CDN for CSS Styling: https://tailwindcss.com/docs/installation/play-cdn -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body class="bg-gradient-to-b from-purple-800 via-fuchsia-500 to-pink-500">
        <div class="body_wrapper">
            <?php
                $webpage->setNav();
            ?>
        </div>

        <div class="body_wrapper">
            <!--Form to Add a New Post-->
            <form id="create_post" action="add_post.php?page=blog.php" method="post" class="
                    flex flex-col items-center justify-center gap-4
                    text-center
                    m-4">
                <?php
                    //Print out msg if it is setup
                    if(isset($_POST['msg'])){
                        echo $_POST['msg'];
                    }

                    //sets up msg
                    function set_msg($string){    
                        $_POST['msg'] = '<h3 class="text-blue-600 text-2xl font-bold p-4 bg-white rounded-2xl">'.$string.'</h3>';
                    }
                ?>

                <legend class="
                        bg-fuchsia-400 rounded-3xl 
                        hover:bg-fuchsia-400
                        p-4">
                    <h2 class="text-3xl font-extrabold">
                        Please Enter The Information for the Book Review You will be Posting:
                    </h2>
                </legend>

                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl">
                    <label for="title" class="text-2xl font-bold underline decoration-solid">
                        Your Post's Title:
                    </label>
                    <input type="text" id="title" name="title" placeholder="Name of Your Book" required class="
                        rounded-3xl outline-2
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white
                        p-2">
                </div>

                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl">
                    <label for="subtitle" class="text-2xl font-bold underline decoration-solid">
                        Your Post's Subtitle:
                    </label>
                    <input type="text" id="subtitle" name="subtitle" placeholder="Your Book's Author" required class="
                        rounded-3xl outline-2
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white
                        p-2">
                </div>

                <div class="
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl">
                    <label for="year" class="text-2xl font-bold underline decoration-solid">
                        Your Book's Publication Date:
                    </label>
                    <input type="number" id="year" name="year" min="0" max="2026" placeholder="Book's Publication Year" required class="
                        rounded-3xl outline-2
                        hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white
                        p-2">
                </div>

                <!--Made the width=100% (w-full using tailwind) so that <textarea> can have (width = form width)--->
                <div class="
                        w-full
                        p-4 gap-4
                        flex flex-col
                        bg-indigo-500 rounded-3xl">
                    <label for="review" class="text-2xl font-bold underline decoration-solid">
                        Your Review:
                    </label>
                    <!--Textarea element ref: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/textarea -->
                    <!--Need to write everything in 1 line for placeholder text to appear, ref: https://stackoverflow.com/questions/10186913/html5-textarea-placeholder-not-appearing -->
                    <textarea id="review" name="review" placeholder="Write Your Review Here" rows="10" required class="rounded-3xl outline-2 hover:bg-indigo-800 hover:outline-2 hover:outline-black hover:text-white p-2"></textarea>
                </div>
                <div>
                    <input type="submit" id="create_post_btn" value="Create New Post" class="
                        bg-green-600 rounded-2xl 
                        hover:bg-green-500 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    </input>
                    <!--Hidden input, ref: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input/hidden -->
                    <input type="hidden" id="save_flag" name="save_flag" value="0">
                    <!--Save Button for Optional Part 5 a)-->
                    <input type="submit" id="save_draft" value="Save Draft" class="
                        bg-blue-600 rounded-2xl 
                        hover:bg-blue-400 hover:outline-2 hover:outline-black hover:text-white
                        text-2xl font-bold
                        w-min
                        p-4">
                    </input>
                    <!--JS file adds a onclick event to the "save_draft" button, if clicked will change the value of the hidden input: "save_flag" to 1-->
                    <script src="js/save_post_draft.js"></script>
                </div>
            </form>
        </div>

        <?php
            $webpage->setFooter();
        ?>
    </body>
</html>