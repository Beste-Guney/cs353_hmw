<?php 

session_start(); 

include "config.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['username']);

    $pass = validate($_POST['password']);

    if (empty($uname)) {

        header("Location: index.php");

        exit();

    }else if(empty($pass)){
        header("Location: index.php");
        exit();

    }else{

        $sql = "SELECT * FROM customer WHERE cname='$uname' AND cid='$pass'";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (strtolower($row['cname'])  === strtolower($uname) && strtolower($row['cid']) === strtolower($pass)) {

                echo "Logged in!";

                $_SESSION['user_name'] = $row['cname'];

                $_SESSION['cid'] = $row['cid'];

                header("Location: mainpage.php");

                exit();

            }else{

                header("Location: index.php?error=Incorect User name or password");

                exit();

            }

        }else{
            echo 'aaaa';
            header("Location: index.php?error=Incorect User name or password");

            exit();

        }

    }

}else{

    header("Location: index.php");

    exit();

}