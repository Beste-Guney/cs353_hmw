<?php
include 'session.php';


if (isset($_POST['amount'])) {
    function validate($data){

        $data = trim($data);
 
        $data = stripslashes($data);
 
        $data = htmlspecialchars($data);
 
        return $data;
 
     }
 
     $pid = validate($_POST['pid']);
     $pamount = validate($_POST['amount']);
     
     //query for customer budget
     $query = 'select wallet from customer where cid=' .'\'' .$current_user_id. '\'';
     $resultedQuery = $conn->query($query);
     if (!$resultedQuery) {
        echo 'not found';
    }

     $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);

     $amount = $currentTuple[0];

     //query for product price
     $query = 'select price from product where pid=' .'\'' .$pid. '\'';
     $resultedQuery = $conn->query($query);
     $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
     $price = $currentTuple[0];

     //query for stock amount
     $query = 'select stock from product where pid=' .'\'' .$pid. '\'';
     $resultedQuery = $conn->query($query);
     $currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
     $stock = $currentTuple[0];

     if($stock < $_POST['amount']){
         header("Location: mainpage.php?error=Unsufficient Stock");
         exit();
     }
     else if ($_POST['amount'] == 0){
        header("Location: mainpage.php?error=Please enter an amount to buy");
        exit();
     }
     else if($price * $_POST['amount'] > $amount){
         header("Location: mainpage.php?error=You cannot afford it");
         exit();
     }
     else{
         $newAmount = $amount - $price * $_POST['amount'];
         $newStock = $stock - $_POST['amount'];
         $query = 'update customer set wallet =' .'\'' .$newAmount. '\' where cid=' .'\'' .$current_user_id. '\'';
        $resultedQuery = $conn->query($query);
        $query = 'update product set stock =' .'\'' .$newStock. '\' where pid=' .'\'' .$pid. '\' ';
        $resultedQuery = $conn->query($query);
        $query = 'insert into buy values('.'\'' .$current_user_id. '\',' .'\'' .$pid. '\',' .$_POST['amount']. ')';
        $resultedQuery = $conn->query($query);
        header("Location: mainpage.php?success=Successfully bought");
        exit();
     }
     
 
}
else{
    header("Location: mainpage.php?error=Could not find amount");
}

