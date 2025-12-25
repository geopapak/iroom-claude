<?php
session_start();
require_once('../connectDB.php');
include '../Global/email.php';
if(isset($_GET['ID']))
{
    $_POST['id']=$_GET['ID'];
}

	$pass = rand();
	$password = password_hash($pass, PASSWORD_BCRYPT );
				
	$sql="SELECT * FROM  password WHERE ID_user=:id";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id',$_POST['id'],PDO::PARAM_STR);
	$stmt-> execute();
    $sql="SELECT * FROM  users WHERE ID=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id',$_POST['id'],PDO::PARAM_STR);
    $stmt-> execute();
    $row=($stmt ->fetch(PDO::FETCH_OBJ));
    $name=$row->name;
    $last_name=$row->last_name;
    $email=$row->email;
    $num=$stmt->rowCount();
	if($num>0){
        $sql = "UPDATE password SET pass=:pass WHERE ID_user=:get_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':pass',$password ,PDO::PARAM_STR);
        $stmt->bindParam(':get_id',$_POST['id'],PDO::PARAM_STR);
        $result=$stmt-> execute(); 
        $email=sent_email($name,$last_name,$email,$pass);
    } else{
		$sql= "INSERT INTO password(ID_user,pass) VALUES (:id_user,:pass)";
    	$stmt = $dbh->prepare($sql,array());
    	$result=$stmt -> execute(array(':id_user'=>$_POST['id'],  ':pass'=>$password));
        $email=sent_email($name,$last_name,$email,$pass);
	}
    if($result){
        $_SESSION['message'] = 0;
    }else{
        $_SESSION['message'] = 1;
    }
if(isset($_SESSION['UserType']) && $_SESSION['UserType']=='Καθηγητής'){
    unset($_SESSION['UserType']);
    header('location: main_user.php');
}else{
    unset($_SESSION['UserType']);
    header('location: userstudent.php');
}

?>
