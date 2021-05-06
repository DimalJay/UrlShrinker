<?php

include "header.php";

if(isset($_POST["file"])){
    // Get parameters
    $key = $_POST["file"]; // Decode URL-encoded string
    $data = getDownloadUrl($conn, $key);

    $key_code = $data["keycode"];
    $filepath = urldecode($data["url"]);
    $filename = basename(parse_url($filepath, PHP_URL_PATH));
    
    if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $filename)){
    
        // Process download
        if(check_file_exist($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            IncreaseDownload($conn, $key_code);
            die();
        } else {
            http_response_code(404);
	        die();
        }
    } else {
        die("Invalid file name!");
    }
}


function check_file_exist($url){
    $handle = @fopen($url, 'r');
    if(!$handle){
        return false;
    }else{
        return true;
    }
}
?>