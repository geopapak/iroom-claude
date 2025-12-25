<?php
include '../errorReporting.php';
ini_set('display_errors',1);
require  "../connectDB.php";

try{
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$uni_name=filter_var( $_POST['UniName'], FILTER_SANITIZE_STRING);
$sem_admin=filter_var( $_POST['sem_admin'], FILTER_SANITIZE_STRING);
$code=filter_var( $_POST['Code'], FILTER_SANITIZE_STRING);

$x= $dbh->prepare("SELECT ID FROM university WHERE name= :name");
$result = $x-> execute(array(':name' => "$uni_name"));
$row=($x ->fetch(PDO::FETCH_OBJ));
$ID= $row -> ID;

 $sql= "INSERT INTO departament (name, ID_university,sso_depart) VALUES (:name, :ID_university,:sso_depart)";
 $stmt = $dbh->prepare($sql,array());
    
$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
$res=$stmt -> execute(array(':name'=>$name ,':ID_university'=>$ID,'sso_depart'=>$code));

$last=$dbh->lastInsertId();

 $sql= "INSERT INTO admin_sem (ID_department, ID_sem) VALUES (:ID_department, :ID_sem)";
 $stmt = $dbh->prepare($sql,array());
 $res1=$stmt -> execute(array(':ID_department'=>$last ,':ID_sem'=>$sem_admin));

if ($res){
	header('Location:university.php');
}else{
	header('Location:university.php');
}
}catch(PDOException $e){
	die('Connection error:' . $e->getmessage()); 
}
?>