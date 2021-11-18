<?php
include "config.php"; 
include 'session.php';

if (isset($_POST['amount'])) {
    function validate($data){

        $data = trim($data);
 
        $data = stripslashes($data);
 
        $data = htmlspecialchars($data);
 
        return $data;
 
     }
 
     $pamount = validate($_POST['amount']);
     echo $pamount;
     $query = 'update customer set wallet =' .'\'' .$pamount. '\' where cid=' .'\'' .$current_user_id. '\'';
    $resultedQuery = $conn->query($query);
    header("Location: mainpage.php");
}else{
    header("Location: login.php");
    echo '<script>alert(\'Please enter an amount to buy\')</script>';
}