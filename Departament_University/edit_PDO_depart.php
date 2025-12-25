<?php
session_start();
include '../connectDB.php';
$get_id=filter_var( $_REQUEST['ID'] , FILTER_SANITIZE_NUMBER_INT);
$admin_sem=filter_var( $_POST['sem_admin'] , FILTER_SANITIZE_NUMBER_INT);
var_dump($admin_sem);
$sql = "SELECT university.ID as iduni,departament.ID as iddep,university.name as uni,departament.name as depart,departament.sso_depart as sso FROM university INNER JOIN departament ON university.ID=departament.ID_university WHERE university.ID= :ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$get_id,PDO::PARAM_STR);
$stmt->execute();         

$num_get_rows = $stmt->rowCount();
	$uniname=$_POST['uni'];
	$sql = "UPDATE university SET name =:name WHERE ID = :get_id ";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':get_id',$get_id,PDO::PARAM_STR);
	$stmt->bindParam(':name',$_POST['uni'],PDO::PARAM_STR);
	$result=$stmt-> execute(); 

	
	if (isset ($_POST['table_id'])){
		$table_id=$_POST['table_id'];
		$table_sso=$_POST['table_sso'];
		$table_sem=$_POST['table_sem'];
		foreach ($table_id as $index => $table_id){
			$sql = "UPDATE departament SET name =:name,sso_depart =:sso WHERE ID = :get_id ";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':get_id',$index,PDO::PARAM_STR);
			$stmt->bindParam(':name',$table_id,PDO::PARAM_STR);
			$stmt->bindParam(':sso',$table_sso[$index],PDO::PARAM_INT);
			$result=$stmt-> execute();

			$sql1 = "UPDATE admin_sem SET ID_sem =:ID_sem WHERE ID_department = :get_id ";
			$stmt1 = $dbh->prepare($sql1);
			$stmt1->bindParam(':get_id',$index,PDO::PARAM_STR);
			$stmt1->bindParam(':ID_sem',$table_sem[$index],PDO::PARAM_STR);
			$result=$stmt1-> execute();			 
		}
	}
	header('Location:university.php');
/*}
if ($result){
	$_SESSION['edituni']=1;
	echo "<script>alert('Successfully Edit The Account!'); window.location='university.php'</script>";
}else{
	echo "Ανεπιτυχης επεξεργασια : ERROR CODE [3000]";
}*/

?>
