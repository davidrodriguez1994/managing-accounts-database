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

  	if (isset($_GET["id"]) && $_GET["id"] !== "") {
//////////////////////////////////////////////////////////////////////////////////////
	  //Prepare and execute a query to DELETE FROM using GET id in criterion - WHERE PersonID = ?
		$query = "DELETE FROM people WHERE PersonID=?;";
	  	$stmt = $mysqli -> prepare($query);
		$stmt -> execute([$_GET["id"]]);



		if ($stmt) {
			//Create SESSION message that Person successfully deleted
			$_SESSION["message"] = "Person has been deleted";


		}
		else {
			//Create SESSION message that Person could not be deleted
			$_SESSION["message"] = "Error! Could not delete ".$_GET["FirstName"]." ".$_GET["LastName"];

		}

		//************** Redirect to readPeople.php
		redirect("readPeople.php");

//////////////////////////////////////////////////////////////////////////////////////
	}
	else {
		$_SESSION["message"] = "Person could not be found!";
		//header("Location: readPeople.php");
		//exit;
		redirect("readPeopleSOLN.php");
	}



//Define footer with the phrase "Who's Who"
	new_footer("Who's Who");

//Release query results
	//$stmt -> close();

//Close database
	Database::dbDisconnect();

?>
