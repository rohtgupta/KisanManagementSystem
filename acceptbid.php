<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']) || ($_SESSION['usertype'] !== 1))
        header("Location: index.php");

    var_dump($_POST);

    try{
        $conn->beginTransaction();
        $sql = "SELECT * FROM cropkart.product P WHERE P.productid = ".intval($_POST['productid']);

        $stm = $conn->query($sql);
        $productinfo = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo"<br>";
        var_dump($productinfo);

        $sql = "SELECT * FROM cropkart.farmer F WHERE F.loginID = \"".$productinfo[0]['farmerid']."\"";

        $stm = $conn->query($sql);
        $farmerinfo = $stm->fetchAll(PDO::FETCH_ASSOC);

        echo"<br>";
        var_dump($farmerinfo);

        $sql = "SELECT * FROM cropkart.buyer F WHERE F.loginID = \"".$_POST['buyerid']."\"";

        $stm = $conn->query($sql);
        $buyerinfo = $stm->fetchAll(PDO::FETCH_ASSOC);

        echo"<br>";
        var_dump($buyerinfo);

        $sql = "INSERT INTO cropkart.bill (product_description, amount, farmerid, buyerid, farmeruid, buyeruid) 
        VALUES (:pd, :amt, :farmerid, :buyerid, :farmeruid, :buyeruid)";

        $stm = $conn->prepare($sql);
        $data = $stm->execute(array(':pd'=>$productinfo[0]['description'], ':amt'=>intval($_POST['amt']),
            ':farmerid'=>$farmerinfo[0]['loginID'],
            ':buyerid' =>$buyerinfo[0]['loginID'],
            ':farmeruid'=>$farmerinfo[0]['UID'],
            ':buyeruid'=>$buyerinfo[0]['UID'],
        ));

        if(!$data)
            throw new Exception('Failed to accept bid');

        
        $sql = "UPDATE cropkart.product SET product.state = 0 WHERE product.productid = ".intval($productinfo[0]['productid']);

        $stm = $conn->prepare($sql);

        if(!($stm->execute()))
            throw new Exception('Failed to update product');

        $sql = "DELETE FROM cropkart.bid  WHERE bid.productid = ".intval($productinfo[0]['productid']);

        echo "<br>".$sql;
        
        $stm = $conn->prepare($sql);

        if(!($stm->execute()))
            throw new Exception('Failed to update bids');

        $conn->commit();
        header("Location: farmerhome.php?message=Auction Closed Successfully");

    }catch(Exception $e){
        $conn->rollBack();
        header("Location: farmerhome.php?err=".$e->getMessage());
    }
    
?>