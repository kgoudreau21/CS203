    //get "save_draft" button
    let save_btn = document.getElementById("save_draft");

    //get the hidden input "save_flag"
    let flag = document.getElementById("save_flag");

    //when btn is pressed will save drafft to local storage and set save_flag to '1'
    save_btn.addEventListener("click", () => {
        //create an Object that stores key value pairs from Form inputs
        let output = {
            'title' : document.getElementById("title").value,
            'subtitle' : document.getElementById("subtitle").value,
            'year' : document.getElementById("year").value,
            'review' : document.getElementById("review").value
        };

        //Save to local storage under "draft", ref: https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage
        //JSON.stringify reff: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON/stringify
        localStorage.setItem("draft", JSON.stringify(output));

        //set save_flag to '1' (string)
        flag.value = '1';
    });