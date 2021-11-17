if(document.readyState == "loading"){
    document.addEventListener('DOMContentLoaded', ready);
}else{
    ready();
}

function ready(){
    addproject();
    acceptbids();
}

function addproject(){
    var btn = document.getElementById('modify');

    btn.addEventListener('click', ()=>{
        var productform = document.getElementById('productdetails');
        productform.hidden = false;
    });
}

function acceptbids(){
    var acceptbtn = document.getElementsByClassName('acceptbids');
    // console.log(acceptbtn);
    for(var i =0; i < acceptbtn.length; i++){
        acceptbtn[i].addEventListener('click', (e)=>{
            var box = document.getElementById('bidconfirmbox');
            // console.log(box);

            var productid = box.querySelector("input[name ='productid']");
            var buyerid = box.querySelector("input[name ='buyerid']");
            var amt = box.querySelector("input[name ='amt']");

            // console.log(e.target);
            productid.value = e.target.dataset.id;
            buyerid.value = e.target.dataset.buyerid;
            amt.value = e.target.dataset.amt;

            productid.readOnly = true;
            buyerid.readOnly = true;
            amt.readOnly = true; 
            box.hidden = false;
        });
    }
}