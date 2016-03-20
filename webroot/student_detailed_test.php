<?php
/**
 * Class that takes a search result from a previous link about hte student and 
 * prints all the detailed information from two tables of the database
 * @author Samuel No
 * @version 2/29/16
 */
class student_detailed_test {
  /**
   * MySQLi connection
   * @access private
   * @var object
   */
  private $student_search_term;
  private $user_search_term;
  private $stud_row;
  private $user_row;
  private $user_notes_table;
  private $conn;
  private $user_notes = [];
  /**
   * Constructor
   *
   * This sets up the class
   */
  public function __construct() {		
 	//$this->student_search_term = mysqli_real_escape_string($search_term);
	$this->connect();
	$this->getQueryTerms();
	}
  public function connect(){
	// Connect to our database and store in $mysqli property
	$this->conn = mysqli_connect('localhost', 'root', 'root', 'prism');
	if(!$this->conn){
		die("Connection failed: " . mysqli_connect_error());
	}	
  }
  /**
   *Function that grabs the user name details from the database through queries
   *assuming that we already have students from a link
   */
  public function getQueryTerms(){
	$this->student_search_term = mysqli_query($this->conn, "SELECT * FROM students
															WHERE StudentId = 1");
	$this->stud_row = mysqli_fetch_assoc($this->student_search_term);
	$userId = $this->stud_row["UserId"];
	$this->user_notes_table = mysqli_query($this->conn, "SELECT * FROM user_notes
													     WHERE UserId = '$userId'");
	$this->getUserNotes();
	$sql = "SELECT * FROM users 
			WHERE UserId = '$userId'";
	$this->user_search_term = mysqli_query($this->conn, $sql);
	//$this->user_search_term = mysqli_real_escape_string($this->user_search_term);
	$this->user_row = mysqli_fetch_assoc($this->user_search_term);
  }
  
  /**
    * Function that returns the row with the student query in it
	* @return student row 
    */
  public function getStudQuery(){
	  return $this->stud_row;
  }
  
  /**
    * Function that returns the row with the student query in it
	* @return student row 
    */
  public function getUserQuery(){
	  return $this->user_row;
  }
  
  private function getUserNotes(){
	  while($row = mysqli_fetch_assoc($this->user_notes_table)){
		  $this->user_notes[] = $row;
	  }
  }
  
  /**
    * Function that sends a query that updates the database currently connected to
	* @return new name being changed
    */
  public function setStudentName($name){
	  $userId = $this->stud_row["UserId"];
	  $sql = "UPDATE users
			  SET FullName='$name'
			  WHERE UserId = '$userId'";
	  mysqli_query($this->conn, $sql);
  }
  
  /**
    * Function that sends a query that updates the student id to the database
	* @return new student id 
    */
  public function setStudentId($studentId){
	  $userId = $this->stud_row["UserId"];
	  $sql = "UPDATE students
			  SET StudentId = '$studentId'
			  WHERE UserId = '$userId'";
	  mysqli_query($this->conn, $sql);
  }
  
  /**
    * Function that sends a query that updates the current active status
	* @return new name being changed
    */
  public function setActiveStatus($status){
	  $userId = $this->stud_row["UserId"];
	  $sql = "UPDATE students
			  SET ProgramStatus = '$status'
			  WHERE UserId = '$userId'";
	  mysqli_query($this->conn, $sql);
  }
  
  /**
    * Function that sends a query that updates the database currently connected to
	* @return new name being changed
    */
  public function setCohort($cohort){
	  $studentId = $this->stud_row["StudentId"];
	  $sql = "UPDATE students
			  SET Cohort = '$cohort'
			  WHERE StudentId = '$studentId'";
	  mysqli_query($this->conn, $sql);
  }
  
  public function displayFullName(){
	  echo $this->user_row["FullName"];
  }
  
  public function displayUserName(){
	  echo $this->user_row["UserName"];
  }
  public function displayContactInfo(){
	  echo $this->user_row["ContactInfo"];
  }
  public function displayProgramStatus(){
	  echo $this->stud_row["ProgramStatus"];
  }
  public function displayStreetAddressLineOne(){
	  echo $this->stud_row["StreetAddressLineOne"];
  }
  public function displayStreetAddressLineTwo(){
	  echo $this->stud_row["StreetAddressLineTwo"];
  }
  
  public function displayCity(){
	  echo $this->stud_row["City"];
  }
  
  public function displayState(){
	  echo $this->stud_row["State"];
  }
  
  public function displayUserNotes(){
	  //checks if there were any notes to display
	  if(!$this->user_notes_table){
		  return false;
	  }
	  foreach($this->user_notes as $use_note){
		  echo $use_note["Note_Type"] . "<br>";
		  echo $use_note["Note_Text"] . "<br>";
	  }
  }
  
  /**
   * Method that echos all the data about the student into html from the query results
   */
  public function displayStudDetails(){
	echo "UserId: " . $this->user_row["UserId"] . "<br>";
	echo "Name: " . $this->user_row["FullName"] . "<br>";
	echo "UserName: " . $this->user_row["UserName"] . "<br>";
	echo "Contact Info: " . $this->user_row["ContactInfo"] . "<br>";
	echo "Program Status: " . $this->stud_row["ProgramStatus"] . "<br>";
	echo "Cohort: " . $this->stud_row["Cohort"] . "<br>";
	echo "Address: " . $this->stud_row["StreetAddressLineOne"] . "<br>";
	echo "Address: " . $this->stud_row["StreetAddressLineTwo"] . "<br>";
	echo "City: " . $this->stud_row["City"] . "<br>";
	echo "State: " . $this->stud_row["State"] . "<br>";
  }
}