<?php 
 session_start();
include ('../header.php'); 
include('../connectDB.php');
include ('../footer.php'); 

$ID=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);
$id_hour=substr($ID,0,-1);
$id_day=substr($ID,-1);
$id_hour1=$id_hour+1;
$editHTML=<<<EOF
<body>
<header>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
                 $head
	</header>
EOF;
echo $editHTML;
$sql="SELECT name FROM days WHERE  ID=:id_day";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$id_day,PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$name_day=$row->name;

$editHTML=<<<EOF
<form method="post" class="form" action="edit_PDO_course.php?ID=$ID"  enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία Μαθήματος</h4></legend>
                                <h4>Μέρα: $name_day  <br> 'Ωρα: $id_hour.00 - $id_hour1.00</h4>
                                <hr>
								 <div>
                                    <label>Μάθημα</label>
EOF;
echo $editHTML;
$sql="SELECT ID_semester_course,ID_user,ID_schedule FROM programme WHERE  ID_day =:id_day AND ID_hour =:id_hour";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_day',$id_day,PDO::PARAM_INT);
$stmt->bindParam(':id_hour',$id_hour,PDO::PARAM_INT);
$stmt-> execute();

while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_semester_course=$row->ID_semester_course;
$id_user=$row->ID_user;
	
$sql1="SELECT course.ID,course.name FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
$stmt1-> execute();

$sql2="SELECT ID,name,last_name FROM users WHERE ID=:id_user";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':id_user',$id_user,PDO::PARAM_INT);
$stmt2-> execute();

while($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){
$id_course=$row1->ID;
$course=$row1->name;	
$row2 = $stmt2->fetch(PDO::FETCH_OBJ);
$id_user=$row2->ID;
$profesor=$row2->name;
$lprofesor=$row2->last_name;
$editHTML=<<<EOF
							<div  class="search-box">
							<input type="text" name="Course[]" required value='$course' autocomplete="off">
							<div class="result"></div>
							</div>
							<br>
EOF;
echo $editHTML;
}
}
$editHTML=<<<EOF
								</div>
								<div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update"><span>Αποθήκευση</button>
										<a href="calendar.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>
 <footer>
 $footer
 </footer>
</body>
EOF;
echo $editHTML;
?>