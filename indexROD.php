<?php
//Add beginning code to
//1. Require the needed 3 files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

//2. Connect to your database
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//3. Output a message, if there is one
if (($output = message()) !== null) {
	echo $output;
}

new_header("Who's who!");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//     Step 7.  Check whether username and password have been submitted from the index form. Verify the values are not empty
//				Some of this code may be borrowed from addLogin.php
if(isset($_POST['submit'])){
	if( (isset($_POST["username"]) && $_POST["username"] !== "") && (isset($_POST["password"]) && $_POST["password"] !== "")){

	    //Grab posted values for username and password.
		//IMPORTANT CHANGE:  Unlike in addLogin.php, you will NOT encrypt password
		//Once we check if the username exists, we will do the encryption in
		//the function password_check, which returns true if the passwords match
		$username = $_POST['username'];
		$password = $_POST['password'];


		//Check to make sure user does already exist
		$query = "SELECT * FROM admins WHERE username=? LIMIT 1";
		$stmt = $mysqli->prepare($query);
		$stmt->execute([$_POST['username']]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//NOTE:  This part differs from addLogin.php
		//Username found so now check password
		//If the attempted password matches the database password then set two $_SESSION variables
		//$_SESSION["username"]  & $_SESSION[admin_id"]
		//Redirect to readPeople.php
		if($row > 1){
			if ($stmt) {


				if(password_check($_POST["password"], $row["hashed_password"])){
					$_SESSION["username"] = $username;
					$_SESSION["admin"] = $row["id"];
					redirect("readPeople.php");
				}
				else{
					$_SESSION["message"] = "Username/Password could not be found";
					redirect("indexROD.php");
				}
			}

			//If the attempted password DOES NOT match the database password, create a session
			//message -> "Username/Password could not be found"
			//Redirect to indexABC.php   where ABC are the first 3 letters of your last name

		}
		else {

			$_SESSION["message"] = "Username/Password could not be found";
			redirect("indexROD.php");

		}
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////

?>

		<div class='row'>
		<label for='left-label' class='left inline'>

		<h3>Welcome!</h3>

<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->
<!--    Step 6. Create textboxes for Login -->
<!--            Note:  you can copy and paste from addLogin.php.  Just be sure to change -->
<!--                   action = "addLogin.php"    to action = "indexABC.php"  where ABC are the first 3 letters of your last name -->

	<form action="indexROD.php" method="POST">
		<p>Username:<input type="text" name="username" value="" /></p>
		<p>Password:<input type="password" name="password" value="" /></p>
		<input type="submit" name="submit" class="button tiny round" value="Login"/>
	</form>





<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->

	</div>
	</label>

<?php
//Define footer with the phrase "Who's Who"
new_footer("Who's Who");

//Release query results
	//$stmt -> close();

//Close database
Database::dbDisconnect();


 ?>
