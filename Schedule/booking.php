  <?php 
  require_once('../connectDB.php');
$output .= '<table id="myTable" >
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
									$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course AND programme_rooms.ID_room=:id_room";
									$stmt = $dbh->prepare($sql);
									$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
									$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
									$stmt->bindParam(':id_room',$id_room,PDO::PARAM_INT);
									$stmt-> execute();
									if($stmt->rowCount()>0){
										$row = $stmt->fetch(PDO::FETCH_OBJ);
										$room=$row->name;
										$output .= ''.$room.'<hr><br>';
									}else{
										$output .='<a href="book.php?ID=$i.$j"><button class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></a>';
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
                        </table>';				
  echo $output;  						
?>						