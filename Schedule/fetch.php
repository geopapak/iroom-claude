<?php
session_start();
require_once('../connectDB.php');
if(isset($_POST['view'])){
$sql = "SELECT * FROM notification WHERE status=0 and ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);	
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt-> execute();
$result = $stmt->rowCount();
$output = '';
if($result > 0)
{
while($row = $stmt->fetch(PDO::FETCH_OBJ))
{
$id=$row->ID;
$subject=$row->subject;
$id_room=$row->ID_room;
$id_user=$row->ID_user;
$id_day_hour=$row->ID_day_hour;
$id_departament=$row->ID_departament;
$id_course=$row->ID_course;
$id_hour=substr($id_day_hour,0,-1);
$id_day=substr($id_day_hour,-1);
$int_day=(int)$id_day;
$sql1 = "SELECT name FROM days WHERE ID=:id_day";
$stmt1 = $dbh->prepare($sql1);	
$stmt1->bindParam(':id_day',$int_day,PDO::PARAM_INT);
$stmt1-> execute();
$row1 = $stmt1->fetch(PDO::FETCH_OBJ);
$day=$row1->name;
$sql1 = "SELECT name FROM course WHERE ID=:id_course";
$stmt1 = $dbh->prepare($sql1);  
$stmt1->bindParam(':id_course',$id_course,PDO::PARAM_INT);
$stmt1-> execute();
$row1 = $stmt1->fetch(PDO::FETCH_OBJ);
$course=$row1->name;
$sql1 = "SELECT name,last_name FROM users WHERE ID=:id_user AND ID_departament=:id_departament";
$stmt1 = $dbh->prepare($sql1);	
$stmt1->bindParam(':id_user',$id_user,PDO::PARAM_INT);
$stmt1->bindParam(':id_departament',$id_departament,PDO::PARAM_INT);
$stmt1-> execute();
$row1 = $stmt1->fetch(PDO::FETCH_OBJ);
$name=$row1->name;
$last_name=$row1->last_name;
  $output .= '
  <li>
  <a href="#">
  <strong>'.$subject.'</strong><br />
  <small ><em>Ο/Η '.$name.' '.$last_name.' θέλει την αίθουσα <br>';
	$room=explode(", ", $id_room);
	foreach($room as $value){
		$sql1 = "SELECT name FROM rooms WHERE ID=:name";
		$stmt1 = $dbh->prepare($sql1);	
		$stmt1->bindParam(':name',$value,PDO::PARAM_INT);
		$stmt1-> execute();	
		$row1 = $stmt1->fetch(PDO::FETCH_OBJ);
		$room=$row1->name;
   $output .=  ''.$room.',';
		}
    $output .= ' για τη μέρα '.$day.' και ώρα '.$id_hour.' <br> για το μάθημα '.$course.'</em><br>
  <a href="add_course.php?ID='.$id.'&IDroom='.$id_room.'&IDuser='.$id_user.'&IDdayhour='.$id_day_hour.'&IDdepart='.$id_departament.'&IDcourse='.$id_course.'"><button class="btn btn-success" ><i class="fas fa-check"></i></button></a>
  <!-- <button class="btn btn-primary" ><i class="far fa-edit"></i></button> -->
  <a href="delete_noti.php?ID='.$id.'"><button class="btn btn-danger" ><i class="fas fa-trash-alt"></i></button></a></small>
  </a>
  <hr>
  </li>
 ';
}
}else{
    $output .= '<li><a href="#" class="text-bold text-italic">Δεν υπάρχουν νέες ενημερώσεις</a></li>';
}
$sql = "SELECT * FROM notification WHERE status=0 and ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);	
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt-> execute();
$count =  $stmt->rowCount();
$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);
echo json_encode($data);
}
?>