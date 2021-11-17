<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    $username = $_SESSION['username'];

    $sql = "SELECT * FROM cropkart.bill B WHERE (B.farmerid = \"$username\" OR B.buyerid = \"$username\") Order By Date(updated_on);";

    try{
        // echo $sql;
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
</head>
<body>
    <button onclick="location.href= 'login.php?logout=1' ">Logout</button>
    <button onclick="location.href= 'transactions.php' ">Transaction History</button><br><br>

    <?php 
        if(count($data) > 0){
            echo "<table><tr><th>Bill No.</th><th>Product Description</th><th>Transaction Id</th><th>Paid</th><th>Amount</th>
            <th>FarmerId</th><th>Farmer UID</th><th>BuyerId</th><th>Buyer UID</th><th>Delivery Address</th></tr>";
            foreach($data as $ele){
                echo "<tr><td>".$ele['billid']."</td><td>".$ele['product_description']."</td><td>".$ele['transactionid'].
                "</td><td>".($ele['state']==1 ? "Yes":"No")."</td><td>".$ele['amount']."</td><td>".$ele['farmerid']."</td><td>".
                $ele['farmeruid']."</td><td>".$ele['buyerid']."</td><td>".$ele['buyeruid']."</td><td>".$ele['delivery_address']."</td></tr>";
            }
            echo "</table>";
        }else{
            echo "<h2>No bills to display </h2>";
        }
    ?>
</body>
</html>