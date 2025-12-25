<?php
/*require '../logged.php';*/
require  '../connectDB.php'; 
ini_set('display_errors',1);
include '../errorReporting.php';
include '../Global/email.php';
session_start();

try {
	$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
	$last_name = filter_var( $_POST['LastName'], FILTER_SANITIZE_STRING);
	$phone= filter_var( $_POST['Phone'], FILTER_SANITIZE_NUMBER_INT);
    $email=filter_var( $_POST['Email'], FILTER_SANITIZE_STRING);
	$user_type=filter_var( $_POST['UserType'], FILTER_SANITIZE_STRING);
	$sso="";
	//$departament=filter_var( $_POST['Departament'], FILTER_SANITIZE_STRING);
	$sql = "SELECT * FROM users WHERE email=:email";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':email',$_POST['Email'],PDO::PARAM_STR);
	$stmt->execute();     
	$num_get_rows = $stmt->rowCount();
	if($num_get_rows>0){
		$_SESSION['add']=1;
			if($user_type=='Καθηγητής'){
				header('location:main_user.php');
						exit();		
			}elseif($user_type=='Γραμματεια'){
				header('location:../Global/gramuser.php');
						exit();	
			}else{
				header('location:userstudent.php');	
						exit();	
			}
	}else{
		$sql ="SELECT ID FROM departament WHERE  name= :depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':depart',$_POST['Departament'],PDO::PARAM_STR);
		$result=$stmt-> execute();
		$row=($stmt ->fetch(PDO::FETCH_OBJ));
	 	//$ID_departament= $row -> ID;
	 	if($_SESSION['user_dp']== null){
				$ID_departament= $row -> ID;
	 	}else{
	 		$ID_departament=$_SESSION['user_dp'];
	 	}
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     	$sql= "INSERT INTO users(name, last_name,phone,email,ID_departament,user_type,sso_id) VALUES (:name,:last_name,:phone,:email,:ID_departament,:user_type,:sso_id)";
    	$stmt = $dbh->prepare($sql);
    	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
    	$stmt->bindParam(':last_name',$_POST['LastName'],PDO::PARAM_STR);
    	$stmt->bindParam(':phone',$_POST['Phone'],PDO::PARAM_STR);
    	$stmt->bindParam(':email',$_POST['Email'],PDO::PARAM_STR);
    	$stmt->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
    	$stmt->bindParam(':user_type',$user_type,PDO::PARAM_STR);
    	$stmt->bindParam(':sso_id',$sso,PDO::PARAM_STR);
		if ($stmt -> execute()){
				$last_id = $dbh->lastInsertId();
				$pass = rand();
				$password = password_hash($pass, PASSWORD_BCRYPT );
				$sql= "INSERT INTO password(ID_user,pass) VALUES (:id_user,:pass)";
    			$stmt = $dbh->prepare($sql,array());
    			$stmt -> execute(array(':id_user'=>$last_id,  ':pass'=>$password));
    			$email=sent_email($name,$last_name,$email,$pass); 
			$_SESSION['add']=0;
			if($user_type=='Καθηγητής'){
				header('location:main_user.php');		
			}elseif($user_type=='Γραμματεια'){
				header('location:../Global/gramuser.php');
			}else{
				header('location:userstudent.php');		
			}
		}else{
			echo "Ανεπιτυχης επεξεργασια : ERROR CODE [3000]";
		}
    /*if ($ret) {
	$_SESSION['insert_course']=1;
    	header("location: pagingHint.php");
    } else {
	$_SESSION['iinsert_course']=0;
     	echo "error on inserting new hint ERROR CODE:[1500] ";
    }*/
    }

} catch (Exception $e) {
    echo "error on inserting data" .$e;   
}

?>    
