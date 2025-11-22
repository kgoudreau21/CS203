<?php
    include_once("php/nav.php");
?>
<!DOCTYPE html>
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

        <!-- Documentation for using Tailwind
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
            center items along cross axis in flex: https://tailwindcss.com/docs/align-items

            float left: https://tailwindcss.com/docs/float#floating-elements-to-the-left

            colors: https://tailwindcss.com/docs/colors
            setup background color gradient: https://tailwindcss.com/docs/background-image#setting-gradient-color-stops

            add border radius: https://tailwindcss.com/docs/border-radius

            create an outline on hover: https://tailwindcss.com/docs/outline-width

            mouse hover effects: https://tailwindcss.com/docs/hover-focus-and-other-states

            CSS @media equivalent: https://v3.tailwindcss.com/docs/responsive-design

            using scroll smooth effect for blog links: https://tailwindcss.com/docs/scroll-behavior#using-smooth-scrolling
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
            <!--Hero Section-->
            <!--Using display flex in column direction, and center items along y axis, center text, margin of 56(14 rem or 224px using default spacing)-->
            <div id="hero" class="
                text-center
                flex flex-col items-center
                m-56">
                <!--Hero Section Title: text weight and font size extrabold-->
                <!--fuchsia color background with rounded edges, outline/bg color/text color changes on hover, padding of 5 and bottom margin of 10-->
                <h1 id="hero_title" class="
                        bg-fuchsia-400 rounded-2xl 
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                        text-6xl font-extrabold 
                        p-5 mb-10">
                    Book Review Blog
                </h1>
                <!--Hero Section Text: width = 80% of container-->
                <p id="hero_text" class="
                    bg-fuchsia-400 rounded-2xl 
                    hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white
                    text-4xl font-bold
                    w-4/5"> 
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
                text-3xl text-center
                m-4">
                <!--Main Section: float left-->
                <section id="main" class="
                    float-left w-3/4
                    text-3xl">
                    <!--Posts: all have margin of 10-->
                    <article id="post1" class="
                        bg-indigo-500 rounded-2xl
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                        text-2xl font-bold 
                        m-10
                        ">
                        <h2 class="text-4xl font-bold underline decoration-solid">Gachiakuta</h2>
                        <h3 class="text-3xl">Manga series written and drawn by Kei Urana, 2022</h3>
                        <p class="m-4">
                            This is Ms. Urana’s first major published series for Weekly Shonen magazine.
                            It's about a boy named Rudo, who gets framed for murder and is thrown out from his hometown.
                            A mysterious floating island where the rich live behind a wall and the poor in the slums.
                            He finds himself on the earth and soon discovers that it is full of garbage the sky people throw down.
                            These mountains of garbage end up creating these giant garbage monsters that terrorize the people living on the surface.
                        </p>
                        <p class="m-4">
                            With nowhere to go Rudo joins a group called the “Cleaners” who fight these monsters using special abilities harnessed through their “jinki”.
                            Which is a special object they must care for deeply for many years before it gives them magical powers. 
                        </p>
                        <p class="m-4">
                            There is a big emphasis on the importance of taking care of the environment.
                            The heavy levels of pollution down on the surface has made life very difficult for the people on the surface.
                            Meanwhile the ultra rich live on a floating island and keep carelessly throwing their trash down to earth.
                        </p>
                        <p class="m-4">
                            Rudo himself is someone who cares deeply about the “discarded” things others throw away.
                            He finds value in the garbage dumps that litter his neighborhood and discovers that his own ‘jinki” is related to recycling things.
                        </p>
                        <p class="m-4">
                            Kei Urana has a very good fashion sense that is reflected in her character design.
                            The main attraction I had for this series was the art direction. Gackiakuta has this cool “urban-punk” look.
                            When I saw the cover for the first two volumes in the book store I just had to read it.
                        </p>
                    </article>
                    <article id="post2" class="
                        bg-indigo-500 rounded-2xl
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                        text-2xl font-bold 
                        m-10">
                        <h2 class="text-4xl font-bold underline decoration-solid">I'm Thinking of Ending Things</h2>
                        <h3 class="text-3xl">Novel by Ian Reid, 2016</h3>
                        <p class="m-4">
                            This story is told from our protagonist's point of view, a woman who is thinking about breaking up with her boyfriend Jake.
                            We get this very intimate view into her and Jake’s relationship which really helps bring these characters to life.
                            She first introduces herself as Lucy, but throughout the story you find that her name keeps changing, which adds to the mystery.
                        </p>
                        <p class="m-4">
                            This is what you might call “social anxiety horror”.
                            Everyone Lucy meets seems to be acting a little off, but you just can’t really explain why.
                            First it’s the long awkward drive to his Jake’s family’s house deep in the countryside.
                            When she gets there she meets his parents for the first time. That’s when she notices odd things.
                            How Jake’s parents dress, the awkward silences, the facial expressions and mannerisms of random people she meets at the gas station.
                            It creates a very surreal atmosphere.
                        </p>
                        <p class="m-4">
                            One of the most terrifying things I have ever read was the “man at the window” chapter.
                            One night Lucy wakes up to see an impossible tall man standing in front of her window.
                            So tall only his chest is visible.
                        </p>
                        <p class="m-4">
                            When I first picked up this book I was thinking: “what is up with this title?”.
                            Now am I not going to outright explain the ending but… I think it's pretty bad.
                            The whole book was building up all this mystery and tension, and then in the end its explanation of what really happened roughly boils down to “it was all just a dream”!!!
                        </p>
                        <p class="m-4">
                            The reason this book’s ending makes me angry is because the beginning of the book was just so good! I was hooked in the first chapter.
                            If you like psychological horror, something a little more philosophical and existential I think you might like this, just be warned it has a very rough ending.
                        </p>
                    </article>
                    <article id="post3" class="
                        bg-indigo-500 rounded-2xl  
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                        text-2xl font-bold 
                        m-10">
                        <h2 class="text-4xl font-bold underline decoration-solid">Land of the Lustrous</h2>
                        <h3 class="text-3xl">Manga series by Haruko Ichikawa, 2012</h3>
                        <p class="m-4">
                            This is a series about a small island community of people made up of gems.
                            During the day they have to defend themselves from the lunarians.
                            Cloud people who want to break them and take their pieces to use as jewelry.
                            During the day they come out of these giant rorschach ink plots in the sky.
                        </p>
                        <p class="m-4">
                            Our main character is named Phosphophyllite, who is made of the same green mineral.
                            They’re the youngest among their peers at only 300 years old and seen as clumsy and fragile by the others.
                            The story explores themes of personnel change and growth through Phos’s journey to uncover the mysteries behind the lunarians.
                        </p>
                        <p class="m-4">
                            We get to meet a vast array of colorful characters, each of them is named after a different gem.
                            It is really unique because of how the properties of each gem affect their personality. You have a Diamond whose attitude shines bright and cheerful.
                            Bort, who’s gloomy, has an abrasive personality and a short temper. Cinnabar, which according to wikipedia is made of the “bright scarlet to brick-red form of mercury sulfide”.
                            This causes them to stay away from others due to the toxic effects of mercury.
                        </p>
                            Cool fact: Amethyst 84 and 33 are two twins, a reference to “Japan Law Twinning”.
                            A phenomena where 2 pieces of quartz join together at an angle of 84 degrees and 33 minutes (1 minute is 1/60 degrees).
                        </p>
                    </article>
                    <article id="post4" class="
                        bg-indigo-500 rounded-2xl
                        hover:bg-indigo-800 hover:outline hover:outline-2 hover:outline-black hover:text-white 
                        text-2xl font-bold 
                        m-10">
                        <h2 class="text-4xl font-bold underline decoration-solid">Hitch Hiker’s Guide to the Galaxy</h2>
                        <h3 class="text-3xl">Book series by Douglas Adams, 1978</h3>
                        <p class="m-4">
                            A classic of science fiction and humor. A story full of clever and  ludicrous humor. The earth gets destroyed to make space for a giant space highway. Leaving our main character Arthur Dent as one of the last two humans alive. Thankfully right before earth’s destruction he was saved by his friend Ford Prefect. A jobless actor on earth, Ford turns out to be an alien in disguise.

                        <p class="m-4">
                            Arthur now finds himself in an absurd world full of aliens and crazy technology. Yet even in a space faring intergalactic civilisation there still exists the monotony of bureaucracy and the need to work a 9 to 5. Like in this universe God would just be a normal salary man up in heaven who needs to lead a normal life just like the rest of us.

                        <p class="m-4">
                            It feels timeless and strangely modern. When I read it you could still relate a lot with the characters and the jokes still land. For example you have Marvin, a robot who is the smartest computer in the world but is always depressed. At one point Arthur finds out that you can fly if you stop thinking long enough. It turns out that dolphins are smarter than humans and were able to leave earth before it was destroyed. And who can forget the famous number 42, which is the answer to the question: “what is the meaning of life”. It's a fun read and if you like absurd, random and dry humor I think you would like this book.
                        </p>
                    </article>
                </section>
                <!--Aside Section-->
                <!--takes up 1/4 of the container's width, float left, top margin of 10(2.5 rem, 40px)-->
                <aside id="aside" class="
                    float-left 
                    w-1/4
                    mt-10">
                    <!--Aside List Section-->
                    <div id="aside_list">
                        <!--Aside Title: dashed line text decoration-->
                        <h1 id="aside_title" class="
                            underline decoration-dashed
                            text-6xl font-extrabold mb-5">
                            Table of Contents
                        </h1>

                        <!--Link containers: have a bottom margin of 5(1.25rem, 20px)-->
                        <!--Have ffuchsia background with rounded edges, background color/text color/outline changes when you hover mouse-->
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