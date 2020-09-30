<?php
//Add beginning code to
//1. Require the needed 3 files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");
verify_login();

new_header("Who's who!");
//2. Connect to your database
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// if(!isset($_SESSION["admin_id"])) {
// 	$_SESSION["message"] = "You must login in first!";
// 	redirect("indexROD.php");  //***********  REPLACE ABC with first 3 letters of your last name
// }

//3. Output a message, if there is one
if (($output = message()) !== null) {
	echo $output;
}
/////////////////////////////////////////////////////////////////////////////////////////
// Step 10.  Kill the session by setting the username and admin_id to null
$_SESSION["username"] = NULL;
$_SESSION["admin"] = NULL;

////////////////////////////////////////////////////////////////////////////////////////


 redirect("indexROD.php");	//*************  REPLACE ABC with first 3 letters of your last name

//Define footer with the phrase "Who's Who"
new_footer("Who's Who");

//Release query results
	//$stmt -> close();

//Close database
Database::dbDisconnect();
 ?>
