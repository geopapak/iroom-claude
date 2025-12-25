<?php
session_start();
include '../connectDB.php';
include '../Global/email.php';
$get_id=filter_var( $_REQUEST['ID'] , FILTER_SANITIZE_NUMBER_INT);
$name= filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
$last_name= filter_var( $_POST['Lname'], FILTER_SANITIZE_STRING);
$phone= filter_var( $_POST['Phone'], FILTER_SANITIZE_STRING);
$email= filter_var( $_POST['Email'], FILTER_SANITIZE_STRING);
$iddepart= filter_var( $_POST['Depart'], FILTER_SANITIZE_STRING);

//$user_type= filter_var( $_POST['UserType'], FILTER_SANITIZE_STRING);
$sql = "SELECT user_type FROM users WHERE ID=:get_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id',$get_id,PDO::PARAM_STR);
$stmt->execute(); 
$row=$stmt->fetch(PDO::FETCH_OBJ);
$user_type=$row->user_type;

$sql = "SELECT ID,user_type FROM users WHERE email=:email AND ID<>:ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$get_id,PDO::PARAM_STR);
$stmt->bindParam(':email',$email,PDO::PARAM_STR);
$stmt->execute();         

$num_get_rows = $stmt->rowCount();

if($num_get_rows >0){
	$_SESSION['editroom']=2;
	if($user_type=='Καθηγητής'){
		header('Location:main_user.php');
	}elseif($user_type=='Γραμματεια'){
			header('Location:../Global/gramuser.php');
		}else{
		header('Location:userstudent.php');
	}
}else {

	$sql = "UPDATE users SET name =:name, last_name=:last_name,phone=:phone, email=:email, ID_departament=:ID_departament WHERE ID = :get_id";
	$paramas=array(':get_id' =>$get_id);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->bindParam(':last_name',$last_name,PDO::PARAM_STR);
	$stmt->bindParam(':phone',$phone,PDO::PARAM_STR);
	$stmt->bindParam(':email',$email,PDO::PARAM_STR);
	$stmt->bindParam(':ID_departament',$iddepart,PDO::PARAM_STR);
	$stmt->bindParam(':user_type',$user_type,PDO::PARAM_STR);
	$stmt->bindParam(':get_id',$get_id,PDO::PARAM_INT); 
	$result=$stmt-> execute();
if($_POST['Pass'] != null){
	$pass=filter_var( $_POST['Pass'], FILTER_SANITIZE_STRING);
	$password = password_hash($pass, PASSWORD_BCRYPT );
	$sql = "UPDATE password SET pass=:pass WHERE ID_user = :get_id";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':pass',$password,PDO::PARAM_STR);
	$stmt->bindParam(':get_id',$get_id,PDO::PARAM_STR);
	$stmt-> execute();
	$email=sent_email($name,$last_name,$email,$pass);
}
	if ($result){
		$_SESSION['editroom']=1;
		if($user_type=='Καθηγητής'){
			header('Location:main_user.php');
		}elseif($user_type=='Γραμματεια'){
			header('Location:../Global/gramuser.php');
		}else{
			header('Location:userstudent.php');
		}
	}else{
		echo "Ανεπιτυχης επεξεργασια : ERROR CODE [3000]";
	}
}
error_reporting(E_ALL);
//echo "<script>alert('Successfully Edit The Account!'); window.location='main_user.php'</script>";


?>