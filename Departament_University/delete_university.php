<?php
require_once('../connectDB.php');

$get_id=$_GET['ID'];

// sql to delete a record
$sql = "DELETE FROM university where ID = '$get_id'";

// use exec() because no results are returned
$dbh->exec($sql);
header('location:university.php');
?>