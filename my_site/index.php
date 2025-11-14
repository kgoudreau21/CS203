<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Korey's Website</title>
        <meta charset="UTF-8">
        <meta name="description" content="Korey's Personnal Website">
        <meta name="keywords" content="HTML, CSS, Javascript, Home, Homepage">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" type="text/css" href="css/my_style.css">
        <link rel="stylesheet" type="text/css" href="css/slideshow.css">

        <?php
            include_once("php/nav.php");
        ?>
    </head>
    <body style="background-color:khaki;">

        <div class="body_wrapper">
            <?php
                $webpage->setNav();
            ?>
        </div>

        <div class="body_wrapper">
            <h1>Welcome to my Blog!</h1>
            <p>
                <strong>
                    Hi, my name is Korey &amp; this is my personnal website!<br>
                    I plan on adding more here in the future, but in the meantime please enjoy!
                </strong>
            </p>
        </div>
        <hr>
        <div class="body_wrapper">
            <h2>A Little about Myself:</h2>
            <p>
                My name is Korey Goudreau, &amp; I am currently studying Computer Science &commat; Bishops University.<br>
                This website is actually part of my <em>Website Design</em> class!<br>
                While I'm &commat; it I guess I thought it would be cool to make this a personnal blog.<br>
            </p>
        </div>

        <div class="body_wrapper">
            <div class="slideshow">
                <div class="slideshow_img" >
                    <img src="images/slide1.jpg" alt="image of lake with cherryblossoms">
                </div>

                <div class="slideshow_img" >
                    <img src="images/slide2.jpg" alt="image of green mountains with lake and trees">
                </div>

                <div class="slideshow_img" >
                    <img src="images/slide3.jpg" alt="image of lake with mountain range in background">
                </div>
                
                <a id="previous" title="click for next image" onclick="previous()">&larr; Previous</a>
                <a id="next" title="click for previous image" onclick="next()">Next &rarr;</a>
            </div>
        </div>
        
        <hr>
        <div class="body_wrapper">
            <p>
            Unlike social media, making your own website allows you to customize everything yourself.<br>
            It reminds me of old 80's depictions of technology &amp; the internet you see in stuff like:<br>
            </p>
            <ul>
                <em>
                    <li><a href="https://www.youtube.com/watch?v=9uI7IMB27_c">Hypnospace Outlaw</a></li>
                    <li><a href="https://www.youtube.com/watch?v=gUHejU7qyv8">Code Lyoko</a></li>
                    <li><a href="https://www.youtube.com/watch?v=MM8RufZr5lw">Serial Experiments Lain</a></li>
                </em>
            </ul>
        </div>
        <hr>
        <div class="body_wrapper">
            <h2>
                My Top 3 Vacation Spots
            </h2>
            <ol>
                <li>South Korea</li>
                <li>Japan</li>
                <li>Hawaii</li>
            </ol>
            <h2>
                Flights from Montreal
            </h2>
            <table border=1 style="width:100%;text-align:center;">
                <tr style="background-color:aqua;">
                    <th>Date</th>
                    <th>Flying From</th>
                    <th>Flying To</th>
                    <th>Time</th>
                    <th>Economy (CAD)</th>
                    <th>Premium Econo (CAD)</th>
                    <th>Business Class (CAD)</th>
                    <th>Airline</th>
                </tr>
                <tr>
                    <td>Sept. 24 2025</td>
                    <td>Montreal (YUL)</td>
                    <td>Seoul (ICN)</td>
                    <td>14h40m</td>
                    <td>994$</td>
                    <td>1,601$</td>
                    <td>3,236$</td>
                    <td>Air Canada</td>
                </tr>
                <tr>
                    <td>Sept. 24 2025</td>
                    <td>Montreal (YUL)</td>
                    <td>Tokyo (TYO)</td>
                    <td>13h30m</td>
                    <td>731$</td>
                    <td>1,711$</td>
                    <td>4,652$</td>
                    <td>Air Canada</td>
                </tr>
                <tr style="font-family:papyrus, fantasy;">
                    <td>Sept. 30 2025</td>
                    <td>   
                        <ol>
                            <li><em>Montreal (YUL)</em></li>
                            <li>Detroit (DTW)</li>
                            <li>Los Angeles (LAX)</li>
                        </ol>
                    </td>
                    <td>
                        <ol>
                            <li>Detroit (DTW)</li>
                            <li>Los Angeles (LAX)</li>
                            <li><em>Kona Coast (KOA)</em></li>
                        </ol>
                    </td>
                    <td>
                        <ol>
                            <li>1h54m</li>
                            <li>4h49m</li>
                            <li>5h35m</li>
                        </ol>
                        <p><em>Total:17h35m</em></p>
                    </td>
                    <td>817$</td>
                    <td>1,083$</td>
                    <td>6,009$</td>
                    <td>Delta</td>
                </tr>
            </table>
            <a href="my_vacation.html">Link to Vacation Page here!</a>
        </div>
        <hr>
        <?php
            $webpage->setFooter();
        ?>

        <!--JS Code for div with class="slideshow"-->
        <script src="slideshow.js"></script>
    </body>
</html>