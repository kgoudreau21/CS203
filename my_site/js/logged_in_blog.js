    //get main section
    let main = document.getElementById("main");

    //get a nodeList of all <article> elements inside main section
    //using query selector all: https://www.w3schools.com/jsref/met_document_queryselectorall.asp
    let posts = main.querySelectorAll("article");

    //Loop through each blog post(<article>) inside "main" and append a <div> element(a btn to remove post) to it
    posts.forEach((article) => {
        // Create a new div element
        let trash_btn = document.createElement("div");

        //set classes as ‘fa’ and ‘fa-trash’ and also other classes for tailwind CSS styling
        trash_btn.classList.add('fas', 'fa-trash', 'bg-red-600', 'rounded-2xl', 'p-2', 'hover:outline-2', 'hover:outline-black', 'text-center'); 
        
        //id = "trash_post#" (post# is the current iteration's element id)
        let id = 'trash_'+article.id;

        //Store id in DOM, Reference: https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset
        trash_btn.dataset.id = id; 
        
        //add text content to trash_btn
        trash_btn.textContent = "REMOVE POST";
        
        // Append the new element inside the article
        article.appendChild(trash_btn);

        //when btn is pressed will delete post
        trash_btn.addEventListener("click", () => {
            //Create a window asking to confirm from user, if yes then proceed with deleting the post: https://www.w3schools.com/jsref/met_win_confirm.asp
            if(confirm("Are you sure?")){
                //remove blog post from DOM
                article.remove();

                //get the id of the post we want to delete
                let post_id = article.id;

                //create a form and send a HTTP POST request containing post_id back to blog.php
                //code copied from: https://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'blog.php?page=blog.php';
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = 'posts';
                hiddenField.value = post_id;
                form.appendChild(hiddenField);
                document.body.appendChild(form);
                form.submit();
            }
        })
    });