<?php
session_start();
require_once('../connectDB.php');
$output = '';  
	$output .='
	<a class="btn btn-danger" href="../printarea.php?semid='.$_GET['id'].'&userid='.$_GET['user'].'&roomid='.$_GET['room'].'&courseid='.$_GET['course'].'&departid='.$_GET['depart'].'" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>';
	if(isset($_GET['depart']) and $_GET['depart'] != ''){
								$sql="SELECT * FROM  departament where ID=:ID";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':ID',$_GET['depart'],PDO::PARAM_INT);
								$stmt-> execute();
								$count=$stmt->rowCount();
								if($count>0){
									$row=$stmt->fetch(PDO::FETCH_OBJ);
									$name = $row->name;
								}
	$output .='<div id="titlos" style="font-size: 25px;text-align: center;">Ωρολόγιο Πρόγραμμα για τo Προγράμματα Σπουδών <br> '.$name.'</div>';							
	}else{
	$output .='<div id="titlos" style="font-size: 25px;text-align: center;">Ωρολόγιο Πρόγραμμα για όλα τα Προγράμματα Σπουδών</div>';
	}
	$output .='<link href="../css/myTable.css" rel="stylesheet" /> 
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
									if ( $_GET['id'] != '') {
										$column1 = $_GET['id'];
									    $clauses[] = 'semester_course.ID_semester = '.$column1.'';
									}
									if ( $_GET['user'] != '' ) {
										$column2 = $_GET['user'];
									    $clauses[] = 'ID_user = "'.$column2.'"';
									}
									if ( $_GET['depart'] != '' ) {
										$column3 = $_GET['depart'];
									    $clauses[] = 'ID_departament = "'.$column3.'"';
									}
									if ( $_GET['course'] != ''  ) {
										$column4 = $_GET['course'];
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
									if ( $_GET['room'] != ''  ) {
										$column5 = $_GET['room'];
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
											$output .= ''.$name_course.'<br>'.$optional.'<br>'.$name_user.' '.$lname_user.'<br>'.$name_semester.'<br>'.$room.'<br>';	
											$output .= '<hr>';						
										}else{
											$output .= ''.$name_course.'<br>'.$name_user.' '.$lname_user.'<br>'.$name_semester.'<br>'.$room.'<br>';
											$output .= '<hr>';
										}		
									}else{
										$output .='';
									}								
								}
								$output .= '<br>
								 <a href="add_edit.php?ID='.$i.'.'.$j.'"><button class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></a> 
								<!-- <a href="edit.php?ID=$i.$j"><button class="btn btn-primary" ><i class="far fa-edit"></i></button></a> -->
								
								<button class="btn btn-danger" data-target="#delete'.$i.''.$j.'" data-toggle="modal"><i class="fas fa-trash-alt"></i></button>
								</td>
								<!-- Modal -->
								<div id="delete'.$i.''.$j.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle">Διαγραφή</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
											</div>
										<form method="post" action="delete_course.php?ID='.$i.'.'.$j.'" id="'.$i.''.$j.'" enctype="multipart/form-data">											
											<div class="modal-body">
											<p><div style="font-size:larger;padding:20px; background-color:#f44336; color:white; opacity: 1; transition: opacity 0.6s; margin-bottom: 15px;" class="">Επιλέξτε το/τα μαθήματα που θέλετε να διαγράψετε.</div></p>';				
											$sql = "SELECT course.ID,course.name FROM ((course INNER JOIN semester_course ON course.ID=semester_course.ID_course)INNER JOIN programme ON programme.ID_semester_course=semester_course.ID)WHERE ID_day=:id_day AND ID_hour=:id_hour AND semester_course.ID_depart=:id_depart";
											$stmt = $dbh->prepare($sql);
											$stmt->bindParam(':id_day',$j,PDO::PARAM_INT);
											$stmt->bindParam(':id_hour',$i,PDO::PARAM_INT);
											$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
											$stmt->execute();         
											while( $row = $stmt->fetch(PDO::FETCH_OBJ) ){
												$id_course=$row->ID;
												$name_course=$row->name;
								$output .= '
											<div class="form-group">
												<input type="checkbox" form="'.$i.''.$j.'" id="'.$id_course.'" name="delete_course[]" value="'.$id_course.'"><label style="color:red;" for="'.$id_course.'">&nbsp '.$name_course.'</label><br>
											</div>';
										}
								$output .= '</div>
								<div class="modal-footer">
									<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
									<button type="submit" name="Submit" form="'.$i.''.$j.'" class="btn btn-danger">Ναι</button>
								</div>
								</form>
							</div>
						</div>
					</div>';
								}else{
									$output .= '<td id="'.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"><a href="add_edit.php?ID='.$i.'.'.$j.'"><button class="btn btn-default"><i class="fas fa-plus-circle"></i></button></a></td>';
								}
				}	
				$output .= '</tr>';			
	}
						$output .= '	</tbody>
							</div>
                        </table>';            
	   echo $output;  						
?>	                        