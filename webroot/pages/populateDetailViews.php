<?php
$type = $_GET['type'];
$id = $_GET['id'];

if($type == 'internship') {
    populate_internship_detail($id);
}
elseif($type == 'organization') {
    populate_org_detail($id);
}
elseif($type == 'student') {
    populate_org_detail($id);
}


function populate_internship_detail($val) {
    $mysqli = get_db_connection();
    if($result = $mysqli->query("CALL internship_detail_single($val)")) {
        echo "<h1>$result</h1>";
    }
}

function populate_org_detail($val) {
    $mysqli = get_db_connection();

    if($result = $mysqli->query("CALL org_detail_single($val)")) {
        echo "<h1>$result</h1>";
    }
}

function populate_student_detail($val) {
    $mysqli = get_db_connection();
    if($result = $mysqli->query("CALL student_detail_single($val)")) {
        echo "<h1>$result</h1>";
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