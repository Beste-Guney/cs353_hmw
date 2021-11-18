<?php
include 'session.php';


if (isset($_POST['amount']) & isset($_POST['pid'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
 
     $pid = validate($_POST['pid']);
     $pamount = validate($_POST['amount']);
     
     $query = 'select * from buy where cid=' .'\'' .$current_user_id. '\' and pid=' .'\'' .$pid. '\'';
     $resultedQuery = $conn->query($query);
     if (mysqli_num_rows($resultedQuery)==0) {
        header("Location: profile.php?error= Please return something you have");
        exit();
    }

     //query for customer budget
     $query = 'select wallet from customer where cid=' .'\'' .$current_user_id. '\'';
     $resultedQuery = $conn->query($query);
     if (mysqli_num_rows($resultedQuery)==0) {
        echo 'not found';
    }

     $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
     $amount = $currentTuple[0];

     //query for product price
     $query = 'select price from product where pid=' .'\'' .$pid. '\'';
     $resultedQuery = $conn->query($query);
     if (mysqli_num_rows($resultedQuery)==0) {
        echo 'not found product';
    }
     $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
     $price = $currentTuple[0];


     //query for stock amount
     $query = 'select stock from product where pid=' .'\'' .$pid. '\'';
     $resultedQuery = $conn->query($query);
     $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
     $stock = $currentTuple[0];

     //query for the amount of item user has
     $statement = 'select sum(quantity) from buy,product where buy.pid=' .'\'' .$pid. '\' and buy.cid=' .'\'' .$current_user_id. '\'';
    $resultedQuery = $conn->query($statement);
    $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
     $user_has = $currentTuple[0];

     if ($user_has < $_POST['amount']){
        header("Location: profile.php?error= You try to return more than you have ");
        exit();
     }

    $newAmount = $amount + $price * $_POST['amount'];
    $newStock = $stock + $_POST['amount'];
    // $newQuantity = $quantity - $_POST['amount'];
    $query = 'update customer set wallet =' .'\'' .$newAmount. '\' where cid=' .'\'' .$current_user_id. '\'';
    $resultedQuery = $conn->query($query);
    $query = 'update product set stock =' .'\'' .$newStock. '\' where pid=' .'\'' .$pid. '\' ';
    $resultedQuery = $conn->query($query);
    $insert_amount = -1 * $_POST['amount'];
    $query = 'insert into buy values('.'\'' .$current_user_id. '\',' .'\'' .$pid. '\',' .$insert_amount. ')';
    $resultedQuery = $conn->query($query);
     
    header("Location: mainpage.php?error= You have successly returned the product");
    exit();
}
else{
    header("Location: login.php?error=Please enter an amount to buy");
}

