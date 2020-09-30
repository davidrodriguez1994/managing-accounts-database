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

	echo "<h3>Update to Who's who!</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
///////////////////////////////////////////////////////////////////////////////////////////
		//Step 2.
		//Create an UPDATE query using anonymous parameters and the criterion WHERE PersonID = ?
		$query = "UPDATE people SET FirstName=?, LastName=?, Birthdate=?, BirthCity=?, BirthState=?, Region=? WHERE PersonID=?";


		//Prepare and execute query (use $_POST values from submitted form)
		$stmt = $mysqli -> prepare($query);
		$stmt -> execute([$_POST["FirstName"], $_POST["LastName"], $_POST["Birthdate"], $_POST["BirthCity"], $_POST["BirthState"], $_POST["Region"], $_POST["PersonID"]]);

		//Verify $stmt executed - create a SESSION message
		if($stmt){
			$_SESSION["message"] =  $_POST['FirstName']. " ".$_POST['LastName']. " has been updated!";
		}

		//Redirect back to readPeople.php
		redirect("readPeople.php");

///////////////////////////////////////////////////////////////////////////////////////////

		//Output query results and return to readPeople.php

		if($stmt) {
			$_SESSION["message"] = $_POST["FirstName"]." ".$_POST["LastName"]." has been changed";
			//echo $_POST['FirstName']." ".$_POST['LastName']." has been changed<br />";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["FirstName"]." ".$_POST["LastName"];
			//echo "Error! Could not change ".$_POST['FirstName']." ".$_POST['LastName']."<br />";
		}


	}
	else {
///////////////////////////////////////////////////////////////////////////////////////////
	  //Step 1.
	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
	  //Prepare and execute a query to SELECT * using GET id in criterion - WHERE PersonID = ?
		$query = "SELECT * FROM people WHERE PersonID=?;";
	  	$stmt = $mysqli -> prepare($query);
		$stmt -> execute([$_GET["id"]]);


		//Verify statement successfully executed - I assume that results are returned to variable $stmt
		if ($stmt)  {
			//Fetch associative array from executed prepared statement
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			//Output whose profile we are updating
			//UNCOMMENT ONCE YOU'VE COMPLETED THE FILE
			echo "<h3>".$row["FirstName"]." ".$row["LastName"]."'s Profile</h3>";
			echo '<form method="POST" action="editPeople.php">';
			echo '<input type="hidden" name="PersonID" value='.$_GET["id"].'/>';
			echo '<p>First Name: <br><input type="text" name="FirstName" value='.$row["FirstName"].'></p>';
			echo '<p>Last Name: <br><input type="text" name="LastName" value='.$row["LastName"].'></p>';
			echo '<p>Birthdate (YYYY-MM-DD): <br><input type="text" name="Birthdate" value='.$row["Birthdate"].'></p>';
			echo '<p>Birth City: <br><input type="text" name="BirthCity" value='.$row["BirthCity"].'></p>';
			echo '<p>Birth State: <br><input type="text" name="BirthState" value='.$row["BirthState"].'></p>';
			echo '<p>Region <br><input type="text" name="Region" value='.$row["Region"].'></p>';


			//Create form with inputs for each field in people table, pre-populating the values
			//DON'T FORGET your submit button - use class attribute (i.e., class='button tiny round')
			echo '<input type="submit" name="submit" class="button tiny round" value="Change" />';
			echo '</form>';





///////////////////////////////////////////////////////////////////////////////////////////

			echo "<br /><p>&laquo:<a href='readPeople.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";


		}
		//Query failed. Return to readPeople.php and output error
		else {
			$_SESSION["message"] = "Person could not be found!";
			redirect("readPeople.php");
		}
	  }
    }

//Define footer with the phrase "Who's Who"
	new_footer("Who's Who");

//Release query results
	//$stmt -> close();

//Close database
	Database::dbDisconnect();
?>
