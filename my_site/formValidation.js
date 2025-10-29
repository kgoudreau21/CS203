function validate(){
    event.preventDefault();

    //array contains: names of the form inputs I will check
    let arr = new Array("name", "email", "holiday", "mood", "top1food", "top2food", "top3food", "competitive", "birth");

    //If an form input from "arr" is not valid, its name is added to "error"
    let error = new Array();

    //checking all names in "arr"
    arr.forEach(item => {
        if(isempty(item)){
            error.push(item);
        }
    });
    
    //Generate error message with all form inputs that are invalid
    if(error.length!==0){
        let msg = error[0];
        for(let i=1;i<error.length;i++){
            msg += ", " + error[i];
        }
        window.alert("You forgot to complete the following form inputs: " + msg);
        return false;
    }

    checkTop3foodsForDuplicates();

    //returns true if form validation is good
    console.log("Your form input is good!");
    return true;
}

function isempty(key){
    console.log('The element with name="'+key+'":');

    //temp finds element where name=key, else returns null
    let selector = 'input[name="' + key + '"]';
    //if input is type radio, then add a ":checked" to selector
    if (document.querySelector(selector).type === "radio") {
        selector += ':checked';
    }
    let temp = document.querySelector(selector);

    if (temp!==null) {
        let input = temp.value;
        console.log('Contains value ="'+input+'"');

        input = input.replace(/\s/g,''); // get rid of all spaces in input: https://stackoverflow.com/questions/6623231/remove-all-white-spaces-from-text
        console.log('Contains value ="'+input+'" (with spaces removed)');

        if(input!==''){
            console.log("Is not empty");
            return false;
        }
    }
    console.log("Is empty");
    return true;
}

function checkTop3foodsForDuplicates(){
    //Get the checked element for all top 3 foods
    let top1 = document.querySelector('input[name="top1food"]:checked');
    let top2 = document.querySelector('input[name="top2food"]:checked');
    let top3 = document.querySelector('input[name="top3food"]:checked');

    //Get rid of the last character in the id (ex:id="Bread1" turns into "Bread")
    const x = top1.id.substring(0, (top1.id.length - 1));
    const y = top2.id.substring(0, (top1.id.length - 1));
    const z = top3.id.substring(0, (top1.id.length - 1));

    if (x === y || x === z || y === z) {
        alert("You must choose three different foods for your Top 1, Top 2 and Top 3.");
        return false;
    }
}