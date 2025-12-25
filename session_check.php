<?php

if ( isset($_SESSION["valuepid"]) )
{
	require_once('connectDB.php');
	$sql="SELECT * FROM  users WHERE sso_id=:user_id";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':user_id',$_SESSION["valuepid"],PDO::PARAM_INT);
	$stmt-> execute();
	$row=$stmt->fetch(PDO::FETCH_OBJ);
	$id=$row->ID;
	$name = $row->name;
	$lname=$row->last_name;
	$user_dp=$row->ID_departament;
	$_SESSION['user_id']=$id;
	$_SESSION['name']=$name;
	$_SESSION['lname']=$lname;
	$_SESSION['user_dp']=$user_dp;
}elseif (isset($_POST['Username'])){
	require_once ('connectDB.php');
	session_start();  
	$sql1 = "SELECT * FROM admin WHERE email=:name and pass=:pass";
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindParam(':name',$_POST['Username'],PDO::PARAM_STR);
	$stmt1->bindParam(':pass',$_POST['Password'],PDO::PARAM_STR);
	$stmt1->execute();         
	$row1 = $stmt1->fetch(PDO::FETCH_OBJ);
	if($stmt1->rowCount()>0){
	$user_id=$row1->ID;
	$user_level=$row1->user_type;
	if($user_level=="Διαχειριστής"){
		$_SESSION['user_id']=$row1->ID;
		$_SESSION['name']=$row1->name;
		$_SESSION['lname']=$row1->last_name;
		$_SESSION['user_level']=$row1->user_type;
		header('location: Global/database.php');
		exit();
	}
	}
	$sql = "SELECT * FROM users WHERE email=:name";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$_POST['Username'],PDO::PARAM_STR);
	$stmt->execute();         
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	if($stmt) { die("ERROR in user login");}
	$user_id=$row->ID;
	$user_dp=$row->ID_departament;
	$user_level=$row->user_type;
	$name=$row->name;
	$sql = "SELECT * FROM password WHERE ID_user=:user_id";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':user_id',$user_id,PDO::PARAM_STR);
	$stmt->execute(); 
	$row1 = $stmt->fetch(PDO::FETCH_OBJ);
	$pass=$row1->pass;

	if (password_verify($_POST['Password'],$pass)) {
		$_SESSION['name']=$name;
		$_SESSION['lname']=$row->last_name;
		$_SESSION['user_id']=$user_id;
		$_SESSION['user_dp']=$user_dp;
		$_SESSION['user_level']=$user_level;
		 if($user_level=='Καθηγητής'){
			header('location: Schedule/calendar_profesor.php');
		}elseif($user_level=='Γραμματεια'){
			$sql = "SELECT * FROM hours ";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();         
			$count=$stmt->rowCount();
				
			$sql = "SELECT * FROM days ";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();         
			$count1=$stmt->rowCount();
				if($count>0 and $count1>0){	
					header('location: Schedule/calendar.php');
				}else{
				echo "Δεν έχουν δημιουργηθεί ημέρες και ώρες λειτουργίας!! Παρακαλώ επικοινωνήστε με τον διαχειριστεί";
				}
		}elseif($user_level=='Φοιτητης'){
				header('location: Schedule/calendar_student.php');
		}else {
	var_dump($user_level);
	die();
				header('location: login.php');	
		}
	}else{
		header('location: login.php');
	}
}
?>
