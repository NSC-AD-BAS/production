<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php
/*-------- CONFIG SECTION --------------*/
/* Supply parameters $username, $message,
and $password with the appropriate credentials to
be entered in log*/
$servername = "localhost";
$username = "root";
$password = "";
$message = "11 A first new log message";
$userid = 112;
$dbname = "prism";

function writeLog($userid, $message, $servername, $username, $password, $dbname)
{
    $mysqli = new mysqli($servername, $username, $password, $dbname);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    if ($stmt = $mysqli->prepare('INSERT INTO change_log (UserId, Message) VALUES(?,?)')) {
        $stmt->bind_param('is', $userid, $message);
        $stmt->execute();
    } else {
        echo 'Failed statement';
    }

    mysqli_close($mysqli);
}

function viewLog($servername, $username, $password, $dbname)
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT LogTime, UserId, Message FROM change_log ORDER BY LogTime;";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $count = 1;
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div>" . $count . " Time: " . $row["LogTime"] . " User: " . $row["UserId"] . " Change: " . $row["Message"] . "</div><hr>";
            $count++;
        }
    }
    else {
        echo "0 results";
    }

    mysqli_close($conn);
}

writeLog(5, "test", $servername, $username, $password, $dbname);
viewLog($servername, $username, $password, $dbname);


?>
</body>
</html>


​
