<?php
session_start();
//f(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Γραμματεια'){
include ('../header.php');
include('../connectDB.php');
include ('../footer.php');
$ID=$_GET['ID'];
$pieces = explode(".", $_GET['ID']);
$id_hour=$pieces[0];
$id_day=$pieces[1];
$sql="SELECT name FROM departament WHERE  ID=:id order by name";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$dep=$row->name;
$editHTML=<<<EOF
<body>
<header>
<style>
.selectize-input{
	width:70% !important;
}
</style>
                 $head
	</header>
EOF;
echo $editHTML;
$sql="SELECT * FROM programme WHERE  ID_day =:id_day AND ID_hour =:id_hour";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$id_day,PDO::PARAM_INT);
$stmt->bindParam(':id_hour',$id_hour,PDO::PARAM_INT);
$stmt-> execute();
$id_hour1=$id_hour+1;
$editHTML=<<<EOF
<form method="post" class="form" action="add_course.php?ID=$ID"  enctype="multipart/form-data">
                                <legend><h4>Προσθήκη μαθήματος για το <br> πρόγραμμα σπουδών $dep</h4></legend>
EOF;
echo $editHTML;
$sql="SELECT name FROM days WHERE  ID=:id_day";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$id_day,PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$name_day=$row->name;
$editHTML=<<<EOF
                                <h4>Μέρα: $name_day<br> 'Ωρα: $id_hour.00 - $id_hour1.00</h4>
                                <hr>
								<div>
                                    <label><strong>Μάθημα:</strong></label>
									<select class="select_form" name="IDCourse" required>
									<option value="" disabled selected>-- Επιλογή Μαθήματος --</option>

EOF;
echo $editHTML;
/*$sql="SELECT course.ID,semester_course.ID as id_semester from ((programme inner join semester_course on programme.ID_semester_course=semester_course.ID) inner join course on semester_course.ID_course=course.ID) WHERE ID_day=:ID_day";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$id_day,PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->rowCount();
if($row>0){
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	$id_sem[]=$row->id_semester;
}
}
if (isset ($id_sem)){
	$selectedrooms=$id_sem;
	foreach ($selectedrooms as $value){
		if (isset($value)){
			$sql1="SELECT ID_course FROM semeter_course WHERE ID_semester<>:id_sem";
			$stmt1 = $dbh->prepare($sql1);
			$stmt1->bindParam(':id_sem',$value,PDO::PARAM_INT);
			$stmt1->execute();
			$course1[]=$row
		}
	}
}*/
$sql="SELECT course.ID,course.name FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE ID_departament=:id_depart order by name";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_course=$row->ID;
$name_course=$row->name;
$editHTML=<<<EOF
									<option value="$id_course">$name_course</option>
EOF;
echo $editHTML;
}
$editHTML=<<<EOF

									</select>
								</div>
								<table style="margin: auto;">
									<tr>
											<td align='center'>
											<input type="checkbox" id="flag" name="flag" value="1">	
											<label for="flag"> Αποθήκευση χωρίς ελέγχο</label>
											</td>
									</tr>		
								</table>
								<br>
								<div>
                                    <label><strong>Αίθουσα/Εργαστήριο:</strong></label>
                                    <table style="margin: auto;">
EOF;
echo $editHTML;
$sql="SELECT rooms.ID,name FROM rooms inner join room_depart on rooms.ID=room_depart.ID_room order by name";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
//$row = mysql_fetch_row($stmt);
//$row = mysql_num_rows($sql);
$row = $stmt->rowCount();
if($row>0){
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_room=$row->ID;
$room=$row->name;
$editHTML=<<<EOF
									<tr>
										<td align='center'>
									<input type="checkbox"  class="form-check-input" name="Room[]" value="$id_room"/>
										</td>
										<td>
											<label>$room</label>
										</td>
									</tr>
EOF;
echo $editHTML;
}
}else{
	echo("Δεν υπάρχουν δεδομενα...<br>");
}
$editHTML=<<<EOF
<br>
</table>
								 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update" onclick="myFunction()"><span>Αποθήκευση</button>
										<a href="calendar.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>
 <footer>
 $footer
 </footer>
 <script>
$(document).ready(function(){
    $("form").submit(function(){
		if ($('input:checkbox').filter(':checked').length < 1){
        alert("Επιλέξτε τουλάχιστον μια αίθουσα!");
		return false;
		}
    });
});

</script>
</body>
EOF;
echo $editHTML;
/*}else{
		header('Location:../login.php');
}*/
?>
