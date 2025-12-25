<?php
  require_once('../connectDB.php');
   $output = '';  
     if(isset($_POST["id"])){
     	$pieces = explode(".", $_POST['id']);
		$id_sch=$pieces[0];
		$type=$pieces[1];
        //$id_sch=$_POST["id"];
       	$sql="SELECT * FROM  schedules where ID=:sc";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':sc',$id_sch,PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$sc=$row->name;
		if($type==1){
			$typename="Εαρινό";
		}else{
			$typename="Χειμερινό";
		}
	$output .= '<br><div style="font-size: 25px;text-align: center;">Ωρολόγιο πρόγραμμα εξαμήνου "'.$sc.' '.$typename.'".</div><br>
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
														$sql= "SELECT ID,ID_semester_course,ID_user FROM programme_history WHERE ID_hour=:start_hour AND ID_day=:id_day AND ID_schedule=:id_sch AND type=:type";
														$stmt1 = $dbh->prepare($sql);
														$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
														$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
														$stmt1->bindParam(':id_sch',$id_sch,PDO::PARAM_INT);
														$stmt1->bindParam(':type',$type,PDO::PARAM_INT);
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
									$output .= ''.$name_course.'<br>'.$name_user.''. $lname_user.'<br>'.$name_semester.'<br>';								
																$id_day_hour=(int)($i.$j);
													            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
																$sql="SELECT name FROM rooms INNER JOIN programme_rooms_history ON rooms.ID=programme_rooms_history.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
																$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
																$stmt-> execute();
																while($row = $stmt->fetch(PDO::FETCH_OBJ)){
																	$room=$row->name;
										$output .= ''.$room.'<br>';
																}
									$output .= '<hr>';
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
                        </table>';
	 }
	   echo $output;  						
?>	