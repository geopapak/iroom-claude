<?php
session_start();
require_once('../connectDB.php');

try{
$get_id=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);
$sql="SELECT ID_course,ID_day_hour FROM programme_rooms WHERE ID_room=:get_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
$stmt-> execute();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){	
$id_day_hour=$row->ID_day_hour;
$id_course=$row->ID_course;

$id_hour=substr($id_day_hour,0,-1);
$id_day=substr($id_day_hour,-1);
$int_hour=(int)$id_hour;
$int_day=(int)$id_day;
var_dump($int_hour,"<br>",$int_day);
$sql1 = "DELETE programme FROM ((programme INNER JOIN semester_course ON semester_course.ID=programme.ID_semester_course) INNER JOIN course ON course.ID=semester_course.ID_course) WHERE course.ID=:id_course AND programme.ID_day=:id_day AND programme.ID_hour=:id_hour AND programme.ID_departament=:id_depart";
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':id_course', $id_course, PDO::PARAM_INT); 
$stmt1->bindParam(':id_day',$int_day,PDO::PARAM_INT);
$stmt1->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);  
$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt1->execute();
$sql1 = "DELETE FROM programme_rooms where ID_room=:get_id";
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':get_id', $get_id, PDO::PARAM_INT); 
$stmt1->execute();
}
$sql = "DELETE FROM room_depart where ID_room = :get_id AND ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id', $get_id, PDO::PARAM_INT);   
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt->execute();

$sql = "DELETE FROM equipment_room where ID_rooms = :get_id AND ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id', $get_id, PDO::PARAM_INT);   
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt->execute();

$_SESSION['deleteroom']=1;
header('location:rooms.php');
}catch (Exception $e) {
    echo "error on inserting data" .$e;   
}

?>