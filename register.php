-+<?php 
    require_once('database_connect.php');
    
    if (isset($_POST['farmerform'])){
        try{
            if ($_POST['conf_password'] !== $_POST['password']){
                throw new Exception("Password and Confirm Password Don't Match");
            }

            $id = $_POST['loginid'];
            $sql = "SELECT * FROM cropkart.users S WHERE S.loginID = \"$id\" ";

            $user = $conn->query($sql);
            
            if($user->rowcount() >= 1){
                throw new Exception("Username Already Exist");
            }

            $name = $_POST['name'];
            $password = md5($_POST['password']);

            try{
                $sql = "INSERT INTO cropkart.users VALUES ('$id', '$name', '$password', '1')";
                $conn->exec($sql);
            }catch (PDOException $e){
                throw new Exception($e->getMessage());
            }
            
            $uid = $_POST['UID'];
            $acc = $_POST['account'];
            $ifsc = $_POST['ifsc'];
            
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d', strtotime('+1 years'));

            try{
                $sql = "INSERT INTO cropkart.farmer VALUES ('$id', '$name', '$uid', '$acc', '$ifsc', '$startdate', '$enddate')";
                $conn->exec($sql);
            }catch (PDOException $e){
                throw new Exception($e->getMessage());
            }

            header("Location: index.php"."?message= User Added Succesully!!!");

        }catch(Exception $err){
            $query = http_build_query(array('uid'=>$_POST['UID'], 
            'name'=>$_POST['name'],
            'loginid'=>$_POST['loginid'],
            'registerfarmer'=> 1
        ));
            header("Location: index.php"."?err=".$err->getMessage().'&'.$query);
        }
    }

    if (isset($_POST['buyerform'])){
        try{
            if ($_POST['conf_password'] !== $_POST['password']){
                throw new Exception("Password and Confirm Password Don't Match");
            }

            $id = $_POST['loginid'];
            $sql = "SELECT * FROM cropkart.users S WHERE S.loginID = \"$id\" ";

            $user = $conn->query($sql);
            
            if($user->rowcount() >= 1){
                throw new Exception("Username Already Exist");
            }

            $name = $_POST['name'];
            $password = md5($_POST['password']);

            try{
                $sql = "INSERT INTO cropkart.users VALUES ('$id', '$name', '$password', '0')";
                $conn->exec($sql);
            }catch (PDOException $e){
                throw new Exception($e->getMessage());
            }
            
            $uid = $_POST['UID'];
            
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d', strtotime('+1 years'));

            try{
                $sql = "INSERT INTO cropkart.buyer VALUES ('$id', '$name', '$uid', '$startdate', '$enddate')";
                $conn->exec($sql);
            }catch (PDOException $e){
                throw new Exception($e->getMessage());
            }

            header("Location: index.php"."?message= User Added Succesully!!!");

        }catch(Exception $err){
            $query = http_build_query(array('uid'=>$_POST['UID'], 
            'name'=>$_POST['name'],
            'loginid'=>$_POST['loginid'],
            'registerbuyer'=> 1
        ));
            header("Location: index.php"."?err=".$err->getMessage().'&'.$query);
        }
    }
?>

