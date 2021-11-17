<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']) || ($_SESSION['usertype'] !== 1))
        header("Location: index.php");

    // echo $_GET['productid'];

    $sql = "SELECT * FROM cropkart.product P WHERE P.productid =".$_GET['productid'].";";

    try{
        $sth = $conn->query($sql);
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($data);
        if($data[0]['farmerid'] !== $_SESSION['username']){
            throw new Exception('Invalid Action!!');
        }

        $sql = "DELETE FROM cropkart.product  WHERE productid = ".$_GET['productid'].";";

        $stm = $conn->prepare($sql);

        if($stm->execute()){
            echo "Product Deleted Successfully!!";
            echo "<a href= 'index.php'>Click to go back</a>";
        }

    }catch(Exception $e){
        header("Location: index.php");
    }

?>