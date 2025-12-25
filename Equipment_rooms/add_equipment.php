<?php
session_start();
include '../errorReporting.php';
ini_set('display_errors',1);
require  "../connectDB.php";

try{
$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM equipment INNER JOIN equipment_depart ON equipment.ID=equipment_depart.ID_equipment WHERE name=:name AND equipment_depart.ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt->execute();         
$num_get_rows = $stmt->rowCount();

if($num_get_rows >0){
	$_SESSION['addeqip']=1;
	header('Location:equipment.php');
	exit();
}else{
	$sql = "SELECT * FROM equipment WHERE name=:name";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->execute(); 
	$row=$stmt->fetch(PDO::FETCH_OBJ);
	$id=$row->ID;
	$num_get_rows1 = $stmt->rowCount();
	if($num_get_rows1==0){   
		$sql= "INSERT INTO equipment(name) VALUES (:name)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		$stmt-> execute();
		$last_inserted =  $dbh->lastInsertId();
		$sql= "INSERT INTO equipment_depart (ID_equipment,ID_departament) VALUES (:id_equipment,:id_departament)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_equipment',$last_inserted,PDO::PARAM_STR);
		$stmt->bindParam(':id_departament',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt-> execute();
	}else{
		$sql= "INSERT INTO equipment_depart (ID_equipment,ID_departament) VALUES (:id_equipment,:id_departament)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_equipment',$id,PDO::PARAM_STR);
		$stmt->bindParam(':id_departament',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt-> execute();		
	}
	
if($stmt){
	$_SESSION['addeqip']=0;
	header('Location:equipment.php');
}
}
	} catch (Exception $e) {
    echo "error on inserting data" .$e;   
}
?>