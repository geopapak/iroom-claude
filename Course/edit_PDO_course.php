<?php
session_start();
include '../connectDB.php';

$get_id=filter_var( $_REQUEST['ID'] , FILTER_SANITIZE_NUMBER_INT);
$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
$year = filter_var( $_POST['Year'], FILTER_SANITIZE_NUMBER_INT);
$code= filter_var( $_POST['Code'], FILTER_SANITIZE_STRING);
$id_sem=filter_var( $_POST['Semester'], FILTER_SANITIZE_STRING);
$id_user=filter_var( $_POST['IDUser'], FILTER_SANITIZE_STRING);
//var_dump($_REQUEST['ID']);
//var_dump($_POST);

$sql = "SELECT * FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.name=:name AND course.code=:code AND course_depart.ID_departament=:id_depart AND course.ID<>:ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$get_id,PDO::PARAM_STR);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':code',$code,PDO::PARAM_STR);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt->execute();         
$num_get_rows = $stmt->rowCount();
//var_dump($num_get_rows);
if(isset($_POST['optional'])){
	if($_POST['optional']==1){	
		$optional="yes";
	}else{
		$optional="no";
	}
}
if($num_get_rows >0){
	$_SESSION['editcoursename']=2;
	header('Location:course.php');
	exit();
}else {
	$sql = "SELECT * FROM course WHERE name=:name AND code=:code AND optional=:optional";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->bindParam(':code',$code,PDO::PARAM_STR);
	$stmt->bindParam(':optional',$optional,PDO::PARAM_STR);
	$stmt->execute(); 
	$num_get_rows1 = $stmt->rowCount();
	if($num_get_rows1==0){
//		var_dump("mpike 1.1");
		$sql= "INSERT INTO course (name,year,code,optional)VALUES (:name,:year,:code,:optional)"; 
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		$stmt->bindParam(':year',$year,PDO::PARAM_INT);
		$stmt->bindParam(':code',$code,PDO::PARAM_STR);
		$stmt->bindParam(':optional',$optional,PDO::PARAM_STR);
		$stmt-> execute();	

		$last_inserted =$dbh->lastInsertId();

		$sql = "SELECT * FROM course_depart WHERE ID_departament=:id_depart AND ID_course=:id_course";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_course',$get_id,PDO::PARAM_STR);
		$stmt->execute(); 	
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id_r_d=$row->ID;	

		$sql = "UPDATE course_depart SET ID_departament=:id_depart,ID_course=:id_course WHERE ID=:id_r_d";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_course',$last_inserted,PDO::PARAM_STR);
		$stmt->bindParam(':id_r_d',$id_r_d,PDO::PARAM_INT);
		$result=$stmt-> execute();

		$sql = "UPDATE programme_rooms SET ID_course=:id_course WHERE ID_course=:id_cour AND ID_departament=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_course',$last_inserted,PDO::PARAM_STR);
		$stmt->bindParam(':id_cour',$get_id,PDO::PARAM_STR);
		$result=$stmt-> execute();



		$table_equip=array();
		$sql = "SELECT * FROM course_kateuthinsi where ID_course = :id AND ID_department=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$get_id,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				$id_equip=$row -> ID_kat;	
				$sql2="SELECT * FROM kateuthinsi";
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
					$ID_kat = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
					$sql="UPDATE course_kateuthinsi  SET ID_course=:id_room WHERE ID_course=:get_id AND ID_kat=:ID_kat AND ID_department=:id_depart";
					$stmt = $dbh->prepare($sql);
					$stmt->bindParam(':id_room',$last_inserted,PDO::PARAM_STR);
					$stmt->bindParam(':ID_kat',$ID_kat,PDO::PARAM_STR);
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
					$ID_kat = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);		
						$sql="INSERT INTO course_kateuthinsi (ID_course, ID_kat,ID_department)VALUES(:ID_course, :ID_kat,:id_depart)";
						$stmt = $dbh->prepare($sql);
						$stmt->bindParam(':ID_course',$last_inserted,PDO::PARAM_STR);
						$stmt->bindParam(':ID_kat',$ID_kat,PDO::PARAM_STR);
						$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						$stmt-> execute();
				}
			}
		}
		
	}else{
//		var_dump("mpike 2.2");
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id=$row->ID;		
		$sql = "SELECT * FROM course_depart WHERE ID_departament=:id_depart AND ID_course=:id_course";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_course',$get_id,PDO::PARAM_STR);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id_r_d=$row->ID;
		$sql = "UPDATE course_depart SET ID_departament=:id_depart,ID_course=:id_course WHERE ID=:id_r_d";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_course',$id,PDO::PARAM_STR);
		$stmt->bindParam(':id_r_d',$id_r_d,PDO::PARAM_INT);
		$result=$stmt-> execute();	
		if (isset ($_POST['choosenEquipments1'])){
			$selectedEquipments=$_POST['choosenEquipments1'];
			foreach ($selectedEquipments as $value){
				if (isset($value)){
					$id_equipment = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);				
						$sql="INSERT INTO course_kateuthinsi (ID_course, ID_kat,ID_department)VALUES(:ID_rooms, :ID_equipment,:id_depart)";
						$stmt = $dbh->prepare($sql);
						$stmt->bindParam(':ID_rooms',$id,PDO::PARAM_INT);
						$stmt->bindParam(':ID_equipment',$id_equipment,PDO::PARAM_INT);
						$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						$stmt-> execute();
				}
			}
		}		
		$sql = "UPDATE programme_rooms SET ID_course=:id_course WHERE ID_course=:id_cour AND ID_departament=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt->bindParam(':id_course',$id,PDO::PARAM_STR);
		$stmt->bindParam(':id_cour',$get_id,PDO::PARAM_STR);
		$result=$stmt-> execute();
	}
	$_SESSION['editcoursename']=1;
}
if(isset($last_inserted)){
	$ID_course=$last_inserted;
}else{
	$ID_course=$id;
}
//var_dump($ID_course);
$sql = "UPDATE semester_course SET ID_semester=:ID_semester, ID_course=:ID_course WHERE ID_course=:get_id AND ID_depart=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
$stmt->bindParam(':ID_semester',$id_sem,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$result1=$stmt -> execute();

	/*if(isset($_POST['Semester1'])){
		$sql ="SELECT ID FROM semester WHERE name= :semester";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':semester',$_POST['Semester1'],PDO::PARAM_STR);
		$stmt-> execute();
		$row=$stmt ->fetch(PDO::FETCH_OBJ);
		$ID_semester= $row -> ID;
		$sql ="SELECT ID FROM semester_course WHERE ID_course=:ID_course AND ID_semester=:ID_semester AND ID_depart=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
		$stmt->bindParam(':ID_semester',$ID_semester,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt-> execute();
		$num=$stmt->rowCount();
		if($num==0){
			$sql = "UPDATE semester_course SET ID_semester=:ID_semester, ID_course=:ID_course WHERE ID_course=:get_id AND ID_depart=:id_depart AND ID_semester<>:ID_sem";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
			$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
			$stmt->bindParam(':ID_semester',$ID_semester,PDO::PARAM_INT);
			$stmt->bindParam(':ID_sem',$id_sem,PDO::PARAM_INT);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
			$result1=$stmt -> execute();
		}
	} */

$sql = "SELECT ID FROM course_profesor WHERE ID_course=:get_id AND ID_depart=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$result2=$stmt -> execute();
$num_get_rows = $stmt->rowCount();
if($num_get_rows ==0){
	$sql= "INSERT INTO course_profesor(ID_course,ID_profesor,ID_depart) VALUES (:ID_course, :ID_profesor, :ID_depart)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
	$stmt->bindParam(':ID_profesor',$id_user,PDO::PARAM_INT);
	$stmt->bindParam(':ID_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
	$stmt-> execute();
	$_SESSION['editcourseprofesor']=1;
}else{
	$sql = "UPDATE course_profesor SET ID_profesor=:ID_user,ID_course=:ID_course WHERE ID_course=:get_id AND ID_depart=:id_depart";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
	$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
	$stmt->bindParam(':ID_user',$id_user,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
	$result2=$stmt -> execute();
}


/*
if (isset ($_POST['choosenType'])){
	$selectedType=$_POST['choosenType'];
	foreach ($selectedType as $value){
		if (isset($value)){
			$id_type = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
			$sql="UPDATE type_of_course  SET ID_course=:get_id, ID_type=:id_type WHERE ID_course=:get_id AND ID_type=:id_type";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_type',$id_type,PDO::PARAM_INT);
			$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT);
			$stmt-> execute();
		} 
	}
}

if (isset ($_POST['choosenType1'])){
	$selectedType=$_POST['choosenType1'];
	foreach ($selectedType as $value){
		if (isset($value)){
			echo $value;
			$id_type = filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
			$sql="INSERT INTO type_of_course (ID_course, ID_type)VALUES(:ID_course, :ID_type)";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':ID_course',$get_id,PDO::PARAM_INT);
			$stmt->bindParam(':ID_type',$id_type,PDO::PARAM_INT);
			$stmt-> execute();
		}
	}
}*/
//$_SESSION['editcourse']=1;
//die();
header('Location:course.php');
?>

