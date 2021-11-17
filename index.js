if(document.readyState == "loading"){
    document.addEventListener('DOMContentLoaded', ready);
}else{
    ready();
}

function ready(){
    entrypoint();
    usertype();
}

function entrypoint(){
    var loginbtn = document.getElementById('login');
    var registerbtn = document.getElementById('register');
    var login = document.getElementsByClassName('login1')[0];
    var register = document.getElementsByClassName('signupform')[0];
    var buyer = document.getElementsByClassName('buyerform')[0];
    var farmer = document.getElementsByClassName('farmerform')[0];
    var buyerbtn = document.getElementById('buyer1');
    var farmerbtn = document.getElementById('farmer1');
    var signup = document.getElementsByClassName('signupform');

    loginbtn.addEventListener('click', (e)=>{
        register.style.display = 'none';
        login.style.display = 'block';
 
    });

    registerbtn.addEventListener('click', (e)=>{
        login.style.display = 'none';
        register.style.display = 'block';
        farmer.style.display = 'block';
        buyer.style.display = 'none';
        signup.style.display = 'none';
        loginbtn.classList.remove('active');
        loginbtn.classList.add('inactive');
        registerbtn.classList.add('active');
        registerbtn.classList.remove('inactive');
    });

    buyerbtn.addEventListener('click', (e)=>{
        farmer.style.display = 'none';
        buyer.style.display = 'block';
    });

    farmerbtn.addEventListener('click', (e)=>{
        farmer.style.display = 'block';
        buyer.style.display = 'none';
    });
}

function usertype(){
    var users = document.querySelectorAll('input[type = "radio"][name = "type"]');
    // console.log(users);
    users.forEach((user)=>{
        user.addEventListener('change', formdisplay);
    });
}

function formdisplay(val){
    var form1 = document.getElementsByClassName('farmerform')[0];
    var form2 = document.getElementsByClassName('buyerform')[0];
    if(this.value == 0){
        form2.style.display = "none";
        form1.style.display = "block";
    }else{
        form1.style.display = "none";
        form2.style.display = "block";
    }
}