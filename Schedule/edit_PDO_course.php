<?php
session_start();
include '../connectDB.php';

try{
$get_id=filter_var( $_REQUEST['ID'] , FILTER_SANITIZE_STRING);
$id_hour=substr($get_id,0,-1);
$id_day=substr($get_id,-1);


$sql = "SELECT course.name,programme.ID_user FROM ((course INNER JOIN semester_course ON course.ID=semester_course.ID_course)INNER JOIN programme ON programme.ID_semester_course=semester_course.ID)WHERE ID_day=:id_day AND ID_hour=:id_hour";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$id_day,PDO::PARAM_INT);
$stmt->bindParam(':id_hour',$id_hour,PDO::PARAM_INT);
$stmt->execute();         
while( $row = $stmt->fetch(PDO::FETCH_OBJ) ){
				$name_course[]=$row->name;
				$id_user[]=$row->ID_user;
}

if (isset ($_POST['Course'])){
	$name=$_POST['Course'];
	foreach ($name as $value){
		if (isset($value)){	
			$sql = "SELECT ID FROM course  WHERE name=:name";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':name',$value,PDO::PARAM_INT);
			$stmt->execute();         
			$row = $stmt->fetch(PDO::FETCH_OBJ) ;
			$id_course1=$row->ID;
			
			$sql = "SELECT users.ID FROM users INNER JOIN course_profesor ON users.ID=course_profesor.ID_profesor WHERE ID_course=:id_course";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_course',$id_course1,PDO::PARAM_INT);
			$stmt->execute();         
			$row = $stmt->fetch(PDO::FETCH_OBJ) ;
			$name_course1[]=$value;
			$id_user1[]=$row->ID;
		}
	}
}

for($i=0; $i<sizeof($name_course); $i++){	
	if($name_course[$i]==$name_course1[$i] OR in_array($id_user[$i],$id_user1)){
		var_dump($_SESSION['editcourse']=0);
		//header('Location:calendar.php');
	}else{
		echo "fasfasfsfsf";
		/*$sql = "SELECT ID,name FROM course WHERE name=:name_course";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name_course',$name_course[$i],PDO::PARAM_STR);
		$stmt->execute();     
	    $row = $stmt->fetch(PDO::FETCH_OBJ) ;
		$id_course_old=$row->ID;
		$name_course_old=$row->name;
		
		$sql1 = "SELECT ID,name FROM course WHERE name=:name_course";
		$stmt1 = $dbh->prepare($sql1);
		$stmt1->bindParam(':name_course',$name_course1[$i],PDO::PARAM_STR);
		$stmt1->execute();     
	    $row1= $stmt1->fetch(PDO::FETCH_OBJ) ;
		$id_course_new=$row1->ID;
		$name_course_new=$row1->name;

		$sql8 = "SELECT ID_profesor FROM course_profesor WHERE ID_course=:id_course";
		$stmt8 = $dbh->prepare($sql8);
		$stmt8->bindParam(':id_course',$id_course_old,PDO::PARAM_INT);
		$stmt8->execute();         
		$row8 = $stmt8->fetch(PDO::FETCH_OBJ);
		$id_profesor_old=$row8->ID_profesor;
		
		$sql2 = "SELECT ID_profesor FROM course_profesor WHERE ID_course=:id_course";
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindParam(':id_course',$id_course_new,PDO::PARAM_INT);
		$stmt2->execute();         
		$row2 = $stmt2->fetch(PDO::FETCH_OBJ);
		$id_profesor_new=$row2->ID_profesor;

		$sql9 = "SELECT ID,name FROM users WHERE ID=:id_profesor";
		$stmt9 = $dbh->prepare($sql9);
		$stmt9->bindParam(':id_profesor',$id_profesor_old,PDO::PARAM_INT);
		$stmt9->execute();         
		$row9= $stmt9->fetch(PDO::FETCH_OBJ);
		$id_profesor_old1=$row9->ID;
		$name_profesor_old=$row9->name;
		var_dump($name_profesor_old);
		
		$sql3 = "SELECT ID,name FROM users WHERE ID=:id_profesor";
		$stmt3 = $dbh->prepare($sql3);
		$stmt3->bindParam(':id_profesor',$id_profesor_new,PDO::PARAM_INT);
		$stmt3->execute();         
		$row3= $stmt3->fetch(PDO::FETCH_OBJ);
		$id_profesor_new1=$row3->ID;
		$name_profesor_new=$row3->name;
		var_dump($name_profesor_new);	
		
		
		$sql4 = "SELECT ID FROM semester_course WHERE ID_course=:id_course_old";
		$stmt4 = $dbh->prepare($sql4);
		$stmt4->bindParam(':id_course_old',$id_course_old,PDO::PARAM_INT);
		$stmt4->execute();         
		$row4 = $stmt4->fetch(PDO::FETCH_OBJ);
		$id_semester_course_old=$row4->ID;
	
		$sql5 = "SELECT ID FROM semester_course WHERE ID_course=:id_course_new";
		$stmt5 = $dbh->prepare($sql5);
		$stmt5->bindParam(':id_course_new',$id_course_new,PDO::PARAM_INT);
		$stmt5->execute();         
		$row5 = $stmt5->fetch(PDO::FETCH_OBJ);
		$id_semester_course_new=$row5->ID;

echo("<br>id_course_old=>$id_course_old<br>name_course_old=>$name_course_old<br>id_course_new=>$id_course_new<br>name_course_new=>$name_course_new<br>name_profesor=>$name_profesor<br>id_semester_course_old=>$id_semester_course_old<br>id_semester_course_new=>$id_semester_course_new<br>id_profesor_old=>$id_profesor_old<br>id_profesor_new=>$id_profesor_new"); 

		$sql6 = "SELECT ID,ID_user FROM programme WHERE ID_semester_course=:id_semester_course_old AND ID_user=:id_user AND ID_day= :id_day AND ID_hour=:id_hour";
		$stmt6 = $dbh->prepare($sql6);
		$stmt6->bindParam(':id_semester_course_old',$id_semester_course_old,PDO::PARAM_INT);
		$stmt6->bindParam(':id_user',$id_profesor_old1,PDO::PARAM_INT);
		$stmt6->bindParam(':id_day',$id_day,PDO::PARAM_INT);
		$stmt6->bindParam(':id_hour',$id_hour,PDO::PARAM_INT);
		if($stmt6->execute()){        
			$row6 = $stmt6->fetch(PDO::FETCH_OBJ);
			$id=$row6->ID;
			$id_user=$row6->ID_user;
		}
		var_dump($id_user);
		
		
			var_dump("<br>id_profesor_new1=>",$id_profesor_new1);
			if(($id_semester_course_old==$id_semester_course_new)OR($id_profesor_old1==$id_profesor_new1)){
				echo "<script>alert('back'); window.location='calendar.php'</script>";
			}else{
				$sql7 = "UPDATE programme SET ID_semester_course=:id_semester_course_new, ID_user=:id_profesor  WHERE  ID=:id";
				$stmt7 = $dbh->prepare($sql7);	
				$stmt7->bindParam(':id_semester_course_new',$id_semester_course_new,PDO::PARAM_INT);
				$stmt7->bindParam(':id_profesor',$id_profesor_new1,PDO::PARAM_INT);
				$stmt7->bindParam(':id',$id,PDO::PARAM_INT);
				$stmt7-> execute();
				echo "fasfasfafaf";
			}
		*/
	}
}
	/*if($_SESSION['updatecourse']==1){
	echo "<script>alert('Successfully Edit The Account!'); window.location='calendar.php'</script>";
	}elseif($_SESSION['updatecourse']==2){
	echo "<script>alert('De mporei o idios kathigitis tin idia wra na kanei 2 mathimata'); window.location='calendar.php'</script>";
	}else{
	echo "<script>alert('back'); window.location='calendar.php'</script>";
	}*/
}catch(Exception $e){
	echo "<script>alert('error'); window.location='calendar.php'</script>";
}
/*if ($result){
	$_SESSION['editequip']=1;
	echo "<script>alert('Successfully Edit The Account!'); window.location='equipment.php'</script>";
}else{
	echo "Ανεπιτυχης επεξεργασια : ERROR CODE [3000]";
}
}*/

?>

