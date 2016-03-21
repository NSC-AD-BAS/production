<?php

function populate_internship_detail($val) {
    $mysqli = get_db_connection();

    if($result = $mysqli->query("CALL internship_detail_single($val)")) {
        echo "<h1>$result</h1>";
    }
}

function populate_org_detail($val) {
    $mysqli = get_db_connection();

    if($result = $mysqli->query("CALL org_detail_single($val)")) {
        echo "<ul>";
        foreach($result as $row) {

            foreach($row as $element) {
                echo "<li>$element</li>";
            }
        }
        echo "</ul>";
    }
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