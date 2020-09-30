<?php
//Add beginning code to
//1. Require the needed 3 files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");
verify_login();

new_header("Here is Who's Who!");
//2. Connect to your database
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//3. Output a message, if there is one
if (($output = message()) !== null) {
	echo $output;
}

	echo "<h3>Add to Who's who!</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["FirstName"]) && $_POST["FirstName"] !== "") && (isset($_POST["LastName"]) && $_POST["LastName"] !== "") &&(isset($_POST["Birthdate"]) && $_POST["Birthdate"] !== "") &&(isset($_POST["BirthCity"]) && $_POST["BirthCity"] !== "") &&(isset($_POST["BirthState"]) && $_POST["BirthState"] !== "") &&(isset($_POST["Region"]) && $_POST["Region"] !== "") ) {
//////////////////////////////////////////////////////////////////////////////////////////////////
					//STEP 2.
					//Create and prepare query to insert information that has been posted
			$query = "INSERT INTO people(FirstName, LastName, Birthdate, BirthCity, BirthState, Region) VALUES (?, ?, ?, ?, ?, ?)";

					// Execute query
			$stmt = $mysqli -> prepare($query);
			$stmt -> execute([$_POST["FirstName"], $_POST["LastName"], $_POST["Birthdate"], $_POST["BirthCity"], $_POST["BirthState"], $_POST["Region"]]);

					//Verify $stmt executed - create a SESSION message
			if($stmt){
				$_SESSION["message"] =  $_POST['FirstName']. " ".$_POST['LastName']. " has been added!";
			}
					//Redirect back to readPeople.php
			redirect("readPeople.php");

//////////////////////////////////////////////////////////////////////////////////////////////////


		}
		else {
				$_SESSION["message"] = "Unable to add person. Fill in all information!";
				redirect("addPeople.php");
		}
	}
	else {
//////////////////////////////////////////////////////////////////////////////////////////////////
		// STEP 1.  Create a form that will post to this page: createPeople.php
		echo '<form method="POST" action="createPeople.php">';

		//Include <input> tags for each of the attributes in person:
		//First Name, Last Name, Birthdate, Birth City, Birth State, Region
		echo '<p>First Name: <br><input type="text" name="FirstName"></p>';
		echo '<p>Last Name: <br><input type="text" name="LastName"></p>';
		echo '<p>Birthdate (YYYY-MM-DD): <br><input type="text" name="Birthdate"></p>';
		echo '<p>Birth City: <br><input type="text" name="BirthCity"></p>';
		echo '<p>Birth State: <br><input type="text" name="BirthState"></p>';
		echo '<p>Region <br><input type="text" name="Region"></p>';

		//Finally, add a submit button - include the class 'tiny round button'
		echo '<input type="submit" name="submit" class="button tiny round" value="Add a person" />';
		echo '</form>';

//////////////////////////////////////////////////////////////////////////////////////////////////

	}
	echo "</label>";
	echo "</div>";
	echo "<br /><p>&laquo:<a href='readPeople.php'>Back to Main Page</a>";
	?>


<?php
//Define footer with the phrase "Who's Who"
	new_footer("Who's Who");

//Release query results
	//$stmt -> close();
//Close database
	Database::dbDisconnect();


 ?>
