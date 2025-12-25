<?php
/*require '../logged.php';*/
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';


try {

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
			$sql= "INSERT INTO  month(name) VALUES ('Ιανουάριος'), ('Φεβρουάριος'), ('Μάρτιος'),('Απρίλιος'),('Μάιος'),('Ιούνιος'),('Ιούλιος'),('Αύγουστος'),('Σεπτέμβριος'), ('Οκτώμβριος'),('Νοέμβριος'),('Δεκέμβριος')";
			$dbh->exec($sql);
			echo "New record created successfully";
			}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
	}

?>    