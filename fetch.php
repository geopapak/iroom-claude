   <?php  
 //fetch.php  
 session_start();
require_once('connectDB.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 if(isset($_POST["user_id"]))  
 {  
      $sql = " select university.name as uni,users.ID as user_id,users.name,users.last_name,users.phone,users.email,departament.name as depart from ((users inner join departament on departament.ID=users.ID_departament) inner join university on departament.ID_university=university.ID) where users.ID=:id";  
	  $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':id',$_POST['user_id'],PDO::PARAM_INT);
      $stmt-> execute();
	  $row=$stmt->fetch(PDO::FETCH_OBJ);
      echo json_encode($row);  
 }
 ?>
 
