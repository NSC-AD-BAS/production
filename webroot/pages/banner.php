<?php
echo "<html>";
echo "<head>";
echo "<title>PHP Test</title>";
echo "<link href=\"../css/style.css\" type=\"text/css\" rel=\"stylesheet\" />";
    echo "<script type=\"text/javascript\" src=\"helper.js\"></script>";
echo "</head>";
echo "<body onload=\"setHandlers()\">";

session_start();
#print buttons in banner
echo "<div id=\"banner\"> <h1>P R I S M </h1>";
#print buttons in banner
if ($_SESSION["user_type"] == "Faculty") {
    echo "<a href=\"studentListView.php\"><button id=\"studentlist\">Students</button></a>";
    echo "<a href=\"userListView.php\"><button id=\"userlist\">Users</button></a>";
}
elseif($_SESSION["user_type"] == "Admin") {
    echo "<a href=\"studentListView.php\"><button id=\"studentlist\">Students</button></a>";
}
echo "<a href=\"internListView.php\"><button id=\"internshiplist\">Internships</button></a>";
echo "<a href=\"organizationListView.php\"><button id=\"orglist\">Organizations</button></a>";


echo "<div id=\"search\">";
    echo "<form id=\"searchForm\" action=\"search.php\" method=\"POST\">";
        echo "<input type=\"text\" name=\"searchInput\" class=\"searchBar\">";
        echo "<input type=\"submit\" id=\"searchIcon\" value=\"\">";
    echo "</form>";
echo "</div>";

#print user details in banner
echo "<span id=\"userinfo\">" . $_SESSION["user_type"] . "&emsp;" . $_SESSION["username"] . " | " . $_SESSION["name"];
echo "</span></div>";
echo ">L O G O U T</a><br>";

echo "<div id=\"spacer\"></div>";
echo "</body>";
echo "</html>";
?>
