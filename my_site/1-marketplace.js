
function Cart(){
    this.itemGroups = [];
    this.showTotalAmount = function(){
        if (this.itemGroups.length == 0){
            document.write("<p>You have 0 items, for a total amount of 0$, in your cart! </p>");
        } else  {
            let total_amount = this.getTotalAmount();
            let total_number = this.getTotalNumber();
           document.write("<p>You have "+total_number+" item(s), for a total amount of "+total_amount.toFixed(2)+"$. The Total amount with 15% tax is: "+(total_amount*1.15).toFixed(2)+"$!</p>")
        }
    }

    //Methods
    this.addItemGroup = function(x){
        this.itemGroups.push(x);
    }

    this.getTotalAmount = function(){ //returns total price of items in a cart
        let total=0; //initialize total
        for(let x=0;x<this.itemGroups.length;x++){ //for loop repeats for all items in array itemGroups
            total+=((this.itemGroups[x].price)*(this.itemGroups[x].number));
        }
        return total;
    }

    this.getTotalNumber = function(){ //returns total number of items in a cart
        let total=0; //initialize total
        for(let x=0;x<this.itemGroups.length;x++){ //for loop repeats for all items in array itemGroups
            total+=(this.itemGroups[x].number);
        }
        return total;
    }
}


//ItemGroup Prototype
function ItemGroup(name, price, number){ //(name of item, price per item, number of items)
    this.name=name;
    this.price=price;
    this.number=number;
}


document.write("<h2> 1) Creating the cart </h2>")
let my_cart = new Cart()
my_cart.showTotalAmount();
document.write("<h2> 2) Adding 15 pants at 10.05$ each to the cart! </h2>")
let pants = new ItemGroup("pants", 10.05, 15);
my_cart.addItemGroup(pants)
my_cart.showTotalAmount();
document.write("<h2> 3) Adding 1 coat at 99.99$ to the cart! </h2>")
let coat = new ItemGroup("pants", 99.99, 1);
my_cart.addItemGroup(coat)
my_cart.showTotalAmount();