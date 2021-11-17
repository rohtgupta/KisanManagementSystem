if(document.readyState == "loading"){
    document.addEventListener('DOMContentLoaded', ready);
}else{
    ready();
}

function ready(){
    addproject();
}

function addproject(){
    var btn = document.getElementById('addproduct');

    btn.addEventListener('click', ()=>{
        var productform = document.getElementById('productdetails');
        productform.hidden = false;
    });
}