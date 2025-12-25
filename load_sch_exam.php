<?php
require_once('connectDB.php');
if(isset($_POST["id"])){
	    $id_sch=$_POST["id"]; 
        $sql="SELECT * FROM  departament WHERE ID=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$room1=$row->name; 
		$nr = $stmt->rowCount();
}

								$sql="SELECT * FROM  departament where ID=:id_depart";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
								$stmt-> execute();
								$row=$stmt->fetch(PDO::FETCH_OBJ);
								$dp=$row->name;
$printrooms = <<< EOF
	<link href="css/myTable.css" rel="stylesheet" /> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<br><div style="font-size: 25px;text-align: center;">Πρόγραμμα Εξεταστικής για $dp</div><br>	
	<div class="select-after" style="padding-left: 38%;">
	<select name="Room" id="load">
		<option value="$id_sch">$room1</option>
EOF;
echo $printrooms;		
        $sql="SELECT * FROM  departament where ID<>:id_sch";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_sch',$id_sch,PDO::PARAM_INT);
		$stmt-> execute();
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
	<br>
<a style="float: left; padding-left:10px" class="like-button" href="printarea.php?depart_exam=$id_sch&ndepart_exam=$room1" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a><br>	
	<div id="printableArea">	
	<table id="myTable">
						<thead>
                                <tr>
                                    <th style="text-align:center;width: 7%;">Ημέρα/'Ωρα</th>
EOF;
echo $printrooms; 
								$sql="SELECT * FROM  exam_days where ID_departament=:id_depart";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
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
									$stmt1->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
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
 <script>
 $(document).ready(function(){  
      $("#load").change(function(){  
           var id = $(load).val();  
           $.ajax({  
                url:"load_sch_exam.php",  
                method:"POST",  
                data:{id:id},  
                success:function(data){  
                     $("#show_table").html(data);  
                }  
           });  
      });  
 }); 
 </script>                       
EOF;
echo $printrooms;		
?>							