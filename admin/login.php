<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"><!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/argon-dashboard/assets/vendor/nucleo/css/nucleo.css" type="text/css"><!-- CSS -->
    <link rel="stylesheet" href="https://demos.creative-tim.com/argon-dashboard/assets/css/argon.min.css?v=1.2.0" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php 
        error_reporting(0);
        include("../header.php");
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (!empty($_POST['login'])){
                $user = $conn -> real_escape_string($_POST['user']);
                $pass = md5($conn -> real_escape_string($_POST['pass']));

                $sql = "SELECT id FROM jadmin WHERE username = '$user' and passcode = '$pass'";
                $result = $conn->query($sql);

                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                $count = mysqli_num_rows($result);

                if($count == 1) {
                    addCookie("user",$user);
                    addCookie("pass",$pass);
                    
                    #header("location:index.php");
                    echo "You are Logged";
                }else {
                    $error = "Your Login Name or Password is invalid";
                }

                
            }
        }
    ?>

</head>
<body>
<?php //md5("dimalJAYadmin^^^");?>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="user">Username:</label>
                <input type="text" name="user" id="user" class="form-control">
            </div>
            <div class="form-group">
                <label for="user">Password:</label>
                <input type="password" name="pass" id="pass" class="form-control">
            </div>
            <input type="submit"class="btn btn-danger btn-block" name="login"  value="Login">
        </form>
    </div>
</body>
</html>