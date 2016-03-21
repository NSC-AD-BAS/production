<?php

/**
 * Class that takes a search result from a previous link about hte student and
 * prints all the detailed information from two tables of the database
 * Most like the echo statements will be made to just return the elements of the query
 * and the html will print out the various things
 * @author Samuel No Raquel Moura
 * @version 2/29/16
 */
class student_detailed
{
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
    private $student_id;
    private $conn;
    private $user_notes = [];
    private $userId;

    /**
     * Constructor
     *
     * This sets up the class
     * @param $search_term The search term passed in from the student list
     */
    public function __construct($search_term)
    {
        $this->connect();
        $this->getQueryTerms($search_term);
    }

    public function connect()
    {
        // Connect to our database and store in $mysqli property
        include 'db_connect.php';
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    /**
     *Function that grabs the user name details from the database through queries
     *assuming that we already have students from a link
     */
    public function getQueryTerms($search_term)
    {
        //$this->student_search_term = $search_term;
        $this->student_id = $search_term;
        $this->student_search_term = mysqli_query($this->conn, "SELECT * FROM students
											  WHERE StudentId = '$this->student_id'");
        $this->stud_row = mysqli_fetch_assoc($this->student_search_term);
        $this->userId = $this->stud_row["UserId"];
        $this->user_search_term = mysqli_query($this->conn, "SELECT * FROM users
											  WHERE UserId = '$this->userId'");
        $this->user_row = mysqli_fetch_assoc($this->user_search_term);
        $this->user_notes_table = mysqli_query($this->conn, "SELECT * FROM user_notes
													     WHERE UserId = '$this->userId'");
        $this->getUserNotes();
        mysqli_close($this->conn);

    }

    /**
     * Function that returns the row with the student query in it
     * @return student row
     */
    public function getStudQuery()
    {
        return $this->stud_row;
    }

    /**
     * Function that returns the row with the student query in it
     * @return student row
     */
    public function getUserQuery()
    {
        return $this->user_row;
    }

    /**
     * Function that builds the notes since there can be multiple into an array
     */
    private function getUserNotes()
    {
        while ($row = mysqli_fetch_assoc($this->user_notes_table)) {
            $this->user_notes[] = $row;
        }
    }

    /**
     * Function that sends a query that updates the database currently connected to
     * @return new name being changed
     */
    public function setStudentFirstName($name)
    {
        $userId = $this->stud_row["UserId"];
        $sql = "UPDATE users
			  SET FirstName='$name'
			  WHERE UserId = '$userId'";
        mysqli_query($this->conn, $sql);
    }

    /**
     * Function that sends a query that updates the student id to the database
     * @return new student id
     */
    public function setStudentId($studentId)
    {
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
    public function setActiveStatus($status)
    {
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
    public function setCohort($cohort)
    {
        $studentId = $this->stud_row["StudentId"];
        $sql = "UPDATE students
			  SET Cohort = '$cohort'
			  WHERE StudentId = '$studentId'";
        mysqli_query($this->conn, $sql);
    }

    /**
     * Return element of the row checked, to be used in a print later
     * @return the FullName of the user from the user row
     */
    public function getFullName()
    {
        return $this->user_row["FirstName"] . " " . $this->user_row["MiddleName"] . " " . $this->user_row["LastName"];
    }

    /**
     * Return element of the row checked, to be used in a print later
     * @return the UserName of the user from the user row
     */
    public function getUserName()
    {
        return $this->user_row["UserName"];
    }

    /**
     * Return element of the row checked, to be used in a print later
     * @return the ContactInfo of the user from the user row
     */
    public function getContactInfo()
    {
        return $this->user_row["ContactInfo"];
    }

    /**
     * Return element of the row checked, to be used in a print later
     * @return the ProgramStatus of the user from the student row
     */
    public function getProgramStatus()
    {
        return $this->stud_row["ProgramStatus"];
    }
	/**
	 * Return which year the cohort the student is in
	 * @return the year the student is in the cohort
	 */
	public function getCohort(){
		return $this->stud_row["Cohort"];
	}
    /**
     * Return element of the row checked, to be used in a print later
     * @return the StreetAddressLineOne of the user from the student row
     */
    public function getStreetAddressLineOne()
    {
        return $this->stud_row["StreetAddressLineOne"];
    }

    /**
     * Return element of the row checked, to be used in a print later
     * @return the StreetAddressLineTwo of the user from the student row
     */
    public function getStreetAddressLineTwo()
    {
        return $this->stud_row["StreetAddressLineTwo"];
    }

    /**
     * Return element of the row checked, to be used in a print later
     * @return the City of the user from the student row
     */
    public function getCity()
    {
        return $this->stud_row["City"];
    }
	
    /**
     * Return element of the row checked, to be used in a print later
     * @return the State of the user from the student row
     */
    public function getState()
    {
        return $this->stud_row["State"];
    }

	/**
	 * Returns a function with the array with notes
	 * @return array with the notes
	 */
	public function getUserNotesArray(){
		return $this->user_notes;
	}
    /**
     * Display Methods here will be used when we need to display and change the messages
     */
    public function displayFullName()
    {
        echo $this->user_row["FirstName"] . " " . $this->user_row["MiddleName"] . " " . $this->user_row["LastName"];
    }

    public function displayUserName()
    {
        echo $this->user_row["UserName"];
    }

    public function displayContactInfo()
    {
        echo $this->user_row["ContactInfo"];
    }

    public function displayProgramStatus()
    {
        echo $this->stud_row["ProgramStatus"];
    }

    public function displayStreetAddressLineOne()
    {
        echo $this->stud_row["StreetAddressLineOne"];
    }

    public function displayStreetAddressLineTwo()
    {
        echo $this->stud_row["StreetAddressLineTwo"];
    }

    public function displayCity()
    {
        echo $this->stud_row["City"];
    }

    public function displayState()
    {
        echo $this->stud_row["State"];
    }

    /**
     * Function that goes through the array to print out the contents of the array of notes
     */
    public function displayUserNotes()
    {
        //checks if there were any notes to display
        if (count($this->user_notes) == 0) {
            return false;
        }
        foreach ($this->user_notes as $user_note) {
            echo $user_note["Note_Type"] . "<br>";
            echo $user_note["Note_Text"] . "<br>";
        }
    }

    /**
     * Method that echos all the data about the student into html from the query results
     */
    public function displayStudDetails()
    {
        echo "StudentID: " . $this->student_id . "<br>";
        echo "UserId: " . $this->userId . "<br>";
        echo "Name: " . $this->user_row["FirstName"] . " " . $this->user_row["MiddleName"] . " " . $this->user_row["LastName"]. "<br>";
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