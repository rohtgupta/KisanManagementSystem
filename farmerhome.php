<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    // echo $_SESSION['usertype'];

    $username = $_SESSION['username'];
    $sql = "SELECT * FROM cropkart.farmer F WHERE F.loginID = \"$username\"";
    
    try{
        $query = $conn->query($sql);
        $userinfo = $query->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($userinfo);
    }catch(PDOException $e){
        header("Location: logout.php?logout=1"."?err=".$err->getMessage().'&'.$query);
    }

    $sql = "SELECT * FROM cropkart.product F WHERE F.farmerid = \"$username\" AND F.state = '1' ORDER BY DATE(updated_on) DESC";

    try{
        $query = $conn->query($sql);
        $productinfo = $query->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($productinfo);
    }catch(PDOException $e){
        header("Location: logout.php?logout=1"."?err=".$err->getMessage().'&'.$query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="farmerhome.js" defer></script>
</head>
<body>
    <button onclick="location.href= 'login.php?logout=1' ">Logout</button>
    <button onclick="location.href= 'transactions.php' ">Transaction History</button><br><br>
    
    <?php 

        if(count($productinfo) > 0){
            echo "<table>
                <tr><th>Name</th><th>Description</th><th>Category</th><th>Weight</th><th>Min Bid</th><th>Updated On</th><th>Auction Details</th></tr>";
            

            foreach($productinfo as $product){
                echo "<tr> <td>".$product['name']."</td><td>".$product['description']."</td><td>".$product['category']."</td><td>".$product['weight'];
                echo "</td><td>".$product['min_bid']."</td><td>".$product['updated_on']."</td><td><a target = \"_blank\" href=auctiondetails.php?productid=".$product['productid'].">link</a></td></tr>";
            }

            echo "</table>";
        }else{
            echo "<h2>No Products to Display </h2>";
        }  
    ?>
    <br><br>
    <button id = 'addproduct'>Add Product</button>
    <div id = 'productdetails' hidden>
        <form method="POST" action ="addproduct.php" >
            <input type="text" name = "name" placeholder="Enter Crop Name" required>
            <input type="text" name = "category" placeholder="Enter category Eg: Wheat, Rice, Jowar" required>
            <textarea rows = "15" cols ="10" name = "description" placeholder="Add Description" required></textarea>
            <input type="number" name ="weight" placeholder="Enter Weight in kilograms" required>
            <input type="number" name ="minbid" placeholder="Enter minimum bid amount" required>
            <input type="submit" name="addproduct">
        </form>
    </div>
</body>
</html>