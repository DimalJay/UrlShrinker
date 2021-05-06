<?php
    $db_host = "localhost";
    $db_username = "username";
    $db_password = "password";
    $db = "databsename";

    $conn = new mysqli($db_host, $db_username, $db_password, $db);

    $table_name_usr = "usr";
    $table_name_downl = "downl";
    $COOKIE_USR = "usr";
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $sql_usr = "CREATE TABLE $table_name_usr (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(100) NOT NULL,
        usr_agent text,
        browser text,
        os text,
        email VARCHAR(100) NOT NULL,
        key_code VARCHAR(30) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    
    $sql_downl = "CREATE TABLE $table_name_downl (
        keycode VARCHAR(30) PRIMARY KEY,
        title text NOT NULL,
        subtitle text NOT NULL,
        link text NOT NULL,
        downloads int(5),        
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    
    function createTable($conn, $name, $query){
        $table_validator = "select 1 from '$name' LIMIT 1";
        if ($conn->query($table_validator) === FALSE) {
            $conn->query($query);
        }
    }

    function addusr($conn, $email, $key_code){
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $remote_browser = getBrowser();
        $remote_os = getOS();
        global $COOKIE_USR;

        $sql = "INSERT INTO `usr`(`ip`, `usr_agent`, `browser`, `os`, `email`, `key_code`) VALUES ('$ip','$user_agent','$remote_browser','$remote_os','$email','$key_code')";
        
        if($conn->query($sql) === TRUE){
           addCookie($COOKIE_USR,$email);
        }
    }

    function getDownloadUrl($conn, $key_code){
        $sql =  "SELECT * FROM `downl` WHERE `keycode`='$key_code'";
        $user_result = $conn->query($sql);
        
        $response = array();

        if ($user_result->num_rows > 0) {
            while($row = $user_result->fetch_assoc()) {
                $down_url = $row["link"];
                $title = $row["title"];
                $download_count = $row["downloads"];
                $response=array('keycode'=>$key_code,'title'=> $title, 'url'=>urlencode($down_url), 'count'=> $download_count);
            }
        }
    
        return $response;

    }

    function IncreaseDownload($conn,$key_code){
        $sqlget = "SELECT * from downl WHERE keycode='$key_code'";
        
        $count = NULL;

        $getresult = $conn->query($sqlget);
        while($row = $getresult->fetch_assoc()){
            $count = $row["downloads"];
        }
        
        $new_count = (int)$count + 1;
        $sqlupdate = "UPDATE downl SET downloads='$new_count' WHERE keycode='$key_code'";
        $conn->query($sqlupdate);

    }

    function getOS() { 

        global $user_agent;
    
        $os_platform  = "Unknown OS Platform";
    
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }

    function getBrowser() {

        global $user_agent;
    
        $browser        = "Unknown Browser";
    
        $browser_array = array(
                                '/msie/i'      => 'Internet Explorer',
                                '/firefox/i'   => 'Firefox',
                                '/safari/i'    => 'Safari',
                                '/chrome/i'    => 'Chrome',
                                '/edge/i'      => 'Edge',
                                '/opera/i'     => 'Opera',
                                '/netscape/i'  => 'Netscape',
                                '/maxthon/i'   => 'Maxthon',
                                '/konqueror/i' => 'Konqueror',
                                '/mobile/i'    => 'Handheld Browser'
                         );
    
        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;
    
        return $browser;
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateUnicId($conn){
        $random_key = generateRandomString(20);
        $check_sql = "SELECT * FROM downl WHERE keycode='$random_key'";
        $result = mysqli_query($conn,$check_sql);

        if(mysqli_num_rows($result) == 0){
            return $random_key;
        }else{
            //Again
            generateUnicId($conn);
        }
    }

    function addCookie($name,$value){
        setcookie($name, $value, time() + (86400), "/");
    }

    createTable($conn, $table_name_usr, $sql_usr);
    createTable($conn, $table_name_downl, $sql_downl);

?>