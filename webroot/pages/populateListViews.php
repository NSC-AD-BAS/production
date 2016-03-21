<?php

function populate_internships() {
    $mysqli = get_db_connection();

    /* Select queries return a resultset */
    # first two values in internship are internship_id and org_id
    # slots available, date posted, start date printed on 2nd line of element
    if ($result = $mysqli->query("SELECT * FROM internship_list")) {
        $infoArray = mysqli_fetch_assoc($result);
        echo "<div id=\"list_view\">";
        echo "<p id=\"query_stats\">";
        printf("Select returned %d internships.\n", $result->num_rows);
        echo "</p><br /><ul>";
        foreach ($result as $row) {
            echo "<li>Internship: <br />";
            foreach ($row as $element) {
                echo $element . "&emsp;";
            }
            echo "</li></br >";
        }
        echo "</ul></div>";
        /* free result set */
        $result->close();
    }
    $mysqli->close();
}

function populate_users() {
    $mysqli = get_db_connection();
    /* Select queries return a resultset */
    if ($result = $mysqli->query("SELECT * FROM user_list")) {

        echo "<div id=\"list_view\">";
        echo "<p id=\"query_stats\">";
        printf("Select returned %d users.\n", $result->num_rows);
        echo "</p><br /><ul>";
        foreach ($result as $row) {
            echo "<li>User: <br />";
            foreach ($row as $element) {
                echo $element . "&emsp;";
            }
            echo "</li></br >";
        }
        echo "</ul></div>";
        /* free result set */
        $result->close();
    }
    $mysqli->close();
}

function populate_students() {
    $mysqli = get_db_connection();
    /* Select queries return a resultset */
    if ($result = $mysqli->query("SELECT * FROM student_list")) {

        echo "<div id=\"list_view\">";
        echo "<p id=\"query_stats\">";
        printf("Select returned %d students.\n", $result->num_rows);
        echo "</p><br /><ul>";
        foreach ($result as $row) {
            echo "<li>Student: <br />";
            foreach ($row as $element) {
                echo $element . "&emsp;";
            }
            echo "</li></br >";
        }
        echo "</ul></div>";
        /* free result set */
        $result->close();
    }
    $mysqli->close();
}

function populate_orgs() {
        $mysqli = get_db_connection();
        /* Select queries return a resultset */
        if ($result = $mysqli->query("SELECT * FROM org_list")) {
            $infoArray = mysqli_fetch_assoc($result);
            $orgId = $infoArray["OrganizationId"];
            echo "<div id=\"list_view\">";
            echo "<p id=\"query_stats\">";
            printf("Select returned %d organizations.\n", $result->num_rows);
            echo "</p><br /><ul>";
            foreach ($result as $row) {
                echo "<li>Organization: <br />";
                foreach ($row as $element) {
                    echo "<a href='organizationDetailView.php?value=10'>";
                    echo $element . "&emsp;";
                }
                echo "</a></li></br >";
            }
            echo "</ul></div>";
            /* free result set */
            $result->close();
        }
        $mysqli->close();
}

function get_db_connection() {
    include 'db_connect.php';
    //create and verify connection
    $mysqli_obj = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli_obj->connect_error) {
        die('DB Connection Error: ' . $mysqli_obj->connect_errno . $mysqli_obj->connect_error);
    }
    return $mysqli_obj;
}
?>