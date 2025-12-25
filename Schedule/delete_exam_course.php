<?php
session_start();
require_once('../connectDB.php');
$get_id=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);
$pieces = explode(".", $_GET['ID']);
$id_hour=$pieces[0];
$id_day=$pieces[1];
$int_hour=(int)$id_hour;
$int_day=(int)$id_day;
if (isset ($_POST['delete_course'])){
	$id=$_POST['delete_course'];
	foreach ($id as $value){
		if (isset($value)){	
			$sql = "DELETE exam_programme FROM exam_programme INNER JOIN semester_course ON exam_programme.ID_semester_course=semester_course.ID WHERE  ID_day =:id_day AND ID_hour =:id_hour AND ID_course=:id";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
			$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
			$stmt->bindParam(':id',$value,PDO::PARAM_STR);
			$stmt->execute();
			
			$sql = "DELETE exam_programme_rooms FROM exam_programme_rooms WHERE  ID_day_hour =:id_day_hour AND ID_course=:id";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_day_hour',$get_id,PDO::PARAM_INT);
			$stmt->bindParam(':id',$value,PDO::PARAM_STR);
			$stmt->execute();
		}
	}
}
$_SESSION['delete']=0;
header('location:exam_calendar.php');
?>