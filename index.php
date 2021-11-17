<?php 
    // require_once('database_connect.php');
    session_start();

    if((isset($_SESSION['token'])) && (isset($_COOKIE['user'])) && ($_SESSION['token'] === $_COOKIE['user'])){
        if($_SESSION['usertype'] === 1){
            header("Location: farmerhome.php");
        }else if($_SESSION['usertype'] === 0){
            header("Location: buyerhome.php");
        }
    }

    include('index1.html');

    if(isset($_GET['login'])){
        $user = $_GET['user'];
        echo "<script>
            var login = document.getElementsByClassName('login')[0];
            var id = login.querySelector('input[name = \'loginid\']');

            id.value = '$user';
            login.style.display = 'block';
         </script>";

        echo $_GET['err'];
    }

    if(isset($_GET['registerfarmer'])){
        $user = array($_GET['uid'], $_GET['name'], $_GET['loginid']);

        echo "<script async> 
            var register = document.getElementsByClassName('register')[0];
            var type = register.querySelector('input[name= \'type\'][value = \'0\']');
            type.checked = 'True';
            
            register.style.display = 'block';

            var farmer = document.getElementsByClassName('farmerform')[0];
            farmer.style.display = 'block';
           
            farmer.querySelector('input[name=\'UID\']').value = '$user[0]';
            farmer.querySelector('input[name=\'name\']').value = '$user[1]';
            farmer.querySelector('input[name=\'loginid\']').value = '$user[2]';

        </script>";
        echo '<br><br>'.$_GET['err'];
    }

    if(isset($_GET['registerbuyer'])){
        $user = array($_GET['uid'], $_GET['name'], $_GET['loginid']);

        echo "<script async> 
            var register = document.getElementsByClassName('register')[0];
            var type = register.querySelector('input[name= \'type\'][value = \'1\']');
            type.checked = 'True';
            
            register.style.display = 'block';

            var buyer = document.getElementsByClassName('buyerform')[0];
            buyer.style.display = 'block';
           
            buyer.querySelector('input[name=\'UID\']').value = '$user[0]';
            buyer.querySelector('input[name=\'name\']').value = '$user[1]';
            buyer.querySelector('input[name=\'loginid\']').value = '$user[2]';

        </script>";
        echo '<br><br>'.$_GET['err'];
    }

    if (isset($_GET['message']))
        echo '<br><br>'.$_GET['message'];
?>



