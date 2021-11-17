<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    $username = $_SESSION['username'];

    if(isset($_POST['addproduct']))
    {
        $sql = "INSERT INTO cropkart.product (farmerid, name, description, weight, min_bid, category, state) VALUES (:farmerid, :name, :description, :weight, :minbid, :category, :state)";

        try{
            $stm = $conn->prepare($sql);
            $data = $stm->execute(array(':farmerid'=> $username, ':name'=> $_POST['name'], ':description'=>$_POST['description'],
            ':weight'=>$_POST['weight'],
            ':minbid'=>$_POST['minbid'],
            ':category'=>$_POST['category'],
            ':state'=>1));

            if(!$data){
                throw new Exception('Product could not be added');}
            
            header("Location: farmerhome.php?message=Product Added Successfully");
        }catch(Exception $e){
            header("Location: farmerhome.php?err=".$e->getMessage());
        }
    }else if(isset($_POST['modifyproduct'])){
        $sql = "Update cropkart.product SET
        product.name = \"".$_POST['name']."\",  product.description = \"".$_POST['description']."\", product.category = \"".$_POST['category']."\"
        , product.weight = ".intval($_POST['weight']).", product.min_bid = ".intval($_POST['minbid'])." WHERE product.productid =".intval($_POST['productid'])." AND product.farmerid = \"".$_SESSION['username']."\";";
        
        try{
            // echo ($sql);
            $data = $conn->query($sql);
    
            if(!$data){
                throw new Exception('Product could not be added');}
            
            header("Location: farmerhome.php?message=Product Added Successfully");
        }catch(Exception $e){
            // echo $e->getMessage();
            header("Location: farmerhome.php?err=".$e->getMessage());
        }
    }
?>