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
{
    echo "<h2>" . count($results) . " rows returned." . "</h2>";

    // indicates that a header row needs to be printed
    $header = true;
    $columns = array_keys($results[0]);

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
        if ( $column == $detailsLink){
        		//$student_details.php would be the link from Sam's php
			 echo '<td><form name="student_id" action="testStudDetail.php" method="POST">
					<input type="submit" name="student_id" value=" '.$student[$column].' " />
					</form></td>';
					
       		 //echo '<td><a href="testStudDetail.php">'.$student[$column].'</a></td>';
       		 
       		 }else{  
       		 echo "<td>" . $student[$column] . "</td>";
         }
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
}

?>

<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php
// Query string to use to get a list of students
$query = "SELECT * FROM student_list WHERE `Program Status` LIKE 'Active'";
// Get the students as an array
$student_list = get_student_lists($query);
// Output them in a table

//Parameter $studentLink set to SID
print_student_list($student_list, "SID");
?>
</table>
</body>
</html>