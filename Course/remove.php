<?php 
session_start();
include('../connectDB.php');

$id = $_POST['id'];
$deleteid = explode(".", $id);

if($deleteid[0] > 0){

  // Check record exists
  //$checkRecord = mysqli_query($dbh,"SELECT * FROM equipment_room INNER JOIN  equipment ON  equipment.ID=equipment_room.ID_equipment WHERE equipment.ID=$deleteid[0] AND ID_rooms=$deleteid[1]");
  //$totalrows = mysqli_num_rows($checkRecord);
  
	$sql="SELECT course_kateuthinsi.ID as id_e_r FROM course_kateuthinsi INNER JOIN  kateuthinsi ON  kateuthinsi.ID=course_kateuthinsi.ID_kat WHERE kateuthinsi.ID=:id_eq AND course_kateuthinsi.ID_course=:id_r AND course_kateuthinsi.ID_department=:id_depart";
	$stmt= $dbh->prepare($sql); 
	$stmt->bindParam(':id_eq',$deleteid[0] ,PDO::PARAM_INT);
	$stmt->bindParam(':id_r',$deleteid[1],PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
	$stmt-> execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$idlast=$row ->id_e_r;	
	
  if($idlast > 0){
    // Delete record
    //$query = "DELETE FROM equipment_room WHERE equipment.ID=$deleteid[0] AND ID_rooms=$deleteid[1]";
    //mysqli_query($dbh,$query);
	$sql = "DELETE FROM course_kateuthinsi WHERE ID=:idlast";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':idlast',$idlast ,PDO::PARAM_INT);
	$stmt->execute();
    echo 1;
    exit;
  }
}

echo 0;
exit;