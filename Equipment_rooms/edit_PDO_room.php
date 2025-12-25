<?php
session_start();
include '../connectDB.php';

$get_id=filter_var( $_REQUEST['ID'] , FILTER_SANITIZE_NUMBER_INT);
$name= filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
//$kind= filter_var( $_POST['Kind'], FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM rooms inner join room_depart on rooms.ID=room_depart.ID_room WHERE name=:name AND rooms.ID<>:id AND room_depart.ID_departament=:depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id',$get_id,PDO::PARAM_STR);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
//$stmt->bindParam(':kind',$kind,PDO::PARAM_STR);
$stmt->bindParam(':depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt->execute();

$num_get_rows = $stmt->rowCount();

if($num_get_rows >0){
	$_SESSION['editroom']=2;
	header('location:rooms.php');
	exit();
}else{
	$sql = "SELECT * FROM rooms WHERE name=:name";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	//$stmt->bindParam(':kind',$kind,PDO::PARAM_STR);
	$stmt->execute(); 
	$num_get_rows1 = $stmt->rowCount();
	if($num_get_rows1==0){
		//var_dump("mpike 1.1");
		//die();
		$sql= "INSERT INTO rooms(name) VALUES (:name)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		//$stmt->bindParam(':kind',$kind,PDO::PARAM_STR);
		$stmt-> execute();
		$last_inserted =$dbh->lastInsertId();
		$sql = "SELECT * FROM room_depart WHERE ID_departament=:id_depart AND ID_room=:id_room";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_room',$get_id,PDO::PARAM_STR);
		$stmt->execute(); 	
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id_r_d=$row->ID;

		$sql = "UPDATE room_depart SET ID_departament=:id_depart, ID_room=:id_room WHERE ID=:id_r_d";
		$paramas=array(':get_id' =>$get_id);
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_r_d',$id_r_d,PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_room',$last_inserted,PDO::PARAM_INT); 
		$result=$stmt-> execute();

		$sql = "UPDATE programme_rooms SET ID_room=:id_room WHERE ID_departament=:id_depart AND ID_room=:get_id";
		$paramas=array(':get_id' =>$get_id);
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_room',$last_inserted,PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR); 
		$stmt->bindParam(':get_id',$get_id,PDO::PARAM_STR); 
		$result=$stmt-> execute();

		$table_equip=array();
		$sql = "SELECT * FROM equipment_room where ID_rooms = :id AND ID_departament=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$get_id,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				$id_equip=$row -> ID_equipment;	
				$sql2="SELECT * FROM equipment";
				$stmt2= $dbh->prepare($sql2); 
				$stmt2-> execute();
				for($i=0; $row1 = $stmt2 ->fetch(PDO::FETCH_OBJ); $i++){
					$id_equip2=$row1 -> ID;
					$name_equip= $row1 -> name;
					if($id_equip2==$id_equip){
						$table_equip[$i]=$id_equip2;
					}
				}
			}
		if (isset ($table_equip)){
			$selectedEquipments=$table_equip;
			foreach ($selectedEquipments as $value){
				if (isset($value)){
					$id_equipment = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
					$sql="UPDATE equipment_room  SET ID_rooms=:id_room WHERE ID_rooms=:get_id AND ID_equipment=:id_equipment AND ID_departament=:id_depart";
					$stmt = $dbh->prepare($sql);
					$stmt->bindParam(':id_room',$last_inserted,PDO::PARAM_STR);
					$stmt->bindParam(':id_equipment',$id_equipment,PDO::PARAM_STR);
					$stmt->bindParam(':get_id',$get_id,PDO::PARAM_STR);
					$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
					$stmt-> execute();
				} 
			}
		}				 
			var_dump($table_equip);
			//die();
		if (isset ($_POST['choosenEquipments1'])){
			$selectedEquipments=$_POST['choosenEquipments1'];
			foreach ($selectedEquipments as $value){
				if (isset($value)){
					$id_equipment = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);		
						$sql="INSERT INTO equipment_room (ID_rooms, ID_equipment,ID_departament)VALUES(:ID_rooms, :ID_equipment,:id_depart)";
						$stmt = $dbh->prepare($sql);
						$stmt->bindParam(':ID_rooms',$last_inserted,PDO::PARAM_STR);
						$stmt->bindParam(':ID_equipment',$id_equipment,PDO::PARAM_STR);
						$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						$stmt-> execute();
				}
			}
		}
	}else{
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id=$row->ID;
		$sql = "SELECT * FROM room_depart WHERE ID_departament=:id_depart AND ID_room=:id_room";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_room',$get_id,PDO::PARAM_STR);
		$stmt->execute(); 	
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id_r_d=$row->ID;

		$sql = "UPDATE room_depart SET ID_departament=:id_depart, ID_room=:id_room WHERE ID=:id_r_d";
		$paramas=array(':get_id' =>$get_id);
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_r_d',$id_r_d,PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_room',$id,PDO::PARAM_INT); 
		$result=$stmt-> execute();

		if (isset ($_POST['choosenEquipments1'])){
			$selectedEquipments=$_POST['choosenEquipments1'];
			foreach ($selectedEquipments as $value){
				if (isset($value)){
					$id_equipment = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);				
						$sql="INSERT INTO equipment_room (ID_rooms, ID_equipment,ID_departament)VALUES(:ID_rooms, :ID_equipment,:id_depart)";
						$stmt = $dbh->prepare($sql);
						$stmt->bindParam(':ID_rooms',$id,PDO::PARAM_INT);
						$stmt->bindParam(':ID_equipment',$id_equipment,PDO::PARAM_INT);
						$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						$stmt-> execute();
				}
			}
		}		
		$sql = "UPDATE programme_rooms SET ID_room=:id_room WHERE ID_departament=:id_depart AND ID_room=:get_id";
		$paramas=array(':get_id' =>$get_id);
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_room',$last_inserted,PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR); 
		$stmt->bindParam(':get_id',$get_id,PDO::PARAM_STR); 
		$result=$stmt-> execute();
	}

}
$_SESSION['editroom']=1;
header('location:rooms.php');
?>