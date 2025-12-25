<?php
session_start();
require_once('../connectDB.php');

$get_id=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);

$sql = "DELETE FROM equipment_depart where ID_equipment = :get_id and ID_departament=:id_dapart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id', $get_id, PDO::PARAM_INT);
$stmt->bindParam(':id_dapart', $_SESSION['user_dp'], PDO::PARAM_INT);    
$stmt->execute();


$sql = "DELETE FROM equipment_room where ID_equipment = :get_id and ID_departament=:id_dapart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id', $get_id, PDO::PARAM_INT);
$stmt->bindParam(':id_dapart', $_SESSION['user_dp'], PDO::PARAM_INT);    
$stmt->execute();
$_SESSION['delete']=1;
header('location:equipment.php');
?>