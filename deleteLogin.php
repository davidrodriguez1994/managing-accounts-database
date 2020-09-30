<?php
//Add beginning code to
//1. Require the needed 3 files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");
verify_login();

//2. Connect to your database
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
	echo $output;
}

new_header("Delete from Who's who!");

///////////////////////////////////////////////////////////////////////////////////
//  Step 9  -  invoke verify_login
//			   Will redirect to indexABC.php if there is not a SESSION admin_id set
//             NOTE:  REPLACE ABC with the first 3 letters of your last name


///////////////////////////////////////////////////////////////////////////////////

//3. Output a message, if there is one
	if (($output = message()) !== null) {
		echo $output;
	}
///////////////////////////////////////////////////////////////////////////////////
// Step 5.  Get this admins ID and delete from the database
if (isset($_GET["id"]) && $_GET["id"] !== ""){

	// Execute query and create a session message
	$query = "DELETE FROM admins WHERE id=?;";
	$stmt = $mysqli -> prepare($query);
	$stmt -> execute([$_GET["id"]]);

	// If successful (i.e., $stmt is true), output "Successfully deleted user"
	if ($stmt) {
		$_SESSION["message"] = "Person has been deleted";
		redirect("addLogin.php");
	}

	// If unsuccessful, output "Unable to delete user"
	else {
		//Create SESSION message that Person could not be deleted
		$_SESSION["message"] = "Error! Could not delete ".$_GET["FirstName"];
		redirect("addLogin.php");
	}
//////////////////////////////////////////////////////////////////////////////////



}

//Define footer with the phrase "Who's Who"
new_footer("Who's Who");

//Release query results
	//$stmt -> close();

//Close database
Database::dbDisconnect();
?>
