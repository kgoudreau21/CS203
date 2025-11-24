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

        //when btn is pressed, will create a window asking to confirm from user, if yes then will delete the post
        trash_btn.addEventListener("click", () => {
            if(confirm("Are you sure?")){
                //remove blog post from DOM
                article.remove();

                //Get the contents of blog_posts.json using fetch API: https://www.w3schools.com/jsref/api_fetch.asp#gsc.tab=0
                fetch('blog_posts.json')
                //get the contents as a JS Object representing the json contents: https://developer.mozilla.org/en-US/docs/Web/API/Response/json
                .then(x => x.json()) 
                .then(y => {
                    //console.log(y);

                    //turn each key/value pair in the JS object into key/value pairs of an array: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries
                    let array = Object.entries(y);
                    //console.log(array);

                    // Remove the blog post specified from the array: https://www.geeksforgeeks.org/javascript/how-to-remove-specific-json-object-from-array-javascript/
                    let blog_posts = array.filter(post => post !== array[index]);
                    //console.log(blog_posts);

                    //undo "Object.entries(y)" by creating an object from the entries in the array: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/fromEntries
                    let output = Object.fromEntries(blog_posts)

                    // Convert array to string: https://www.w3schools.com/js/js_json_stringify.asp
                    let string = JSON.stringify(output);
                    //console.log(string);

                    //create a form and submit the string under $_POST['posts']: https://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
                    const form = document.createElement('form');
                    form.method = 'post';
                    form.action = 'blog.php?page=blog.php';
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = 'posts';
                    hiddenField.value = string;
                    form.appendChild(hiddenField);
                    document.body.appendChild(form);
                    form.submit();
                })
            }
        })
    });