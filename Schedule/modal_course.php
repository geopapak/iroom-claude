<?php
$modal= <<<EOF
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <h3 id="myModalLabel">Προσθήκη Μαθήματος</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="add_favourite.php" enctype="multipart/form-data">
					<table class="table1">
							<tr>
EOF;
echo $modal;							
								$sql= "SELECT * FROM course WHERE ID NOT IN (SELECT ID_course FROM my_course WHERE ID_user=:id_user)";
								$stmt = $dbh->prepare($sql);
								$stmt->bindParam(':id_user',$_SESSION['user_id'],PDO::PARAM_STR);
								$stmt-> execute();
								$count=$stmt->rowCount();
								if($count>0){
									while($row = $stmt ->fetch(PDO::FETCH_OBJ)){
										$id=$row -> ID;
										$name=$row -> name;	
										$sql1= "SELECT semester.name as sem FROM semester_course inner join semester on semester_course.ID_semester=semester.ID WHERE semester_course.ID_course=:id_c";
										$stmt1 = $dbh->prepare($sql1);
										$stmt1->bindParam(':id_c',$id,PDO::PARAM_STR);
										$stmt1-> execute();
										while ($row1 = $stmt1 ->fetch(PDO::FETCH_OBJ)){	
											$sem=$row1->sem;
										}
$modal= <<<EOF
							<td><input type="checkbox" name="MyCourse[]" value="$id" /> &nbsp $name &nbsp ($sem)</td></tr>
EOF;
echo $modal;
									}
								}else{
$modal= <<<EOF
							<td>Δεν υπάρχουν μαθήματα για να διαλεξετε...</td>
EOF;
echo $modal;						
								}
$modal= <<<EOF
						</tr>
					</table>
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
<button type="submit" name="Submit" class="btn btn-primary">Προσθήκη</button>
    </div>
	
					</form>
    </div>
EOF;
echo $modal; 	
?>	