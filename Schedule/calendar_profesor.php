<?php
 session_start();
if(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Καθηγητής'){
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include ('insert_noti.php');
$id_user1= $_SESSION['user_id'];
//$id_depart=$_SESSION['user_dp'];
$printrooms = <<< EOF
<html>
<body>
<header>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
                 $head
				 $redirect
	</header>
<div id="main">
EOF;
echo $printrooms;
if(isset($_SESSION['noti'])) { 
    echo "<div class='alert alert-success' role='alert'>"  ;
    echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
    $message = $_SESSION['noti'];
    echo "$message</div>"; 
    unset($_SESSION['noti'] );
}
if(isset($_SESSION['message'])) { 
    echo "<div class='alert alert-success' role='alert'>"  ;
    echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
    $message = $_SESSION['message'];
    echo "$message</div>"; 
    unset($_SESSION['message'] );
}
$printrooms = <<< EOF
<!--
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	
-->
<br>
<div class="tab">
  <button class="tablinks" onclick="openTable(event, 'Mycourse')" id="defaultOpen">Τα μαθήματα μου</button>
  <button class="tablinks" onclick="openTable(event, 'Allcourse')" >Όλα τα μαθήματα</button>
  <button class="tablinks" onclick="openTable(event, 'Room')">Ανα αίθουσα</button>
  <button class="tablinks" onclick="openTable(event, 'Semester')">Ανα εξάμηνο</button>
   <button class="tablinks" onclick="openTable(event, 'Depart')">Ανα πρόγραμμα σπουδών</button>
  <button class="tablinks" onclick="openTable(event, 'Book')">Κράτηση Αίθουσας</button>
  <button class="tablinks" onclick="openTable(event, 'Pass')">Αλλαγή κωδικού</button>
  <button class="tablinks" onclick="openTable(event, 'exam')">Πρόγραμμα εξεταστικής</button>
</div>

<!-- -------------------------------------------------- MyCourse ---------------------------------------- -->
<div id="Mycourse" class="tabcontent">
<a class="like-button" href="../printarea.php?user=$id_user1" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
<div style="overflow-x:auto;">
							<table id="myTable" >
							<br><div style="font-size: 25px;text-align: center;">Τα δικά μου μαθήματα</div><br>
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/'Ωρα</th>
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$printrooms = <<< EOF
									<th style="text-align:center;">$name_day </th>
EOF;
echo $printrooms; 
								}
$printrooms = <<< EOF
								</tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$printrooms = <<< EOF
									<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> $i.00 - $start_hour1.00</td>
EOF;
echo $printrooms;									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day AND ID_user=:id_user";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_user',$id_user1,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$printrooms = <<< EOF
							<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">
EOF;
echo $printrooms;
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_programme=$row1->ID;
									$id_semester_course=$row1->ID_semester_course;	
									$sql="SELECT course.ID,course.name,semester_course.ID_semester FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$id_course=$row->ID;
									$idsem=$row->ID_semester;
									$name_course=$row->name;
									$sql="SELECT name FROM semester WHERE ID=:sem";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':sem',$idsem,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$sem=$row->name;
									$sql="SELECT name,last_name FROM users WHERE ID=:id_user";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_user',$id_user1,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$name_user=$row->name;
									$lname_user=$row->last_name;
$printrooms = <<< EOF
									$name_course ($sem)<br>$name_user $lname_user<br>
EOF;
echo $printrooms;
									$id_day_hour=(int)($i.$j);
									$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									while($row = $stmt->fetch(PDO::FETCH_OBJ)){
									$room=$row->name;
								
$printrooms = <<< EOF
									$room<br>
EOF;
echo $printrooms;
									}
								}
						}else{
$printrooms = <<< EOF
									<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>
EOF;
echo $printrooms;
						}
				}	
$printrooms = <<< EOF
				</tr>
EOF;
echo $printrooms;				
	}
$printrooms = <<< EOF
							</tbody>
							</div>
                        </table>	
               </div>         
</div>
<!-- ------------------------------------------ Password --------------------------------------------------- -->
<div id="Pass" class="tabcontent">
 <form method="post" class="form" action="password.php" onSubmit="return validatePassword()"  name="frmChange" enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Αλλαγή κωδικού</h4>
                                <hr>
                                <div>
                                    <label>Παλιός Κωδικός <br>(Του συστήματος. Όχι τον ιδρυματικό)</label>
                                    <input type="password" name="currentPassword" class="txtField" autocomplete="on"/><span id="currentPassword" class="required"></span>
                                </div>  
                                <div>
                                    <label>Νέος Κωδικός</label>
                                    <input type="password" name="newPassword" class="txtField" autocomplete="on"/><span id="newPassword" class="required"></span>
                                </div>
                                <div>
                                    <label>Επαλήθευση</label>
                                    <input type="password" name="confirmPassword" class="txtField" autocomplete="on"/><span id="confirmPassword" class="required"></span>
                                </div>
                                 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="submit" value="Submit"><span>Αποθήκευση</button>
                                </div>
                            </form>   
</div>		
<!-- ---------------------------------------------------- All course ---------------------------------------------------- -->
<div id="Allcourse" class="tabcontent">
<a class="like-button" href="../printarea.php?allcourse=1" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
<div style="overflow-x:auto;">
						<table id="myTable" >
						<br><div style="font-size: 25px;text-align: center;">Όλα τα μαθήματα του εξαμήνου για όλα τα προγράμματα σπουδών</div><br>
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/'Ωρα</th>
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$printrooms = <<< EOF
									<th style="text-align:center;">$name_day </th>
EOF;
echo $printrooms; 
								}
$printrooms = <<< EOF
								</tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$printrooms = <<< EOF
									<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> $i.00 - $start_hour1.00</td>
EOF;
echo $printrooms;									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$printrooms = <<< EOF
							<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">
EOF;
echo $printrooms;
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_programme=$row1->ID;
									$id_semester_course=$row1->ID_semester_course;
									$id_user=$row1->ID_user;		
									$sql="SELECT course.ID,course.name,semester_course.ID_semester FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$id_course=$row->ID;
									$idsem=$row->ID_semester;
									$name_course=$row->name;
									$sql="SELECT name FROM semester WHERE ID=:sem";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':sem',$idsem,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$sem=$row->name;
									$sql="SELECT name,last_name FROM users WHERE ID=:id_user";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$name_user=$row->name;
									$lname_user=$row->last_name;
									
									$id_day_hour=(int)($i.$j);
									//var_dump($id_day_hour);
									//var_dump($id_course);
									$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$room=$row->name;
								
$printrooms = <<< EOF
									$name_course ($sem)<br>$name_user $lname_user<br>$room<hr><br>
EOF;
echo $printrooms;
								}
						}else{
$printrooms = <<< EOF
									<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>
EOF;
echo $printrooms;
						}
				}	
$printrooms = <<< EOF
				</tr>
EOF;
echo $printrooms;				
	}
$printrooms = <<< EOF
							</tbody>
							</div>
                        </table>
                        </div>							
</div>
<!-- ------------------------------------------------- Room ------------------------------------------------------------ -->			
<div id="Room" class="tabcontent">
<form>
Επιλέξτε Αίθουσα:
    <select name="Room"  id="load">
        <option value="" disabled selected>--Επιλέξτε--</option>
EOF;
echo $printrooms; 
$sql="SELECT rooms.ID,rooms.name FROM rooms INNER JOIN room_depart on rooms.ID=room_depart.ID_room order by name";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id=$row->ID;
$name=$row->name;
$printrooms = <<< EOF
		<option value="$id">$name</option>
EOF;
echo $printrooms;
		}
$printrooms = <<< EOF
</select>
<div style="overflow-x:auto;">
<div id="show_table"></div>
</div>
</form>
</div>		
<!-- ------------------------------------------------- Book ----------------------------------------------------------------- -->
<div id="Book" class="tabcontent">
						<table id="myTable" >
						<br><div style="font-size: 25px;text-align: center;">Πίνακας για κράτηση αίθουσας</div><br>
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/'Ωρα</th>
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$printrooms = <<< EOF
									<th style="text-align:center;">$name_day </th>
EOF;
echo $printrooms; 
								}
$printrooms = <<< EOF
								</tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$printrooms = <<< EOF
									<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> $i.00 - $start_hour1.00</td>
EOF;
echo $printrooms;									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$printrooms = <<< EOF
							<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">
EOF;
echo $printrooms;
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_semester_course=$row1->ID_semester_course;		
									$sql="SELECT course.ID,course.name,semester_course.ID_semester FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$id_course=$row->ID;
									
									$id_day_hour=(int)($i.$j);
									$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									while($row = $stmt->fetch(PDO::FETCH_OBJ)){
									$room=$row->name;
$printrooms = <<< EOF
									$room<br>
EOF;
echo $printrooms;
									}
								}
										$dayhour=(int)($i.$j);
										//var_dump($dayhour);
										$sql = "SELECT rooms.ID,rooms.name from rooms INNER JOIN room_depart on rooms.ID=room_depart.ID_room where rooms.ID not in (select ID_room from programme_rooms WHERE ID_day_hour=:id_day_hour)";
										$stmt = $dbh->prepare($sql);
										$stmt->bindParam(':id_day_hour',$dayhour,PDO::PARAM_INT);
										$stmt->execute();
										if($stmt->rowCount()>0){
$printrooms = <<< EOF
								<button class="btn btn-default" data-target="#book$i$j" data-toggle="modal"><i class="fas fa-plus-circle"></i></button>
EOF;
echo $printrooms;
									}
$printrooms = <<< EOF
								</td>
								<!-- Modal -->
								<div id="book$i$j" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle">Αναπλήρωση</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
													</button>
											</div>
								<div class="modal-body">
								<p><div style="font-size:larger;" class="alert alert-danger">Επιλέξτε μάθημα και αίθουσα/σες που θέλετε να κλείσετε.</div></p>
									<form method="post" id="comment_form" enctype="multipart/form-data">
										<div class="form-group">
											<input type="hidden" name="dayhour" value="$i$j">
										</div> 
										<div class="form-group">
											<input type="date" name="date" value="" required>
										</div>										
										<div class="form-group">
												<input type="hidden" name="subject" id="subject" value="Κράτηση αίθουσας">
										</div>
										<div class="form-group">
											<select class="select_form" name="IDCourse" required>
												<option value="" disabled selected>-- Επιλογή Μαθήματος --</option>
EOF;
echo $printrooms;
													$sql="SELECT course.ID,course.name FROM course INNER JOIN course_profesor ON course_profesor.ID_course=course.ID WHERE course_profesor.ID_profesor=:id_user AND ID_depart=:id_depart order by name";
													$stmt = $dbh->prepare($sql);
													$stmt->bindParam(':id_user',$id_user1,PDO::PARAM_INT);
													$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
													$stmt-> execute();
													while($row = $stmt->fetch(PDO::FETCH_OBJ)){
													$id_course=$row->ID;
													$name_course=$row->name;
$printrooms=<<<EOF
											   <option value="$id_course">$name_course</option>
EOF;
echo $printrooms;
}
$printrooms=<<<EOF
											</select>
									</div>
EOF;
echo $printrooms;							
										$dayhour=(int)($i.$j);
										$sql = "select rooms.ID,rooms.name from rooms INNER JOIN room_depart on rooms.ID=room_depart.ID_room where rooms.ID not in (select programme_rooms.ID_room from programme_rooms WHERE ID_day_hour=:id_day_hour) order by rooms.name";
										$stmt = $dbh->prepare($sql);
										$stmt->bindParam(':id_day_hour',$dayhour,PDO::PARAM_INT);
										$stmt->execute();  
										while( $row = $stmt->fetch(PDO::FETCH_OBJ) ){
											$id_room=$row->ID;
											$room=$row->name;
											//$kind=$row->kind;
$printrooms = <<< EOF
									<div class="form-group">
										<input type="checkbox" name=booking[] value="$id_room">&nbsp $room <br> <br> Εξοπλισμός:<br>
EOF;
echo $printrooms;
											$sql2 = "SELECT equipment.name as equip FROM equipment_room INNER JOIN equipment ON equipment_room.ID_equipment=equipment.ID WHERE equipment_room.ID_rooms=:id_room";
											$stmt2 = $dbh->prepare($sql2);
											$stmt2->bindParam(':id_room',$id_room,PDO::PARAM_INT);
											$stmt2->execute();         
											while( $row2 = $stmt2->fetch(PDO::FETCH_OBJ) ){
												$equipment=$row2->equip;
$printrooms = <<< EOF
$equipment<br>
EOF;
echo $printrooms;
											}
$printrooms = <<< EOF
</b><hr><br></div>
EOF;
echo $printrooms;
										}
$printrooms = <<< EOF
										</div>	
								<div class="modal-footer">
									<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
									<button type="submit" name="post" id="post" class="btn btn-danger">Ναι</button>
									</form>									
								</div>
							</div>
						</div>
					</div>									
EOF;
echo $printrooms;																	
						}else{
$printrooms = <<< EOF
								<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;">
								<button class="btn btn-default" data-target="#book$i$j" data-toggle="modal"><i class="fas fa-plus-circle"></i></button>
								</td>
								<!-- Modal -->
								<div id="book$i$j" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle">Αναπλήρωση</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
													</button>
											</div>
								<div class="modal-body">
								<p><div style="font-size:larger;" class="alert alert-danger">Επιλέξτε μάθημα και αίθουσα/σες που θέλετε να κλείσετε.</div></p>
									<form method="post" id="" enctype="multipart/form-data">
										<div class="form-group">
											<input type="hidden" name="dayhour" value="$i$j">
										</div>
										<div class="form-group">
											<input type="date" name="date" value="" required>
										</div>												
										<div class="form-group">
												<input type="hidden" name="subject" id="subject" value="Κράτηση αίθουσας">
										</div>
										<div class="form-group">
											<select class="select_form" name="IDCourse" required>
												<option value="" disabled selected>-- Επιλογή Μαθήματος --</option>
EOF;
echo $printrooms;
													$sql="SELECT course.ID,course.name FROM course INNER JOIN course_profesor ON course_profesor.ID_course=course.ID WHERE course_profesor.ID_profesor=:id_user order by name";
													$stmt = $dbh->prepare($sql);
													$stmt->bindParam(':id_user',$id_user1,PDO::PARAM_INT);
													$stmt-> execute();
													while($row = $stmt->fetch(PDO::FETCH_OBJ)){
													$id_course=$row->ID;
													$name_course=$row->name;
$printrooms=<<<EOF
											   <option value="$id_course">$name_course</option>
EOF;
echo $printrooms;
}
$printrooms=<<<EOF
											</select>
									</div>
EOF;
echo $printrooms;								
										$sql = "SELECT * FROM rooms";
										$stmt = $dbh->prepare($sql);
										$stmt->execute();         
										while( $row = $stmt->fetch(PDO::FETCH_OBJ) ){
											$id_room=$row->ID;
											$room=$row->name;
											//$kind=$row->kind;
$printrooms = <<< EOF
									<div class="form-group">
										<input type="checkbox" name=booking[] value="$id_room">&nbsp $room <br> <br> Εξοπλησμός:<br>
EOF;
echo $printrooms;
											$sql2 = "SELECT equipment.name as equip FROM equipment_room INNER JOIN equipment ON equipment_room.ID_equipment=equipment.ID WHERE equipment_room.ID_rooms=:id_room";
											$stmt2 = $dbh->prepare($sql2);
											$stmt2->bindParam(':id_room',$id_room,PDO::PARAM_INT);
											$stmt2->execute();         
											while( $row2 = $stmt2->fetch(PDO::FETCH_OBJ) ){
												$equipment=$row2->equip;
$printrooms = <<< EOF
$equipment<br>
EOF;
echo $printrooms;
											}
$printrooms = <<< EOF
</b><hr><br></div>
EOF;
echo $printrooms;
										}
$printrooms = <<< EOF
										</div>	
								<div class="modal-footer">
									<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
									<button type="submit" name="post" id="post" class="btn btn-danger">Ναι</button>
									</form>									
								</div>
							</div>
						</div>
					</div>	
EOF;
echo $printrooms;
						}
				}	
$printrooms = <<< EOF
				</tr>
EOF;
echo $printrooms;				
	}
$printrooms = <<< EOF
							</tbody>
							</div>
                        </table>	
</div>	
<!-- ------------------------------------------------------------------------------------------------------------- ΕΧΑΜ ---------------------------------------------------------- -->
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  departament where ID=:id_depart";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
								$stmt-> execute();
								$row=$stmt->fetch(PDO::FETCH_OBJ);
								$dp=$row->name;
$printrooms = <<< EOF
<div id="exam" class="tabcontent">
	<table id="myTable">
							<br><div style="font-size: 25px;text-align: center;">Πρόγραμμα Εξεταστικής για $dp</div><br>
						<thead>
                                <tr>
                                    <th style="text-align:center;width: 7%;">Ημέρα/'Ωρα</th>
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  exam_days where ID_departament=:id_depart";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
								$stmt-> execute();
								$count_days=$stmt->rowCount(); 
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$printrooms = <<< EOF
									<th style="text-align:center; width: 7%;">$name_day </th>
EOF;
echo $printrooms; 
								}
$printrooms = <<< EOF
								</tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$printrooms = <<< EOF
									<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> $i.00 - $start_hour1.00</td>
EOF;
echo $printrooms;									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM exam_programme WHERE ID_hour=:start_hour AND ID_day=:id_day And ID_departament=:id_depart";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
									$stmt1-> execute();
						  if($stmt1->rowCount()>0){
$printrooms = <<< EOF
							<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">
EOF;
echo $printrooms;
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_programme=$row1->ID;
									$id_semester_course=$row1->ID_semester_course;
									$id_user=$row1->ID_user;		
									$sql="SELECT course.ID,course.name,semester_course.ID_semester,course.optional FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$id_course=$row->ID;
									$name_course=$row->name;
									$id_sc=$row->ID_semester;
									$optional=$row->optional;
									$sql="SELECT name FROM semester WHERE ID=:id_sc";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_sc',$id_sc,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$name_semester=$row->name;
									
									$sql="SELECT name,last_name FROM users WHERE ID=:id_user";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$name_user=$row->name;
									$lname_user=$row->last_name;
									if($optional=="yes"){
										$optional="(Επιλογής)";
$printrooms = <<< EOF
										$name_course<br>$optional<br>$lname_user<br>$name_semester<br>
EOF;
echo $printrooms;									
									}else{
$printrooms = <<< EOF
										$name_course<br>$lname_user<br>$name_semester<br>
EOF;
echo $printrooms;
									}
$printrooms = <<< EOF
									
EOF;
echo $printrooms;										
									$id_day_hour=(int)($i.$j);
									$sql="SELECT name FROM rooms INNER JOIN exam_programme_rooms ON rooms.ID=exam_programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									while($row = $stmt->fetch(PDO::FETCH_OBJ)){
									$room=$row->name;
$printrooms = <<< EOF
										$room<br>
EOF;
echo $printrooms;
									}
									echo "<hr>";
								}
$printrooms = <<< EOF
									<br>
								</td>
EOF;
echo $printrooms;
								}else{
$printrooms = <<< EOF
									<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>
EOF;
echo $printrooms;
								}
				}	
$printrooms = <<< EOF
				</tr>
EOF;
echo $printrooms;				
	}
$printrooms = <<< EOF
							</tbody>
EOF;
echo $printrooms; 
$printrooms = <<< EOF
							</div>
                        </table>
</div>									
<!-- -------------------------------------------------------- Semester -------------------------------- -->
<div id="Semester" class="tabcontent">
<form>
Επιλέξτε Εξάμηνο:
    <select name="Semester"  id="load_sem">
        <option value="" disabled selected>--Επιλέξτε--</option>
EOF;
echo $printrooms; 
$sql="SELECT * FROM admin_sem where ID_department=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_sem=$row->ID_sem;
if($id_sem==2){

$sql="SELECT ID,name FROM semester where mod(id,2)=0";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_sem=$row->ID;
$name=$row->name;
$printrooms = <<< EOF
		<option value="$id_sem">$name</option>
EOF;
echo $printrooms;
		}

}else{
$sql="SELECT ID,name FROM semester where mod(id,2)<>0";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_sem=$row->ID;
$name=$row->name;
$printrooms = <<< EOF
		<option value="$id_sem">$name</option>
EOF;
echo $printrooms;
		}
}
$printrooms = <<< EOF
</select>
<div style="overflow-x:auto;">
<div id="show_table_sem"></div>
</div>
</form>
</div>
<!-- -------------------------------------------------------- Depart -------------------------------- -->
<div id="Depart" class="tabcontent">
<form>
Επιλέξτε Πρόγραμμα Σπουδών:
    <select name="Depart"  id="load_depart">
        <option value="" disabled selected>--Επιλέξτε--</option>
EOF;
echo $printrooms; 
$sql="SELECT ID,name FROM departament";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_depart=$row->ID;
$name=$row->name;
$printrooms = <<< EOF
		<option value="$id_depart">$name</option>
EOF;
echo $printrooms;
		}
$printrooms = <<< EOF
</select>
<div style="overflow-x:auto;">
<div id="show_table_depart">
</div>


</div>
</form>
</div>									
</div>	
<footer>
$footer
    </footer>	
 <script>  
 function openTable(evt, option) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(option).style.display = "block";
    evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
 $(document).ready(function(){  
      $('#load').change(function(){  
           var id = $(this).val();  
           $.ajax({  
                url:"load_table.php",  
                method:"POST",  
                data:{id:id},  
                success:function(data){  
                     $('#show_table').html(data);  
                }  
           });  
      });  
 });  
   $(document).ready(function(){  
      $('#load_sem').change(function(){  
           var id_sem = $(this).val();  
           $.ajax({  
                url:"load_table_semester.php",  
                method:"POST",  
                data:{id_sem:id_sem},  
                success:function(data){  
                     $('#show_table_sem').html(data);  
                }  
           });  
      });  
 }); 
    $(document).ready(function(){  
      $('#load_depart').change(function(){  
           var id_depart = $(this).val();  
           $.ajax({  
                url:"load_table_depart.php",  
                method:"POST",  
                data:{id_depart:id_depart},  
                success:function(data){  
                     $('#show_table_depart').html(data);  
                }  
           });  
      });  
 });  


</script>

</body>
</html>
EOF;
echo $printrooms ;
}else{
	header("Location: index.php");
	var_dump($_SESSION);
}
?>