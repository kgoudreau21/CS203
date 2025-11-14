<?php
//Test URL: http://localhost/CS203/my_site/quiz_verification.php?name=Korey&email=example%40gmail.com&holiday=air&mood=air&top1food=water&top2food=air&top3food=stone&competitive=5&activity1=stone&activity6=air&birth=2025-12
//test sample input: print_r($_GET)
//Array ( [name] => Korey [email] => example@gmail.com [holiday] => air [mood] => air [top1food] => water [top2food] => air [top3food] => stone [competitive] => 5 [activity1] => stone [activity6] => air [birth] => 2025-12 ) 1


//Form input verification

//checking if all required inputs are set
//only input not required is 'activity'
$required = ['name', 'email', 'holiday', 'mood','top1food','top2food', 'top3food', 'birth', 'competitive'];
foreach($required as $i){ //goes through all elements of $required and checks to see if $_GET doesn't have a matching key
    if(!isset($_GET[$i])){
        //error msg: need required input $i in the form
        die('Error: Require input: "'.$i.'"');
    }
}

//check name to see if its an empty string
$name = $_GET['name'];
// Strip whitespace from the beginning and end of $name
$name = trim($name); //ref: https://www.php.net/manual/en/function.trim.php
if(strlen($name) <= 0){
    //error msg: input name not set
    die('Error: Name input missing!');
}

//verify email
$email = filter_var($_GET['email'].FILTER_VALIDATE_EMAIL);
if($email === false){
    //error msg: email not set
    die('Error: Email input missing!');
}



//Start tallying points
$fire=0;
$air=0;
$water=0;
$stone=0;

//birth month -> input type=month has format: YYYY-MM
$month = $_GET['birth'];

//use substr() to extract MM -> ref: https://www.php.net/manual/en/function.substr.php
$month = substr($month, 5, 2);

//extract int value from string $month -> ref: https://www.php.net/manual/en/function.intval.php
$month = intval($month);

//assign 2.5 points depending on birth month value
//each of the 4 elements are associated to 3 months of the year -> ref: https://en.wikipedia.org/wiki/Astrology_and_the_classical_elements
switch ($month) {
    case 3:
    case 7:
    case 11:
        //March, July, November
        $fire+=2.5;
        break;
    case 1:
    case 5:
    case 9:
        //January, May, September
        $air+=2.5;
        break;
    case 2:
    case 6:
    case 10:
        //February, June, October
        $water+=2.5;
        break;
    case 4:
    case 8:
    case 12:
        //April, August, December
        $stone+=2.5;
        break;
    default:
        //error msg: unrecognized values for birth month
        die('Error: "Birth month" value unrecognized!');
}

//competitive is worth 1-2 points so it get seperate function
switch($_GET['competitive']){
    //Not competitive = water
    case 1:
        $water+=2;
        break;
    case 2:
        $water+=1;
        break;

    //A little competitive = air
    case 3:
        $air+=2;
        break;
    case 4:
        $air+=1;
        break;
    
    //Average competitive = stone
    case 5:
        $stone+=2;
        break;
    case 6:
        $stone+=1;
        break;

    //Very competitive = fire
    case 7:
        $fire+=1;
        break;
    case 8:
        $fire+=2;
        break;

    default:
        //error msg: unrecognized values for competitive level
        die('Error: "Competitive Level" value unrecognized!');
}

//setup array called "inputs" where key = "name of each form input" and value = "number of points that input is worth"
$inputs = [
    "holiday" => 2,
    "mood" => 2,
    "top1food" => 3,
    "top2food" => 2,
    "top3food" => 1,
];

//checking if activity1 to activity9 are set, if yes then add them as key to $inputs with a value of -1
for($i=1;$i<9;$i++){
    $s = "activity".$i;
    if(isset($_GET[$s])){
        $inputs[$s]=-1;
    }
}

//tallies points using $inputs
foreach($inputs as $key=>$value){
    switch($_GET[$key]){
        case "fire":
            if(($fire+$value)>0){ //prevents score from going negative
                $fire+=$value;
            }
            break;
        case "air":
            if(($air+$value)>0){ //prevents score from going negative
                $air+=$value;
            }
            break;
        case "water":
            if(($water+$value)>0){ //prevents score from going negative
                $water+=$value;
            }
            break;
        case "stone":
            if(($stone+$value)>0){ //prevents score from going negative
                $stone+=$value;
            }
            break;
        default:
            //error msg: input=$key not recongized
            die('Error: input value for "'.$key.'" is not recognized!');
    }
}

//tally your total points
$total=$fire+$air+$water+$stone;

//for debugging
//print("total=".$total.PHP_EOL);
//print("fire=".$fire.PHP_EOL);
//print("air=".$air.PHP_EOL);
//print("water=".$water.PHP_EOL);
//print("stone=".$stone.PHP_EOL);

//set results to percentage with 2 decimal places -> ref: https://www.w3schools.com/php/func_math_round.asp
$fire=round(($fire/$total)*100,2,PHP_ROUND_HALF_UP);
$air=round(($air/$total)*100,2,PHP_ROUND_HALF_UP);
$water=round(($water/$total)*100,2,PHP_ROUND_HALF_UP);
$stone=round(($stone/$total)*100,2,PHP_ROUND_HALF_UP);

//Setup array with key=score and value = string (name of element)
$elements = [
    $fire => "fire",
    $air => "air",
    $water => "water",
    $stone => "stone"
];

//Setup output for html page
$output = [
    'your_element' => $elements[max($fire, $air, $water, $stone)], //check to see which of the 4 elements has highest score -> ref: https://www.php.net/manual/en/function.max.php
    
    //output text content for html page
    'abilities' => '',
    'season' => '',
    'text' => '',

    //will be used to modify css styling of html content
    'fire_style' => '',
    'air_style' => '',
    'water_style' => '',
    'stone_style' => '',
];


switch($output['your_element']){
    case "fire":
        $output['abilities']='Lightning and Explosion bending';
        $output['season']='Summer';
        $output['text']='You have a passionate and unrelenting soul that burns bright with ambition. Bring life to the party and never have to worry about being cold again thanks to your mastery of fire and combustion. Create dazzling firework shows from the palms of your hands, cook the perfect steak without even needing a grill. When the scorching sun is at its peak, so are you. But be warned that during a solar eclipse you will temporarily lose your powers.';
        $output['your_element']='<span style="color:red">'.$output['your_element'].'</span>'; //use css to change the color of the text in $output['your_element']
        $output['fire_style']='style="border: 0.25em solid red"'; //use css to add colored border to corresponding column
        break;
    case "air":
        $output['abilities']='Spirit projection and Flying';
        $output['season']='Fall';
        $output['text']='You possess the ability to control the very air around you. It may seem like an intangible force, but gather enough momentum and you can create strong hurricanes. Air bending allows you to perform amazing acrobatics thanks to your incredible speed and agility. You are a free spirit, full of mirth and unencumbered by the challenges you face.';
        $output['your_element']='<span style="color:purple">'.$output['your_element'].'</span>';
        $output['air_style']='style="border: 0.25em solid purple"';
        break;
    case "water":
        $output['abilities']='Healing and Blood bending';
        $output['season']='Winter';
        $output['text']='As a water bender you are a versatile and adaptable person. You go with the flow and openly embrace change. Although you may not see it, water is everywhere. Its in the humidity of the air, the faucets of your house and the oceans of the world. Create giant tsunamis, water fountains and ice castles at will! However the highs of the tide must also come with the lows. Your strength is greatest during a full moon, and weakest during a lunar eclipse.';
        $output['your_element']='<span style="color:blue">'.$output['your_element'].'</span>';
        $output['water_style']='style="border: 0.25em solid blue"';
        break;
    case "stone":
        $output['abilities']='Metal and Lava bending';
        $output['season']='Spring';
        $output['text']='You are stable, dependable and well rounded. A pillar for others to lean on in hard times. A good listener with an ear always to the ground. Your not afraid to get your hands dirty, which is when you are in your element. Ride the sands like a Hawaiian surfer, create castles of marble and stone. Change the world just as easily as you can mold clay with your mind.';
        $output['your_element']='<span style="color:green">'.$output['your_element'].'</span>';
        $output['stone_style']='style="border: 0.25em solid green"';
        break;
}


    include_once("php/nav.php");
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Your Form Results</title>
        <meta charset="UTF-8">
        <meta name="description" content="Questionnaire Form">
        <meta name="keywords" content="HTML, Javascript, PHP, Form">
        <meta name="author" content="Korey Goudreau">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/my_style.css">
        <link rel="stylesheet" type="text/css" href="css/form_style.css">

        <!--Links for Google font: Tangerine: https://fonts.google.com/specimen/Tangerine -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap">
    </head>
    <body>
        <?php
            $webpage->setNav();
            
            //heredoc syntax for strings -> ref: https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
            echo <<<END
            <div class="body_wrapper">
                <div class="oldPaper">
                    <div class="column_container">
                        <div class="column" {$output['fire_style']}>
                            <img src="images/fire.jpg" alt="Fire">
                            <h2>{$fire}%</h2>
                        </div>
                        <div class="column" {$output['air_style']}>
                            <img src="images/air.jpg" alt="Air">
                            <h2>{$air}%</h2>
                        </div>
                        <div class="column" {$output['water_style']}>
                            <img src="images/water.jpg" alt="Water">
                            <h2>{$water}%</h2>
                        </div>
                        <div class="column" {$output['stone_style']}>
                            <img src="images/stone.jpg" alt="Stone">
                            <h2>{$stone}%</h2>
                        </div>
                    </div>
                    <article>
                        <h1>Your Element is: {$output['your_element']}</h1>
                        <h3>
                            Your special abilities: {$output['abilities']}<br>
                            Your element's season: {$output['season']}<br><br>
                            {$output['text']}
                        </h3>
                    </article>
                </div>
            </div>
            END;

            $webpage->setFooter();
        ?>
    </body>
</html>