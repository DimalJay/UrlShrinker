<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include "header.php";
        
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div>
        <table class="table">
            <thead>
                <th>Key Code</th>
                <th>File name</th>
                <th>Url</th>
                <th>Downloads</th>
            </thead>
            <tbody>
            <?php 
                $query = "SELECT * FROM downl";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()){
                    $key = $row["keycode"];
                    $url = $row["link"];
                    $title = $row["title"];
                    $count  =$row["downloads"];

                    echo "<tr>";
                    echo "<td><a href='http://localhost/download/index.php?key=$key' target='_blank'>$key</a></td>";
                    echo "<td>$title</td>";
                    echo "<td>$url</td>";
                    echo "<td>$count</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>

    
</body>
</html>