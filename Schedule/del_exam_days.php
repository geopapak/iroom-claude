<?php
session_start();
require_once('../connectDB.php');
$sql = "DELETE FROM exam_days";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$sql = "DELETE FROM exam_programme";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$sql = "DELETE FROM exam_programme_rooms";
$stmt = $dbh->prepare($sql);
$stmt->execute(); 

$sql = "ALTER TABLE exam_days AUTO_INCREMENT = 1";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$_SESSION['deletecourse']=1;
header('location:exam_calendar.php');
exit();
?>