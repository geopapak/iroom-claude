<?php 

$modal = <<< EOF
<div class="modal fade" id="add_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Προσθήκη Μαθήματος στο Πρόγραμμα</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="add_course.php"  enctype="multipart/form-data">
      <div class="modal-body">
					<table class="table1">
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Μέρα</label></td>
							<td width="30"></td>
							<td><select name="day" required>
								<option disabled selected value="">-- Επιλέξτε Μέρα --</option>
EOF;
echo $modal; 
							$sql= "SELECT * FROM days";
							$stmt = $dbh->prepare($sql);
							$stmt-> execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ)){	
								$id=$row->ID;
								$name=$row->name;
$modal = <<< EOF
							<option value="$id">$name</option>
EOF;
echo $modal; 
							}
$modal = <<< EOF
							<!-- <td><input type="text" name="Name" placeholder="Όνομα" required /></td> -->
						</tr>						
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Ώρα</label></td>
							<td width="30"></td>
							<td><select name="hour" required>
								<option disabled selected value="">-- Επιλέξτε Ώρα --</option>
EOF;
echo $modal; 
							$sql= "SELECT * FROM hours";
							$stmt = $dbh->prepare($sql);
							$stmt-> execute();
							$row = $stmt->fetch(PDO::FETCH_OBJ);
							$start_hour=$row->start_hour;
							$end_hour=$row->end_hour;
							for($i=$start_hour; $i<$end_hour; $i++){ 
								$start_hour1=$i+1;
$modal = <<< EOF
							<option value="$i">$i.00 - $start_hour1.00</option>
EOF;
echo $modal; 
							}
$modal = <<< EOF
							<!-- <td><input type="text" name="Name" placeholder="Όνομα" required /></td> -->
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Μάθημα</label></td>
							<td width="30"></td>
							<td><select name="IDCourse" required>
								<option disabled selected value="">-- Επιλέξτε Μάθημα --</option>
EOF;
echo $modal; 
							$sql= "SELECT course.ID,course.name FROM course INNER JOIN course_depart on course.ID=course_depart.ID_course WHERE ID_departament=:id_depart order by name";
							$stmt = $dbh->prepare($sql);
							$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
							$stmt-> execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ)){
							$id=$row->ID;
							$name=$row->name;
$modal = <<< EOF
							<option value="$id">$name</option>
EOF;
echo $modal; 
							}
$modal = <<< EOF
							<!-- <td><input type="text" name="Name" placeholder="Όνομα" required /></td> -->
						</tr>				
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Αίθουσα:</label></td>
							<td width="30"></td>
EOF;
echo $modal; 
							$sql= "SELECT rooms.ID,rooms.name FROM rooms INNER JOIN room_depart on rooms.ID=room_depart.ID_room WHERE ID_departament=:id_depart order by name";
							$stmt = $dbh->prepare($sql);
							$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
							$stmt-> execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ)){
							$id=$row->ID;
							$name=$row->name;
$modal = <<< EOF
						<tr><td align='left'><input type="checkbox"  class="form-check-input" name="Room[]" value="$id"/>$name</td></tr>
EOF;
echo $modal; 
							}
$modal = <<< EOF
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Αποθήκευση χωρίς ελέγχο</label></td>
							<td width="30"></td>
							<td>											
								<input type="checkbox" id="flag" name="flag" value="1">	
							</td>
						</tr>							
					</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Όχι</button>
        <button type="submit" class="btn btn-primary">Αποθήκευση</button>
      </div>
    </div>
    </form>
  </div>
</div>		
EOF;
echo $modal; 	
?>