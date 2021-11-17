<?php 
    require_once('database_connect.php');
    session_start();

    if(!(isset($_SESSION['token'])) || !(isset($_COOKIE['user'])) || ($_SESSION['token'] !== $_COOKIE['user']))
        header("Location: index.php");

    if(isset($_POST['search'])){
        $sql = "Select * FROM cropkart.product P where (P.name like \"%".$_POST['searchtext']."%\" OR P.category like \"%".$_POST['searchtext']."%\") AND P.state = 1;";
    
        try{
            $stm = $conn->query($sql);
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){
            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src = "search.js" defer></script>
</head>
<body>
    <div id = "searchbar">
        <form action="search.php" method = 'POST'>
            <input type="text" name ='searchtext' placeholder ='Enter name or category' value = "<?php echo $_POST['searchtext']?>">
            <input type="submit" name = 'search'>
        </form>
    </div>

    <?php
        if(count($data) > 0){
            echo "<table> <tr><th>Farmerid</th><th>Productid</th><th>Name</th><th>Description</th><th>Category</th><th>Weight</th><th>Min Bid</th><th>Action</th></tr>";
            foreach($data as $ele){
                echo "<tr><td>".$ele['farmerid']."</td><td>".$ele['productid']."</td><td>".$ele['name']."</td><td>".$ele['description']."</td><td>
                ".$ele['category']."</td><td>".$ele['weight']."</td><td>".$ele['min_bid']."</td><td><button class = 'addbid' data-id =".$ele['productid'].">Add bid</button></td></tr>";
            }

            echo "</table>";
        }else{
            echo "<h2> No results found </h2>";
        }
    ?>

    <div id = 'bidformbox' hidden>
        <form id = 'bidform' action="addbid.php" method = 'POST'>
            <input type="number" name ='productid' readOnly>
            <input type="number" name ="bid" placeholder ='Enter bid amount' required>
            <input type ="submit" name = "submitbid">
        </form>
    </div>
    
</body>
</html>