<?php
	require_once("session.php");
	require_once("included_functions.php");
	require_once("database.php");
	verify_login();

	new_header("Here is Who's Who!");
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	//****************  Add Query
	//  Query people to select PersonID, FirstName, and LastName, sorting in ascending order by LastName
	$query = "SELECT PersonID, FirstName, LastName from people ORDER BY LastName ASC;";

	//  Prepare and execute query
	$stmt = $mysqli -> prepare($query);
	$stmt -> execute();

/********************    Uncomment Once Code Completed  **************************/
	if ($stmt) {
		echo "<div class='row'>";
		echo "<center>";
		echo "<h2>Here is Who's Who</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th>Name</th><th></th><th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			//Output FirstName and LastName
			echo "<td>".$row['FirstName']." ".$row["LastName"]."</td>";

			//Create an Edit and Delete link
			//Edit should direct to editPeople.php, sending PersonID in URL
			//Delete should direct to deletePeople.php, sending PersonID in URL - include onclick to confirm delete
			echo "<td><a href='editPeople.php?id=".urlencode($row["PersonID"])."'>Edit</a></td>";
			echo "<td><a href='deletePeople.php?id=".urlencode($row["PersonID"])."' onclick='return confirm('Are you sure you want to delete?');'>Delete</a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		echo "<br /><br /><a href='createPeople.php'>Add a person</a> | <a href='addLogin.php'>Add an admin</a> | <a href='logout.php'>Logout</a>";
		echo "</center>";
		echo "</div>";
	}
	new_footer("Who's Who");
	$stmt -> close();
/************       Uncomment Once Code Completed For This Section  ********************/

	Database::dbDisconnect();
 ?>
