<?php
session_start();
require_once('../connectDB.php');
if (count($_POST) > 0) {
    $sql="SELECT * FROM  password WHERE ID_user=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['user_id'],PDO::PARAM_STR);
    $stmt-> execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    $pass=$row->pass;
    $password = password_hash($_POST["newPassword"], PASSWORD_BCRYPT );
    if (password_verify($_POST["currentPassword"],$pass)){
        $sql = "UPDATE password SET pass=:pass WHERE ID_user=:get_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':pass',$password ,PDO::PARAM_STR);
        $stmt->bindParam(':get_id',$_SESSION['user_id'],PDO::PARAM_STR);
        $stmt-> execute();
        $_SESSION['message'] = "Ο κωδικός <strong>άλλαξε</strong>.";
    } else{
        $_SESSION['message']  = "Ο τρέχον κωδικός είναι λανθασμένος.";
    }
}
header('location: calendar_profesor.php')
?>