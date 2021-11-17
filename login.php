<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    if (isset($_GET['logout'])){
        setcookie('user', "", 1);
        session_unset();
        session_destroy();
        header("Location: index.php");
    }else if (isset($_POST['login'])){

        try{
            $id = $_POST['loginid'];
            $sql = "SELECT * FROM cropkart.users S WHERE S.loginID = \"$id\" ";

            $user = $conn->query($sql);
            
            if($user->rowcount() < 1 || $user->rowcount() > 1){
                throw new Exception("Invalid Username");
            }
            $data = $user->fetchAll(PDO::FETCH_ASSOC);

            if (md5($_POST['password']) === $data[0]['passwordkey'] ){
                $_SESSION['username'] = $id;
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                setcookie('user', $token, time()+(86400*30), "/");
                $_SESSION['usertype'] = (int)$data[0]['type'];

                if ($data[0]['type'] === 1)
                    header("Location: farmerhome.php");
                else if($data[0]['type'] === 0)
                    header("Location: buyerhome.php");

            }else{
                throw new Exception("Invalid Password");
            }
        }catch (Exception $err){
            header("Location: index.php"."?err=".$err->getMessage()."&user=".$_POST['loginid']."&login=1");
        }
    }
?>


