#!/usr/bin/env php
<?php
include('connectDB.php');
chdir("/home/ece00614/public_html");

$pc_date=Date("Y-m-d");
$sql="SELECT * FROM notification";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	$ID_user=$row->ID_user;
	$ID_day_hour=$row->ID_day_hour;
	$ID_departament=$row->ID_departament;
	$ID_course=$row->ID_course;
	$ID_room=$row->ID_room;
	$dt=$row->dt;
	$id_hour=substr($ID_day_hour,0,-1);
	$id_day=substr($ID_day_hour,-1);
	$int_hour=(int)$id_hour;
	$int_day=(int)$id_day;
	if($pc_date>$dt){
			$sql = "DELETE programme FROM programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID WHERE  ID_day =:id_day AND ID_hour =:id_hour AND ID_course=:ID_course AND ID_departament=:id_depart";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
			$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
			$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_STR);
			$stmt->bindParam(':id_depart',$ID_departament,PDO::PARAM_INT);
			$res=$stmt->execute();

			$sql = "DELETE programme_rooms FROM programme_rooms WHERE  ID_day_hour =:id_day_hour AND ID_course=:id_course AND ID_departament=:id_depart";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_day_hour',$ID_day_hour,PDO::PARAM_INT);
			$stmt->bindParam(':id_course',$ID_course,PDO::PARAM_STR);
			$stmt->bindParam(':id_depart',$ID_departament,PDO::PARAM_INT);
			$res1=$stmt->execute();
	}	
}
if($res and $res1){
$a=($res and $res1);
var_dump($a);
	die();
}
	
echo "executing....";
?>
