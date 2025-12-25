<?php
session_start();
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';
 
try {
	$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);

	$sql="SELECT * FROM kateuthinsi WHERE name=:name AND ID_department=:id_depart";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
	$stmt->execute();         
	$num_get_rows = $stmt->rowCount();

	if($num_get_rows >0){
		$_SESSION['addcourse']=2;
		header('Location:kateuthinsi.php');
		exit();	
	}else {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql= "INSERT INTO kateuthinsi (name,ID_department) VALUES (:name,:id_depart)"; 
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$res=$stmt-> execute();
		if ($res) {
				$_SESSION['addcourse']=1;
		} else {
				$_SESSION['addcourse']=0;
				echo "Ανεπιτυχής προσθήκη : ERROR CODE [3000]";
		}
echo "<script>window.location='kateuthinsi.php'</script>";
}
} catch (Exception $e) {
    echo "error on inserting data" .$e;   
}

?>    
