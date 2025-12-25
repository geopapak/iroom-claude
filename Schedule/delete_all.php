<?php
session_start();
require_once('../connectDB.php');
			$sql = "DELETE  FROM programme where ID_departament=:id_depart";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
			$stmt->execute();
			
			$sql = "DELETE  FROM programme_rooms where ID_departament=:id_depart";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
			$stmt->execute();
			
header('location:calendar.php');
?>