function splitAtRoot(path){
    const url = new URL(path, location.origin);
    const pathFromRoot = url.pathname;
    //console.log("---> path from root: " + pathFromRoot);
    return pathFromRoot;
};

function setNav(current_path){
    /*
    fetch creates a request to fetch your html file.
    r is the response from the request to the nav.html file.
    r.text() reads the file's content.
    .then(r => ...) means: do this when you have received r.
    .then(html => … ) means: do this when the html content (from nav.html) is ready.
    */
    fetch("nav.html")
    .then(r => r.text())
    .then(html => {
        document.getElementById("main-nav").innerHTML = html;

        //Following code will apply the "current_page" class to <a> in <nav> with (href === current_page)
        current_path = splitAtRoot(current_path);
        let nav = document.getElementById("main-nav");

        for(let child of nav.children){
            //console.log(splitAtRoot(child.href));
            
            if(child instanceof HTMLAnchorElement){
                if(splitAtRoot(child.href) === current_path){
                    //console.log("if condition passed!");
                    child.classList.add("current_page");
                }
                
                //check for a link finishing with a simple "/"" (for my site its "/CS203/"")
                if(splitAtRoot(child.href) === "/CS203/index.php" && current_path === "/CS203/"){
                    //console.log("if condition passed!");
                    child.classList.add("current_page");
                }
            }
        }
    })
};