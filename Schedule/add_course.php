<?php
 session_start();
//f(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Γραμματεια'){
include '../errorReporting.php';
ini_set('display_errors',1);
require  "../connectDB.php";
try{
if(isset($_GET['ID'])AND isset($_GET['IDroom'])AND isset($_GET['IDuser'])AND isset($_GET['IDdayhour'])AND  isset($_GET['IDdepart'])AND  isset($_GET['IDcourse']))	{


$ID=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);
$IDroom=filter_var( $_GET['IDroom'] , FILTER_SANITIZE_NUMBER_INT);
$IDuser=filter_var( $_GET['IDuser'] , FILTER_SANITIZE_NUMBER_INT);
$IDdayhour=filter_var( $_GET['IDdayhour'] , FILTER_SANITIZE_NUMBER_INT);
$IDdepart=filter_var( $_GET['IDdepart'] , FILTER_SANITIZE_NUMBER_INT);
$IDcourse=filter_var( $_GET['IDcourse'] , FILTER_SANITIZE_NUMBER_INT);

$id_hour=substr($IDdayhour,0,-1);
$id_day=substr($IDdayhour,-1);
$int_hour=(int)$id_hour;
$int_day=(int)$id_day;

$sql = "UPDATE notification SET status = 1 WHERE status=0 AND ID=:id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id',$ID,PDO::PARAM_INT);
$stmt-> execute();

		$year= date('Y');
		$sql="SELECT ID FROM schedules WHERE name=:year";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':year',$year,PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		$id_year=$row->ID;
		var_dump($int_day,$int_hour,$IDuser,$_SESSION['user_dp']);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$sql="SELECT ID FROM programme WHERE ID_day=:id_day AND ID_hour=:id_hour AND ID_semester_course=:id_sc AND ID_user=:id_user";
		$sql="SELECT ID FROM programme WHERE ID_day=:id_day AND ID_hour=:id_hour AND ID_user=:id_user AND ID_departament=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
		$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
		$stmt->bindParam(':id_user',$_GET['IDuser'],PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
		$resurlt=$stmt->execute();
		$count=$stmt->rowCount();

		$sql="SELECT semester_course.ID,semester_course.ID_semester as sem FROM ((semester_course INNER JOIN course ON semester_course.ID_course=course.ID )INNER JOIN semester ON semester.ID=semester_course.ID_semester)WHERE course.ID=:id_course AND semester_course.ID_depart=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_course',$IDcourse,PDO::PARAM_STR);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		$id_sc=$row->ID;
		$id_sem=$row->sem;

$sql="SELECT optional FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.ID=:id_course AND course_depart.ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_course',$IDcourse,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$optional=$row->optional;

if($optional=="no"){
	$sql="SELECT programme.ID as id, semester_course.ID_semester as id_sem,ID_course FROM programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID WHERE ID_day=:id_day AND ID_semester_course<>:id_seme AND ID_hour=:id_hour AND semester_course.ID_depart=:id_depart";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
	$stmt->bindParam(':id_seme',$id_sc,PDO::PARAM_INT);
	$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt->execute();
	$count1=$stmt->rowCount();
	if($count1>0){
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$idc[]=$row->ID_course;
			$id_sem1[]=$row->id_sem;
		}
		if(isset($idc)){
			foreach ($idc as $key => $value) {
				$sql="SELECT * FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.ID=:id_course AND course_depart.ID_departament=:id_depart";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':id_course',$value,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$optional=$row->optional;
				if($optional=='yes'){
					$sql="SELECT semester_course.ID_course,semester_course.ID_semester as sem FROM ((semester_course INNER JOIN course ON semester_course.ID_course=course.ID )INNER JOIN semester ON semester.ID=semester_course.ID_semester)WHERE course.ID=:id_course AND semester_course.ID_depart=:id_depart";
					$stmt = $dbh->prepare($sql);
					$stmt->bindParam(':id_course',$value,PDO::PARAM_STR);
					$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_OBJ);
					$id_op[]=$row->ID_course;
					$sem_op[]=$row->sem;
				}else{
					$id_op[]='';
					$sem_op[]='';
				}
			}
		}
		$result=array_intersect($idc,$id_op);
		$result1=array_intersect($id_sem1,$sem_op);
		if(in_array($id_sem, $result1)){
			$id_sem2=0;
		}else{
			if(in_array($id_sem, $id_sem1)){
				$id_sem2=$id_sem;
			}
		}
	}else{
		$id_sem2=0;
	}
}else{
	$id_sem2=0;
}

	$sql="SELECT programme_rooms.ID_course FROM programme_rooms  WHERE ID_day_hour=:id_day_hour AND ID_departament=:id_depart ";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_day_hour',$IDdayhour,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt->execute();
	if($stmt->rowCount()>0){
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$idcp[]=$row->ID_course;
		}
		if(isset($idcp)){
			foreach ($idcp as $key => $value) {
				$sql="SELECT ID_kat FROM course_kateuthinsi  WHERE ID_course=:value AND ID_department=:id_depart";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':value',$value,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt->execute();
				if($stmt->rowCount()>0){
					while($row = $stmt->fetch(PDO::FETCH_OBJ)){
						$id_kat[]=$row->ID_kat;
					}
				}
			}
		}
				$sql="SELECT ID_kat FROM course_kateuthinsi  WHERE ID_course=:value AND ID_department=:id_depart";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':value',$IDcourse,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt->execute();
				if($stmt->rowCount()>0){
					while($row = $stmt->fetch(PDO::FETCH_OBJ)){
						$id_kat1[]=$row->ID_kat;
					}
				$result=array_intersect($id_kat,$id_kat1);
				if(count($result)>0){
					$id_sem2=$id_sem;
				}else{
					$id_sem2=0;
				}
				}

		
	var_dump($idcp);
	var_dump($id_kat);
	var_dump($id_kat1);
	var_dump($result);
	var_dump("afaffasfasfasfasfasfasfasfasffasfafasfasfasfsf");
	var_dump($id_sem2);
	//die();
	}
	var_dump($count);
	var_dump($id_sem);
	var_dump($id_sem2);
	var_dump($count1);

	if($count>0 OR $id_sem==$id_sem2){
		$_SESSION['editcourse']=0;
		header('Location:calendar.php');
		exit();
	}else{
		$sql= "INSERT INTO programme(ID_semester_course,ID_day,ID_hour,ID_user,ID_schedule,ID_departament ) VALUES (:id_sc, :id_day, :id_hour, :id_profesor, :year,:id_depart)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_sc',$id_sc,PDO::PARAM_INT);
		$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
		$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
		$stmt->bindParam(':id_profesor',$IDuser,PDO::PARAM_INT);
		$stmt->bindParam(':year',$id_year,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
		$stmt-> execute();

		/*$sql = "DELETE FROM notification WHERE ID=:id ";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$_GET['ID'],PDO::PARAM_INT);
		$stmt-> execute();*/
	}
$id_rooms=explode(", ", $IDroom);
foreach($id_rooms as $value){
	$sql="SELECT ID FROM programme_rooms WHERE ID_room=:id_room AND ID_day_hour=:id_day_hour";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_room',$value,PDO::PARAM_INT);
	$stmt->bindParam(':id_day_hour',$IDdayhour,PDO::PARAM_INT);
	$stmt->execute();

	if($stmt->rowCount()>0){
		$_SESSION['editcourse']=0;
		header('Location:calendar.php');
		exit();
	}else{
		$active="active";
		$sql= "INSERT INTO programme_rooms(ID_day_hour,ID_room,ID_course,active,ID_departament) VALUES (:id_day_hour,:id_room,:id_course,:active,:id_depart)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_day_hour',$IDdayhour,PDO::PARAM_INT);
		$stmt->bindParam(':active',$active,PDO::PARAM_STR);
		$stmt->bindParam(':id_room',$value,PDO::PARAM_INT);
		$stmt->bindParam(':id_course',$IDcourse,PDO::PARAM_INT);
		$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
		$result=$stmt-> execute();
	}
}

$_SESSION['editcourse']=1;
		header('Location:calendar.php');
		exit();
}else{


if(isset($_POST['day']) AND isset($_POST['hour'])){
	$id_hour=filter_var( $_POST['hour'] , FILTER_SANITIZE_NUMBER_INT);
	$id_day=filter_var( $_POST['day'] , FILTER_SANITIZE_NUMBER_INT);
	$int_hour=(int)$id_hour;
	$int_day=(int)$id_day;
	$ID=(int)$int_hour.$int_day;
}else{
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ID=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);
	$pieces = explode(".", $_GET['ID']);
	$id_hour=$pieces[0];
	$id_day=$pieces[1];
	$int_hour=(int)$id_hour;
	$int_day=(int)$id_day;
}

$course=filter_var( $_POST['IDCourse'] , FILTER_SANITIZE_NUMBER_INT);
$id_course=(int)$course;
var_dump("$id_course");
//die();
$sql="SELECT ID_profesor FROM course_profesor WHERE  ID_course=:id_course";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_course',$id_course,PDO::PARAM_STR);
$stmt->execute();
$num=$stmt->rowCount();
var_dump($num);
if($num>0){
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_profesor=$row->ID_profesor;
}else{
	$_SESSION['prof']=1;
header('Location:calendar.php');	
}
$year= date('Y');
$sql="SELECT ID FROM schedules WHERE name=:year";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':year',$year,PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_year=$row->ID;
$sql="SELECT semester_course.ID,semester_course.ID_semester as sem FROM ((semester_course INNER JOIN course ON semester_course.ID_course=course.ID )INNER JOIN semester ON semester.ID=semester_course.ID_semester)WHERE course.ID=:id_course AND semester_course.ID_depart=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_course',$id_course,PDO::PARAM_STR);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_sc=$row->ID;
$id_sem=$row->sem;
$sql="SELECT ID FROM programme WHERE ID_day=:id_day AND ID_hour=:id_hour AND ID_user=:id_user AND ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
$stmt->bindParam(':id_user',$id_profesor,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->execute();
$count2=$stmt->rowCount();

$sql="SELECT optional FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.ID=:id_course AND course_depart.ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$optional=$row->optional;

$sql="SELECT * FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.ID=:id_course AND course_depart.ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$optional=$row->optional;

$sql="SELECT * FROM course inner join course_kateuthinsi on course.ID=course_kateuthinsi.ID_course WHERE course.ID=:id_course AND course_kateuthinsi.ID_department=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->execute();


if($optional=="no"){
	$sql="SELECT programme.ID as id, semester_course.ID_semester as id_sem,ID_course FROM programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID WHERE ID_day=:id_day AND ID_semester_course<>:id_seme AND ID_hour=:id_hour AND semester_course.ID_depart=:id_depart";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
	$stmt->bindParam(':id_seme',$id_sc,PDO::PARAM_INT);
	$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt->execute();
	$count1=$stmt->rowCount();
	if($count1>0){
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$idc[]=$row->ID_course;
			$id_sem1[]=$row->id_sem;
		}
		if(isset($idc)){
			foreach ($idc as $key => $value) {
				$sql="SELECT * FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.ID=:id_course AND course_depart.ID_departament=:id_depart";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':id_course',$value,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$optional=$row->optional;
				if($optional=='yes'){
					$sql="SELECT semester_course.ID_course,semester_course.ID_semester as sem FROM ((semester_course INNER JOIN course ON semester_course.ID_course=course.ID )INNER JOIN semester ON semester.ID=semester_course.ID_semester)WHERE course.ID=:id_course AND semester_course.ID_depart=:id_depart";
					$stmt = $dbh->prepare($sql);
					$stmt->bindParam(':id_course',$value,PDO::PARAM_STR);
					$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_OBJ);
					$id_op[]=$row->ID_course;
					$sem_op[]=$row->sem;
				}
			}
		}
		$result=array_intersect($idc,$id_op);
		$result1=array_intersect($id_sem1,$sem_op);
		//var_dump($idc,$id_sem1);
		//print_r("<br>");
		//var_dump($id_op,$sem_op);
		//print_r("<br>");
		//print_r($result);
		//print_r("<br>");
		//print_r($result1);
		if(in_array($id_sem, $result1)){
			//var_dump("<br>");
			//var_dump("prepei na mpei");
			$id_sem2=0;
		}else{
			if(in_array($id_sem, $id_sem1)){
				$id_sem2=$id_sem;
			}
		}
		//die();
	}else{
		$id_sem2=0;
	}
}else{
	$id_sem2=0;
}
//if(isset($id_sem1)){
//	if(in_array($id_sem, $id_sem1)){
//		$id_sem2=$id_sem;
//	}
//}

	$sql="SELECT programme_rooms.ID_course FROM programme_rooms  WHERE ID_day_hour=:id_day_hour AND ID_departament=:id_depart ";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_day_hour',$ID,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt->execute();
	if($stmt->rowCount()>0){
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$idcp[]=$row->ID_course;
		}
		if(isset($idcp)){
			foreach ($idcp as $key => $value) {
				$sql="SELECT ID_kat FROM course_kateuthinsi  WHERE ID_course=:value AND ID_department=:id_depart";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':value',$value,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt->execute();
				if($stmt->rowCount()>0){
					while($row = $stmt->fetch(PDO::FETCH_OBJ)){
						$id_kat[]=$row->ID_kat;
					}
				}
			}
		}
				$sql="SELECT ID_kat FROM course_kateuthinsi  WHERE ID_course=:value AND ID_department=:id_depart";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':value',$id_course,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt->execute();
				if($stmt->rowCount()>0){
					while($row = $stmt->fetch(PDO::FETCH_OBJ)){
						$id_kat1[]=$row->ID_kat;
					}
				$result=array_intersect($id_kat,$id_kat1);
				if(count($result)>0){
					$id_sem2=$id_sem;
				}else{
					$id_sem2=0;
				}
				}

		
	var_dump($idcp);
	var_dump($id_kat);
	var_dump($id_kat1);
	var_dump($result);
	var_dump("afaffasfasfasfasfasfasfasfasffasfafasfasfasfsf");
	var_dump($id_sem2);
	//die();
	}
if (isset ($_POST['Room'])){
	$selectedrooms=$_POST['Room'];
	foreach ($selectedrooms as $value){
		if (isset($value)){
			$id_room= filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
			$sql1="SELECT ID FROM programme_rooms WHERE ID_room=:id_room AND ID_day_hour=:id_day_hour";
			$stmt1 = $dbh->prepare($sql1);
			$stmt1->bindParam(':id_room',$id_room,PDO::PARAM_INT);
			$stmt1->bindParam(':id_day_hour',$ID,PDO::PARAM_INT);
			//$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR); AND ID_departament=:id_depart
			$stmt1->execute();
		}
	}
	$count=$stmt1->rowCount();
}
//var_dump($id_sem,$id_sem2);
//var_dump("<br>");
//$a=($count2>0 OR $count>0  OR $id_sem==$id_sem2);
//var_dump($a);
//die();
if(isset($_POST['flag']) and $_POST['flag']==1){
	$sql= "INSERT INTO programme(ID_semester_course,ID_day,ID_hour,ID_user,ID_schedule,ID_departament ) VALUES (:id_sc, :id_day, :id_hour, :id_profesor, :year,:id_depart)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_sc',$id_sc,PDO::PARAM_INT);
	$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
	$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
	$stmt->bindParam(':id_profesor',$id_profesor,PDO::PARAM_INT);
	$stmt->bindParam(':year',$id_year,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$result=$stmt-> execute();

	if (isset ($_POST['Room'])){
		$selectedrooms=$_POST['Room'];
		foreach ($selectedrooms as $value){
			if (isset($value)){
				$id_room= filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
				$active="active";
				$sql= "INSERT INTO programme_rooms(ID_day_hour,ID_room,ID_course,active,ID_departament) VALUES (:id,:id_room,:id_course,:active,:id_depart)";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':id',$ID,PDO::PARAM_INT);
				$stmt->bindParam(':active',$active,PDO::PARAM_STR);
				$stmt->bindParam(':id_room',$id_room,PDO::PARAM_INT);
				$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
				$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
				$stmt-> execute();
			}
		}
	}	
	if($result){
		$_SESSION['exist']=1;
		header('Location:calendar.php');
		exit();		
	}
}elseif($count2>0 OR $count>0  OR $id_sem==$id_sem2){
	if($count2>0){
		$_SESSION['exist']=10;
		header('Location:calendar.php');
		exit();
	}elseif($count>0){
		$_SESSION['exist']=11;
		header('Location:calendar.php');
		exit();
	}else{
		$_SESSION['exist']=12;
		header('Location:calendar.php');
		exit();
	}
	//var_dump($count2,$count,$id_sem,$id_sem1);
	//var_dump($_SESSION['exist']);
	//die();
}else{
	$sql= "INSERT INTO programme(ID_semester_course,ID_day,ID_hour,ID_user,ID_schedule,ID_departament ) VALUES (:id_sc, :id_day, :id_hour, :id_profesor, :year,:id_depart)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id_sc',$id_sc,PDO::PARAM_INT);
	$stmt->bindParam(':id_day',$int_day,PDO::PARAM_INT);
	$stmt->bindParam(':id_hour',$int_hour,PDO::PARAM_INT);
	$stmt->bindParam(':id_profesor',$id_profesor,PDO::PARAM_INT);
	$stmt->bindParam(':year',$id_year,PDO::PARAM_INT);
	$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
	$stmt-> execute();

if (isset ($_POST['Room'])){
	$selectedrooms=$_POST['Room'];
	foreach ($selectedrooms as $value){
		if (isset($value)){
			$id_room= filter_var( $value, FILTER_SANITIZE_NUMBER_INT);
			$active="active";
			$sql= "INSERT INTO programme_rooms(ID_day_hour,ID_room,ID_course,active,ID_departament) VALUES (:id,:id_room,:id_course,:active,:id_depart)";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id',$ID,PDO::PARAM_INT);
			$stmt->bindParam(':active',$active,PDO::PARAM_STR);
			$stmt->bindParam(':id_room',$id_room,PDO::PARAM_INT);
			$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
			$stmt-> execute();
		}
	}
}

		$_SESSION['exist']=1;
		header('Location:calendar.php');
		exit();
}
}
} catch (Exception $e) {
    echo "error on inserting data" .$e;
	}
/*}else{
		header('Location:calendar.php');
		exit();
}*/
?>