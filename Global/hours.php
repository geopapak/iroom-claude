<?php
/*require '../logged.php';*/
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';


try {
$start =filter_var( $_POST['Start_hour'], FILTER_SANITIZE_NUMBER_INT);
$end = filter_var( $_POST['End_hour'], FILTER_SANITIZE_NUMBER_INT);
	
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
$sql= "INSERT INTO  hours (start_hour,end_hour) VALUES  (:start,:end)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':start',$start,PDO::PARAM_INT);
$stmt->bindParam(':end',$end,PDO::PARAM_INT);
$stmt-> execute();
header('location: database.php');
			}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
	}

?>    
