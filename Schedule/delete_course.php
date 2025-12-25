<?php
session_start();
require_once('../connectDB.php');
$get_id=filter_var( $_GET['ID'] , FILTER_SANITIZE_STRING);
$pieces = explode(".", $get_id);
$id_hour=$pieces[0];
$id_day=$pieces[1];
//$id_hour=substr($get_id,0,-1);
$int_hour=(int)$id_hour;
//$id_day=substr($get_id,-1);
$int_day=(int)$id_day;

$iddayhour=(int)$int_hour.$int_day;
var_dump($get_id);
var_dump($int_day);
var_dump($int_hour);
var_dump($iddayhour);
var_dump($_SESSION);
var_dump($_POST['delete_course']);
die();
if (isset ($_POST['delete_course'])){
	$id=$_POST['delete_course'];
	foreach ($id as $value){
		if (isset($value)){	
			$sql = "DELETE programme FROM programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID WHERE  ID_day =:id_day AND ID_hour =:id_hour AND ID_course=:id AND ID_departament=:id_depart";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
			$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
			$stmt->bindParam(':id',$value,PDO::PARAM_STR);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
			$res=$stmt->execute();

			$sql = "DELETE programme_rooms FROM programme_rooms WHERE  ID_day_hour =:id_day_hour AND ID_course=:id AND ID_departament=:id_depart";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_day_hour',$iddayhour,PDO::PARAM_INT);
			$stmt->bindParam(':id',$value,PDO::PARAM_STR);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
			$res2=$stmt->execute();
		}
	}
}
$a= ($res and $res2);
var_dump($a);
//die();
if($res and $res2){
	//die();
}
$_SESSION['delete']=0;
header('location:calendar.php');
?>