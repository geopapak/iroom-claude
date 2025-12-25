<?php
session_start();
if(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Φοιτητης'){
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include('pagination_course.php');
include ('modal_course.php');
$pagination = new paginate_1($dbh);
$printrooms = <<< EOF
<html>
<body>
<header>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
                 $head
				 $redirect
	</header>
<div id="main">
<br>
<div class="tab">
  <button class="tablinks" onclick="openTable(event, 'Course')" id="defaultOpen">Τα δικά μου μαθήματα</button>
  <button class="tablinks" onclick="openTable(event, 'Allcourse')">Όλα τα μαθήματα</button>
  <button class="tablinks" onclick="openTable(event, 'Room')">Ανα αίθουσα</button>
  <button class="tablinks" onclick="openTable(event, 'Semester')">Ανα εξάμηνο</button>
  <button class="tablinks" onclick="openTable(event, 'Pass')">Αλλαγή κωδικού</button>
  <button class="tablinks" onclick="openTable(event, 'exam')">Πρόγραμμα Εξεταστικής</button>
</div>
EOF;
echo $printrooms;
$printrooms = <<< EOF
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
<!-- ---------------------------------------------------- Allcourse ---------------------------------------------- -->
EOF;
echo $printrooms;
$id_depart=$_SESSION['user_dp'];
$printrooms = <<< EOF
<div id="Allcourse" class="tabcontent">
<a class="like-button" href="../printarea.php?depart="$id_depart" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
						<table id="myTable" >
						<br><div style="font-size: 25px;text-align: center;">Πρόγραμμα Εξαμήνου</div><br>
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
									$sql= "SELECT ID,ID_semester_course,ID_user FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day ";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									//$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
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
$printrooms = <<< EOF
									$name_course ($sem)<br>$name_user $lname_user<br>
EOF;
echo $printrooms;									
									$id_day_hour=(int)($i.$j);
									$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course AND ID_departament=:id_depart";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
									$stmt-> execute();
									while($row = $stmt->fetch(PDO::FETCH_OBJ)){
									$room=$row->name;
								
$printrooms = <<< EOF
									$room<hr><br>
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
<!-- ---------------------------------------------------- Course ---------------------------------------------- -->
<div id="Course" class="tabcontent">
						<table id="myTable" >
						<thead>
						<tr>
						</tr>
                                <tr>
                                    <th style="text-align:center;">Μάθημα</th>
									<th style="text-align:center;">Κωδικός</th>
									<th style="text-align:center;">Διαγραφή</th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms;
								$query="SELECT * FROM  my_course WHERE ID_user=:ID_user";
								$data_per_Page=10;
								$query_1 = $pagination->paging($query,$data_per_Page);
								$pagination->dataview($query_1);  
$printrooms = <<< EOF
								</tbody>
							<tr>
							</tr>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Μαθήματος</a><br>
							<div style="font-size: 25px;text-align: center;">Τα μαθήματα που παρακολουθώ</div>
							<div class="pagination">
EOF;
echo $printrooms; 
							$pagination->paginglink($query,$data_per_Page);
$printrooms = <<< EOF
							<input class="form-control" id="myInput" type="text" placeholder="Αναζήτηση..">
							</div>
							<tfoot>
							</tfoot>
                        </table>
             <!-- <a class="like-button" href="../printarea.php?mycourse=1" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a> -->
                        <table id="myTable" >
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
									$sql= "SELECT programme.ID as pID,programme.ID_semester_course as scID,programme.ID_user as uID FROM ((programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID) INNER JOIN my_course ON my_course.ID_course=semester_course.ID_course) WHERE ID_hour=:start_hour AND ID_day=:id_day AND my_course.ID_user=:ID_user";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1->bindParam(':ID_user',$_SESSION['user_id'],PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$printrooms = <<< EOF
							<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">
EOF;
echo $printrooms;
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_programme=$row1->pID;
									$id_semester_course=$row1->scID;
									$id_user=$row1->uID;		
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
<!-- ---------------------------------------------------- ROOM ---------------------------------------------- -->			
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
<div id="show_table"></div>
</form>
</div>		
<!-- ---------------------------------------------------- Semester ---------------------------------------------- -->	
<div id="Semester" class="tabcontent">
<form>
Επιλέξτε Εξάμηνο:
    <select name="Semester"  id="load_sem">
        <option value="" disabled selected>-- Επιλέξτε --</option>
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
<div id="show_table_sem"></div>
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
 // Delete 
 $('.delete').click (function(){
	 
   var el = this;
   var id = this.id;
   //var splitid = id.split(".");
		
   // Delete id
   //var deleteid = id;
	//alert(+id);
 
    // AJAX Request
   $.ajax({
     url: 'remove.php',
     type: 'POST',
     data: { id:id },
     success: function(response){
	//alert(+response);
	console.log(response);
      if(response == 1){
	 // Remove row from HTML Table
	 $(el).closest('tr').css('background','tomato');
	 $(el).closest('tr').fadeOut(0,function(){
	    $(this).remove();
	 });
      }else{
	 alert('Invalid ID.');
      }
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
}
?>