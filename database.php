<?php
class Database {
  private static $mysqli = null;

  public function __construct() {
    die('Init function error');
  }

  public static function dbConnect() {
	//try connecting to your database
	require_once("/home/drodrig1/DBRodriguez.php");

	//catch a potential error, if unable to connect
try{
   $mysqli=new PDO('mysql:host='.DBHOST.';dbname='.DBNAME,USERNAME,PASSWORD);
   echo "Connection Successful";
 }catch(PDOException $error){
   echo "Connection Lost";
 }

    return $mysqli;
  }

  public static function dbDisconnect() {
    $mysqli = null;
  }
}
?>
