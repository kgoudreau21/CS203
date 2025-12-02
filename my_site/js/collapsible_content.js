//copied code from: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_collapsible

let coll = document.getElementsByClassName("collapsible");

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
    //Access next element in childList of Parent Element, ref: https://developer.mozilla.org/en-US/docs/Web/API/Element/nextElementSibling
    let content = this.nextElementSibling; 
    if (content.classList.contains("hidden")) {
        content.classList.remove("hidden");
    } else {
        content.classList.add("hidden");
    }
    });
}