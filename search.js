if(document.readyState == "loading"){
    document.addEventListener('DOMContentLoaded', ready);
}else{
    ready();
}

// var last = 0;

function ready(){
    addbid();
}

function addbid(){
    var btns = document.getElementsByClassName('addbid');
    for(var i = 0; i < btns.length; i++){
        btns[i].addEventListener('click', function (e){
            var bidformbox = document.getElementById('bidformbox');
            bidformbox.hidden = false;
 
            var bidform = bidformbox.querySelector("input[name ='productid']");
            bidform.value = Number(e.target.dataset.id);
            bidform.readOnly = true;
            // last = e.target.dataset.id;
        });
    }
}