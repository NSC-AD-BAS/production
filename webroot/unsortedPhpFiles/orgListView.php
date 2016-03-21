<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php
echo "<div id=\"banner\"> <h1>P R I S M </h1>";
    #print buttons in banner
    if ($_SESSION["user_type"] == "Faculty" || $_SESSION["user_type"] == "Admin") {
    echo "<a href=\"studentListView.php\"><button id=\"studentlist\">Students</button></a>";
    }
    echo "<a href=\"internListView.php\"><button id=\"internshiplist\">Internships</button></a>";
    echo "<a href=\"orgListView.php\"><button id=\"orglist\">Organizations</button></a>";

    #print user details in banner
    echo "<span id=\"userinfo\">" . $_SESSION["user_type"] . "&emsp;" . $_SESSION["username"] . " | " . $_SESSION["name"];
    echo "</span></div>";
echo "<a id=\"logout\"href=\"logout.php\">L O G O U T</a>";
?>
<?php
    include 'db_connect.php';
    $rec_limit = 10;
    //create connection
    $conn=mysqli_connect($servername,$username,$password,$dbname);
    //check connection
    if (!$conn){
        die("Connection failed: " .mysqli_connect_error());
    }
    $sql ="SELECT OrganizationId, OrganizationName, NumOfEmployees, City  FROM organizations";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
//output data of each row
        while($row= mysqli_fetch_assoc($result)){
            $varName=$row["OrganizationId"];
            echo "<a href='orgDetailView.php?orgId=$varName'>" .$row["OrganizationName"]. "
-Employee #: " .$row["NumOfEmployees"]. " -City: " .$row["City"]. "</a><br>";
        }
    }else{
        echo "0 results";
    }
    mysqli_close($conn);
    ?>

</div>
</body>
</html>