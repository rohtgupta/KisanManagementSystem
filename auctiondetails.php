<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']) || ($_SESSION['usertype'] !== 1))
        header("Location: index.php");

    $productid = intval($_GET['productid']);
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM cropkart.bid B, cropkart.product P WHERE B.productid = $productid AND P.productid = $productid AND P.farmerid = \"$username\" ORDER BY DATE(B.updated_on)  ASC";

    try{
        $sth = $conn->query($sql);
        $bidinfo = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sql = "SELECT * FROM cropkart.product P WHERE P.productid = $productid";

        $sth = $conn->query($sql);
        $productinfo = $sth->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($productinfo);
    }catch(Exception $e){
        echo $e->getMessage();
        // header("Location: index.php?err=".$e->getMessage());
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="auctiondetails.js" defer></script>
    <title>Document</title>
</head>
<body>
    <button onclick="location.href= 'login.php?logout=1' ">Logout</button>
    <!-- echo "<button onclick="location.href= 'deleteproduct.php?productid' ">Delete Product</button>"; -->
    
    <?php
        if($productinfo[0]['state'] == 1){
            echo "<button id = 'modify'>Modify Product</button>";
        }
        echo "<button onclick=\"location.href= 'deleteproduct.php?productid= $productid' \">Delete Product</button>";
        if($productinfo[0]['state'] == 1 && count($bidinfo) > 0){
            echo "<table>
                <tr><th>BuyerId</th><th>Bid Amount</th><th>Updated On</th><th>Action</th></tr>";
            
            foreach($bidinfo as $bid){
                echo "<tr><td>".$bid['buyerid']."</td><td>".$bid['amt']."</td><td>".$bid['updated_on']."</td><td>
                <button class= 'acceptbids' data-buyerid = ".$bid['buyerid']." data-id = ".$bid['productid']." data-amt =".$bid['amt'].">Accept & Close</button></td></tr>";
            }

            echo "</table>";
        }else if ($productinfo[0]['state'] == 0){
            echo "<h2> Auction Closed!! </h2>";
        }else{
            echo "<h2>No Bids Yet </h2>";
        }
    ?>
    <div id = 'productdetails' hidden>
        <form method="POST" action ="addproduct.php" >
            <input type="number" name='productid' value = "<?php echo $_GET['productid']?>" hidden>
            <input type="text" name = "name" placeholder="Enter Crop Name" value = "<?php echo $productinfo[0]['name']?>" required>
            <input type="text" name = "category" placeholder="Enter category Eg: Wheat, Rice, Jowar" value = "<?php echo $productinfo[0]['category']?>" required>
            <textarea rows = "15" cols ="10" name = "description" placeholder="Add Description"required><?php echo htmlspecialchars($productinfo[0]['description'])?></textarea>
            <input type="number" name ="weight" placeholder="Enter Weight in kilograms" value = "<?php echo $productinfo[0]['weight']?>" required>
            <input type="number" name ="minbid" placeholder="Enter minimum bid amount" value = "<?php echo $productinfo[0]['min_bid']?>" required>
            <input type="submit" name="modifyproduct">
        </form>
    </div>

    <div id='bidconfirmbox' hidden>
        <form action="acceptbid.php" method="POST">
            <input type ="number" name='productid' readOnly>
            <input type="text" name = 'buyerid' readOnly>
            <input type ="number" name = 'amt' readOnly>
            <input type="submit" name = 'acceptbid' readOnly>
        </form>
    </div>
</body>
</html>