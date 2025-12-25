<?php
session_start();
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';
 
try {
	$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
	$year = filter_var( $_POST['Year'], FILTER_SANITIZE_STRING);
	$id_user = filter_var( $_POST['IDUser'], FILTER_SANITIZE_NUMBER_INT);
	$code= filter_var( $_POST['Code'], FILTER_SANITIZE_STRING);
    $semester=filter_var( $_POST['Semester'], FILTER_SANITIZE_STRING);
    $kat =filter_var_array ( $_POST['kat'], FILTER_SANITIZE_NUMBER_INT);

	if($_POST['optional']==1){
		$optional="yes";
	}else{
		$optional="no";
	}
	$sql="SELECT * FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE (course.name=:name OR course.code=:code) AND optional=:optional AND course_depart.ID_departament=:id_depart";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->bindParam(':code',$code,PDO::PARAM_STR);
	$stmt->bindParam(':optional',$optional,PDO::PARAM_STR);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt->execute();         
	$num_get_rows = $stmt->rowCount();

if($num_get_rows >0){
	$_SESSION['addcourse']=2;
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
		$sql= "INSERT INTO course (name,year,code,optional)VALUES (:name,:year,:code,:optional)"; 
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		$stmt->bindParam(':year',$year,PDO::PARAM_INT);
		$stmt->bindParam(':code',$code,PDO::PARAM_STR);
		$stmt->bindParam(':optional',$optional,PDO::PARAM_STR);
		//$stmt-> execute();
		if($stmt-> execute()){
			$_SESSION['addcourse']=1;
		}
		$last_inserted =$dbh->lastInsertId();

		$sql= "INSERT INTO course_depart(ID_course,ID_departament) VALUES (:course,:depart)";
		$stmt1 = $dbh->prepare($sql);
		$stmt1->bindParam(':course',$last_inserted,PDO::PARAM_STR);
		$stmt1->bindParam(':depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt1-> execute();

		if (isset ($kat)){
			$id_kat=$kat;
			foreach ($id_kat as $value){
				if (isset($value)){
					$sql="INSERT INTO  course_kateuthinsi(ID_course, ID_kat, ID_department)VALUES(:ID_course, :ID_kat, :id_depart)";
					$stmt2 = $dbh->prepare($sql);
					$stmt2->bindParam(':ID_course',$last_inserted,PDO::PARAM_INT);
					$stmt2->bindParam(':ID_kat',$value,PDO::PARAM_INT);
					$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
					$stmt2-> execute();
				}
			}
		}

	}else{
		$row=$stmt->fetch(PDO::FETCH_OBJ);
		$id=$row->ID;
		$sql= "INSERT INTO course_depart(ID_course,ID_departament) VALUES (:course,:depart)";
		$stmt1 = $dbh->prepare($sql);
		$stmt1->bindParam(':course',$id,PDO::PARAM_STR);
		$stmt1->bindParam(':depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$stmt1-> execute();		
	}
	/*if ($stmt) {
		$_SESSION['addcourse']=1;
	} else {
		$_SESSION['addcourse']=0;
		echo "Ανεπιτυχής προσθήκη : ERROR CODE [3000]";
	}*/

	/*$sql ="SELECT ID FROM course WHERE name=:name and code=:code";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->bindParam(':code',$code,PDO::PARAM_STR);
	$stmt-> execute();
	$row=$stmt ->fetch(PDO::FETCH_OBJ);
	$ID_course= $row -> ID;*/
	if(isset($last_inserted)){
		$ID_course=$last_inserted;
	}else{
		$ID_course=$id;
	}
	$sql ="SELECT ID FROM semester WHERE name= :semester";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':semester',$semester,PDO::PARAM_STR);
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
		$sql = "INSERT INTO semester_course (ID_course, ID_semester,ID_depart) VALUES (:ID_course,:ID_semester,:id_depart)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
		$stmt->bindParam(':ID_semester',$ID_semester,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
		$stmt -> execute();
	}
	if(isset($_POST['Semester1'])){
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
			$sql = "INSERT INTO semester_course (ID_course, ID_semester,ID_depart) VALUES (:ID_course,:ID_semester,:id_depart)";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
			$stmt->bindParam(':ID_semester',$ID_semester,PDO::PARAM_INT);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
			$stmt -> execute();
		}
	}
	$sql ="SELECT ID FROM course_profesor WHERE ID_course=:ID_course AND ID_profesor=:ID_profesor AND ID_depart=:id_depart";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
	$stmt->bindParam(':ID_profesor',$id_user,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt-> execute();
	$num=$stmt->rowCount();
	if($num==0){
		$sql = "INSERT INTO course_profesor (ID_course, ID_profesor,ID_depart) VALUES (:ID_course,:ID_user,:id_depart)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':ID_course',$ID_course,PDO::PARAM_INT);
		$stmt->bindParam(':ID_user',$id_user,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
		$stmt -> execute();
	}
	header('Location:course.php');
}
} catch (Exception $e) {
    echo "error on inserting data" .$e;   
}

?>    
