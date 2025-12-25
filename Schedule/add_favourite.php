 <?php
/*require '../logged.php';*/
session_start();
require  "../connectDB.php";
include '../errorReporting.php';
try {
if (isset ($_POST['MyCourse'])){
	$selected=$_POST['MyCourse'];
	foreach ($selected as $value){
		if (isset($value)){
			$id = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
			$sql="INSERT INTO my_course (ID_user, ID_course)VALUES(:ID_user, :ID_course)";
			$stmt2 = $dbh->prepare($sql);
			$stmt2->bindParam(':ID_user',$_SESSION['user_id'],PDO::PARAM_INT);
			$stmt2->bindParam(':ID_course',$value,PDO::PARAM_INT);
			$stmt2-> execute();
		}
	}
}		
header('Location:calendar_student.php');
 } catch (Exception $e) {
    echo "error on inserting data" .$e;   
}
?>