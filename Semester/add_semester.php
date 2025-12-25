<?php
/*require '../logged.php';*/
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';


try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql= "INSERT INTO semester(name) VALUES (:name)";
    $stmt = $dbh->prepare($sql,array());
    
	$semester =filter_var( $_POST['Semester'], FILTER_SANITIZE_STRING);
	
	echo "<br>$semester<br>";

	if ($stmt -> execute(array(':name'=>$semester))){
	echo "<script>alert('insert successfully')</script>";
}else{
	echo "ddsfsfsfsdfsadasgsadgadsgas";
}
    /*if ($ret) {
	$_SESSION['insert_course']=1;
    	header("location: pagingHint.php");
    } else {
	$_SESSION['iinsert_course']=0;
     	echo "error on inserting new hint ERROR CODE:[1500] ";
    }*/
   header('location:semester.php');

} catch (Exception $e) {
    echo "error on inserting data" .$e;   
}

?>    
