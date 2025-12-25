  <?php
 session_start();
/*require '../logged.php';*/
require  "../connectDB.php";
include '../errorReporting.php';

try {
$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
//$kind =filter_var( $_POST['Kind'], FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM rooms inner join room_depart on rooms.ID=room_depart.ID_room WHERE name=:name AND room_depart.ID_departament=:depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
//$stmt->bindParam(':kind',$kind,PDO::PARAM_STR);
$stmt->bindParam(':depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt->execute();         
$num_get_rows = $stmt->rowCount();
if($num_get_rows >0){
	$_SESSION['addroom']=1;
	header('Location:rooms.php');
	exit();
}else {
	$sql = "SELECT * FROM rooms WHERE name=:name";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	//$stmt->bindParam(':kind',$kind,PDO::PARAM_STR);
	$stmt->execute();    
	$num_get_rows1 = $stmt->rowCount();
	if($num_get_rows1==0){
		var_dump("mpike sto 1.1");
   		//die(); 	 
		$sql= "INSERT INTO rooms(name) VALUES (:name)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		//$stmt->bindParam(':kind',$kind,PDO::PARAM_STR);
		$stmt-> execute();
		$last_inserted =$dbh->lastInsertId();

		$sql= "INSERT INTO room_depart(ID_room,ID_departament) VALUES (:room,:depart)";
		$stmt1 = $dbh->prepare($sql);
		$stmt1->bindParam(':room',$last_inserted,PDO::PARAM_STR);
		$stmt1->bindParam(':depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt1-> execute();

		if (isset ($_POST['choosenEquipments'])){
			$selectedEquipments=$_POST['choosenEquipments'];
				foreach ($selectedEquipments as $value){
					if (isset($value)){
						$id_equipment = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
						$sql="SELECT * FROM equipment_room WHERE ID_rooms=:id_rooms AND ID_equipment=:id_equipment AND ID_departament=:id_depart";
						$stmt2 = $dbh->prepare($sql);
						$stmt2->bindParam(':id_rooms',$last_inserted,PDO::PARAM_STR);
						$stmt2->bindParam(':id_equipment',$id_equipment,PDO::PARAM_STR);
						$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						$stmt2-> execute(); 
						$num_get_rows2 = $stmt2->rowCount();
						//var_dump($num_get_rows2);
						//die();
						if($num_get_rows2==0){
							//var_dump($last_inserted,$id_equipment,$_SESSION['user_dp']);
							//die();
							$sql="INSERT INTO equipment_room (ID_rooms,ID_equipment,ID_departament) VALUES (:ID_rooms,:ID_equipment,:id_depart)";
							$stmt = $dbh->prepare($sql);
							$stmt->bindParam(':ID_rooms',$last_inserted,PDO::PARAM_STR);
							$stmt->bindParam(':ID_equipment',$id_equipment,PDO::PARAM_STR);
							$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);	
							$stmt-> execute(); 				
						}
					}
				}
		}
	}else{
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id=$row->ID;
		var_dump("mpike sto 2.1");
	//	var_dump($id);
		//var_dump($id_equipment);
   		//var_dump($_SESSION['user_dp']);

		$sql= "INSERT INTO room_depart(ID_room,ID_departament) VALUES (:room,:depart)";
		$stmt1 = $dbh->prepare($sql);
		$stmt1->bindParam(':room',$id,PDO::PARAM_STR);
		$stmt1->bindParam(':depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt1-> execute();
		var_dump($_POST);
		if (isset ($_POST['choosenEquipments'])){
			$selectedEquipments=$_POST['choosenEquipments'];
				foreach ($selectedEquipments as $value){
					if (isset($value)){
						$id_equipment = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
						var_dump($id_equipment);
						var_dump($id);
						$sql="SELECT * FROM equipment_room WHERE ID_rooms=:id_rooms AND ID_equipment=:id_equipment";
						$stmt2 = $dbh->prepare($sql);
						$stmt2->bindParam(':ID_rooms',$id,PDO::PARAM_STR);
						$stmt2->bindParam(':ID_equipment',$id_equipment,PDO::PARAM_INT);
						$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
						$stmt2-> execute();  
						$num_get_rows2 = $stmt2->rowCount();
						if($num_get_rows2==0){
							$sql="INSERT INTO equipment_room (ID_rooms, ID_equipment,ID_departament)VALUES(:ID_rooms, :ID_equipment,:id_depart)";
							$stmt2 = $dbh->prepare($sql);
							$stmt2->bindParam(':ID_rooms',$id,PDO::PARAM_INT);
							$stmt2->bindParam(':ID_equipment',$id_equipment,PDO::PARAM_INT);
							$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
							$stmt2-> execute();						
						}
					}
				}
		}
	}
}	
   		//die(); 
	$_SESSION['addroom']=0;
	header('Location:rooms.php');
	exit();
 } catch (Exception $e) {
    echo "error on inserting data" .$e;   
}

?>