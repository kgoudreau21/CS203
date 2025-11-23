    //get main section
    let main = document.getElementById("main");

    //returns a nodeList of all <article> elements in main section: https://www.w3schools.com/jsref/met_document_queryselectorall.asp
    let posts = main.querySelectorAll("article");

    //Loop through each blog post(<article>) inside "main" and append a div element(remove post btn) to it
    posts.forEach((article, index) => {
        // Create a new div element
        let trash_btn = document.createElement("div");

        let current_post = index + 1;

        //id = "trash#" (# is the post number)
        let id = 'trash'+current_post;

        //set classes as ‘fa’ and ‘fa-trash’
        trash_btn.classList.add('fas', 'fa-trash', 'bg-red-600', 'rounded-2xl', 'p-2', 'm-2', 'hover:outline-2', 'hover:outline-black'); 

        //Store id in DOM, Reference: https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset
        trash_btn.dataset.id = id; 
        
        //add texxt content to trash_btn
        trash_btn.textContent = "REMOVE POST";
        
        // Append the new element inside the article
        article.appendChild(trash_btn);

        trash_btn.addEventListener("click", () => {
            article.remove(); //add an even listener to span_btn. When clicked will remove blog post
        });
    });