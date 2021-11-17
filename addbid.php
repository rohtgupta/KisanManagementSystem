<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    // var_dump($_POST)

    if(isset($_POST['submitbid'])){

        $sql = "INSERT INTO cropkart.bid (productid, buyerid, amt) VALUES (:productid, :buyerid, :amt)";

        try{
            $stm = $conn->prepare($sql);
            $data = $stm->execute(array(':productid'=> intval($_POST['productid']), ':buyerid'=>$_SESSION['username'],
            ':amt'=>intval($_POST['bid'])));
            
            if(!$data){
                throw new Exception('Bid could not be added');}
            
            header("Location: buyerhome.php?message=Bid Added Successfully");
        }catch(Exception $e){
            // echo $e->getMessage();
            header("Location: index.php");
        }
    }else if(isset($_POST['changebid'])){
        $sql = "Update cropkart.bid SET bid.amt =".intval($_POST['bid'])." Where bid.productid =".intval($_POST['productid'])." AND
        bid.buyerid = \"".$_SESSION['username']."\";";

        try{
            echo $sql;
            $stm = $conn->prepare($sql);
            // $data = $stm->fetchAll();
            // echo $data;
            if(!($stm->execute())){
                throw new Exception('Bid could not be updated');}
            
            header("Location: activebids.php?message=Bid Updated Successfully");
        }catch(Exception $e){
            echo $e->getMessage();
            // header("Location: buyerhome.php?err=".$e->getMessage());
        }
    }else if(isset($_POST['deletebid'])){
        $sql = "DELETE FROM cropkart.bid WHERE bid.productid = ".intval($_POST['productid'])." AND bid.buyerid = \"".$_SESSION['username']."\";";

        try{
            echo $sql;
            $stm = $conn->prepare($sql);

            if($stm->execute()){
                echo "Bid Deleted Successfully!!";
                echo "<a href= 'index.php'>Click to go back</a>";
            }
        }catch(Exception $e){
            header("Location: index.php");
        }
    }

?>