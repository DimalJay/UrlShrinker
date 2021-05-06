<?php 

    include "header.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(empty($_POST["update"]))){
            
            $email_addr = $_POST["email"];
            $key_code = $_POST["key"];
            addusr($conn, $email_addr, $key_code);
            echo "true";


        }else if(!(empty($_POST["download"]))){
        
            $key_code = $_POST["key"];

            header('Content-Type: application/json');
            $data = getDownloadUrl($conn, $key_code);
            echo json_encode($data);

        }
    
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>