<?php
session_start();
require_once('../connectDB.php');

$get_id=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT user_type FROM users WHERE ID=:ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$get_id,PDO::PARAM_STR);
$stmt->execute();   
$row=$stmt->fetch(PDO::FETCH_OBJ);
$user_type=$row->user_type;

if($user_type=='Καθηγητής'){
	$sql = "DELETE programme_rooms FROM programme_rooms  inner join course_profesor on course_profesor.ID_course=programme_rooms.ID_course where ID_profesor=:ID";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':ID', $get_id, PDO::PARAM_INT);   
	$stmt->execute();
	
	$sql = "DELETE exam_programme_rooms FROM exam_programme_rooms  inner join course_profesor on course_profesor.ID_course=exam_programme_rooms.ID_course where ID_profesor=:ID";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':ID', $get_id, PDO::PARAM_INT);   
	$stmt->execute();	
}

$sql = "DELETE FROM users where ID = :get_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id', $get_id, PDO::PARAM_INT);   
$stmt->execute();


$_SESSION['delete']=0;

if($user_type=='Καθηγητής'){
			header('location:main_user.php');		
}elseif($user_type=='Γραμματεια'){
			header('Location:../Global/gramuser.php');
}else{
			header('location:userstudent.php');		
}
?>