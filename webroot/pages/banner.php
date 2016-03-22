<html>
<head>
<title>PHP Test</title>
<link href="../css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
session_start();
#print buttons in banner
echo "<div id=\"banner\"> <h1>P R I S M </h1>";
#print buttons in banner
if ($_SESSION["user_type"] == "Admin") {
    echo "<a href=\"studentListView.php\"><button id=\"studentlist\">Students</button></a>";
    echo "<a href=\"userListView.php\"><button id=\"studentlist\">Users</button></a>";
}
if ($_SESSION["user_type"] == "Faculty") {
    echo "<a href=\"studentListView.php\"><button id=\"studentlist\">Students</button></a>";
}
echo "<a href=\"internListView.php\"><button id=\"internshiplist\">Internships</button></a>";
echo "<a href=\"organizationListView.php\"><button id=\"orglist\">Organizations</button></a>";
?>

<div id="search">
    <form id="searchForm" action="search.php" method="POST">
        <input type="text" name="searchInput" class="searchBar">
        <input type="submit" id="searchIcon" value="">
    </form>
</div>

<?php
#print user details in banner
echo "<span id=\"userinfo\">" . $_SESSION["user_type"] . "&emsp;" . $_SESSION["username"] . " | " . $_SESSION["name"];
echo "</span></div>";
echo ">L O G O U T</a><br>";
?>
<div id="spacer"></div>
