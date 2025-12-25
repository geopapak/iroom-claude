<?php
if(isset($_POST["subject"])){
include('../connectDB.php');
$id_user= $_SESSION['user_id'];
$dayhour=$_POST['dayhour'];
$subject = $_POST["subject"];
$id_course=$_POST["IDCourse"];
$dt=$_POST['date'];
$sql="SELECT ID_departament FROM users WHERE ID=:id_user";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_departament=$row->ID_departament;
//$id_departament=3;

//die();
if (isset ($_POST["booking"])){
	$id_rooms=implode(", ", array_map('intval', $_POST["booking"]));
}

$sql= "INSERT INTO notification(ID_user ,ID_day_hour ,ID_departament,ID_course,ID_room,subject,status,dt) VALUES (:id_user, :dayhour, :id_departament ,:id_course, :id_booing, :subject,0,:dt )";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
$stmt->bindParam(':dayhour',$dayhour,PDO::PARAM_INT);
$stmt->bindParam(':id_departament',$id_departament,PDO::PARAM_INT);
$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
$stmt->bindParam(':id_booing',$id_rooms,PDO::PARAM_STR);
$stmt->bindParam(':subject',$subject,PDO::PARAM_STR);
$stmt->bindParam(':dt',$dt,PDO::PARAM_STR);
$result=$stmt-> execute();
if($result){
	$_SESSION['noti']="Έχει σταλθεί στην γραμματεία";
}else{
	$_SESSION['noti']="Δεν έχει σταλθεί στην γραμματεία";
}
//var_dump($_POST);
//die();
 echo "<script>window.location='calendar_profesor.php'</script>";
}
?>