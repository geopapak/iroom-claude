<?php
/*require '../logged.php';*/
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';


try {

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
			$sql= "INSERT INTO  days(name) VALUES ('Δευτέρα'), ('Τρίτη'),  ('Τετάρτη'),('Πέμπτη'),('Παρασκευή')";
			$dbh->exec($sql);
			header('location: database.php');
			}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
	}

?>    
