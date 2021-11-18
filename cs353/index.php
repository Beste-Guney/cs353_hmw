<!DOCTYPE html>
    <head>
        <title>CS353 Programming Assignment</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <form name='login_form' action="login.php" method="post" onsubmit="emptyField()">

            <h2>Welcome to Customer Product Service</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <div class='input-field' >
                <label>User Name</label>
                <input type="text" name="username" placeholder="User Name"><br>
                <label>Password</label>
                <input class='input-field' type="password" name="password" placeholder="Password"><br> 
            </div>
            <button type="submit">Login</button>
        </form>
    </body>
    <script>
        function emptyField(){
            var name = document.forms["login_form"]["username"].value;
            var pass = document.forms['login_form']['password'].value;
            if (name == "" && pass == "" )
            {
                alert("Input fields are empty");
                return false;
            }
            else if (name ==  ""){
                alert("Name field is empty");
                return false;
            }
            else if (pass == ""){
                alert("Password field is empty");
                return false;
            }
            return true;
        };
    </script>
</html>