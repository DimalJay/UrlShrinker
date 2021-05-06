<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include "../header.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST["upload"])){
                $title = $conn -> real_escape_string($_POST['filename']);
                $des = $conn -> real_escape_string($_POST['description']);
                $url = $conn -> real_escape_string($_POST['url']);

                $random_key = generateUnicId($conn);
                $sql = "INSERT INTO `downl`(`keycode`, `title`, `subtitle`, `link`, `downloads`) VALUES ('$random_key','$title','$des','$url','0')";
                if($conn->query($sql)===TRUE){
                    echo "<script>alert('$random_key')</script>";
                }
            }
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
        if(!isset($_COOKIE["user"]) && !isset($_COOKIE["pass"])){
            //header("location:login.php");
            echo "Not Logged";
        }
    ?>
</head>
<body>
    <div class="container p-3">
        <h1>File Uploader v2</h1>
        <form class="form-group" method="post">
            <div class="form-group">
                <label for="filename">File Title:</label>
                <input type="text" name="filename" id="filename" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">File description</label>
                <input type="text" name="description" id="description" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="url">File Url</label>
                <input type="text" name="url" id="url" class="form-control" required>
            </div>
                <button type="submit" name="upload" value="Upload" class="btn btn-success btn-block">Upload</button>
        </form>
    </div>
</body>
</html>