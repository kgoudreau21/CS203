//Lab7 Part 3 C
// Load saved items from localStorage
let items = JSON.parse(localStorage.getItem("items")) || [];
console.log(items);
renderList();  // We want show items in our list before adding new ones.

function renderList(){
      items.forEach((item, index) => {
        renderItem(item.text, item.id);
    })
}


//lab7 Part 3 A
function addItem(){
    let item_text = document.getElementById("input").value;
    item_text = item_text.trim(); //Removes whitespace from both sides of a string: https://www.w3schools.com/jsref/jsref_trim_string.asp
    //console.log(item_text);

    if(item_text==''){
        window.alert("The input for your To Do List is empty!");
        return;
    } else{
        //Lab7 Part 3 C: Save in storage
        const newItem = {
            text: item_text,
            id: Date.now()  // unique timestamp-based id
        };
        items.push(newItem);
        localStorage.setItem("items", JSON.stringify(items));

        renderItem(item_text);
    }
}

function renderItem(item_text, id){
    //console.log(item_text);
    //console.log(id);

    let list_item = document.createElement('li'); //create li element, reference: https://www.w3schools.com/jsref/met_document_createelement.asp
    
    //Lab7 Part 3 C
    list_item.dataset.id = id; //Store id in DOM, Reference: https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset

    let span_text = document.createElement('span'); //create span element
    span_text.textContent = item_text; //set span element's text Content
    list_item.appendChild(span_text); //add span_text as child to list_item

    let trash_span = document.createElement('span'); //create 2nd span element
    trash_span.classList.add('fas', 'fa-trash'); //set classes as ‘fa’ and ‘fa-trash’
    list_item.appendChild(trash_span); //add trash_span as child to list_item
    trash_span.addEventListener("click", () => {
        list_item.remove() //add an even listener to span_trash. When clicked will remove list_item.

        //Lab7 Part 3 C
        items = items.filter(x => x.id !== id); // Remove based on unique id
        localStorage.setItem("items", JSON.stringify(items)); //Update localStorage
    ;});

    console.log(list_item);
    document.getElementById("list").appendChild(list_item); //add list_item as child to element with ID="list"
}