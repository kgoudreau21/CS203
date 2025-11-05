let current_slide=0;
let number_slides=3;
showSlide(current_slide);

function showSlide(n){
    let slides = document.getElementsByClassName("slideshow_img");
    for(let i=0;i<slides.length;i++){
        if(i===n){
            slides[i].style.display = "block";  // hide it
        } else {
            slides[i].style.display = "none"; // show it
        }
    }
    return;
}

function previous(){
    current_slide--;
    if(current_slide<0){
        current_slide=number_slides-1;
    }
    showSlide(current_slide);
    return;
}

function next(){
    current_slide++;
    current_slide%=number_slides;
    showSlide(current_slide);
    return;
}