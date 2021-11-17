<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']) || ($_SESSION['usertype']!==0))
        header("Location: index.php");
    
    $sql = "SELECT * FROM cropkart.bid B, cropkart.product P WHERE B.buyerid = \"".$_SESSION['username']."\" AND P.productid = B.productid;";

    try{
        $stm = $conn->query($sql);
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($data);
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src = 'activebids.js' defer></script>
</head>
<body>
    <?php
        if(count($data) > 0){
            echo "<table><tr><th>ProductId</th>
            <th>FarmerId</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Weight</th>
            <th>Bid Amount</th><th>Action</th></tr>";

            foreach($data as $element){
                echo "<tr><td>".$element['productid']."</td><td>".$element['farmerid']."</td>
                <td>".$element['name']."</td><td>".$element['category']."</td><td>".$element['description']."</td><td>".$element['weight']."</td>
                <td>".$element['amt']."</td><td><button class = 'modifybtn' data-id = ".$element['productid']." data-amt = ".intval($element['amt'])."> Modify Bid </button></td></tr>";
            }

            echo "</table>";
        }
    ?>

    <div id = 'bidformbox' hidden>
        <form id = 'bidform' action="addbid.php" method = 'POST'>
            <input type="number" name ='productid' readOnly>
            <input type="number" name ="bid" placeholder ='Enter bid amount' required>
            <input type ="submit" name = "changebid" value = "Update">
        </form>
        <span> OR </span> 
        <form  action="addbid.php" method = 'POST'>
            <input type="number" name ='productid'  readOnly>
            <input type = "submit" name ='deletebid' value = "Delete Bid">
        </form>
    </div>
</body>
</html>
