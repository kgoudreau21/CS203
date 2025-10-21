
function compute_days(){
    const dob = get_dob();
    
    // Gets today's date
    const today = new Date();

    //get number of days, months and years from today
    const current_year = today.getFullYear();
    const current_month = today.getMonth();
    const current_day = today.getDate();
    
    //convert dob from string to date
    const input_date = new Date(dob);

    //SideNote: today's date is accurate, but I am getting a different value from input_date, its 1 day earlier than today...
    console.log(today);
    console.log(input_date);

    //Find difference in number of days, months and years between today and input_date
    let age_years = current_year - input_date.getFullYear();
    let age_months = current_month - input_date.getMonth();
    let age_days = current_day - input_date.getDate();

    //An array that lists the number of days in each month, from jan to dec (not counting leap years)
    const days_per_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    let total_days = age_days + (age_years*365)
    
    for(let x=0;x<age_months;x++){
        total_days += days_per_month[x];
    }
    
    write_answer_days("Your date of birth is: " + dob + ". You have lived: "+total_days+" day(s) in total as of today!")
}



function compute_circle(){
    const screen = get_screen_dims();
    
    //initialize radius r
    let r=0;
    if(screen.width < screen.height){
        r=screen.width/2;
    }
    else{
        r=screen.height/2;
    }

    //get value of pi
    const pi = Math.PI;

    //square r
    r = Math.pow(r,2);

    //Calculate A = pi * r^2
    let area = pi * r;

    //Output answer
    write_answer_circle("Your screen properties are: " + screen.width + " x " + screen.height + ". The total area of the widest possible circle is: " + area.toFixed(2) + " square pixels!")
}



function check_palindrome(){
    const text_input = get_palindrome();

    //create new string from text input, easier way to check palindrome
    let temp_text = text_input.replace(' ', '') // get rid of all spaces
    temp_text = text_input.toLowerCase(); //Turn all characters from upper to lowercase
    
    //will be set to true if input is a palindrome
    let is_palindrome = false;

    /*
    Continue for loop while text looks like a palindrome, otherwise break for loop
    Compares first character with last in string, then compare second and second last, etc...
    Ends after these two comparison characters cross each other
    */
    for(let x = 0, y = (temp_text.length-1); x <= y; x++, y--){
        if(temp_text[x] === temp_text[y]){
            if(x+1 >= y) //happens right before for loop ends
                is_palindrome = true;
        }
        else{ //if characters don't match then end for loop
            x=y+1;
        }
    }

    //answer message in string
    let answer = "this is not a palindrome!";
    
    if(is_palindrome)
        answer = "this is a palindrome!";

    write_answer_palindrome("Your text: " + text_input + ". I believe "+ answer)
}



function create_fibo(){    
    const fibo_length = document.getElementById("fibo_length").value;
    
    let sequence = [0, 1];
    for(let x = 1; x < fibo_length; x++){
        sequence.push(sequence[x] + sequence[x-1]);
    }

    //Initialize answer with 0 in order to convert array of numbers into a string
    let answer = "0";
    
    //If input is negative it will return an invalid message
    if(fibo_length < 1)
        answer = "Your input is invalid. The Fibonnacci sequence must be of length 1 or above!"
    else{
        for(let x = 1; x < fibo_length; x++){ //turns the sequence array into a string
            answer += ", "+ sequence[x];
        }
    }
    write_answer_fibo(answer)
}

