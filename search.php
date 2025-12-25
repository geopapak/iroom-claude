<?php
require_once('connectDB.php');
if(isset($_POST["id_uni"]) && !empty($_POST["id_uni"])){
    //Get all state data

$sql = "SELECT * FROM departament WHERE ID_university = :ID_university ORDER BY name ASC"; 
$stmt = $dbh->prepare($sql); 
$stmt->bindParam(':ID_university',$_POST['id_uni'],PDO::PARAM_INT);
$stmt->execute();   
    //Count total number of rows
    $rowCount = $stmt->rowCount();
    
    //Display states list
    if($rowCount > 0){
        echo '<option value="">Επιλέξτε τμήμα </option>';
        while($row=$stmt->fetch(PDO::FETCH_OBJ)){ 
		$id_depart=$row->ID;
		$depart=$row->name;
            echo '<option value='.$depart.'>'.$depart.'</option>';
        }
    }else{
        echo '<option value="">Μη διαθέσημα τμήματα</option>';
    }
}
?>