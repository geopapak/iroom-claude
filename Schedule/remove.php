<?php 
include('../connectDB.php');
$deleteid = $_POST['id'];
if($deleteid > 0){
  // Check record exists
  //$checkRecord = mysqli_query($dbh,"SELECT * FROM equipment_room INNER JOIN  equipment ON  equipment.ID=equipment_room.ID_equipment WHERE equipment.ID=$deleteid[0] AND ID_rooms=$deleteid[1]");
  //$totalrows = mysqli_num_rows($checkRecord);
  
	$sql="SELECT * FROM my_course WHERE ID=:id";
	$stmt= $dbh->prepare($sql); 
	$stmt->bindParam(':id',$deleteid ,PDO::PARAM_INT);
	$stmt-> execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$idlast=$row -> ID;	
	
  if($idlast > 0){
    // Delete record
    //$query = "DELETE FROM equipment_room WHERE equipment.ID=$deleteid[0] AND ID_rooms=$deleteid[1]";
    //mysqli_query($dbh,$query);
	$sql = "DELETE FROM my_course WHERE ID=:idlast";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':idlast',$idlast ,PDO::PARAM_INT); 
	$stmt->execute();
    echo 1;
    exit;
  }
}
echo 0;
exit;