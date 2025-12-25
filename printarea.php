<?php 
   $output = '';  
   $output = '<style type="text/css" media="all">
body {margin: 2em 5%;}
table {border-collapse: collapse; border-spacing: 0;font-size: 8px;}
th, td {padding: 0.25em 0.75em; border: 1px solid #333; text-align: center; font-weight: bold;}

thead th {border-bottom: 1px solid #333; text-align: center; font-weight: bold;}
tfoot th, tfoot td {border-top: 2px solid #666; color: #363;}

</style>
<script src="js/print.js" rel="stylesheet" /></script> 
'; 
require_once('connectDB.php');
if(isset($_GET['depart'])){
       $id_depart=$_GET['depart'];
if(isset($_GET['ndepart'])){
	$ndepart=$_GET['ndepart'];
	if(isset($_GET['sem'])){
	$output .= '<br><div style="text-align: center;font-size: 25px;">Πρόγραμμα εξαμήνου για το πρόγραμμα σπουδών "'.$_GET['ndepart'].' και εξάμηνο '.$_GET['sem'].'"</div><br>';
	}else{
	$output .= '<br><div style="text-align: center;font-size: 25px;">Πρόγραμμα εξαμήνου για το πρόγραμμα σπουδών "'.$_GET['ndepart'].'"</div><br>';		
	}

}else{
	$output .= '
<br><div style="text-align: center;font-size: 25px;">Πρόγραμμα όλων των εξαμήνων</div><br>';
}
$output .= '
	<div id="printableArea">
	<table id="myTable" >
						<thead style="border-bottom: solid">
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
											$sql="SELECT * FROM  days";
											$stmt = $dbh->prepare($sql);
											$stmt-> execute();
											$count_days=$stmt->rowCount();
											while($row=$stmt->fetch(PDO::FETCH_OBJ)){
												$name_day = $row->name;
		$output .= '<th style="text-align:center;">'.$name_day.'</th>';
											}
						$output .= '</tr>
								</thead>
								<tbody id="table-body">';
												$sql="SELECT * FROM  hours ";
												$stmt = $dbh->prepare($sql);
												$stmt-> execute();
												$row = $stmt ->fetch(PDO::FETCH_OBJ); 
												$id=$row->ID;
												$start_hour=$row ->start_hour;
												$end_hour=$row ->end_hour;
												for($i=$start_hour; $i<$end_hour; $i++){
													$start_hour1=$i+1;
				$output .= '<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> '.$i.'.00 - '.$start_hour1.'.00</td>';							
													for($j=1; $j<=$count_days; $j++){
														$sql= "SELECT programme.ID,programme.ID_semester_course,programme.ID_user, semester_course.ID_course FROM programme inner join semester_course on semester_course.ID=programme.ID_semester_course WHERE ID_hour=:start_hour AND ID_day=:id_day AND ID_departament=:id_sch";
														$clauses = array();
														if (isset($_GET['sem']) and $_GET['sem'] != '') {
															$column1 = $_GET['sem'];
														    $clauses[] = 'semester_course.ID_semester = '.$column1.'';
														}		
														if ( count($clauses) > 0 ) {
														     $sql .= ' AND '.implode(' AND ', $clauses).';';
														}																
														$stmt1 = $dbh->prepare($sql);
														$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
														$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
														$stmt1->bindParam(':id_sch',$id_depart,PDO::PARAM_INT);
														$stmt1-> execute();
														if($stmt1->rowCount()>0){
							$output .= '<td id='.$i.'.'.$j.' style="text-align:center;  word-break:inherit; width:375px;">';
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
																$name_course=$row->name;
																$id_sc=$row->ID_semester;
									
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
									$output .= ''.$name_course.' ('.$name_semester.')<br>'. $lname_user.'<br>';								
																$id_day_hour=(int)($i.$j);
																$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course AND ID_departament=:id_depart";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
																$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
																$stmt->bindParam(':id_depart',$id_depart,PDO::PARAM_INT);
																$stmt-> execute();
																while($row = $stmt->fetch(PDO::FETCH_OBJ)){
																	$room=$row->name;
										$output .= ''.$room.'<hr><br>';
																}
									//$output .= '<hr>';
															}
									$output .= '<br>';
														}else{
									$output .= '<td id='.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"></td>';
														}
													}
				$output .= '</tr>';			
												}
							$output .= '</tbody>
							</div>
                        </table>
                        </div>
                           ';
	 }elseif(isset($_GET['room'])){
$id_room=$_GET['room'];
$output .= '<div id="printableArea">
<br><div style="text-align: center;font-size: 25px;">Πρόγραμμα εξαμήνου για την αίθουσα "'.$_GET['nroom'].'"</div><br>
<table id="myTable" >
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$output .=	'<th style="text-align:center;">'.$name_day.'</th>';
								}
$output .='			</tr>
								</thead>
								<tbody id="table-body">';
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$output .='				<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;">'.$i.'.00 - '.$start_hour1.'.00</td>';									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$output .= 	'<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">';
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
									$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course AND programme_rooms.ID_room=:id_room";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt->bindParam(':id_room',$id_room,PDO::PARAM_INT);
									$stmt-> execute();
									if($stmt->rowCount()>0){
										$row = $stmt->fetch(PDO::FETCH_OBJ);
										$room=$row->name;
										$output .= ''.$name_course.' ('.$sem.')<br>'.$lname_user.'<br>'.$room.'<hr><br>';
									}else{
										$output .='';
									}
								}
						}else{
$output .='<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>';
						}
				}	
$output .='</tr>';				
	}
$output .='</tbody>
							</div>
                        </table>
                        </div>';				
   }elseif(isset($_GET['sem'])){
   	$id_sem=$_GET['sem'];
   	$output .= '
	<div id="printableArea">
	<div style="text-align: center;font-size: 25px;">Πρόγραμμα για το εξάμηνο "'.$_GET['nsem'].'"</div><br>
				<table id="myTable" >
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$output .=	'<th style="text-align:center;">'.$name_day.'</th>';
								}
$output .='			</tr>
								</thead>
								<tbody id="table-body">';
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$output .='				<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;">'.$i.'.00 - '.$start_hour1.'.00</td>';									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT programme.ID,programme.ID_semester_course,programme.ID_user FROM programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID WHERE ID_hour=:start_hour AND ID_day=:id_day AND ID_semester=:id_sem";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1->bindParam(':id_sem',$id_sem,PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$output .= 	'<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">';
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_programme=$row1->ID;
									$id_semester_course=$row1->ID_semester_course;
									$id_user=$row1->ID_user;		
									$sql="SELECT course.ID,course.name FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$id_course=$row->ID;
									$name_course=$row->name;
									
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
									//$stmt->bindParam(':id_room',$id_room,PDO::PARAM_INT);
									$stmt-> execute();
									if($stmt->rowCount()>0){
										$row = $stmt->fetch(PDO::FETCH_OBJ);
										$room=$row->name;
										$output .= ''.$name_course.'<br>'.$name_user.' '.$lname_user.'<br>'.$room.'<hr><br>';
									}else{
										$output .='';
									}
								}
						}else{
$output .='<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>';
						}
				}	
$output .='</tr>';				
	}
$output .='</tbody>
							</div>
                        </table>
                        </div>';
   }elseif(isset($_GET['allcourse'])){
$output .= '
	<div id="printableArea">
	<div style="text-align: center;font-size: 25px;">Τα μαθήματα όλων των προγραμμάτων σπουδών</div><br>
				<table id="myTable" >
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$output .=	'<th style="text-align:center;">'.$name_day.'</th>';
								}
$output .='			</tr>
								</thead>
								<tbody id="table-body">';
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$output .='				<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;">'.$i.'.00 - '.$start_hour1.'.00</td>';									
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){
$output .= 	'<td id="$i.$j" style="text-align:center;  word-break:inherit; width:375px;">';
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
									$sql="SELECT * FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									$id=$row -> ID;
									$room=$row->name;
$output .= ''.$name_course.'<br>'.$name_user.' '.$lname_user.'<br>'.$room.'<hr><br>';
								}
						}else{
$output .='<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>';
						}
				}	
$output .='</tr>';				
	}
$output .='</tbody>
							</div>
                        </table>
                        </div>';
   }elseif(isset($_GET['user'])){
   	       $id_user=$_GET['user'];
	$output .= '
<br><div style="text-align: center;font-size: 25px;">Τα δικά μου μαθήματα</div><br>';
$output .= '
	<div id="printableArea">
	<table id="myTable" >
						<thead style="border-bottom: solid">
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
											$sql="SELECT * FROM  days";
											$stmt = $dbh->prepare($sql);
											$stmt-> execute();
											$count_days=$stmt->rowCount();
											while($row=$stmt->fetch(PDO::FETCH_OBJ)){
												$name_day = $row->name;
		$output .= '<th style="text-align:center;">'.$name_day.'</th>';
											}
						$output .= '</tr>
								</thead>
								<tbody id="table-body">';
												$sql="SELECT * FROM  hours ";
												$stmt = $dbh->prepare($sql);
												$stmt-> execute();
												$row = $stmt ->fetch(PDO::FETCH_OBJ); 
												$id=$row->ID;
												$start_hour=$row ->start_hour;
												$end_hour=$row ->end_hour;
												for($i=$start_hour; $i<$end_hour; $i++){
													$start_hour1=$i+1;
				$output .= '<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> '.$i.'.00 - '.$start_hour1.'.00</td>';							
													for($j=1; $j<=$count_days; $j++){
														$sql= "SELECT ID,ID_semester_course,ID_user FROM programme WHERE ID_hour=:start_hour AND ID_day=:id_day AND ID_user=:id_user";
														$stmt1 = $dbh->prepare($sql);
														$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
														$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
														$stmt1->bindParam(':id_user',$id_user,PDO::PARAM_INT);
														$stmt1-> execute();
														if($stmt1->rowCount()>0){
							$output .= '<td id='.$i.'.'.$j.' style="text-align:center;  word-break:inherit; width:375px;">';
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
																$name_semester=$row->name;
																$sql="SELECT name,last_name FROM users WHERE ID=:id_user";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
																$stmt-> execute();
																$row = $stmt->fetch(PDO::FETCH_OBJ);
																$name_user=$row->name;
																$lname_user=$row->last_name;
$output .= ''.$name_course.' ('.$name_semester.')<br>'. $lname_user.'<br>';	
																$id_day_hour=(int)($i.$j);
																$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
																$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
																$stmt-> execute();
																while($row = $stmt->fetch(PDO::FETCH_OBJ)){
																	$room=$row->name;
										$output .= ''.$room.'<br>';
																}
									//$output .= '<hr>';
															}
									$output .= '<br>';
														}else{
									$output .= '<td id='.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"></td>';
														}
													}
				$output .= '</tr>';			
												}
							$output .= '</tbody>
							</div>
                        </table>
                        </div>
                           ';
   }elseif(isset($_GET['mycourse'])){
   	  $output .= ' 
   	  <div id="printableArea">
   	  <table id="myTable" >
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
									 $output .= ' <th style="text-align:center;">'.$name_day.' </th>';
								}
 $output .= ' 					</tr>
								</thead>
								<tbody id="table-body">';
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
 $output .= ' 						<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;">'.$i.'.00 - '.$start_hour1.'.00</td>';								
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT programme.ID as pID,programme.ID_semester_course as scID,programme.ID_user as uID FROM ((programme INNER JOIN semester_course ON programme.ID_semester_course=semester_course.ID) INNER JOIN my_course ON my_course.ID_course=semester_course.ID_course) WHERE ID_hour=:start_hour AND ID_day=:id_day AND my_course.ID_user=:ID_user";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1->bindParam(':ID_user',$_SESSION['user_id'],PDO::PARAM_INT);
									$stmt1-> execute();
					    if($stmt1->rowCount()>0){

 $output .= ' 				<td id="'.$i.'.'.$j.'" style="text-align:center;  word-break:inherit; width:375px;">';
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
								
 $output .= ' 					'.$name_course.''. ($sem).'<br>'.$lname_user.'<br>'.$room.'<hr><br>';
								}
						}else{
 $output .= ' 					<td id="'.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"></td>';
						}
				}	
 $output .= ' 				</tr>';			
	}
 $output .= ' 							</tbody>
							</div>
                        </table>
                        </div>';
   }elseif(isset($_GET['semid']) OR isset($_GET['userid']) OR isset($_GET['roomid']) OR isset($_GET['courseid']) OR isset($_GET['departid'])){
   	$print = array();
   	$keimeno="Ωρολογιο προγραμμα";
   	if(isset($_GET['semid']) and $_GET['semid'] != ''){
   		$sql="SELECT * FROM  semester where ID=:id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$_GET['semid'],PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$name_sem=$row->name;
		$print[] = $name_sem;
   	}
   	if(isset($_GET['userid']) and $_GET['userid'] != ''){
   		$sql="SELECT * FROM  users where ID=:id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$_GET['userid'],PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$name_users=$row->name;
		$print[] = $name_users;		
   	}
   	if(isset($_GET['roomid']) and $_GET['roomid'] != ''){
   		$sql="SELECT * FROM  rooms where ID=:id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$_GET['roomid'],PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$name_rooms=$row->name;
		$print[] = $name_rooms;		
   	}
   	if(isset($_GET['courseid']) and $_GET['courseid'] != ''){
   		$sql="SELECT * FROM  course where ID=:id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$_GET['courseid'],PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$name_course=$row->name;
		$print[] = $name_course;		
   	}
   	if(isset($_GET['departid']) and $_GET['departid'] != ''){
   		$sql="SELECT * FROM  departament where ID=:id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id',$_GET['departid'],PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$name_depart=$row->name;
		$print[] = $name_depart;		
   	}
   if ( count($print) > 0 ) {
	$keimeno .= ' , '.implode(' , ', $print).'';		
	}else{
		$keimeno="Ωρολόγιο Πρόγραμμα για όλα τα Προγράμματα Σπουδών";
	}
   	 $output .= '<br><div style="text-align: center;font-size: 25px;">'.$keimeno.'</div><br>
   	  <div id="printableArea">
	<table id="myTable">
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
								$sql="SELECT * FROM  days";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$count_days=$stmt->rowCount();
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
	$output .= '<th style="text-align:center;">'.$name_day.' </th>';
								}
					$output .= '</tr>
								</thead>
								<tbody id="table-body">';
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
									$output .= '<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> '.$i.'.00 - '.$start_hour1.'.00</td>';									
				for($j=1; $j<=$count_days; $j++){
									$sql = 'SELECT programme.ID,programme.ID_semester_course,programme.ID_user, semester_course.ID_course FROM programme inner join semester_course on semester_course.ID=programme.ID_semester_course WHERE ID_hour=:start_hour AND ID_day=:id_day';
									$clauses = array();
									if ( $_GET['semid'] != '') {
										$column1 = $_GET['semid'];
									    $clauses[] = 'semester_course.ID_semester = '.$column1.'';
									}
									if ( $_GET['userid'] != '' ) {
										$column2 = $_GET['userid'];
									    $clauses[] = 'ID_user = "'.$column2.'"';
									}
									if ( $_GET['departid'] != '' ) {
										$column3 = $_GET['departid'];
									    $clauses[] = 'ID_departament = "'.$column3.'"';
									}
									if ( $_GET['courseid'] != ''  ) {
										$column4 = $_GET['courseid'];
									    $clauses[] = 'semester_course.ID_course = "'.$column4.'"';
									}
									if ( count($clauses) > 0 ) {
									     $sql .= ' AND '.implode(' AND ', $clauses).';';
									}
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									//$stmt1->bindParam(':id_sem',$_POST['id'],PDO::PARAM_INT);
									//$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);									
									$result = $stmt1-> execute();
						  if($stmt1->rowCount()>0){
							$output .= '<td id="'.$i.'.'.$j.'" style="text-align:center;  word-break:inherit; width:375px;">';
								while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_programme=$row1->ID;
									$id_semester_course=$row1->ID_semester_course;
									$id_user=$row1->ID_user;
									$id_course=$row1->ID_course;		
									$sql="SELECT course.ID,course.name,semester_course.ID_semester,course.optional FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
									$clauses2 = array();
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
									//$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
									$stmt-> execute();
									$row = $stmt->fetch(PDO::FETCH_OBJ);
									//$id_course=$row->ID;
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
									$id_day_hour=(int)($i.$j);
									$sql1="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$clauses1 = array();
									if ( $_GET['roomid'] != ''  ) {
										$column5 = $_GET['roomid'];
									    $clauses1[] = 'rooms.ID = "'.$column5.'"';
									}
									if ( count($clauses1) > 0 ) {
									     $sql1 .= ' AND '.implode(' AND ', $clauses1).';';
									}					
									$stmt = $dbh->prepare($sql1);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									if($stmt->rowCount()>0){
										$row = $stmt->fetch(PDO::FETCH_OBJ);
										$room=$row->name;
										if($optional=="yes"){
											$optional="(Επιλογής)";
											$output .= ''.$name_course.' ('.$name_semester.')<br>'.$optional.'<br>'.$lname_user.'<br>'.$room.'<br>';	
											$output .= '<hr>';						
										}else{
											$output .= ''.$name_course.' ('.$name_semester.')<br>'.$lname_user.'<br>'.$room.'<br>';
											$output .= '<hr>';
										}		
									}else{
										$output .='';
									}								
								}
								$output .= '<br>
								</td>';
								}else{
									$output .= '<td id="'.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"></td>';
								}
				}	
				$output .= '</tr>';			
	}
						$output .= '	</tbody>
							</div>
                        </table>';

   	 $output .= '<div>'; 
   }elseif (isset($_GET['exam'])) {
   	$sql="SELECT * FROM  exam_days";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
$count_days=$stmt->rowCount(); 
   	  $output .= '<div id="printableArea">
	<table id="myTable">
						<thead>
                                <tr>
                                    <th style="text-align:center;width: 7%;">Ημέρα/Ωρα</th>';
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
$output .= '					<th style="text-align:center; width: 7%;">'.$name_day.' </th>';
								}
$output .= '					</tr>
								</thead>
								<tbody id="table-body">';

								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
$output .= '						<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> '.$i.'.00 - '.$start_hour1.'.00</td>';
								
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM exam_programme WHERE ID_hour=:start_hour AND ID_day=:id_day";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1-> execute();
						  if($stmt1->rowCount()>0){
$output .= '				<td id="'.$i.'.'.$j.'" style="text-align:center;  word-break:inherit; width:375px;">';
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
									$name_course=$row->name;
									$id_sc=$row->ID_semester;
									
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

$output .= '						'.$name_course.' ('.$name_semester.')<br>'.$lname_user.'<br>';
								
									$id_day_hour=(int)($i.$j);
									$sql="SELECT name FROM rooms INNER JOIN exam_programme_rooms ON rooms.ID=exam_programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									while($row = $stmt->fetch(PDO::FETCH_OBJ)){
									$room=$row->name;
$output .= '							'.$room.'<br>';
									}
								}
$output .= '				<br>
								</td>';
								}else{
$output .= '						<td id="$i.$j" style="text-align:center; word-break:break-all; width:300px;"></td>';
								}
				}	
$output .= '	</tr>	';		
	}
$output .= '				</tbody>
							</div>
                        </table>
</div>';
   }elseif (isset($_GET['depart_exam'])) {
   	$id_sch=$_GET['depart_exam'];
	$output .= '<div id="printableArea">	
	 <br><div style="text-align: center;font-size: 25px;">Πρόγραμμα Εξεταστικής '.$_GET['ndepart_exam'].'</div><br>
	<table id="myTable">
						<thead>
                                <tr>
                                    <th style="text-align:center;width: 7%;">Ημέρα/Ωρα</th>';
								$sql="SELECT * FROM  exam_days where ID_departament=:id_depart";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
								$stmt-> execute();
								$count_days=$stmt->rowCount(); 
								while($row=$stmt->fetch(PDO::FETCH_OBJ)){
									$name_day = $row->name;
									$output .= '<th style="text-align:center; width: 7%;">'.$name_day.'</th>';
								}
								$output .= '</tr>
								</thead>
								<tbody id="table-body">';
								$sql="SELECT * FROM  hours ";
								$stmt = $dbh->prepare($sql);
								$stmt-> execute();
								$row = $stmt ->fetch(PDO::FETCH_OBJ); 
								$id=$row->ID;
								$start_hour=$row ->start_hour;
								$end_hour=$row ->end_hour;
	for($i=$start_hour; $i<$end_hour; $i++){  
									$start_hour1=$i+1;
									$output .= '<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> '.$i.'.00 - '.$start_hour1.'.00</td>';								
				for($j=1; $j<=$count_days; $j++){
									$sql= "SELECT ID,ID_semester_course,ID_user FROM exam_programme WHERE ID_hour=:start_hour AND ID_day=:id_day And ID_departament=:id_depart";
									$stmt1 = $dbh->prepare($sql);
									$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
									$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
									$stmt1->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
									$stmt1-> execute();
						  if($stmt1->rowCount()>0){
							$output .= '<td id="'.$i.'.'.$j.'" style="text-align:center;  word-break:inherit; width:375px;">';
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
										$output .= ''.$name_course.'<br>'.$optional.'<br>'.$lname_user.'<br>'.$name_semester.'<br>';								
									}else{
										$output .= ''.$name_course.'<br>'.$lname_user.'<br>'.$name_semester.'<br>';
									}										
									$id_day_hour=(int)($i.$j);
									$sql="SELECT name FROM rooms INNER JOIN exam_programme_rooms ON rooms.ID=exam_programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt-> execute();
									while($row = $stmt->fetch(PDO::FETCH_OBJ)){
									$room=$row->name;
										$output .= ''.$room.'<br>';
									}
								}
									$output .= '<br>
								</td>';
								}else{
									$output .= '<td id="'.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"></td>';
								}
				}
				$output .= '</tr>';			
	}
							$output .= '</tbody>
							</div>
                        </table>
                        </div> ';
   }				
	 	   echo $output;  		
?>							   