<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    $sql = "SELECT * FROM cropkart.bill B WHERE B.buyerid = \"".$_SESSION['username']."\" AND B.state = 0";

    try{
        $stm = $conn->query($sql);
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($data);
    }catch (Exception $e){
        header("Location: buyerhome.php?err=".$e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src = "buyerhome.js" defer></script>
</head>
<body>
    <button onclick="location.href= 'login.php?logout=1' ">Logout</button>
    <button type="menu" id = 'searchbtn'>Search</button>
    <button type="submit" onclick = "location.href = 'activebids.php' ">Active Bids</button>
    <button onclick="location.href= 'transactions.php'">Transaction History</button><br><br>
    <div id = "searchbar" hidden>
        <form action="search.php" method = 'POST'>
            <input type="text" name ='searchtext' placeholder ='Enter name or category'>
            <input type="submit" name = 'search'>
        </form>
    </div>

    <?php
        if(count($data) > 0){

            echo "<table><tr><th>Bill Id</th><th>Product Description</th><th>Amount</th><th>Time</th><th>Action</th></tr>";

            foreach($data as $ele){
                echo "<tr><td>".$ele['billid']."</td><td>".$ele['product_description']."</td><td>".$ele['amount']
                ."</td><td>".$ele['updated_on']."</td><td><button>Pay</button></td></tr>";
            }
        } 
    ?>
    
</body>
</html>
