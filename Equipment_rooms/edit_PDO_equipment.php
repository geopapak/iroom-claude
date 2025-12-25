<?php
session_start();
include '../connectDB.php';

$get_id=filter_var( $_REQUEST['ID'] , FILTER_SANITIZE_NUMBER_INT);
$name= filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM equipment WHERE name=:name";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->execute();         

$num_get_rows = $stmt->rowCount();

if($num_get_rows >0){
	$_SESSION['editequip']=2;
	header('Location:equipment.php');
}else {
$sql = "UPDATE equipment SET name ='$name' WHERE ID = :get_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
$result=$stmt-> execute();
if ($result){
	$_SESSION['editequip']=1;
	header('Location:equipment.php');
}else{
	echo "Ανεπιτυχης επεξεργασια : ERROR CODE [3000]";
}
}

?>

