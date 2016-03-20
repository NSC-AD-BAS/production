<?php
session_start();
//need to check if there's a search given in the first place
if(isset($_POST['student_id'])){
  // Include the search class
  require_once( dirname( __FILE__ ) . '/student_detailed.php' );
  
  //quick search to initialize the class
  include 'db_connect.php';
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  //$student_search_term = mysqli_query($conn, "SELECT * FROM students
	//										  WHERE StudentId = 1");
  // Test to check if we can just have a name to query the database
  //$name = "Bob Ross";
  $student_id = $_POST['student_id'];
  // Instantiate a new instance of the search class
  // This is assuming that we are receiving the search 
  $student_search = new student_detailed($student_id);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Student Detail</title>
		<meta charset="utf-8">
	</head>
	<body>
	<?php echo "<h1>" . $student_search->getFullName() . "</h1>" ?>
	<?php echo "Name: " . $student_search->getFullName() . "<br>" ?>
	<?php echo "UserName: " . $student_search->getUserName() . "<br>" ?>
    <?php echo "Contact Info: " . $student_search->getContactInfo() . "<br>" ?>
    <?php echo "Program Status: " . $student_search->getProgramStatus() . "<br>" ?>
    <?php echo "Cohort: " . $student_search->getCohort() . "<br>" ?>
    <?php echo "Address: " . $student_search->getStreetAddressLineOne(). "<br>" ?>
    <?php echo "Address: " . $student_search->getStreetAddressLineTwo() . "<br>" ?>
    <?php echo "City: " . $student_search->getCity() . "<br>" ?>
    <?php echo "State: " . $student_search->getState() . "<br>" ?>
	<!-- prints out the array of user notes piece by piece -->
	<?php //checks if there were any notes to display
        if(count($student_search->getUserNotesArray()) == 0) {
            return false;
        }
        foreach (($student_search->getUserNotesArray()) as $user_note) {
            echo $user_note["Note_Type"] . "<br>";
            echo $user_note["Note_Text"] . "<br>";
        }
		?>
	<!--<?php $student_search->displayStudDetails()?>-->
	<!--This query updates the database, probably best not to use it-->
	<!--<?php $name = "Bob Ross"; $student_search->setStudentName($name) ?> -->
	<?php echo "<br>"?>
	<!--<?php $student_search->displayUserNotes() ?> -->

	</body>
</html>