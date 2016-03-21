<?php

function get_student_lists($query)
{
    include 'db_connect.php';
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $results = mysqli_query($conn, $query);
    mysqli_close($conn);
    if ($results == FALSE) {
        return array();
    } else {
        $arr = array();
        // Get each result row as an associative array
        while ($row = $results->fetch_assoc()) {
            $arr[] = $row;
        }
        // Free the memory $results used as we now have everything in $arr
        $results->free();
        return $arr;
    }
}



//added new parameters $studentLink - in this case it would be SID
function print_student_list($results, $detailsLink)
{    // indicates that a header row needs to be printed
    $header = true;
    $columns = array_keys($results[0]);
    // Setting up a form to link to detail form.
    echo'<form name="student_id" action="testStudDetail.php" method="POST">';
    echo "<table>";
    foreach ($results as $student) {
        if ($header == true) {
            // Create a header row from the Keys
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<th>" . $column . "</th>";
            }
            echo "</tr>";
            // Header row is printed, so change $header to false
            $header = false;
        }
        echo "<tr>";
        // Print out each column based on the keys
        foreach ($columns as $column) {

            //setting the link to the $studentLink
            if ($column == $detailsLink) {
                echo "<td>";
                echo '<input type="submit" name="student_id" value=" '.$student[$column].' " />';
                echo "</td>";
            } else {
                echo "<td>" . $student[$column] . "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
    echo "<br>";
}

?>

<html>
<head>
    <title>PHP Test</title>
    <link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
session_start();
#print buttons in banner
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
    echo "<a id=\"logout\" href=\"prism_login/logout.php\">L O G O U T</a>";



// Query string to use to get a list of students
$query = "SELECT * FROM student_list WHERE `Program Status` LIKE 'Active'";
// Get the students as an array
$student_list = get_student_lists($query);
// Output them in a table

//Parameter $studentLink set to SID
print_student_list($student_list, "SID");
?>
</body>
</html>