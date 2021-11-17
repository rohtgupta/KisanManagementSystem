if(document.readyState == "loading"){
    document.addEventListener('DOMContentLoaded', ready);
}else{
    ready();
}

function ready(){
    modifybids();
}

function modifybids(){
    var modifybtns = document.getElementsByClassName('modifybtn');

    for(var i=0; i < modifybtns.length; i++){

        modifybtns[i].addEventListener('click', (e)=>{
            var bidformbox = document.getElementById('bidformbox');
            bidformbox.hidden = false;

            var bidform = bidformbox.querySelectorAll("input[name ='productid']");
            var bidvalue = bidformbox.querySelector("input[name ='bid']");
            bidform[0].value = Number(e.target.dataset.id);
            bidform[1].value = Number(e.target.dataset.id);
            bidvalue.value = Number(e.target.dataset.amt);
            bidform[0].readOnly = true;
            bidform[1].readOnly = true;
            bidform[1].hidden = true;
        });
    }
}