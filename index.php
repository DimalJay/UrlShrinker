<!DOCTYPE html>
<html lang="en">
<head>
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
    include "header.php";
    $title = $subtitle = $total_dowl = $key_code = "";


    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        if (!empty($_GET['key'])){
            $key = $conn -> real_escape_string($_GET['key']);
            $query_selectfile = "SELECT * FROM `downl` WHERE `keycode`='$key'";

            $user_result = $conn->query($query_selectfile);
            
            if ($user_result->num_rows > 0) {
                while($row = $user_result->fetch_assoc()) {
                    $key_code = $row["keycode"];
                    $title = $row["title"];
                    $subtitle = $row["subtitle"];
                    $total_dowl = $row["downloads"];
                }
            }else{
               //header("location:http://localhost/quiz");
            }
        }
    }
    ?>
</head>
<body class="d-flex align-items-center">
    <div class="container-fluid pt-3 ">
        <div class="card card-stats draggable" draggable="true">
            <div class="card-body">
                <img src="img.png" class="mx-auto d-block logo">
                <h1><?php echo $title; ?></h1>
                <p><?php echo $subtitle;?></p>

                <input type="hidden" id="key" value="<?php echo $key_code;?>"/>
                <div class="email-feild">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" class="form-control email" placeholder="Email Address" aria-label="email" name="email" required aria-describedby="basic-addon1">
                    </div>
                    <button class="btn mt-2 btn-danger btn-block subscribe">Subscribe</button>
                </div>
                <div class="card text-dark download-panel">
                    <div class="card-body">                   
                        <!-- Auto width -->
                        <div class="row">
                            <div class="col"><div class="btn dat"><?php echo $title; ?></div></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="btn dat" id="count" style="font-size:12px">Total Downloads <?php echo $total_dowl?></div>
                            </div>
                            <div class="col">
                                <button class="btn da download" disabled><i class="fa fa-download"></i> Download</button>
                            </div>
                        </div>
                    </div>
                </div>

                <p></br>Type your email address to get the download button. There is no charge for this and your file can be easily downloaded</p>
                
            
        </div>    
    </div>

    <script src="script.js"></script>
</body>

</html>