if(document.readyState == "loading"){
    document.addEventListener('DOMContentLoaded', ready);
}else{
    ready();
}

function ready(){
    searchbar();
}

function searchbar(){
    var btn = document.getElementById('searchbtn');

    btn.addEventListener('click', ()=>{
        var productform = document.getElementById('searchbar');
        productform.hidden = false;
    });
}
