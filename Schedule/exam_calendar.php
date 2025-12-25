<?php
session_start();
//if(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Γραμματεια'){
require '../redirectHTTPS.php';
require_once('../connectDB.php');
include ('../header.php'); 
include ('../footer.php');
include('exam_modal_add_course.php');
$sql="SELECT * FROM departament WHERE ID=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
$name_for_modal = $row -> name;
}
$sql="SELECT * FROM  exam_days where ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
$count_days=$stmt->rowCount(); 
$printrooms = <<< EOF
<html>
<body>
<header class="header">
                 $head
				 $redirect
	</header>
$menu
<div id="main">
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	
EOF;
echo $printrooms; 
if($count_days==0){
	$printrooms = <<< EOF
	<a href='period.php' class="btn btn-primary style="margin-left: 1%;margin-bottom: 1%;">Περίοδος Εξεταστικής</a>
EOF;
echo $printrooms;
	}else{
$printrooms = <<< EOF
	<a href='del_exam_days.php' class="btn btn-danger style="margin-left: 1%;margin-bottom: 1%;">Διαγραφή Περίοδος Εξεταστικής</a>
EOF;
echo $printrooms;	
}
$printrooms = <<< EOF
 <a class="btn btn-primary style="margin-left: 1%;margin-bottom: 1%;" href="../printarea.php?exam=1" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a><br>
EOF;
echo $printrooms;
if(isset($_SESSION['exist'])){
	if($_SESSION['exist']==10){
		unset($_SESSION['exist']);
		echo "<div class='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Δε μπορείτε να καταχωρήσετε το ίδιο μάθημα ή τον ίδιο καθηγητή την ίδια μέρα και ώρα.";
		echo "<strong>Προσοχη ! </strong>$message</div>"  ;
}elseif($_SESSION['exist']==11){
	unset($_SESSION['exist']);
	echo "<div class='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Η αίθουσα δεν είναι διαθέσιμη για αυτή την ημέρα και ώρα.";
	echo "<strong>Προσοχη ! </strong>$message</div>"  ;
}elseif($_SESSION['exist']==12){
	unset($_SESSION['exist']);
	echo "<div class='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Δεν μπορείτε να καταχωρήσετε μάθημα ίδιου εξαμήνου για αυτή την ημέρα και ώρα.";
	echo "<strong>Προσοχη ! </strong>$message</div>"  ;
}elseif($_SESSION['exist']==1){
	unset($_SESSION['exist']);
	echo "<div class='alert success'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Το μάθημα έχει <strong>καταχωρηθεί</strong> με επιτυχία.";
	echo "$message</div>"  ;
}
}
if(isset($_SESSION['delete'])){
	if($_SESSION['delete']==0){
		unset($_SESSION['delete']);
		echo "<div class='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Το μάθημα διαγράφηκε.";
		echo "<strong>Προσοχη ! </strong>$message</div>"; 
	}
}

if(isset($_SESSION['prof'])){
	if($_SESSION['prof']==1){
		unset($_SESSION['prof']);
		echo "<div class='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Το μάθημα <strong>δεν</strong> καταχωρηθήκε. Συμπληρώστε τον καθηγητή που το διδάσκει.";
		echo "<strong>Προσοχη ! </strong>$message</div>"; 
	}
}
if(isset($_SESSION['date'])){
	if($_SESSION['date']==1){
		unset($_SESSION['date']);
		echo "<div class='alert success'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Δημιουργήθηκε περίοδος εξεταστικής.";
		echo "$message</div>"; 
	}else{
		unset($_SESSION['date']);
		echo "<div class='alert success'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Δεν δημιουργήθηκε περίοδος εξεταστικής.";
		echo "<strong>Προσοχη ! </strong>$message</div>"; 		
	}
}
/*if(isset($_SESSION['exist'])){
	if($_SESSION['exist']==10){
		unset($_SESSION['exist']);
echo "<div class='alert success'>"  ;
echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
$message = "Το μάθημα έχει καταχωρηθή ήδη αυτή την ημέρα"
echo "$message</div>"  ;
	}*/
$printrooms = <<< EOF

<br><div style="font-size: 25px;text-align: center;">Πρόγραμμα Εξεταστικής</div><br>
<div class="select" id="select" style="margin-left: 7%;" id="pass">

			<button class="btn btn-danger" data-target="#delete_all" data-toggle="modal">Καθαρισμός πίνακα</button>
		<!-- Modal -->
		<div id="delete_all" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Καθαρισμός Πίνακα</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p><div style="font-size:larger;padding:20px; background-color:#f44336; color:white; opacity: 1; transition: opacity 0.6s; margin-bottom: 15px;" class="">Αν πατήσετε 'ναι' θα διαγραφούν όλα τα στοιχεία που έχετε συμπληρώσει στον πίνακα 'Πρόγραμμα Εξεταστικής' και αφόρα <strong>μόνο</strong> το πρόγραμμα σπουδών $name_for_modal.</div></p>
									<form method="post" action="exam_delete_all.php"  enctype="multipart/form-data">	
						</div>
					<div class="modal-footer">
						<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
						<button type="submit" name="Submit"  class="btn btn-danger">Ναι</button>
						</form>
						</div>
					</div>
				</div>
			</div>
			<!-- <button class="btn btn-info" data-target="#add_course" data-toggle="modal">Προσθήκη Μαθήματος</button> -->

			<!-- <a href='delete_all.php' class="btn btn-danger">Καθαρισμός Πίνακα</a> -->
		<br>
		<br>
Επιλέξτε Εξάμηνο:
            <select name="sem" id="load" style="width:10%;">
              <option value=''  selected>--Επιλέξτε--</option>
EOF;
echo $printrooms; 
$sql="SELECT * FROM admin_sem where ID_department=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_sem_a=$row->ID_sem;
if($id_sem_a==2){

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
  
Επιλέξτε Καθηγητή:  
            <select name="user" id="load_user" style="width:10%;">
              <option value=''  selected>--Επιλέξτε--</option>
EOF;
echo $printrooms;
$user="Καθηγητής";
$sql="SELECT * FROM users WHERE ID_departament=:id_depart AND user_type=:user ORDER BY last_name";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->bindParam(':user',$user,PDO::PARAM_INT);
$stmt-> execute();
$count=$stmt->rowCount();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
$name = $row -> name;
$last_name=$row-> last_name;
$id=$row->ID;
$printrooms = <<< EOF
                <option value="$id">$last_name $name</option>
EOF;
echo $printrooms;  
}
$printrooms = <<< EOF
            </select> 
Επιλέξτε αίθουσα:  
            <select name="room" id="load_room" style="width:10%;">
              <option value=''  selected>--Επιλέξτε--</option>
EOF;
echo $printrooms;
$user="Καθηγητής";
$sql="SELECT rooms.ID,rooms.name FROM rooms inner join room_depart on room_depart.ID_room=rooms.ID ORDER BY name ";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
$count=$stmt->rowCount();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
$name = $row -> name;
$id=$row->ID;
$printrooms = <<< EOF
                <option value="$id">$name</option>
EOF;
echo $printrooms;  
}
$printrooms = <<< EOF
            </select>
Πρόγραμμα σπουδών:  
            <select name="depart" id="load_depart" style="width:10%;">
              <option value=''  selected>--Επιλέξτε--</option>
EOF;
echo $printrooms;
$sql="SELECT * FROM departament ORDER BY name ";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
$count=$stmt->rowCount();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
$name = $row -> name;
$id=$row->ID;
$printrooms = <<< EOF
                <option value="$id">$name</option>
EOF;
echo $printrooms;  
}
$printrooms = <<< EOF
            </select>
            Επιλογή μαθήματος:  
            <select name="course" id="load_course" style="width:10%;">
              <option value=''  selected>--Επιλέξτε--</option>
EOF;
echo $printrooms;
$sql="SELECT course.ID,course.name FROM course inner join course_depart on course_depart.ID_course=course.ID AND ID_departament=:id_depart ORDER BY name ";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
$count=$stmt->rowCount();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
$name = $row -> name;
$id=$row->ID;
$printrooms = <<< EOF
                <option value="$id">$name</option>
EOF;
echo $printrooms;  
}
$printrooms = <<< EOF
            </select>
</div>
	</div>
<div style="overflow-x:auto;">
<div id="show_table"  style="font-size: 13px;">
	<table id="myTable">
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
									$sql= "SELECT ID,ID_semester_course,ID_user FROM exam_programme WHERE ID_hour=:start_hour AND ID_day=:id_day";
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
								 <a href="add_exam.php?ID=$i.$j"><button class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></a> 
								<!-- <a href="edit.php?ID=$i.$j"><button class="btn btn-primary" ><i class="far fa-edit"></i></button></a> -->
								
								<button class="btn btn-danger" data-target="#delete$i$j" data-toggle="modal"><i class="fas fa-trash-alt"></i></button>
								</td>
								<!-- Modal -->
								<div id="delete$i$j" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle">Διαγραφή</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
											</div>
											<div class="modal-body">
											<p><div style="font-size:larger;" class="alert alert-danger">Επιλέξτε το/τα μαθήματα που θέλετε να διαγράψετε.</div></p>
EOF;
echo $printrooms;								
											$sql = "SELECT course.ID,course.name FROM ((course INNER JOIN semester_course ON course.ID=semester_course.ID_course)INNER JOIN exam_programme ON exam_programme.ID_semester_course=semester_course.ID)WHERE ID_day=:id_day AND ID_hour=:id_hour";
											$stmt = $dbh->prepare($sql);
											$stmt->bindParam(':id_day',$j,PDO::PARAM_INT);
											$stmt->bindParam(':id_hour',$i,PDO::PARAM_INT);
											$stmt->execute();         
											while( $row = $stmt->fetch(PDO::FETCH_OBJ) ){
												$id_course=$row->ID;
												$name_course=$row->name;
$printrooms = <<< EOF
											<form method="post" action="delete_exam_course.php?ID=$i.$j"  enctype="multipart/form-data">
											<div class="form-group">
												<input type="checkbox" name=delete_course[] value="$id_course"<b style="color:red;"><b style="color:red;">&nbsp $name_course</b><br>
											</div>
EOF;
echo $printrooms;
						  }
$printrooms = <<< EOF
										</div>
								<div class="modal-footer">
									<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
									<button type="submit" name="Submit"  class="btn btn-danger">Ναι</button>
</form>
								</div>
							</div>
						</div>
					</div>	
EOF;
echo $printrooms;
								}else{
$printrooms = <<< EOF
									<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"><a href="add_exam.php?ID=$i.$j"><button class="btn btn-default"><i class="fas fa-plus-circle"></i></button></a></td>
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
                    </div>    
</div>				
<footer>
$footer
    </footer>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table-body tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
var close = document.getElementsByClassName("closebtn1");
var i;
for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
 $(document).ready(function(){  
      $('#load,#load_user,#load_depart,#load_room,#load_course').change(function(){  
           var id = $(load).val();  
           var user = $(load_user).val(); 
           var depart = $(load_depart).val();
           var room = $(load_room).val(); 
           var course = $(load_course).val(); 
           $.ajax({  
                url:"load_exam_sch.php",  
                method:"GET",  
                data:{id:id,
                	user:user,
                	depart:depart,
                	room:room,
                	course:course},  
                success:function(data){  
                     $('#show_table').html(data);  
                }  
           });  
      });  
 }); 
</script>
</body>
</html>
EOF;
echo $printrooms ;
//}else{
//	echo "<script>window.location='../login.php'</script>";
//}
?>